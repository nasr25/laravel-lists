============================================
ORACLE INSTANT CLIENT 23.7 FOR WINDOWS x64
============================================

Most DLL files are included in this folder!

IMPORTANT: One large file (oraociei.dll - 290MB) must be downloaded
separately due to GitHub's file size limit.

============================================
BEFORE GOING OFFLINE - DOWNLOAD THIS FILE:
============================================

1. Download Oracle Instant Client Basic Package from:
   https://www.oracle.com/database/technologies/instant-client/winx64-64-downloads.html

   File: instantclient-basic-windows.x64-23.7.0.25.01.zip

2. Extract and copy ONLY oraociei.dll to this folder

============================================
INSTALLATION STEPS:
============================================

1. Copy ALL files from this folder to: C:\oracle\instantclient_23_7

2. Add to System PATH:
   - Open System Properties > Environment Variables
   - Edit PATH variable
   - Add: C:\oracle\instantclient_23_7

3. Create ORACLE_HOME environment variable:
   - Variable name: ORACLE_HOME
   - Variable value: C:\oracle\instantclient_23_7

4. Copy these DLLs to your PHP folder (C:\php):
   - oci.dll
   - oraociei.dll

5. Restart Command Prompt after making PATH changes

============================================
FILES INCLUDED:
============================================
- oci.dll           (Oracle Call Interface)
- orannz.dll        (Oracle Network)
- orasql.dll        (Oracle SQL)
- fips.dll          (FIPS support)
- legacy.dll        (Legacy support)
- extks.dll         (Extended Key Store)
- pkcs11.dll        (PKCS#11)
- And other supporting files

MISSING (download separately):
- oraociei.dll      (290MB - Oracle OCI Instant Client Engine)

============================================
