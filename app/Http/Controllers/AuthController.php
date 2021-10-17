<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function login_2(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
            //'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!\Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('alp');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = \Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => \Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function login(Request $request)
    {

       $validator = Validator::make($request->input(), [
            'email'=>'required',
            'password'=>'required',
        ]);
        
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors(),
                                        'res' => false]);
        }

        $user = User::whereEmail($request->email)->first();       
        if (!is_null($user) && (md5($request->password) == $user->password)) {
            $token = $user->createToken('alp')->accessToken;
            return response()->json([
                'res' => true, 
                    'user'=> $user, //auth()->user(),
                        'token' => $token, 
                            'access'  =>base64_encode($user->tipo_usuario_id),
                                'message' => "Bienvenido al sistema"]);
        } else
        {
            return response()->json([
                'res' => false, 
                    'message' => "Cuenta a password incorrectos",
                        'errors' => $validator->errors()]);
        }            
    }

    public function logout(){
        $user = auth()->user();
        $user->tokens->each(function ($token, $key){
            $token->delete();
        });
        return response()->json(['res' => true, 'message' => "Adios"]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json([
            'res'=>true,
                'result'=>$user,
                    'access'  =>base64_encode($user->tipo_usuario_id),
                        'message'=>'ok'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
