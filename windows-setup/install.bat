@echo off
echo ============================================
echo Laravel Oracle API - Windows Installation
echo ============================================
echo.

REM Check if PHP is available
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] PHP is not installed or not in PATH
    echo Please install PHP and add it to your system PATH
    pause
    exit /b 1
)

REM Check if Composer is available
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Composer is not installed or not in PATH
    echo Please install Composer from https://getcomposer.org/
    pause
    exit /b 1
)

echo [OK] PHP found
php -v
echo.

echo [OK] Composer found
composer -V
echo.

echo ============================================
echo Installing dependencies...
echo ============================================
cd ..
call composer install

if %errorlevel% neq 0 (
    echo [ERROR] Composer install failed
    pause
    exit /b 1
)

echo.
echo ============================================
echo Setting up environment...
echo ============================================

if not exist .env (
    copy .env.example .env
    echo [OK] Created .env file from .env.example
) else (
    echo [OK] .env file already exists
)

echo.
echo ============================================
echo Generating application key...
echo ============================================
call php artisan key:generate

echo.
echo ============================================
echo Clearing caches...
echo ============================================
call php artisan config:clear
call php artisan cache:clear
call php artisan route:clear
call php artisan view:clear

echo.
echo ============================================
echo Installation Complete!
echo ============================================
echo.
echo IMPORTANT: Before running the application:
echo.
echo 1. Update .env file with your Oracle database credentials:
echo    - DB_HOST=your_oracle_host
echo    - DB_PORT=1521
echo    - DB_SERVICE_NAME=your_service_name
echo    - DB_USERNAME=your_username
echo    - DB_PASSWORD=your_password
echo.
echo 2. Make sure Oracle Instant Client is installed and in PATH
echo.
echo 3. Start the server with: php artisan serve
echo.
echo ============================================
pause
