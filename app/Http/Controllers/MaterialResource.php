<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialHistory;
use FontLib\Table\Type\name;
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
        $materials = Material::where('material_sub_category_id','!=','999')->paginate(10);
        $materialCategory=MaterialCategory::whereNotIn('id',[998])->get();
        return view('material.indexMaterial', compact('materials','materialCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materialCategory=MaterialCategory::whereNotIn('id',[998,999])->get();
        return view('material.formMaterial', compact('materialCategory'));
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
            'sub_category_id' => 'required',
            'material_image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        $data=[
            'id'=>Material::latest()->first()->id+1,
            'material_name' => $validated['name'],
            'material_description' => $validated['description'],
            'material_quantity' => $validated['quantity'],
            'material_measure_unit' => $validated['measure_unit'],
            'material_sub_category_id' => $validated['sub_category_id'],
        ];

        if($request->hasFile('material_image')){
            $file = $request->file('material_image');
            $extension = $file->getClientOriginalExtension();
            $filename = $request['name'] . '.' . $extension;
            $file->move('uploads/material/', $filename);
            $data['material_image'] = $filename;
        }

        Material::create($data);

        MaterialHistory::create([
            'material_id' => Material::latest()->first()->id,
            'quantity' => $validated['quantity'],
            'description' => 'Material created',
        ]);

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
        $materialHistory=MaterialHistory::where('material_id',$material->id)->get();

        //sort materialHistory desc by created
        $materialHistory = $materialHistory->sortByDesc('created_at');

        return view('material.showMaterial', compact('material','materialHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        $materialCategory=MaterialCategory::whereNotIn('id',[998,999])->get();
        return view('material.editMaterial', compact('material','materialCategory'));
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
            'measure_unit' => 'required',
            'sub_category_id'=> 'required',
        ]);


        $data=[
            'material_name' => $validated['name'],
            'material_description' => $validated['description'],
            'material_measure_unit' => $validated['measure_unit'],
            'material_sub_category_id' => $validated['sub_category_id'],
        ];

        if($request->hasFile('material_image')){
            if($material->material_image == '' || $material->material_image == null){
                unlink('uploads/material/'.$material->material_image);
            }
            $file = $request->file('material_image');
            $extension = $file->getClientOriginalExtension();
            $filename = $request['name'] . '.' . $extension;
            $file->move('uploads/material/', $filename);
            $data['material_image'] = $filename;
        }

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

        if($material->material_image != 'default.jpg' && !$material->material_image == '' && !$material->material_image == null){
            unlink('uploads/material/'.$material->material_image);
        }
        $material->delete();
        return redirect('/material')->with('success', 'Material deleted successfully');
    }
    
    public function pageQuantity(Material $material)
    {
        return view('material.updateMaterial', compact('material'));
    }

    public function updateQuantity(Request $request, Material $material)
    {
        $validated=$request->validate([
            'quantity' => 'required',
            'description' => 'required',
        ]);

        $data=[
            'material_id' => $material->id,
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
        ];

        MaterialHistory::create($data);
        $material->material_quantity += $validated['quantity'];
        $material->save();
        return redirect('/material/'.$material->id)->with('success', 'Material quantity updated successfully');
    }
}
