<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Automatic extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'automatic';

    protected $fillable = [
        'uuid',
        'is_default',
        'user_id',
        'name',
        'image',
        'phrases',
    ];

    protected $cast = [
        'is_default' => 'boolean',
        'phrases' => 'array'
    ];

    protected $hidden = [
        'user_id'
    ];

    /**
     * Determine the columns that should receive a unique identifier.
     *
     * This method specifies that the 'uuid' column should be automatically 
     * generated as a sortable, unique identifier when the model is created.
     *
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    /**
     * Define the relationships between this model and other models.
     *
     * Use these methods to access related data via Eloquent relationships
     * (hasOne, hasMany, belongsTo, belongsToMany, etc.).
     */

    public function host()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function onair()
    {
        return $this->morphMany(Onair::class, 'program');
    }
}
