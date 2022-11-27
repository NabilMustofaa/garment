<?php

namespace App\Http\Controllers;

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

        return view('subproses.show', compact('subProses'));
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

        $subProses = SubProses::find($id);
        $subProses->sub_proses_actual=$subProses->sub_proses_actual + $request->quantityAmbil;
        $subProses->save();

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
        $subProses=SubProses::find($subProsesHistory->sub_process_id);
        $subProses->sub_proses_actual=$subProses->sub_proses_actual - $subProsesHistory->quantity;
        $subProses->save();

        $subProsesHistory->delete();

        return redirect()->back()->with('success', 'Sub Proses Berhasil Dihapus');
        
    }

    public function updateQuantity (Request $request, SubProses $subproses) {
        $listProcess= Process::where('production_id',$subproses->process->production_id)->get()->pluck('id')->toArray();
        $index=array_search($request->process_id, $listProcess);

        //array append
       

        $processMaterial[]=$subproses->processMaterial;
        $processMaterial[]=processMaterial::where('process_material_name',$subproses->processMaterial->process_material_name)->where('process_id',$listProcess[$index+1])->first();

        foreach ($processMaterial as $pm) {
            $pm->process_material_quantity=$pm->process_material_quantity+$request->quantity;
            $pm->save();
            $pm->material->material_quantity=$pm->material->material_quantity+$request->quantity;
            $pm->material->save();
        }
        $subProsesHistory=SubProcessHistory::find($request->sph_id);
        $subProsesHistory->is_done=true;
        $subProsesHistory->save();

        return redirect('/production/'.$subproses->process->production_id.'/edit')->with('success', 'Sub Proses Berhasil Diupdate');
    }
}
