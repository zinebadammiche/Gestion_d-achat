<?php
namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Module;
use App\Models\SousModule;
use App\Models\Departement;
use App\Models\FicheTechnique;
use App\Models\Service;
use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DemandeController extends Controller
{
      // Chef de division crée une demande
      public function create(Request $request)
      {
          $request->validate([
              'module_name' => 'required|integer',
              'sous_module_name' => 'required|integer',
              'detail' => 'required|string',
              'justification' => 'required|string',
              'departement_name' => 'required|integer',
              'service_id' => 'required|integer', // Ajout de la validation pour service_id
              'article' => 'required|string',
              'caracteristique_technique' => 'required|string',  
              'quantite' => 'required|string',
              'date_de_livraison_souhaite' => 'required|date',
              'credit_estimatif' => 'required|numeric',
          ]);
      
          $user = Auth::user();
      
          // Création de la demande
          $demande = new Demande([
              'user_id' => $user->id,
              'module_id' => $request->module_name,
              'sous_module_id' => $request->sous_module_name,
              'departement_id' => $request->departement_name,
              'service_id' => $request->service_id, // Ajout de service_id
              'detail' => $request->detail,
              'justification' => $request->justification,
              'date_de_livraison_souhaite' => $request->date_de_livraison_souhaite,
              'credit_estimatif' => $request->credit_estimatif,
              'date_de_creation_demande' => now(), // Automatically set the current date
          ]);
      
          $demande->save();
      
          // Insérer les informations de la fiche technique
          $ficheTechnique = new FicheTechnique([
              'demande_id' => $demande->id,
              'article' => $request->article,
              'caracteristique_technique' => $request->caracteristique_technique,
              'quantite' => $request->quantite,
          ]);
      
          $ficheTechnique->save();
      
          return redirect()->route('demandes.index')->with('success', 'Demande créée avec succès.');
      }
      
    // Méthode pour récupérer tous les modules
    public function getAllModules()
    {
        $modules = Module::all();
        return response()->json($modules);
    }
    // Méthode pour récupérer tous les départements
 public function getAllDepartements()
 {
     $departements = Departement::all();
     return response()->json($departements);
 }

    // Méthode pour récupérer les sous-modules en fonction du module
    public function getSousModules(Request $request)
    {
        $module_id = $request->input('module_id');
        $sousModules = SousModule::where('module_id', $module_id)->get();
        return response()->json($sousModules);
    }

    // Méthode pour afficher le formulaire de modification
    public function edit($id)
    {
        $demande = Demande::with('ficheTechnique', 'departement')->findOrFail($id);
        $modules = Module::all();
        $sousModules = SousModule::all();
        $departements = Departement::all(); // Assurez-vous que vous avez un modèle `Departement`
    
        return view('demandes.edit', compact('demande', 'modules', 'sousModules', 'departements'));
    }
    
    public function update(Request $request, $id)
    {
        $demande = Demande::findOrFail($id);
        $demande->update($request->all());
    
        // Mise à jour de la fiche technique associée
        foreach ($request->fiche_technique as $fiche_technique_data) {
            $fiche_technique = FicheTechnique::findOrFail($fiche_technique_data['id']);
            $fiche_technique->update($fiche_technique_data);
        }
    
        return redirect()->route('demandes.validateform')->with('success', 'Demande mise à jour avec succès.');
    }
    // Méthode pour valider une demande par directeur 
    public function validateDemande($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->validation = "true";
        $demande->save();
     
    return redirect()->route('demandes.validateform')->with('success', 'Demande validée avec succès.');
}

     
    // Chef de service traite une demande et ajoute une pièce jointe
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:processing,completed', // Ajoutez d'autres statuts au besoin
        ]);
    
        $demande = Demande::findOrFail($id);
        $demande->status = $request->status;
        $demande->save();
    
        return redirect()->route('demandes.process')->with('success', 'Statut de la demande mis à jour avec succès.');
    }
    public function addAttachment(Request $request, $id)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:pdf|max:10000', // Vous pouvez ajuster les règles de validation selon vos besoins
        ]);
    
        // Recherche de la demande par son ID
        $demande = Demande::find($id);
    
        // Vérification si la demande existe
        if (!$demande) {
            return redirect()->route('demandes.process')->with('error', 'Demande non trouvée.');
        }
    
        if ($request->hasFile('attachment')) {
            // Stockage du fichier joint dans le dossier 'public/pieces_jointes'
            $path = $request->file('attachment')->store('public/pieces_jointes');
            
            // Attribution du chemin vers le fichier PDF à l'objet Demande
            $demande->pdf_path = Storage::url($path);
            
            // Enregistrement des modifications dans la base de données
            $demande->save();
        }
    
        // Redirection avec un message de succès
        return redirect()->route('demandes.process')->with('success', 'Pièce jointe ajoutée avec succès.');
    }
//affiche juste les demande creer par chefd connecte
    public function index(Request $request)
    {
        $user = Auth::user();
    
        // Récupérer les demandes créées par l'utilisateur connecté
        $query = Demande::with(['user', 'module', 'sousModule', 'departement', 'ficheTechnique'])
            ->where('user_id', $user->id);
            
     // Filtrer par module_id
     if ($request->filled('module_id')) {
        $query->where('module_id', $request->module_id);
    }

    // Filtrer par sous_module_id
    if ($request->filled('sous_module_id')) {
        $query->where('sous_module_id', $request->sous_module_id);
    }

    // Filtrer par service_id
    if ($request->filled('service_id')) {
        $query->where('service_id', $request->service_id);
    }

    // Filtrer par date de création
    if ($request->filled('created_from')) {
        $query->where('date_de_creation_demande', '>=', $request->created_from);
    }

    if ($request->filled('created_to')) {
        $query->where('date_de_creation_demande', '<=', $request->created_to);
    }

    // Filtrer par date de livraison souhaitée
    if ($request->filled('delivered_from')) {
        $query->where('date_de_livraison_souhaite', '>=', $request->delivered_from);
    }

    if ($request->filled('delivered_to')) {
        $query->where('date_de_livraison_souhaite', '<=', $request->delivered_to);
    }

    

    // Exécuter la requête
    $demandes = $query->get();
    $modules = Module::all();
    $sousModules = SousModule::all();
    $services = Service::all();
     

    return view('demandes.index', compact('demandes', 'modules', 'sousModules', 'services',  'user'));

         
    }
    

    public function index2(Request $request)
    {
        $user = Auth::user();
        $departement = Departement::where('directeur_id', $user->id)->first();
        if($departement) {
            $query = Demande::with(['user', 'module', 'sousModule', 'departement', 'ficheTechnique'])
                ->where('departement_id', $departement->id);
    
            // Filtrer par module_id
            if ($request->filled('module_id')) {
                $query->where('module_id', $request->module_id);
            }
    
            // Filtrer par sous_module_id
            if ($request->filled('sous_module_id')) {
                $query->where('sous_module_id', $request->sous_module_id);
            }
    
            // Filtrer par service_id
            if ($request->filled('service_id')) {
                $query->where('service_id', $request->service_id);
            }
    
            // Filtrer par date de création
            if ($request->filled('created_from')) {
                $query->where('date_de_creation_demande', '>=', $request->created_from);
            }
    
            if ($request->filled('created_to')) {
                $query->where('date_de_creation_demande', '<=', $request->created_to);
            }
    
            // Filtrer par date de livraison souhaitée
            if ($request->filled('delivered_from')) {
                $query->where('date_de_livraison_souhaite', '>=', $request->delivered_from);
            }
    
            if ($request->filled('delivered_to')) {
                $query->where('date_de_livraison_souhaite', '<=', $request->delivered_to);
            }
    
            // Filtrer par division_id si fourni
            if ($request->filled('division_id')) {
                // Récupérer l'ID du chef de division associé à la division sélectionnée
                $division = Division::find($request->division_id);
                if ($division) {
                    $query->where('user_id', $division->chef_division_id);
                }
            }
    
            // Exécuter la requête
            $demandes = $query->get();
            $modules = Module::all();
            $sousModules = SousModule::all();
            $services = Service::all();
            $divisions = Division::all();
    
            return view('demandes.validateditdemande', compact('demandes', 'modules', 'sousModules', 'services','divisions', 'user'));
        } else {
            return view('login');
        }
    }
    
      
  
      // Afficher la liste des demandes pour le chef de service
    public function process(Request $request)
      {
        $user = Auth::user();

        // Récupérer le service du chef de service
        $service = Service::where('chef_service_id', $user->id)->first(); 
    
        $query = Demande::with(['user', 'module', 'sousModule', 'departement', 'ficheTechnique'])
                    ->where('validation', "true") // Pas besoin de mettre 'true' entre guillemets
                    ->whereHas('user', function($query) use ($service) {
                        // Utiliser le service récupéré pour filtrer les demandes
                        $query->where('service_id', $service->id);
                    });
    
        // Appliquer les filtres supplémentaires si fournis
        if ($request->filled('module_id')) {
            $query->where('module_id', $request->module_id);
        }
    
        if ($request->filled('sous_module_id')) {
            $query->where('sous_module_id', $request->sous_module_id);
        }
    
        // Filtrer par date de création si fournie
        if ($request->filled('created_from')) {
            $query->where('date_de_creation_demande', '>=', $request->created_from);
        }
    
        if ($request->filled('created_to')) {
            $query->where('date_de_creation_demande', '<=', $request->created_to);
        }
    
        // Filtrer par date de livraison souhaitée si fournie
        if ($request->filled('delivered_from')) {
            $query->where('date_de_livraison_souhaite', '>=', $request->delivered_from);
        }
    
        if ($request->filled('delivered_to')) {
            $query->where('date_de_livraison_souhaite', '<=', $request->delivered_to);
        }
    
        // Exécuter la requête
        $demandes = $query->get();
        $modules = Module::all();
        $sousModules = SousModule::all();
        $service =Service::where('chef_service_id', $user->id) 
                ->first();

        return view('demandes.process', compact('demandes','modules', 'sousModules', 'user','service'));
     
    }
      //divisions associe au user connecte 
      public function getServicesByDivision(Request $request)
      {
          $user = Auth::user();
      
          // Recherche de la division associée à l'utilisateur connecté
          $division = Division::where('chef_division_id', $user->id)->first();
      
          // Vérification si la division existe
          if ($division) {
              $divisionId = $division->id;
              
              // Recherche des services associés à la division
              $services = Service::where('division_id', $divisionId)->get();
      
              return response()->json($services);
          } else {
              // Gérer le cas où l'utilisateur n'a pas de division associée
              return response()->json(['error' => 'Utilisateur sans division associée'], 404);
          }
      }
      
      
  }