<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Notifications\ForgotPasswordCode;
use App\User;
use App\UserRole;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client as OClient;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8']
        ]);

        if ( $validator->fails() ) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if ( !Auth::attempt(['email' => $request->email, 'password' => $request->password]) ) {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
        
        $oClient = OClient::where('password_client', 1)->first();
        $response = $this->getTokenAndRefreshToken($oClient, $request->email, $request->password);
        $response = json_decode((string) $response->getBody(), true);

        $user = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'gender', 'dob')
            ->where('email', $request->email)
            ->first();

        $response['user'] = $user;
        
        return $response;
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'size:13'],
            'dob' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'string', 'max:10']
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $password = $request->password;
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $users_role = UserRole::where('title', '=', 'User')->first();
        $input['role_id'] = $users_role->id;

        $user = User::create($input);
        $oClient = OClient::where('password_client', 1)->first();

        $response = $this->getTokenAndRefreshToken($oClient, $user->email, $password);
        $response = json_decode((string) $response->getBody(), true);

        // Remove these keys from User object
        unset($user->role_id);
        unset($user->created_at);
        unset($user->updated_at);

        $response['user'] = $user;

        return $response;
    }

    public function register_social(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50']
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();

        $users_role = UserRole::where('title', '=', 'User')->first();
        $input['role_id'] = $users_role->id;
        $input['is_social'] = 1;

        try {
            $user = User::where('social_id', '=', $input['social_id'])->firstOrFail();
        } catch(ModelNotFoundException $e) {
            try {
                if ( $request->exists('email') ) {
                    $user = User::where('email', '=', $input['email'])->firstOrFail();
                    return response()->json(['error'=>'Email already exists and linked with another login option!'], 401);
                } else {
                    $user = User::create($input);
                }
            } catch(ModelNotFoundException $e) {
                $user = User::create($input);
            }        
        }

        // Remove these keys from User object
        unset($user->role_id);
        unset($user->created_at);
        unset($user->updated_at);

        $response['user'] = $user;

        return $response;
    }

    public function forgot_password(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:50']
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user === null) {
            return response()->json(['status' => false, 'msg' => "User doesn't exist!"], 404);
        }

        try {
            $reset_code = rand ( 1001 , 9999 );
            $user->notify( new ForgotPasswordCode($user, $reset_code) );

            $user->reset_code = $reset_code;
            $user->save();
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 401);
        }

        return response()->json(['status' => true, 'msg' => "Success"], 200);
    }

    public function verify_code(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:50']
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user === null) {
            return response()->json(['status' => false, 'msg' => "User doesn't exist!"], 404);
        }

        if ( $request->code === $user->reset_code ) {
            return response()->json(['status' => true, 'msg' => "Success"], 200);
        } else {
            return response()->json(['status' => false, 'msg' => "Wrong code!"], 404);
        }
    }

    public function change_password(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:50'],
            'password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user === null) {
            return response()->json(['status' => false, 'msg' => "User doesn't exist!"], 404);
        }

        if ( $request->code === $user->reset_code ) {
            $user->password = bcrypt($request->password);
            $user->reset_code = null;
            $user->save();
        } else {
            return response()->json(['status' => false, 'msg' => "Wrong code!"], 404);
        }

        return response()->json(['status' => true, 'msg' => "Password successfully changed"], 200);
    }

    public function update_password(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:50'],
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user === null) {
            return response()->json(['status' => false, 'msg' => "User doesn't exist!"], 404);
        }

        if ( Hash::check($request->old_password, $user->password) ) {
            $user->password = bcrypt($request->new_password);
            $user->save();
        } else {
            return response()->json(['status' => false, 'msg' => "Wrong credentials!"], 404);
        }

        return response()->json(['status' => true, 'msg' => "Password successfully changed"], 200);
    }

    public function register_device(Request $request) {
        $user = User::where('id', $request->user_id)->first();

        if ($user === null) {
            return response()->json(['msg' => "User doesn't exist!"], 404);
        }

        $user->fcm_token = $request->device_token;
        $user->save();

        return response()->json(['msg' => "Token successfully saved"], 200);
    }

    public function update_profile(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'size:13'],
            'dob' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'string', 'max:10']
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = User::where('id', $request->user_id)->first();

        if ($user === null) {
            return response()->json(['status' => false, 'msg' => "User doesn't exist!"], 404);
        }

        if ($user->email === null || $user->email === '') {
            $user->email = $request->email;
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->save();

        // Remove these keys from User object
        unset($user->role_id);
        unset($user->created_at);
        unset($user->updated_at);

        return response()->json(['status' => true, 'msg' => "Profile successfully updated", 'user' => $user], 200);
    }

    public function delete_account(Request $request) {
        $user = User::where('id', $request->user_id)->first();

        if ($user === null) {
            return response()->json(['msg' => "User doesn't exist!"], 404);
        }

        $user->delete();

        return response()->json(['msg' => "Account successfully deleted"], 200);
    }

    private function getTokenAndRefreshToken(OClient $oClient, $email, $password) {

        $response = Http::post( env('BASE_URL_TEMP') . 'oauth/token', [
            'grant_type' => 'password',
            'client_id' => $oClient->id,
            'client_secret' => $oClient->secret,
            'username' => $email,
            'password' => $password,
            'scope' => '*'
        ]);

        return $response;

    }
}
