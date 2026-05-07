<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasswordResetRepository
{
    protected $table = 'password_resets';

    public function createOrUpdate(array $data)
    {
        return DB::table($this->table)->updateOrInsert(
            ['email' => $data['email']], 
            ['token' => $data['token'], 'created_at' => Carbon::now()]
        );
    }

    public function findByEmail(string $email)
    {
        return DB::table($this->table)->where('email', $email)->first();
    }

    public function deleteByEmail(string $email)
    {
        return DB::table($this->table)->where('email', $email)->delete();
    }
}