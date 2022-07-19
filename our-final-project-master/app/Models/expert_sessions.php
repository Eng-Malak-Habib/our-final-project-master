<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class expert_sessions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'present_Lawyer_name', 'Session_Reason', 'Session_date', 'Expert_name', 'Attachment', 'Next_date', 'Desicion', 'Case_id', 'Office_address'
    ];
}
