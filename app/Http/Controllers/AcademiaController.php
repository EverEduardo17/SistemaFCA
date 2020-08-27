<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademiaRequest;
use App\Academia;
use App\Academico;
use Illuminate\Http\Request;

class AcademiaController extends Controller
{
    public function index()
    {
        return view('academias.index', [
            'academias' => Academia::get()
        ]);
    }

    public function create()
    {
        return view('academias.create', [
            'academia' => new Academia,
            'coordinadores' => Academico::get()
        ]);
    }

    public function store(AcademiaRequest $request)
    {
        Academia::create( $request->validated() );
        return redirect()->route('academias.index');
    }

    public function show(Academia $academia)
    {
        
    }

    public function edit(Academia $academia)
    {
        return view('academias.edit', [
            'academia' => $academia,
            'coordinadores' => Academico::get()
        ]);
    }

    public function update(AcademiaRequest $request, Academia $academia)
    {
        $academia->update( $request->validated() );
        return redirect()->route('academias.index');
    }

    public function destroy(Academia $academia)
    {
        $academia->delete();
        return redirect()->route('academias.index');
    }
}
