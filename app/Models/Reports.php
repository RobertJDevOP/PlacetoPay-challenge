<?php

namespace App\Models;

use App\Filters\Concerns\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;

    public $primaryKey = 'id_report';

    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
