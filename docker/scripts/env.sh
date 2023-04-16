#!/usr/bin/env bash

set -euo pipefail

echo "Copying example envs..."

cp ./../.env.example ./../.env

cp ./../../src/.env.example ./../../src/env

echo 'Done!'