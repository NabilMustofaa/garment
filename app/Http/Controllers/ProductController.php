<?php

namespace App\Http\Controllers;

use App\Models\MaterialHistory;
use App\Models\PersonProcess;
use App\Models\Process;
use App\Models\processMaterial;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\SubProses;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
    //    $users=Process::find($product->current_process_id)->process_type;
    //    $users=PersonProcess::where('process_type_id',$users)->get();
    //    $users=User::whereIn('id',$users->pluck('user_id'))->get();

        

       $nextProcess = Process::whereIn('id',$product->productLog->pluck('process_id'))->get();
       $nextProcess = $nextProcess->sortBy('process_type')->pluck('id');
        $index = $nextProcess->search($product->current_process_id);
        
        $subProcesses = SubProses::where('process_id',$product->current_process_id)->get();

        

        dump($nextProcess->get($index-1),$product->current_process_id);

        if($index === false){
            $nextProcess=Process::where('process_type',5)->where('production_id',$product->production_id)->first();;
        }
        else if($index < $nextProcess->count()-1){
            $nextProcess=Process::find($nextProcess->get($index+1));
            
        }else{
            $nextProcess=Process::where('process_type',5)->where('production_id',$product->production_id)->first();
        }
       
        
        return view('product.show', compact('product','nextProcess','subProcesses'));
    }

    public function printPDF(Product $product)
    {
        return view('product.printPDF', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $subProcess = SubProses::find($request->sub_process_id);
        $productLog = ProductLog::where('process_id', $product->current_process_id)->where('product_id', $product->id)->first();
        $productLog->update([
            'user_id' => $subProcess->user_id,
            'accepted_at' => now(),

        ]);

        if($request->permak == 1){
            $productLog->update([
                'permak' => 1,
            ]);

            $process = Process::where('process_type',Process::find($product->current_process_id)->process_type)->where('production_id',$product->production_id)->where('process_name','like','%Permak%')->first();
            
            if($process == null){
                $process = Process::create([
                    'production_id' => $product->production_id,
                    'process_name' => 'Permak untuk '.$product->currentProcess->process_name,
                    'process_type' => $product->currentProcess->process_type,
                    'process_status' => 1,
                    'process_start_date' => $product->currentProcess->process_start_date,
                    'process_end_date' => $product->currentProcess->process_end_date,
            ]);
            }
            
            $productLog = ProductLog::create([
                'product_id' => $product->id,
                'process_id' => $process->id,
            ]);

            $product->update([
                'current_process_id' => $process->id,
            ]);

            return redirect()->back()->with('alert', 'Product has been reported, proses selanjutnya adalah '.$process->process_name);
        }
        
        $nextProcess = Process::whereIn('id',$product->productLog->pluck('process_id'))->get();
        $nextProcess = $nextProcess->sortBy('process_type')->pluck('id');
        $index = $nextProcess->search($product->current_process_id);


        if($index < $nextProcess->count()-1){
            $nextProcess=Process::find($nextProcess->get($index+1));

        }else{
            $nextProcess=Process::where('process_type',5)->where('production_id',$product->production_id)->first();

            $material = $product->material;
            $material->update([
                'material_quantity' => $material->material_quantity + 1
            ]);

            MaterialHistory::create([
                'material_id' => $material->id,
                'quantity' => 1,
                'description' => 'Produk '.$product->kode_produk.' telah selesai diproses',
            ]);
        }

        $processMaterial = processMaterial::where('process_id',$nextProcess->id)->where('material_id',$product->material->id)->where('process_material_status','Input Produksi')->first();

        if ($processMaterial == null) {
            $processMaterial = processMaterial::create([
                'process_id' => $nextProcess->id,
                'material_id' => $product->material->id,
                'process_material_name' => $product->material->material_name,
                'process_material_quantity' => 0,
                'process_material_status' => 'Input Produksi',
            ]);
        }

        $processMaterial->update([
            'process_material_quantity' => $processMaterial->process_material_quantity + 1
        ]);

        $subProcess->update([
            'sub_proses_actual' => $subProcess->sub_proses_actual + 1
        ]);

        $product->update([
            'current_process_id' => $nextProcess->id,
        ]);


        return redirect()->back()->with('alert', 'Product has been updated, proses selanjutnya adalah '.$nextProcess->process_name);

        


    }

}
