<?php

namespace App\Http\Controllers;

use App\Models\bagian;
use App\Models\bagian_baju;
use App\Models\colour;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialHistory;
use App\Models\MaterialSubCategory;
use App\Models\Person;
use App\Models\PersonProcess;
use App\Models\Process;
use App\Models\processMaterial;
use App\Models\Product;
use App\Models\Production;
use App\Models\production_process_type;
use App\Models\production_type;
use App\Models\SubProses;
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
        $productions = Production::all()->sortByDesc('id');
        return view('production.indexProduction', compact('productions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materialCategory=MaterialCategory::whereNotIn('id',[998,999])->get();
        $productionType= production_type::all();
        $ukurans = ukuran::whereIn('id',[1,2,3,4,5])->get();
        
        return view('production.formProduction', compact('productionType', 'ukurans', 'materialCategory'));
        
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
        
        $prod = Production::where('production_name', $validated['name'])->count();
        if ($prod>0) {
            $validated['name'] = $validated['name']."-".$prod;
        }
        
        $data=[
            'production_name' => $validated['name'],
            'production_type' => $validated['production_type'],
            'production_description' => $validated['description'],
            'production_status' => $validated['status'],
            'production_projected_end_date' => $validated['end_date'],
        ];
        $production = Production::create($data);
        
        
        
        

        $types= production_process_type::where('production_type_id', $validated['production_type'])->get();
        $procesMats=array();
        foreach ($types as $type){
            
            $processMat=Process::create([
                'production_id' => $production->id,
                'process_type' => $type->process_type_id,
                'process_name' => $type->process_type->process_type_name." Untuk ".$validated['name'],
                'process_status' => $validated['status'],
                'process_start_date' => now(),
                'process_end_date' => now(),
            ]);
            array_push($procesMats, $processMat);
        }
        
        for ($i=1; $i <= $validated['totalMaterial']; $i++) { 
            $processMaterial=[
                'process_id' => $procesMats[1]->id,
                'material_id' => $request['material_id_'.$i],
                'process_material_name' => " Bahan ".Material::find($request['material_id_'.$i])->material_name,
                'process_material_quantity' => $request['input_quantity_'.$i],
                'process_material_status' => 'Input Produksi',
            ];
            processMaterial::create($processMaterial);
            
            $mts=Material::find($request['material_id_'.$i]);
            $mts->material_quantity=$mts->material_quantity-$request['input_quantity_'.$i];
            $mts->save();

            MaterialHistory::create([
                'material_id' => $request['material_id_'.$i],
                'quantity' => -$request['input_quantity_'.$i],
                'description' => 'Bahan untuk Produksi '.$validated['name'],
            ]);
        }


        $ukurans = ukuran::whereIn('id',[1,2,3,4,5])->get();
        $bagians = bagian::all();
        $warnas = colour::all();

        // for ($j=1; $j <= count($ukurans); $j++) {
        //     if ($request['output_quantity_'.$j]!=0) {
        //         foreach ($bagians as $bagian) {
        //             $bagiann=bagian_baju::create([
        //                 'bagian_id' => $bagian->id,
        //                 'ukuran_id' => $ukurans[$j-1]->id,
        //                 'production_id'=> $production->id,
        //             ]);
        //             $material=Material::create([
        //                 'material_name' => $bagian->name." Ukuran ".ukuran::find($ukurans[$j-1]->id)->name,
        //                 'material_description' => $validated['description'],
        //                 'material_quantity' => 0,
        //                 'material_measure_unit' => 'pcs',
        //                 'material_type' => 'Semi-Finished',
        //                 'bagian_baju_id' => $bagiann->id,
        //             ]);
        //             if ($bagiann->bagian_id == 5){
        //                 $processMaterial=[
        //                     'process_id' => $procesMats[0]->id,
        //                     'material_id' => $material->id,
        //                     'process_material_name' => $material->material_name,
        //                     'process_material_quantity' => $request['output_quantity_'.$j],
        //                     'process_material_status' => 'Output Produksi',
        //                 ];
        //                 processMaterial::create($processMaterial);
        //             }
        //         }
        //     }

        // }
        $i=0;
        $j=0;
        foreach ($request['output_quantity'] as $output) {
            //for each index

            if ($output != 0) {
                foreach ($bagians as $bagian) {
                    $bagiann=bagian_baju::create([
                        'bagian_id' => $bagian->id,
                        'ukuran_id' => $request['ukuran_id'][$j],
                        'colour_id' => $request['colour_id'][$i],
                        'production_id'=> $production->id,
                    ]);
                    
                    if ($bagiann->bagian_id == 5){
                        $material=Material::create([
                            'material_name' => $data['production_name']." Ukuran ".$ukurans[$request['ukuran_id'][$j]-1]->name." Warna ".$warnas[$request['colour_id'][$i]-1]->colour_name,
                            'material_description' => $validated['description'],
                            'material_quantity' => 0,
                            'material_measure_unit' => 'pcs',
                            'material_sub_category_id' => 999,
                            'bagian_baju_id' => $bagiann->id,
                        ]);

                        $processMaterial=[
                            'process_id' => $procesMats[0]->id,
                            'material_id' => $material->id,
                            'process_material_name' => $material->material_name,
                            'process_material_quantity' => $request['output_quantity'][$j],
                            'process_material_status' => 'Output Produksi',
                        ];
                        processMaterial::create($processMaterial);
                    }
                    $material=Material::create([
                        'material_name' => $bagian->name." Ukuran ".$ukurans[$request['ukuran_id'][$j]-1]->name." Warna ".$warnas[$request['colour_id'][$i]-1]->colour_name,
                        'material_description' => $validated['description'],
                        'material_quantity' => 0,
                        'material_measure_unit' => 'pcs',
                        'material_sub_category_id' => 999,
                        'bagian_baju_id' => $bagiann->id,
                    ]);
                }
            }
            $j++;
            if ($j%5==0) {
                $i++;
            }
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
        $productionType= production_type::all();
        
        $processes = Process::where('production_id', $production->id)->orderBy('process_type')->get();

        $processMaterials=processMaterial::whereIn('process_id', $processes->pluck('id'))->get();

        
        $bagianBaju=bagian_baju::where('production_id', $production->id)->where('bagian_id',"!=",5)->get();
        $ukuranBagian=Material::whereIn('bagian_baju_id',$bagianBaju->pluck('id'))->get();
        $materials = Material::whereIn('id', $processMaterials->pluck('material_id'))->whereNotIn('id',$ukuranBagian->pluck('id'))->whereIn('material_sub_category_id',[999,998])->get();
        
        $person=PersonProcess::where('process_type_id',2)->get();

        $bagians = bagian::all();

        $bagianBaju=bagian_baju::where('production_id', $production->id)->where('bagian_id',"=",5)->get();
        $ukuranBaju = ukuran::whereIn('id', $bagianBaju->pluck('ukuran_id'))->get();
        $warnaBaju = colour::whereIn('id', $bagianBaju->pluck('colour_id'))->get();
        $products = Product::where('production_id', $production->id)->get();

        
        // $ukurans=ukuran::whereIn('id', bagian_baju::where('production_id', $production->id)->pluck('ukuran_id'))->get();
        // $bagians=bagian::where('id','!=',5)->get();

        return view('production.detailProduction', compact('production', 'materials', 'processes', 'processMaterials', 'ukuranBagian', 'person', 'productionType', 'bagians', 'products', 'ukuranBaju', 'warnaBaju'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        $productionType= production_type::all();
        
        $processes = Process::where('production_id', $production->id)->get();
        $processMaterials=processMaterial::whereIn('process_id', $processes->pluck('id'))->get();
        $bagianBaju=bagian_baju::where('production_id', $production->id)->where('bagian_id',"!=",5)->get();
        $ukuranBagian=Material::whereIn('bagian_baju_id',$bagianBaju->pluck('id'))->get();
        $materials = Material::whereIn('id', $processMaterials->pluck('material_id'))->whereNotIn('id',$ukuranBagian->pluck('id'))->whereNotIn('material_sub_category_id',[999,998])->get();
        $person=PersonProcess::where('process_type_id',2)->get();

        
        
        // $ukurans=ukuran::whereIn('id', bagian_baju::where('production_id', $production->id)->pluck('ukuran_id'))->get();
        // $bagians=bagian::where('id','!=',5)->get();

        return view('production.editProduction', compact('production', 'materials', 'processes', 'processMaterials', 'ukuranBagian', 'person', 'productionType'));


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
        $validated = $request->validate([
            'production_name' => 'required',
            'production_description' => 'required',
            'production_type' => 'required',
            'production_projected_end_date' => 'required',
        ]);

        $production->production_name = $validated['production_name'];
        $production->production_description = $validated['production_description'];
        $production->production_type = $validated['production_type'];
        $production->production_projected_end_date = $validated['production_projected_end_date'];

        $production->save();

        return redirect("/production")->with('success', 'Production updated successfully.');


        
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

    public function send (Production $production){
        $process= Process::where('production_id', $production->id)->where('process_type',5)->first();
        $processMats = processMaterial::where('process_id', $process->id)->where('process_material_status', 'Input Produksi')->get();
        
        return view('production.sendProduction', compact('production', 'processMats'));
    }

    public function createSize (Production $production){
        return view('production.createSize', compact('production'));
    }

    public function storeSize (Production $production, Request $request){

        $ukuran=ukuran::create([
            'name' => $request->size,
        ]);
        $bagians = bagian::all();

        foreach ($bagians as $bagiann) {
            $bagian=bagian_baju::create([
                'bagian_id' => $bagiann->id,
                'ukuran_id' => $ukuran->id,
                'colour_id' => $request->color,
                'production_id' => $production->id,
            ]);

            if ($bagian->bagian_id == 5) {
                $material = Material::create([
                    'material_name' => $production->production_name." Ukuran ".$ukuran->name." Warna ".$request->search,
                    'material_description' => $production->production_description,
                    'material_quantity' => 0,
                    'material_measure_unit' => 'pcs',
                    'material_sub_category_id' => 999,
                    'bagian_baju_id' => $bagian->id,
                ]);
                processMaterial::create([
                    'process_material_name' => $production->production_name." Ukuran ".$ukuran->name." Warna ".$request->search,
                    'process_id' => $production->process->where('process_type', 1)->first()->id,
                    'material_id' => $material->id,
                    'process_material_quantity' => $request->quantity,
                    'process_material_status' => 'Input Produksi',
                ]);
                $processMaterial = processMaterial::create([
                    'process_material_name' => $production->production_name." Ukuran ".$ukuran->name." Warna ".$request->search,
                    'process_id' => $production->process->where('process_type', 5)->first()->id,
                    'material_id' => $material->id,
                    'process_material_quantity' => $request->quantity,
                    'process_material_status' => 'Output Produksi',
                ]);

            }
            Material::create([
                'material_name' => $bagiann->name." Ukuran ".$ukuran->name." Warna ".$request->search,
                'material_description' => $bagiann->name." Ukuran ".$ukuran->name." Warna ".$request->search,
                'material_quantity' => 0,
                'material_measure_unit' => 'pcs',
                'material_sub_category_id' => 999,
                'bagian_baju_id' => $bagian->id,
            ]);
        }



        return redirect("/production/".$production->id)->with('success', 'Size created successfully.');


    }
        

        
}
