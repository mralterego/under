<?php

namespace App\Services;

use App\Models\SocialUser;
use App\Models\User;

class SocialAccountService
{
    public function createOrGetUser($providerObj, $providerName)
    {

        $providerUser = $providerObj->user();

        if ($providerUser->getEmail() == null){

            $account = SocialUser::whereProvider($providerName)
                ->whereProviderUserId($providerUser->getId())
                ->first();

            if ($account) {
                return $account->user;
            } else {
                $account = new SocialUser([
                    'provider_user_id' => $providerUser->getId(),
                    'provider' => $providerName
                ]);

                $user = User::whereEmail($providerUser->getNickname())->first();

                if (!$user) {
                    $user = User::createBySocialProvider($providerUser);
                }

                $account->user()->associate($user);
                $account->save();

                return $user;
            }

        } else {

            $account = SocialUser::whereProvider($providerName)
                ->whereProviderUserId($providerUser->getId())
                ->first();

            if ($account) {
                return $account->user;
            } else {
                $account = new SocialUser([
                    'provider_user_id' => $providerUser->getId(),
                    'provider' => $providerName
                ]);

                $user = User::whereEmail($providerUser->getEmail())->first();

                if (!$user) {
                    $user = User::createBySocialProvider($providerUser);
                }

                $account->user()->associate($user);
                $account->save();

                return $user;

            }
        }



    }
}