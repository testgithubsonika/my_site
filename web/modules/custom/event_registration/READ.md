
Install PHP
in php.ini uncomment extension=pdo_pgsql  and extension=pgsql for posgresql all other like curl, opcache
and make some changes in php.ini such as set extension_dir


apache time u should # Load PHP module
LoadModule php_module "C:/Users/hp/Downloads/php-8.1.34-Win32-vs16-x64/php8apache2_4.dll"

# Tell Apache where php.ini is
PHPIniDir "C:/Users/hp/Downloads/php-8.1.34-Win32-vs16-x64"

# Handle .php files
AddHandler application/x-httpd-php .php

check these ServerRoot "C:/Users/hp/Downloads/httpd-2.4.66-260131-Win64-VS18/Apache24

DocumentRoot "C:/Users/hp/my_site/web"
<Directory "C:/Users/hp/my_site/web">
   
    Options Indexes FollowSymLinks

    #
    # AllowOverride controls what directives may be placed in .htaccess files.
    # It can be "All", "None", or any combination of the keywords:
    #   AllowOverride FileInfo AuthConfig Limit
    #
    AllowOverride All

======================================
Install Composer
Install Database i use PostgreSQL
. Install Web Server
Apache hhttp server 
first posgresql server installed then set up all thing like password username and remeber these because when .. -- CREATE EXTENSION pg_trgm;if not enabled



Create AdminSettingsForm.php

Create Event Configuration Form (Admin Creates Events)

===========
Create Event Registration Form
How It Works
Static fields: Full Name, Email, College Name, Department.

Category dropdown: Triggers AJAX to load event dates.

Event Date dropdown: Triggers AJAX to load event names.

Event Name dropdown: Populated based on selected date.

Submit: Saves registration into event_registration table.


Fields

Full Name

Email

College Name

Department

Category Dropdown

Event Date Dropdown (AJAX)

Event Name Dropdown (AJAX)

✔ Form submission works (temporary)
=================
i did tests 
✔ Test 1 — Special Characters

Try:

Name = Sonika@123
👉 Should show error.

✔ Test 2 — Duplicate Registration

Register once → Try again with same email + event.

👉 Should block.

✔ Test 3 — Successful Registration

Should insert into database.
Drupal Form API rebuild + AJAX state + timestamp mismatch.
==========================
EMAIL NOTIFICATION SYSTEM

✔ Send confirmation email to user
✔ Send admin notification email
✔ Use Config API admin email
✔ Create reusable mail service
✔ Follow Dependency Injection

Email Flow Architecture

Registration Form
      ↓
Mail Service
      ↓
Drupal Mail API
      ↓
User Email + Admin Email
======================================
Admin Listing Dashboard
✅ Features We Will Build

Admin Page that:

✔ Lists all registrations
✔ Filters by Event Date
✔ Filters Event Name via AJAX
✔ Shows total participants
✔ Shows registration table
✔ Restricts access using custom permission
Architecture Design
Controller → Loads Page
     ↓
AJAX → Updates Table + Count
     ↓
Database → Fetch Registrations

===to do Industry standard → use Drupal Table render array.

What Should Work

✔ Event Date dropdown loads
✔ Event Name loads via AJAX
✔ Dashboard updates via AJAX
✔ Participant count displays
✔ Table shows registrations
✔ Page protected by permission

==========
⭐ TECHNICAL CONSTRAINT CHECK
Requirement	Status
No contrib module	✅
PSR-4	✅
Dependency Injection	✅
Drupal coding standard	✅
Config API	✅
Form API	✅
Mail API	✅

==============
CSV Export Architecture
Admin Dashboard
     ↓
Click Export
     ↓
Controller Route
     ↓
Database Query
     ↓
Generate CSV
     ↓
Download File
=======================
Event Registration Form → /event-registration
Event Configuration Form → /admin/event-registration/create
Admin Dashboard → /admin/event-registration/dashboard

