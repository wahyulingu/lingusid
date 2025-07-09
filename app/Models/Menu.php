<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'url',
        'icon',
        'order',
        'parent_id',
        'group_id',
    ];

    /**
     * Get the parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get the children menu items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get the group that owns the menu item.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}