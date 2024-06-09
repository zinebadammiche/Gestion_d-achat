<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\User;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::with('director')->get();
        return view('departements.indexdepartements', compact('departements'));
    }

    public function create()
    {
        $directeurs = User::role('Directeur')->get();
        return view('departements.createdepartements', compact('directeurs'));
    }

     

        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required',
                'directeur_id' => 'required|exists:users,id'
            ]);
        
            // Vérifiez les données envoyées
            // dd($request->all());
        
            // Créez un nouveau département
            $departement = new Departement();
            $departement->name = $request->name;
            $departement->directeur_id = $request->directeur_id;
            $departement->save();
        
            return redirect()->route('departements.indexdepartements');
        }

    public function edit(Departement $departement)
    {
        $directeurs = User::role('Directeur')->get();
        return view('departements.editdepartements', compact('departement', 'directeurs'));
    }

    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'name' => 'required',
            'directeur_id' => 'required|exists:users,id'
        ]);

        $departement->update([
            'name' => $request->name,
            'directeur_id' => $request->directeur_id
        ]);

        return redirect()->route('departements.indexdepartements');
    }

    public function destroy(Departement $departement)
    {
        $departement->delete();
        return redirect()->route('departements.indexdepartements');
    }
  
}
