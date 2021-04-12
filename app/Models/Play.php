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
                'player'     => $card,
                'challenge'  => $randomCard = self::figures()->random(),
                'is_winner'  => $card >= $randomCard,
            ];
        });

        return $this->fill([
            'score'             => $challenges->where('is_winner', 1)->count(),
            'challenge_score'   => $challenges->where('is_winner', 0)->count(),
            'challenges'        => $challenges,
        ])->fill([
            'is_winner' => $this->score >= $this->challenge_score,
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
