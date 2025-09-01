<?php

namespace App\Models\Sid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidResident extends Model
{
    use HasFactory;

    protected $table = 'sid_residents';

    protected $fillable = [
        'nik',
        'name',
        'no_kk',
        'address',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'marital_status',
        'education',
        'occupation',
        'nationality',
        'father_name',
        'mother_name',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
}