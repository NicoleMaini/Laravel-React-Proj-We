<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    // da copiare in ogni model nel quale tabella abbiamo tolto i timestamps
    public $timestamps = false;

    // relazione 1 a molti - HasMany ha più di un collegamento

    public function courses(): HasMany
    {
        // nome corrisposto al nome dell'altra tabella
        return $this->hasMany(Course::class);
    }
}
