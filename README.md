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
* **One Line Description**: Monorepo komprehensif perjalanan praktikum Pemrograman Web semester 5 yang mencakup arsip modul teori laboratorium, implementasi tugas codelab terstruktur, serta proyek demonstrasi mandiri yang terus berkembang sepanjang semester.
* **Problem Statement**: Selama satu semester perkuliahan praktikum web, materi berkembang secara berkala dari dasar frontend, styling modern, interaktivitas DOM/API, hingga topik lanjutan. Tanpa repositori terpusat dan dokumentasi modular per modul, riwayat kode sering kali tercecer dan sulit dipelajari ulang.
* **Target Users**: Praktikan, asisten laboratorium, dosen pengampu, serta pembaca umum yang membutuhkan studi kasus praktikum web terstruktur dari dasar hingga advanced.

---

## ⚡ [FEATURES]
* 📚 **Centralized Module Repository**: Arsip lengkap buku panduan praktikum resmi PDF di folder `Materi/` sebagai acuan standar kompetensi tiap modul.
* 🧪 **Hands-on Codelab Tasks**: Implementasi tugas codelab tiap modul yang terdokumentasi mandiri dengan panduan, instalasi, dan arsitektur spesifik per folder.
* 🚀 **Interactive Demo Applications**: Demonstrasi aplikasi web mandiri untuk mengeksplorasi eksperimen fitur, UI/UX modern, dan studi kasus praktikal.
* 🌐 **Real-world API & Data Handling**: Eksplorasi komunikasi data eksternal, penanganan asinkron, dan integrasi layanan web.
* 📁 **Modular Documentation Architecture**: Setiap sub-proyek memiliki `README.md` independen dengan detail tech stack, arsitektur, dan cara menjalankan masing-masing.

---

## 📑 [MODULE & DIRECTORY MATRIX]

Seluruh tugas dan materi saling terhubung sesuai dengan silabus praktikum semester 5:

| Modul | Topik Pokok Bahasan | Kategori | Folder Kode / Sumber | Dokumentasi Khusus | Status |
| :---: | :--- | :---: | :--- | :---: | :---: |
| **Modul 1** | Fundamental HTML, CSS, Layouting, Tailwind CSS Engine | Materi | [`Materi/Modul_1_WEB.pdf`](Materi/Modul_1_WEB.pdf) | - | ✅ Arsip |
| **Modul 1** | Modern Dark-Mode Landing Page & Vector Icons | Demo | [`Code/Demo/Demo1/`](Code/Demo/Demo1) | [📄 README Demo 1](Code/Demo/Demo1/README.md) | ✅ Selesai |
| **Modul 2** | JavaScript ES6+, DOM Manipulation, Async/Await, REST API | Materi | [`Materi/Modul_2_WEB.pdf`](Materi/Modul_2_WEB.pdf) | - | ✅ Arsip |
| **Modul 2** | Multi-Page Web Portfolio, Custom Toast, & PokeAPI Explorer | Codelab | [`Code/Codelab/codelab_2/`](Code/Codelab/codelab_2) | [📄 README Codelab 2](Code/Codelab/codelab_2/README.md) | ✅ Selesai |
| **Modul 3+** | Modul Praktikum Lanjutan (Backend / Framework / Fullstack) | Codelab / Demo | *Menunggu jadwal praktikum* | - | ⏳ Segera |

---

## 🏗️ [ARCHITECTURE]

### Monorepo Structure Overview

```
                                  ┌───────────────────────────┐
                                  │      Root Workspace       │
                                  │   (Praktikum Web Sem 5)   │
                                  └─────────────┬─────────────┘
                                                │
                       ┌────────────────────────┴────────────────────────┐
                       ▼                                                 ▼
            ┌─────────────────────┐                           ┌─────────────────────┐
            │   Materi/ (Buku)    │                           │    Code/ (Proyek)   │
            │  - Modul 1 PDF      │                           │  - Codelab Tasks    │
            │  - Modul 2 PDF      │                           │  - Demo Projects    │
            └─────────────────────┘                           └──────────┬──────────┘
                                                                         │
                                                ┌────────────────────────┴────────────────────────┐
                                                ▼                                                 ▼
                                     ┌─────────────────────┐                           ┌─────────────────────┐
                                     │  Codelab/codelab_2  │                           │     Demo/Demo1      │
                                     │  (PokeAPI + DOM)    │                           │  (FlipPlay Landing) │
                                     └─────────────────────┘                           └─────────────────────┘
```

---

## 📁 [PROJECT STRUCTURE]

Berikut adalah struktur hirarki direktori monorepo praktikum web:

```
Pemrograman_Web/Lab/
├── README.md                      # Dokumentasi induk praktikum (file ini)
├── Materi/                        # Dokumen modul acuan laboratorium
│   ├── Modul_1_WEB.pdf            # Modul 1: Dasar HTML, CSS, & Layouting
│   └── Modul_2_WEB.pdf            # Modul 2: JavaScript Modern, DOM, Async & API
└── Code/                          # Seluruh implementasi kode tugas & demonstrasi
    ├── Codelab/                   # Direktori penugasan terstruktur Codelab
    │   └── codelab_2/             # Codelab Modul 2: Web Portfolio & PokeAPI
    │       ├── README.md          # 📄 Dokumentasi lengkap Codelab 2
    │       ├── package.json       # Konfigurasi dependensi build
    │       ├── dist/              # Direktori output CSS terkompilasi
    │       └── src/               # Kode sumber aplikasi multi-page
    │           ├── index.html     # Halaman beranda utama
    │           ├── pages/         # Sub-halaman (about, contact, pokemon)
    │           ├── scripts/       # Script JavaScript ES6+ & Fetch handler
    │           └── styles/        # File stylesheet input Tailwind v4
    └── Demo/                      # Direktori demonstrasi proyek mandiri
        └── Demo1/                 # Demo Modul 1/2: FlipPlay Entertainment Portal
            ├── README.md          # 📄 Dokumentasi lengkap Demo 1
            ├── package.json       # Konfigurasi build Tailwind CLI
            └── src/               # Kode sumber landing page FlipPlay
                ├── index.html     # Halaman landing page dark-theme
                ├── css/           # Input CSS & Theme tokens
                ├── js/            # Inisialisasi ikon Lucide
                └── dist/          # Output CSS terkompilasi
```

---

## 📝 [KEY LEARNINGS & HIGHLIGHTS]

* **Transisi ke Tailwind CSS v4**: Penerapan directive `@theme` langsung dalam file CSS untuk deklarasi token warna custom tanpa memerlukan file `tailwind.config.js`.
* **Asynchronous Execution Pattern**: Penerapan kombinasi `async/await` dan `Promise.all()` untuk menangani batch request data secara efisien tanpa membuat browser UI freeze.
* **Component-Oriented Vanilla JS**: Pemanfaatan *closure* dan *factory function* untuk menciptakan komponen UI yang dapat dipakai ulang (seperti custom Toast Notification) tanpa memerlukan library external.

---

## 🗺️ [SEMESTER ROADMAP]
- [x] **Modul 1**: Dasar Web, Semantic HTML5, CSS Layouting, & Pengenalan Tailwind CSS.
- [x] **Modul 2**: JavaScript Modern (ES6+), DOM Manipulation, Event Handling, & REST API Fetch.
- [ ] **Modul 3**: Penyusunan Komponen Dinamis & Form Processing Tingkat Lanjut.
- [ ] **Modul 4**: State Management & Client-Side Routing.
- [ ] **Modul 5**: Integrasi Backend & Fullstack Architecture.

---

## 📄 [LICENSE]
Seluruh materi dan kode dalam repositori ini dirilis di bawah lisensi **MIT**. Digunakan untuk kebutuhan dokumentasi akademik dan pengembangan keilmuan.
