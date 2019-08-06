<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Socialite;

use App\User;
use App\Role;
use App\SocialIdentity;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->middleware('auth')->except('logout');
    }

    public function redirectTo() 
    {
        foreach(auth()->user()->roles as $role){
            $role = $role->name;
        }
        //dd($role);
        if ($role == 'user') {
            return('/user/home');
        }elseif($role == 'admin') {
            return('/admin/home');
        }else{
            return('/');
        }
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try{
            $providerUser = Socialite::driver($provider)->stateless()->user();
        }catch(Exception $e){
            return redirect('/login');
        }

        $authUser = $this->findOrCreateUser($providerUser, $provider);
        
        
        Auth::login($authUser, true);
        //auth()->login($authUser, true);
        
        //return redirect()->route('userhome');
        //return redirect($this->redirectTo());
        //return redirect('user/home');
        //return redirect()->to('user/home');
        //return redirect()->back();
        return redirect()->to('/user/home');
    }

    public function findOrCreateUser($providerUser, $provider)
    {
        $account = SocialIdentity::whereProviderName($provider)
                    ->whereProviderId($providerUser->getId())
                    ->first();
       
        if($account){
            return $account->user;
        }else{
            $user = User::whereEmail($providerUser->getEmail())->first();
            
            if(!$user){
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => bcrypt('User@123')
                ]);

                $id = Role::where('name', 'user')->first();
                $user->roles()
                        ->attach($id);
                
            }

            $user->identities()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider
            ]);

            return $user;
        }
    }
}