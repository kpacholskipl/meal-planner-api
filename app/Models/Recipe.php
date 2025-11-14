<?php

namespace App\Models;

use App\Enums\RecipeStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    use HasUuids;
    protected $fillable = [
        'id',
        'root_id',
        'is_latest',
        'version',
        'name',
        'user_id',
        'description',
        'preparation',
        'kcal',
        'preparation_time',
        'status',
    ];

    protected $casts = [
        'status' => RecipeStatusEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function versions(): HasMany
    {
        return $this->hasMany(static::class, 'root_id')
            ->orderBy('version', 'desc');
    }

    public function root(): BelongsTo
    {
        return $this->belongsTo(static::class, 'root_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(RecipeItem::class);
    }
}
