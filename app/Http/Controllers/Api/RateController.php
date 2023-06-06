<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function rate(Request $request)
    {
        $userRated = User::where('id','=',$request->get('user_id'))->first();
        $user = $request->user();
        $rating = $request->get('rate');

        if ((float)$rating < 0)
            $rating = 0;

        if ((float)$rating > 5)
            $rating = 5;

        $userRatings = json_decode($userRated->ratings, true);

        $userRatings[$user->id] = $rating;

        $numberOfRatings = count(array_keys($userRatings));

        $sum = 0;

        foreach ($userRatings as $rate){
            $sum += (float)$rate;
        }

        $newRate = $sum/$numberOfRatings;

        try {
            $userRated->update([
                'ratings' => json_encode($userRatings),
                'ratings_nr' => $numberOfRatings,
                'rating' => $newRate,
            ]);
        } catch (\Exception $exception){
            return response()->json($exception);
        }


        return response()->json(['status' => 'good']);
    }
}
