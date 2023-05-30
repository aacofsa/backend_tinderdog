<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dog extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'dog';
    protected $visible = ['id', 'name', "avatar_url", "description"];
    protected $fillable = ['name', "avatar_url", "description", "active"];
    
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class, "id_dog", "id");
    }

    public function views(): HasMany
    {
        return $this->hasMany(Interaction::class, "id_selected_dog", "id");
    }
}
