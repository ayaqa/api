#!/usr/bin/env bash

PROJECT_ROOT=$(realpath "${SCRIPT_DIR}/../")
PHP=$(which php)

DB_MIGRATION_MAIN_RELATIVE_PATH=database/migrations/main
DB_MIGRATION_MAIN_CONFIG_NAME=main

DB_MIGRATION_TENANT_RELATIVE_PATH=database/migrations/tenant
DB_MIGRATION_TENANT_CONFIG_NAME=tenant
