<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Helpers\FileHelper;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $messages=Message::where('user_id',auth()->user()->id)->get();

        return view("website.messages.index", ['messages' => $messages]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return view("website.messages.create", ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {

        $path="";
        if($request->hasFile('image')){
            $path=FileHelper::storeFile($request->file('image'));

        }

        $data=Message::create([
            'text'=>$request->text,
            'email'=>$request->email,
            'image'=>$path,
            'user_id'=>$request->user_id,
            'ip'=>$request->ip,
            'location'=>$request->location,
        ]);

        if($data){
            return response()->json([
                'status'=>200,
                'message'=>"store message success",
                'data'=> $data,
            ]);
        }else{
            return response()->json([
                'status'=>200,
                'message'=>"store message success",
                'data'=> $data,
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {

        $message->delete();

        return redirect()->back()->with('success', 'Message delete successfully');

    }
}
