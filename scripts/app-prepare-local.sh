#!/usr/bin/env bash

######
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
. "${SCRIPT_DIR}/includes/vars.sh"
. "${SCRIPT_DIR}/includes/fnc.sh"
######

cd_root

echo "Prepare Laravel Telescope"
$PHP artisan telescope:install
$PHP artisan migrate

echo "Prepare IDE Helper"
$PHP artisan ide-helper:generate
$PHP artisan ide-helper:models
$PHP artisan ide-helper:meta

cd_back
