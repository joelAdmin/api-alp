<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'pgrw_chats_mensajes';
    protected $primaryKey = 'mensaje_id';
    protected $fillable = ['chat_id', 
                                'fecha', 
                                    'mensaje', 
                                        'emisor_id',  
                                            'receptor_id', 
                                                'estatus', 
                                                    'attachment', 
                                                        'ogg',
                                                            'detete'
                                                                    ];
    protected $guarded = ['mensaje_id'];

    public function user(){
        return $this->belongsTo('App\User', 'emisor_id', 'usuario_id');
    }
}
