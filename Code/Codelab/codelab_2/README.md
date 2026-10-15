# Codelab 2 - Web Portfolio & Pokemon Explorer

[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS_v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![JavaScript ES6+](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![PokeAPI](https://img.shields.io/badge/PokeAPI-REST_v2-EF5350?style=for-the-badge&logo=pokemon&logoColor=white)](https://pokeapi.co/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📋 [PROJECT INFO]
* **Project Name**: `codelab_2` (Web Portfolio & Pokemon Explorer)
* **Modul Terkait**: Modul 2 - Pemrograman Web (JavaScript Modern, DOM Manipulation, Event Handling, Asynchronous JavaScript, & REST API Fetch)
* **One Line Description**: Aplikasi web multi-halaman responsif berbasis Tailwind CSS v4 dan Vanilla JavaScript ES6+ yang mengimplementasikan manipulasi DOM dinamis, arsitektur event handling, notifikasi toast berbasis closure/factory function, serta konsumsi PokeAPI secara asinkron.
* **Problem Statement**: Pengembang pemula seringkali langsung bergantung pada library/framework JavaScript berat (seperti React/Vue) tanpa memahami dasar manipulasi Document Object Model (DOM), penanganan asynchronous event loop, alur Promise, serta pengolahan REST API secara native.
* **Target Users**: Praktikan, asisten laboratorium, dan developer web yang mengeksplorasi implementasi native modern JavaScript tanpa runtime framework tambahan.

---

## ⚡ [FEATURES]
* 📱 **Responsive Multi-Page Layout**: Halaman beranda (*Home*), profil (*About*), formulir interaktif (*Contact*), dan katalog data dinamis (*Pokemon*).
* ⚡ **PokeAPI Asynchronous Data Fetching**: Mengambil daftar 30 Pokémon pertama dari REST API PokeAPI secara asinkron (`async/await`) dan melakukan parsing paralel sub-detail menggunakan `Promise.all()`.
* 🎨 **Dynamic DOM Card Rendering**: Menampilkan data Pokémon (sprite image, nama, ID berformat padding 3 digit `#001`, dan badge elemen tipe) secara dinamis ke dalam container grid.
* ⏳ **Stateful UI (Loading & Error Handling)**: Indikator visual loading spinner saat data sedang ditarik dan fallback banner jika transmisi jaringan gagal.
* 🍞 **Custom Reusable Toast Notification**: Komponen notifikasi toast berbasis factory function/closure (`createToast`) dengan durasi dan animasi fade dinamis tanpa dependency pihak ketiga.
* 📝 **Client-side Form Validation & Logging**: Validasi form kontak dengan pengecekan input kosong, dynamic error feedback, dan audit log timestamp ISO ke console browser.
* 🍔 **Mobile-First Responsive Navigation**: Navbar toggle hamburger otomatis untuk tampilan layar mobile (< 768px) yang reset saat viewport diubah ukurannya (*resize event*).
* 🔤 **Offline Typography & Custom Design Tokens**: Konfigurasi font Poppins lokal (Woff2) dan desain palet kustom melalui CSS engine Tailwind CSS v4 `@theme`.

---

## 💻 [TECH STACK]
* **Markup**: Semantic HTML5
* **Styling**: Tailwind CSS v4.3.3 (`@tailwindcss/cli` engine)
* **Scripting**: Native JavaScript (ES6+ standard: Arrow Functions, Template Literals, Destructuring, Promises, Async/Await)
* **Typography**: Local Poppins WebFont (weights: 400, 500, 600, 700)
* **External API**: [PokeAPI v2](https://pokeapi.co/api/v2/) (Public REST API)
* **Package Manager**: npm (Node.js runtime environment)

---

## 🏗️ [ARCHITECTURE]

### System Overview
Aplikasi berjalan di browser client secara statis, memisahkan markup HTML, styling CSS berbasis token utility, dan modular script JavaScript.

```
                              ┌─────────────────────────────────────────┐
                              │            Client Browser               │
                              │  (index.html / about / contact / poke)  │
                              └────────────────────┬────────────────────┘
                                                   │
                         ┌─────────────────────────┴─────────────────────────┐
                         │                                                   │
                         ▼                                                   ▼
              ┌─────────────────────┐                             ┌─────────────────────┐
              │   Local Resources   │                             │  External PokeAPI   │
              │  - Poppins Fonts    │                             │  - GET /pokemon     │
              │  - Tailwind CSS v4  │                             │  - GET /pokemon/:id │
              │  - Assets & Scripts │                             └─────────────────────┘
              └─────────────────────┘
```

### Data Flow Summary (Pokemon Page)
1. **Inisialisasi**: Saat `pokemon.html` dibuka, script `pokemon-scripts.js` otomatis dieksekusi.
2. **State Loading**: Elemen `#loading` diaktifkan (`classList.remove('hidden')`), sedangkan container card disembunyikan.
3. **Fetch Utama**: Request HTTP GET dikirim ke `https://pokeapi.co/api/v2/pokemon?limit=30`.
4. **Sub-Fetch Paralel**: Array hasil di-mapping ke fungsi `fetch(p.url)` dan dieksekusi bersamaan via `Promise.all()`.
5. **DOM Injection**: Kartu-kartu Pokémon dibuat menggunakan template literal HTML dan di-append ke `#card-container`.
6. **State Selesai**: Spinner disembunyikan, kontainer grid dimunculkan, dan status log dicatat ke console browser.

---

## ⚙️ [INSTALLATION]

### 1. Masuk ke Direktori Proyek
```bash
cd Code/Codelab/codelab_2
```

### 2. Install Dependencies
Pastikan Node.js (v18+) sudah terpasang, lalu unduh Tailwind CLI dan library terkait:
```bash
npm install
```

---

## 🏃 [RUN COMMANDS]

* **Menjalankan Kompilasi Tailwind CSS (Watch Mode)**:
  ```bash
  npm run build:css
  ```
* **Membuka Halaman Web**:
  Buka file `src/index.html` langsung di browser, atau gunakan ekstensi VS Code **Live Server** pada folder `src/`.

---

## 🌐 [API INTEGRATION]

* **Base URL**: `https://pokeapi.co/api/v2`
* **Auth**: None (Public Open API)

### Endpoints Digunakan

| Endpoint | Method | Keterangan | Output Data |
| :--- | :--- | :--- | :--- |
| `/pokemon?limit=30` | `GET` | Mengambil metadata 30 entitas Pokémon awal | List nama & resource URL |
| `/pokemon/{id atau name}` | `GET` | Mengambil detail spesifik per Pokémon | `sprites.front_default`, `types`, `id` |

---

## 📁 [PROJECT STRUCTURE]

```
codelab_2/
├── package.json                   # Konfigurasi npm scripts & Tailwind CLI dependency
├── package-lock.json              # Dependency lockfile
├── dist/
│   └── output.css                 # Output build CSS yang dikompilasi oleh Tailwind CLI
└── src/
    ├── index.html                 # Halaman utama (Portfolio & Overview)
    ├── assets/
    │   ├── fonts/                 # WebFont lokal Poppins (woff2)
    │   │   ├── Poppins-Regular.woff2
    │   │   ├── Poppins-Medium.woff2
    │   │   ├── Poppins-SemiBold.woff2
    │   │   └── Poppins-Bold.woff2
    │   └── images/                # Asset gambar showcase artikel/portofolio
    │       ├── web-development.jpeg
    │       ├── progamming.jpeg
    │       └── build-project.jpeg
    ├── pages/                     # Sub-halaman aplikasi
    │   ├── about.html             # Halaman Tentang Kami
    │   ├── contact.html           # Halaman Form Kontak & Validasi
    │   └── pokemon.html           # Halaman Eksplorasi Pokémon API
    ├── scripts/
    │   ├── script.js              # Script global: Mobile toggle, Form validation, Toast factory
    │   └── pages/
    │       ├── home-script.js     # Script spesifik beranda
    │       ├── about-script.js    # Script spesifik halaman about
    │       ├── contact-script.js  # Script spesifik halaman contact
    │       └── pokemon-scripts.js # Script asynchronous fetch & DOM injection PokeAPI
    └── styles/
        └── main.css               # Input stylesheet Tailwind v4 (@theme & @font-face)
```

---

## 📝 [NOTES / DECISIONS]

* **Tailwind CSS v4 `@theme` Engine**: Menggunakan directive `@theme` modern menggantikan file konfigurasi `tailwind.config.js` lama untuk mendeklarasikan custom color tokens (`--color-primary`, `--color-surface`, dll.).
* **Zero Dependency Frontend**: Logika interaktif dibangun murni dengan Vanilla JS untuk memaksimalkan pemahaman spesifikasi ECMAScript dan meminimalkan bundle overhead.
* **Concurrency with `Promise.all`**: Pengambilan 30 detail Pokémon dilakukan paralel untuk memangkas waktu rendering dari sekuensial (~3-5 detik) menjadi sub-detik.

---

## 🗺️ [ROADMAP]
- [ ] Fitur Search & Filter berdasarkan nama atau tipe Pokémon.
- [ ] Modal pop-up dialog untuk melihat status stats (HP, Attack, Defense).
- [ ] Pagination/Infinite scroll untuk load batch data Pokémon berikutnya.

---

## 📄 [LICENSE]
Didistribusikan di bawah lisensi **MIT**. Bebas dipelajari dan dikembangkan.
