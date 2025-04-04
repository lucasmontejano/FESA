<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatec Esports Arena</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e1e2e; /* Dark esports theme */
            color: #fff;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content') <!-- This will insert page-specific content -->
    </div>
</body>
</html>
