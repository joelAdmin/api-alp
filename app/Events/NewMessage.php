<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\User;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastAs() //cliente escuchando este evento
    {
        return 'NewMessage';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('new-message.'.$this->message->receptor_id);
    }

    public function broadcastWith(){
        $user_receptor = User::find($this->message->receptor_id);
        $user_emisor = User::find($this->message->emisor_id);
        return ['emisor_id' => $user_emisor->usuario_id,
                    'receptor_id' => $user_receptor->usuario_id,
                        'chat_id' => $this->message->chat_id,
                            'user_receptor' => $user_receptor,
                                'user_emisor' => $user_emisor];
    }
}
