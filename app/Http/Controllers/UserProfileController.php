<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;

class UserProfileController extends Controller
{
    /**
     * Profil korisnika + svi njegovi oglasi.
     */
    public function show(User $user)
    {
        // koliko oglasa ima
        $adsCount = Ad::query()
            ->where('user_id', $user->id)
            ->count();

        // njegovi oglasi (možeš paginaciju ako hoćeš)
        $ads = Ad::query()
            ->with('category')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('users.profile', [
            'user' => $user,
            'ads' => $ads,
            'adsCount' => $adsCount,
        ]);
    }
}
