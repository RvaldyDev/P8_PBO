<?php
declare(strict_types=1);

/**
 * TUGAS 4 (Individu):
 * Menjelaskan dan mendemonstrasikan dampak:
 * 1. final
 * 2. private
 * 3. Signature yang tidak kompatibel (parameter/return type/visibility)
 * pada mekanisme Overriding di PHP.
 * 
 * Modul: Praktikum PBO Pertemuan 8 - Point H (Tugas 4) & Point D.3 / Contoh 5
 */

echo "==========================================================" . PHP_EOL;
echo "TUGAS 4: ATURAN OVERRIDING (FINAL, PRIVATE, & SIGNATURE)" . PHP_EOL;
echo "==========================================================" . PHP_EOL;

// -----------------------------------------------------------------------------
// 1. DAMPAK KEYWORD 'final'
// -----------------------------------------------------------------------------
echo "--- 1. DAMPAK KEYWORD 'final' ---" . PHP_EOL;
class BaseReport
{
    // Method ini ditandai 'final', artinya terkunci dan DILARANG di-override oleh subclass
    final public function getSecurityHash(): string
    {
        return "SEC-HASH-9988";
    }

    public function generate(): string
    {
        return "Laporan Standar";
    }
}

class CustomReport extends BaseReport
{
    // Override method biasa diperbolehkan:
    public function generate(): string
    {
        return "Laporan Kustom Khusus";
    }

    // JIKA baris di bawah ini diaktifkan, PHP akan menghasilkan FATAL ERROR:
    // "Fatal error: Cannot override final method BaseReport::getSecurityHash()"
    /*
    public function getSecurityHash(): string
    {
        return "HASH-PALSU";
    }
    */
}

$report = new CustomReport();
echo "getSecurityHash() [Final dari Parent] : " . $report->getSecurityHash() . PHP_EOL;
echo "generate() [Overridden di Child]       : " . $report->generate() . PHP_EOL;
echo "Dampak: Keyword 'final' menjamin integritas logika penting agar tidak dimodifikasi oleh subclass." . PHP_EOL;

// -----------------------------------------------------------------------------
// 2. DAMPAK VISIBILITY 'private'
// -----------------------------------------------------------------------------
echo PHP_EOL . "--- 2. DAMPAK VISIBILITY 'private' ---" . PHP_EOL;
class Induk
{
    // Method private HANYA dapat diakses oleh class Induk sendiri
    private function rahasia(): string
    {
        return "Rahasia Milik Induk";
    }

    public function panggilRahasia(): string
    {
        return $this->rahasia();
    }
}

class Anak extends Induk
{
    // Ini BUKAN overriding! Ini adalah method baru yang kebetulan memiliki nama sama.
    // Class Anak tidak mewarisi method private dari Induk.
    public function rahasia(): string
    {
        return "Rahasia Milik Anak";
    }
}

$anak = new Anak();
echo "Panggilan dari method Anak   : " . $anak->rahasia() . PHP_EOL;
echo "Panggilan via internal Induk : " . $anak->panggilRahasia() . PHP_EOL;
echo "Dampak: Method 'private' TIDAK diwariskan dan TIDAK mengalami polymorphic overriding." . PHP_EOL;

// -----------------------------------------------------------------------------
// 3. DAMPAK SIGNATURE YANG TIDAK KOMPATIBEL
// -----------------------------------------------------------------------------
echo PHP_EOL . "--- 3. DAMPAK SIGNATURE TIDAK KOMPATIBEL ---" . PHP_EOL;
class LayananInduk
{
    // Mengharuskan parameter int dan mengembalikan string
    public function proses(int $id): string
    {
        return "Memproses ID: {$id}";
    }
}

class LayananAnakKompatibel extends LayananInduk
{
    // Signature KOMPATIBEL (Tipe parameter sama, tipe return sama, visibility sama)
    public function proses(int $id, string $catatan = ""): string
    {
        return "Anak memproses ID: {$id} dengan catatan: {$catatan}";
    }
}

$layanan = new LayananAnakKompatibel();
echo $layanan->proses(101, "Selesai cepat") . PHP_EOL;

echo "Dampak Inkompatibilitas:" . PHP_EOL;
echo "- Mengurangi visibilitas (misal public diubah menjadi protected/private) -> FATAL ERROR." . PHP_EOL;
echo "- Mengubah return type menjadi tidak kompatibel (misal string diubah ke int) -> FATAL ERROR." . PHP_EOL;
echo "- Menambah parameter wajib baru tanpa default value -> FATAL ERROR." . PHP_EOL;
echo "Aturan ini menerapkan LSP (Liskov Substitution Principle) agar objek child selalu aman menggantikan parent." . PHP_EOL;
