# Demo 1 - FlipPlay Streaming & Reading Platform

[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS_v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![Lucide Icons](https://img.shields.io/badge/Lucide_Icons-F56565?style=for-the-badge&logo=lucide&logoColor=white)](https://lucide.dev/)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📋 [PROJECT INFO]
* **Project Name**: `Demo1` (FlipPlay Entertainment Portal)
* **Modul Terkait**: Modul 1 & Modul 2 - Pemrograman Web (HTML5 Semantic, Modern Layouting, Tailwind CSS v4 Engine, & Vector Iconography)
* **One Line Description**: Halaman arahan (*landing page*) platform hiburan all-in-one dark mode untuk streaming anime, serial drama, dan pembacaan manga/light novel beresolusi tinggi dengan styling modern berbasis Tailwind CSS v4.
* **Problem Statement**: Pengguna media hiburan sering kali harus membuka banyak aplikasi berbeda untuk menonton anime, membaca manga, dan melacak daftar tontonan. Antarmuka FlipPlay dirancang untuk mengintegrasikan pengalaman penemuan konten tersebut dalam satu landing page modern dengan estetika dark mode premium.
* **Target Users**: Audiens pecinta kultur pop Jepang/Asia (anime, drama, manga, novel) serta praktikan yang mempelajari layouting komponen modern dan tipografi kontras tinggi.

---

## ⚡ [FEATURES]
* 🌙 **Immersive Dark Theme**: Palet warna bertema gelap (*deep dark background* `#07090d` dan *surface container* `#181d25`) yang ramah di mata untuk pengalaman konsumsi media.
* 🎯 **Impactful Hero Showcase**: Judul visual berukuran besar (*"YOUR STORIES. ONE PLACE."*) dengan ringkasan nilai platform serta tombol aksi ganda (*Explore* & *Discover More*).
* 🧭 **Fixed Responsive Header**: Navigasi atas yang mencakup logo identitas merek, menu tautan section (*Home, Discover, Features, Categories*), dan tombol otentikasi cepat (*Sign In* & profil pengguna).
* 🎨 **SVG Vector Iconography**: Integrasi library ikon Lucide via CDN (`lucide.createIcons()`) untuk visualisasi tombol aksi, panah eksplorasi, dan status profil.
* 🧱 **Modular Section Architecture**: Kerangka terstruktur yang siap dikembangkan untuk segmen *Categories*, *Watch-Read Showcase*, *Trending Feed*, dan *Call-to-Action (CTA)*.

---

## 💻 [TECH STACK]
* **Markup**: Semantic HTML5 (Header, Nav, Section, Footer)
* **Styling**: Tailwind CSS v4.3.3 (`@tailwindcss/cli` build workflow)
* **Design Engine**: CSS Theme Variables (`@theme` block di `input.css`)
* **Icon Library**: Lucide Icons (CDN browser runtime & npm package)
* **Runtime**: Node.js & npm scripts

---

## 🏗️ [ARCHITECTURE]

### UI Layer Overview
Struktur visual dibangun dengan hierarki semantik modular:

```
                            ┌────────────────────────────────────┐
                            │            Browser Page            │
                            └─────────────────┬──────────────────┘
                                              │
                   ┌──────────────────────────┴──────────────────────────┐
                   ▼                                                     ▼
        ┌─────────────────────┐                               ┌─────────────────────┐
        │   Header Nav Bar    │                               │     Hero Section    │
        │ - Brand Logo & Name │                               │ - Headline & Sub    │
        │ - Navigation Links  │                               │ - Quick Action CTA  │
        │ - User Action Auth  │                               │ - Media Badges      │
        └─────────────────────┘                               └─────────────────────┘
                   │                                                     │
                   └──────────────────────────┬──────────────────────────┘
                                              ▼
                             ┌─────────────────────────────────┐
                             │    Modular Sections Skeleton    │
                             │  - Categories                   │
                             │  - Watch & Read Carousel        │
                             │  - Trending Feeds               │
                             │  - Features & CTA               │
                             └─────────────────────────────────┘
```

---

## ⚙️ [INSTALLATION]

### 1. Masuk ke Direktori Proyek
```bash
cd Code/Demo/Demo1
```

### 2. Install Dependencies
```bash
npm install
```

---

## 🏃 [RUN COMMANDS]

* **Menjalankan Kompilasi Tailwind CSS (Watch Mode)**:
  ```bash
  npm run start
  ```
* **Membuka Halaman Web**:
  Buka file `src/index.html` langsung di browser Anda atau gunakan Live Server.

---

## 📁 [PROJECT STRUCTURE]

```
Demo1/
├── package.json              # Konfigurasi dependensi Tailwind CLI & Lucide
├── package-lock.json         # Versi terkunci dari dependency tree
└── src/
    ├── index.html            # Markup utama FlipPlay Landing Page
    ├── css/
    │   └── input.css         # Sumber styling Tailwind v4 dengan custom @theme variables
    ├── dist/
    │   └── output.css        # File hasil kompilasi CSS yang digunakan oleh index.html
    ├── images/
    │   └── logo.jpeg         # Asset logo visual FlipPlay
    └── js/
        └── script.js         # Inisialisasi ikon Lucide via lucide.createIcons()
```

---

## 📝 [NOTES / DECISIONS]

* **Tailwind v4 Theme Variables**: Nilai warna utama didefinisikan langsung dalam `@theme` di `input.css` (`--color-background`, `--color-surface`, `--color-card`, `--color-primary`), menghasilkan bundle CSS yang ramping dan mudah di-maintenance tanpa konfigurasi JavaScript terpisah.
* **SVG Rendering**: Menggunakan atribut `data-lucide` yang dirender di client-side menggunakan Vanilla JS untuk menjaga ukuran file HTML tetap bersih.

---

## 🗺️ [ROADMAP]
- [ ] Grid Card untuk katalog Anime & Manga populer pada section `#categories`.
- [ ] Tab Switcher interaktif untuk memilah konten *Watch* (Video) vs *Read* (Komik/Buku).
- [ ] Form Newsletter / Registrasi awal pada section `#cta`.

---

## 📄 [LICENSE]
Didistribusikan di bawah lisensi **MIT**. Bebas digunakan untuk bahan ajar dan referensi.
