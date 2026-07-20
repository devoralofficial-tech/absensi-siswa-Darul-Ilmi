<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Services\QrCodeService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class StudentSeeder extends Seeder
{
    private array $students = [
        ['nama' => 'Ahmad Thoriq Alwafi',   'nomor_wa' => '6285382286556'],
        ['nama' => 'Rafa Hamizan Syaputra', 'nomor_wa' => '6285758795259'],
        ['nama' => 'Azka Athariz Akbar',    'nomor_wa' => '6285379551690'],
        ['nama' => 'Hafidh Fahmy Syahreza', 'nomor_wa' => '6282306097991'],
        ['nama' => 'Fazri Nur Mardiansyah', 'nomor_wa' => '6285357946635'],
        ['nama' => 'Naufal',                'nomor_wa' => '089667922929'],
        ['nama' => 'Muhammad Sadidan',      'nomor_wa' => '6281319442943'],
    ];

    public function run(): void
    {
        Storage::disk('public')->makeDirectory('qr');

        $qrService = app(QrCodeService::class);

        foreach ($this->students as $index => $data) {
            $token   = 'STU-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT);
            $student = Student::firstOrCreate(
                ['qr_token' => $token],
                [
                    'nama'     => $data['nama'],
                    'nomor_wa' => $data['nomor_wa'],
                ]
            );

            $this->command->info("✓ {$student->nama} — {$token}");
        }
    }
}
