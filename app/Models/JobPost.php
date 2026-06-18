<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'is_active',
        'apply_duration',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'apply_duration' => 'date',
    ];

    /**
     * Get the career applications for this job post, matched by position title.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(CareerApplication::class, 'position', 'title');
    }
}
