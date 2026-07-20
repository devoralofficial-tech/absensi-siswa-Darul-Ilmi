<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('students')->insertOrIgnore([
            'nama' => 'Muhammad Sadidan',
            'nomor_wa' => '6281319442943',
            'qr_token' => 'STU-000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('students')->where('qr_token', 'STU-000007')->delete();
    }
};
