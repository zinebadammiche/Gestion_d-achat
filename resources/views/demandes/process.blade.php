<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processus Demandes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
    
        <form method="GET" action="{{ url('/demandes/process') }}">
        <h1>Traiter les Demandes de service {{ $service->name }}</h1>


<button class="btn btn-primary mb-3" onclick="refreshPage()">
<i class="fas fa-sync-alt fa-fw"></i> Rafraîchir
</button>
        <div class="row mt-3 mb-3">
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
<div class="col-md-4">
                <button class="btn btn-primary mt-4" id="apply_filters">Appliquer Filtres</button>
            </div>

</div>
</form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de l'utilisateur</th>
                    <th>Module</th>
                    <th>Sous-Module</th>
                    <th>Détail</th>
                    <th>Justification</th>
                    <th>Département</th>
                    <th>service</th>
                    <th>Validation</th>
                    <th>Statut</th>
                    <th>Date de Création</th> <!-- Nouvelle colonne pour la date de création -->
                    <th>Date de Livraison Souhaitée</th> <!-- Nouvelle colonne pour la date de livraison -->
                    <th>Crédit Estimatif</th> <!-- Nouvelle colonne pour le crédit estimatif -->
                    <th>Piece</th> <!-- Colonnes existantes -->
                    <th>Actions</th> <!-- Colonnes existantes -->
                </tr>
            </thead>
            <tbody>
            @foreach($demandes as $demande)
                <tr id="demande_{{ $demande->id }}" class="demande_row" data-module="{{ $demande->module_id }}" data-sous-module="{{ $demande->sous_module_id }}">
                    <td>{{ $demande->id }}</td>
                    <td>{{ $demande->user->name }}</td>
                    <td>{{ $demande->module->name }}</td>
                    <td>{{ $demande->sousModule->name }}</td>
                    <td>{{ $demande->detail }}</td>
                    <td>{{ $demande->justification }}</td>
                    <td>{{ $demande->departement->name }}</td>
                    <td>{{ $demande->service->name }}</td>
                    <td>{{ $demande->validation }}</td>
                    <td>
                        <form action="{{ route('demandes.updateStatus', $demande->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <select name="status" class="form-control-sm">
                                <option value="created">{{ $demande->status }}</option>
                                <option value="processing">created</option>
                                <option value="processing">processing</option>
                                <option value="completed">completed</option>
                            </select>
                            <button type="submit" class="btn btn-info btn-sm">Mettre à jour</button>
                        </form>
                        <form action="{{ route('demandes.addAttachment', $demande->id) }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                            @csrf
                            <input type="file" name="attachment" class="form-control-file">
                            <button type="submit" class="btn btn-primary btn-sm">Ajouter Pièce Jointe</button>
                        </form>
                    </td>
                    <td>{{ $demande->date_de_creation_demande }}</td> <!-- Afficher la date de création -->
                    <td>{{ $demande->date_de_livraison_souhaite }}</td> <!-- Afficher la date de livraison souhaitée -->
                    <td>{{ $demande->credit_estimatif }}</td> <!-- Afficher le crédit estimatif -->
                    <td>
                        @if($demande->pdf_path)
                            <a href="{{ asset('storage/pieces_jointes/' . basename($demande->pdf_path)) }}" class="btn btn-primary">Télécharger</a>
                        @else
                            Pas de pièces jointes disponibles
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="generatePDF({{ $demande }})">Télécharger Fiche technique</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-md-4">
    <a href="/dashboard" class="btn btn-primary">Retour</a>
</div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
         function refreshPage() {
        window.location.href = "{{url('/dashboard')}}";
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
        $(document).ready(function() {
            $("#apply_filters").on("click", function() {
                var module_id = $("#filter_module").val();
                var sous_module_id = $("#filter_sous_module").val();

                $(".demande_row").each(function() {
                    var module_match = module_id === "" || $(this).data("module") == module_id;
                    var sous_module_match = sous_module_id === "" || $(this).data("sous-module") == sous_module_id;
                    if (module_match && sous_module_match) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>
</html>