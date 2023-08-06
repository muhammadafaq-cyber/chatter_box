<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()){
            $response =[
                'success'=>'false',
                'message'=>$validator->errors()
            ];
            return response()->json($response,404);
        }
        $input = $request->all();
        $input['password']= Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name']=$user->name;
        $response = [
            'success'=>true,
            'data'=>$success,
            'message'=>"User Register Successfully!"
        ];
        return response()->json($response,202);
    }


    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()){
            $response =[
                'success'=>'false',
                'message'=>$validator->errors()
            ];
            return response()->json($response,404);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user['token'] = $user->createToken('MyApp')->plainTextToken;
            $response = [
                'success'=>true,
                'data'=>$user,
                'message'=>"User Login Successfully!"
            ];
            return response()->json($response);
        } else {
            $response = [
                'success'=>'false',
                'message'=>'Unauthorized'
            ];
            return response()->json($response,202);
        }
    }
}
