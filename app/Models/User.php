<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Hashids\Hashids;
use App\Models\Employee;
use App\Models\SigninHistory;
use App\Models\SignoutHistory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organization_name',
        'email',
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $salt = config('name') . config('url');
            $hashids = new Hashids($salt, 8); // 8-character UID

            $user->user_uid = $hashids->encode($user->id);
            $user->save();
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    // Relationship To Employee Model
    public function employee() {
        return $this->hasMany(Employee::class, "user_id");
    }

    // Relationship To SignInHistory Model
    public function signInHistory() {
        return $this->hasMany(SigninHistory::class, "user_id");
    }

    // Relationship To SignOutHistory Model
    public function signOutHistory() {
        return $this->hasMany(SignoutHistory::class, "user_id");
    }
}
