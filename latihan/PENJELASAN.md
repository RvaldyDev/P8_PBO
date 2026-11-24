# Dokumentasi & Penjelasan Lengkap Source Code
## Praktikum Pemrograman Berorientasi Objek (PBO) — Pertemuan 8
### Topik: Overloading dan Overriding dalam PHP (PHP 8+)

Dokumen ini berisi penjelasan baris demi baris, konsep fundamental, alur eksekusi, serta analisis mendalam yang berfokus secara eksklusif pada dua file praktikum:
1. **`overloading.php`**
2. **`overriding.php`**

---

## 📑 Daftar Isi
1. [Konsep Dasar: Overloading vs Overriding](#1-konsep-dasar-overloading-vs-overriding)
2. [Bedah Kode: `overloading.php`](#2-bedah-kode-overloadingphp)
   - [Source Code](#source-code-overloadingphp)
   - [Penjelasan Baris per Baris](#penjelasan-baris-per-baris-overloadingphp)
   - [Diagram Alur Eksekusi (Flowchart)](#diagram-alur-eksekusi-overloading)
   - [Hasil Eksekusi & Tracing Nilai](#hasil-eksekusi--tracing-nilai-overloading)
3. [Bedah Kode: `overriding.php`](#3-bedah-kode-overridingphp)
   - [Source Code](#source-code-overridingphp)
   - [Penjelasan Baris per Baris](#penjelasan-baris-per-baris-overridingphp)
   - [Diagram Struktur Hirarki Class](#diagram-struktur-hirarki-class)
   - [Hasil Eksekusi & Tracing Nilai](#hasil-eksekusi--tracing-nilai-overriding)
   - [Analisis Perilaku Pewarisan (Inheritance Fallback)](#analisis-perilaku-pewarisan-inheritance-fallback)
4. [Tabel Komparasi Fitur: Overloading vs Overriding](#4-tabel-komparasi-fitur-overloading-vs-overriding)
5. [Petunjuk Eksekusi Terminal](#5-petunjuk-eksekusi-terminal)

---

## 1. Konsep Dasar: Overloading vs Overriding

Sebelum membedah baris kode, penting untuk memahami perbedaan konseptual kedua istilah ini dalam konteks bahasa pemrograman PHP:

* **Overloading dalam PHP (Dynamic Dispatch via Magic Methods):**
  Pada bahasa seperti Java atau C++, *method overloading* berarti membuat beberapa method dengan **nama yang sama persis** tetapi memiliki jumlah atau tipe parameter yang berbeda (*signature* berbeda). Compiler akan memilih method yang cocok saat waktu kompilasi (*compile-time*).  
  **PHP tidak mendukung deklarasi method ganda dengan nama yang sama**. Jika Anda mendeklarasikan dua function bernama sama dalam satu class, PHP akan melempar fatal error (*Cannot redeclare method*). Oleh karena itu, istilah *overloading* di PHP mengacu pada kemampuan menangani pemanggilan method atau property yang **tidak dideklarasikan secara eksplisit** menggunakan *magic method*, khususnya `__call()`.

* **Overriding dalam PHP (Subtype Polymorphism via Inheritance):**
  *Method overriding* terjadi ketika subclass (*child class*) mendefinisikan ulang method yang telah ada pada superclass (*parent class*) dengan nama dan signature yang kompatibel. Ketika method dipanggil pada objek subclass, PHP akan mengeksekusi versi milik subclass tersebut saat aplikasi berjalan (*runtime polymorphism*).

---

## 2. Bedah Kode: `overloading.php`

### Source Code: `overloading.php`

```php
1: <?php
2: class Kalkulator
3: {
4:     // Dipanggil untuk method instance yang tidak tersedia/tidak dapat diakses.
5:     public function __call(string $namaMethod, array $argumen): mixed
6:     {
7:         if ($namaMethod === "tambah") {
8:             if (count($argumen) === 2) {
9:                 return $argumen[0] + $argumen[1];
10:             }
11:             if (count($argumen) === 3) {
12:                 return $argumen[0] + $argumen[1] + $argumen[2];
13:             }
14:         }
15:         throw new BadMethodCallException("Method/argumen tidak valid");
16:     }
17: }
18: 
19: $hitung = new Kalkulator();
20: echo $hitung->tambah(10, 20) . PHP_EOL;
21: echo $hitung->tambah(10, 20, 30) . PHP_EOL;
```

---

### Penjelasan Baris per Baris (`overloading.php`)

* **Baris 1 (`<?php`):**
  Tag pembuka skrip PHP standar.

* **Baris 2–3 (`class Kalkulator {`):**
  Mendeklarasikan cetak biru (*blueprint*) class bernama `Kalkulator`. Class ini dirancang untuk mendemonstrasikan bagaimana satu nama method (`tambah`) dapat memproses jumlah argumen yang berbeda secara dinamis.

* **Baris 5 (`public function __call(string $namaMethod, array $argumen): mixed`):**
  * Ini adalah **magic method** bawaan PHP. Method ini akan **secara otomatis dipicu oleh engine PHP** ketika sebuah objek memanggil method instance yang **tidak ada / tidak dideklarasikan** di dalam class tersebut.
  * **Parameter 1 (`string $namaMethod`)**: Menerima nama method yang dipanggil oleh pemanggil (misal: `"tambah"`).
  * **Parameter 2 (`array $argumen`)**: Menerima seluruh nilai argumen yang dikirimkan saat pemanggilan dalam bentuk array terindeks (misal: `[10, 20]` atau `[10, 20, 30]`).
  * **Return Type (`mixed`)**: Fitur PHP 8+ yang menandakan bahwa method dapat mengembalikan tipe data apa saja (integer, float, dsb.).

* **Baris 7 (`if ($namaMethod === "tambah") {`):**
  Melakukan validasi nama method. Kode ini memastikan bahwa logika di dalamnya hanya akan dieksekusi jika method yang dipanggil bernama persis `"tambah"`. Jika pemanggil memanggil method lain (misalnya `$hitung->kali(2, 3)`), blok ini akan dilewati dan program langsung menuju baris 15.

* **Baris 8–10:**
  ```php
  if (count($argumen) === 2) {
      return $argumen[0] + $argumen[1];
  }
  ```
  * `count($argumen)` menghitung banyaknya nilai yang dikirimkan.
  * Jika jumlah argumen adalah **2**, maka sistem mengambil elemen indeks ke-0 (`$argumen[0]`) dan indeks ke-1 (`$argumen[1]`), menjumlahkannya, lalu mengembalikan (`return`) hasilnya ke pemanggil.

* **Baris 11–13:**
  ```php
  if (count($argumen) === 3) {
      return $argumen[0] + $argumen[1] + $argumen[2];
  }
  ```
  * Jika pemanggil mengirimkan **3** bilangan, maka program menjumlahkan ketiga elemen array (`$argumen[0] + $argumen[1] + $argumen[2]`) dan mengembalikan hasilnya.

* **Baris 15 (`throw new BadMethodCallException("Method/argumen tidak valid");`):**
  Sebagai gerbang pengaman (*fail-safe guard*). Jika nama method bukan `"tambah"`, atau jika method `"tambah"` dipanggil dengan jumlah argumen di luar 2 dan 3 (misal: hanya 1 angka atau 5 angka), maka PHP akan melempar exception bawaan `BadMethodCallException` untuk mencegah perhitungan yang salah dan memberikan pesan kesalahan yang eksplisit.

* **Baris 19 (`$hitung = new Kalkulator();`):**
  Menginstansiasi class `Kalkulator` menjadi objek konkret bernama `$hitung`.

* **Baris 20 (`echo $hitung->tambah(10, 20) . PHP_EOL;`):**
  * Objek `$hitung` memanggil method `tambah(10, 20)`.
  * Karena method `tambah()` tidak pernah dideklarasikan secara konvensional di dalam class `Kalkulator`, PHP mengalihkan panggilan ini ke `__call("tambah", [10, 20])`.
  * `count($argumen)` bernilai 2, sehingga `10 + 20 = 30` dikembalikan dan dicetak ke layar.
  * `PHP_EOL` mencetak karakter pemisah baris (*End of Line*) yang kompatibel lintas sistem operasi (Linux, Windows, macOS).

* **Baris 21 (`echo $hitung->tambah(10, 20, 30) . PHP_EOL;`):**
  * Panggilan `tambah(10, 20, 30)` dialihkan ke `__call("tambah", [10, 20, 30])`.
  * `count($argumen)` bernilai 3, sehingga `10 + 20 + 30 = 60` dikembalikan dan dicetak ke layar.

---

### Diagram Alur Eksekusi (Overloading)

```
Pemanggilan: $hitung->tambah(...)
                  │
                  ▼
Apakah method tambah() terdaftar secara fisik di class Kalkulator?
                  │
                  ├─► TIDAK
                  │
                  ▼
PHP otomatis memicu magic method: __call($namaMethod, $argumen)
                  │
                  ▼
Apakah $namaMethod === "tambah"?
       │                      │
      YA                    TIDAK ──► Throw BadMethodCallException
       │
       ├─► Jika count($argumen) === 2 ──► Return arg[0] + arg[1] (30)
       ├─► Jika count($argumen) === 3 ──► Return arg[0] + arg[1] + arg[2] (60)
       └─► Selain 2 atau 3 ────────────► Throw BadMethodCallException
```

---

### Hasil Eksekusi & Tracing Nilai (`overloading.php`)

| Panggilan Baris | Parameter Dikirim | Ditangkap oleh | `count($argumen)` | Operasi | Output Terminal |
| :--- | :--- | :--- | :---: | :--- | :---: |
| Baris 20 | `(10, 20)` | `__call("tambah", [10, 20])` | `2` | `10 + 20` | **`30`** |
| Baris 21 | `(10, 20, 30)` | `__call("tambah", [10, 20, 30])` | `3` | `10 + 20 + 30` | **`60`** |

---

## 3. Bedah Kode: `overriding.php`

### Source Code: `overriding.php`

```php
1: <?php
2: // Parent class
3: class Hewan
4: {
5:     public function suara(): string
6:     {
7:         return "Hewan mengeluarkan suara";
8:     }
9: }
10: 
11: // Child class pertama
12: class Kucing extends Hewan
13: {
14:     public function suara(): string
15:     {
16:         return "Meong!";
17:     }
18: }
19: 
20: // Child class kedua
21: class Anjing extends Hewan
22: {
23:     public function suara(): string
24:     {
25:         return "Guk guk!";
26:     }
27: }
28: 
29: $hewan = new Hewan();
30: $kucing = new Kucing();
31: $anjing = new Anjing();
32: 
33: echo $hewan->suara() . PHP_EOL;
34: echo $kucing->suara() . PHP_EOL;
35: echo $anjing->suara() . PHP_EOL;
```

---

### Penjelasan Baris per Baris (`overriding.php`)

* **Baris 2–9: Deklarasi Parent Class (`Hewan`)**
  * `class Hewan`: Bertindak sebagai *superclass* (induk) yang merepresentasikan konsep umum hewan.
  * `public function suara(): string`: Method umum dengan hak akses `public` dan tipe kembalian `string`. Method ini memberikan implementasi *default*, yaitu mengembalikan teks `"Hewan mengeluarkan suara"`.

* **Baris 11–18: Deklarasi Child Class 1 (`Kucing`)**
  * `class Kucing extends Hewan`: Kata kunci `extends` menyatakan hubungan pewarisan (*inheritance*). Class `Kucing` mewarisi semua sifat dan method yang ada pada class `Hewan`.
  * `public function suara(): string`: **Inilah baris terjadinya Method Overriding**. Class `Kucing` mendeklarasikan ulang method dengan nama dan signature yang sama dengan milik parent-nya, namun mengubah perilakunya agar secara spesifik mengembalikan teks `"Meong!"`.

* **Baris 20–27: Deklarasi Child Class 2 (`Anjing`)**
  * `class Anjing extends Hewan`: Class turunan kedua yang juga mewarisi class `Hewan`.
  * `public function suara(): string`: Melakukan overriding kedua terhadap method `suara()` milik `Hewan`, disesuaikan untuk mengeluarkan teks `"Guk guk!"`.

* **Baris 29–31: Instansiasi Objek**
  * `$hewan = new Hewan();` : Membuat instance langsung dari parent class `Hewan`.
  * `$kucing = new Kucing();` : Membuat instance dari subclass `Kucing`.
  * `$anjing = new Anjing();` : Membuat instance dari subclass `Anjing`.

* **Baris 33 (`echo $hewan->suara() . PHP_EOL;`):**
  Memanggil method `suara()` pada objek `$hewan`. Karena tipe objeknya adalah `Hewan`, PHP mengeksekusi implementasi asal pada parent class, menghasilkan:  
  `Hewan mengeluarkan suara`

* **Baris 34 (`echo $kucing->suara() . PHP_EOL;`):**
  Memanggil method `suara()` pada objek `$kucing`. Karena tipe objek konkretnya adalah `Kucing`, PHP mengeksekusi method `suara()` hasil overriding milik subclass `Kucing`, menghasilkan:  
  `Meong!`

* **Baris 35 (`echo $anjing->suara() . PHP_EOL;`):**
  Memanggil method `suara()` pada objek `$anjing`. PHP mengeksekusi method hasil overriding milik subclass `Anjing`, menghasilkan:  
  `Guk guk!`

---

### Diagram Struktur Hirarki Class

```
        ┌────────────────────────────────────┐
        │            class Hewan             │  <--- (Parent Class)
        ├────────────────────────────────────┤
        │ + suara(): string                  │
        │   -> "Hewan mengeluarkan suara"    │
        └─────────────────┬──────────────────┘
                          │ extends
            ┌─────────────┴─────────────┐
            ▼                           ▼
┌───────────────────────┐   ┌───────────────────────┐
│     class Kucing      │   │     class Anjing      │  <--- (Child Classes)
├───────────────────────┤   ├───────────────────────┤
│ + suara(): string     │   │ + suara(): string     │  <--- (Overridden Method)
│   -> "Meong!"         │   │   -> "Guk guk!"       │
└───────────────────────┘   └───────────────────────┘
```

---

### Hasil Eksekusi & Tracing Nilai (`overriding.php`)

| Baris Pemanggilan | Objek Target | Tipe Class Sebenarnya | Method yang Dijalankan | Teks Output |
| :--- | :--- | :--- | :--- | :--- |
| Baris 33 | `$hewan` | `Hewan` | `Hewan::suara()` (Parent) | **`Hewan mengeluarkan suara`** |
| Baris 34 | `$kucing` | `Kucing` | `Kucing::suara()` (Override) | **`Meong!`** |
| Baris 35 | `$anjing` | `Anjing` | `Anjing::suara()` (Override) | **`Guk guk!`** |

---

### Analisis Perilaku Pewarisan (Inheritance Fallback)

> **Apa yang terjadi jika deklarasi method `suara()` pada class `Kucing` dihapus?**
>
> Jika baris 14–17 pada `overriding.php` dihapus:
> ```php
> class Kucing extends Hewan
> {
>     // kosong, tidak ada override suara()
> }
> ```
> Saat `$kucing->suara()` dipanggil, PHP akan mencari method `suara()` di dalam class `Kucing`. Karena tidak menemukannya, PHP secara otomatis menelusuri ke atas menuju class induknya (`Hewan`). Hasilnya, `$kucing->suara()` akan mengeksekusi method milik `Hewan` dan mengeluarkan teks **`"Hewan mengeluarkan suara"`**. Hal ini membuktikan bahwa *overriding* bersifat opsional untuk memperbarui perilaku, dan jika tidak di-override, perilaku default parent yang akan tetap diwariskan.

---

## 4. Tabel Komparasi Fitur: Overloading vs Overriding

| Karakteristik | `overloading.php` (Overloading) | `overriding.php` (Overriding) |
| :--- | :--- | :--- |
| **Kebutuhan Inheritance** | **Tidak memerlukan inheritance**. Cukup dalam satu class tunggal (`Kalkulator`). | **Wajib memiliki inheritance** (`extends Hewan`). Menghubungkan parent dan child class. |
| **Mekanisme Eksekusi** | Melalui **Magic Method `__call()`** saat method tidak ditemukan di class. | Melalui **Redefinisi Langsung** method pada child class dengan nama yang sama. |
| **Dasar Pemilihan Aksi** | Berdasarkan nama method dan **pemeriksaan argumen dinamis** (`count($argumen)`). | Berdasarkan **tipe objek aktual** (*Runtime/Subtype Polymorphism*). |
| **Waktu Penentuan** | *Runtime evaluation* berbasis percabangan `if/else`. | *Runtime dynamic dispatch* berbasis class instansiasi. |
| **Analogi di Java / C++** | Berbeda konsep. Java menggunakan *static signature compile-time overloading*. | Identik konsep. Java dan PHP sama-sama mengimplementasikan *method overriding* berbasis pewarisan. |

---

## 5. Petunjuk Eksekusi Terminal

Jalankan perintah berikut melalui Terminal PowerShell di Antigravity IDE atau Terminal Windows:

```powershell
# Menjalankan Praktikum 1: Overloading
php overloading.php

# Menjalankan Praktikum 2: Overriding
php overriding.php
```

*Jika variabel PATH belum dimuat ulang pada terminal yang sedang aktif, Anda dapat memanggilnya langsung dengan menyertakan path executable PHP:*
```powershell
& "D:\xampp\php\php.exe" overloading.php
& "D:\xampp\php\php.exe" overriding.php
```
