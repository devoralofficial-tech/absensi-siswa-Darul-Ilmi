<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository implements StudentRepositoryInterface
{
    public function findByToken(string $token): ?Student
    {
        return Student::where('qr_token', $token)->first();
    }

    public function all(): Collection
    {
        return Student::orderBy('nama')->get();
    }
}
