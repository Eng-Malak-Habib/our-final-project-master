<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cases extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Case_id', 'Case_type', 'Court_no', 'Content', 'Note', 'status', 'Lawyer_id', 'contender', 'Title', 'client_name', 'Attachment'
    ];
}
