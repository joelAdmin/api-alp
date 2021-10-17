<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'pgrw_chats';
    protected $primaryKey = 'chat_id';
    protected $fillable = ['fecha', 
                                'emisor_id', 
                                    'receptor_id', 
                                        'estatus',  
                                            'observacion', 
                                                'cargo', 
                                                    'nro_contacto', 
                                                        'nombre_solicitante'
                                                                            ];
    protected $guarded = ['chat_id'];

    public function user(){
        return $this->belongsTo('App\User', 'receptor_id', 'usuario_id');
    }
}
