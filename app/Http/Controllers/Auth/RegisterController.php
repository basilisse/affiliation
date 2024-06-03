<?php

namespace App\Http\Controllers\Auth;

use App\Enum\PointOwned;
use App\Enum\Role;
use App\Http\Controllers\Controller;
use App\Models\InvitationHistory;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
          'username' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
          'password_confirmation' => ['required', 'string', 'min:8'],
          'role' => ['nullable', 'string'],
          'parrain_code' => ['required', 'string', 'max:255'],
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
      $invitationCode = Utils::generateRandomString(6);
      $parrain_code = $data['parrain_code'] ?? '';
      $parrain_id = null;
      $niveau = 1;
      if ($parrain_code) {
        $parrain = User::where('invitation_code', $parrain_code)->first();
        if ($parrain != null) {
          $parrain_id = $parrain->id;
          $niveau = $parrain->niveau + 1;
        }
      }
      $role = $data['role'] ?? Role::USER;
      $user = User::create([
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => $role,
        'parrain_id' => $parrain_id,
        'invitation_code' => $invitationCode,
        'points' => 500,
        'niveau' => $niveau,
      ]);
      while ($parrain != null) {
        $points = 0;
        switch ($parrain->niveau) {
          case 1:
            $points = 100;
            break;
          case 2:
            $points = 50;
            break;
          case 3:
            $points = 25;
            break;
          case 4:
            $points = 10;
            break;
          case 5:
            $points = 5;
            break;
          default:
            break;
        }
        if ($points > 0) {
          $parrain->points += $points;
          $parrain->save();
          $history = new InvitationHistory();
          $history->user_id = $user->id;
          $history->parrain_id = $parrain->id;
          $history->points = $points;
          $history->save();
        }
        $parrain = $parrain->parrain;
      }
      return $user;
    }
}
