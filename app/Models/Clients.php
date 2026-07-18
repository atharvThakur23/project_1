<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    public $timestamps = false;

    protected $fillable = [
        'client_name',
        'client_comp_name',
        'email',
        'mob',
        'dob',
        'address',
        'register_by',
        'updated_date',
        'updated_by',
        'is_active',
        'is_delete',
        'company_id',
        'expected_revenue',
    ];

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'company_id');
    }
    public function callLog(){
        return $this->hasMany(Call_Log::class,'client_id','client_id');
    }
}
