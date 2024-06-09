<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Sous-Modules</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Liste des Sous-Modules</h1>
    <a href="{{ route('sousmodules.create') }}" class="btn btn-primary mb-3">Ajouter un Sous-Module</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                 
                <th scope="col">Module</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sousmodules as $sousmodule)
            <tr>
                <th scope="row">{{ $sousmodule->id }}</th>
                <td>{{ $sousmodule->name }}</td>
          
                <td>{{ $sousmodule->module->name }}</td>
                <td>
 
                    <a href="{{ route('sousmodules.edit', $sousmodule->id) }}" class="btn btn-primary">Modifier</a>
                    <form action="{{ route('sousmodules.destroy', $sousmodule->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-md-4">
    <a href="/dashboard" class="btn btn-primary">Retour</a>
</div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/js/bootstrap.min.js"></script>
</body>
</html>
