#!/bin/bash
# $ script/run.sh <service> <your command>
# EG:
# $ script/run.sh api yarn install
# $ script/run.sh schedule yarn migration:run

SERVICE=$1
shift

if [ -z "$SERVICE" ]; then
  echo "Service name is required."
  echo "Usage: $0 <service> <command>"
  exit 1
fi

docker exec -it ptcd_$SERVICE "$@"