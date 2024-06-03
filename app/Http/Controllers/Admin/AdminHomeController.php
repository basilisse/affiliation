<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index()
    {
      $totalUser = User::count();
      $userPerLevel = User::selectRaw('niveau, count(*) as number')->groupBy('niveau')->get();
      $totalPoint = User::sum('points');
      $users = User::orderBy('niveau')->paginate(10);
      return view('admin.home', compact(
          'totalUser',
          'userPerLevel',
          'totalPoint',
          'users'
      ));
    }
}
