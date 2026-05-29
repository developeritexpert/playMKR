<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\SearchableAndFilterable;


#[Fillable(['name', 'email', 'password' , 'role_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use SearchableAndFilterable;
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function setPasswordAttribute(string $value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sponsor()
    {
        return $this->hasOne(Sponsor::class);
    }
}
