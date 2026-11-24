<?php
declare(strict_types=1);

/**
 * TUGAS 3 (Kelompok):
 * Menambahkan child InternationalStudent dengan calculateFee() berbeda;
 * Memastikan repository CRUD tidak perlu mengetahui nama class child (Polymorphism).
 * 
 * Modul: Praktikum PBO Pertemuan 8 - Point H (Tugas 3) & Point F
 */

// 1. Abstract Base Class
abstract class Student
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected float $baseFee
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBaseFee(): float
    {
        return $this->baseFee;
    }

    // Abstract method yang wajib di-override oleh setiap subclass
    abstract public function calculateFee(): float;

    public function summary(): string
    {
        return $this->id . ' - ' . $this->name;
    }
}

// 2. Child Class 1: RegularStudent
class RegularStudent extends Student
{
    public function calculateFee(): float
    {
        return $this->baseFee;
    }
}

// 3. Child Class 2: ScholarshipStudent
class ScholarshipStudent extends Student
{
    public function __construct(
        string $id,
        string $name,
        float $baseFee,
        private float $discountPercent
    ) {
        if ($discountPercent < 0 || $discountPercent > 100) {
            throw new InvalidArgumentException('Persentase diskon tidak valid (0 - 100).');
        }
        parent::__construct($id, $name, $baseFee);
    }

    public function calculateFee(): float
    {
        return $this->baseFee * (1 - $this->discountPercent / 100);
    }

    public function summary(): string
    {
        return parent::summary() . " [Scholarship {$this->discountPercent}%]";
    }
}

// 4. [TUGAS 3] Child Class 3: InternationalStudent
class InternationalStudent extends Student
{
    public function __construct(
        string $id,
        string $name,
        float $baseFee,
        private float $visaAndLanguageSurcharge
    ) {
        if ($visaAndLanguageSurcharge < 0) {
            throw new InvalidArgumentException('Surcharge internasional tidak boleh negatif.');
        }
        parent::__construct($id, $name, $baseFee);
    }

    /**
     * Implementasi calculateFee() yang berbeda:
     * Biaya dasar ditambah biaya visa, asuransi, dan fasilitas bahasa internasional.
     */
    public function calculateFee(): float
    {
        return $this->baseFee + $this->visaAndLanguageSurcharge;
    }

    public function summary(): string
    {
        return parent::summary() . ' [International Student]';
    }
}

// 5. [TUGAS 3] Repository CRUD Mahasiswa
// Repository ini HANYA bergantung pada tipe abstrak 'Student'.
// Repository TIDAK PERLU mengetahui atau mengecek nama class child (No instanceof check).
class StudentRepository
{
    /** @var array<string, Student> */
    private array $storage = [];

    // Create / Update (Save): Menerima objek bertipe Student
    public function save(Student $student): void
    {
        $this->storage[$student->getId()] = $student;
    }

    // Read: Mencari mahasiswa berdasarkan ID
    public function findById(string $id): ?Student
    {
        return $this->storage[$id] ?? null;
    }

    // Read All: Mengambil semua data mahasiswa
    /** @return Student[] */
    public function getAll(): array
    {
        return array_values($this->storage);
    }

    // Delete: Menghapus data mahasiswa
    public function delete(string $id): bool
    {
        if (isset($this->storage[$id])) {
            unset($this->storage[$id]);
            return true;
        }
        return false;
    }

    // Menampilkan rekap tagihan secara polymorphic
    public function displayBillingReport(): void
    {
        foreach ($this->storage as $student) {
            // Polymorphic dispatch:
            // summary() dan calculateFee() dieksekusi berdasarkan jenis objek aktual,
            // tanpa repository perlu tahu apakah dia Regular, Scholarship, atau International!
            printf(
                "%-42s | Tagihan: Rp %s%s",
                $student->summary(),
                number_format($student->calculateFee(), 0, ',', '.'),
                PHP_EOL
            );
        }
    }
}

// ==========================================================
// PENGUJIAN TUGAS 3
// ==========================================================
echo "==========================================================" . PHP_EOL;
echo "TUGAS 3: INTERNATIONAL STUDENT & CRUD REPOSITORY POLYMORPHISM" . PHP_EOL;
echo "==========================================================" . PHP_EOL;

$repo = new StudentRepository();

// Simpan berbagai tipe mahasiswa ke dalam satu repository yang sama
$repo->save(new RegularStudent("M01", "Alya", 5000000));
$repo->save(new ScholarshipStudent("M02", "Bima", 5000000, 40));
$repo->save(new InternationalStudent("M03", "John Smith", 5000000, 2500000));

echo "--- LAPORAN TAGIHAN DARI REPOSITORY ---" . PHP_EOL;
$repo->displayBillingReport();

echo PHP_EOL . "--- PENGUJIAN READ (findById) ---" . PHP_EOL;
$cari = $repo->findById("M03");
if ($cari !== null) {
    echo "Ditemukan: " . $cari->summary() . PHP_EOL;
    echo "Total Tagihan: Rp " . number_format($cari->calculateFee(), 0, ',', '.') . PHP_EOL;
}
