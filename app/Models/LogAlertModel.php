<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAlertModel extends Model
{
    use HasFactory;

    protected $table = 'log_alert';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'eventid',
        'name',
        'severity',
    ];
}
