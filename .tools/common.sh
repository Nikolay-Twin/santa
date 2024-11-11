#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
export $(grep -v '#' "$DIR/../.env" | xargs)

log() {
    RED='\e[31m'
    GREEN='\e[32m'
    YELLOW='\e[33m'
    BLUE='\e[34m'

    case $2 in
        wait)
            printf "${BLUE}${1}\e[0m\n"
        ;;
        progress)
            printf "${GREEN}${1}\e[0m\n"
        ;;
        info)
            printf "${YELLOW}${1}\e[0m\n"
        ;;
        error)
            printf "${RED}${1}\e[0m\n"
        ;;
        *)
            printf "${1}"
        ;;
    esac
}


php() {
  docker-compose exec php ${@:1}
  log "DONE!" "info"
}

exec() {
  docker exec -it "${CONTAINER_PREFIX}_${CONTAINER_NAME}_php" ${@:1}
  log "DONE!" "info"
}

console() {
  docker exec -it "${CONTAINER_PREFIX}_${CONTAINER_NAME}_php" ./bin/console ${@:1}
  log "DONE!" "info"
}

composer() {
  exec composer ${@:1}
  log "DONE!" "info"
}

sniffer() {
  exec sh -c vendor/bin/phpcs
  log "Code review completed" "wait"
  printf "\e[0m\n"
  printf "\e[0m\n"
}

fix() {
  exec sh -c vendor/bin/phpcbf --standard=PSR12
  log "Code fix completed" "wait"
  printf "\e[0m\n"
  printf "\e[0m\n"
}
