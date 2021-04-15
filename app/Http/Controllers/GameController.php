<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::selectRaw('username, count(*) as games, count(case when is_winner = 1 then 1 end) as wins')
                      ->groupBy('username')
                      ->orderByRaw('wins desc')
                      ->get();

        return response()->json([
            'games' => $games,
        ]);
    }

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username'  => 'required|string|max:255',
            'cards'     => ['bail', 'required', function ($attribute, $cards, $fail) {
                if (!collect($cards)->every(fn ($card) => in_array($card, Game::figures()))) {
                    $fail('The hand of cards is invalid.');
                }
            }],
        ]);

        $play = Game::make(['username'=> $request->username])->challenge($request->cards);

        return response()->json([
            'results'   => [
                'challengeCards'    => collect($play->challenges)->pluck('challenge_card'),
                'score'             => $play->score,
                'challengeScore'    => $play->challenge_score,
                'is_winner'         => $play->is_winner,
            ],
        ]);
    }
}
