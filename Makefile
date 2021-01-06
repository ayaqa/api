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
ENV_FILE_PATH=${ROOT_DEV_DIR}/.env

APP_FILES_DIR=${ROOT_DEV_DIR}/infra/app/${APP_NAME}
APP_STATIC_DIR=${APP_FILES_DIR}/static
APP_BUILD_DIR=${APP_FILES_DIR}/build

DOCKER_COMPOSE_TEMPLATE=${APP_STATIC_DIR}/docker-compose.yml
DOCKER_COMPOSE_ENV_FILE=${APP_STATIC_DIR}/.env
DOCKER_COMPOSE_DYNAMIC_FILE=${APP_BUILD_DIR}/docker-compose.yml
DOCKER_COMPOSE_PRJECT_ENV_FILE=${APP_BUILD_DIR}/app.env

# Literal
COMPILE_CONFIG_COMMAND_INFRA="compile_configs"

.PHONY: display_help include_env check_env_vars pre_scripts pre_build generate_infra_config_files generate_docker_compose_files util_ask_to_continue

#########
# Aliases
#########
help: pre_scripts display_help
pre_scripts: include_env check_env_vars
pre_build: pre_scripts generate_infra_config_files generate_docker_compose_files

display_help: 
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

generate_infra_config_files:
	@echo "${INFO_STRING} Ask ayaqa/infra to build configs."
	@echo "============== ayaqa/infra output start ========"
	@cd "${INFRA_DIR_PATH}" && make ${COMPILE_CONFIG_COMMAND_INFRA} && cd - &>/dev/null
	@echo "============== ayaqa/infra output end ========"

generate_docker_compose_files: check_if_app_dir_is_fine
	@echo "${INFO_STRING} Generate docker compose for ${APP_NAME} development"
	@if [[ -f "${DOCKER_COMPOSE_DYNAMIC_FILE}" ]]; then \
		echo "${WARN_STRING} Found generated docker-compose."; \
		echo "${WARN_STRING} Will stop all docker compose services and remove generated dynamic files."; \
		make util_ask_to_continue;  \
	fi;

util_ask_to_continue:
	@echo -n "Continue? [y/N] " && read ans && [ $${ans:-N} = y ]