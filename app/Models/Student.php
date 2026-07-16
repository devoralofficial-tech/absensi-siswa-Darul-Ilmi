<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'nama',
        'nomor_wa',
        'qr_token',
        'qr_image',
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function todayAttendances()
    {
        return $this->attendances()->whereDate('attendance_date', today());
    }

    public function getQrImageUrlAttribute(): ?string
    {
        $options = new \chillerlan\QRCode\QROptions([
            'outputInterface'  => \chillerlan\QRCode\Output\QRMarkupSVG::class,
            'outputBase64'     => true,
            'scale'            => 10,
        ]);

        return (new \chillerlan\QRCode\QRCode($options))->render($this->qr_token);
    }
}
