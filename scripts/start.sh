#!/bin/bash

# !!! Please run this file in root project folder
# This file is a shortcut for `docker-compose up`
# USAGE:
# $ script/start.sh

docker compose -p ptcd --env-file .env -f docker-compose.yml up -d