<?php

/* Model Template
Use it to create new Models */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        "email",
        "password",
    ];
}
