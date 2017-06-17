<?php

namespace App\Http\Controllers;

use App\Models\Users;

use App\Http\Controllers\Controller;

use Sangria\JSONResponse;

use Illuminate\Http\Request;

use Validator;
use Log;
use stdClass;
use Session;
use Exception;
use DB;

class UserReg extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name'  => 'required',
            'user_email' => 'required|email',
            'user_pass'  => 'required',
        ]);

        if ($validator->fails()){
            $response = "Invalid Parameters";
            return JSONResponse::response(400, $response);
        }

        $name     = $request->input('user_name');
        $email    = $request->input('user_email');
        $password = $request->input('user_pass');


        $user = Users::where('email',$email)
                     ->first();
        if($user)
        {
            $status_code = 400;
            $message = "Email already registered";
            return JSONResponse::response($status_code, $message);
        }
        $user = new Users;
        $user->name = $name;
        $user->email = $email;
        $user->password = md5($password);
        $user->save();
        $status_code = 200;
        return JSONResponse::response($status_code);
        
    }

}
