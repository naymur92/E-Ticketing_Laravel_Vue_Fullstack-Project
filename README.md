# E-Ticket System (Train)

This application is developed using laravel 8, vue 3. php 8.0 or more needed

## Commands to active application

- run those commands on main app folder 'backend'
- composer install / composer update
- npm install
- npm run dev
- make env file and give command 'php artisan key:generate'
- setup db and give command 'php artisan migrate --seed' or import backup db file

# Application Features

- Backend using Laravel (with some Vue components) and Frontend using Vue
- Same Login page for backend and frontend
- Train, Schedule & Ticket, etc. Management from backend
- Train searching, Seat Selecting, Booging, Ticket Downloading, etc. from frontend

## From Admin Panel (Laravel)

### Some Vue components is being used here

- Manage Users
- Manage Stations
- Manage Root Trains
- Manage Train Routes
- Manage Bogi Types for Bogis
- Manage everyday Train using Root Trains having Train Routes
- Automation on Train adding based on previous record (ex. automatic bogis adding)
- For each stopage there have been a Schedule with specific bogis with seat ranges.
- Manage Schedules for Everyday Trains and Add Seat Ranges for Each Schedules
- Automation on Schedules adding based on previous record (ex. automatic bogis and seats selection)
- Ticket Management

## From User Panel (Vue)

- Search Train
- Seat Selection
- Seats Booking
- Ticket Printing

# Login Details

- admin: naymur@example.com
- user: alo@example.com
- password: abcd1234
