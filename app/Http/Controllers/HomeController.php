<?php

namespace App\Http\Controllers;

use App\Models\InvitationHistory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $histories = InvitationHistory::where('parrain_id', $user->id)
            ->paginate(10);
        return view('home', [
            'histories' => $histories
        ]);
    }

    public function changePassword()
    {
        return view('auth.change-password');
    }
    public function changePseudo()
    {
      return view('admin.edit-user', ['user' => auth()->user()]);
    }
}
