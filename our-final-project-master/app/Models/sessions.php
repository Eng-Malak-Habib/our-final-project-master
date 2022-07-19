<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sessions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Role_no', 'present_Lawyer_name', 'Session_Reason', 'Session_date', 'Session_Requirements', 'Attachment', 'Next_date', 'Desicion', 'Case_id'
    ];
}
