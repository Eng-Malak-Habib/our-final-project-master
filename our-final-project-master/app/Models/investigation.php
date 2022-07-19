<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class investigation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'investigation_id',
        'topic',
        'in_Date',
        'contender',
        'Decision',
        'Note',
        'investigation_place_No',
        'Lawyer_id',
        'Case_id',
    ];
}
