<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Job
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $level
 * @property float|null $budget
 * @property string $address
 * @property string $urgency
 * @property int $user_id
 * @property int $group_id
 * @property int $winner_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bid> $bids
 * @property-read int|null $bids_count
 * @property-read \App\Models\Group|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Photo> $photos
 * @property-read int|null $photos_count
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\User|null $winner
 * @method static \Database\Factories\JobFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUrgency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereWinnerId($value)
 * @mixin \Eloquent
 */
class Job extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'description',
        'level',
        'budget',
        'address',
        'urgency',
        'status',
        'user_id',
        'winner_id',
        'group_id',
        'city',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function winner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function bids(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Photo::class);
    }
}
