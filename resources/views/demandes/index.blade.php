<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des demandes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <style>
        .custom-form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Demandes créées par {{ $user->name }}</h1>
        <button class="btn btn-primary mb-3" onclick="refreshPage()">
    <i class="fas fa-sync-alt fa-fw"></i> Rafraîchir
</button>

        <a href="{{ route('demandes.createform') }}" class="btn btn-primary mb-3">Créer une demande</a>
        <form method="GET" action="{{ url('/demandes') }}">
            <div class="row mt-3 mb-3">
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
                    <label for="service_id" class="form-label">Service</label>
                    <select name="service_id" id="service_id" class="form-control">
                        <option value="">Sélectionnez un service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
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
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Module</th>
                    <th>Sous-Module</th>
                    <th>Détail</th>
                    <th>Justification</th>
                    <th>Status</th>
                    <th>Validation</th>
                    <th>Date de Création</th>
                    <th>Date de Livraison Souhaitée</th>
                    <th>Crédit Estimatif</th>
                    <th>Département</th>
                    <th>Service</th>
                    <th>Fiche technique</th>
                    <th>Télécharger Fiche technique</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demandes as $demande)
                    <tr id="demande_{{ $demande->id }}">
                        <td>{{ $demande->id }}</td>
                        <td>{{ $demande->module->name }}</td>
                        <td>{{ $demande->sousModule->name }}</td>
                        <td>{{ $demande->detail }}</td>
                        <td>{{ $demande->justification }}</td>
                        <td>{{ $demande->status }}</td>
                        <td>{{ $demande->validation }}</td>
                        <td>{{ $demande->date_de_creation_demande }}</td>
                        <td>{{ $demande->date_de_livraison_souhaite }}</td>
                        <td>{{ $demande->credit_estimatif }}</td>
                        <td>{{ $demande->departement->name }}</td>
                        <td>{{ $demande->service->name }}</td>
                        <td>
                            @foreach($demande->ficheTechnique as $ficheTechnique)
                                {{ $ficheTechnique->article }},
                                {{ $ficheTechnique->caracteristique_technique }},
                                {{ $ficheTechnique->quantite }}
                            @endforeach
                        </td>
                        <td></td>
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
    // Fonction asynchrone pour charger jsPDF
    async function loadJsPDF() {
        if (typeof jsPDF !== 'undefined') return; // Vérifie si jsPDF est déjà défini
        const response = await fetch('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
        const scriptContent = await response.text();
        eval(scriptContent); // Évalue le contenu du script pour définir jsPDF
    }
    function refreshPage() {
        window.location.href = "{{ url('/demandes') }}";
    }
    // Fonction pour générer un fichier PDF à partir des informations de la fiche technique
    async function generatePDF(demande) {
    await loadJsPDF(); // Charger jsPDF de manière asynchrone
    const doc = new window.jspdf.jsPDF();
    console.log(demande)
    // Vérifier si demande.ficheTechnique est défini et est un tableau
    if (demande.fiche_technique && Array.isArray(demande.fiche_technique)) {
        // Insérer les informations de la fiche technique dans le PDF
        console.log("exixts")
        demande.fiche_technique.forEach(function(fiche_technique, index) {
            const y = 10 + (index * 10);
            doc.text(`Article: ${fiche_technique.article}`, 10, y);
            doc.text(`Caractéristique technique: ${fiche_technique.caracteristique_technique}`, 10, y + 5);
            doc.text(`Quantité: ${fiche_technique.quantite}`, 10, y + 10);
        });
    } else {
        // Gérer le cas où demande.ficheTechnique n'est pas défini ou n'est pas un tableau
        console.error('Fiche technique non définie ou incorrecte pour la demande:', demande.id);
    }

    // Sauvegarder le PDF avec le nom de la demande
    doc.save(`demande_${demande.id}.pdf`);
}

    // Écouteur d'événement pour le chargement du document
    document.addEventListener('DOMContentLoaded', async function() {
        const demandes = {!! json_encode($demandes) !!}; // Récupérer les demandes depuis le backend

        // Boucler à travers chaque demande pour ajouter un bouton pour télécharger le PDF
        demandes.forEach(function(demande) {
            const td = document.createElement('td');
            const button = document.createElement('button');
            button.textContent = 'Télécharger Fiche technique ';
            // Écouteur d'événement pour générer le PDF au clic sur le bouton
            button.addEventListener('click', async function(event) {
                event.preventDefault();
                await generatePDF(demande);
            });
            td.appendChild(button);
            // Ajouter la colonne PDF à la ligne de la demande
            const tr = document.getElementById(`demande_${demande.id}`);
            tr.lastElementChild.appendChild(td);
        });
    });
</script>

</body>
</html>
