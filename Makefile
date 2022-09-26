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

# Current OS is needed for one of sed replacement to work properly on mac & linux.
ifeq ($(OS),Windows_NT)
    DETECTED_OS := Windows
else
    DETECTED_OS := $(shell uname)
endif

OK_STRING=$(GREEN_COLOR)[OK]$(RESET_COLOR)
ERROR_STRING=$(RED_COLOR)[ERROR]$(RESET_COLOR)
WARN_STRING=$(YELLOW_COLOR)[WARNING]$(RESET_COLOR)
INFO_STRING=$(CYAN_COLOR)[INFO]$(RESET_COLOR)

APP_FORMATTED_FOR_PRINT=$(RED_COLOR)[$(GREEN_COLOR)${APP_NAME}$(RED_COLOR)]$(RESET_COLOR)

# paths
ROOT_DEV_DIR=${CURDIR}
INFRA_APP_DIR=${ROOT_DEV_DIR}/.infra
ENV_FILE_NAME=.make-env
ENV_FILE_TEMPLATE_NAME=.make-env.dist
ENV_FILE_PATH=${ROOT_DEV_DIR}/${ENV_FILE_NAME}
ENV_FILE_TEMPLATE_PATH=${ROOT_DEV_DIR}/${ENV_FILE_TEMPLATE_NAME}

AYAQA_INFRA_VARS_FILE_NAME=make.mk
AYAQA_INFRA_RELATIVE_TO_ROOT_PATH_VAR_FILE=files/vars/${AYAQA_INFRA_VARS_FILE_NAME}

APP_FILES_DIR=${INFRA_APP_DIR}/app/${APP_NAME}
APP_STATIC_DIR=${APP_FILES_DIR}/static
APP_DOCKER_TEMPLATE_DIR=${APP_STATIC_DIR}/template
APP_BUILD_DIR=${APP_FILES_DIR}/build

# docker-compose file paths
DOCKER_COMPOSE_TEMPLATE_FILE_NAME=docker-compose.yml
DOCKER_COMPOSE_TEMPLATE_FILE_PATH=${APP_DOCKER_TEMPLATE_DIR}/${DOCKER_COMPOSE_TEMPLATE_FILE_NAME}

DOCKER_COMPOSE_ENV_FILE_NAME=.env
DOCKER_COMPOSE_ENV_FILE_PATH=${APP_DOCKER_TEMPLATE_DIR}/${DOCKER_COMPOSE_ENV_FILE_NAME}

DOCKER_COMPOSE_DYNAMIC_FILE_NAME=docker-compose.yml
DOCKER_COMPOSE_DYNAMIC_FILE_PATH=${APP_BUILD_DIR}/${DOCKER_COMPOSE_DYNAMIC_FILE_NAME}

DOCKER_COMPOSE_APP_ENV_FILE_NAME=app.env
DOCKER_COMPOSE_APP_ENV_FILE_PATH=${APP_DOCKER_TEMPLATE_DIR}/${DOCKER_COMPOSE_APP_ENV_FILE_NAME}

# configs paths
DEV_CONFIG_JSON_MAIN_FILE_NAME=infra-config.json
DEV_CONFIG_JSON_MAIN_FILE_PATH=${INFRA_APP_DIR}/${DEV_CONFIG_JSON_MAIN_FILE_NAME}

DEV_CONFIG_JSON_LOCAL_FILE_NAME=infra-config-local.json
DEV_CONFIG_JSON_LOCAL_FILE_PATH=${ROOT_DEV_DIR}/${DEV_CONFIG_JSON_LOCAL_FILE_NAME}

DEV_CONFIG_JSON_GENERATED_FILE_NAME=infra-config-generated.json
DEV_CONFIG_JSON_GENERATED_FILE_PATH=${ROOT_DEV_DIR}/${DEV_CONFIG_JSON_GENERATED_FILE_NAME}

# Others
COMPILE_CONFIG_COMMAND_INFRA="compile_configs"

# Dynamic (populated during running command)
ROOT_INFRA_DIR=
DOCKER_VOLUME_DIR=

.PHONY: help pre_build build clean up down ps status logs generate_infra_config_files generate_docker_compose_files docker_compose

#########
# Aliases
#########
help: .display_help_dev
pre_build: .include_env .validate_env_vars_from_file
build: pre_build generate_infra_config_files generate_docker_compose_files
clean: .clean
up: .docker_up
stop: .docker_stop
down: .docker_down
ps: .docker_status
status: .docker_status
logs: .docker_logs
bash: .docker_bash

.util_ask_to_continue:
	@echo -n "Continue? [y/N] " && read ans && if [[ $${ans:-N} =~ ^[Nn] ]]; then \
		echo "${ERROR_STRING} Abort.."; \
		exit 1; \
	fi;

.display_help_dev:
	@echo "";
	@echo -e "Usage example:\t make [TASK] [VARIABLES]";
	@echo -e "===================================================================================="
	@echo -e "\t\t make build APP_NAME=<app name> \t\t\t Build everything for dev env.";
	@echo -e "\t\t make clean APP_NAME=<app name> \t\t\t Clear everything dynamic.";
	@echo -e "\t\t make up APP_NAME=<app name> \t\t\t\t Start docker-compose (with up -d)";
	@echo -e "\t\t make down APP_NAME=<app name> \t\t\t\t Stop docker-compose";
	@echo -e "\t\t make ps APP_NAME=<app name> \t\t\t\t Print docker-compose status";
	@echo -e "\t\t make status APP_NAME=<app name> \t\t\t Print docker-compose status";
	@echo -e "\t\t make logs APP_NAME=<app name> \t\t\t\t Tail docker-compose logs";
	@echo -e "\t\t make bash APP_NAME=<app name> \t\t\t\t Attach to bash session";
	@echo -e "===================================================================================="
	@echo -e "${INFO_STRING} Default APP_NAME: $(GREEN_COLOR)${APP_NAME}$(RESET_COLOR)"

.include_env:
	@echo "${INFO_STRING} Check if ${ENV_FILE_NAME} file exists."
	@if [[ ! -f "${ENV_FILE_PATH}" ]]; then \
		echo "${ERROR_STRING} ${ENV_FILE_PATH} is not found."; \
		echo "${INFO_STRING} Copy template ${ENV_FILE_TEMPLATE_NAME} and fill variables. Check README.md for more info."; \
		exit 1; \
	fi;
	@echo "${OK_STRING} Variables from ${ENV_FILE_NAME} file were included."
include ${ENV_FILE_PATH}
ROOT_INFRA_DIR=`realpath -s ${INFRA_DIR_PATH}`
DOCKER_VOLUME_DIR=`realpath -s ${DOCKER_VOLUME_PATH}`
include ${INFRA_DIR_PATH}/${AYAQA_INFRA_RELATIVE_TO_ROOT_PATH_VAR_FILE}

.validate_env_vars_from_file:
	@echo "${INFO_STRING} Check if ${ENV_FILE_NAME} file have all required vars."
	@if [ -z "${INFRA_DIR_PATH}" ]; then \
		echo "${ERROR_STRING} INFRA_DIR_PATH from [${ENV_FILE_NAME}] was not found."; \
		exit 1; \
	fi;
	@if [[ ! -d "${INFRA_DIR_PATH}" ]]; then \
		echo "${ERROR_STRING} INFRA_DIR_PATH from [${ENV_FILE_NAME}] is not a directory."; \
		exit 1; \
	fi;
	@if [ -z "${DOCKER_VOLUME_PATH}" ]; then \
		echo "${ERROR_STRING} DOCKER_VOLUME_PATH from [${ENV_FILE_NAME}] was not found."; \
		exit 1; \
	fi;
	@if [[ ! -d "${DOCKER_VOLUME_PATH}" ]]; then \
		echo "${ERROR_STRING} DOCKER_VOLUME_PATH from [${ENV_FILE_NAME}] is not a directory."; \
		exit 1; \
	fi;

	@echo "${INFO_STRING} ROOT_INFRA_DIR ${ROOT_INFRA_DIR}."
	@echo "${INFO_STRING} DOCKER_VOLUME_DIR ${DOCKER_VOLUME_DIR}."

	@echo "${OK_STRING} Local ${ENV_FILE_NAME} file is fine."

.check_if_app_dir_is_fine:
	@echo "${INFO_STRING} Check if app dir for ${APP_FORMATTED_FOR_PRINT} have all required files/folders."
	@if [[ ! -d "${APP_FILES_DIR}" ]]; then \
		echo "${ERROR_STRING} App root dir was not found at ${APP_FILES_DIR}"; \
		exit 1; \
	fi;
	@if [[ ! -d "${APP_STATIC_DIR}" ]]; then \
		echo "${ERROR_STRING} App static dir was not found at ${APP_STATIC_DIR}"; \
		exit 1; \
	fi;
	@if [[ ! -d "${APP_BUILD_DIR}" ]]; then \
		echo "${ERROR_STRING} App build dir was not found at ${APP_BUILD_DIR}"; \
		exit 1; \
	fi;
	@if [[ ! -f "${DOCKER_COMPOSE_TEMPLATE_FILE_PATH}" ]]; then \
		echo "${ERROR_STRING} docker-compose template is missing at ${DOCKER_COMPOSE_TEMPLATE_FILE_PATH}"; \
		exit 1; \
	fi;
	@echo "${OK_STRING} App: ${APP_FORMATTED_FOR_PRINT} dir have all required files/folders."

.compile_dev_config_file:
	@echo "${INFO_STRING} Compile dynamic config using ${DEV_CONFIG_JSON_LOCAL_FILE_NAME}"
	@if [[ -f "${DEV_CONFIG_JSON_LOCAL_FILE_PATH}" ]]; then \
		echo "${WARN_STRING} Local config ${DEV_CONFIG_JSON_LOCAL_FILE_NAME} found. Both will be merged."; \
		jq -s '.[0] * .[1]' ${DEV_CONFIG_JSON_MAIN_FILE_PATH} ${DEV_CONFIG_JSON_LOCAL_FILE_PATH} > ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}; \
		echo "${OK_STRING} Local config ${DEV_CONFIG_JSON_LOCAL_FILE_NAME} overrides applied."; \
	else \
		cat ${DEV_CONFIG_JSON_MAIN_FILE_PATH} > ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}; \
		echo "${INFO_STRING} Local config overrides not found."; \
	fi;
	@echo "${INFO_STRING} Replace vars within ${DEV_CONFIG_JSON_GENERATED_FILE_NAME}. [OS: ${DETECTED_OS}]"
	@if [[ ${DETECTED_OS} == 'Darwin' ]]; then \
		sed -i '' "s|{{ROOT_DEV_DIR}}|$(ROOT_DEV_DIR)|g" ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}; \
		sed -i '' "s|{{DOCKER_VOLUME_DIR}}|$(DOCKER_VOLUME_DIR)|g" ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}; \
	else \
		sed -i "s|{{ROOT_DEV_DIR}}|$(ROOT_DEV_DIR)|g" ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}; \
		sed -i "s|{{DOCKER_VOLUME_DIR}}|$(DOCKER_VOLUME_DIR)|g" ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}; \
	fi;

generate_infra_config_files:
	@echo "${INFO_STRING} Call ayaqa/infra to build dynamic configs."
	@echo "${YELLOW_COLOR}============== ayaqa/infra output start ========${RESET_COLOR}"
	@cd "${INFRA_DIR_PATH}" && make -s ${COMPILE_CONFIG_COMMAND_INFRA} && cd - &>/dev/null
	@echo "${YELLOW_COLOR}============== ayaqa/infra output end ========${RESET_COLOR}"

generate_docker_compose_files: .check_if_app_dir_is_fine .compile_dev_config_file
	@echo "${INFO_STRING} Generate [${DOCKER_COMPOSE_DYNAMIC_FILE_NAME}] for ${APP_FORMATTED_FOR_PRINT} development env."
	@if [[ -f "${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}" ]]; then \
		echo "${WARN_STRING} Found generated ${DOCKER_COMPOSE_DYNAMIC_FILE_NAME} at ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}"; \
		echo "${WARN_STRING} Will smtop all docker compose services and remove generated dynamic files."; \
		make -s .util_ask_to_continue || exit 1;  \
		make -s clean; \
		make -s .compile_dev_config_file; \
	fi;
	@if [[ $$(jq '.APPS.${APP_NAME}.DOCKER_COMPOSE_VARS' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}) != "null" ]]; then \
		jq '.APPS.${APP_NAME}.DOCKER_COMPOSE_VARS' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" > ${DOCKER_COMPOSE_ENV_FILE_PATH}; \
		jq '.APPS.${APP_NAME}.APP_VARS' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" >> ${DOCKER_COMPOSE_ENV_FILE_PATH}; \
		echo "${OK_STRING} Docker compose ${DOCKER_COMPOSE_ENV_FILE_NAME} was generated. Saved in: ${DOCKER_COMPOSE_ENV_FILE_PATH} "; \
	fi;
	@echo "${INFO_STRING} Getting shared vars from ayaqa/infra: ${SHARED_VARS_FILE_NAME}"
	@if [[ $$(jq '.' ${SHARED_VARS_FILE_PATH}) != "null" ]]; then \
		jq "." ${SHARED_VARS_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" >> ${DOCKER_COMPOSE_ENV_FILE_PATH}; \
		echo "${OK_STRING} Shared vars were merged into .env: ${DOCKER_COMPOSE_ENV_FILE_PATH}"; \
		jq "." ${SHARED_VARS_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" >> ${DOCKER_COMPOSE_APP_ENV_FILE_PATH}; \
		echo "${OK_STRING} Shared vars were added into ${DOCKER_COMPOSE_APP_ENV_FILE_NAME} at ${DOCKER_COMPOSE_APP_ENV_FILE_PATH}"; \
	fi;
	@echo "${INFO_STRING} Getting constants from ayaqa/infra: ${CONSTANTS_FILE_NAME}"
	@if [[ $$(jq '.' ${CONSTANTS_FILE_PATH}) != "null" ]]; then \
		jq "." ${CONSTANTS_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" >> ${DOCKER_COMPOSE_ENV_FILE_PATH}; \
		echo "${OK_STRING} Shared vars were merged into .env: ${DOCKER_COMPOSE_ENV_FILE_PATH}"; \
		jq "." ${CONSTANTS_FILE_PATH} | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" >> ${DOCKER_COMPOSE_APP_ENV_FILE_PATH}; \
		echo "${OK_STRING} Constants were added into ${DOCKER_COMPOSE_APP_ENV_FILE_NAME} at ${DOCKER_COMPOSE_APP_ENV_FILE_PATH}"; \
	fi;
	@echo "${INFO_STRING} Generate ${DOCKER_COMPOSE_TEMPLATE_FILE_NAME} by using dynamic vars."
	@docker-compose -f ${DOCKER_COMPOSE_TEMPLATE_FILE_PATH} --env-file ${DOCKER_COMPOSE_ENV_FILE_PATH} config > ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}
	@echo "${OK_STRING} ${DOCKER_COMPOSE_DYNAMIC_FILE_NAME} was generated at ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}"
	@cp ${DOCKER_COMPOSE_APP_ENV_FILE_PATH} ${APP_BUILD_DIR}
	@echo "${OK_STRING} ${DOCKER_COMPOSE_APP_ENV_FILE_PATH} was copied to ${APP_BUILD_DIR}"

.clean:
	@echo "${INFO_STRING} Removing everything dynamic generated for ${APP_FORMATTED_FOR_PRINT}"
	@if [[ -f "${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}" ]]; then \
		echo "${YELLOW_COLOR}============== docker-compose output start ========${RESET_COLOR}"; \
		docker-compose -f ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH} down; \
		echo "${YELLOW_COLOR}============== docker-compose output end ========${RESET_COLOR}"; \
	fi;
	@echo "${INFO_STRING} Remove dynamic ${DOCKER_COMPOSE_DYNAMIC_FILE_NAME} at ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}"
	@rm -f ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}
	@echo "${INFO_STRING} Remove dynamic ${DOCKER_COMPOSE_APP_ENV_FILE_NAME} at ${APP_BUILD_DIR}"
	@rm -f ${APP_BUILD_DIR}/${DOCKER_COMPOSE_APP_ENV_FILE_NAME}
	@echo "${INFO_STRING} Remove dynamic ${DOCKER_COMPOSE_ENV_FILE_NAME} file at ${DOCKER_COMPOSE_ENV_FILE_PATH}"
	@rm -f ${DOCKER_COMPOSE_ENV_FILE_PATH}
	@echo "${INFO_STRING} Remove dynamic ${DOCKER_COMPOSE_APP_ENV_FILE_NAME} file at ${DOCKER_COMPOSE_APP_ENV_FILE_PATH}"
	@rm -f ${DOCKER_COMPOSE_APP_ENV_FILE_PATH}
	@echo "${INFO_STRING} Remove docker-compose app volume"
	@docker volume rm -f $(shell jq '.APPS.${APP_NAME}.DOCKER_COMPOSE_VARS.AYAQA_DATA_NAME' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH})
	@echo "${INFO_STRING} Remove docker-compose data persist volume"
	@docker volume rm -f $(shell jq '.APPS.${APP_NAME}.DOCKER_COMPOSE_VARS.AYAQA_VOLUME_NAME' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH})

	@echo "${INFO_STRING} Remove dynamic ${DEV_CONFIG_JSON_GENERATED_FILE_NAME} file at ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}"
	@rm -f ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}

	@echo "${OK_STRING} Everything dynamic for ${APP_FORMATTED_FOR_PRINT} were cleared."


# Docker compose targets
.check_if_docker_compose_is_generated:
	@if [[ ! -f "${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}" ]]; then \
		echo "${ERROR_STRING} ${DOCKER_COMPOSE_DYNAMIC_FILE_NAME} is not found for ${APP_FORMATTED_FOR_PRINT} at ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}"; \
		exit 1; \
	fi

.docker_up: .check_if_docker_compose_is_generated
	@echo "${INFO_STRING} Executing docker-compose up -d for ${APP_FORMATTED_FOR_PRINT}"
	@echo "${YELLOW_COLOR}============== docker-compose output start ========${RESET_COLOR}"; \
		docker-compose -f ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH} up -d; \
		echo "${YELLOW_COLOR}============== docker-compose output end ========${RESET_COLOR}";

.docker_down: .check_if_docker_compose_is_generated
	@echo "${INFO_STRING} Executing docker-compose down for ${APP_FORMATTED_FOR_PRINT}"
	@echo "${YELLOW_COLOR}============== docker-compose output start ========${RESET_COLOR}"; \
		docker-compose -f ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH} down; \
		echo "${YELLOW_COLOR}============== docker-compose output end ========${RESET_COLOR}";

.docker_stop: .check_if_docker_compose_is_generated
	@echo "${INFO_STRING} Executing docker-compose stop for ${APP_FORMATTED_FOR_PRINT}"
	@echo "${YELLOW_COLOR}============== docker-compose output start ========${RESET_COLOR}"; \
		docker-compose -f ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH} stop; \
		echo "${YELLOW_COLOR}============== docker-compose output end ========${RESET_COLOR}";

.docker_status: .check_if_docker_compose_is_generated
	@echo "${INFO_STRING} Executing docker-compose ps for ${APP_FORMATTED_FOR_PRINT}"
	@echo "${YELLOW_COLOR}============== docker-compose output start ========${RESET_COLOR}"; \
		docker-compose -f ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH} ps; \
		echo "${YELLOW_COLOR}============== docker-compose output end ========${RESET_COLOR}";

.docker_logs: .check_if_docker_compose_is_generated
	@echo "${INFO_STRING} docker-compose logs for ${APP_FORMATTED_FOR_PRINT}"
	@docker-compose -f ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH} logs --tail=100 -f

.docker_bash: .check_if_docker_compose_is_generated
	@echo "${INFO_STRING} docker-compose bash for ${APP_FORMATTED_FOR_PRINT}"
	@docker exec -it $(shell jq '.APPS.${APP_NAME}.DOCKER_COMPOSE_VARS.AYAQA_APP_NAME' ${DEV_CONFIG_JSON_GENERATED_FILE_PATH}) /bin/bash

docker_compose: .check_if_docker_compose_is_generated
	@echo "${INFO_STRING} Command below can be used to run docker-compose commands for ${APP_FORMATTED_FOR_PRINT}"
	@echo "docker-compose -f ${DOCKER_COMPOSE_DYNAMIC_FILE_PATH}"
