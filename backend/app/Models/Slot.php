<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function courses(): HasMany
    {
        // nome corrisposto al nome dell'altra tabella
        return $this->hasMany(Course::class);
    }
}
