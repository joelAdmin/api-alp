<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
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

    public function subAllAuthM($emisor_id){
         $result = \DB::table('pgrw_chats')
                        ->select('pgrw_chats_mensajes.chat_id', 'pgrw_chats_mensajes.fecha','pgrw_chats.chat_id', 
                            'pgrw_chats.emisor_id', 'pgrw_chats.receptor_id', 'pgrw_chats.observacion', 'pgrw_usuarios.nombres', 
                                'pgrw_usuarios.apellidos', 'pgrw_usuarios.avatar', 'pgrw_usuarios.conectado', 
                                    \DB::raw("COUNT(DISTINCT IF((pgrw_chats_mensajes.estatus = 0 && pgrw_chats_mensajes.receptor_id = ".auth()->user()->usuario_id."), pgrw_chats_mensajes.mensaje_id, 0)) - 1 AS num_mensajes"),
                                        //\DB::raw("MAX(pgrw_chats_mensajes.fecha) AS fecha_order"), 
                                            'pgrw_chats_mensajes.mensaje_id')
                                                ->join('pgrw_usuarios', 'pgrw_chats.receptor_id', '=','pgrw_usuarios.usuario_id')
                                                    ->join('pgrw_chats_mensajes', 'pgrw_chats.chat_id', '=', 'pgrw_chats_mensajes.chat_id')
                                                        ->where('pgrw_chats.emisor_id', '=', $emisor_id)
                                                            ->where('pgrw_chats.estatus', '=', 0)
                                                                ->orderBy('pgrw_chats_mensajes.fecha', 'desc')
                                                                    ->groupBy('pgrw_chats_mensajes.chat_id')
                                                                        ->get();
        return response()->json(['res'=>true,
                                    'message' => 'success',
                                        'result' => $result], 200);
    }

    public function allAuthM($receptor_id){
        
        $result = \DB::table('pgrw_chats')
                            ->select('pgrw_chats_mensajes.chat_id', 'pgrw_chats_mensajes.fecha','pgrw_chats.chat_id', 'pgrw_chats.emisor_id', 'pgrw_chats.receptor_id', 'pgrw_chats.observacion', 'pgrw_usuarios.nombres', 'pgrw_usuarios.apellidos', 'pgrw_usuarios.avatar', 'pgrw_usuarios.conectado', 
                                \DB::raw("COUNT(DISTINCT IF((pgrw_chats_mensajes.estatus = 0 && pgrw_chats_mensajes.receptor_id = ".auth()->user()->usuario_id."), pgrw_chats_mensajes.mensaje_id, 0)) - 1 AS num_mensajes"), 
                                    \DB::raw("MAX(pgrw_chats_mensajes.fecha) AS fecha_order"), 
                                        'pgrw_chats_mensajes.mensaje_id')
                                        ->join('pgrw_usuarios', 'pgrw_chats.emisor_id', '=','pgrw_usuarios.usuario_id')
                                            ->join('pgrw_chats_mensajes', 'pgrw_chats.chat_id', '=', 'pgrw_chats_mensajes.chat_id')
                                                ->where('pgrw_chats.receptor_id', '=', $receptor_id)
                                                    ->where('pgrw_chats.estatus', '=', 0)
                                                        //->orderBy('pgrw_chats_mensajes.fecha', 'desc')
                                                            ->orderBy('fecha_order', 'desc')
                                                                ->groupBy('pgrw_chats.emisor_id')
                                                                    ->get();
        return response()->json(['res' => true,
                                    'message' => 'success',
                                        'result' => $result], 200);
    }

    public function allAuthU($emisor_id)
    {
        $result = \DB::table('pgrw_chats')
                    ->select('pgrw_chats_mensajes.chat_id', 'pgrw_chats_mensajes.fecha','pgrw_chats.chat_id', 'pgrw_chats.emisor_id', 'pgrw_chats.receptor_id', 'pgrw_chats.observacion', 'pgrw_usuarios.nombres', 'pgrw_usuarios.apellidos', 'pgrw_usuarios.avatar', 'pgrw_usuarios.conectado', 
                            \DB::raw("COUNT(DISTINCT IF((pgrw_chats_mensajes.estatus = 0 && pgrw_chats_mensajes.receptor_id = ".auth()->user()->usuario_id."), pgrw_chats_mensajes.mensaje_id, 0)) - 1 AS num_mensajes"), 
                                //\DB::raw("MAX(pgrw_chats_mensajes.fecha) AS fecha_order"), 
                                    'pgrw_chats_mensajes.mensaje_id')
                                        ->join('pgrw_usuarios', 'pgrw_chats.receptor_id', '=','pgrw_usuarios.usuario_id')
                                            ->join('pgrw_chats_mensajes', 'pgrw_chats.chat_id', '=', 'pgrw_chats_mensajes.chat_id')
                                                ->where('pgrw_chats.emisor_id', '=', $emisor_id)
                                                    ->where('pgrw_chats.estatus', '=', 0)
                                                        ->orderBy('pgrw_chats_mensajes.fecha', 'desc')
                                                            ->groupBy('pgrw_chats_mensajes.chat_id')
                                                                ->get();
        return response()->json(['res' => true,
                                    'message' => 'success',
                                        'result' => $result], 200);
    }

    public function all(){
        $result = \DB::table('users')->get();
        return response()->json([
            'res' => true,
                'message' => 'success', 
                    'result'=> $result,
        ], 200);
    }

    public function all_2(){
      $result = \DB::table('pgrw_chats')->get();
        return response()->json([
            'res' => true,
                'message' => 'success', 
                    'result'=> $result,
        ], 200);
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
        //
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
