<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Demande</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier la Demande</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('demandes.update', $demande->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="user_id">Utilisateur</label>
                <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $demande->user->name }}" disabled>
            </div>
            <div class="form-group">
                <label for="module_id">Module</label>
                <select class="form-control" id="module_id" name="module_id">
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ $demande->module_id == $module->id ? 'selected' : '' }}>{{ $module->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sous_module_id">Sous-Module</label>
                <select class="form-control" id="sous_module_id" name="sous_module_id">
                    @foreach($sousModules as $sousModule)
                        <option value="{{ $sousModule->id }}" {{ $demande->sous_module_id == $sousModule->id ? 'selected' : '' }}>{{ $sousModule->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="departement_id">Département</label>
                <select class="form-control" id="departement_id" name="departement_id">
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}" {{ $demande->departement_id == $departement->id ? 'selected' : '' }}>{{ $departement->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="detail">Détail</label>
                <textarea class="form-control" id="detail" name="detail">{{ $demande->detail }}</textarea>
            </div>
            <div class="form-group">
                <label for="justification">Justification</label>
                <textarea class="form-control" id="justification" name="justification">{{ $demande->justification }}</textarea>
            </div>
            <div class="form-group">
                <label for="validation">Validation</label>
                <select class="form-control" id="validation" name="validation">
                    <option value="true" {{ $demande->validation == "true" ? 'selected' : '' }}>Validé</option>
                    <option value="false" {{ $demande->validation == "false" ? 'selected' : '' }}>Non Validé</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_de_livraison_souhaite">Date de Livraison Souhaitée</label>
                <input type="date" class="form-control" id="date_de_livraison_souhaite" name="date_de_livraison_souhaite" value="{{ $demande->date_de_livraison_souhaite }}">
            </div>
            <div class="form-group">
                <label for="credit_estimatif">Crédit Estimatif</label>
                <input type="number" step="0.01" class="form-control" id="credit_estimatif" name="credit_estimatif" value="{{ $demande->credit_estimatif }}">
            </div>
            <div class="form-group">
                <label for="date_de_creation_demande">Date de Création de Demande</label>
                <input type="date" class="form-control" id="date_de_creation_demande" name="date_de_creation_demande" value="{{ $demande->date_de_creation_demande }}">
            </div>
            <div class="form-group">
                <label>Fiche Technique</label>
                @foreach($demande->ficheTechnique as $fiche_technique)
                    <div class="form-group">
                        <label for="article">Article</label>
                        <input type="text" class="form-control" name="fiche_technique[{{ $fiche_technique->id }}][article]" value="{{ $fiche_technique->article }}">
                        <label for="caracteristique_technique">Caractéristique Technique</label>
                        <input type="text" class="form-control" name="fiche_technique[{{ $fiche_technique->id }}][caracteristique_technique]" value="{{ $fiche_technique->caracteristique_technique }}">
                        <label for="quantite">Quantité</label>
                        <input type="number" class="form-control" name="fiche_technique[{{ $fiche_technique->id }}][quantite]" value="{{ $fiche_technique->quantite }}">
                        <input type="hidden" name="fiche_technique[{{ $fiche_technique->id }}][id]" value="{{ $fiche_technique->id }}">
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
