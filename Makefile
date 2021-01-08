####################
# Set default values
####################
SHELL 	 := /bin/bash
APP_NAME := ayaqa

RESET_COLOR=$$(tput sgr0)
GREEN_COLOR=$$(tput setaf 2)
RED_COLOR=$$(tput setaf 1)
YELLOW_COLOR=$$(tput setaf 3)
CYAN_COLOR=$$(tput setaf 6)

OK_STRING=$(GREEN_COLOR)[OK]$(RESET_COLOR)
ERROR_STRING=$(RED_COLOR)[ERROR]$(RESET_COLOR)
WARN_STRING=$(YELLOW_COLOR)[WARNING]$(RESET_COLOR)
INFO_STRING=$(CYAN_COLOR)[INFO]$(RESET_COLOR)

# Paths
ROOT_DEV_DIR=${CURDIR}
ROOT_INFRA_DIR=
ENV_FILE_PATH=${ROOT_DEV_DIR}/.env
ROOT_INFRA_MAKE_VARS_RELATIVE_PATH=vars.mk

APP_FILES_DIR=${ROOT_DEV_DIR}/infra/app/${APP_NAME}
APP_STATIC_DIR=${APP_FILES_DIR}/static
APP_BUILD_DIR=${APP_FILES_DIR}/build

DOCKER_COMPOSE_TEMPLATE=${APP_STATIC_DIR}/docker-compose.yml
DOCKER_COMPOSE_ENV_FILE=${APP_STATIC_DIR}/.env
DOCKER_COMPOSE_DYNAMIC_FILE=${APP_BUILD_DIR}/docker-compose.yml
DOCKER_COMPOSE_APP_ENV_FILE=${APP_STATIC_DIR}/app.env

# Files path
DEV_CONFIG_JSON_MAIN_FILE_PATH=${ROOT_DEV_DIR}/config.json
DEV_CONFIG_JSON_LOCAL_FILE_PATH=${ROOT_DEV_DIR}/config-local.json
DEV_CONFIG_JSON_GENERATED_FILE_PATH=${ROOT_DEV_DIR}/config-generated.json

# Literal
COMPILE_CONFIG_COMMAND_INFRA="compile_configs"

.PHONY: display_help_dev include_env check_env_vars pre_scripts pre_build generate_infra_config_files generate_docker_compose_files util_ask_to_continue clean compile_config_file

#########
# Aliases
#########
help: pre_scripts display_help_dev
pre_scripts: include_env check_env_vars
pre_build: pre_scripts generate_infra_config_files generate_docker_compose_files

display_help_dev: 
	@echo "";
	@echo -e "Usage example:\t make [TASK] [VARIABLES]";

include_env:
	@echo "${INFO_STRING} Check if local env file is there."
	@if [[ ! -f "${ENV_FILE_PATH}" ]]; then \
		echo "${ERROR_STRING} ${ENV_FILE_PATH} is not found. Please copy template and fix variables."; \
		exit 1; \
	fi;
	@echo "${OK_STRING} Variables from local .env file were included."
include ${ENV_FILE_PATH}
ROOT_INFRA_DIR=${INFRA_DIR_PATH}
include ${INFRA_DIR_PATH}/${ROOT_INFRA_MAKE_VARS_RELATIVE_PATH}

check_env_vars:
	@echo "${INFO_STRING} Check if local env file have proper variables."
	@if [ -z "${INFRA_DIR_PATH}" ]; then \
		echo "${ERROR_STRING} INFRA_DIR_PATH from ${ENV_FILE_PATH} is not found in env file."; \
		exit 1; \
	fi;
	@if [[ ! -d "${INFRA_DIR_PATH}" ]]; then \
		echo "${ERROR_STRING} INFRA_DIR_PATH from ${ENV_FILE_PATH} is not valid directory."; \
		exit 1; \
	fi;
	@echo "${OK_STRING} Local env file is fine."

check_if_app_dir_is_fine:
	@echo "${INFO_STRING} Check if app dir for ${APP_NAME} have all needed files."
	@if [[ ! -d "${APP_FILES_DIR}" ]]; then \
		echo "${ERROR_STRING} ${APP_FILES_DIR} app root dir is missing."; \
		exit 1; \
	fi;
	@if [[ ! -d "${APP_STATIC_DIR}" ]]; then \
		echo "${ERROR_STRING} ${APP_STATIC_DIR} app static dir is missing."; \
		exit 1; \
	fi;
	@if [[ ! -d "${APP_BUILD_DIR}" ]]; then \
		echo "${ERROR_STRING} ${APP_BUILD_DIR} app build dir is missing."; \
		exit 1; \
	fi;
	@if [[ ! -f "${DOCKER_COMPOSE_TEMPLATE}" ]]; then \
		echo "${ERROR_STRING} ${DOCKER_COMPOSE_TEMPLATE} docker compose template is missing."; \
		exit 1; \
	fi;
	@echo "${OK_STRING} App: ${APP_NAME} dir have all needed files/folders."

compile_dev_config_file:
	@echo "${INFO_STRING} Compile config file using static [${DEV_CONFIG_JSON_MAIN_FILE_PATH}] and local [${DEV_CONFIG_JSON_LOCAL_FILE_PATH}]."
	@echo "${WARN_STRING} If local config is found, both will be merged and all defined keys from local will override static ones."
	@if [[ -f "${DEV_CONFIG_JSON_LOCAL_FILE_PATH}" ]]; then \
		jq -s '.[0] * .[1]' ${DEV_CONFIG_JSON_MAIN_FILE_PATH} ${DEV_CONFIG_JSON_LOCAL_FILE_PATH} > ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}; \
		echo "${OK_STRING} Local config ${DEV_CONFIG_JSON_LOCAL_FILE_PATH} overrides applied."; \
	else \
		cat ${DEV_CONFIG_JSON_MAIN_FILE_PATH} > ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}; \
		echo "${INFO_STRING} Local config overrides not found."; \
	fi;
	@echo "${INFO_STRING} Going to replace vars from generated config if we have any."
	@sed -i '' -r 's~{{ROOT_DEV_DIR}}~${ROOT_DEV_DIR}~g' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}

generate_infra_config_files:
	@echo "${INFO_STRING} Ask ayaqa/infra to build configs."
	@echo "${YELLOW_COLOR}============== ayaqa/infra output start ========${RESET_COLOR}"
	@cd "${INFRA_DIR_PATH}" && make ${COMPILE_CONFIG_COMMAND_INFRA} && cd - &>/dev/null
	@echo "${YELLOW_COLOR}============== ayaqa/infra output end ========${RESET_COLOR}"

generate_docker_compose_files: check_if_app_dir_is_fine compile_dev_config_file
	@echo "${INFO_STRING} Generate docker-compose for ${APP_NAME} development"
	@if [[ -f "${DOCKER_COMPOSE_DYNAMIC_FILE}" ]]; then \
		echo "${WARN_STRING} Found generated docker-compose."; \
		echo "${WARN_STRING} Will stop all docker compose services and remove generated dynamic files."; \
		make util_ask_to_continue;  \
		make clean; \
	fi;
	@if [[ $$(jq '.APPS.${APP_NAME}.DOCKER_COMPOSE_VARS' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}) != "null" ]]; then \
		jq '.APPS.${APP_NAME}.DOCKER_COMPOSE_VARS' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" > ${DOCKER_COMPOSE_ENV_FILE}; \
		jq '.APPS.${APP_NAME}.APP_VARS' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" >> ${DOCKER_COMPOSE_ENV_FILE}; \
		echo "${OK_STRING} Docker compose .env was generated. Saved in: ${DOCKER_COMPOSE_ENV_FILE} "; \
	fi;
	@echo "Getting shared vars from ayaqa/infra: ${SHARED_VARS_FILE_PATH}"
	@if [[ $$(jq '.' ${SHARED_VARS_FILE_PATH}) != "null" ]]; then \
		jq "." ${SHARED_VARS_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" >> ${DOCKER_COMPOSE_ENV_FILE}; \
		echo "${OK_STRING} Shared vars were merged into .env: ${DOCKER_COMPOSE_ENV_FILE}"; \
		jq "." ${SHARED_VARS_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" >> ${DOCKER_COMPOSE_APP_ENV_FILE}; \
		echo "${OK_STRING} Shared vars were merged into project.env: ${DOCKER_COMPOSE_APP_ENV_FILE}"; \
	fi;
	@echo "Generate docker-compose.yml based on all dynamic vars."
	@docker-compose -f ${DOCKER_COMPOSE_TEMPLATE} --env-file ${DOCKER_COMPOSE_ENV_FILE} config > ${DOCKER_COMPOSE_DYNAMIC_FILE}
	@echo "${OK_STRING} ${DOCKER_COMPOSE_DYNAMIC_FILE} was generated."

clean:
	@echo "${INFO_STRING} Removing everything dynamic generated for: ${APP_NAME}"
	@if [[ -f "${DOCKER_COMPOSE_DYNAMIC_FILE}" ]]; then \
		echo "${YELLOW_COLOR}============== docer-compose output start ========${RESET_COLOR}"; \
		docker-compose -f ${DOCKER_COMPOSE_DYNAMIC_FILE} down; \
		echo "${YELLOW_COLOR}============== docer-compose output end ========${RESET_COLOR}"; \
	fi;
	@echo "${INFO_STRING} Remove dynamic docker-compose.yml. [${DOCKER_COMPOSE_DYNAMIC_FILE}]"
	@rm -f ${DOCKER_COMPOSE_DYNAMIC_FILE}
	@echo "${INFO_STRING} Remove dynamic .env file. [${DOCKER_COMPOSE_ENV_FILE}]"
	@rm -f ${DOCKER_COMPOSE_ENV_FILE}
	@echo "${INFO_STRING} Remove dynamic app.env file. [${DOCKER_COMPOSE_APP_ENV_FILE}]"
	@rm -f ${DOCKER_COMPOSE_APP_ENV_FILE}
	@echo "${OK_STRING} Everything dynamic for ${APP_NAME} were cleared."

util_ask_to_continue:
	@echo -n "Continue? [y/N] " && read ans && [ $${ans:-N} = y ]