# ConstructionHub - Project Management System

## 📋 Table of Contents
- [Project Overview](#project-overview)
- [Features](#features)
- [Project Structure](#project-structure)
- [System Architecture](#system-architecture)
- [Installation & Setup](#installation--setup)
- [Database Configuration](#database-configuration)
- [User Guide](#user-guide)
- [File Descriptions](#file-descriptions)
- [Security Features](#security-features)
- [Technologies Used](#technologies-used)
- [Troubleshooting](#troubleshooting)
- [Future Enhancements](#future-enhancements)
- [License](#license)
- [Contact & Support](#contact--support)

---

## 🏗️ Project Deployment Link
https://constructionhub.infinityfreeapp.com/
To access the project in an admin mode use the below information:
name: get
email: a@gmail.com
password: 123456

## 🏗️ Project Overview

**ConstructionHub** is a comprehensive web-based project management system designed specifically for construction companies and project teams. It provides a centralized platform for managing construction projects, materials, tasks, and team communications.

### Purpose
ConstructionHub simplifies construction project management by providing:
- Centralized project and material tracking
- Task assignment and monitoring
- Role-based access control for different team members
- Real-time project status updates
- Secure user authentication and authorization

### Target Users
- **Administrators**: Project managers and supervisors who oversee all projects, materials, and tasks
- **Regular Users**: Team members, contractors, and site staff who can view projects, access materials, and submit requests

---

## ✨ Features

### Authentication & Security
- ✅ User registration with email validation
- ✅ Secure login with session management
- ✅ Password hashing using PHP's PASSWORD_DEFAULT algorithm
- ✅ Automatic logout functionality
- ✅ Role-based access control (Admin vs User)

### Admin Features
- 📊 **Dashboard**: Complete overview of all projects, materials, and tasks
- 🏗️ **Projects Management**: Create, view, and manage construction projects
  - Add project title, description, and status
  - Upload project images
  - Track project progress
- 📦 **Materials Management**: Manage construction materials inventory
  - Track material specifications
  - Monitor material status and availability
- ✓ **Tasks Management**: Assign and track project tasks
  - Define task priorities
  - Set task status and deadlines
  - Monitor task progress
- 📝 **Posts/Announcements**: Create and share important announcements

### User Features
- 👥 **User Dashboard**: View assigned projects and available materials
- 🔍 **View Projects**: Browse all available construction projects
- 📦 **View Materials**: Access material information and specifications
- 💬 **Post Requests**: Submit material or project inquiries/requests
- 📋 **Ask Materials**: Make specific material availability queries
- ❓ **Ask Projects**: Inquire about specific project details

---

## 📁 Project Structure

```
Final Project/
│
├── admin/                          # Administrator-only pages
│   ├── dashboard.php              # Admin main dashboard with overview
│   ├── projects.php               # Project management interface
│   ├── materials.php              # Materials management interface
│   ├── tasks.php                  # Tasks management interface
│   └── post.php                   # Announcements/posts management
│
├── user/                          # User-only pages
│   ├── dashboard.php              # User main dashboard
│   ├── askprojects.php            # User project inquiry form
│   ├── askmaterials.php           # User materials inquiry form
│   └── ask.php                    # General request posting
│
├── assets/                        # Static files
│   ├── css/
│   │   └── styles.css             # Main stylesheet
│   └── js/
│       └── main.js                # JavaScript functionality
│
├── config/                        # Configuration files
│   └── db.php                     # Database connection settings
│
├── includes/                      # Reusable PHP components
│   └── auth.php                   # Authentication & session checking
│
├── uploads/                       # Directory for uploaded files
│   └── .gitkeep                   # Placeholder for git tracking
│
├── login.php                      # User login page
├── logout.php                     # User logout handler
├── register.php                   # User registration page
│
└── README.md                      # This file

```

---

## 🏛️ System Architecture

### Architecture Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                      Client Browser                          │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│                    Web Server (Apache)                       │
│                    PHP Application Layer                     │
│                                                              │
│  ┌─────────────────┐  ┌──────────────┐  ┌──────────────┐   │
│  │  Auth Layer     │  │  Admin Pages │  │  User Pages  │   │
│  │  (Session Mgmt) │  │  (CRUD Ops)  │  │  (Viewing)   │   │
│  └────────┬────────┘  └──────┬───────┘  └──────┬───────┘   │
│           └────────────────┬─────────────────────┘           │
│                            ↓                                 │
│                   ┌─────────────────┐                        │
│                   │  Database Layer │                        │
│                   │   (PDO Object)  │                        │
│                   └────────┬────────┘                        │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│                   MySQL Database                            │
│   (ConstructionHub)                                         │
│                                                              │
│  Tables: users, projects, materials, tasks, posts          │
└─────────────────────────────────────────────────────────────┘
```

### Data Flow

1. **User Request**: User accesses the application through a web browser
2. **Route**: Request is processed by PHP (login.php, register.php, admin/, user/)
3. **Authentication**: Session check via `includes/auth.php`
4. **Database Query**: Data is fetched/stored using PDO from `config/db.php`
5. **Response**: HTML page is rendered with data and sent to browser

---

## 🚀 Installation & Setup

### Prerequisites
- **Web Server**: Apache with mod_php or equivalent
- **PHP**: Version 7.2 or higher
- **Database**: MySQL 5.7 or higher
- **Web Browser**: Modern browser (Chrome, Firefox, Safari, Edge)

### Installation Steps

#### 1. Clone/Copy Project Files
```bash
# If using git
git clone <repository-url> /var/www/html/training/Final Project

# Or copy files to your web directory
cp -r Final Project/ /var/www/html/training/
```

#### 2. Create MySQL Database
```sql
-- Login to MySQL
mysql -u root -p

-- Create database
CREATE DATABASE ConstructionHub;

-- Use the database
USE ConstructionHub;
```

#### 3. Create Database Tables
Execute the following SQL to create the required tables:

```sql
-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Projects table
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    status ENUM('planning', 'in_progress', 'completed', 'on_hold') DEFAULT 'planning',
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Materials table
CREATE TABLE materials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    quantity INT,
    unit VARCHAR(50),
    status ENUM('available', 'in_use', 'unavailable') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tasks table
CREATE TABLE tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    assigned_to INT,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    due_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);

-- Posts/Announcements table
CREATE TABLE posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    author_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id)
);
```

#### 4. Configure Database Connection
Edit `config/db.php` with your database credentials:

```php
<?php
$host = "localhost";           // Database host
$db   = "ConstructionHub";     // Database name
$user = "root";                // MySQL username
$pass = "your_password";       // MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
```

#### 5. Set Permissions
```bash
# Allow web server to write to uploads directory
chmod 755 uploads/
chmod 755 assets/
chmod 755 config/
```

#### 6. Access the Application
Open your web browser and navigate to:
```
http://localhost/training/Final Project/
```

---

## 🗄️ Database Configuration

### Database Connection File: `config/db.php`

**Purpose**: Centralizes database connection logic using PDO (PHP Data Objects)

**Key Components**:
- **Host**: Server address (typically `localhost` for local development)
- **Database**: ConstructionHub database name
- **User**: MySQL username (default: `root`)
- **Password**: MySQL user password
- **PDO Settings**: Error mode set to exceptions for better error handling

**Connection String**:
```
mysql:host=localhost;dbname=ConstructionHub;charset=utf8
```

### Database Modification Security Notes
- ⚠️ **IMPORTANT**: Update credentials in production
- Use environment variables for sensitive data
- Never commit passwords to version control
- Implement proper backup procedures

---

## 👥 User Guide

### For New Users - Registration

1. Navigate to the application home page
2. Click on **"Register"** link
3. Fill in the registration form:
   - **Name**: Your full name
   - **Email**: Valid email address
   - **Password**: Strong password (recommended: 8+ characters, mix of letters/numbers)
4. Click **"Register"** button
5. Upon successful registration, you'll be redirected to login
6. Login with your credentials

### For Users - Using the Dashboard

**After logging in as a regular user:**

1. **Home Dashboard**
   - View all available projects
   - View materials inventory
   - Quick access to common tasks

2. **View Projects**
   - Browse all construction projects
   - See project status and descriptions
   - View project images

3. **View Materials**
   - Check material availability
   - Review material specifications
   - Check quantities and units

4. **Post Request**
   - Submit general inquiries or requests
   - Ask about specific materials
   - Inquire about specific projects
   - Track request status

### For Admins - Managing Projects

**After logging in as an admin:**

1. **Admin Dashboard**
   - Overview of all projects, materials, and tasks
   - Quick statistics and status

2. **Projects Management**
   - Create new projects
   - Edit project details
   - Update project status
   - Upload project images
   - Delete projects if needed

3. **Materials Management**
   - Add new materials to inventory
   - Update material quantities
   - Change material status
   - Remove materials

4. **Tasks Management**
   - Create new tasks
   - Assign tasks to team members
   - Set task priorities and deadlines
   - Track task progress
   - Update task status

5. **View/Manage Posts**
   - Create announcements
   - View user requests
   - Respond to inquiries
   - Manage communications

---

## 📄 File Descriptions

### Root Authentication Files

| File | Purpose |
|------|---------|
| `login.php` | Handles user login, session creation, role-based redirection |
| `register.php` | Manages user registration with email validation |
| `logout.php` | Clears session and logs user out |

### Configuration & Includes

| File | Purpose |
|------|---------|
| `config/db.php` | Database connection with PDO setup |
| `includes/auth.php` | Session validation and role-based access control |

### Admin Pages

| File | Purpose |
|------|---------|
| `admin/dashboard.php` | Admin overview with all projects, materials, tasks |
| `admin/projects.php` | Create, edit, delete construction projects |
| `admin/materials.php` | Manage inventory of construction materials |
| `admin/tasks.php` | Assign and track project tasks |
| `admin/post.php` | Manage announcements and user requests |

### User Pages

| File | Purpose |
|------|---------|
| `user/dashboard.php` | User home page with projects and materials overview |
| `user/askprojects.php` | Submit inquiries about specific projects |
| `user/askmaterials.php` | Request or inquire about materials |
| `user/ask.php` | Submit general requests or messages |

### Frontend Assets

| File | Purpose |
|------|---------|
| `assets/css/styles.css` | Main stylesheet with layout and styling |
| `assets/js/main.js` | Client-side JavaScript for interactivity |

### Uploads Directory

| File | Purpose |
|------|---------|
| `uploads/.gitkeep` | Placeholder for git tracking, stores uploaded images |

---

## 🔐 Security Features

### Authentication & Authorization
- ✅ **Session-Based Authentication**: Uses PHP sessions for user tracking
- ✅ **Password Hashing**: Uses `PASSWORD_DEFAULT` algorithm for secure storage
- ✅ **Role-Based Access Control (RBAC)**: 
  - Admin role for managers/supervisors
  - User role for team members
  - Page-level protection via `auth.php`

### Data Protection
- ✅ **SQL Injection Prevention**: Uses prepared statements with PDO
- ✅ **Input Validation**: Trimming and sanitization of user inputs
- ✅ **Output Escaping**: Uses `htmlspecialchars()` to prevent XSS
- ✅ **Session Validation**: Checks session existence before page access

### Best Practices Implemented
- ✅ Error reporting enabled (development)
- ✅ Proper HTTP redirects for unauthorized access
- ✅ Secure password verification
- ✅ Database connection error handling

### Security Recommendations
- 🔒 **Production**: Disable error display (`display_errors = 0`)
- 🔒 Use HTTPS for all connections
- 🔒 Implement CSRF tokens for forms
- 🔒 Add rate limiting for login attempts
- 🔒 Implement two-factor authentication
- 🔒 Regular security audits
- 🔒 Keep PHP and MySQL updated

---

## 💻 Technologies Used

### Backend
- **Language**: PHP 7.2+
- **Database**: MySQL 5.7+
- **Database Interface**: PDO (PHP Data Objects)
- **Session Management**: PHP Sessions

### Frontend
- **Markup**: HTML5
- **Styling**: CSS3
- **Scripting**: JavaScript (Vanilla)

### Server
- **Web Server**: Apache (with mod_php)
- **Operating System**: Linux/Unix

### Development Tools
- **Version Control**: Git
- **Code Editor**: VS Code / Any PHP IDE

---

## 🛠️ Troubleshooting

### Common Issues & Solutions

#### Issue 1: Database Connection Failed
**Error**: `Database connection failed: SQLSTATE[HY000]`

**Solutions**:
- Check MySQL server is running
- Verify database credentials in `config/db.php`
- Ensure database `ConstructionHub` exists
- Check user permissions

```bash
# Check MySQL status
sudo service mysql status

# Restart MySQL
sudo service mysql restart
```

#### Issue 2: Blank Pages or 500 Errors
**Cause**: PHP/Database error

**Solutions**:
- Check PHP error logs
- Verify database tables exist
- Ensure proper file permissions (755)

```bash
# Check PHP error log
tail -f /var/log/php-errors.log

# Set proper permissions
chmod 755 -R /var/www/html/training/Final\ Project/
```

#### Issue 3: Can't Upload Images
**Cause**: Upload directory permissions

**Solutions**:
```bash
# Give write permission to uploads
chmod 777 uploads/

# Verify web server user owns directory
chown www-data:www-data uploads/
```

#### Issue 4: Session Not Persisting
**Cause**: Session directory permissions or PHP configuration

**Solutions**:
```bash
# Check session save path
php -i | grep session.save_path

# Set correct permissions
sudo chmod 1733 /var/lib/php/sessions
```

#### Issue 5: 403 Forbidden Error
**Cause**: File permissions too restrictive

**Solutions**:
```bash
# Set directory permissions
chmod 755 uploads/ config/ includes/

# Set file permissions
chmod 644 *.php assets/css/* assets/js/*
```

---

## 🚀 Future Enhancements

### Planned Features
- [ ] **Real-time Notifications**: Email/SMS alerts for task updates
- [ ] **Advanced Search**: Filter and search across all data
- [ ] **Reports & Analytics**: Generate project progress reports
- [ ] **Document Management**: Upload and manage project documents
- [ ] **Team Chat**: Real-time messaging between team members
- [ ] **Mobile App**: Native mobile application
- [ ] **Calendar Integration**: Project timeline and milestone calendar
- [ ] **Budget Tracking**: Monitor project costs and budgets
- [ ] **Safety Compliance**: Safety checklist and incident tracking
- [ ] **API Integration**: REST API for third-party integrations
- [ ] **Two-Factor Authentication**: Enhanced security
- [ ] **Dark Mode**: User interface theme options
- [ ] **Multi-language Support**: Internationalization (i18n)
- [ ] **Audit Logging**: Track all user actions

### Suggested Improvements
1. Implement password reset functionality
2. Add email verification for new registrations
3. Create user profile management page
4. Add pagination for large data sets
5. Implement soft delete instead of hard delete
6. Add data export functionality (CSV/PDF)
7. Create comprehensive admin analytics dashboard
8. Add file attachment support to posts

---

## 📝 License

This project is provided as-is for educational and development purposes. 

**Usage**: You are free to use, modify, and distribute this project with appropriate attribution.

**Note**: Always review and comply with local regulations regarding construction project management and data privacy (GDPR, CCPA, etc.)

---

## 📞 Contact & Support

### Getting Help

**For Technical Issues**:
- Check the Troubleshooting section above
- Review error messages in PHP error logs
- Check MySQL error logs
- Verify database connections

**For Feature Requests**:
- Document your requirement clearly
- Include use case and expected behavior
- Submit through project repository

**Documentation**:
- Inline code comments throughout the project
- Database schema documentation above
- This comprehensive README file

### Project Information
- **Project Name**: ConstructionHub
- **Version**: 1.0.0
- **Status**: Production Ready
- **Last Updated**: 2026

### Developer Notes
- All pages require proper authentication
- Database credentials must be updated for production
- HTTPS should be enabled in production
- Regular database backups are recommended
- Test thoroughly after any modifications

---

## 📊 Quick Reference

### Default User Roles
- **Admin**: Full access to manage all projects, materials, tasks, and posts
- **User**: Limited access to view and submit requests

### File Upload
- **Location**: `/uploads/` directory
- **Supported**: Image files (JPG, PNG, GIF)
- **Max Size**: Configure in PHP.ini

### Key Database Fields
- `users.role`: Determines access level
- `projects.status`: Tracks project progress
- `materials.status`: Tracks material availability
- `tasks.priority`: Task urgency level

---

**For questions or issues, please refer to the documentation above or review the inline code comments in specific PHP files.**

**Version**: 1.0.0 | Last Updated: May 2026
