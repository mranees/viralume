<?php

namespace App\Models;

use Database\Factories\SpecializationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'description'])]
class Specialization extends Model
{
    /** @use HasFactory<SpecializationFactory> */
    use HasFactory;

    /** @return BelongsToMany<Doctor, $this> */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class);
    }

    /**
     * @param  Builder<Specialization>  $query
     * @return Builder<Specialization>
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, fn ($query, $search) => $query->where('name', 'like', '%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%'));
    }
}
