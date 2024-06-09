<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\User;
use App\Models\Departement;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::all();
        return view('divisions.indexdivisions', compact('divisions'));
    }
    public function create()
    {
        // Récupérer tous les départements
        $departements = Departement::all();
        
        // Récupérer tous les chefs de division
        $chef_division = User::role('Chef division')->get();
    
        return view('divisions.createdivisions', compact('departements', 'chef_division'));
    }
    

    public function store(Request $request)
{
    // Validation des données
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'departement_id' => 'required|exists:departements,id',
        'chef_division_id' => 'nullable|exists:users,id', // Chef de division peut être null
    ]);

    try {
        // Création de la division avec les données validées
        Division::create($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('divisions.index')->with('success', 'Division créée avec succès.');
    } catch (\Exception $e) {
        // En cas d'erreur, redirection avec un message d'erreur
        return redirect()->route('divisions.index')->with('error', 'Une erreur est survenue lors de la création de la division.');
    }}
 

    public function edit(Division $division)
    {
        $divisions = Division::all();
        $chef_division = User::role('Chef division')->get();
         // Récupérer tous les départements
         $departements = Departement::all();
        return view('divisions.editdivisions', compact('division','departements','chef_division'));
    }

    public function update(Request $request, Division $division)
    {
        $division->update($request->only(['name', 'departement_id', 'chef_division_id']));
        return redirect()->route('divisions.index');
    }

    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('divisions.index');
    }
}
