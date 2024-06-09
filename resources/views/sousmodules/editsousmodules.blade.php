<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Sous-Module</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mt-5">Modifier le Sous-Module</h1>
    <form action="{{ route('sousmodules.update', $sousmodule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $sousmodule->name }}" required>
        </div>
         
        <div class="mb-3">
            <label for="module" class="form-label">Module</label>
            <select class="form-select" id="module" name="module_id" required>
                @foreach ($modules as $module)
                <option value="{{ $module->id }}" @if ($module->id == $sousmodule->module_id) selected @endif>{{ $module->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/js/bootstrap.min.js"></script>
</body>
</html>
