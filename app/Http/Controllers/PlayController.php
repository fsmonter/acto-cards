<?php

namespace App\Http\Controllers;

use App\Models\Play;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlayController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'cards'     => 'required|array',
            'cards.*'   => ['required', Rule::in(Play::figures())],
        ]);

        return response()->json([
            'play'       => Play::make(['username'=> $request->username])
                                 ->challenge($request->cards)
                                 ->save(),
        ]);
    }
}
