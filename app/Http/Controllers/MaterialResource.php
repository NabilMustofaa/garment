<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Material::all();
        return view('material.indexMaterial', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('material.formMaterial');
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
            'quantity' => 'required',
            'measure_unit' => 'required',
            'type' => 'required',
        ]);

        $data=[
            'material_name' => $validated['name'],
            'material_description' => $validated['description'],
            'material_quantity' => $validated['quantity'],
            'material_measure_unit' => $validated['measure_unit'],
            'material_type' => $validated['type'],
        ];

        Material::create($data);
        return redirect('/material')->with('success', 'Material created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        return view('material.editMaterial', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $validated=$request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'measure_unit' => 'required',
            'type' => 'required',
        ]);

        $data=[
            'material_name' => $validated['name'],
            'material_description' => $validated['description'],
            'material_quantity' => $validated['quantity'],
            'material_measure_unit' => $validated['measure_unit'],
            'material_type' => $validated['type'],
        ];

        $material->update($data);
        return redirect('/material')->with('success', 'Material updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return redirect('/material')->with('success', 'Material deleted successfully');
    }
}
