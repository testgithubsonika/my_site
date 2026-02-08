# Event Registration (Drupal 10)

##  Overview
My project allows administrators to create and manage events and enables users to register for those events through a dynamic form.My project includes validation rules, email notifications, admin reporting dashboard, and CSV export functionality.
---

##  Features
### Admin Features

* Admin can Create and manage events
* Can Configure admin notification email
* Can Enable/disable admin email notifications
* Can View registration dashboard
* Admin can Filter registrations using AJAX
* Admin can Export registrations as CSV

### User Features

* can register for events via custom form
* It has dynamic dropdowns using AJAX
* Implement all Validation rules for user inputs
* It prevents Duplicate registration prevention
* also Email confirmation after registration

---

## 🛠 Technical Implementation

my project meets take care of all constraints like 

* Drupal 10.x
* Custom Module Development
* Drupal Form API
* Config API
* Mail API
* Dependency Injection
* AJAX Callbacks
* Custom Database Tables
* PSR-4 Autoloading
* Drupal Coding Standards

---

## Module Location

```
web/modules/custom/event_registration
```
---

## ⚙️ Installation Steps


### — Install Dependencies and configure files.

``
Install PHP [if not installed] version - PHP 8.1.34 (cli) 

In php.ini uncomment extension=pdo_pgsql  and 

extension=pgsql for posgresql and other extension like 

curl, opcache.

update extension_dir path and serverRoot then for email service find [root function] in php.ini file and add STMP EMAIL , SMPT PORT etc.



``
set up Database [i use PostgreSQL]   VERSION - 16.x
-- CREATE EXTENSION pg_trgm;if not enabled
 

 
### — Clone Repository

```
git clone <repository_url>
```
---

### — Navigate to Drupal Root

```
cd my_site
```

---

---

###  start drupal
---

php -S localhost:8080 -t web

---

###  Enable Module

```
drush en event_registration
```

---

###  Clear Cache

```
drush cr
```
---

## 🌐 All four URLs [adminconfig email, Create event , create event registration, dashboard]

### Admin Configuration Page

```
/admin/config/event-registration/settings
```
---

### Event Creation Page

```
/admin/event-registration/create
```
---

### User Registration Form

```
/event-registration
```
---

### Admin Dashboard

```
/admin/event-registration/dashboard
```

---

## 🗄 explanation of tables
---

### 1️⃣ event_config Table and [ web\data-dump] datadump folder has dump of these table .

Stores event details.

| Column             | Description                  |
| ------------------ | ---------------------------- |
| id                 | Primary Key                  |
| event_name         | Name of event                |
| category           | Event category               |
| registration_start | Registration start timestamp |
| registration_end   | Registration end timestamp   |
| event_date         | Event date timestamp         |
| created            | Record creation timestamp    |

---

### 2️⃣ event_registration Table

Stores user registrations.

| Column          | Description                 |
| --------------- | --------------------------- |
| id              | Primary Key                 |
| full_name       | Participant name            |
| email           | Participant email           |
| college_name    | College name                |
| department      | Department                  |
| event_config_id | Foreign key to event_config |
| created         | Submission timestamp        |

---

---
## Relationship Between Tables

event_config (1)
        ↓
event_registration (Many)

---
 One event can have multiple registrations
 Foreign key ensures data integrity

## Event Registration Form logic

Static fields: Full Name, Email, College Name, Department.

✔ Category loads only active events
✔ Event Date loads via AJAX
✔ Event Name loads via AJAX
Submit: Saves registration into event_registration table.



## ✔ Validation Logic

### Email Validation

* Uses Drupal email validation

### Text Field Validation

* Allows alphabets and spaces only
* no special characters allowed

### Duplicate Prevention

* Prevents duplicate registrations using:

```
Email + Event ID
```

---

## 📧 Email Notification Logic

After successful registration:

### User Email

Includes:

* Name
* Event Name
* Event Date
* Category

---

### Admin Email

Sent only if enabled in configuration.
Admin email address is configurable only  via Config API.

## Email Flow logic 


 Send confirmation email to user
 Send admin notification email
 Use Config API admin email
 Create reusable mail service
 Follow Dependency Injection

Registration Form
      ↓
Mail Service
      ↓
Drupal Mail API
      ↓
User Email + Admin Email
---

##  Admin Dashboard Logic

* AJAX based filtering
* Filter by Event Date
* Filter by Event Name
* Displays participant count
* Displays registration table

## Logic of dashboard

✔ Event Date dropdown loads
✔ Event Name loads via AJAX
✔ Dashboard updates via AJAX
✔ Participant count displays
✔ Table shows registrations
✔ Page protected by permission

Controller → Loads Page
     ↓
AJAX → Updates Table + Count
     ↓
Database → Fetch Registrations
---

##  CSV Export Logic

* Exports filtered event registrations
* Includes:

  * Name
  * Email
  * College
  * Department
  * Submission Date

## Logic of CSV export logic 

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
---

## Permissions

Custom permission added:

```
Access Event Registration Admin Page
```

Only authorized users can access dashboard and export.

---

## Architecture

* Service Layer for Email handling
* Controller for admin dashboard
* Form API for all forms
* Database API for queries

---

##  Coding Standards Followed

* PSR-4 Autoloading
* Dependency Injection
* Drupal 10 Coding Standards
* No Hardcoded Configuration

---


