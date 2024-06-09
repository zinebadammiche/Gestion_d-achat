<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Custom CSS styles */
        .custom-form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-group-custom {
            margin-bottom: 1.5rem;
        }
        .stats p {
            margin-bottom: 0.5rem;
        }
        .btn-custom {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Tableau de Bord</h1>
    <button class="btn btn-primary mb-3" onclick="refreshPage()">
    <i class="fas fa-sync-alt fa-fw"></i> Rafraîchir
</button>
    <form method="GET" action="{{ route('dashboard') }}">
        <div class="row">
            <div class="col-md-6 custom-form-group">
                <label for="module_id" class="form-label">Module</label>
                <select name="module_id" id="module_id" class="form-control">
                    <option value="">Sélectionnez un module</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 custom-form-group">
                <label for="sous_module_id" class="form-label">Sous-module</label>
                <select name="sous_module_id" id="sous_module_id" class="form-control">
                    <option value="">Sélectionnez un sous-module</option>
                    @foreach($sousModules as $sousModule)
                        <option value="{{ $sousModule->id }}">{{ $sousModule->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if(!$user->roles->pluck('name')->contains('Chef service'))
        <div class="row">
            <div class="col-md-6 custom-form-group">
                <label for="service_id" class="form-label">Service</label>
                <select name="service_id" id="service_id" class="form-control">
                    <option value="">Sélectionnez un service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        @if(!$user->roles->pluck('name')->contains('Chef division') && !$user->roles->pluck('name')->contains('Directeur') && !$user->roles->pluck('name')->contains('Chef service'))
        <div class="row">
            <div class="col-md-6 custom-form-group">
                <label for="departement_id" class="form-label">Département</label>
                <select name="departement_id" id="departement_id" class="form-control">
                    <option value="">Sélectionnez un département</option>
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        @if(!$user->roles->pluck('name')->contains('Chef division'))
        <div class="row">
            <div class="col-md-6 custom-form-group">
                <label for="division_id" class="form-label">Division</label>
                <select name="division_id" id="division_id" class="form-control">
                    <option value="">Sélectionnez une division</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-6 custom-form-group">
                <label for="created_from" class="form-label">Date de création de</label>
                <input type="date" id="created_from" name="created_from" class="form-control">
            </div>
            <div class="col-md-6 custom-form-group">
                <label for="created_to" class="form-label">à</label>
                <input type="date" id="created_to" name="created_to" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 custom-form-group">
                <label for="delivered_from" class="form-label">Date de livraison souhaitée de</label>
                <input type="date" id="delivered_from" name="delivered_from" class="form-control">
            </div>
            <div class="col-md-6 custom-form-group">
                <label for="delivered_to" class="form-label">à</label>
                <input type="date" id="delivered_to" name="delivered_to" class="form-control">
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary mb-4">Rechercher</button>
    </form>

    <h2 class="mb-3">Statistiques</h2>
    <div class="row stats mb-3">
        <div class="col-md-4">
            <p><strong>Total des demandes :</strong> {{ $totalDemandes }}</p>
        </div>
        <div class="col-md-4">
            <p><strong>Demandes validées :</strong> {{ $validatedDemandes }}</p>
        </div>
        <div class="col-md-4">
            <p><strong>Demandes non validées :</strong> {{ $nonValidatedDemandes }}</p>
        </div>
    </div>

    <h2 class="mb-3">Résultats de la recherche</h2>

    @if(!$user->roles->pluck('name')->contains('Chef service'))
    <div class="btn-group-custom">
        <button id="showAllButton" class="btn btn-primary btn-custom">Afficher Toutes les Demandes</button>
        <button id="showValidatedButton" class="btn btn-success btn-custom">Afficher Demandes Validées</button>
        <button id="showPendingButton" class="btn btn-warning btn-custom">Afficher Demandes en Attente</button>
    </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Detail</th>
                <th>Justification</th>
                <th>Module</th>
                <th>Sous-module</th>
                <th>Service</th>
                <th>Département</th>
                <th>Validation</th>
                <th>Status</th>
                <th>Piece jointe</th>
                <th>   Fiche technique </th>
             
                <th>Date de Livraison Souhaitée</th>
                <th>Crédit Estimatif</th>
                <th>Date de Création de la Demande</th>
            </tr>
        </thead>
        <tbody>
        @foreach($demandes as $demande)
            <tr class="demande-row" data-validation="{{ $demande->validation }}">
                <td>{{ $demande->detail }}</td>
                <td>{{ $demande->justification }}</td>
                <td>{{ $demande->module->name }}</td>
                <td>{{ $demande->sousModule->name }}</td>
                <td>{{ $demande->service->name }}</td>
                <td>{{ $demande->departement->name }}</td>
                <td>{{ $demande->validation == "true" ? 'Oui' : 'Non' }}</td>
                <td>{{ $demande->status }}</td>
       <td>
        @if($demande->pdf_path)
    <a href="{{ asset('storage/pieces_jointes/' . basename($demande->pdf_path)) }}" class="btn btn-primary">Télécharger</a>
    @endif  @if(!$demande->pdf_path)
 pas de pieces jointess @endif
</td> 
<td>
                        <button class="btn btn-primary" onclick="generatePDF({{ $demande }})">Télécharger Fiche technique</button>
                    </td>


                <td>{{ $demande->date_de_livraison_souhaite }}</td>
                <td>{{ $demande->credit_estimatif }}</td>
                <td>{{ $demande->date_de_creation_demande }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

    @if($user->roles->pluck('name')->contains('Admin'))
    <div class="d-flex flex-wrap justify-content-between">
        <form action="{{ route('users.index') }}" method="GET" class="mt-2">
            <button type="submit" class="btn btn-secondary">Utilisateurs</button>
        </form>
        <form action="{{ route('departements.indexdepartements') }}" method="GET" class="mt-2">
            <button type="submit" class="btn btn-secondary">Departements</button>
        </form>
        <form action="{{ route('divisions.index') }}" method="GET" class="mt-2">
            <button type="submit" class="btn btn-secondary">Divisions</button>
        </form>
        <form action="{{ route('services.index') }}" method="GET" class="mt-2">
            <button type="submit" class="btn btn-secondary">Services</button>
        </form>
        <form action="{{ route('modules.indexmodules') }}" method="GET" class="mt-2">
            <button type="submit" class="btn btn-secondary">Modules</button>
        </form>
        <form action="{{ route('sousmodules.indexsousmodules') }}" method="GET" class="mt-2">
            <button type="submit" class="btn btn-secondary">Sous Modules</button>
        </form>
    </div>
@endif

    @if($user->roles->pluck('name')->contains('Chef division'))
        <button onclick="window.location.href='/demandes'" class="btn btn-info mt-2">Voir Demandes</button>
    @endif

    @if($user->roles->pluck('name')->contains('Chef service'))
        <button onclick="window.location.href='/demandes/process'" class="btn btn-info mt-2">Processus des Demandes</button>
    @endif

    @if($user->roles->pluck('name')->contains('Directeur'))
        <button onclick="window.location.href='/demandes/validate'" class="btn btn-info mt-2">Valider les Demandes</button>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
     function refreshPage() {
        window.location.href = "{{ url('/demandes') }}";
    }
    async function loadJsPDF() {
            if (typeof jsPDF !== 'undefined') return;
            const response = await fetch('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
            const scriptContent = await response.text();
            eval(scriptContent);
        }
        async function generatePDF(demande) {
            await loadJsPDF();
            const doc = new window.jspdf.jsPDF();
            if (demande.fiche_technique && Array.isArray(demande.fiche_technique)) {
                demande.fiche_technique.forEach(function(fiche_technique, index) {
                    const y = 10 + (index * 10);
                    doc.text(`Article: ${fiche_technique.article}`, 10, y);
                    doc.text(`Caractéristique technique: ${fiche_technique.caracteristique_technique}`, 10, y + 5);
                    doc.text(`Quantité: ${fiche_technique.quantite}`, 10, y + 10);
                });
            } else {
                console.error('Fiche technique non définie ou incorrecte pour la demande:', demande.id);
            }
            doc.save(`demande_${demande.id}.pdf`);
        }

    document.addEventListener("DOMContentLoaded", function() {
        const showAllButton = document.getElementById("showAllButton");
        const showValidatedButton = document.getElementById("showValidatedButton");
        const showPendingButton = document.getElementById("showPendingButton");

        showAllButton.addEventListener("click", function() {
            const rows = document.querySelectorAll(".demande-row");
            rows.forEach(row => {
                row.style.display = "";
            });
        });

        showValidatedButton.addEventListener("click", function() {
            const rows = document.querySelectorAll(".demande-row");
            rows.forEach(row => {
                if (row.getAttribute("data-validation") === "true") {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        showPendingButton.addEventListener("click", function() {
            const rows = document.querySelectorAll(".demande-row");
            rows.forEach(row => {
                if (row.getAttribute("data-validation") === "false") {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
</script>
</body>
</html>
