<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'challenges'    => 'array',
    ];

    const FIGURES = [
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '10',
    ];

    const SPECIAL_FIGURES = [
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14,
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
                'player_card'      => $card,
                'challenge_card'   => $randomCard = Arr::random(self::figures()),
                'is_winner'        => $this->cardValue($card) >= $this->cardValue($randomCard),
            ];
        });

        $this->fill([
            'score'             => $challenges->where('is_winner', 1)->count(),
            'challenge_score'   => $challenges->where('is_winner', 0)->count(),
            'challenges'        => $challenges,
        ])->fill([
            'is_winner' => $this->score >= $this->challenge_score,
        ])->save();

        return $this;
    }

    /**
     * Get the int value of a card.
     *
     * @param mixed $card
     *
     * @return int
     */
    public function cardValue($card)
    {
        return (int) Arr::get(self::SPECIAL_FIGURES, $card, $card);
    }

    /**
     * Get all the valid figures.
     *
     * @return array
     */
    public static function figures()
    {
        return array_merge(self::FIGURES, array_keys(self::SPECIAL_FIGURES));
    }
}
