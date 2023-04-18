#!/usr/bin/env bash

set -euo pipefail

docker exec tangent-test-app php artisan migrate:fresh --seed && \
docker exec tangent-test-app php artisan test
