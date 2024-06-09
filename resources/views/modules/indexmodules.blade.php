<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Modules</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Modules</h1>
    <a href="{{ route('modules.create') }}" class="btn btn-primary mt-3">Créer un Module</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modules as $module)
            <tr>
                <td>{{ $module->name }}</td>
                <td>
                    <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('modules.destroy', $module->id) }}" method="POST" style="display:inline;">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
