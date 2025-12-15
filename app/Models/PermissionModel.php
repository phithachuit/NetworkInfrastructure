<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    use HasFactory;

    protected $table = 'users_permissions';
    protected $primaryKey = 'permission_id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'permission_id',
        'permission_name',
        'permission_active'
    ];

    // // rela
    public function users(){
        return $this->hasMany(UserModel::class, 'role', 'permission_id');
    }

    public function getPermissions()
    {
        return $this->all();
    }

    public function store($data)
    {
        return self::create([
            'permission_id' => $data['permission_id'],
            'permission_name' => $data['permission_name'],
            'permission_active' => $data['permission_active']
        ]);
    }

    public function find($id) {
        return self::where('permission_id', $id)->first()->toArray();
    }

    // fake permission data
    public function initPermissions() {
        $permissions = [
            ['permission_id' => 'admin', 'permission_name' => 'Quản trị', 'permission_active' => true],
            ['permission_id' => 'user', 'permission_name' => 'Người dùng', 'permission_active' => true],
            ['permission_id' => 'viewer', 'permission_name' => 'Người xem', 'permission_active' => true],
        ];

        foreach ($permissions as $permission) {
            self::updateOrCreate(
                ['permission_id' => $permission['permission_id']],
                $permission
            );
        }
    }
}
