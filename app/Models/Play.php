<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Play extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'challenges'    => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(fn ($play) => $play->is_winner = $play->score >= $play->challenge_score);
    }

    /**
     * Create the challenge.
     *
     * @param array $cards
     *
     * @return $this
     */
    public function challenge(array $cards)
    {
        $challenges = collect($cards)->map(function ($card) {
            return [
                'player'    => $card,
                'challenge' => $randomCard = self::figures()->random(),
                'user_won'  => $card >= $randomCard,
            ];
        });

        return $this->fill([
            'score'             => $challenges->where('user_won', 1)->count(),
            'challenge_score'   => $challenges->where('user_won', 0)->count(),
            'challenges'        => $challenges,
        ]);
    }

    /**
     * Get the available figures for the play.
     *
     * @return illuminate\Support\Collection
     */
    public static function figures()
    {
        return collect(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A']);
    }
}
