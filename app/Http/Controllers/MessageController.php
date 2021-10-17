<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;

class MessageController extends Controller
{
    public function show($chat_id){
        $result = Message::select('pgrw_chats_mensajes.*', 'receptor.usuario_id AS usuarioid_receptor', 'receptor.nombres AS nombre_receptor', 'receptor.apellidos AS apellido_receptor', 'receptor.avatar AS avatar_receptor', 'receptor.email AS email_receptor', 'receptor.login AS login_receptor', 'receptor.conectado AS conectado_receptor', 'emisor.usuario_id AS usuarioid_emisor', 'emisor.nombres AS nombre_emisor', 'emisor.apellidos AS apellido_emisor', 'emisor.avatar AS avatar_emisor', 'emisor.email AS email_emisor', 'emisor.login AS login_emisor', 'emisor.conectado AS conectado_emisor')
                                        ->join('pgrw_usuarios AS receptor', 'pgrw_chats_mensajes.receptor_id', '=', 'receptor.usuario_id')
                                            ->join('pgrw_usuarios AS emisor', 'pgrw_chats_mensajes.emisor_id', '=', 'emisor.usuario_id')
                                                ->where('delete', 0)
                                                    ->where('chat_id', $chat_id)
                                                        ->get();

        return response()->json(['res'=>true, 'message'=>'success', 'result'=>$result], 200);
    }

    public function sendMessage(Request $request){
        $request->request->add(['fecha'=>date('Y-m-d'), 'estatus'=>1, 'attachment'=>0, 'ogg' => null]);
        $validator = Validator::make($request->input(), [
            'mensaje'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors(),
                                        'res' => false]);
        }

        $message = new Message();
        $message->chat_id = $request->get('chat_id');
        $message->fecha = $request->get('fecha');
        $message->mensaje = $request->get('mensaje');
        $message->emisor_id = $request->get('emisor_id');
        $message->receptor_id = $request->get('receptor_id');
        $message->attachment = $request->get('attachment');
        $message->ogg = $request->get('ogg');
        
        if($message->save()){
             broadcast(new \App\Events\NewMessage($message));
            return response()->json([
                'res' => true, 
                    'message' => "REGISTRO CREADO CORRECTAMENTE, GRACIAS"], 200);   
        }else{
            return response()->json([
                'res' => false, 
                    'message' => "ERROR AL CREAR EL REGISTRO, GRACIAS"], 200); 
        }    
    }
}
