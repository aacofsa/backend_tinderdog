<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'interaction';
    protected $visible = ['id', 'dog_id', "target_dog_id", "action"];
    protected $fillable = ["action"];
}
