<?php

namespace App\Http\Controllers;

use App\Models\Process;
use Illuminate\Http\Request;

class ProcessResource extends Controller
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
        $validated=$request->validate([
            'user_id' => 'required',
            'production_id' => 'required',
            'process_name' => 'required',
            'process_input_material_id' => 'required',
            'process_input_quantity' => 'required',
            'process_output_material_id' => 'required',
            'process_output_quantity' => 'required',
            'process_status' => 'required',
            'process_start_date' => 'required',
            'process_end_date' => 'required',
        ]);
        
        $data=[
            'user_id' => $validated['user_id'],
            'production_id' => $validated['production_id'],
            'process_name' => $validated['process_name'],
            'process_input_material_id' => $validated['process_input_material_id'],
            'process_input_quantity' => $validated['process_input_quantity'],
            'process_output_material_id' => $validated['process_output_material_id'],
            'process_output_quantity' => $validated['process_output_quantity'],
            'process_status' => $validated['process_status'],
            'process_start_date' => $validated['process_start_date'],
            'process_end_date' => $validated['process_end_date'],
        ];

        $result=Process::create($data);

        //return json
        return response()->json([
            'status' => 'success',
            'message' => 'Process created successfully',
            'data' => $result
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function show(Process $process)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function edit(Process $process)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Process $process)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $process)
    {
        Process::destroy($process->id);
        return response()->json([
            'status' => 'success',
            'message' => 'Process deleted successfully',
        ]);
    }
    public function change (Process $process){
        return view('process.updateProcess', compact('process'));
    }

    public function finish (Request $request,Process $process)
    {
        $validated=$request->validate([
            'process_output_quantity' => 'required',
        ]);

        if($validated['process_output_quantity']<$process->process_output_quantity){
            $validated['process_status']='problem';
            $validated['process_message']='The output quantity is less than the expected quantity';
        }else{
            $validated['process_status']='finished';
            $validated['process_message']='The process is finished';
            
        }
        
        $process->update($validated);
        return redirect("/production/1/edit");
       
    }
    public function finished(){
        return view('process.finish');
    }
}
