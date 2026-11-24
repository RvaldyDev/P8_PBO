<?php
declare(strict_types=1);

/**
 * TUGAS 1 (Individu): 
 * Mengapa Variadic PHP Tidak Sama dengan Method Overloading Tradisional.
 * 
 * Modul: Praktikum PBO Pertemuan 8 - Point H (Tugas 1)
 */

class CalculatorVariadic
{
    /**
     * SATU method dengan operator variadic (...$numbers).
     * Menerima berapapun jumlah argumen bertipe integer.
     */
    public function add(int ...$numbers): int
    {
        // PHP mengemas seluruh argumen ke dalam satu array bernama $numbers
        return array_sum($numbers);
    }
}

echo "==========================================================" . PHP_EOL;
echo "TUGAS 1: VARIADIC PHP VS OVERLOADING TRADISIONAL" . PHP_EOL;
echo "==========================================================" . PHP_EOL;

$calc = new CalculatorVariadic();

// Pemanggilan dengan 2 argumen
$hasil2 = $calc->add(10, 20);
echo "1. add(10, 20)         = " . $hasil2 . PHP_EOL;

// Pemanggilan dengan 3 argumen
$hasil3 = $calc->add(10, 20, 30);
echo "2. add(10, 20, 30)     = " . $hasil3 . PHP_EOL;

// Pemanggilan dengan 4 argumen
$hasil4 = $calc->add(10, 20, 30, 40);
echo "3. add(10, 20, 30, 40) = " . $hasil4 . PHP_EOL;

echo PHP_EOL . "--- ANALISIS KONSEPTUAL ---" . PHP_EOL;
echo "1. Pada Java/C++ (Overloading Tradisional):" . PHP_EOL;
echo "   - Terdapat BEBERAPA deklarasi method bernama sama: add(int, int) dan add(int, int, int)." . PHP_EOL;
echo "   - Compiler memilih method yang mana yang akan dieksekusi saat COMPILE-TIME berdasarkan signature." . PHP_EOL;
echo PHP_EOL;
echo '2. Pada PHP Variadic (...$numbers):' . PHP_EOL;
echo "   - Hanya ada SATU deklarasi method add() di dalam class." . PHP_EOL;
echo "   - Variasi jumlah parameter terjadi karena operator '...' mengemas semua argumen menjadi array dinamis." . PHP_EOL;
echo "   - PHP sama sekali TIDAK melakukan resolusi pemilihan method di antara beberapa deklarasi." . PHP_EOL;
echo "   - Kesimpulan: Variadic adalah fitur penanganan argumen dinamis (variadic parameters), BUKAN method overloading." . PHP_EOL;
