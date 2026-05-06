#!/usr/bin/env bash
set -euo pipefail

git pull origin main
npm ci && npm run build:css
docker compose -f docker-compose.prod.yml up -d --build
docker image prune -f
