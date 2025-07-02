# 🎓 MYGRADETRACK

**MYGRADETRACK** is a modern Laravel-based academic grade tracking system designed to help students and administrators manage semester subjects, units, and grades. Built with Laravel Jetstream, Livewire, Tailwind CSS, and Vite, this application offers a responsive and interactive experience with real-time UI updates and secure authentication.

---

## 🌟 Features

- 📅 Semester and subject management  
- 📝 Grade tracking per course  
- 🧑‍🎓 User authentication via Jetstream  
- ⚡ Real-time UI using Livewire and Alpine.js  
- 💅 Beautiful and responsive interface with Tailwind CSS  
- 🔧 Modern build process using Vite and npm  
- 📁 Organized migrations for database setup  

---

## 🛠️ Tech Stack

| Tool         | Purpose                            |
|--------------|------------------------------------|
| Laravel      | Backend framework                  |
| Jetstream    | Authentication scaffolding         |
| Livewire     | Reactive components                |
| Alpine.js    | Lightweight frontend interactivity |
| Tailwind CSS | Utility-first CSS framework        |
| Vite         | Fast frontend build tool           |
| MySQL        | Preferred database (or compatible) |

---

## 🚀 Getting Started

### ✅ Prerequisites

Ensure you have the following installed:
- PHP >= 8.1  
- Composer  
- Node.js and npm  
- MySQL or any Laravel-supported database  

---

### 📦 Full Setup Instructions

```bash
# 1. Clone the Repository
git clone https://github.com/your-username/mygrades_track.git
cd mygrades_track

# 2. Install PHP Dependencies
composer install

# 3. Install Frontend Dependencies
npm install

# 4. Copy Environment File and Generate App Key
cp .env.example .env
php artisan key:generate

# 5. Configure .env (edit with your preferred editor)
# Set the following variables appropriately:
# DB_DATABASE=your_database_name
# DB_USERNAME=your_database_user
# DB_PASSWORD=your_database_password

# 6. Run Database Migrations
php artisan migrate

# 7. Build Frontend Assets (for development)
npm run dev

# 8. Serve the Application
php artisan serve
