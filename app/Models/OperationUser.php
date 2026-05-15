<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationUser extends Model
{
    protected $table = 'operation_users';
    protected $fillable = ['name', 'email'];
}
