#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
source "${DIR}/doc.sh"
source "${DIR}/common.sh"

testing() {
  composer tests_run
}

case "$1" in
  "fxt")
    apFixtures;;
  "run")
    testing;;
  *)
    doc;;
esac