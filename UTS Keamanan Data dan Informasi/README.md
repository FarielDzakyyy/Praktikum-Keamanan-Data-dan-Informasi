Mini DVWA-like PHP Demo
=======================
Structure:
  - index.php : main menu linking vulnerable/ and secure/ labs
  - vulnerable/ : intentionally vulnerable PHP modules (login, comments, upload, profile) and a db_init.php to create app.db
  - secure/ : safer versions with simple mitigations and a db_init.php

Secure auth:
  - secure/auth_login.php (login page) issues a UUID and token stored in sessions/ as server-side validation.
  - Secure pages require both session uuid and token to match server-side file before granting access.

To run locally (requires PHP 7.4+ with PDO SQLite enabled):
  1) Copy this folder into a PHP-enabled webroot (or use built-in PHP server):
     php -S 127.0.0.1:8000 -t /path/to/dvwa_php_demo
  2) Initialize DBs:
     visit /vulnerable/db_init.php and /secure/db_init.php once.
  3) Visit http://127.0.0.1:8000/index.php

Notes:
  - These apps are for educational use only. Do NOT deploy vulnerable/ on public hosts.
  - Mitigations in secure/ are intentionally simple for teaching; production needs stronger measures.
