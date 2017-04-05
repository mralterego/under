<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\SocialAccountService;
use Socialite;

class VkController extends Controller
{

    public function redirectToProvider()
    {
        return Socialite::with('vkontakte')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(SocialAccountService $service)
    {
        $driver = Socialite::driver('vkontakte');
        $user = $service->createOrGetUser($driver, 'vkontakte');

        \Auth::login($user, true);
        return redirect()->intended('/home');
    }

}