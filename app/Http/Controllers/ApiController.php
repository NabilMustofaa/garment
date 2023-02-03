<?php

namespace App\Http\Controllers;

use App\Models\colour;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialSubCategory;
use App\Models\PersonProcess;
use App\Models\Process;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getRoles($id){
        $user= User::find($id);
        $roles= $user->personProcess;
        return response()->json($roles);
    }

    public function getProcessUser($id){
        $processid= Process::find($id)->process_type;
        $process= PersonProcess::where('process_type_id',$processid)->get();
        $userid= $process->pluck('user_id');
        $user= User::whereIn('id',$userid)->get();
        return response()->json($user);
    }
    public function getMaterialBySubCategory($id){
        $material= Material::where('material_sub_category_id',$id)->get();
        return response()->json($material);
    }
    public function getMaterialQuantity($id){
        $material=Material::find($id);
        return response($material->material_quantity);
    }

    public function searchColour(Request $request){
        $colour= $request->colour_name;
        $colours= colour::where('colour_name','like','%'.$colour.'%')->get();
        return response()->json($colours);
    }

    public function getColour($id){
        $colour= colour::find($id);
        return response()->json($colour);
    }
    public function postColour(Request $request){
        $colour= colour::create([
            'colour_code' => '#ffffff',
            'colour_name' => $request->colour_name,
        ]);
        return response()->json($colour);
    }

    public function getSubCategory($id){
        $materialSubCategory= MaterialSubCategory::where('material_category_id',$id)->get();
        return response()->json($materialSubCategory);
    }

    public function postSubCategory(Request $request){
        $subcategory=MaterialSubCategory::create([
              'sub_category_name' => $request->sub_category_name,
              'material_category_id' => $request->category_id,
       ]);
        return response()->json($subcategory);


    }

    public function getMaterialByCategory($id){
        $materialSubCategory= MaterialSubCategory::where('material_category_id',$id)->get();
        $material= Material::whereIn('material_sub_category_id',$materialSubCategory->pluck('id'))->get();
        return response()->json($material);
    }

    

}
