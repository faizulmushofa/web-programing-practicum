# Catatan Pengerjaan Demo Modul 4 (Laravel REST API)

## 1. Database & Environment
- **Server Database**: Jika sudah memiliki service MySQL atau PostgreSQL lokal di OS (misal via Homebrew di macOS/Linux), tidak wajib menggunakan XAMPP/Laragon.
- **Kelebihan XAMPP/Laragon**: Praktis untuk pemula (GUI tinggal klik Start tanpa setup awal), namun jika server lokal sudah aktif, gunakan yang sudah ada.
- **Kredensial Default macOS/Linux**: Username PostgreSQL biasanya sama dengan username OS/Mac (`whoami`), dan password defaultnya kosong.
- **CLI Database**:
  - PostgreSQL: `psql postgres` atau `psql -U <username> -d <database>`
  - MySQL: `mysql -u root -p`
- **Konfigurasi Routing API**: Pada Laravel 11/12, file `routes/api.php` tidak tersedia secara default. Aktifkan dengan perintah:
  ```bash
  php artisan install:api
  ```
- **Verifikasi Koneksi**: Setelah konfigurasi file `.env`, periksa status koneksi database dengan perintah:
  ```bash
  php artisan db:show
  ```

---

## 2. Migration & Database Design
- **Urutan Pengerjaan**: Buat migrasi tabel terlebih dahulu sebelum model.
  ```bash
  php artisan make:migration create_media_table
  ```
- **Foreign Key**: Menuliskan tabel tujuan secara eksplisit lebih aman dan mudah dibaca:
  ```php
  $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
  ```

---

## 3. Autocomplete & Tooling (IDE Helper)
- Eloquent ORM menggunakan fitur dinamis (*magic methods*), sehingga sering tidak terdeteksi autocomplete oleh extension PHP.
- **Solusi**:
  1. Pasang extension **PHP Intelephense** di VS Code.
  2. Pasang package IDE Helper:
     ```bash
     composer require --dev barryvdh/laravel-ide-helper
     php artisan ide-helper:generate
     php artisan ide-helper:meta
     ```
  3. Pastikan workspace VS Code dibuka langsung pada root folder project Laravel (`Demo4`), bukan di folder induknya (`Lab`), agar indexing vendor bekerja maksimal.

---

## 4. Model & Eloquent ORM
- **Membuat Model**:
  ```bash
  php artisan make:model Media
  ```
- **Convention over Configuration**: Laravel memetakan nama Model ke nama tabel secara otomatis dengan aturan:
  `Nama Model (PascalCase)` $\rightarrow$ `snake_case` $\rightarrow$ `Plural (Jamak)`.
  *Contoh: `Media` $\rightarrow$ tabel `media`.*
- **Override Atribut Default Model**:
  - `protected $table = 'nama_tabel';` (Menentukan nama tabel secara manual).
  - `protected $primaryKey = 'id_kustom';` (Jika primary key bukan `id`).
  - `public $incrementing = false;` (Jika primary key bukan auto-increment/misal UUID).
  - `protected $keyType = 'string';` (Jika tipe primary key bukan integer).
  - `public $timestamps = false;` (Jika tidak menggunakan kolom `created_at` & `updated_at`).
  - `const CREATED_AT = 'creation_date';` / `const UPDATED_AT = 'last_update';` (Custom nama kolom timestamp).
  - `protected $dateFormat = 'U';` (Custom format penyimpanan tanggal).
  - `protected $attributes = ['status' => 'current'];` (Menentukan nilai default atribut).
- **Mass Assignment**:
  - `$fillable = [...]` (Daftar kolom yang boleh diisi via request).
  - `$guarded = [...]` (Daftar kolom yang diproteksi/tidak boleh diisi langsung).
- **Casting & Serialization**:
  - `protected $casts = [...]` (Konversi tipe data otomatis, misal JSON ke array, integer, boolean).
  - `protected $hidden = [...]` (Sembunyikan kolom sensitif seperti password saat diubah ke JSON).
  - `protected $visible = [...]` (Kebalikan `$hidden`, hanya tampilkan kolom tertentu).

---

## 5. DTO, Validasi, dan Resource
- **Request DTO (Input Validation)**: Mencegah data tidak valid masuk ke controller.
  ```bash
  php artisan make:request StoreMediaRequest
  ```
- **Response DTO (API Resource)**: Menyeragamkan format output JSON ke client.
  ```bash
  php artisan make:resource MediaResource
  ```
- **Lazy/Eager Loading Protection**:
  Gunakan `$this->whenLoaded('relation_name')` di API Resource agar data relasi hanya disertakan ketika controller memanggil eager loading (`with()` atau `load()`).

---

## 6. Controller & Routing (RESTful Standard)
- **Membuat Controller API**:
  ```bash
  php artisan make:controller Api/MediaController --api
  ```
- **Standar Route Resource**:
  ```php
  Route::apiResource('media', MediaController::class);
  ```

| HTTP Method | URL Endpoint | Method Controller | Fungsi / Makna Aksi | HTTP Status Code |
| :--- | :--- | :--- | :--- | :--- |
| **GET** | `/api/media` | `index()` | Ambil daftar data (list/katalog, pagination) | `200 OK` |
| **POST** | `/api/media` | `store()` | Simpan data baru | `201 Created` |
| **GET** | `/api/media/{id}` | `show()` | Ambil detail satu data spesifik | `200 OK` |
| **PUT / PATCH**| `/api/media/{id}` | `update()` | Perbarui data yang sudah ada | `200 OK` |
| **DELETE** | `/api/media/{id}` | `destroy()` | Hapus data dari sistem | `200 OK` / `204 No Content` |

- **Cek Seluruh Route Terdaftar**:
  ```bash
  php artisan route:list --path=api
  ```

---

## 7. Custom Controller & Action

Digunakan untuk logika bisnis di luar operasi CRUD standar (seperti: Bookmark, Like, Follow, Pinjam Buku, Checkout).

### Contoh Implementasi:
**Route (`routes/api.php`)**:
```php
Route::post('users/{user}/media/{media}', [UserMediaController::class, 'gasKoleksi']);
```

**Controller (`UserMediaController.php`)**:
```php
public function gasKoleksi(User $user, Media $media): JsonResponse
{
    $user->media()->attach($media->id);

    return response()->json([
        'message' => 'Media berhasil ditambahkan ke koleksi user'
    ], 200);
}
```

### Hal-Hal Penting yang Harus Diperhatikan pada Custom Action:
1. **Pemilihan HTTP Method**:
   - `GET`: Hanya untuk membaca/menghitung data tanpa mengubah kondisi database.
   - `POST`: Untuk menambahkan relasi baru (misal `attach`).
   - `PATCH`/`PUT`: Untuk memperbarui status atau sebagian atribut.
   - `DELETE`: Untuk menghapus/memutus relasi (misal `detach`).
2. **Kesesuaian Parameter Route Model Binding**:
   Nama parameter di URL route harus sama persis dengan variabel type-hint di Controller.
   - Contoh route: `users/{user}/media/{media}`
   - Controller: `public function gasKoleksi(User $user, Media $media)`
3. **Penanganan Validasi Duplikasi Data (Conflict)**:
   Periksa keberadaan relasi sebelum memanggil `attach()`. Kembalikan HTTP status `409 Conflict` jika data sudah ada di relasi untuk mencegah duplikasi.
4. **Urutan Pendaftaran Route**:
   Jika URL custom memiliki prefix yang sama dengan resource (`media/popular` vs `media/{media}`), daftarkan route custom **sebelum** `Route::apiResource` agar tidak salah terbaca sebagai `{id}`.
5. **Keamanan Transaksi Data (Race Condition)**:
   Untuk custom action yang polanya *baca kondisi $\rightarrow$ validasi $\rightarrow$ ubah data* (seperti stok barang atau pinjam buku), bungkus dalam `DB::transaction()` dan gunakan `lockForUpdate()` agar tidak terjadi double-action saat request bersamaan.

---

## 8. Seeder (Pengisian Data Awal)
Seeder memasukkan data master/dummy otomatis tanpa input manual.

### 1. Buat Seeder
```bash
php artisan make:seeder MediaSeeder
php artisan make:seeder Userseeders
```

### 2. Cuplikan Kode Proyek
- **`MediaSeeder.php`** (Gunakan `firstOrCreate` cegah duplikat):
  ```php
  foreach ($items as $item) {
      Media::firstOrCreate(['title' => $item['title']], $item);
  }
  ```
- **`Userseeders.php`** (Wajib `Hash::make` untuk password):
  ```php
  User::firstOrCreate(
      ['email' => 'admin@gmail.com'],
      ['name' => 'admin', 'password' => Hash::make('password123')]
  );
  ```
- **`DatabaseSeeder.php`** (Daftarkan dalam satu array):
  ```php
  $this->call([
      MediaSeeder::class,
      Userseeders::class,
  ]);
  ```

### 3. Perintah Eksekusi
```bash
php artisan db:seed                        # Jalankan semua
php artisan db:seed --class=MediaSeeder     # Jalankan satu class
php artisan migrate:fresh --seed           # Reset DB total + seed ulang
```

---

<br>

**Author:** [faizulmushofa][author-github]  
**Repository:** [web-programing-practicum][repo-github]  
**Last Updated:** November 22, 2026

[^1]: Dokumentasi praktikum mandiri Modul 4 Pemrograman Web (RESTful API & Eloquent ORM).

[author-github]: https://github.com/faizulmushofa
[repo-github]: https://github.com/faizulmushofa/web-programing-practicum
