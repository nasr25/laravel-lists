# Laravel Oracle API

A Laravel application that connects directly to Oracle Database and displays data using Blade templates.

## Features

- Direct Oracle Database connection using `yajra/laravel-oci8`
- PHP OCI8 extension for native Oracle connectivity
- Responsive Blade templates with styled data table
- Easy Windows deployment

---

## Windows Installation Guide

### Prerequisites

Before installing this application on Windows, you need to install the following:

### Step 1: Install PHP 8.2 or higher

1. Download PHP for Windows from: https://windows.php.net/download/
   - Choose **VS16 x64 Thread Safe** version (recommended)
   - Download the ZIP file

2. Extract PHP to `C:\php` (or your preferred location)

3. Add PHP to System PATH:
   - Open **System Properties** → **Environment Variables**
   - Under **System Variables**, find `Path` and click **Edit**
   - Add `C:\php` (or your PHP installation path)
   - Click **OK** to save

4. Verify installation:
   ```cmd
   php -v
   ```

### Step 2: Install Composer

1. Download Composer from: https://getcomposer.org/download/
2. Run the installer (`Composer-Setup.exe`)
3. Follow the installation wizard
4. Verify installation:
   ```cmd
   composer -V
   ```

### Step 3: Install Oracle Instant Client

1. Download Oracle Instant Client from:
   https://www.oracle.com/database/technologies/instant-client/winx64-64-downloads.html

2. Download these packages:
   - **Basic Package** (instantclient-basic-windows.x64-XX.X.X.X.X.zip)
   - **SDK Package** (instantclient-sdk-windows.x64-XX.X.X.X.X.zip)

3. Extract both packages to `C:\oracle\instantclient_23_7` (or similar)

4. Add Oracle Instant Client to System PATH:
   - Open **System Properties** → **Environment Variables**
   - Under **System Variables**, find `Path` and click **Edit**
   - Add `C:\oracle\instantclient_23_7`
   - Click **OK** to save

5. Create environment variable `ORACLE_HOME`:
   - Under **System Variables**, click **New**
   - Variable name: `ORACLE_HOME`
   - Variable value: `C:\oracle\instantclient_23_7`

6. **IMPORTANT**: Copy these DLL files from Oracle Instant Client to your PHP folder (`C:\php`):
   - `oci.dll`
   - `oraociei23.dll` (or similar version)
   - `orannzsbb23.dll`
   - `oraons.dll`

### Step 4: Configure PHP for Oracle

1. Navigate to your PHP installation folder (`C:\php`)

2. Copy `php.ini-development` to `php.ini`

3. Edit `php.ini` and enable/add these extensions:
   ```ini
   extension=curl
   extension=fileinfo
   extension=mbstring
   extension=openssl
   extension=pdo_mysql
   extension=zip
   extension=oci8_19
   ```

4. Set the extension directory (uncomment and update):
   ```ini
   extension_dir = "ext"
   ```

5. You can also use the sample `php.ini.example` from `windows-setup` folder

6. Verify OCI8 is loaded:
   ```cmd
   php -m | findstr oci8
   ```
   You should see `oci8` in the output.

### Step 5: Install the Laravel Application

1. Clone or download this repository

2. Open Command Prompt and navigate to the project folder:
   ```cmd
   cd C:\path\to\laravel-oracle-api
   ```

3. Run the installation script:
   ```cmd
   windows-setup\install.bat
   ```

   Or manually install:
   ```cmd
   composer install
   copy .env.example .env
   php artisan key:generate
   ```

### Step 6: Configure Database Connection

1. Open `.env` file in the project root

2. Update the Oracle database settings:
   ```env
   DB_CONNECTION=oracle
   DB_HOST=your_oracle_host
   DB_PORT=1521
   DB_DATABASE=
   DB_SERVICE_NAME=XEPDB1
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

3. Clear configuration cache:
   ```cmd
   php artisan config:clear
   ```

### Step 7: Run the Application

1. Start the Laravel development server:
   ```cmd
   php artisan serve
   ```

2. Open your browser and navigate to:
   ```
   http://localhost:8000
   ```

---

## Project Structure

```
laravel-oracle-api/
├── app/
│   └── Http/
│       └── Controllers/
│           └── DataController.php    # Main controller
├── config/
│   └── oracle.php                    # Oracle configuration
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php         # Main layout
│       └── data/
│           └── index.blade.php       # Data display view
├── routes/
│   └── web.php                       # Web routes
├── windows-setup/
│   ├── install.bat                   # Windows installation script
│   └── php.ini.example               # Sample PHP configuration
├── .env.example                      # Environment template
└── README.md                         # This file
```

---

## Configuration Options

### Oracle Connection (.env)

| Variable | Description | Example |
|----------|-------------|---------|
| `DB_CONNECTION` | Database driver | `oracle` |
| `DB_HOST` | Oracle host | `localhost` |
| `DB_PORT` | Oracle port | `1521` |
| `DB_SERVICE_NAME` | Oracle service name | `XEPDB1` |
| `DB_USERNAME` | Database username | `system` |
| `DB_PASSWORD` | Database password | `your_password` |

---

## Troubleshooting

### Common Issues

#### 1. OCI8 extension not loading

**Error**: `PHP Warning: PHP Startup: Unable to load dynamic library 'oci8_19'`

**Solution**:
- Ensure Oracle Instant Client is in PATH
- Copy required DLL files to PHP folder
- Restart Command Prompt after PATH changes

#### 2. ORA-12541: TNS:no listener

**Error**: Cannot connect to Oracle database

**Solution**:
- Verify Oracle database is running
- Check `DB_HOST` and `DB_PORT` in `.env`
- Ensure firewall allows connection on port 1521

#### 3. ORA-12505: TNS:listener does not currently know of SID

**Error**: SID not found

**Solution**:
- Use `DB_SERVICE_NAME` instead of `DB_DATABASE`
- Verify the service name with your DBA

#### 4. Composer install fails

**Solution**:
- Run `composer clear-cache`
- Delete `vendor` folder and `composer.lock`
- Run `composer install` again

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

## Technologies Used

- **Laravel 12.x** - PHP Framework
- **PHP 8.2+** - Server-side language
- **yajra/laravel-oci8** - Oracle database driver for Laravel
- **Oracle Database** - Database system
- **Blade** - Laravel's templating engine

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## Author

Nasser
