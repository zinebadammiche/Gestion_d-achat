<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Divisions</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styles personnalisés pour la liste des divisions */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin-top: 80px;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Style pour le bouton "Ajouter une division" */
        .btn-add-division {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-add-division:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Style pour le bouton "Modifier" */
        .btn-edit {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-edit:hover {
            background-color: #138496;
            border-color: #138496;
        }

        /* Style pour le bouton "Supprimer" */
        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="mt-5">Liste des Divisions</h1>
    <button onclick="window.location='{{ route('divisions.create') }}'" class="btn btn-primary mb-3 btn-add-division">Ajouter une division</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Département</th>
                <th scope="col">Chef de division</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($divisions as $division)
                <tr>
                    <th scope="row">{{ $division->id }}</th>
                    <td>{{ $division->name }}</td>
                    <td>{{ $division->departement->name }}</td>
                    <td>{{ $division->chefd ? $division->chefd->name : 'Aucun directeur' }}</td>
                    
                    <td>
                        <form action="{{ route('divisions.edit', $division->id) }}">
                            <button type="submit" class="btn btn-info btn-edit">Modifier</button>
                        </form>
                        <form action="{{ route('divisions.destroy', $division->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-delete">Supprimer</button>
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
