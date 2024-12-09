<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolve Concern</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        h1, h2 {
            font-weight: 700; /* Bold */
        }

        .table th {
            background: linear-gradient(90deg, #007bff, #6c757d);
            color: #fff;
        }

        .table td, .table th {
            font-weight: 600;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .text-primary {
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table-container {
            margin: 0 auto;
            max-width: 90%;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-5">
        <h1 class="text-center mb-4 text-primary">Resolve Concern</h1>

        @foreach ($averagesByBranch as $branchName => $concerns)
            <div class="text-center mb-5">
                <h2 class="text-primary">Branch: {{ ucfirst($branchName) }}</h2>
            </div>
            <div class="table-container">
                <table class="table table-hover table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">Concern Type</th>
                            <th scope="col">Days</th>
                            <th scope="col">Hours</th>
                            <th scope="col">Minutes</th>
                            <th scope="col">Seconds</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($concerns as $concern => $average)
                            <tr>
                                <td>{{ ucfirst($concern) }}</td>
                                <td>{{ $average['days'] ?? 'N/A' }}</td>
                                <td>{{ $average['hours'] ?? 'N/A' }}</td>
                                <td>{{ $average['minutes'] ?? 'N/A' }}</td>
                                <td>{{ $average['seconds'] ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
