<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SignoutHistory extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'time',
        'role',
        'remark'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
};
