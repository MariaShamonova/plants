<?php

namespace App\Http\Controllers\api\Auth;

use App\Models\User;
use App\Models\UserSocial;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\InvalidStateException;
use Tymon\JWTAuth\JWTAuth;

class SocialLoginController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
        $this->middleware(['social', 'web']);
    }

    // public function redirect($service)
    // {
    //     return Socialite::driver($service)->redirect();
    // }

    public function callback($service)
    {
        try {
            $serviceUser = Socialite::driver($service)->stateLess()->user();
        } catch (InvalidStateException $e) {
            return redirect(env('CLIENT_BASE_URL') . '?error=Unable to login user' . $service . '. Please try again');
        }

        $email = $serviceUser->getEmail();
        if  ($service != 'google') {
            $email = $serviceUser->getId() . '@' . $service . '.local';
        }

        $user = $this->getExistingUser($serviceUser, $email, $service);
    //     $newUser = false;
        if (!$user) {
            //$newUser = true;
            $user = User::create([
                'name' => $serviceUser->getName(),
                'email' => $email,
                'password' => ''
            ]);
            dd($user);
        }

    //     if ($this->needsToCreateSocial($user, $service)) {
    //         UserSocial::create([
    //             'user_id' => $user->id,
    //             'social_id' => $serviceUser->getId(),
    //             'service' => $service
    //         ]);
    //     }

    //     return redirect(env('CLIENT_BASE_URL') . '/auth/social-callback?token=' . $this->auth->fromUser($user) . '&origin=' . ($newUser ? 'register' : 'login'));
    // }

    // public function needsToCreateSocial(User $user, $service)
    // {
    //     return !$user->hasSocialLinked($service);
    // }

    public function getExistingUser($serviceUser, $email, $service)
    {
        if ($service != 'google') {
            
            return User::where('email', $email)->orWhereHas('social', function($q) use ($serviceUser, $service) {
                $q->where('social_id', $serviceUser->getId())->where('service', $service);
            })->first();
        } else {
            $userSocial = UserSocial::where('social_id', $serviceUser->getId())->first();
            return  $userSocial ? $userSocial->user:null;
        }
        
    }
}
