<?php

namespace App\Http\Controllers\Auth;

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

class UserAuth extends Controller
{
    public function webAuth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_email' => 'required|email',
            'user_pass'  => 'required',
        ]);

        if ($validator->fails()){
            $response = "Invalid Parameters";
            return JSONResponse::response(400, $response);
        }

        $email    = $request->input('user_email');
        $password = $request->input('user_pass');

        try{
            $message = null;
            $user    = Users::where('email', '=', $email)
                            ->first();

            if (!$user){
                $status_code = 400;
                $message     = "Please Register";
                Log::info($email.'-not registered');
            }
            else if($user->password == md5($password)){
                $status_code = 200;
                Session::put('user_id',$user->id);
                Session::put('user_name',$user->name);
               // $value = session()->get('user_id');
               // echo $value;
                Session::save();
            }
            else{
                $status_code = 401;
                $message = "Unauthorized";
            }

            return JSONResponse::response($status_code, $message);
        }
        catch (Exception $e){
            Log::error($e->getMessage());
            return JSONResponse::response(500);
        }
    }

    public function logout(Request $request)
    {
        try{
            $request->session()->flush();
            return redirect('/login');
        } 
        catch (Exception $e){
            Log::error($e->getMessage());
            return JSONResponse::response(500);
        }
    }
}
