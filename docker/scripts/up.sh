#!/usr/bin/env bash

set -euo pipefail

COMPOSE_FILE="../docker-compose.yml"

docker-compose --file $COMPOSE_FILE up --build --detach && \
docker exec tangent-test-app composer install && \
docker exec tangent-test-app npm install && \
docker exec tangent-test-app npm run build

echo ""
echo "Should be ready to rock and roll!"
echo ""
echo "!!! Remember to add tangenttest.local to your hosts file !!!"
echo "Thereafter, you can access the site via your browser at http://tangenttest.local"
echo ""
