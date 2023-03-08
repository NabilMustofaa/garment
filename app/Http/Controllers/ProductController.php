<?php

namespace App\Http\Controllers;

use App\Models\MaterialHistory;
use App\Models\PersonProcess;
use App\Models\Process;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
       $users=Process::find($product->current_process_id)->process_type;
       $users=PersonProcess::where('process_type_id',$users)->get();
       $users=User::whereIn('id',$users->pluck('user_id'))->get();

       $nextProcess = Process::whereIn('id',$product->productLog->pluck('process_id'))->get();
       $nextProcess = $nextProcess->sortBy('process_type')->pluck('id');
        $index = $nextProcess->search($product->current_process_id);
        
        dump($nextProcess);

        if($index === false){
            $nextProcess=Process::where('process_type',5)->where('production_id',$product->production_id)->first();;
        }
        else if($index < $nextProcess->count()-1){
            $nextProcess=Process::find($nextProcess->get($index+1));
            
        }else{
            $nextProcess=Process::where('process_type',5)->where('production_id',$product->production_id)->first();
        }
       
        
        return view('product.show', compact('product','users','nextProcess'));
    }

    public function printPDF(Product $product)
    {
        return view('product.printPDF', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $productLog = ProductLog::where('process_id', $product->current_process_id)->where('product_id', $product->id)->first();
        $productLog->update([
            'user_id' => $request->user_id,
            'accepted_at' => now(),
        ]);
        
        if($request->permak == 1){
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
        $product->update([
            'current_process_id' => $nextProcess->id,
        ]);

        return redirect()->back()->with('alert', 'Product has been updated, proses selanjutnya adalah '.$nextProcess->process_name);

        


    }

}
