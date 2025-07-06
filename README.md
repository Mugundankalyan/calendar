# Calendar

A simple PHP + JavaScript web application for managing and visualizing course schedules on a calendar. It allows users to add, edit, and delete course events, with each event specifying the course title, instructor, start/end dates, and start/end times. The application provides an interactive monthly calendar view and supports CRUD operations for events.

## Features

- Interactive monthly calendar display in the browser
- Add new course events with title, instructor, date, and time
- Edit and delete existing events
- Visual event listing per day with course and instructor details
- Responsive UI for desktop and mobile
- Real-time clock display

## Demo

To see a running example, clone the repo and follow the installation instructions below.

## Installation

### Requirements

- PHP (tested with PHP 7+)
- MySQL (e.g., via XAMPP)
- Web server (e.g., Apache)

### Steps

1. **Clone this repository:**
   ```bash
   git clone https://github.com/Mugundankalyan/calendar.git
   cd calendar
   ```

2. **Set up the MySQL database:**
   - Create a database named `calendar`.
   - Create a table called `courses`:
     ```sql
     CREATE TABLE courses (
       id INT AUTO_INCREMENT PRIMARY KEY,
       course_name VARCHAR(255) NOT NULL,
       instructor_name VARCHAR(255) NOT NULL,
       start_date DATE NOT NULL,
       end_date DATE NOT NULL,
       start_time TIME NOT NULL,
       end_time TIME NOT NULL
     );
     ```
   - (Optional) Insert seed data as needed.

3. **Configure the database connection:**
   - Edit `connection.php` if your MySQL credentials are different (default is user: `root`, no password, db: `calendar`).

4. **Run the application:**
   - Place the project folder in your web server's root directory (e.g., `htdocs` for XAMPP).
   - Start your web and MySQL servers.
   - Visit `http://localhost/calendar` in your browser.

## Usage

- **Add Event:** Click "+ Add" on a date, fill in the form, and hit "Save".
- **Edit Event:** Click "✏️ Edit" on a date with events, select the event, modify details, and save.
- **Delete Event:** Use the "Delete" button in the event modal.
- **Navigate Months:** Use the ⏮️ and ⏭️ buttons to move between months.

## File Structure

- `index.php` – Main entry point; displays the calendar and handles user interaction.
- `calendar.php` – Backend logic for adding, editing, and deleting events; interfaces with the database.
- `calendar.js` – Front-end logic for rendering the calendar, handling modals, and updating the clock.
- `connection.php` – MySQL connection details.
- `style.css` – Styling for the UI.
