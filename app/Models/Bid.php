<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bid
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $date
 * @property float $money
 * @property string $few_words
 * @property string $status
 * @property int $user_id
 * @property int $job_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Job|null $job
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\BidFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Bid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereFewWords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereUserId($value)
 * @mixin \Eloquent
 */
class Bid extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'date',
        'money',
        'few_words',
        'user_id',
        'job_id',
        'status',
    ];
    protected $casts    = [
        'date' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
