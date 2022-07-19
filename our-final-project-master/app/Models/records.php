<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class records extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'record_id', 'topic', 'Attatchment', 'Note', 'Client_name', 'Lawyer_id', 'Contender', 'Case'
    ];
}
