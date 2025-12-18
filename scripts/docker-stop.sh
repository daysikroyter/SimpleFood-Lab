#!/bin/bash
echo "Stopping all SimpleFood services..."
cd "$(dirname "$0")/.."
docker-compose down
echo "All services stopped."
