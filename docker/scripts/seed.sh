#!/usr/bin/env bash

set -euo pipefail

docker exec tangent-test-app php artisan db:seed EmployeeSeeder
