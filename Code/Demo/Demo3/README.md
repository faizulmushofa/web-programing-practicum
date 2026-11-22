# FlipPlay Demo 3 - API Contract & Frontend Analysis

Dokumentasi analisis mendalam kebutuhan API frontend FlipPlay (`apps/frontend/`) serta spesifikasi kontrak API (*API Contract*) untuk backend.

---

## 1. Analisis Frontend Eksisting (`apps/frontend/`)

### 1.1 Kondisi Saat Ini (Current State)
* **File Utama**: `apps/frontend/index.html`, `apps/frontend/js/script.js`.
* **Sumber Data**: Direct client-side fetch ke Kitsu API publik (`https://kitsu.io/api/edge/anime?sort=-startDate`).
* **Format Data**: JSON:API specification (`application/vnd.api+json`) dengan nesting dalam (`item.attributes.*`).

### 1.2 Masalah Arsitektur & Performa
1. **Waterfall Network Requests**:
   * Frontend melakukan looping sekuensial hingga 5 kali (`let page = 1; nextUrl && page < 5; page++`) hanya untuk mengumpulkan ~50 record ke memory array `media`.
   * Mengakibatkan Initial Page Load lambat dan boros bandwidth user.
2. **Client-side Filtering & Pagination**:
   * Pencarian judul (`searchInput`), filter aura (`all`, `high-rated`, `movies`, `ongoing`), dan pagination (8 item/halaman) seluruhnya dieksekusi di browser memory.
   * Tidak scalable jika dataset bertambah.
3. **Tight Coupling ke Schema Eksternal**:
   * Komponen UI terikat langsung ke path field Kitsu:
     * `item.attributes.titles.en_jp` / `item.attributes.canonicalTitle`
     * `item.attributes.posterImage?.medium`
     * `item.attributes.averageRating`
     * `item.attributes.episodeCount`
     * `item.attributes.status`
     * `item.attributes.showType`
4. **Interaksi UI Tanpa Endpoint**:
   * Form `Contact Us` (`#name`, `#email`, `#message`) belum memiliki handler `onsubmit` maupun endpoint backend penerima.
   * Tombol `Sign in` & `Register` di header belum terhubung ke API otentikasi.

### 1.3 Kebutuhan Transformasi ke Internal REST API
* Mengganti Kitsu JSON:API dengan REST API internal berformat JSON standar yang flat dan ringkas.
* Memindahkan filtering, searching, dan pagination ke server-side (DB/Backend).
* Endpoint submit pesan kontak (`POST /api/contact`).
* Kontrak response seragam (*Standard Response Envelope*).

---

## 2. API Contract Specification

### 2.1 Konvensi Umum
* **Base URL**: `/api/v1`
* **Default Headers**:
  * `Content-Type: application/json`
  * `Accept: application/json`
* **Standard Response Envelope (Success)**:
  ```json
  {
    "success": true,
    "message": "Data retrieved successfully",
    "data": [],
    "meta": {
      "page": 1,
      "limit": 8,
      "total_items": 100,
      "total_pages": 13
    }
  }
  ```
* **Standard Response Envelope (Error)**:
  ```json
  {
    "success": false,
    "message": "Validation failed",
    "errors": {
      "email": ["Invalid email format"]
    }
  }
  ```

---

### 2.2 Endpoints

#### A. `GET /api/v1/media`
Mengambil daftar katalog media dengan filter, pencarian, dan pagination server-side.

##### Query Parameters:
| Parameter | Tipe | Wajib | Default | Deskripsi |
|---|---|---|---|---|
| `page` | Integer | Tidak | `1` | Nomor halaman aktif |
| `limit` | Integer | Tidak | `8` | Jumlah item per halaman (sesuai `itemsPerPage` frontend) |
| `q` | String | Tidak | `""` | Kata kunci pencarian judul anime |
| `aura` | String | Tidak | `"all"` | Filter kategori: `all`, `high-rated`, `movies`, `ongoing` |
| `sort` | String | Tidak | `"-startDate"` | Urutan data: `-startDate`, `rating_desc`, `title_asc` |

##### Aturan Logika Filter Server:
* `aura=high-rated`: `rating >= 80`
* `aura=movies`: `type = 'movie'`
* `aura=ongoing`: `status = 'current'`
* `q`: Case-insensitive `LIKE %query%` pada judul

##### Contoh Request:
```http
GET /api/v1/media?page=1&limit=8&q=piece&aura=ongoing HTTP/1.1
Host: localhost:8000
Accept: application/json
```

##### Contoh Response Sukses (`200 OK`):
```json
{
  "success": true,
  "message": "Media catalog fetched successfully",
  "data": [
    {
      "id": 12,
      "title": "One Piece",
      "poster_image": "https://media.kitsu.app/anime/poster_images/12/medium.jpg",
      "rating": 86.4,
      "episodes": null,
      "status": "current",
      "type": "tv"
    }
  ],
  "meta": {
    "page": 1,
    "limit": 8,
    "total_items": 1,
    "total_pages": 1
  }
}
```

##### Response Kosong (`200 OK`):
```json
{
  "success": true,
  "message": "No matching titles found",
  "data": [],
  "meta": {
    "page": 1,
    "limit": 8,
    "total_items": 0,
    "total_pages": 0
  }
}
```

---

#### B. `GET /api/v1/media/{id}`
Mengambil detail satu item media (untuk modal/detail view).

##### Path Parameters:
| Parameter | Tipe | Deskripsi |
|---|---|---|
| `id` | Integer / String | ID media |

##### Response Sukses (`200 OK`):
```json
{
  "success": true,
  "message": "Media detail fetched successfully",
  "data": {
    "id": 12,
    "title": "One Piece",
    "synopsis": "Gol D. Roger was known as the 'Pirate King'...",
    "poster_image": "https://media.kitsu.app/anime/poster_images/12/medium.jpg",
    "rating": 86.4,
    "episodes": null,
    "status": "current",
    "type": "tv",
    "start_date": "1999-10-20"
  }
}
```

##### Response Error (`404 Not Found`):
```json
{
  "success": false,
  "message": "Media item not found",
  "errors": null
}
```

---

#### C. `POST /api/v1/contact`
Menerima submisi form *Contact Us* dari section `#contact`.

##### Request Headers:
```http
Content-Type: application/json
```

##### Request Body:
```json
{
  "name": "Faizul Mushofa",
  "email": "user@example.com",
  "message": "FlipPlay needs more dark mode options!"
}
```

##### Validasi Input:
* `name`: string, required, min 2 chars, max 100 chars.
* `email`: string, required, valid email format.
* `message`: string, required, min 5 chars, max 1000 chars.

##### Response Sukses (`201 Created`):
```json
{
  "success": true,
  "message": "Pesan Anda berhasil dikirim.",
  "data": {
    "id": 1,
    "name": "Faizul Mushofa",
    "email": "user@example.com",
    "created_at": "2026-11-07T12:00:00Z"
  }
}
```

##### Response Error Validasi (`422 Unprocessable Entity`):
```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "email": ["Format email tidak valid."],
    "message": ["Pesan minimal 5 karakter."]
  }
}
```

---

#### D. `POST /api/v1/auth/login` & `POST /api/v1/auth/register` (Opsional/Next Phase)
Dibutuhkan untuk tombol header `Sign in` dan `Register`.

##### Request Body `POST /api/v1/auth/login`:
```json
{
  "email": "user@example.com",
  "password": "secretpassword"
}
```
##### Response (`200 OK`):
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "eyJhbGciOi...",
    "user": {
      "id": 1,
      "name": "Faizul",
      "email": "user@example.com"
    }
  }
}
```

---

## 3. Matriks Pemetaan Frontend vs REST API

| Elemen UI / Interaksi | Data Lama (Kitsu JSON:API) | Kontrak Baru Internal API |
|---|---|---|
| Card Poster Image | `item.attributes.posterImage?.medium` | `item.poster_image` |
| Card Title | `item.attributes.titles.en_jp \|\| item.attributes.canonicalTitle` | `item.title` |
| Card Rating | `item.attributes.averageRating` | `item.rating` |
| Card Episodes | `item.attributes.episodeCount` | `item.episodes` |
| Filter "Top Rated" | `rating >= 80` (client-side) | `GET /api/v1/media?aura=high-rated` |
| Filter "Movies" | `showType === 'movie'` (client-side) | `GET /api/v1/media?aura=movies` |
| Filter "Currently Airing" | `status === 'current'` (client-side) | `GET /api/v1/media?aura=ongoing` |
| Input Search | `title.includes(query)` (client-side) | `GET /api/v1/media?q={query}` (debounced) |
| Pagination Buttons | Hitung `pageCount` dari array local | Gunakan `meta.total_pages` dari response |
| Form `#contact` | Belum terhubung | `POST /api/v1/contact` |

---

## 4. Rencana Implementasi Perubahan Frontend (`script.js`)

Perubahan minimal pada `apps/frontend/js/script.js`:
```javascript
// ponytail: Client-side fetcher diganti single call server-side pagination & filter
let currentPage = 1;
let activeAura = 'all';
let searchQuery = '';

async function fetchMedia() {
    loading.classList.remove('hidden');
    errorMessage.classList.add('hidden');
    
    try {
        const params = new URLSearchParams({
            page: currentPage,
            limit: 8,
            aura: activeAura,
            q: searchQuery
        });
        const res = await fetch(`/api/v1/media?${params}`);
        if (!res.ok) throw new Error('API Error');
        const json = await res.json();
        
        renderMediaCards(json.data);
        renderPagination(json.meta.total_pages);
    } catch (err) {
        errorMessage.textContent = 'Gagal memuat media.';
        errorMessage.classList.remove('hidden');
    } finally {
        loading.classList.add('hidden');
    }
}
```
