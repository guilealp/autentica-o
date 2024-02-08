<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        try{
            $data = $request->all();

            $data['password'] = Hash::make($request->password);

            $response = admin::create($data)->createToken($request->server('HTTP_USER_AGENT'))->plainTextToken;

            return response()->json([
                'status'=>'success',
                'message'=>"Admin cadastrato com sucesso",
                'token'=>$response
            ],200);
        } catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'menssage'=> $th->getMessage()
            ],500);
        }
    }
    public function login(Request $request){
        try{
            if(Auth::guard('admins')->attempt([
                'email'=> $request->email,
                'password'=>$request->password
            ])) {
                $user = Auth::guard('admins')->user();

                $token = $user->createToken($request->server('HTTP_USER_AGENT',
                ['admins']))->plainTextToken;

                return response()->json([
                    'status'=>'success',
                    'message'=>'Admin login com sucesso',
                    'token'=>$token
                ]);
            }
            else{
                return response()->json([
                    'status'=> false,
                    'message'=>'credenciais incorretas'
                ]);
            }
        }
        catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'menssage'=> $th->getMessage()
            ],500);
        }
    }
    public function verificarUsuarioLogado(Request $request){
        return Auth::user();
    }
}
