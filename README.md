# Praktikum Pemrograman Web - Semester 5

[![Course](https://img.shields.io/badge/Semester-5-blue.svg)](README.md)
[![Status](https://img.shields.io/badge/Status-Active_Lab_Works-success.svg)](README.md)
[![Docs](https://img.shields.io/badge/Documentation-Modular_READMEs-orange.svg)](README.md)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📋 [PROJECT INFO]
* **Repository Name**: [`web-programing-practicum`](https://github.com/faizulmushofa/web-programing-practicum)
* **Mata Kuliah**: Praktikum Pemrograman Web (Semester 5)
* **Author / Developer**: [Faizul Mushofa](https://github.com/faizulmushofa)
* **Repository URL**: `https://github.com/faizulmushofa/web-programing-practicum.git`
* **Related Classroom Repo**: [`faizulmushofa/Praktik_Web`](https://github.com/faizulmushofa/Praktik_Web) — repositori latihan dan materi praktikum teori di kelas
* **One Line Description**: Monorepo komprehensif perjalanan praktikum Pemrograman Web semester 5 yang mencakup arsip modul teori laboratorium, implementasi tugas codelab terstruktur, serta proyek demonstrasi mandiri yang terus berkembang sepanjang semester.

---

## ⚡ [FEATURES]
* 📚 **Centralized Module Repository**: Arsip lengkap buku panduan praktikum resmi PDF di folder `Materi/` sebagai acuan standar kompetensi tiap modul.
* 🧪 **Hands-on Codelab Tasks**: Implementasi tugas codelab tiap modul yang terdokumentasi mandiri dengan panduan, instalasi, dan arsitektur spesifik per folder.
* 🚀 **Interactive Demo Applications**: Demonstrasi aplikasi web mandiri untuk mengeksplorasi eksperimen fitur, UI/UX modern, dan studi kasus praktikal.
* 🔗 **Referensi Repo Asisten**: Setiap codelab dilengkapi link ke repo starter resmi dari asisten laboratorium.

---

## 📑 [MODULE & DIRECTORY MATRIX]

Seluruh materi, tugas codelab, dan implementasi demo disusun modular per modul:

| Modul | Topik Utama | Materi (PDF) | Tugas Codelab | Proyek Demo | Status |
| :---: | :--- | :---: | :--- | :--- | :---: |
| **01** | **Modern Web Fundamentals**<br>HTML5 Semantik, CSS Layouting, Tailwind CSS v4 Engine | [`Modul 1`](Materi/Modul_1_WEB.pdf) | [`codelab_1`](Code/Codelab/codelab_1)<br><sub>Landing page — Tema Modern Blue</sub> | [`Demo1`](Code/Demo/Demo1)<br><sub>FlipPlay — Dark Theme Landing Page</sub> | ✅ Selesai |
| **02** | **JavaScript & REST API**<br>ES6+, DOM Manipulation, Event Handling, Async/Await | [`Modul 2`](Materi/Modul_2_WEB.pdf) | [`codelab_2`](Code/Codelab/codelab_2)<br><sub>Portfolio Web + PokeAPI Explorer</sub> | [`Demo2`](Code/Demo/Demo2)<br><sub>FlipPlay — Vanilla JS + Tailwind</sub> | ✅ Selesai |
| **03** | **Object-Oriented PHP**<br>Class, Encapsulation, State Method, Object Association | [`Modul 3`](Materi/Modul_3_WEB.pdf) | [`codelab_3`](Code/Codelab/codelab_3)<br><sub>Sistem Perpustakaan OOP PHP</sub> | [`Demo3`](Code/Demo/Demo3)<br><sub>FlipPlay — Native PHP Backend + UI</sub> | ✅ Selesai |
| **04** | **Laravel Framework & REST API**<br>Eloquent ORM, Relationship, Form Request, API Resource | [`Modul 4`](Materi/Modul_4_WEB.pdf) | [`codelab_4`](Code/Codelab/codelab_4)<br><sub>REST API Perpustakaan (Laravel 11)</sub> | [`Demo4`](Code/Demo/Demo4)<br><sub>FlipPlay — Laravel + Inertia + React</sub> | ✅ Selesai |
| **05** | *Topik Lanjutan Modul 5* | [`Modul 5`](Materi/Modul_5_WEB.pdf) | *Menunggu jadwal* | *Menunggu jadwal* | ⏳ Segera |
| **06** | *Topik Lanjutan Modul 6* | [`Modul 6`](Materi/Modul_6_WEB.pdf) | *Menunggu jadwal* | *Menunggu jadwal* | ⏳ Segera |

> 💡 **Catatan Codelab 3 & 4**: Merupakan penyelesaian tugas dari starter repository resmi asisten lab. Detail repositori asal dicantumkan di README masing-masing folder ([`codelab_3`](Code/Codelab/codelab_3#readme) & [`codelab_4`](Code/Codelab/codelab_4#readme)).

---

## 🏗️ [ARCHITECTURE]

```
Pemrograman_Web/Lab/
├── README.md
├── Materi/                        # PDF modul resmi laboratorium
│   ├── Modul_1_WEB.pdf
│   ├── Modul_2_WEB.pdf
│   ├── Modul_3_WEB.pdf
│   ├── Modul_4_WEB.pdf
│   ├── Modul_5_WEB.pdf
│   └── Modul_6_WEB.pdf
└── Code/
    ├── Codelab/                   # Tugas codelab per modul
    │   ├── codelab_1/             # Modul 1 — HTML Semantik + Tailwind Modern Blue
    │   ├── codelab_2/             # Modul 2 — Portfolio + PokeAPI
    │   ├── codelab_3/             # Modul 3 — OOP PHP Library System
    │   └── codelab_4/             # Modul 4 — Laravel REST API Perpustakaan
    └── Demo/                      # Demonstrasi proyek mandiri
        ├── Demo1/                 # FlipPlay — Dark Theme Landing Page
        ├── Demo2/                 # FlipPlay — Tailwind + Vanilla JS
        ├── Demo3/                 # FlipPlay — PHP Backend + Frontend
        └── Demo4/                 # FlipPlay — Laravel + Inertia + React
```

---

## 🔗 [REFERENSI STARTER REPO]

Codelab modul 3 dan 4 menggunakan starter project dari asisten laboratorium. Repo berikut adalah sumber asli yang digunakan sebagai bahan pengerjaan:

| Modul | Topik | Repo Asisten |
| :---: | :--- | :--- |
| Modul 3 | OOP PHP — Sistem Perpustakaan | [ShofwanAlifUMM/library-system-md3](https://github.com/ShofwanAlifUMM/library-system-md3) |
| Modul 4 | Laravel REST API — Perpustakaan | [nisrinan/CODELAB-4-WEB](https://github.com/nisrinan/CODELAB-4-WEB) |

> 🔗 **Repositori Terkait Perkuliahan**: Latihan, tugas, dan studi kasus yang dikerjakan saat sesi tatap muka kelas dapat diakses pada repositori [**`faizulmushofa/Praktik_Web`**](https://github.com/faizulmushofa/Praktik_Web).

---

## 📝 [KEY LEARNINGS]

* **Tailwind CSS v4**: Directive `@theme` untuk token warna custom tanpa `tailwind.config.js`.
* **OOP PHP**: Class, encapsulation, getter/setter, relasi antar objek (Association/Dependency).
* **Asynchronous JS**: `async/await` + `Promise.all()` untuk batch request efisien.
* **Laravel Eloquent**: Relasi `belongsTo`/`hasMany`, API Resource, Form Request validation.
* **Inertia.js v3**: SPA tanpa kompleksitas — server-side routing + client-side rendering.

---

## 🗺️ [SEMESTER ROADMAP]
- [x] **Modul 1**: Semantic HTML5, CSS Layouting, Tailwind CSS v4.
- [x] **Modul 2**: JavaScript ES6+, DOM Manipulation, REST API Fetch.
- [x] **Modul 3**: OOP PHP — Class, Encapsulation, Relasi Objek.
- [x] **Modul 4**: Laravel, Eloquent ORM, REST API.
- [ ] **Modul 5**: *(Menunggu jadwal praktikum)*
- [ ] **Modul 6**: *(Menunggu jadwal praktikum)*

---

## 📄 [LICENSE]
Seluruh materi dan kode dalam repositori ini dirilis di bawah lisensi **MIT**. Digunakan untuk kebutuhan dokumentasi akademik dan pengembangan keilmuan.
