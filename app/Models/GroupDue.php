<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupDue extends Model
{
    protected $connection = 'hyze';
    protected $table = 'user_groups_due';
    public $timestamps = false;
}