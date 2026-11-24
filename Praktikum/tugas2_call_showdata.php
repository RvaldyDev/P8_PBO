<?php
declare(strict_types=1);

/**
 * TUGAS 2 (Individu):
 * Modifikasi __call() agar menerima showData(id, name, major) dengan validasi 3 string;
 * pemanggilan lain harus menghasilkan exception.
 * 
 * Modul: Praktikum PBO Pertemuan 8 - Point H (Tugas 2)
 */

class StudentPresenter
{
    /**
     * Magic method __call() dengan validasi ketat
     * 
     * @param string $name Nama method yang dipanggil
     * @param array $args  Daftar argumen yang dikirim
     * @return string
     * @throws BadMethodCallException Jika method bukan 'showData'
     * @throws InvalidArgumentException Jika argumen tidak sesuai tipe/jumlah
     */
    public function __call(string $name, array $args): string
    {
        // Validasi nama method: Hanya mendukung 'showData'
        if ($name !== 'showData') {
            throw new BadMethodCallException("Unknown method: {$name}");
        }

        $argCount = count($args);

        // Pola 1: showData(name) -> 1 argumen string
        if ($argCount === 1 && is_string($args[0])) {
            return "Name: {$args[0]}";
        }

        // Pola 2: showData(id, name) -> 2 argumen string
        if ($argCount === 2 && is_string($args[0]) && is_string($args[1])) {
            return "ID: {$args[0]}, Name: {$args[1]}";
        }

        // Pola 3 [TUGAS 2]: showData(id, name, major) -> 3 argumen string
        if ($argCount === 3 && is_string($args[0]) && is_string($args[1]) && is_string($args[2])) {
            return "ID: {$args[0]}, Name: {$args[1]}, Major: {$args[2]}";
        }

        // Jika jumlah argumen bukan 1, 2, 3 atau ada tipe data yang bukan string
        throw new InvalidArgumentException(
            "Expected 1, 2, or 3 string arguments for showData(). Given {$argCount} arguments."
        );
    }
}

echo "==========================================================" . PHP_EOL;
echo "TUGAS 2: MODIFIKASI __call() DENGAN VALIDASI 3 STRING" . PHP_EOL;
echo "==========================================================" . PHP_EOL;

$view = new StudentPresenter();

// 1. Uji Coba Positif: 1 Argumen String
echo "[Positif 1] " . $view->showData("Ahmad") . PHP_EOL;

// 2. Uji Coba Positif: 2 Argumen String
echo "[Positif 2] " . $view->showData("2026001", "Ahmad") . PHP_EOL;

// 3. Uji Coba Positif: 3 Argumen String (TUGAS 2)
echo "[Positif 3] " . $view->showData("2026001", "Ahmad", "Informatika") . PHP_EOL;

echo PHP_EOL . "--- PENGUJIAN NEGATIF (EXCEPTION HANDLING) ---" . PHP_EOL;

// 4. Uji Coba Negatif: showData() tanpa argumen
try {
    echo "Menjalankan \$view->showData() tanpa argumen..." . PHP_EOL;
    $view->showData();
} catch (InvalidArgumentException $e) {
    echo "-> [TERTANGKAP InvalidArgumentException]: " . $e->getMessage() . PHP_EOL;
}

// 5. Uji Coba Negatif: showData(id, name, major) dengan tipe integer (bukan string)
try {
    echo "Menjalankan \$view->showData('2026001', 'Ahmad', 12345)..." . PHP_EOL;
    $view->showData("2026001", "Ahmad", 12345);
} catch (InvalidArgumentException $e) {
    echo "-> [TERTANGKAP InvalidArgumentException]: " . $e->getMessage() . PHP_EOL;
}

// 6. Uji Coba Negatif: Pemanggilan method tidak dikenal
try {
    echo "Menjalankan \$view->getProfile('Ahmad')..." . PHP_EOL;
    $view->getProfile("Ahmad");
} catch (BadMethodCallException $e) {
    echo "-> [TERTANGKAP BadMethodCallException]: " . $e->getMessage() . PHP_EOL;
}
