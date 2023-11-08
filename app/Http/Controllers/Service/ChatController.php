<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function chatList () 
    {

        $user_id = auth()->user()->id;
        // return $user_id;
        $get_chat_list_1 = DB::table('chats')->select(
            'users.id as user_id',
            'users.first_name',
            'users.last_name',
            'users.profile_image',
            DB::raw('(select message from chats as st where st.sender_id = `users`.`id` OR st.receiver_id = `users`.`id` order by created_at desc limit 1) as message'),
            DB::raw('(select deleted_by from chats as st where st.sender_id = `users`.`id` OR st.receiver_id = `users`.`id` order by created_at desc limit 1) as deleted_by'),
            DB::raw('(select count(id) from chats as st where st.sender_id = `users`.`id` and st.receiver_id = '. $user_id .' and st.read_at is NULL) as read_count'),
            'chats.created_at',
            'chats.id as chat_id'
        )
        ->leftJoin('users', 'users.id', '=', 'chats.receiver_id')
        ->where('chats.sender_id', $user_id);

        $get_chat_list_2 = DB::table('chats')->select(
            'users.id as user_id',
            'users.first_name',
            'users.last_name',
            'users.profile_image',
            DB::raw('(select message from chats as st where st.sender_id = `users`.`id` OR st.receiver_id = `users`.`id` order by created_at desc limit 1) as message'),
            DB::raw('(select deleted_by from chats as st where st.sender_id = `users`.`id` OR st.receiver_id = `users`.`id` order by created_at desc limit 1) as deleted_by'),
            DB::raw('(select count(id) from chats as st where st.sender_id = `users`.`id` and st.receiver_id = '. $user_id .' and st.read_at is NULL) as read_count'),
            'chats.created_at',
            'chats.id as chat_id'
        )
        ->leftJoin('users', 'users.id', '=', 'chats.sender_id')
        ->where('chats.receiver_id', $user_id)
        ->union($get_chat_list_1);

        $chatLists = DB::query()->fromSub($get_chat_list_2, 'p_pn')
            ->select('user_id', 'first_name', 'last_name', 'profile_image', 'message', 'deleted_by', 'chat_id', 'created_at', 'read_count')
            ->groupBy('user_id')->orderBy('created_at','desc')->get();
        // return $chatLists;         
        return view('service.chat.index', compact('chatLists'));    


    }


    public function readMessage()
    {
        return Chat::where('receiver_id', auth()->user()->id)->where('read_at', null)->update(['read_at' => now()]);
    }

}
