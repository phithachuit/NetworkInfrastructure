<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    public function getUser() {
        return UserModel::join('users_permissions', 'users_permissions.permission_id', '=', 'users.role')->get()->toArray();
    }

    // rela
    public function permissions(){
        return $this->hasMany(PermissionModel::class);
    }
}
