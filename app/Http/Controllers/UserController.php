<?php

namespace App\Http\Controllers;

use App\Events\MessageDeleteEvent;
use App\Events\MessageEvent;
use App\Events\MessageUpdatedEvent;
use App\Models\Chat;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users=User::whereNotIN('id',[Auth::user()->id])->get();
        return view('dashboard',get_defined_vars());
    }
    public function saveChat(Request$request)
    {

        try {
            $chat = Chat::create($request->all());
            MessageEvent::dispatch($chat);
            return response()->json(['success' => true, 'data' => $chat]);


        } catch (\Exception $exception) {

            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);

        }
    }



    public function loadChat(Request $request){
        try{
            $chat=Chat::where(function ($q) use ($request){
                $q->where('sender_id',$request->sender_id)->orWhere('sender_id',$request->receiver_id);

            })->where(function ($q) use ($request){
                $q->where('receiver_id',$request->sender_id)->orWhere('receiver_id',$request->receiver_id);

            })->get();
            return  response()->json(['success'=>true,'data'=>$chat]);


        }  catch (\Exception $exception){

            return  response()->json(['success'=>false,'msg'=>$exception->getMessage()]);

        }




        }
        public function deleteChat(Request$request){
            try{

                $caht=Chat::find($request->id);
                $caht->delete();
event(new MessageDeleteEvent($request->id));
                return  response()->json(['success'=>true,'data'=>1]);

        }  catch (\Exception $exception){

return  response()->json(['success'=>false,'msg'=>$exception->getMessage()]);

}
        }


    public function updateChat(Request$request){
        try{

            $caht=Chat::find($request->id);
            $caht->update(['message'=>$request->message]);
            event(new MessageUpdatedEvent($caht));
            return  response()->json(['success'=>true,'data'=>1]);

        }  catch (\Exception $exception){

            return  response()->json(['success'=>false,'msg'=>$exception->getMessage()]);

        }
    }



}
