<!DOCTYPE html>
<html>
<head>
    <title>Créer une Demande</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Créer une Demande</h1>
        <form action="{{ route('demandes.create') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="module_name" class="form-label">Module</label>
                <select class="form-control" id="module_name" name="module_name" required>
                    <option value="">Sélectionnez un module</option>
                    <!-- Options seront ajoutées dynamiquement via AJAX -->
                </select>
                @if ($errors->has('module_name'))
                    <div class="text-danger">{{ $errors->first('module_name') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="departement_name" class="form-label">Département</label>
                <select class="form-control" id="departement_name" name="departement_name" required>
                    <option value="">Sélectionnez un département</option>
                    <!-- Options seront ajoutées dynamiquement via AJAX -->
                </select>
                @if ($errors->has('departement_name'))
                    <div class="text-danger">{{ $errors->first('departement_name') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="service_id" class="form-label">Service</label>
                <select class="form-control" id="service_id" name="service_id" required>
                    <option value="">Sélectionnez un service</option>
                    <!-- Options seront ajoutées dynamiquement via AJAX -->
                </select>
                @if ($errors->has('service_id'))
                    <div class="text-danger">{{ $errors->first('service_id') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="sous_module_name" class="form-label">Sous-Module</label>
                <select class="form-control" id="sous_module_name" name="sous_module_name" required>
                    <option value="">Sélectionnez un sous-module</option>
                    <!-- Options seront ajoutées dynamiquement via AJAX -->
                </select>
                @if ($errors->has('sous_module_name'))
                    <div class="text-danger">{{ $errors->first('sous_module_name') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Détail</label>
                <textarea class="form-control" id="detail" name="detail" required></textarea>
                @if ($errors->has('detail'))
                    <div class="text-danger">{{ $errors->first('detail') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="justification" class="form-label">Justification</label>
                <textarea class="form-control" id="justification" name="justification" required></textarea>
                @if ($errors->has('justification'))
                    <div class="text-danger">{{ $errors->first('justification') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="date_de_livraison_souhaite" class="form-label">Date de Livraison Souhaitée</label>
                <input type="date" class="form-control" id="date_de_livraison_souhaite" name="date_de_livraison_souhaite" required>
                @if ($errors->has('date_de_livraison_souhaite'))
                    <div class="text-danger">{{ $errors->first('date_de_livraison_souhaite') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="credit_estimatif" class="form-label">Crédit Estimatif</label>
                <input type="number" step="0.01" class="form-control" id="credit_estimatif" name="credit_estimatif" required>
                @if ($errors->has('credit_estimatif'))
                    <div class="text-danger">{{ $errors->first('credit_estimatif') }}</div>
                @endif
            </div>
            <button type="button" class="btn btn-primary" id="btnFicheTechnique">Ajouter une Fiche Technique</button>
            <div id="formFicheTechnique" style="display: none;">
                <h2>Formulaire Fiche Technique</h2>
                <div class="mb-3">
                    <label for="article" class="form-label">Article</label>
                    <input type="text" class="form-control" id="article" name="article" required>
                    @if ($errors->has('article'))
                        <div class="text-danger">{{ $errors->first('article') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="caracteristique_technique" class="form-label">Caractéristiques Techniques</label>
                    <textarea class="form-control" id="caracteristique_technique" name="caracteristique_technique" required></textarea>
                    @if ($errors->has('caracteristique_technique'))
                        <div class="text-danger">{{ $errors->first('caracteristique_technique') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input type="number" class="form-control" id="quantite" name="quantite" required>
                    @if ($errors->has('quantite'))
                        <div class="text-danger">{{ $errors->first('quantite') }}</div>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-success">Créer la Demande</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnFicheTechnique = document.getElementById('btnFicheTechnique');
            const formFicheTechnique = document.getElementById('formFicheTechnique');

            btnFicheTechnique.addEventListener('click', function() {
                formFicheTechnique.style.display = 'block';
            });

            // Requête AJAX pour récupérer les départements
            fetch("{{ url('/departements') }}")
                .then(response => response.json())
                .then(data => {
                    const departmentSelect = document.getElementById('departement_name');
                    data.forEach(departement => {
                        let option = document.createElement('option');
                        option.text = departement.name;
                        option.value = departement.id;
                        departmentSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur lors de la récupération des départements:', error));
 // Requête AJAX pour récupérer les services
 fetch("{{ url('/services') }}")
    .then(response => response.json())
    .then(data => {
        const serviceSelect = document.getElementById('service_id');
        data.forEach(service => { // Correction de la variable ici
            let option = document.createElement('option');
            option.text = service.name; // Utilisation de la variable correcte ici
            option.value = service.id; // Utilisation de la variable correcte ici
            serviceSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Erreur lors de la récupération des services :', error));

            // Requête AJAX pour récupérer les modules
            fetch("{{ url('/modules') }}")
                .then(response => response.json())
                .then(data => {
                    const moduleSelect = document.getElementById('module_name');
                    data.forEach(module => {
                        let option = document.createElement('option');
                        option.text = module.name;
                        option.value = module.id;
                        moduleSelect.appendChild(option);
                    });

                    // Écouteur d'événement pour le changement de sélection du module
                    moduleSelect.addEventListener('change', function() {
                        const moduleId = this.value;
                        const submoduleSelect = document.getElementById('sous_module_name');

                        // Vider la liste des sous-modules
                        submoduleSelect.innerHTML = '<option value="">Sélectionnez un sous-module</option>';

                        if (moduleId) {
                            // Requête AJAX pour récupérer les sous-modules en fonction du module sélectionné
                            fetch(`{{ url('/sousmodules') }}?module_id=${moduleId}`)
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(submodule => {
                                        let option = document.createElement('option');
                                        option.text = submodule.name;
                                        option.value = submodule.id;
                                        submoduleSelect.appendChild(option);
                                    });
                                })
                                .catch(error => console.error('Erreur lors de la récupération des sous-modules:', error));
                        }
                    });
                })
                .catch(error => console.error('Erreur lors de la récupération des modules:', error));
        });
    </script>
</body>
</html>
