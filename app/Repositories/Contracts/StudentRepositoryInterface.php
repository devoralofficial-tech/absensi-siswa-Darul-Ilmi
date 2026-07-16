<?php

namespace App\Repositories\Contracts;

use App\Models\Student;

interface StudentRepositoryInterface
{
    public function findByToken(string $token): ?Student;
    public function all(): \Illuminate\Database\Eloquent\Collection;
}
