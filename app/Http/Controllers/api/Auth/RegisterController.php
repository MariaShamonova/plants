<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Orders;
use App\Models\DataDelivery;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '';
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $auth)
    {
       $this->auth = $auth;
    }

        /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        $admin= User::where('is_admin', 1)->first();
        if (!$validator->fails()) {
            
           
            DB::transaction(function() use ($request, $admin)
            {
                $currAd = $request->get('is_admin');
                if ($admin == null || ($currAd !== '1')) {

                

                    $user = $this->create($request->all());
                    $token = JWTAuth::attempt($request->only('email', 'password'));
                    $userInfo = DataDelivery::create(
                        [
                            'client_id' => $user->id,                   
                        ]
                    );
                    echo($userInfo->id);
                    $order = Orders::create(
                        [
                            'client_id' => $user->id, 
                            'delivery_id'=>$userInfo->id,
                            'status_id' => 1, 
                            'price' => 0, 
                        ]
                    );
                    

                    $order->save();
                    $userInfo->save();
                    return response()->json([
                        'success' => true,
                        'data' => $user,
                        'token' => $token
                    ], 200);
                } 
            });
            
        }

        // return response()->json([
        //     'success' => false,
        //     'errors' => [$validator->errors(),'Admin already exist!'],
        // ], 422);
    }
 
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8']
        
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
      
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => $data['is_admin']
        ]);
    }
    
}