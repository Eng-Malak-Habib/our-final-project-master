<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class case_attachments extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Case_id', 'Attachment'
    ];
}
