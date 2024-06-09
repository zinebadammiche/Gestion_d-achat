<?php 
namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Module;
use App\Models\SousModule;
use App\Models\Service;
use App\Models\Departement;
use App\Models\Division;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Demande::query();

        // Filtrer par module, sous-module et service
        if (!$user->hasRole('Directeur')) {
            if ($request->filled('module_id')) {
                $query->where('module_id', $request->module_id);
            }

            if ($request->filled('sous_module_id')) {
                $query->where('sous_module_id', $request->sous_module_id);
            }

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
        }

        if ($user->hasRole('Chef division')) {
            // Si l'utilisateur est un chef de division, ne filtrer que par user_id
            $query->where('user_id', $user->id);
        }

        if ($user->hasRole('Directeur')) {
            // Si l'utilisateur est un directeur, récupérer le département dont il est le directeur
            $departement = Departement::where('directeur_id', $user->id)->first();
            
            if ($departement) {
                // Si le département est trouvé, filtrer par son ID
                $query->where('departement_id', $departement->id);
            }
        }
        if ($user->hasRole('Chef service')) {
            // Si l'utilisateur est un chef service, récupérer le service dont il est le chef service
            $service = Service::where('chef_service_id', $user->id)->first();
            
            if ($service) {
                // Si le service est trouvé, filtrer par son ID
                $query->where('service_id', $service->id);
            }
        }
        // Filtrer par département_id si fourni
        if ($request->filled('departement_id')) {
            $query->where('departement_id', $request->departement_id);
        }

        // Filtrer par division_id si fourni
        if ($request->filled('division_id')) {
            // Récupérer l'ID du chef de division associé à la division sélectionnée
            $division = Division::find($request->division_id);
            if ($division) {
                $query->where('user_id', $division->chef_division_id);
            }
        }

        $demandes = $query->get();
        $totalDemandes = $demandes->count();
        $validatedDemandes = $demandes->where('validation', "true")->count();
        $nonValidatedDemandes = $demandes->where('validation', "false")->count();

        $modules = Module::all();
        $sousModules = SousModule::all();
        $services = Service::all();
        $departements = Departement::all();
        $divisions = Division::all();
        $modules = Module::all();
        $sousModules = SousModule::all();
        return view('dashboard', compact('demandes', 'totalDemandes', 'validatedDemandes', 'nonValidatedDemandes', 'modules', 'sousModules', 'services', 'departements', 'divisions', 'user'));
    }
    public function downloadPdf(Request $request, $pdfFileName)
    {
        // Spécifiez le chemin complet vers le répertoire de stockage
        $storagePath = storage_path('app/pieces_jointes');

        // Vérifiez que le fichier existe dans le répertoire de stockage
        if (Storage::exists('pieces_jointes/' . $pdfFileName)) {
            // Récupérez le chemin complet du fichier
            $filePath = $storagePathss. $pdfFileName;
            
            // Retournez une réponse de type fichier
            return response()->download($filePath, $pdfFileName);
        } else {
            // Si le fichier n'existe pas, redirigez vers une page d'erreur ou affichez un message d'erreur
            return redirect()->back()->with('error', 'Le fichier demandé n\'existe pas.');
        }
    }
}
