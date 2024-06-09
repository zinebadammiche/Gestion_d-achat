<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier et Valider les Demandes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier et Valider les Demandes du departement {{$user->departement->name}}</h1>
        <button class="btn btn-primary mb-3" onclick="refreshPage()">
    <i class="fas fa-sync-alt fa-fw"></i> Rafraîchir
</button>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="GET" action="{{ url('/demandes/validate') }}">
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
                <label for="division_id" class="form-label">Division</label>
                <select name="division_id" id="division_id" class="form-control">
                    <option value="">Sélectionnez une division</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
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
                    <th>Date de Création</th> <!-- Nouvelle colonne pour la date de création -->
                    <th>Date de Livraison Souhaitée</th> <!-- Nouvelle colonne pour la date de livraison -->
                    <th>Crédit Estimatif</th> <!-- Nouvelle colonne pour le crédit estimatif -->
                    <th>Actions</th> <!-- Colonnes existantes -->
                    <th>Fiche technique</th> <!-- Colonnes existantes -->
                </tr>
            </thead>
            <tbody>
                @foreach($demandes as $demande)
                    <tr id="demande_{{ $demande->id }}">
                        <td>{{ $demande->id }}</td>
                        <td>{{ $demande->user->name }}</td>
                        <td>{{ $demande->module->name }}</td>
                        <td>{{ $demande->sousModule->name }}</td>
                        <td>{{ $demande->detail }}</td>
                        <td>{{ $demande->justification }}</td>
                        <td>{{ $demande->departement->name }}</td>
                        <td>{{ $demande->service->name }}</td>
                        <td>
                            @if($demande->validation == "true")
                                Validé
                            @else
                                Non Validé
                                <form action="{{ route('demandes.validate', $demande->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                </form>
                            @endif
                        </td>
                        <td>{{ $demande->date_de_creation_demande }}</td> <!-- Afficher la date de création -->
                        <td>{{ $demande->date_de_livraison_souhaite }}</td> <!-- Afficher la date de livraison souhaitée -->
                        <td>{{ $demande->credit_estimatif }}</td> <!-- Afficher le crédit estimatif -->
                        <td>
                            <a href="{{ route('demandes.edit', $demande->id) }}" class="btn btn-primary btn-sm">Modifier</a>
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
        window.location.href = "{{ url('/dashboard') }}";
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

        document.addEventListener('DOMContentLoaded', function() {
            const demandes = {!! json_encode($demandes) !!};

            demandes.forEach(function(demande) {
                const tr = document.getElementById(`demande_${demande.id}`);
                const td = document.createElement('td');
                const button = document.createElement('button');
                button.textContent = 'Télécharger Fiche technique';
                button.addEventListener('click', async function(event) {
                    event.preventDefault();
                    await generatePDF(demande);
                });
                td.appendChild(button);
                tr.appendChild(td);
            });
        });

        $(document).ready(function() {
            $('[id^=module_id_]').each(function() {
                const moduleSelect = $(this);
                const moduleId = moduleSelect.val();
                const sousModuleSelect = moduleSelect.closest('form').find('[id^=sous_module_id_]');

                function loadSousModules(moduleId) {
                    $.ajax({
                        url: "{{ url('/sousmodules') }}",
                        method: 'GET',
                        data: { module_id: moduleId },
                        success: function(data) {
                            sousModuleSelect.empty();
                            data.forEach(function(sousModule) {
                                sousModuleSelect.append(new Option(sousModule.name, sousModule.id));
                            });
                            sousModuleSelect.val(sousModuleSelect.data('selected'));
                        }
                    });
                }

                loadSousModules(moduleId);

                moduleSelect.change(function() {
                    loadSousModules(moduleSelect.val());
                });
            });
        });
    </script>
</body>
</html>
