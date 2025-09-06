<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GrammarCheck
 *
 * @property int $id
 * @property string $name
 * @property string $school
 * @property string $original_text
 * @property string $corrected_text
 * @property string $suggestions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck whereOriginalText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck whereCorrectedText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck whereSuggestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GrammarCheck whereId($value)
 * @method static \Database\Factories\GrammarCheckFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class GrammarCheck extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'school',
        'original_text',
        'corrected_text',
        'suggestions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}