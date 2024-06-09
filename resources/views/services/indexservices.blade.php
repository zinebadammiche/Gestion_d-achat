<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Services</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Services</h1>
    <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Créer un Service</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Division</th>
                <th>Chef de Service</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->division->name }}</td>
                    <td>{{ $service->chefs->name }}</td>
                    <td>
                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-secondary">Modifier</a>
                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
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
