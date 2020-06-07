<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function showAll(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
                ->setRowAttr([
                    'href' => '/user/{{ $id }}',
                ])
                ->make(true);
        }
        return view('users.showAll');
    }

    public function destroy($user_id)
    {
        User::destroy($user_id);

        return Redirect::to('/users');
    }
}
