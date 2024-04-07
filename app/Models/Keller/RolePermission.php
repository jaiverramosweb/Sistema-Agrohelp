<?php

namespace App\Models\Keller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    
    protected $table = 'role_permission';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fk_role_id',
        'fk_permission_id',
        'create',
        'read',
        'update',
        'delete',
    ];

}
