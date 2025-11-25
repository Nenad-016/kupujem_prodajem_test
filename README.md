# 🛒 Mali Oglasi – Laravel 12 Application

## 📌 About the Project

**Mali Oglasi** je moderna Laravel 12 aplikacija za objavljivanje i administraciju oglasa.  
Koristi **Repository–Service pattern**, hijerarhijske kategorije, uloge korisnika, upload slika
i kompletan admin panel.

### Tehnologije:

-   **Laravel 12**
-   **Blade + Tailwind CSS**
-   **Laravel Breeze (Auth)**
-   **Repository-Service Pattern**
-   **Admin & User Dashboard**
-   **Hierarchical Categories**
-   **CRUD for Ads & Categories**

---

## 🚀 Features

### 👤 User Features

-   Registracija i login
-   Kreiranje oglasa
-   Upload više slika
-   Kategorije i podkategorije
-   User dashboard
-   Pretraga po nazivu, opisu i kategoriji
-   Prijavi oglas (Spam i sl.)

### 🛠 Admin Features

-   Admin dashboard
-   User dashboard
-   CRUD kategorija
-   CRUD oglasa
-   CRUD user-a
-   Moderacija oglasa
-   Statusi: `draft`, `active`, `archived`

### ⚙️ Tech Features

-   Repository layer
-   Service layer
-   Validacije
-   Middleware za uloge
-   Tailwind + Blade UI
-   Čista arhitektura

---

## 🛠 Installation & Setup

### 1️⃣ Clone the Repository

```sh
git clone https://github.com/Nenad-016/kupujem_prodajem_test.git
cd kupujem_prodajem_test
```

### 2️⃣ Install PHP Dependencies

````sh
composer install```


### 4️⃣ Environment Setup
```sh
cp .env.example .env
````

**Podesi .env:**

```
DB_DATABASE=popart_db
DB_USERNAME=root
DB_PASSWORD=
```

## ZAHTEVA POSTOJANJE BAZE popart_db

## 5️⃣ Project Setup Command (Custom)

```sh
php artisan app:install
```

Radi:

-   Kreira admin korisnika
-   Ubacuje kategorije
-   Migrira bazu
-   Seederi
-   Storage link
-   NPM build

---

## ▶️ Starting the Development Server

```sh
php artisan serve
```

Ili Docker:

```sh
docker compose up -d
```

Aplikacija:  
http://localhost:8000

---

## 🔐 Default Login Credentials

### Admin

```
email: admin@admin.com
password: password
```

### User

```
email: user@test.com
password: password
```

---

## 📂 Project Architecture Overview

```
app/
├── Models/
├── Repositories/
│   ├── Contracts/
│   └── Eloquent/
├── Services/
└── Http/
    ├── Controllers/
    │   ├── Admin/
    │   └── User/
    └── Middleware/
```

```
resources/views/
├── admin/
└── ads/
└── auth/
└── components/
└── emails/
└── layouts/
└── partials/
└── profile/
└── users/
```

```
routes/
├── web.php
├── admin.php
└── auth.php
```

---

## 🖼️ Images Upload

-   Slike se čuvaju u: `storage/app/public/ads/`
-   Komanda za symlink:

```sh
php artisan storage:link
```

-   Podržano: više slika, brisanje, validacija

---

## 🔍 Search System

-   Pretraga po: nazivu, opisu, kategoriji, podkategoriji
-   Implementacija kroz dynamic Eloquent query builder

---

## 🧩 Category Hierarchy

Kolone:

```
id, name, parent_id (nullable)
```

Podržano:

-   breadcrumbs
-   sidebar listing
-   filtriranje

---

## 🧱 Repository–Service Pattern

Controller → Service → Repository

Primer:

```php
$ads = $this->adService->getAllAds();
```

---

## ✍️ Author

**Created by: Nenad Jovanovic - for testing purpose**  
Laravel Developer – 2024–2025
