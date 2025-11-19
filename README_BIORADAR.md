# BIORADAR - Early Cancer Detection and Notification System

A comprehensive Laravel-based health assessment system that provides automated risk evaluation and professional doctor consultations for early cancer detection.

## Features

### Three User Roles

#### Patient
- Submit symptoms with severity and duration details
- Get instant automated risk assessments
- Request professional doctor evaluations
- Track assessment history and results
- Receive email notifications with evaluation results
- Manage personal health profile (demographics, BMI, medical history)

#### Doctor
- Review patient assessments
- Provide professional risk evaluations with percentage scores
- Send diagnosis and recommendations via email
- Track pending and completed assessments
- View patient histories and details

#### Admin
- View all system information
- Manage user accounts (create, update, remove)
- Monitor all assessments
- System oversight and reporting

## Technology Stack

- **Framework**: Laravel 11
- **Frontend**: Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Email**: Laravel Mail with queue support

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL or PostgreSQL database

### Setup Instructions

1. **Install Dependencies**
```bash
composer install
npm install
```

2. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure Database**
Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bioradar
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Configure Mail**
Edit `.env` file for email notifications:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@bioradar.com
MAIL_FROM_NAME="BIORADAR"
```

5. **Run Migrations and Seeders**
```bash
php artisan migrate
php artisan db:seed
```

6. **Install Laravel Breeze (for authentication)**
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm run build
```

7. **Start Development Server**
```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

## Default Credentials

After running the seeders, you can login with:

### Admin
- Email: admin@bioradar.com
- Password: password

### Doctor
- Email: doctor@bioradar.com
- Password: password

### Patient
- Email: patient@bioradar.com
- Password: password

## Database Schema

### Main Tables
- **users**: Core user authentication and role management
- **doctors**: Doctor profiles with specialization and credentials
- **patients**: Patient profiles with health information
- **symptoms**: Symptom definitions with risk weights
- **assessments**: Patient symptom submissions
- **assessment_symptoms**: Pivot table linking symptoms to assessments
- **risk_evaluations**: Doctor evaluations with risk scores and recommendations

## Key Functionalities

### Automated Risk Assessment
The system calculates risk scores based on:
- Symptom risk weights
- Symptom severity (mild, moderate, severe)
- Symptom duration
- Combined symptom patterns

Risk levels are automatically categorized as:
- **Low** (0-24%): Minor concerns
- **Moderate** (25-49%): Attention needed
- **High** (50-74%): Medical consultation recommended
- **Critical** (75-100%): Immediate medical attention required

### Email Notifications
Patients receive email notifications containing:
- Risk percentage and level
- Doctor's evaluation notes
- Personalized recommendations
- Urgency indicators for high-risk cases

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── DoctorController.php
│   │   └── PatientController.php
│   └── Middleware/
│       └── CheckRole.php
├── Models/
│   ├── User.php
│   ├── Doctor.php
│   ├── Patient.php
│   ├── Symptom.php
│   ├── Assessment.php
│   └── RiskEvaluation.php
├── Notifications/
│   └── RiskEvaluationNotification.php
└── Services/
    └── RiskAssessmentService.php

database/
├── migrations/
│   ├── 2024_01_01_000003_add_role_to_users_table.php
│   ├── 2024_01_01_000004_create_doctors_table.php
│   ├── 2024_01_01_000005_create_patients_table.php
│   ├── 2024_01_01_000006_create_symptoms_table.php
│   ├── 2024_01_01_000007_create_assessments_table.php
│   ├── 2024_01_01_000008_create_assessment_symptoms_table.php
│   └── 2024_01_01_000009_create_risk_evaluations_table.php
└── seeders/
    ├── UserSeeder.php
    └── SymptomSeeder.php

resources/
└── views/
    ├── landing.blade.php
    ├── layouts/
    │   └── app.blade.php
    ├── admin/
    │   └── dashboard.blade.php
    ├── doctor/
    │   ├── dashboard.blade.php
    │   └── assessment-review.blade.php
    └── patient/
        ├── dashboard.blade.php
        ├── profile.blade.php
        ├── create-assessment.blade.php
        └── assessment-result.blade.php
```

## Routes

### Public Routes
- `GET /` - Landing page
- `GET /login` - Login page
- `POST /login` - Login submission
- `GET /register` - Registration page
- `POST /register` - Registration submission

### Admin Routes (Prefix: `/admin`)
- `GET /dashboard` - Admin dashboard
- `GET /users` - List all users
- `GET /users/create` - Create user form
- `POST /users` - Store new user
- `GET /users/{user}/edit` - Edit user form
- `PUT /users/{user}` - Update user
- `DELETE /users/{user}` - Delete user
- `GET /assessments` - View all assessments
- `GET /assessments/{assessment}` - View assessment details

### Doctor Routes (Prefix: `/doctor`)
- `GET /dashboard` - Doctor dashboard
- `GET /assessments` - View assigned assessments
- `GET /assessments/pending` - View pending assessments
- `GET /assessments/{assessment}` - Review assessment
- `POST /assessments/{assessment}/claim` - Claim assessment
- `POST /assessments/{assessment}/evaluate` - Submit evaluation
- `GET /patients/{patient}` - View patient details

### Patient Routes (Prefix: `/patient`)
- `GET /dashboard` - Patient dashboard
- `GET /profile` - View/edit profile
- `PUT /profile` - Update profile
- `GET /assessment/create` - New assessment form
- `POST /assessment/automated` - Submit automated assessment
- `POST /assessment/doctor-review` - Submit for doctor review
- `GET /assessments` - View all assessments
- `GET /assessments/{assessment}` - View assessment result

## Queue Configuration

For email notifications, configure and run the queue worker:

```bash
php artisan queue:work
```

Or use queue tables:
```bash
php artisan queue:table
php artisan migrate
```

## Security

- Role-based access control using middleware
- Password hashing with bcrypt
- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade templating

## Development

### Run Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

## License

This project is proprietary software for educational purposes.

## Support

For issues or questions, please contact the development team.

---

**BIORADAR** - Early Cancer Detection and Notification System
© 2025 All Rights Reserved

**Disclaimer**: This system is for informational purposes only and does not replace professional medical advice, diagnosis, or treatment.
