<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Division</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Ajouter une Division</h1>
    <form action="{{ route('divisions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="departement_id" class="form-label">Département</label>
            <select class="form-select" id="departement_id" name="departement_id">
                @foreach ($departements as $departement)
                    <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="chef_division_id" class="form-label">Chef de division</label>
            <select class="form-select" id="chef_division_id" name="chef_division_id">
                @foreach ($chef_division as $chef)
                    <option value="{{ $chef->id }}">{{ $chef->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <a href="{{ route('divisions.index') }}" class="btn btn-secondary mt-3">Retour à la liste des divisions</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
