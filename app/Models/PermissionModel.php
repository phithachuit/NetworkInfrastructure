<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    use HasFactory;

    protected $table = 'users_permissions';
    protected $primaryKey = 'permission_id';

    protected $fillable = [
        'permission_id',
        'permission_name',
        'permission_active'
    ];

    public function initPermissions() {
        $permissions = [
            ['permission_id' => 'admin', 'permission_name' => 'Administrator', 'permission_active' => true],
            ['permission_id' => 'user', 'permission_name' => 'user', 'permission_active' => true],
            ['permission_id' => 'viewer', 'permission_name' => 'Viewer', 'permission_active' => true],
        ];

        foreach ($permissions as $permission) {
            self::updateOrCreate(
                ['permission_id' => $permission['permission_id']],
                $permission
            );
        }
    }
}
