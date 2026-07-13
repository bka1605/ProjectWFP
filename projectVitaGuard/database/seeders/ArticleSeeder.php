<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('articles')->insert([
    [
        'judul' => 'Langkah - Langkah Menjaga Kesehatan Liver',
        'kategori' => 'Kesehatan',
        'konten' => 'Hati atau liver adalah organ vital yang berfungsi menyaring racun dari dalam tubuh. Untuk menjaganya tetap sehat, Anda disarankan untuk membatasi konsumsi alkohol, minum air putih yang cukup, serta mengonsumsi sayuran hijau seperti bayam dan brokoli. Hindari juga penggunaan obat-obatan di luar resep dokter secara berlebihan.',
        'tanggal_publish' => '2026-01-02',
    ],
    [
        'judul' => 'Pentingnya Tidur Cukup untuk Imunitas Tubuh',
        'kategori' => 'Gaya Hidup',
        'konten' => 'Tidur kurang dari 7 jam sehari dapat menurunkan sistem kekebalan tubuh Anda. Saat tidur, tubuh memproduksi sitokin, yaitu protein yang membantu melawan infeksi dan peradangan. Oleh karena itu, pastikan Anda mendapatkan tidur berkualitas setiap malam agar tidak mudah terserang penyakit.',
        'tanggal_publish' => '2025-02-15',
    ],
    [
        'judul' => 'Mengenal Gejala Awal Diabetes Melitus',
        'kategori' => 'Penyakit Dalam',
        'konten' => 'Diabetes tipe 2 seringkali tidak menunjukkan gejala di tahap awal. Namun, beberapa tanda peringatan yang harus diwaspadai meliputi sering merasa haus, buang air kecil lebih sering terutama di malam hari, luka yang sulit sembuh, dan pandangan kabur. Segera konsultasikan ke dokter jika Anda mengalami gejala ini.',
        'tanggal_publish' => '2026-03-10',
    ],
    [
        'judul' => 'Manfaat Olahraga Rutin bagi Jantung',
        'kategori' => 'Kesehatan',
        'konten' => 'Berolahraga minimal 30 menit setiap hari dapat membantu menjaga kesehatan jantung, menurunkan tekanan darah, meningkatkan sirkulasi darah, dan mengurangi risiko penyakit kardiovaskular. Pilih olahraga yang sesuai dengan kondisi tubuh Anda.',
        'tanggal_publish' => '2023-04-05',
    ],
    [
        'judul' => 'Cara Mengatasi Stres di Tempat Kerja',
        'kategori' => 'Kesehatan Mental',
        'konten' => 'Stres yang berkepanjangan dapat memengaruhi kesehatan fisik maupun mental. Luangkan waktu untuk beristirahat, lakukan teknik relaksasi seperti meditasi, serta atur prioritas pekerjaan agar beban terasa lebih ringan.',
        'tanggal_publish' => '2024-05-12',
    ],
    [
        'judul' => 'Pentingnya Minum Air Putih Setiap Hari',
        'kategori' => 'Gaya Hidup',
        'konten' => 'Air putih membantu menjaga keseimbangan cairan tubuh, melancarkan pencernaan, serta menjaga fungsi organ tetap optimal. Orang dewasa dianjurkan mengonsumsi sekitar 2 liter air putih setiap hari atau sesuai kebutuhan tubuh.',
        'tanggal_publish' => '2024-06-08',
    ],
    [
        'judul' => 'Makanan yang Baik untuk Kesehatan Mata',
        'kategori' => 'Nutrisi',
        'konten' => 'Wortel, bayam, ikan salmon, telur, dan buah jeruk mengandung vitamin dan antioksidan yang baik untuk kesehatan mata. Konsumsi makanan bergizi seimbang dapat membantu mengurangi risiko gangguan penglihatan.',
        'tanggal_publish' => '2022-07-14',
    ],
    [
        'judul' => 'Tips Menjaga Kesehatan Tulang',
        'kategori' => 'Kesehatan',
        'konten' => 'Asupan kalsium dan vitamin D yang cukup sangat penting untuk menjaga kepadatan tulang. Selain itu, lakukan olahraga seperti berjalan kaki atau latihan beban ringan secara rutin untuk memperkuat tulang.',
        'tanggal_publish' => '2026-08-20',
    ],
    [
        'judul' => 'Bahaya Konsumsi Gula Berlebihan',
        'kategori' => 'Nutrisi',
        'konten' => 'Mengonsumsi gula secara berlebihan dapat meningkatkan risiko obesitas, diabetes tipe 2, dan penyakit jantung. Batasi konsumsi makanan dan minuman manis serta biasakan membaca informasi nilai gizi pada kemasan.',
        'tanggal_publish' => '2024-09-18',
    ],
    [
        'judul' => 'Cara Meningkatkan Daya Tahan Tubuh Secara Alami',
        'kategori' => 'Kesehatan',
        'konten' => 'Menjaga pola makan bergizi, tidur yang cukup, berolahraga secara rutin, mengelola stres, dan mengonsumsi buah serta sayuran merupakan cara alami untuk meningkatkan daya tahan tubuh agar tidak mudah sakit.',
        'tanggal_publish' => '2026-10-25',
    ],
]);
    }
}
