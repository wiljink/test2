<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolve Concern</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        h1, h2 {
            font-weight: 700; /* Bold */
        }

        table th, table td {
            font-weight: 600; /* Semi-Bold for table content */
        }
    </style>
</head>
<body>


<div class="container mt-5">
    <h1 class="text-center mb-4">Resolve Concern</h1>
    
    @foreach ($averagesByBranch as $branchName => $concerns)
        <div class="text-center mb-4">
            <h2 class="text-primary">Branch: {{ ucfirst($branchName) }}</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered mx-auto text-center" style="width: 80%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Concern Type</th>
                        <th>Days</th>
                        <th>Hours</th>
                        <th>Minutes</th>
                        <th>Seconds</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($concerns as $concern => $average)
                        <tr>
                            <td>{{ ucfirst($concern) }}</td>
                            <td>{{ $average['days'] }}</td>
                            <td>{{ $average['hours'] }}</td>
                            <td>{{ $average['minutes'] }}</td>
                            <td>{{ $average['seconds'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
