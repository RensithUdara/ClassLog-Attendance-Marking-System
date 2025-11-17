# 📋 ClassLog - QR-Based Attendance Marking System

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-orange.svg)](https://mysql.com)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow.svg)](https://javascript.info)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Active-brightgreen.svg)](https://github.com)

A comprehensive web-based attendance management system designed for educational institutions, featuring QR code-based attendance marking, real-time reporting, and multi-user role management.

## 🌟 Features

### 🎯 Core Functionality
- **QR Code-Based Attendance**: Generate and scan QR codes for quick attendance marking
- **Multi-User System**: Separate dashboards for Admin, Lecturers, and Students
- **Real-Time Tracking**: Live attendance monitoring and reporting
- **Event Management**: Special event attendance tracking with custom parameters
- **Automated Reports**: Generate PDF and Excel reports with attendance analytics

### 👥 User Roles & Capabilities

#### 🔧 **Administrator**
- Complete system oversight and management
- User account creation and management
- Department and batch administration
- System-wide attendance reports
- Event coordination and management

#### 👨‍🏫 **Lecturer/Event Organizer**
- QR code generation for lectures and events
- Subject-specific attendance tracking
- Student attendance reports and analytics
- Event creation and management
- Performance insights and statistics

#### 🎓 **Student**
- QR code scanning for attendance marking
- Personal attendance history viewing
- Subject-wise attendance reports
- Absence submission with documentation
- Dashboard with attendance insights

### 📊 Advanced Features
- **Department Management**: IAT, ICT, AT, ET departments
- **Batch System**: Multi-year batch support (2019-2023)
- **Subject Tracking**: Multiple subjects per department
- **Absence Management**: Students can submit absence requests with proof
- **Visual Analytics**: Charts and graphs for attendance trends
- **Export Capabilities**: PDF and Excel export functionality
- **Password Recovery**: Secure password reset system
- **Session Management**: Secure login/logout functionality

## 🏗️ System Architecture

### 📁 Directory Structure
```
ClassLog-Attendance-System/
├── 📄 index.html                    # Main landing page
├── 🎨 css/
│   └── style.css                    # Global stylesheet
├── 🗄️ database/
│   └── attendance_system.sql        # Complete database schema
├── 🖼️ img/                          # System images and assets
├── 🔧 JS/
│   ├── script.js                    # Main JavaScript functionality  
│   └── script_2.js                  # Additional UI interactions
└── 🐘 php/
    ├── 👑 admin/                    # Administrator module
    │   ├── Admin_Dashboard.php      # Admin control panel
    │   ├── Admin_login.php          # Admin authentication
    │   └── Admin.html               # Admin login interface
    ├── 👨‍🏫 lecturer/                  # Lecturer module
    │   ├── Lecturer_Dashboard.php   # Lecturer control panel
    │   ├── Lecturer_login.php       # Lecturer authentication
    │   ├── Lecturer_Signup.php      # Lecturer registration
    │   ├── Lecturer.html            # Lecturer login interface
    │   └── 🔐 password_reset/       # Password recovery system
    ├── 🎓 student/                  # Student module
    │   ├── Student_Dashboard.php    # Student control panel
    │   ├── Student_login.php        # Student authentication
    │   ├── Student_Signup.php       # Student registration
    │   ├── Student.php              # Student login interface
    │   └── 🔐 password_reset/       # Password recovery system
    └── 📊 reports/                  # Reporting module
        ├── generate_report.php      # Report generation engine
        ├── export_pdf.php           # PDF export functionality
        ├── export_excel.php         # Excel export functionality
        ├── Lecturer_Reports.php     # Lecturer-specific reports
        ├── Student_Reports.php      # Student-specific reports
        └── 📈 analytics/            # Visual analytics components
```

### 🗃️ Database Schema

#### Core Tables
- **👥 Users**: `2019_20`, `2020_21`, `2021_22`, `2022_23` (Student records by batch)
- **🏢 department**: Department information (IAT, ICT, AT, ET)
- **📚 subjects**: Course/subject definitions
- **👨‍🏫 lecturer**: Faculty information and credentials
- **🔐 admin**: Administrator credentials
- **📅 batch**: Academic year batches
- **🔗 batch_subject**: Subject-lecturer-batch relationships

#### Attendance Tables
- **📋 Subject Attendance**: Individual tables per subject (e.g., `ic_2201_attendance`)
- **🎪 events_attendance**: Special event attendance tracking
- **❌ absences**: Student absence requests with documentation

#### System Tables
- **📖 lectures**: Lecture scheduling and information
- **🎉 events**: Event management and details

## 🚀 Installation Guide

### 📋 Prerequisites
- **Web Server**: Apache 2.4+ or Nginx
- **PHP**: Version 7.4 or higher
- **Database**: MySQL 8.0+ or MariaDB 10.4+
- **Composer**: For PHP dependency management

### 🔧 Step-by-Step Installation

#### 1️⃣ **Clone Repository**
```bash
git clone https://github.com/yourusername/classlog-attendance-system.git
cd classlog-attendance-system
```

#### 2️⃣ **Database Setup**
```sql
-- Create database
CREATE DATABASE attendance_system;

-- Import schema
mysql -u your_username -p attendance_system < database/attendance_system.sql
```

#### 3️⃣ **Configure Database Connection**
Create `config/database.php`:
```php
<?php
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "attendance_system";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
```

#### 4️⃣ **Install Dependencies**
```bash
cd php/reports
composer install
```

#### 5️⃣ **Set Permissions**
```bash
chmod 755 -R .
chmod 777 uploads/  # For file uploads
```

#### 6️⃣ **Configure Web Server**

**Apache (.htaccess)**:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
```

**Nginx**:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/classlog-attendance-system;
    index index.html index.php;

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

## 🎮 Usage Guide

### 🔐 Default Login Credentials

#### Administrator
- **Username**: `administrator`
- **Password**: `SecurePass2025!`

#### Sample Lecturer
- **Email**: `robert.chen@university.edu`
- **Password**: `lecturer123` (change after first login)

#### Sample Student
- **Student ID**: `2019t01101`
- **Email**: `alex.johnson@university.edu`
- **Password**: `student123` (change after first login)

### 🚀 Getting Started

#### **For Administrators**
1. Access admin panel via `/php/admin/Admin.html`
2. Login with admin credentials
3. Navigate through the dashboard to:
   - Manage users and departments
   - View system-wide reports
   - Configure system settings
   - Monitor attendance trends

#### **For Lecturers**
1. Access lecturer panel via `/php/lecturer/Lecturer.html`
2. Login with lecturer credentials
3. Dashboard features:
   - **Generate QR Code**: Create QR codes for lectures
   - **View Reports**: Monitor student attendance
   - **Manage Courses**: Handle subject assignments
   - **Event Organization**: Create and manage events

#### **For Students**
1. Access student portal via `/php/student/Student.php`
2. Login with student credentials
3. Available features:
   - **Scan QR Code**: Mark attendance by scanning lecturer's QR
   - **View Attendance**: Check personal attendance records
   - **Submit Absences**: Request absence approval with documentation
   - **Generate Reports**: Export personal attendance data

### 📱 QR Code System

#### **QR Code Generation (Lecturer)**
1. Navigate to "Generate QR Code" from lecturer dashboard
2. Select subject, date, and time
3. System generates unique QR code
4. Display QR code for students to scan

#### **QR Code Scanning (Student)**
1. Access "Scan QR Code" from student dashboard
2. Use device camera to scan lecturer's QR code
3. Attendance automatically recorded with timestamp
4. Confirmation message displayed

## 📊 Reporting Features

### 📈 **Available Reports**

#### **Student Reports**
- Personal attendance summary
- Subject-wise attendance percentage
- Monthly attendance trends
- Absence history with status

#### **Lecturer Reports**
- Class attendance overview
- Student performance analytics
- Subject-wise statistics
- Event attendance tracking

#### **Admin Reports**
- System-wide attendance metrics
- Department performance comparison
- Batch-wise analytics
- Historical trend analysis

### 📋 **Export Options**
- **PDF Reports**: Professional formatted reports
- **Excel Spreadsheets**: Data analysis and manipulation
- **CSV Files**: Raw data export for external analysis

## 🛠️ Customization

### 🎨 **Theming**
Modify `css/style.css` to customize:
- Color schemes and branding
- Layout and spacing
- Typography and fonts
- Responsive design elements

### 🔧 **Adding New Features**

#### **New Attendance Table**
```sql
CREATE TABLE `new_subject_attendance` (
    `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
    `scanned_Date` date NOT NULL,
    `scanned_Time` time NOT NULL,
    `Subject_id` int(11) NOT NULL,
    `Subject_Code` varchar(20) NOT NULL,
    `student_id` char(10) NOT NULL,
    `batch_id` int(11) NOT NULL,
    `department_id` int(11) NOT NULL,
    PRIMARY KEY (`attendance_id`)
);
```

#### **New User Role**
1. Create role-specific directory in `php/`
2. Implement authentication system
3. Create dashboard with role permissions
4. Update database with role definitions

### 🌐 **Multi-Language Support**
Create language files in `lang/` directory:
```php
// lang/en.php
<?php
return [
    'welcome' => 'Welcome to ClassLog',
    'login' => 'Login',
    'dashboard' => 'Dashboard'
];
?>
```

## 🔒 Security Features

### 🛡️ **Implemented Security Measures**
- **Password Hashing**: bcrypt encryption for all passwords
- **Session Management**: Secure session handling with timeouts
- **SQL Injection Prevention**: Prepared statements and parameterized queries
- **XSS Protection**: Input sanitization and output encoding
- **CSRF Protection**: Token-based form validation
- **File Upload Security**: Type validation and size limits
- **Access Control**: Role-based permission system

### 🔐 **Security Best Practices**
```php
// Example: Secure password hashing
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Example: Input sanitization
$clean_input = filter_var($input, FILTER_SANITIZE_STRING);

// Example: Prepared statements
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
```

## 🧪 Testing

### 🔍 **Testing Scenarios**

#### **Authentication Testing**
- Valid/invalid login attempts
- Password reset functionality
- Session timeout handling
- Multi-role access control

#### **Attendance Testing**
- QR code generation and scanning
- Timestamp accuracy
- Duplicate attendance prevention
- Cross-batch attendance validation

#### **Report Testing**
- Data accuracy in reports
- Export functionality (PDF/Excel)
- Date range filtering
- Performance with large datasets

### 🎯 **Test Data**
The system includes comprehensive test data:
- **64 Students** across 4 batches
- **13 Lecturers** across 4 departments
- **Multiple Subjects** with attendance records
- **Sample Events** with participation data

## 🚀 Performance Optimization

### ⚡ **Database Optimization**
```sql
-- Add indexes for better performance
CREATE INDEX idx_student_batch ON `2019_20` (`batch_id`, `department_id`);
CREATE INDEX idx_attendance_date ON `ic_2201_attendance` (`scanned_Date`);
CREATE INDEX idx_subject_lookup ON `subjects` (`subject_code`);
```

### 🎛️ **PHP Optimization**
- Enable OPcache for improved PHP performance
- Use connection pooling for database connections
- Implement caching for frequently accessed data
- Optimize image loading with lazy loading

### 🌐 **Frontend Optimization**
- Minify CSS and JavaScript files
- Implement browser caching
- Optimize images and assets
- Use CDN for external libraries

## 🤝 Contributing

### 📝 **Contribution Guidelines**
1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### 🐛 **Bug Reports**
When reporting bugs, please include:
- Operating system and browser version
- PHP and MySQL versions
- Steps to reproduce the issue
- Expected vs actual behavior
- Screenshots if applicable

### 💡 **Feature Requests**
- Describe the feature in detail
- Explain the use case and benefits
- Provide mockups or examples if possible

## ❓ Troubleshooting

### 🔧 **Common Issues**

#### **Database Connection Error**
```
Solution: Check database credentials in config files
Verify MySQL service is running
Ensure database exists and user has proper permissions
```

#### **QR Code Not Generating**
```
Solution: Check PHP GD extension is installed
Verify file permissions for uploads directory
Clear browser cache and try again
```

#### **Reports Not Loading**
```
Solution: Install required Composer dependencies
Check PHP memory limit settings
Verify export directory permissions
```

#### **Login Issues**
```
Solution: Clear browser cookies and sessions
Check password hash compatibility
Verify user exists in database
```

### 📞 **Getting Help**
- Check the [Issues](https://github.com/yourusername/classlog-attendance-system/issues) section
- Review documentation thoroughly
- Contact system administrator
- Join our [Discord Community](https://discord.gg/classlog)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

```
MIT License

Copyright (c) 2025 ClassLog Attendance System

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## 👏 Acknowledgments

- **Material Icons**: Google Material Design Icons
- **Chart.js**: For beautiful attendance analytics
- **PhpSpreadsheet**: Excel export functionality
- **mPDF**: PDF generation capabilities
- **Educational Community**: For feedback and testing

## 🌟 Support the Project

If this project helped you, please consider:
- ⭐ Starring the repository
- 🍴 Forking and contributing
- 📢 Sharing with others
- 💬 Providing feedback

---

<div align="center">

**ClassLog Attendance Marking System** 📋

*Making attendance management simple, secure, and efficient*

[![GitHub stars](https://img.shields.io/github/stars/yourusername/classlog-attendance-system.svg?style=social&label=Star)](https://github.com/yourusername/classlog-attendance-system)
[![GitHub forks](https://img.shields.io/github/forks/yourusername/classlog-attendance-system.svg?style=social&label=Fork)](https://github.com/yourusername/classlog-attendance-system/fork)

</div>

---

> **Note**: This README is a living document. Please keep it updated as the project evolves. Last updated: November 2025