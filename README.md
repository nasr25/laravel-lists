# Laravel Oracle API

A Laravel application that connects directly to Oracle Database and displays data using Blade templates.

## Features

- Direct Oracle Database connection using `yajra/laravel-oci8`
- PHP OCI8 extension for native Oracle connectivity
- Responsive Blade templates with styled data table
- **Offline Windows deployment** - All dependencies included
- Oracle Instant Client DLLs included

---

## Windows Offline Installation Guide

This repository includes all required files for offline installation on Windows.

### What's Included

| Folder | Contents |
|--------|----------|
| `vendor/` | All Composer dependencies (no internet needed) |
| `windows-setup/oracle-dlls/` | Oracle Instant Client 23.7 DLLs (except oraociei.dll*) |
| `windows-setup/php-ext/` | PHP OCI8 extension instructions |
| `windows-setup/php.ini.example` | Sample PHP configuration |
| `windows-setup/install.bat` | Installation script |

---

### Step 1: Install PHP 8.3 (Download before going offline)

1. Download PHP for Windows from: https://windows.php.net/download/
   - Choose **VS16 x64 Thread Safe** version
   - Download: `php-8.3.x-Win32-vs16-x64.zip`

2. Extract PHP to `C:\php`

3. Add PHP to System PATH:
   - Open **System Properties** → **Environment Variables**
   - Under **System Variables**, find `Path` and click **Edit**
   - Add `C:\php`
   - Click **OK**

4. Configure PHP:
   - Copy `C:\php\php.ini-development` to `C:\php\php.ini`
   - Or use `windows-setup\php.ini.example` from this repo

5. Edit `php.ini` and enable these extensions:
   ```ini
   extension_dir = "ext"
   extension=curl
   extension=fileinfo
   extension=mbstring
   extension=openssl
   extension=zip
   extension=oci8
   ```

### Step 2: Install PHP OCI8 Extension (Download before going offline)

1. Download from: https://windows.php.net/downloads/pecl/releases/oci8/3.4.1/
   - For PHP 8.3: `php_oci8-3.4.1-8.3-ts-vs16-x64.zip`

2. Extract and copy `php_oci8.dll` to `C:\php\ext\`

### Step 3: Install Oracle Instant Client (MOSTLY INCLUDED)

Most Oracle Instant Client DLLs are included in this repository!

**IMPORTANT**: Download `oraociei.dll` (290MB) before going offline:
1. Download from: https://www.oracle.com/database/technologies/instant-client/winx64-64-downloads.html
2. Get: `instantclient-basic-windows.x64-23.7.0.25.01.zip`
3. Extract and copy `oraociei.dll` to `windows-setup\oracle-dlls\`

1. Copy ALL files from `windows-setup\oracle-dlls\` to `C:\oracle\instantclient_23_7\`

2. Add to System PATH:
   - Open **System Properties** → **Environment Variables**
   - Edit `Path` variable
   - Add: `C:\oracle\instantclient_23_7`

3. Create environment variable:
   - Variable name: `ORACLE_HOME`
   - Variable value: `C:\oracle\instantclient_23_7`

4. Copy these DLLs to PHP folder (`C:\php`):
   - `oci.dll`
   - `oraociei.dll`

5. **Restart Command Prompt** after PATH changes

### Step 4: Verify PHP OCI8 Installation

```cmd
php -m | findstr oci8
```

You should see `oci8` in the output.

### Step 5: Configure the Application

1. Copy `.env.example` to `.env`:
   ```cmd
   copy .env.example .env
   ```

2. Edit `.env` with your Oracle database settings:
   ```env
   DB_CONNECTION=oracle
   DB_HOST=your_oracle_host
   DB_PORT=1521
   DB_DATABASE=
   DB_SERVICE_NAME=XEPDB1
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

3. Generate application key:
   ```cmd
   php artisan key:generate
   ```

4. Clear caches:
   ```cmd
   php artisan config:clear
   php artisan cache:clear
   ```

### Step 6: Run the Application

```cmd
php artisan serve
```

Open browser: http://localhost:8000

---

## Project Structure

```
laravel-oracle-api/
├── app/
│   └── Http/Controllers/
│       └── DataController.php      # Main controller
├── config/
│   └── oracle.php                  # Oracle configuration
├── resources/views/
│   ├── layouts/app.blade.php       # Main layout
│   └── data/index.blade.php        # Data display view
├── vendor/                         # All dependencies (INCLUDED)
├── windows-setup/
│   ├── oracle-dlls/                # Oracle Instant Client (INCLUDED)
│   │   ├── oci.dll
│   │   ├── oraociei.dll
│   │   └── ... (all DLLs)
│   ├── php-ext/                    # PHP extension instructions
│   ├── install.bat                 # Installation script
│   └── php.ini.example             # Sample PHP config
├── .env.example                    # Environment template
└── README.md                       # This file
```

---

## Quick Installation (Windows)

```cmd
:: 1. Copy Oracle DLLs
xcopy windows-setup\oracle-dlls\* C:\oracle\instantclient_23_7\ /E /I

:: 2. Copy required DLLs to PHP
copy C:\oracle\instantclient_23_7\oci.dll C:\php\
copy C:\oracle\instantclient_23_7\oraociei.dll C:\php\

:: 3. Configure environment
copy .env.example .env

:: 4. Generate key
php artisan key:generate

:: 5. Run
php artisan serve
```

---

## Database Setup

Create the sample table and view in Oracle:

```sql
-- Create sample table
CREATE TABLE SAMPLE_ITEMS (
    ID NUMBER PRIMARY KEY,
    NAME VARCHAR2(100),
    STATUS VARCHAR2(20)
);

-- Insert sample data
INSERT INTO SAMPLE_ITEMS VALUES (1, 'Item Alpha', 'Active');
INSERT INTO SAMPLE_ITEMS VALUES (2, 'Item Beta', 'Inactive');
INSERT INTO SAMPLE_ITEMS VALUES (3, 'Item Gamma', 'Active');
INSERT INTO SAMPLE_ITEMS VALUES (4, 'Item Delta', 'Pending');
INSERT INTO SAMPLE_ITEMS VALUES (5, 'Item Epsilon', 'Active');
COMMIT;

-- Create view
CREATE OR REPLACE VIEW YOUR_VIEW_NAME AS
SELECT NAME, STATUS FROM SAMPLE_ITEMS;
```

---

## Configuration Options

### Oracle Connection (.env)

| Variable | Description | Example |
|----------|-------------|---------|
| `DB_CONNECTION` | Database driver | `oracle` |
| `DB_HOST` | Oracle host | `192.168.1.100` |
| `DB_PORT` | Oracle port | `1521` |
| `DB_SERVICE_NAME` | Oracle service name | `XEPDB1` |
| `DB_USERNAME` | Database username | `system` |
| `DB_PASSWORD` | Database password | `your_password` |

---

## Troubleshooting

### OCI8 extension not loading

**Error**: `PHP Warning: Unable to load dynamic library 'oci8'`

**Solution**:
- Ensure Oracle Instant Client is in PATH
- Copy `oci.dll` and `oraociei.dll` to PHP folder
- Restart Command Prompt

### ORA-12541: TNS:no listener

**Solution**:
- Verify Oracle database is running
- Check `DB_HOST` and `DB_PORT`
- Check firewall settings

### ORA-12505: TNS:listener does not know of SID

**Solution**:
- Use `DB_SERVICE_NAME` instead of `DB_DATABASE`
- Verify service name with DBA

---

## Technologies

- Laravel 12.x
- PHP 8.3+
- yajra/laravel-oci8
- Oracle Database
- Blade Templates

---

## Author

Nasser

## License

MIT License
