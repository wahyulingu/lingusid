<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'parent_id',
    ];

    /**
     * Get the parent group.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'parent_id');
    }

    /**
     * Get the children groups.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Group::class, 'parent_id');
    }
}
