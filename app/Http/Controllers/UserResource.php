<?php

namespace App\Http\Controllers;

use App\Models\PersonProcess;
use App\Models\ProcessTypes;
use App\Models\User;
use Illuminate\Http\Request;

class UserResource extends Controller
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
    public function create()
    {
        $processTypes= ProcessTypes::whereNotIn('id',[1,5])->get();
        return view('user.create', compact('processTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated= $request->validate([
            'name'=>'required',
            'role'=>'array|required',
        ]);
        if($request->email != null && $request->password != null){
            $user= User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'isUser'=>1,
            ]);
        }else{
            $user= User::create([
                'name'=>$request->name,
                'isUser'=>0,
            ]);
        }
        foreach($request->role as $role){
            PersonProcess::create([
                'user_id'=>$user->id,
                'process_type_id'=>$role,
            ]);
        }
        return redirect('/process')->with('success','User berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $processTypes= ProcessTypes::whereNotIn('id',[1,5])->get();
        return view('user.edit', compact('user','processTypes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $validated= $request->validate([
            'name'=>'required',
            'process'=>'array|required',
        ]);
        if($request->email != null && $request->password != null){
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'isUser'=>1,
            ]);
        }else{
            $user->update([
                'name'=>$request->name,
                'isUser'=>0,
            ]);
        }
        PersonProcess::where('user_id',$user->id)->delete();
        foreach($request->process as $role){
            PersonProcess::create([
                'user_id'=>$user->id,
                'process_type_id'=>$role,
            ]);
        }
        return redirect('/process')->with('success','User berhasil diupdate');
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
