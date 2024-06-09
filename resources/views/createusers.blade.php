<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Utilisateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Créer un Utilisateur</h1>
    <form action="{{ route('users.register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select class="form-control" id="role" name="role" required>
         
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/js/bootstrap.min.js"></script>
<script>
    // Faites une requête AJAX pour récupérer les rôles
    fetch("{{ route('getallroles') }}")
        .then(response => response.json())
        .then(data => {
            // Ajoutez chaque rôle à la liste déroulante
            data.forEach(role => {
                let option = document.createElement('option');
                option.text = role;
                option.value = role;
                document.getElementById('role').appendChild(option);
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des rôles:', error));
</script>
</body>
</html>
