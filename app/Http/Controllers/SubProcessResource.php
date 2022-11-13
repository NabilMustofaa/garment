<?php

namespace App\Http\Controllers;

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
        $subProses = SubProses::where('user_id', $id)->get();

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
    public function update(Request $request, SubProses $subProses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubProses  $subProses
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubProses $subProses)
    {
        //
    }
}
