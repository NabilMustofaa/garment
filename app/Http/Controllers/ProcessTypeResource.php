<?php

namespace App\Http\Controllers;

use App\Models\process_type;
use Illuminate\Http\Request;

class ProcessTypeResource extends Controller
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
        return view('processType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'name'=>'required',
        ]);
        process_type::create([
            'process_type_name'=>$request->name,
        ]);
        return redirect('/process');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\process_type  $process_type
     * @return \Illuminate\Http\Response
     */
    public function show(process_type $process_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\process_type  $process_type
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $processType=process_type::find($id);
        return view('processType.edit', compact('processType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\process_type  $process_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated=$request->validate([
            'name'=>'required',
        ]);
        $process_type=process_type::find($id);
        $process_type->update([
            'process_type_name'=>$request->name,
        ]);
        return redirect('/process');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\process_type  $process_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(process_type $process_type)
    {
        //
    }
}
