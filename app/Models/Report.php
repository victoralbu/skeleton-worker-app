<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Report
 *
 * @property int $id
 * @property string $description
 * @property int $plaintiff_id
 * @property int $culprit_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $culprit
 * @property-read \App\Models\User|null $plaintiff
 * @method static \Database\Factories\ReportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCulpritId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report wherePlaintiffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Report extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
      'description',
      'culprit_id',
      'plaintiff_id'
    ];

    public function plaintiff()
    {
        return $this->belongsTo(User::class, 'plaintiff_id');
    }

    public function culprit()
    {
        return $this->belongsTo(User::class, 'culprit_id');
    }
}
