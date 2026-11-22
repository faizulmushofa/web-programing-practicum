# FlipPlay RESTful API - Demo Modul 4

RESTful API backend untuk platform katalog media FlipPlay yang dibangun menggunakan **Laravel 12** dan **PostgreSQL**. Proyek ini merupakan kelanjutan dari simulasi OOP pada Modul 3, mengimplementasikan konsep Eloquent ORM, Many-to-Many Relationship, Form Request Validation, API Resource, dan Custom Controller Action.

---

## 🛠️ Tech Stack & Requirements

- **Framework:** Laravel 12 (PHP 8.2+)
- **Database:** PostgreSQL
- **Authentication:** Laravel Sanctum (Bonus Endpoint)
- **API Architecture:** RESTful JSON API

---

## 🚀 Setup & Installation

1. **Clone repository dan masuk ke direktori proyek:**
   ```bash
   cd Code/Demo/Demo4
   ```

2. **Install dependensi Composer:**
   ```bash
   composer install
   ```

3. **Setup Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Pastikan konfigurasi PostgreSQL di `.env` sudah sesuai:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=nama_database_kamu
   DB_USERNAME=username_postgres_kamu
   DB_PASSWORD=password_kamu
   ```

4. **Jalankan Migrasi & Database Seeder:**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Development Server:**
   ```bash
   php artisan serve
   ```
   API akan aktif di `http://127.0.0.1:8000`.

---

## 📌 Daftar Endpoint API

| Method | Endpoint | Fungsi | Status Sukses |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/register` | Registrasi akun baru | `201 Created` |
| `POST` | `/api/login` | Login user & generate token | `200 OK` |
| `GET` | `/api/media` | Katalog media (pagination & query `?title=`) | `200 OK` |
| `POST` | `/api/media` | Tambah media baru (Form Request) | `201 Created` |
| `GET` | `/api/media/{media}` | Detail media + eager load relasi user | `200 OK` |
| `PATCH`| `/api/media/{media}` | Update data media | `200 OK` |
| `DELETE`| `/api/media/{media}` | Hapus data media | `200 OK` |
| `GET` | `/api/users/{user}/media` | List koleksi media milik user | `200 OK` |
| `POST` | `/api/users/{user}/media/{media}` | Tambah media ke koleksi user (`attach`) | `200 OK` |
| `DELETE`| `/api/users/{user}/media/{media}` | Hapus media dari koleksi user (`detach`) | `200 OK` |

---

## 🧪 Panduan Pengujian API (Postman Testing Guide)

Base URL: `http://127.0.0.1:8000`  
Header: `Accept: application/json`, `Content-Type: application/json`

---

### 1. Media CRUD

#### 1. GET All Media (Katalog)
- **URL:** `http://127.0.0.1:8000/api/media`
- **Method:** `GET`
- **Body:** *(none)*
- **Status:** `200 OK`

#### 2. GET Search Media (Query Filter)
- **URL:** `http://127.0.0.1:8000/api/media?title=Piece`
- **Method:** `GET`
- **Body:** *(none)*
- **Status:** `200 OK`

#### 3. POST Create Media (Happy Path)
- **URL:** `http://127.0.0.1:8000/api/media`
- **Method:** `POST`
- **Body:**
  ```json
  {
    "title": "Bleach: Thousand-Year Blood War",
    "url_image": "https://media.kitsu.app/anime/poster_images/43806/medium.jpg",
    "rating": 90.2,
    "episodes": 13,
    "status": "finished"
  }
  ```
- **Status:** `201 Created`

#### 4. POST Create Media - Validasi Gagal (Failure Path)
- **URL:** `http://127.0.0.1:8000/api/media`
- **Method:** `POST`
- **Body:**
  ```json
  {
    "title": "",
    "rating": 150
  }
  ```
- **Status:** `422 Unprocessable Content`

#### 5. GET Single Media & Eager Load Relasi
- **URL:** `http://127.0.0.1:8000/api/media/1`
- **Method:** `GET`
- **Body:** *(none)*
- **Status:** `200 OK`

#### 6. GET Single Media Not Found (Failure Path)
- **URL:** `http://127.0.0.1:8000/api/media/9999`
- **Method:** `GET`
- **Body:** *(none)*
- **Status:** `404 Not Found`

#### 7. PATCH Update Media
- **URL:** `http://127.0.0.1:8000/api/media/1`
- **Method:** `PATCH`
- **Body:**
  ```json
  {
    "rating": 88.0,
    "episodes": 1110
  }
  ```
- **Status:** `200 OK`

#### 8. DELETE Media
- **URL:** `http://127.0.0.1:8000/api/media/6`
- **Method:** `DELETE`
- **Body:** *(none)*
- **Status:** `200 OK`

---

### 2. Custom Action (Koleksi Media User)

#### 1. POST Tambah Media ke Koleksi (Happy Path)
- **URL:** `http://127.0.0.1:8000/api/users/1/media/1`
- **Method:** `POST`
- **Body:** *(none)*
- **Status:** `200 OK`

#### 2. POST Tambah Media Duplikat (Failure Path)
- **URL:** `http://127.0.0.1:8000/api/users/1/media/1`
- **Method:** `POST`
- **Body:** *(none)*
- **Status:** `409 Conflict`

#### 3. GET Koleksi Milik User
- **URL:** `http://127.0.0.1:8000/api/users/1/media`
- **Method:** `GET`
- **Body:** *(none)*
- **Status:** `200 OK`

#### 4. DELETE Hapus Media dari Koleksi
- **URL:** `http://127.0.0.1:8000/api/users/1/media/1`
- **Method:** `DELETE`
- **Body:** *(none)*
- **Status:** `200 OK`

---

### 3. Authentication (Bonus)

#### 1. POST Register
- **URL:** `http://127.0.0.1:8000/api/register`
- **Method:** `POST`
- **Body:**
  ```json
  {
    "name": "Faizul",
    "email": "faizul@test.com",
    "password": "password123"
  }
  ```
- **Status:** `201 Created`

#### 2. POST Login
- **URL:** `http://127.0.0.1:8000/api/login`
- **Method:** `POST`
- **Body:**
  ```json
  {
    "email": "admin@gmail.com",
    "password": "password123"
  }
  ```
- **Status:** `200 OK`

---

<br>

**Author:** [faizulmushofa][author-github]  
**Repository:** [web-programing-practicum][repo-github]  
**Last Updated:** November 22, 2026

[author-github]: https://github.com/faizulmushofa
[repo-github]: https://github.com/faizulmushofa/web-programing-practicum
