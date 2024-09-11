<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\UserRole;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function destroy($user_id)
    {
        if (Auth::user()->id != $user_id)
        {
            User::destroy($user_id);
            return redirect('users')->with('msg', 'User has been deleted successfully!');
        }
        else {
            dd("fuck");
        }
    }

    public function edit($user_id)
    {
        $users_role = UserRole::where('id', '!=', '1')->get();
        $user = User::find($user_id);
        
        return view('users.edit', [
            'user' => $user,
            'users_role' => $users_role,
        ]);
    }

    public function update(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'size:11'],
            'dob' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'string', 'max:10'],
        ]);

        if ($validator->fails()) {
            
            $user = User::find($user_id);
            $users_role = UserRole::where('id', '!=', '1')->get();

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->role_id = $request->role_id;

            return view('users.edit', [
                'user' => $user,
                'users_role' => $users_role,
            ])->withErrors($validator);
        }

        $user = User::find($user_id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->role_id = $request->role_id;
        if ( $request->password != '' ) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect('users')->with('msg', 'User has been edited successfully!');
    }
}
