@echo off
echo Stopping all SimpleFood services...
cd /d %~dp0..
docker-compose down
echo All services stopped.
pause
