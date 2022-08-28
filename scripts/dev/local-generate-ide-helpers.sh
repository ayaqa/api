#!/usr/bin/env bash

######
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
SCRIPT_DIR=$(realpath "${SCRIPT_DIR}/../")

. "${SCRIPT_DIR}/includes/vars.sh"
. "${SCRIPT_DIR}/includes/fnc.sh"
######

TENANT_ARGS=$(get_tenant_id_as_param_if_set "${1}")

cd_root

$PHP artisan ide-helper:generate
$PHP artisan ide-helper:meta
$PHP artisan ide-helper:models Core -n
$PHP artisan tenants:artisan "ide-helper:models Toggle -n" $TENANT_ARGS
$PHP artisan tenants:artisan "ide-helper:models Checkbox -n" $TENANT_ARGS
$PHP artisan tenants:artisan "ide-helper:models Bug -n" $TENANT_ARGS

cd_back
