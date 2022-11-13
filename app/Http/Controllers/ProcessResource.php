<?php

namespace App\Http\Controllers;

use App\Models\bagian_baju;
use App\Models\Material;
use App\Models\Process;
use App\Models\processMaterial;
use App\Models\Production;
use App\Models\production_process_type;
use App\Models\SubProses;
use Illuminate\Http\Request;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $produksi = Production::find($request->production_id);
        $listProcess= production_process_type::where('production_type_id', $produksi->production_type)->pluck('process_type_id');
        $index=array_search($request->process_id, $listProcess->toArray());


        if($request['process_output_material_id']==0){
            $bagianBaju=bagian_baju::where('production_id', $request->production_id)->where('bagian_id',"!=",5)->get();
            $ukuranBagian=Material::whereIn('bagian_baju_id',$bagianBaju->pluck('id'))->get();

            $processMat=processMaterial::where('process_id',$request->process_id)->get();
            // dd($processMat,$ukuranBagian);
            
            foreach($ukuranBagian as $ukuran){
                if($request['process_output_bagian_'.$ukuran->id]== 0){
                    continue;
                }
                else{
                    if(in_array($ukuran->id,$processMat->pluck('material_id')->toArray())){
                        $processMaterial=processMaterial::where('process_id',$request->process_id)->where('material_id',$ukuran->id)->first();
                    }
                    else{
                        $processMaterial=processMaterial::create([
                            'process_id'=>$request->process_id,
                            'material_id'=>$ukuran->id,
                            'process_material_name'=>$ukuran->material_name,
                            'process_material_quantity'=>0,
                            'process_material_status'=>'Output Produksi',
                        ]);
                        processMaterial::create([
                            'process_id'=>$listProcess[$index+1],
                            'material_id'=>$ukuran->id,
                            'process_material_name'=>$ukuran->material_name,
                            'process_material_quantity'=>0,
                            'process_material_status'=>'Input Produksi',
                        ]);
                    }
                    $Subproses=SubProses::create([
                        'process_material_id'=>$processMaterial->id,
                        'process_id'=>$request->process_id,
                        'user_id'=>$request->user_id,
                        'sub_proses_name'=>"User".$request->user_id." ".$processMaterial->process_material_name,
                        'sub_proses_projected'=>$request['process_output_bagian_'.$ukuran->id],
                        'sub_proses_actual'=>0,
                        
                    ]);
                    
                    
                }
            }
        }
        else{
            $processMaterial=processMaterial::where('process_id',$request->process_id)->where('material_id',$request['process_output_material_id'])->first();
            if($processMaterial==null){
                $processMaterial=processMaterial::create([
                    'process_id'=>$request->process_id,
                    'material_id'=>$request['process_output_material_id'],
                    'process_material_name'=>Material::find($request['process_output_material_id'])->material_name,
                    'process_material_quantity'=>0,
                    'process_material_status'=>'Output Produksi',
                ]);
                processMaterial::create([
                    'process_id'=>$listProcess[$index+1],
                    'material_id'=>$request['process_output_material_id'],
                    'process_material_name'=>Material::find($request['process_output_material_id'])->material_name,
                    'process_material_quantity'=>0,
                    'process_material_status'=>'Input Produksi',
                ]);
            }
            $Subproses=SubProses::create([
                'process_material_id'=>$processMaterial->id,
                'process_id'=>$request->process_id,
                'user_id'=>$request->user_id,
                'sub_proses_name'=>"User".$request->user_id." ".$processMaterial->process_material_name,
                'sub_proses_projected'=>$request['process_output_quantity'],
                'sub_proses_actual'=>0,
                
            ]);
        }
        return redirect('/production/'.$request->production_id.'/edit')->with('succes', 'Proses Berhasil Ditambahkan');


        
        
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
        
        $Subproses=SubProses::where('user_id',$request->user_id)->where('process_id',$request->process_id)->get();
        foreach ($Subproses->pluck('id') as $sub) {
            $subproses=SubProses::find($sub);
            $subproses->sub_proses_actual=$subproses->sub_proses_projected-$request['sub_proses_projected_'.$sub]+$subproses->sub_proses_actual;
            $subproses->sub_proses_projected=$request['sub_proses_projected_'.$sub];
            $subproses->save();

            $processMaterial=processMaterial::find($subproses->process_material_id);
            $processMaterial->process_material_quantity=$processMaterial->process_material_quantity+$subproses->sub_proses_actual;
            $processMaterial->save();

            $processMaterial=processMaterial::find($subproses->process_material_id+1);
            $processMaterial->process_material_quantity=$processMaterial->process_material_quantity+$subproses->sub_proses_actual;
            $processMaterial->save();


        }

        return redirect('/production/'.$process->production_id.'/edit')->with('succes', 'Proses Berhasil Diupdate');
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

    public function generatePDF($id)
    {
        
        $pdf = PDF::loadView('process.processPDF', compact('id'));
        return $pdf->download('process'.$id.'.pdf');
        
        // return view('process.processPDF', compact('process','qr'));
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
