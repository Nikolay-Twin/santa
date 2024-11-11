#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
source "${DIR}/doc.sh"
source "${DIR}/common.sh"

checkDockerCompose() {
  if ! [ -f ${DIR}/../docker-compose.yml ]; then
    log "docker-compose.yml not exist."
    exit
  fi
}

checkEnv() {
  if ! [ -f ${DIR}/../.env ]; then
    log "File .env not exist" "error"
    exit
  fi
}

init() {
  checkDockerCompose
  checkEnv
  docker-compose build
  docker-compose up -d
  composer install
  console doctrine:database:create
  migrationApple
  apFixtures
  printf "\e[0m\n"
  log "Project initialization completed!" "wait"
  printf "\e[0m\n"
}

up() {
  down
  docker-compose up -d
}

down() {
  checkDockerCompose
  docker-compose down
}

build() {
  checkDockerCompose
  docker-compose build --network=host
}

migrationCreate() {
  console make:migration
}

migrationApple() {
  console doctrine:migrations:migrate
}

apFixtures() {
  console "--env=dev doctrine:fixtures:load"
}

makeEntity() {
  console make:entity ${@:1}
  log "DONE!" "info"
}

queue() {
  console messenger:consume async --time-limit=3600
}

case "$1" in
  "init")
    init;;
  "build")
    build;;
  "up")
    up;;
  "down")
    down;;
  "queue")
    queue;;
  "mc")
    migrationCreate;;
  "ma")
    migrationApple;;
  "ent"*)
    makeEntity ${@:2};;
  "composer"*)
    composer ${@:2};;
  "cli"*)
    console ${@:2};;
  "php"*)
    php ${$:2};;
  "exec"*)
    exec ${$:2};;
  "sniffer")
    sniffer;;
  "fix")
    fix;;
  *)
    doc;;
esac
