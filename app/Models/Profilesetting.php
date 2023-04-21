<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profilesetting extends Model
{
    use HasFactory;

    protected $table = "profile_setting";
    protected $guarded = ["id"];
}
