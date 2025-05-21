<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
        }
        .dashboard-container {
            max-width: 700px;
            margin: 80px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            padding: 30px;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Bem-vindo, {{ auth()->user()->name }}</h4>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Sair</button>
        </form>
    </div>

    <hr>

    <p class="text-muted">Aqui você pode iniciar uma pesquisa de placas de veículos.</p>

    <form method="GET" action="">
        <div class="input-group">
            <input type="text" name="placa" class="form-control" placeholder="Digite a placa (ex: ABC1D23)" required>
            <button class="btn btn-primary" type="submit">Pesquisar</button>
        </div>
    </form>
</div>

</body>
</html>
