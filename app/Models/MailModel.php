<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailModel extends Model
{
    use HasFactory;

    protected $table = 'mail_history';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['mailto', 'content'];
}
