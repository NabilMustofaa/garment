<?php

namespace App\Http\Controllers;

use App\Models\process_type;
use App\Models\production_process_type;
use App\Models\production_type;
use Illuminate\Http\Request;

class ProductionTypeResource extends Controller
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
        $processTypes=process_type::whereNotIn('id',[1,5])->get();
        return view('productionType.create',compact('processTypes'));
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
            'role'=>'required|array',
        ]);
        production_type::create([
            'production_type_name'=>$validated['name'],
        ]);
        production_process_type::create([
            'production_type_id'=>production_type::latest()->first()->id,
            'process_type_id'=>1,
        ]);

        foreach($validated['role'] as $role){
            production_process_type::create([
                'production_type_id'=>production_type::latest()->first()->id,
                'process_type_id'=>$role,
            ]);
        }

        production_process_type::create([
            'production_type_id'=>production_type::latest()->first()->id,
            'process_type_id'=>5,
        ]);

        return redirect('/process');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\production_type  $production_type
     * @return \Illuminate\Http\Response
     */
    public function show(production_type $production_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\production_type  $production_type
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productionType=production_type::find($id);
        $processTypes=process_type::whereNotIn('id',[1,5])->get();
        return view('productionType.edit',compact('productionType','processTypes'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\production_type  $production_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)

    {

        $validated=$request->validate([
            'name'=>'required',
            'process'=>'required|array',
        ]);
        $productionType=production_type::find($id);
        $productionType->production_type_name=$validated['name'];
        $productionType->save();

        $productionProcessType=production_process_type::where('production_type_id',$id)->get();
        foreach($productionProcessType as $process){
            $process->delete();
        }

        foreach ($validated['process'] as $process) {
            production_process_type::create([
                'production_type_id'=>$id,
                'process_type_id'=>$process,
            ]);
        }

        return redirect('/process');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\production_type  $production_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(production_type $production_type)
    {
        //
    }
}
