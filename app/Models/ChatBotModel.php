<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBotModel extends Model
{
    use HasFactory;

    protected $table = 'chatbot_messages';
    protected $fillable = [
        'user_id',
        'sender',
        'message',
    ];

    public function getAllMessages()
    {
        return $this->all();
    }

    public function saveMessage($sender, $data)
    {
        ChatBotModel::create([
            'user_id' => auth()->id(),
            'sender' => $sender,
            'message' => $data
        ]);
    }
}