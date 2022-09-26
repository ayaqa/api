#!/usr/bin/env bash

######
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
SCRIPT_DIR=$(realpath "${SCRIPT_DIR}/../")

. "${SCRIPT_DIR}/includes/vars.sh"
. "${SCRIPT_DIR}/includes/fnc.sh"
######

TENANT_ARGS=$(get_tenant_id_as_param_if_set "${1}")

cd_root

$PHP artisan tenants:artisan "db:wipe --database=${DB_MIGRATION_TENANT_CONFIG_NAME}" $TENANT_ARGS
$PHP artisan tenants:artisan "migrate --path=${DB_MIGRATION_TENANT_RELATIVE_PATH} --database=${DB_MIGRATION_TENANT_CONFIG_NAME}" $TENANT_ARGS
$PHP artisan tenants:artisan "db:seed --database=${DB_MIGRATION_TENANT_CONFIG_NAME}" $TENANT_ARGS

cd_back
