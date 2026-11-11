# RoomTrack – Campus Directory & Room Booking System

A PHP + MySQL web app for a school campus. Students, teachers and admins can log in,
search for vacant or occupied rooms and book them, while visitors can register and
browse campus information (courses, academic calendar, policies, contact info, map).
Admins approve bookings and manage rooms, users and visitors.

> **Note:** The background pictures were removed from this repository.
> See [`assets/images/README.md`](assets/images/README.md) for the list of file names
> if you want to add them back.

## Features

- **Login & registration** for Students, Teachers and Admins (passwords are hashed)
- **Visitor registration** with a separate visitor area
- **Room search** – view vacant and occupied rooms, search by name, type or capacity
- **Room booking** – request a room for a date and time
- **Admin panel**
  - Approve or reject room bookings
  - Add rooms
  - View, update and delete users
  - View, update and delete visitors
- **Campus info pages** – About Us, Courses, Academic Calendar, Academic Policies,
  Contact Information, Campus Map

## Built with

- PHP (mysqli)
- MySQL / MariaDB
- Tailwind CSS (CDN) and plain CSS
- XAMPP for local development

## Project structure

```
├── index.php                 # Home page: Login / Register / Visitor
├── auth/                     # Login and registration
│   ├── register.php          # Login page (redirects Admins to the admin panel)
│   ├── regform.php           # Create an account
│   ├── visitor_login.php     # Visitor registration
│   └── user_login.php        # Older login form (not linked anywhere)
├── pages/                    # Pages for logged-in students and teachers
│   ├── rooms.php             # Room search home
│   ├── vacant_rooms.php
│   ├── occupied_rooms.php
│   ├── book.php / book_form.php
│   └── about_us.php, courses.php, academic_calendar.php,
│       academic_policies.php, contact_information.php, map.php
├── visitor/                  # Same info pages for visitors (v*.php)
├── admin/                    # Admin panel and management pages
├── includes/
│   └── db_connection.example.php   # Copy to db_connection.php
├── database/
│   └── schema.sql            # Creates the database and tables
├── tools/
│   ├── db_check.php          # Tests the database connection
│   └── export_visitors.php   # Exports visitors to data.csv
├── assets/images/            # Background pictures (removed – see README inside)
└── extras/slider-chart/      # Separate slider/chart experiment, not part of the app
```

## Getting started (XAMPP)

1. **Copy the project** into your XAMPP `htdocs` folder, e.g. `C:\xampp\htdocs\RoomTrack`.
2. **Start Apache and MySQL** from the XAMPP Control Panel.
3. **Create the database:** open phpMyAdmin (`http://localhost/phpmyadmin`), go to the
   **Import** tab and import `database/schema.sql`.
4. **Set up the database connection:**
   copy `includes/db_connection.example.php` to `includes/db_connection.php` and put in
   your MySQL username and password.
5. **Open the app:** `http://localhost/RoomTrack/`

To check the database connection, open `http://localhost/RoomTrack/tools/db_check.php`.

### Making an admin account

Register a new account on the **Register** page and choose the **Admin** role, then log in.
Admins are sent to the admin panel automatically.

## Changes made when organizing for GitHub

- Background pictures removed from the repo (see `assets/images/README.md`).
- Files grouped into `auth/`, `pages/`, `visitor/`, `admin/`, `includes/`, `database/` and `tools/`,
  and all links updated to match.
- The database password was taken out of the code; `db_connection.php` is now in `.gitignore`
  and an example file is provided instead.
- The CSV export and database test scripts were moved out of the connection file into `tools/`.
- `database.php` renamed to `database/schema.sql` and updated to match the columns the code
  uses (`room_name`, `timee`, booking times).
- Exported visitor data (`data.csv`) is not included, because it contains personal information.
- Visitor pages now link to the visitor versions of the info pages.
- Admin pages now redirect to the real login page when you are not logged in.

## Known issues

- `auth/user_login.php` redirects to `welcome.php`, which doesn't exist. It isn't linked from
  anywhere; the working login is `auth/register.php`.
- `pages/map.php` and `visitor/vmap.php` are placeholders with no map yet.
