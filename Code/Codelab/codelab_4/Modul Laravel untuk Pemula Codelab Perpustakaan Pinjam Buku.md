Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Modul Laravel untuk Pemula: Codelab
Perpustakaan Pinjam Buku
Belajar dasar Laravel sambil mengerjakan codelab, langkah demi langkah, dengan cerita
yang mudah diingat.
Catatan untuk pengajar/pembaca: modul ini disusun dari Modul 4 Pemrograman
Web (Laravel 12). Kode di sini sudah dicocokkan dengan isi repo GitHub
nisrinan/CODELAB-4-WEB (nama kolom, nama method, dan nomor TODO). Isi
komentar   (nomor 1 sampai 7) dikerjakan satu per satu di Bab 2 sampai Bab 6,
TODO
lihat peta di bawah.
Peta TODO di repo (urutan pengerjaan)
| TODO | File | Dikerjakan di |
| ---- | ---- | ------------- |
| 1    |      | Bab 2         |
database/migrations/2026_08_10_043505_creat
e_members_table.php
| 2 dan 3 | app/Models/Member.php                     | Bab 3 |
| ------- | ----------------------------------------- | ----- |
| (route) | routes/api.php                            | Bab 4 |
| 4 dan 5 | app/Http/Controllers/MemberController.php | Bab 5 |
| 7       | app/Http/Resources/MemberResource.php     | Bab 6 |
Cara memakai modul ini
1. Kerjakan berurutan, jangan loncat.
2. Setiap bab punya: Cerita (supaya paham), Praktik (supaya bisa), dan Ingat! (supaya
tidak lupa).
3. Di akhir setiap bab ada Cek diri. Kalau belum bisa menjawab, baca ulang bab itu.
Page 1 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Bab 0. Cerita Besar: Perpustakaan Sekolah
Bayangkan kamu membangun sistem perpustakaan sekolah. Anggota (Member) boleh
meminjam dan mengembalikan buku (Book).
Laravel itu seperti perpustakaan yang punya petugas dengan tugasnya masing-masing:
Bagian Di perpustakaan Tugasnya
Laravel
Migration Denah rak buku Menentukan bentuk tabel (rak) di database
Model Petugas gudang Mengambil dan menyimpan data ke tabel
Route Papan petunjuk / pintu Menentukan alamat (URL) menuju petugas
masuk yang tepat
Controller Pustakawan Mengerjakan permintaan: pinjam, kembali,
dan lain-lain
Resource Kemasan / sampul Merapikan data sebelum diberikan ke
peminta
Jurus mengingat urutan kerja
"Tiap Murid Rajin Coding Rutin"
Tabel (Migration) → Model → Route → Controller → Resource
Setiap kali bingung mau mulai dari mana, ucapkan kalimat itu.
Perjalanan satu permintaan
Bayangkan Budi (Member nomor 1) mau meminjam buku nomor 5:
1. Budi mengirim permintaan lewat Postman ke alamat /api/members/1/borrow-book .
2. Route membaca alamat itu dan berkata: "Ke Pustakawan, bagian borrowBook!"
3. Controller (Pustakawan) memeriksa: bukunya ada? Sedang dipinjam atau tidak?
4. Model (Petugas gudang) mengambil dan mengubah data di tabel.
5. Resource merapikan jawaban.
6. Jawaban kembali ke Budi dalam bentuk JSON.
Page 2 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Ingat! Permintaan selalu lewat: Route → Controller → Model → database, lalu jawaban
kembali lewat Resource.
Cek diri: Siapa yang menentukan alamat (URL)? Siapa yang mengerjakan logika pinjam?
Siapa yang mengurus data di tabel?
Bab 1. Persiapan Alat
Cerita
Sebelum membuka perpustakaan, kita butuh gedung dan listrik. Di dunia coding: PHP,
Composer, MySQL, dan Postman.
Alat Fungsi singkat
PHP 8.2+ Bahasa yang dipakai Laravel
Composer Pengunduh paket (seperti toko aplikasi untuk PHP)
Laragon / XAMPP Menyalakan MySQL (database)
VS Code Tempat menulis kode
Postman Alat untuk mengirim permintaan dan melihat
jawaban API
Praktik: menyiapkan project codelab
Urutkan langkah ini persis:
Langkah 1. Nyalakan MySQL. Di Laragon klik Start All. Di XAMPP aktifkan modul MySQL.
Langkah 2. Buat database kosong lewat HeidiSQL atau phpMyAdmin. Laravel tidak
membuatnya otomatis. Beri nama misalnya perpustakaan .
Langkah 3. Clone repo dari GitHub, lalu masuk ke foldernya: git clone
https://github.com/nisrinan/CODELAB-4-WEB.git lalu cd CODELAB-4-WEB.
Langkah 4. Salin file pengaturan:
cp .env.example .env
Langkah 5. Buka .env , sesuaikan bagian database:
Page 3 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan
DB_USERNAME=root
DB_PASSWORD=
Langkah 6. Jalankan dua perintah ini berurutan (perintah ketiga, migrate --seed, menyusul
di Bab 2):
composer install
php artisan key:generate
Langkah 7. Nyalakan server:
php artisan serve
Buka http://127.0.0.1:8000 . Kalau muncul halaman Laravel, berhasil.
Kalau ada masalah
Masalah Obat
Data member dobel karena seeder kejalan php artisan migrate:fresh --seed
berkali-kali
Sudah ganti .env tapi tidak berpengaruh php artisan config:clear
Error koneksi database Cek MySQL sudah menyala dan nama
database sama dengan di .env
Ingat! Urutan emas: database dibuat → .env diisi → composer install → key:generate →
lengkapi migration members → migrate --seed.
Cek diri: Kenapa kita butuh --seed ? (Jawab: supaya tabel members ada isinya, sehingga
ada {id} member untuk diuji.)
Page 4 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Bab 2. Migration: Denah Rak Buku
Cerita
Sebelum menaruh buku, kamu butuh rak. Migration adalah gambar denah rak yang ditulis
dengan kode: kolom apa saja yang ada di tabel.
Contoh denah tabel books :
Schema::create('books', function (Blueprint $table) {
$table->id(); // nomor urut otomatis
$table->string('title'); // judul buku
$table->string('author'); // penulis buku
$table->boolean('is_available')->default(true); // ada di rak?
$table->foreignId('member_id')->nullable()->constrained(); // dipinjam
siapa?
$table->timestamps(); // kapan dibuat dan diubah
});
Baca per baris seperti membaca label rak:
id() → nomor buku, naik sendiri.
string('title') → judul, berupa teks pendek. Kolom author (penulis) dibuat dengan
cara yang sama.
boolean('is_available') → hanya benar/salah. true = ada di rak, false = sedang
dipinjam.
foreignId('member_id') → kartu pengikat ke tabel members. Isinya nomor
peminjam.
nullable() → boleh kosong. Buku yang belum dipinjam belum punya peminjam, jadi
member_id kosong ( null ).
constrained() → Laravel otomatis tahu ini terhubung ke tabel members .
Praktik
Buka folder database/migrations , lihat migration tabel books dan members . Cocokkan
dengan contoh di atas.
Tugas TODO 1. Buka
database/migrations/2026_08_10_043505_create_members_table.php . Tabel members
di sana baru punya id() dan timestamps() . Tambahkan satu baris di tempat komentar
TODO 1:
Page 5 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
$table->string('name');
Tanpa baris ini, seeder gagal karena ia mengisi kolom name , sedangkan tabel members
belum punya kolom itu.
Catatan: seeder hanya membuat 2 member ( Alip Presiden Zimbabwe dan Another
Member ). Tabel books sengaja dikosongkan, jadi bukunya nanti kamu buat sendiri lewat
Postman di Bab 7.
Menjalankan semua denah sekaligus, lalu mengisi dua member contoh dari seeder:
php artisan migrate --seed
Dua aturan emas migration
1. Migration yang sudah dijalankan jangan diedit lalu dijalankan lagi. Laravel hanya
melihat nama file, bukan isinya, sehingga muncul "Nothing to migrate".
2. Kalau data boleh hilang (masih latihan): pakai php artisan migrate:fresh . Kalau
data penting: buat migration baru.
Ingat! Migration = denah. Ubah denah → migrate:fresh (latihan) atau migration baru
(data penting).
Cek diri: Apa arti nullable() pada member_id ? Kapan nilainya null ?
Bab 3. Model dan Relasi: Petugas Gudang yang Tahu Hubungan
Cerita
Rak sudah ada. Sekarang butuh petugas gudang yang tahu cara mengambil dan
menyimpan buku. Itulah Model. Model Book mewakili tabel books , model Member
mewakili tabel members . Kamu tidak perlu menulis SQL, cukup Book::all() .
Hubungan antar tabel (Relasi)
Aturan di perpustakaan kita:
Satu member bisa meminjam banyak buku.
Satu buku hanya sedang dipinjam oleh satu member.
Di Laravel ditulis begini. Mudah diingat dengan "punya banyak" dan "milik satu":
Page 6 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
// app/Models/Member.php  -> Member PUNYA BANYAK buku
public function books()
{
    return $this->hasMany(Book::class);
}
// app/Models/Book.php    -> Buku MILIK satu member
public function member()
{
    return $this->belongsTo(Member::class);
}
| Kata      | Artinya      | Dipasang di model yang... |     |     |           |           |
| --------- | ------------ | ------------------------- | --- | --- | --------- | --------- |
|           | punya banyak | tidak menyimpan kolom     |     |     |           |  (Member) |
| hasMany   |              |                           |     |     | member_id |           |
| belongsTo | milik satu   | menyimpan kolom           |     |     | member_id |  (Book)   |
Trik ingat: yang membawa kartu member_id adalah yang belongsTo (milik). Si pemilik
kartu = Book.
fillable: daftar yang boleh diisi
// Book.php (sudah lengkap)
protected $fillable = ['title', 'author', 'is_available', 'member_id'];
// Member.php (TODO 2: kamu yang mengisi)
protected $fillable = ['name'];
fillable  itu daftar tamu yang boleh masuk. Kolom yang tidak ada di daftar ditolak saat
| disimpan massal ( | create() |  atau  | update() | ).  |     |     |
| ----------------- | -------- | ------ | -------- | --- | --- | --- |
Praktik
| Buka  |     |  (sudah lengkap, jadikan contoh). Di dalamnya ada juga |     |     |     |     |
| ----- | --- | ------------------------------------------------------ | --- | --- | --- | --- |
app/Models/Book.php
$casts  yang membuat  is_available  selalu tampil sebagai  true  atau  false , bukan 1
atau 0. Lalu buka  app/Models/Member.php  dan kerjakan dua TODO:
| TODO 2: isi  | $fillable |  dengan  | ['name'] |     | .   |     |
| ------------ | --------- | -------- | -------- | --- | --- | --- |
TODO 3: isi method  books()  dengan  return $this->hasMany(Book::class); .
Jangan lupa kata  return , kalau lupa relasinya kosong dan nanti error.
Page 7 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Ingat! Member hasMany Book. Book belongsTo Member. Kartu  member_id  ada di Book.
Cek diri: Di tabel mana kolom  member_id  berada? Model mana yang memakai
| belongsTo | ?   |     |
| --------- | --- | --- |
Bab 4. Route: Papan Petunjuk
Cerita
Tamu perlu papan petunjuk: "Mau pinjam buku? Lewat sini." Route menghubungkan
alamat URL + jenis permintaan ke tujuan di Controller.
Jenis permintaan (HTTP method)
| Method | Artinya        | Contoh di perpustakaan |
| ------ | -------------- | ---------------------- |
| GET    | Minta lihat    | Lihat data member      |
| POST   | Kirim hal baru | Pinjam buku            |
| PATCH  | Ubah sebagian  | Kembalikan buku        |
| DELETE | Hapus          | Hapus data             |
Jurus ingat: GET = lihat, POST = tambah, PATCH = ubah, DELETE = hapus.
Aktifkan jalur API (sekali saja)
Laravel 12 tidak membuat   otomatis. Di repo codelab file itu sudah ada,
routes/api.php
jadi kamu tidak perlu menjalankannya. Perintah ini hanya dipakai kalau kamu membuat
project Laravel baru dari nol:
php artisan install:api
Route yang sudah ada dan yang harus kamu tambah
Baris ini sudah tersedia di codelab. Satu baris langsung membuat lima jalur CRUD:
Route::apiResource('books', BookController::class);
Route::apiResource('members', MemberController::class);
Page 8 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Tapi borrowBook dan returnBook tidak ikut. Tambahkan sendiri:
Route::post('/members/{member}/borrow-book', [MemberController::class,
'borrowBook']);
Route::patch('/members/{member}/return-book/{book}',
[MemberController::class, 'returnBook']);
Bagian {member} dan {book} adalah kotak kosong yang diisi angka saat permintaan
dikirim. Misalnya /members/1/borrow-book , maka {member} = 1. Nama di dalam kurung
kurawal harus sama dengan nama variabel di Controller ( $member dan $book ). Karena
Controller memakai Member $member , Laravel otomatis mencari member itu dan
menjawab 404 kalau tidak ada. Fitur ini disebut Route Model Binding.
Praktik: cek papan petunjuk
php artisan route:list
Pastikan borrow-book dan return-book muncul dengan awalan api/ . Kalau tidak
muncul, kemungkinan install:api belum dijalankan atau route salah ketik.
Ingat! Rute tambahan tidak ikut apiResource , jadi tulis manual, lalu cek dengan
route:list.
Cek diri: Kenapa meminjam memakai POST dan mengembalikan memakai PATCH?
Bab 5. Controller: Pustakawan yang Bekerja
Cerita
Pustakawan menerima permintaan dan memutuskan: boleh pinjam, atau ditolak? Itu tugas
Controller. Di MemberController ada dua pekerjaan baru: borrowBook dan returnBook .
Pekerjaan 1: borrowBook (meminjam)
Pustakawan harus berpikir dengan tiga pertanyaan:
1. Bukunya ada? Sudah diurus oleh validate yang disediakan di codelab: kalau
book_id tidak ada di tabel, otomatis dijawab 422.
2. Bukunya sedang dipinjam? Kalau ya, tolak dengan 409.
3. Kalau aman, tandai dipinjam dan catat siapa peminjamnya.
Page 9 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
public function borrowBook(Request $request, Member $member)
{
$request->validate([
'book_id' => 'required|exists:books,id',
]);
// TODO: cari Book berdasarkan $request->book_id
$book = Book::findOrFail($request->book_id);
// TODO: cek apakah buku masih tersedia (is_available)
if (!$book->is_available) {
return response()->json(['message' => 'Buku sedang dipinjam'], 409);
}
// TODO: update Book -> hubungkan ke member ini dan tandai tidak tersedia
$book->update([
'member_id' => $member->id,
'is_available' => false,
]);
// TODO: kembalikan response JSON
return response()->json(['message' => 'Buku berhasil dipinjam']);
}
Perhatikan parameternya: Member $member , bukan $id . Laravel otomatis mencari
member dari angka di URL. Book dan Member sudah di- use di bagian atas file, jadi tidak
perlu ditambah lagi.
Cerita seru: dua orang rebutan satu buku
Budi dan Sari menekan tombol "pinjam" di detik yang sama untuk buku yang sama.
Tanpa pengaman:
1. Budi melihat: tersedia.
2. Sari melihat: tersedia (Budi belum sempat mengubahnya).
3. Budi menyimpan: dipinjam.
4. Sari menyimpan: dipinjam.
Hasil: satu buku fisik, tapi tercatat dipinjam dua orang. Ini disebut race condition
(balapan). Dan ini tidak kelihatan saat kamu mengetes sendirian di Postman.
Pengamannya ada dua:
Page 10 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Alat Seperti apa? Fungsi
DB::transaction() Kantong Semua langkah jadi satu paket. Kalau gagal,
bungkusan semuanya dibatalkan
lockForUpdate() Gembok di rak Selama Budi memegang buku, Sari harus
menunggu di luar
Setelah Budi selesai, Sari masuk, melihat buku sudah dipinjam, lalu ditolak dengan 409.
Adil.
Versi aman (disarankan Bab 4.4 modul). Versi sederhana di atas sudah membuat alurnya
jalan, tapi masih rawan balapan. Kalau mau lebih aman, ganti isi method dengan versi ini
dan tambahkan use Illuminate\Support\Facades\DB; di bagian atas file:
public function borrowBook(Request $request, Member $member)
{
$request->validate([
'book_id' => 'required|exists:books,id',
]);
return DB::transaction(function () use ($request, $member) {
$book = Book::where('id', $request->book_id)
->lockForUpdate()
->firstOrFail();
if (!$book->is_available) {
return response()->json(['message' => 'Buku sedang dipinjam'],
409);
}
$book->update([
'member_id' => $member->id,
'is_available' => false,
]);
return response()->json(['message' => 'Buku berhasil dipinjam']);
});
}
Ingat! Kalau polanya baca → periksa → ubah pada data yang sama, pakai kantong
(transaction) + gembok (lockForUpdate).
Page 11 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Pekerjaan 2: returnBook (mengembalikan)
Kebalikan dari meminjam: buku tersedia lagi dan tidak punya peminjam. Sebaiknya periksa
dulu bahwa buku itu memang sedang dipinjam oleh member yang sama.
public function returnBook(Member $member, Book $book)
{
// TODO: cek apakah $book->member_id sama dengan $member->id
if ($book->member_id != $member->id) {
return response()->json(['message' => 'Buku ini tidak sedang dipinjam
oleh member ini'], 409);
}
// TODO: update Book -> lepaskan relasi dan tandai tersedia kembali
$book->update([
'member_id' => null,
'is_available' => true,
]);
// TODO: kembalikan response JSON
return response()->json(['message' => 'Buku berhasil dikembalikan']);
}
Baris if ($book->member_id != $member->id) adalah pemeriksaan kartu anggota: hanya
peminjam asli yang boleh mengembalikan. Kalau tidak cocok, jawabannya 409. Member
dan buku diambil otomatis lewat Route Model Binding, jadi kalau ID-nya tidak ada, hasilnya
404.
Praktik
Buka app/Http/Controllers/MemberController.php . Method index dan show sudah
lengkap. Kerjakan TODO 4 ( borrowBook ) dan TODO 5 ( returnBook ) sesuai kode di atas.
Di setiap method ada beberapa komentar TODO kecil, isi tepat di bawah komentarnya.
Cek diri: Apa bedanya kode 404 dan 409? Apa gunanya lockForUpdate() ?
Page 12 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Bab 6. Resource: Kemasan yang Rapi
Cerita
Bayangkan kamu memberi hadiah. Isinya sama, tapi dibungkus rapi lebih enak. API
Resource membungkus data supaya format JSON selalu sama dan rapi, apa pun isi
database-nya.
// app/Http/Resources/MemberResource.php
public function toArray(Request $request): array
{
return [
'id' => $this->id,
'name' => $this->name,
'books' => BookResource::collection($this->whenLoaded('books')),
];
}
Apa itu whenLoaded?
whenLoaded('books') artinya: "Tampilkan daftar buku hanya kalau sudah dibawa dari
gudang." Kalau belum, bagian books tidak muncul, jadi tidak ada permintaan database
yang sia-sia.
Untuk membawa buku dari gudang, di Controller pakai load() atau with() :
public function show(Member $member)
{
return new MemberResource($member->load('books'));
}
with('books') = bawa buku sejak mengambil member (cocok untuk daftar banyak
member).
load('books') = bawa buku setelah member sudah ada di tangan.
Jurus ingat: with = "dari awal", load = "menyusul". Keduanya disebut eager loading.
Praktik
Buka BookResource.php (sudah lengkap), lihat cara memakai whenLoaded . Lalu lengkapi
MemberResource.php (TODO 7): tambahkan name dan books . Method index dan show
di MemberController sudah memakai with('books') dan load('books') , jadi tidak
Page 13 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
perlu diubah. Bedanya dengan BookResource: di sana relasinya satu data ( member ), di sini
banyak data, makanya dipakai BookResource::collection(...) .
Ingat! whenLoaded hanya menampilkan relasi. Yang memuat relasi adalah with() atau
load() .
Cek diri: Kalau lupa menulis load('books') , apa yang terjadi pada JSON member?
Bab 7. Uji Coba di Postman: Hari Pembukaan
Cerita
Saatnya perpustakaan dibuka. Kita mengirim permintaan dan memeriksa jawabannya.
Pastikan php artisan serve masih berjalan. Alamat dasarnya http://127.0.0.1:8000 .
Alur wajib (sama dengan penilaian)
Uji 0. Membuat buku dulu (jangan dilewati!) Seeder hanya mengisi member, jadi tabel
books masih kosong.
Method: POST
URL: http://127.0.0.1:8000/api/books
Body, pilih raw lalu JSON:
{ "title": "Laskar Pelangi", "author": "Andrea Hirata" }
Harapannya: status 201 dan buku punya id (buku pertama biasanya 1). Catat id-nya,
dipakai di uji berikutnya.
Uji 1. Meminjam buku
Method: POST
URL: http://127.0.0.1:8000/api/members/1/borrow-book
Body → raw → JSON:
{ "book_id": 1 }
Harapannya: pesan "Buku berhasil dipinjam". Untuk membuktikan bukunya sudah ditandai
dipinjam, buka GET /api/books/1 : is_available menjadi false dan muncul data
member .
Page 14 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Uji 2. Melihat member beserta bukunya
| Method:  | GET |     |     |     |     |
| -------- | --- | --- | --- | --- | --- |
URL:
http://127.0.0.1:8000/api/members/1
Harapannya: data member dengan daftar buku yang sedang dipinjam.
Uji 3. Mengembalikan buku
| Method:                                                 | PATCH |     |     |     |     |
| ------------------------------------------------------- | ----- | --- | --- | --- | --- |
| URL:  http://127.0.0.1:8000/api/members/1/return-book/1 |       |     |     |     |     |
Harapannya: pesan "Buku berhasil dikembalikan". Cek lagi di  GET /api/books/1 :
| is_available |  kembali  | true  dan  | member  menjadi  | null . |     |
| ------------ | --------- | ---------- | ---------------- | ------ | --- |
Uji gagal (jangan dilewat!)
| Skenario                  |     |     | Cara         |     | Harapan          |
| ------------------------- | --- | --- | ------------ | --- | ---------------- |
| Pinjam buku yang sama dua |     |     | Ulangi Uji 1 |     | 409 "Buku sedang |
| kali                      |     |     |              |     | dipinjam"        |
Pinjam buku yang tidak ada book_id  = 9999 422 (ditolak  validate
bawaan codelab)
| Member tidak ada |     |     |     |     | 404 |
| ---------------- | --- | --- | --- | --- | --- |
/members/9999/borrow-
book
| Kembalikan buku yang bukan |     |     | Pakai member lain (id 2) |     | 409 |
| -------------------------- | --- | --- | ------------------------ | --- | --- |
milik member itu
| Kembalikan buku yang tidak |     |     |     |     | 404 |
| -------------------------- | --- | --- | --- | --- | --- |
/members/1/return-
| ada |     |     | book/9999 |     |     |
| --- | --- | --- | --------- | --- | --- |
Tips Postman: tambahkan header  Accept: application/json  supaya error muncul
dalam bentuk JSON, bukan halaman HTML.
Bab 8. Kamus Kode Status
Kode status adalah lampu tanda dari pustakawan:
Page 15 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Kode Seperti... Artinya
200 Jempol Berhasil
201 Jempol + hadiah Berhasil membuat data baru
404 "Buku tidak ditemukan" Data dengan ID itu tidak ada
409 "Maaf, sudah dipinjam orang" Permintaan benar, tapi bentrok dengan kondisi
data
422 "Formulirmu belum lengkap" Validasi input gagal
Trik ingat 4xx: 404 = tidak ketemu, 409 = bentrok, 422 = isian salah.
Bab 9. Kartu Contekan dan Kesalahan Umum
Kartu contekan perintah
| Perintah            | Gunanya                  |     |
| ------------------- | ------------------------ | --- |
| php artisan serve   | Menyalakan server        |     |
| php artisan migrate | Membuat tabel dari denah |     |
php artisan migrate:fresh --seed Ulang dari nol + isi data contoh
| php artisan route:list      | Melihat semua papan petunjuk |      |
| --------------------------- | ---------------------------- | ---- |
| php artisan config:clear    | Membersihkan ingatan lama    | .env |
| php artisan make:model Nama | Membuat model                |      |
php artisan make:controller NamaController Membuat controller
Page 16 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Kesalahan yang paling sering terjadi
| Gejala            |        | Penyebab           |     | Obat        |             |
| ----------------- | ------ | ------------------ | --- | ----------- | ----------- |
| route:list        |  tidak | Belum  install:api |     | Jalankan    | php artisan |
| menampilkan route |        |                    |     | install:api |             |
API
404 padahal data ada URL salah, lupa awalan  /api Cek  route:list
"Nothing to migrate" Migration lama tidak dibaca ulang migrate:fresh
setelah edit migration
Error koneksi Database belum dibuat atau MySQL Buat database, nyalakan
| database          |     | mati                |       | MySQL     |     |
| ----------------- | --- | ------------------- | ----- | --------- | --- |
| JSON member tanpa |     | Lupa  load('books') |  atau | Tambahkan |     |
| daftar buku       |     | with('books')       |       |           |     |
Data member dobel Seeder kejalan berkali-kali migrate:fresh --seed
| Class DB not |     | Lupa  use                      |     | Tambahkan di atas file |     |
| ------------ | --- | ------------------------------ | --- | ---------------------- | --- |
| found        |     | Illuminate\Support\Facades\DB; |     |                        |     |
migrate --seed error: TODO 1 (kolom name di migration Isi kolom name, lalu
Unknown column members) belum diisi jalankan migrate:fresh --
| name |     |     |     | seed |     |
| ---- | --- | --- | --- | ---- | --- |
Ringkasan satu halaman
"Tiap Murid Rajin Coding Rutin"
Tabel (Migration): denah rak
Model: petugas gudang. Member hasMany Book, Book belongsTo Member
Route: papan petunjuk. Tambahan ditulis manual, cek dengan
route:list
Controller: pustakawan. Pinjam = kantong + gembok. Kode 404 / 409
| Resource: kemasan rapi.  |     | whenLoaded |  +  load() |     |     |
| ------------------------ | --- | ---------- | ---------- | --- | --- |
Page 17 of 18

Modul Laravel untuk Pemula: Codelab Perpustakaan Pinjam Buku
Kuis Akhir (jawab tanpa membuka modul)
1. Sebutkan urutan kerja membuat fitur baru di Laravel.
2. Kolom  member_id  ada di tabel apa, dan relasi apa yang dipakai di model itu?
| 3. Kenapa       | borrow-book |  memakai     | lockForUpdate() | ?   |
| --------------- | ----------- | ------------ | --------------- | --- |
| 4. Apa bedanya  | with()      |  dan  load() | ?               |     |
5. Kode apa yang dikirim jika buku sedang dipinjam orang lain?
6. Perintah apa untuk melihat semua route?
| 7. Kenapa melakukan  |     |     |  bisa berbahaya di aplikasi sungguhan? |     |
| -------------------- | --- | --- | -------------------------------------- | --- |
migrate:fresh
Kunci jawaban
1. Tabel → Model → Route → Controller → Resource.
| 2. Tabel  | ; model Book memakai  |     |           | .   |
| --------- | --------------------- | --- | --------- | --- |
|           | books                 |     | belongsTo |     |
3. Supaya dua permintaan tidak bisa meminjam buku yang sama bersamaan (mencegah
race condition).
4.   memuat relasi saat mengambil data utama,   memuat setelah data
| with() |     |     |     | load() |
| ------ | --- | --- | --- | ------ |
utama sudah ada.
5.  os.
| 6.  |     | .   |     |     |
| --- | --- | --- | --- | --- |
php artisan route:list
7. Karena menghapus semua tabel dan datanya.
Tantangan Bonus (untuk yang sudah selesai)
1. Tambahkan pemeriksaan: satu member maksimal meminjam 3 buku. Kode apa yang
cocok untuk penolakan?
2. Tambahkan kolom  borrowed_at  (tanggal pinjam) lewat migration baru, bukan dengan
mengedit yang lama.
3. Buat endpoint  GET /api/books?title=...  untuk mencari buku berdasarkan judul.
Selamat! Kalau semua uji di Bab 7 berhasil, kamu sudah membangun REST API sungguhan.
Page 18 of 18