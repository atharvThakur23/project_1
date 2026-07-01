<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'company_id';
    public $timestamps = false; // Disable timestamps if not needed

    protected $fillable = [
        'company_name',
        'status',
        'created_by',
        'created_at',
        'is_delete',
    ];
}
