#!/usr/bin/env bash

######
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
. "${SCRIPT_DIR}/includes/vars.sh"
. "${SCRIPT_DIR}/includes/fnc.sh"
######

cd_root

$PHP artisan migrate --path="${DB_MIGRATION_MAIN_RELATIVE_PATH}" --database="${DB_MIGRATION_MAIN_CONFIG_NAME}"

cd_back
