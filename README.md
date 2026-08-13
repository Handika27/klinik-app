# 🏥 Klinik App

A comprehensive, web-based clinic management system built with Laravel to streamline daily medical facility operations, enhance patient care, and simplify administrative tasks.

---

## 📸 Screenshots

<table>
  <tr>
    <th colspan="2">Landing Page</th>
  </tr>
  <tr>
    <td colspan="2">
      <img src="https://github.com/user-attachments/assets/eed5eee4-c2a7-4c3e-8577-3e3c163503de" width="100%" alt="Landing Page">
    </td>
  </tr>
  <tr>
    <th width="50%">Admin Dashboard</th>
    <th width="50%">Login Page</th>
  </tr>
  <tr>
    <td>
      <img src="https://github.com/user-attachments/assets/0bc366fa-54be-46e3-9e58-2e4c509d3945" width="100%" alt="Admin Dashboard">
    </td>
    <td>
      <img src="https://github.com/user-attachments/assets/c99205f4-e82f-494d-8478-a1011f9dd1fb" width="100%" alt="Login Page">
    </td>
  </tr>
</table>



---

## 🛠️ Tech Stack

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/vite-%23646CFF.svg?style=for-the-badge&logo=vite&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

---

## ✨ Core Features

Based on the application architecture, this system supports several integrated modules:

* **Multi-Role Authentication:** Secure access control tailored for Administrators, Doctors (Dokter), and Patients (Pasien).
* **Schedule Management:** Modules to manage and display doctor availability and schedules (Jadwal Dokter).
* **Appointment System (Reservasi):** A streamlined booking workflow handling patient reservations and integrated payment fields.
* **Medical Records (Rekam Medis):** Digital tracking and management of patient medical histories and consultation outcomes.
* **Pharmacy Management:** Inventory tracking for medicines (Obat) and digital prescription management (Resep Obat).
* **Announcement System:** A dedicated module for broadcasting clinic updates and general information.

---

## 🚀 Prerequisites

Before setting up the project, ensure you have the following installed on your local machine:
* PHP (v8.1 or higher recommended)
* Composer
* Node.js & NPM
* A database engine (MySQL, SQLite, etc.)

---

## 💻 Installation & Setup

**1. Clone the repository**
```bash
git clone https://github.com/Handika27/klinik-app.git
cd klinik-app
```

**2. Install Dependencies**
```bash
composer install
npm install
```

**3. Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Run Database Migrations & Seeders**
```bash
php artisan migrate --seed
```

**5. Start the Server**
```bash
npm run dev
php artisan serve
```
Visit `http://localhost:8000` in your browser to access the application.

---

## 📁 Project Structure Highlights
* `app/Http/Controllers/`: Contains business logic for Auth, Announcements, Doctors, Patients, and Medicines.
* `resources/views/`: Categorized UI templates for Admin, Dokter, and Pasien dashboards.
* `database/migrations/`: Structured database schemas ensuring data integrity across medical records and user roles.
