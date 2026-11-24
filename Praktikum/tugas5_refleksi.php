<?php
declare(strict_types=1);

/**
 * TUGAS 5 (Refleksi):
 * Kapan sebaiknya memakai:
 * 1. Method Biasa
 * 2. Overriding
 * 3. __call() (Overloading PHP)
 * dalam aplikasi nyata?
 * 
 * Modul: Praktikum PBO Pertemuan 8 - Point H (Tugas 5)
 */

echo "==========================================================" . PHP_EOL;
echo "TUGAS 5: PANDUAN KEPUTUSAN ARSITEKTUR APLIKASI NYATA" . PHP_EOL;
echo "==========================================================" . PHP_EOL;

echo "1. METHOD BIASA (REGULAR METHOD):" . PHP_EOL;
echo "   Kapan Digunakan:" . PHP_EOL;
echo "   - Digunakan sebagai PILIHAN UTAMA (Default Choice - 90% kasus)." . PHP_EOL;
echo "   - Untuk logika bisnis standar, kalkulasi terstruktur, dan operasi CRUD." . PHP_EOL;
echo "   Alasan & Keuntungan:" . PHP_EOL;
echo "   - Type Safety: Dukungan type hinting penuh di PHP 8+." . PHP_EOL;
echo "   - Developer Experience: Autocomplete IDE bekerja 100%, mudah di-refactor." . PHP_EOL;
echo "   - Static Analysis: Dapat diperiksa secara otomatis oleh PHPStan/Psalm." . PHP_EOL;
echo "   - Performa: Eksekusi tercepat tanpa overhead dinamis." . PHP_EOL;

echo PHP_EOL . "2. METHOD OVERRIDING (INHERITANCE & POLYMORPHISM):" . PHP_EOL;
echo "   Kapan Digunakan:" . PHP_EOL;
echo "   - Ketika ada relasi 'is-a' yang jelas antara parent class dan child class." . PHP_EOL;
echo "   - Ketika subclass membutuhkan implementasi perilaku yang berbeda untuk kontrak yang sama." . PHP_EOL;
echo "   - Contoh di Aplikasi Nyata:" . PHP_EOL;
echo "     * Payment Gateway: Parent 'PaymentProcessor' -> Child 'MidtransPayment', 'XenditPayment'." . PHP_EOL;
echo "     * Mahasiswa: Parent 'Student' -> Child 'RegularStudent', 'ScholarshipStudent', 'InternationalStudent'." . PHP_EOL;
echo "     * Notification: Parent 'Notifier' -> Child 'EmailNotifier', 'WhatsappNotifier'." . PHP_EOL;
echo "   Alasan & Keuntungan:" . PHP_EOL;
echo "   - Mematuhi Open-Closed Principle (OCP): Menambah tipe baru tanpa mengubah kode yang memanggilnya." . PHP_EOL;

echo PHP_EOL . "3. MAGIC METHOD __call() (DYNAMIC OVERLOADING):" . PHP_EOL;
echo "   Kapan Digunakan:" . PHP_EOL;
echo "   - HANYA untuk kebutuhan infrastruktur dinamis atau adapter pola desain khusus." . PHP_EOL;
echo "   - Contoh di Aplikasi Nyata:" . PHP_EOL;
echo "     * ORM / Query Builder: Laravel Eloquent 'User::whereEmail(...)', 'User::findByUsername(...)''." . PHP_EOL;
echo "     * Dynamic Proxy / Decorator: Membungkus logging, caching, atau monitoring pada objek lain." . PHP_EOL;
echo "     * API Client SDK: Memetakan ratusan endpoint RPC/REST secara otomatis tanpa menulis ratusan method." . PHP_EOL;
echo "   Alasan & Risiko:" . PHP_EOL;
echo "   - Risiko: Hilangnya autocomplete IDE (harus dibantu @method PHPDoc), sulit di-debug," . PHP_EOL;
echo "     dan berisiko Runtime Error jika validasi argumen di dalam __call() tidak ketat." . PHP_EOL;
echo "   - JANGAN gunakan __call() untuk logika bisnis inti!" . PHP_EOL;
