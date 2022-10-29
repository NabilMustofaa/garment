<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Production;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class productionResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productions = Production::all();
        return view('production.indexProduction', compact('productions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materials = Material::all();
        return view('production.formProduction', compact('materials'));
        
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
            'name' => 'required',
            'description' => 'required',
            'end_date' => 'required',
            'input_quantity' => 'required',
            'material_id' => 'required',
            'output_quantity' => 'required',
        ]);
        $validated['status'] = 'started';
    
        $data=[
            'production_name' => $validated['name'],
            'production_description' => $validated['description'],
            'production_status' => $validated['status'],
            'production_projected_end_date' => $validated['end_date'],
            'production_input_quantity' => $validated['input_quantity'],
            'production_material_id' => $validated['material_id'],
            'production_output_quantity' => $validated['output_quantity'],
        ];
    
        Production::create($data);
        $qr=QrCode::size(100)->generate('Hello');
        return redirect("/production")->with('success', 'Production created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show(Production $production)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        $materials = Material::all();
        $processes = $production->process;
        return view('production.editProduction', compact('production', 'materials', 'processes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        //
    }
}
