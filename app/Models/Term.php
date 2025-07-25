<?php

namespace App\Models;

use App\Abstractions\Traits\Model\HasGroups;
use App\Abstractions\Traits\Model\HasMetadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    use HasGroups;
    use HasMetadata;

    protected $fillable = [
        'text',
    ];
}
