@echo off
echo Starting BizNet Application with Docker...
echo.

REM Start all Docker services
echo Starting Docker services...
docker-compose up -d

REM Wait for services to be ready
echo Waiting for services to start...
timeout /t 10 /nobreak > nul

REM Check if Ollama model exists
echo Checking for AI model...
docker exec biznet-ollama-1 ollama list | findstr "gemma3:1b" > nul
if errorlevel 1 (
    echo Model not found. Pulling gemma3:1b...
    docker exec biznet-ollama-1 ollama pull gemma3:1b
) else (
    echo Model gemma3:1b already exists.
)

echo.
echo ========================================
echo Services are ready!
echo ========================================
echo AI Chat: http://localhost:3000
echo Barcode Generator: http://localhost:8080
echo Ollama API: http://localhost:11434
echo ========================================
echo.
echo Press any key to open AI Chat in browser...
pause > nul
start http://localhost:3000 