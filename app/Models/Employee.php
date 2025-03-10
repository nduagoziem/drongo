<?php

namespace App\Models;

use App\Models\User;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'employee_image',
        'full_name',
        'role',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($employee) {
            $salt = config('name') . config('key');
            $hashids = new Hashids($salt, 12); // 8-character UID

            $employee->employee_uid = $hashids->encode($employee->id);
            $employee->save();
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
};
