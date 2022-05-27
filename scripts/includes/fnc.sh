#!/usr/bin/env bash

cd_root() {
    echo "Working dir: ${PROJECT_ROOT}"
    cd "$PROJECT_ROOT"
}

cd_back() {
    cd - > /dev/null
}

exit_with_msg_if_not_set() {
    if [[ -z "$1" ]]; then
        echo "$2"
        exit 1;
    fi
}

get_tenant_id_as_param_if_set() {
    if [[ -n "$1" ]]; then
        echo "--tenant=${1}"
    fi
}
