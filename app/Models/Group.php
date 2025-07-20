<?php

namespace App\Models;

use App\Abstractions\Traits\Model\HasGroups;
use App\Abstractions\Traits\Model\HasMetadata;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Group extends Model
{
    use HasFactory;
    use HasGroups;
    use HasMetadata;
    use Sluggable;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * Get the children groups.
     */
    public function children(): MorphToMany
    {
        return $this->morphedByMany(self::class, 'groupable', 'model_has_groups');
    }

    /**
     * Get all of the menus that are assigned this group.
     */
    public function menus()
    {
        return $this->morphedByMany(Menu::class, 'groupable', 'model_has_groups');
    }
}
