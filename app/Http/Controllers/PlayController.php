<?php

namespace App\Http\Controllers;

use App\Models\Play;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlayController extends Controller
{
    public function index()
    {
        $plays = Play::selectRaw('username, count(*) as plays, count(case when is_winner = 1 then 1 end) as games_won')
                      ->groupBy('username')
                      ->get();

        return response()->json([
            'plays' => $plays,
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
            'cards'     => 'required|array',
            'cards.*'   => ['required', Rule::in(Play::figures())],
        ]);

        $play = Play::make(['username'=> $request->username])->challenge($request->cards);

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
