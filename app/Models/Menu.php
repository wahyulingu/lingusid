<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
>>>>>>> feature/reusable-groups

class Menu extends Model
{
    protected $fillable = [
        'name',
        'url',
        'icon',
        'order',
        'parent_id',
<<<<<<< HEAD
    ];

=======
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
>>>>>>> feature/reusable-groups
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

<<<<<<< HEAD
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
=======
    /**
     * Get the group that owns the menu item.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
>>>>>>> feature/reusable-groups
