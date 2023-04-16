#!/usr/bin/env bash

set -euo pipefail

COMPOSE_FILE="../docker-compose.yml"

docker-compose --file $COMPOSE_FILE logs -f
