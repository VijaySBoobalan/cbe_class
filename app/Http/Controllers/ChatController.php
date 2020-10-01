<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\LiveChats;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 public function SendChatMessage(request $request){
		 $Chat = new Chat;
		 $Chat->session_id = $request->Chatsession_id;
		 $sesion_id=$Chat->session_id;
         $Chat->commenter_id =auth()->user()->id;
         $Chat->message = $request->messagechat;
		 $Chat->save();
		 $Data['status'] = 'success';
		 $Data['session_id'] =$sesion_id;
		 event(new LiveChats($Chat));
		 return response()->json($Data);
	 }
	public function getChats(request $request){
		$Data['messages']=Chat::where([['chats.session_id',$request->session_id]])
        ->leftJoin('users','chats.commenter_id','users.id')
        ->get()
        ->toArray();
		return view('chats.chatmessages',$Data);	
	}
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
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
