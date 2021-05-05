<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * App\Models\BoardUser
 *
 * @property int $id
 * @property int $board_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Board $board
 * @property-read User $user
 * @method static Builder|BoardUser newModelQuery()
 * @method static Builder|BoardUser newQuery()
 * @method static Builder|BoardUser query()
 * @method static Builder|BoardUser whereBoardId($value)
 * @method static Builder|BoardUser whereCreatedAt($value)
 * @method static Builder|BoardUser whereId($value)
 * @method static Builder|BoardUser whereUpdatedAt($value)
 * @method static Builder|BoardUser whereUserId($value)
 */
class BoardUser extends Pivot
{
    /** @var bool */
    public $incrementing = true;

    /** @var string */
    protected $table = 'board_user';

    /**
     * @return BelongsTo
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
