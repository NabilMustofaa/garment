<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\Process;
use App\Models\processMaterial;
use App\Models\SubProcessHistory;
use App\Models\SubProses;
use Illuminate\Http\Request;

class SubProcessResource extends Controller
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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubProses  $subProses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subProses = SubProcessHistory::find($id);
        $listProcess = $subProses->subProcess->process->production->type->production_process->pluck('process_type_id');

        return view('subproses.show', compact('subProses', 'listProcess'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubProses  $subProses
     * @return \Illuminate\Http\Response
     */
    public function edit(SubProses $subProses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubProses  $subProses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        SubProcessHistory::create([
            'sub_process_id' => $id,
            'quantity' => $request->quantityAmbil
        ]);

        return redirect()->back()->with('success', 'Sub Proses Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubProses  $subProses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subProses = SubProses::find($id);
        $subProsesHistory = SubProcessHistory::where('sub_process_id', $id)->get();
        foreach ($subProsesHistory as $subProsesHistory) {
            $subProsesHistory->delete();
        }
        $subProses->delete();

        return redirect()->back()->with('success', 'Sub Proses Berhasil Dihapus');
        
    }
    public function destroyHistory($id)
    {
        $subProsesHistory = SubProcessHistory::find($id);


        $subProsesHistory->delete();

        return redirect()->back()->with('success', 'Sub Proses Berhasil Dihapus');
        
    }

    public function updateQuantity (Request $request, SubProses $subproses) {

        $listProcess= Process::where('production_id',$request->production_id)->get();
        $listProcess=$listProcess->sortBy('process_type');

            //change order for process type =5 to last
            $no=0;
            foreach($listProcess as $pros){
                
                if($pros->process_type==5){
                    $listProcess->splice($no,1);
                    $listProcess->push($pros);
                    
                }
                $no++;
            }
            $listProcess=$listProcess->pluck('id')->toArray();
            $index=array_search($request->process_id, $listProcess);



        
        //array append
        $processMaterial[]=$subproses->processMaterial;
        if (strpos($subproses->processMaterial->process_material_name, '(Rusak)')) {
            $processName=Process::find($listProcess[$index]);
            $processName=$processName->type->process_type_name;
            $processMaterial[]=processMaterial::where('process_material_name',$subproses->processMaterial->process_material_name)->where('process_id',$listProcess[$index-1])->where('process_material_status','Input Produksi')->first();
            $name=str_replace(' '.$processName.' (Rusak)','',$subproses->processMaterial->process_material_name);
            $processMaterial[]=processMaterial::where('process_material_name',$name)->where('process_id',$listProcess[$index+1])->first();
            $processMaterial[]=processMaterial::where('process_material_name',$name)->where('process_id',$listProcess[$index-1])->where('process_material_status','Output Produksi')->first();
            

        }
        else{
            $processMaterial[]=processMaterial::where('process_material_name',$subproses->processMaterial->process_material_name)->where('process_id',$listProcess[$index+1])->first();
        }
        // dd($name,$processMaterial,$listProcess,$index);
        foreach ($processMaterial as $pm) {
            
            $pm->process_material_quantity=$pm->process_material_quantity+$request->quantity;
            $pm->save();

            $material=$pm->material;
            $material->material_quantity=$material->material_quantity+$request->quantity;
            $material->save();

            if($pm->subProses != null){
               foreach($pm->subProses as $sub){
                    $sub->sub_proses_actual=$sub->sub_proses_actual+$request->quantity;
                    $sub->save();
               }
            }

            MaterialHistory::create([
                'material_id'=>$pm->material->id,
                'quantity'=>$request->quantity,
                'description'=>'Pengambilan Untuk '.$subproses->sub_proses_name
            ]);
        }
        $subProsesHistory=SubProcessHistory::find($request->sph_id);
        $subProsesHistory->is_done=true;
        $subProsesHistory->save();

        $subproses->sub_proses_actual=$subproses->sub_proses_actual+$request->quantity;
        $subproses->save();

        return back()->with('success', 'Sub Proses Berhasil Diupdate');
    }

    public function reportPage($id) {
        $subProses = SubProcessHistory::find($id);

        return view('subproses.report', compact('subProses'));
    }

    public function report(Request $request, $id) {
        $subProsesHistory = SubProcessHistory::find($id);
        $quantityAman=$request['quantity']-$request['quantity_rusak'];
        $subproses = SubProses::find($subProsesHistory->sub_process_id);
        $listProcess= Process::where('production_id',$subproses->process->production_id)->get();
        $listProcess=$listProcess->sortBy('process_type');

            //change order for process type =5 to last
            $no=0;
            foreach($listProcess as $pros){
                
               if($pros->process_type==5){
                    $listProcess->splice($no,1);
                    $listProcess->push($pros);
                    
                }
                $no++;
                
            }

            $listProcess=$listProcess->pluck('id')->toArray();
            $index=array_search($request->process_id, $listProcess);



        //array append
        $processMaterial[]=$subproses->processMaterial;
        if(strpos(Process::find($listProcess[$index+1])->process_name, 'Permak') !== false){
            $processMaterial[]=processMaterial::where('process_material_name',$subproses->processMaterial->process_material_name)->where('process_id',$listProcess[$index+2])->first();
        }
       
        else{
            $processMaterial[]=processMaterial::where('process_material_name',$subproses->processMaterial->process_material_name)->where('process_id',$listProcess[$index+1])->where('process_material_status','Input Produksi')->first();
        }


        // dd($processMaterial,$subproses->processMaterial->process_material_name,$listProcess,$index,Process::find($listProcess[$index+1])->process_name);
        


        foreach ($processMaterial as $pm) {
            $pm->process_material_quantity=$pm->process_material_quantity+$quantityAman;
            $pm->save();
            $pm->material->material_quantity=$pm->material->material_quantity+$quantityAman;
            $pm->material->save();

            MaterialHistory::create([
                'material_id'=>$pm->material->id,
                'quantity'=>$quantityAman,
                'description'=>'Pengambilan Untuk '.$subproses->sub_proses_name
            ]);
        }
        $subProsesHistory=SubProcessHistory::find($request->sph_id);
        $subProsesHistory->quantity=$quantityAman;
        $subProsesHistory->is_done=true;
        $subProsesHistory->save();

        $subproses->sub_proses_actual=$subproses->sub_proses_actual+$quantityAman;
        $subproses->save();

        $processList=Process::where('production_id',$subproses->process->production_id)->get();
        $processList=$processList->pluck('process_name')->toArray();
        $name = 'Permak untuk '.$subproses->process->type->process_type_name.' '.$subproses->process->production->production_name;
        if(!in_array($name, $processList)) {
            $process=Process::create([
                'production_id'=>$subproses->process->production_id,
                'process_type'=>$subproses->process->type->id,
                'process_name'=>'Permak untuk '.$subproses->process->type->process_type_name.' '.$subproses->process->production->production_name,
                'process_status'=>1,
                'process_start_date'=>date('Y-m-d H:i:s'),
                'process_end_date'=>date('Y-m-d H:i:s'),
            ]);
        }
        $process=Process::where('process_name',$name)->first();
        $findMaterial=Material::where('material_name',$subproses->processMaterial->process_material_name.' '.$subproses->process->type->process_type_name.' (Rusak)')->first();
        $productionProcess=Process::where('production_id',$subproses->process->production_id)->get();
        $productionProcess=$productionProcess->pluck('id')->toArray();
        
        if($findMaterial == null) {
            $material=Material::create([
                'material_name'=>$subproses->processMaterial->process_material_name.' '.$subproses->process->type->process_type_name.' (Rusak)',
                'material_description'=>$subproses->processMaterial->process_material_name.' '.$subproses->process->type->process_type_name.' (Rusak)',
                'material_quantity'=>$request['quantity_rusak'],
                'material_measure_unit'=>'pcs',
                'material_sub_category_id'=>999,
                'bagian_baju_id'=>5,
            ]);
            $pms=processMaterial::create([
                'process_id'=>$process->id,
                'material_id'=>$material->id,
                'process_material_name'=>$material->material_name,
                'process_material_quantity'=>$request['quantity_rusak'],
                'process_material_status'=>'Input Produksi',
            ]);

            $index=array_search($pms->process->id, $productionProcess);

            processMaterial::create([
                'process_id'=>$request->process_id,
                'material_id'=>$material->id,
                'process_material_name'=>$material->material_name,
                'process_material_quantity'=>0,
                'process_material_status'=>'Output Produksi',
            ]);

            
        } else{
            $materialProcess=$findMaterial->processMaterial;
            foreach ($materialProcess as $mp) {
                $mp->process_material_quantity=$mp->process_material_quantity+$request['quantity_rusak'];
                $mp->save();
            }

        }

        

        return redirect()->back()->with('success', 'Laporan Berhasil Dikirim');
    }

    public function submitAll(Request $request){
        $count=0;
        foreach ($request->subProcess as $subProcess) {
            SubProcessHistory::create([
                'sub_process_id'=>$subProcess,
                'quantity'=>$request->quantity[$count++],
            ]);

        }
        return redirect()->back()->with('success', 'Sub Proses Berhasil Diupdate');
    }
}
