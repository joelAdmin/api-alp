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
        Message::where('chat_id', $chat_id)->where('receptor_id', auth()->user()->usuario_id)->update(['estatus'=> 1]);

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

    public function sendMessageAudio(Request $request){
        $request->request->add(['fecha'=>date('Y-m-d'), 'estatus'=>1, 'attachment'=>1]);
        $path_img = "/images/";//dirname(__FILE__)."/images/";

        $nombre_archivo_plano    = date("Ymd").md5(date("Y-m-d H:i:s")).rand(5000,999999).md5(date("Y-m-d H:i:s")).'.jlssystem.com';
        $path   =   $path_img.'uploads/attachment/chats/'.$request->get('chat_id').'/'.$nombre_archivo_plano;
        $url    =   'uploads/attachment/chats/'.$request->get('chat_id').'/'.$nombre_archivo_plano;
        //file_put_contents($path, $this->input->post("audio"));
        $json_encode    =   json_encode(["upload_data"=>["url"=>$url,"tipo"=>"audio"]]);
        
        $message = new Message();
        $message->chat_id = $request->get('chat_id');
        $message->fecha = $request->get('fecha');
        $message->mensaje = json_encode($json_encode);
        $message->emisor_id = $request->get('emisor_id');
        $message->receptor_id = $request->get('receptor_id');
        $message->attachment = $request->get('attachment');
        $message->ogg = $request->get('ogg');
        
        if($message->save()){
             broadcast(new \App\Events\NewMessage($message));
            return response()->json([
                'res' => true, 
                    'message' => "REGISTRO CREADO CORRECTAMENTE, GRACIAS", "request"=>$request->get('ogg')], 200);   
        }else{
            return response()->json([
                'res' => false, 
                    'message' => "ERROR AL CREAR EL REGISTRO, GRACIAS"], 200); 
        }    
    }
	
	public function sendMessageFile(Request $request){
       $request->request->add(['fecha'=>date('Y-m-d'), 'estatus'=>1, 'attachment'=>1]);
       $path_upload	= 'images/uploads/attachment/chats/'.$request->get("chat_id");
	   $archivo = $request->file('file');
	   $raw_name = md5(rand(0,999).$archivo->getClientOriginalName());
	   $name = $raw_name.'.'.$archivo->getClientOriginalExtension();
	   $file_path= base_path().$path_upload.'/';
	   $full_path = $file_path.$archivo->getClientOriginalName();
		 
	   $url_original = $archivo->getRealPath();
       $upload_data = [
            'file_name'=>$archivo->getClientOriginalName(),
		   		'file_type'=>$archivo->getMimeType(),
            		'file_path'=>$file_path,
		   				'full_path'=>$full_path,
		   					'raw_name'=>$raw_name,
		   						"orig_name"=>$archivo->getClientOriginalName(),
								    "client_name"=>$archivo->getClientOriginalName(),
									    "file_ext"=>'.'.$archivo->getClientOriginalExtension(),
									        "file_size"=>$archivo->getSize(),
										        "is_image"=>false,
										            "image_width"=>null,
											            "image_height"=>null,
											                "image_type"=>"",
												                "image_size_str"=>"",
                                                                    "imagen_nueva"=>\Request::root().'/'.$path_upload.'/'.$name,
                                              		                    "nuevo_nombre"=>$name
        ];
		 
		$info_file = ['upload_data'=>$upload_data, 'path'=>$path_upload.'/'.$name];

        $info_file_original = json_encode($info_file);
        $message = new Message();
        $message->chat_id = $request->get('chat_id');
        $message->fecha = $request->get('fecha');
        $message->mensaje = json_encode($info_file);
        $message->emisor_id = $request->get('emisor_id');
        $message->receptor_id = $request->get('receptor_id');
        $message->attachment = $request->get('attachment');
        $message->ogg = $request->get('ogg');
		
        if($message->save()){
           /* if (!\File::exists($path_upload)){
                \File::makeDirectory($path_upload, 0775);
            }
            \File::copy($archivo, $path_upload.'/'.$name);*/
            \Storage::disk('local')->put('new_name_'.$name,  \File::get($archivo));  

            broadcast(new \App\Events\NewMessage($message));
            return response()->json([
                'res' => true, 
                    'message' => "REGISTRO CREADO CORRECTAMENTE, GRACIAS", "request"=>$archivo->getRealPath(), 'formData'=>$request->get('chat_id'), 'path_upload'=> $path_upload], 200);
        }else{
          return response()->json([
                'res' => false, 
                    'message' => "ERROR AL CREAR EL REGISTRO, GRACIAS"], 200);  
      }    
    }

    /*
    public function sendMessageFile(Request $request){
       $request->request->add(['fecha'=>date('Y-m-d'), 'estatus'=>1, 'attachment'=>1]);
       $path_upload	= 'images/uploads/attachment/chats/'.$request->get("chat_id");
	   $archivo = $request->file('file');
	   $raw_name = md5(rand(0,999).$archivo->getClientOriginalName());
	   $name = $raw_name.'.'.$archivo->getClientOriginalExtension();
	   $file_path= base_path().$path_upload.'/';
	   $full_path = $file_path.$archivo->getClientOriginalName();
		 
	   $url_original = $archivo->getRealPath();
       $upload_data = [
            'file_name'=>$archivo->getClientOriginalName(),
		   		'file_type'=>$archivo->getMimeType(),
            		'file_path'=>$file_path,
		   				'full_path'=>$full_path,
		   					'raw_name'=>$raw_name,
		   						"orig_name"=>$archivo->getClientOriginalName(),
								    "client_name"=>$archivo->getClientOriginalName(),
									    "file_ext"=>'.'.$archivo->getClientOriginalExtension(),
									        "file_size"=>$archivo->getSize(),
										        "is_image"=>false,
										            "image_width"=>null,
											            "image_height"=>null,
											                "image_type"=>"",
												                "image_size_str"=>"",
                                                                    "imagen_nueva"=>\Request::root().'/'.$path_upload.'/'.$name,
                                              		                    "nuevo_nombre"=>$name
        ];
		 
		$info_file = ['upload_data'=>$upload_data, 'path'=>$path_upload.'/'.$name];

        $info_file_original = json_encode($info_file);
        $message = new Message();
        $message->chat_id = $request->get('chat_id');
        $message->fecha = $request->get('fecha');
        $message->mensaje = json_encode($info_file);
        $message->emisor_id = $request->get('emisor_id');
        $message->receptor_id = $request->get('receptor_id');
        $message->attachment = $request->get('attachment');
        $message->ogg = $request->get('ogg');
		
        if($message->save()){
            if (!\File::exists($path_upload)){
                \File::makeDirectory($path_upload, 0775);
            }
            \File::copy($archivo, $path_upload.'/'.$name);

            broadcast(new \App\Events\NewMessage($message));
            return response()->json([
                'res' => true, 
                    'message' => "REGISTRO CREADO CORRECTAMENTE, GRACIAS", "request"=>$archivo->getRealPath(), 'formData'=>$request->get('chat_id'), 'path_upload'=> $path_upload], 200);
        }else{
          return response()->json([
                'res' => false, 
                    'message' => "ERROR AL CREAR EL REGISTRO, GRACIAS"], 200);  
      }    
    }
    **/
}
