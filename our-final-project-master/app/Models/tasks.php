<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    use HasFactory;
    protected $fillable = [
        'Date', 'StartTime', 'EndTime', 'Description', 'Title', 'Lawyer_id'
    ];
}
