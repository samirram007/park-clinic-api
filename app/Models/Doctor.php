<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'department',
        'rating',
        'image',
        'experience',
        'education',
        'schedule',
        'bio',
        'reviews',
        'type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'decimal:1',
        'reviews' => 'integer',
        'type' => 'array',
        'is_active' => 'boolean',
    ];
}
