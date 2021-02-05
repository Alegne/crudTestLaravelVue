<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Personnel;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('q') && request('q') != '') {
            $perso = Personnel::where('matricule', 'like', '%'.request('q').'%')->orderBy('created_at', 'desc')->get();
            return response()->json(['perso'=>$perso]);
        } else {
            return $this->refresh();
        }
        
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

        $perso = Personnel::create($request->all());
        if ($perso) {
            return $this->refresh();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $perso = Personnel::find($id);
        $perso->matricule = request('matricule');
        $perso->nom = request('nom');
        $perso->prenom = request('prenom');
        $perso->dateNaiss = request('dateNaiss');
        $perso->lieuNaiss = request('lieuNaiss');
        $perso->cin = request('cin');
        $perso->poste = request('poste');
        $perso->save();

        if($perso){
            return $this->refresh();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perso = Personnel::find($id);
        if ($perso->delete()) {
            return $this->refresh();
        } else {
            return response()->json(['error' => 'Erreur lors de la suppression!'], 425);
        }
    }

    protected function refresh(){
        $perso = Personnel::orderBy('created_at', 'desc')->get();
        return response()->json(['perso'=>$perso]);
    }
}
