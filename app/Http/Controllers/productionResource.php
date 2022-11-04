<?php

namespace App\Http\Controllers;

use App\Models\bagian_baju;
use App\Models\Material;
use App\Models\Process;
use App\Models\processMaterial;
use App\Models\Production;
use App\Models\production_type;
use App\Models\ukuran;
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
        $materials = Material::where('material_type', 'Raw Material')->get();
        $productionType= production_type::all();
        $ukurans = ukuran::all();
        
        return view('production.formProduction', compact('materials', 'productionType', 'ukurans'));
        
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
            'production_type' => 'required',
            'description' => 'required',
            'end_date' => 'required',
            'input_quantity_1' => 'required',
            'material_id_1' => 'required',
            'totalMaterial' => 'required',
        ]);
        $validated['status'] = 'started';
        
        $data=[
            'production_name' => $validated['name'],
            'production_type' => $validated['production_type'],
            'production_description' => $validated['description'],
            'production_status' => $validated['status'],
            'production_projected_end_date' => $validated['end_date'],
        ];
        $production = Production::create($data);
        
        $processDefault=Process::create([
            'production_id' => $production->id,
            'user_id' => 1,
            'process_type' => 1,
            'process_name' => "Proses Default Untuk".$validated['name'],
            'process_status' => $validated['status'],
            'process_start_date' => now(),
            'process_end_date' => now(),
        ]);
        
        for ($i=1; $i <= $validated['totalMaterial']; $i++) { 
            $processMaterial=[
                'process_id' => $processDefault->id,
                'material_id' => $request['material_id_'.$i],
                'process_material_name' => $request['material_id_'.$i],
                'process_material_quantity' => $request['input_quantity_'.$i],
                'process_material_status' => 'Input Produksi',
            ];
            processMaterial::create($processMaterial);
        }

        $ukurans = ukuran::all();

        for ($j=1; $j <= count($ukurans); $j++) {
            $bagian=bagian_baju::create([
                'bagian_id' => 5,
                'ukuran_id' => $ukurans[$j-1]->id,
                'production_id'=> $production->id,
            ]);
            $material=Material::create([
                'material_name' => "Produk ".$validated['name']." Ukuran ".$request['ukuran_id_'.$j],
                'material_description' => $validated['description'],
                'material_quantity' => 0,
                'material_measure_unit' => 'pcs',
                'material_type' => 'Produk',
                'bagian_baju_id' => $bagian->id,
            ]);
            $processMaterial=[
                'process_id' => $processDefault->id,
                'material_id' => $material->id,
                'process_material_name' => $material->material_name,
                'process_material_quantity' => $request['output_quantity_'.$j],
                'process_material_status' => 'Output Produksi',
            ];
            processMaterial::create($processMaterial);

        }



        
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
        $processes = Process::where('production_id', $production->id)->where('process_type','!=',1)->get();
        $processMaterials=processMaterial::whereIn('process_id', $processes->pluck('id'))->get();
        dump($processMaterials);
        return view('production.editProduction', compact('production', 'materials', 'processes', 'processMaterials'));

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
        $production->delete();
        return redirect("/production")->with('success', 'Production deleted successfully.');
    }
}
