<?php

namespace App\Http\Controllers;

use App\hpo;
use Illuminate\Http\Request;

class HpoController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\hpo  $hpo
     * @return \Illuminate\Http\Response
     */
    public function show($identifier)
    {
        //dd($identifier);
        $hpo = Hpo::select('identifier', 'term_name', 'description')->where('identifier', $identifier)->get();
        return response()->json($hpo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\hpo  $hpo
     * @return \Illuminate\Http\Response
     */
    public function edit(hpo $hpo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\hpo  $hpo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, hpo $hpo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\hpo  $hpo
     * @return \Illuminate\Http\Response
     */
    public function destroy(hpo $hpo)
    {
        //
    }
}
