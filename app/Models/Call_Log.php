<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Clients;
use App\Models\Tags;
use Illuminate\Database\Eloquent\Model;

class Call_Log extends Model
{
    protected $table = 'call_logs';
    protected $primaryKey = 'call_id';
    public $timestamps = false;
    protected $fillable = [
        'client_id',
        'status',
        'tag_id',
        'follow_up_date',
        'is_follow_up',
        'remark',
        'created_by',
        'call_datetime',
        'is_delete',
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id', 'client_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tags::class, 'call_tag', 'tag_id');
    }
}
