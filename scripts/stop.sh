#!/bin/bash

docker stop $(docker ps -f "name=ptcd" -a -q)