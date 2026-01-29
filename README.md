# Monster Adventure - CodeIgniter Edition

This project has been migrated from React/Node.js to a custom CodeIgniter 4-style PHP framework for Laragon.

## 🚀 Setup Instructions

### 1. Database Setup
1. Open Laragon and start all services (Apache, MySQL).
2. Open **HeidiSQL** (or your preferred SQL client).
3. Connect to your local MySQL server (default: user `root`, no password).
4. Run the setup script located at:
   `database/setup.sql`
   
   This will create the `refize_studio` database and seed it with:- 
   - **Users** (Admin & Test User)
   - **News** (Sample changelogs)
   - **Subscribers**

### 2. Access the Site
Since you are using Laragon, the site should be automatically available at:
**http://refize-studio.test**

(If auto-virtual hosts are disabled, go to `http://localhost/refize-studio/`)

---

## 🔑 Default Credentials

### Admin Account
- **Email:** `admin@refize.com`
- **Password:** `admin123`

### User Account
- **Email:** `user@refize.com`
- **Password:** `admin123`

---

## 📂 Project Structure

- **app/** - Core application logic (MVC)
  - **Controllers/** - Handle requests (Home, Auth, News)
  - **Models/** - Database interaction
  - **Views/** - HTML templates
- **public/** - Static assets (CSS, JS)
- **_legacy_backup/** - Backup of original Node.js/React source files

## ✨ Features

- **Authentication**: Login, Register, Forgot Password
- **Evolutionary Story**: Character carousel with 3D tilt effects
- **Game Log**: News system with creating/editing/deleting (Admin only)
- **Eye Tracking**: Interactive Monster SVG
- **Responsive Design**: Mobile-friendly layout
