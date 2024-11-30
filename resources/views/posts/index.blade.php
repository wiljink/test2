<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* Custom styles */
        .custom-container {
            background-color: #004d00;
            /* Dark green background */
            padding: 30px;
            border-radius: 10px;
            color: #fff;
            /* White text for better contrast */
        }

        .custom-form {
            border: 1px solid #ccc;
            /* Border around the form */
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
            /* White background for the form */
            color: #000;
            /* Default black text for form content */
        }

        .button-container {
            display: flex;
            gap: 15px;
            /* Add gap between buttons */
            margin-top: 20px;
        }

        .custom-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-size: 16px;
        }

        /* Custom button colors */
        .loans-btn {
            background-color: #007bff;
        }

        /* Blue */
        .deposits-btn {
            background-color: #6c757d;
        }

        /* Gray */
        .customer-service-btn {
            background-color: #28a745;
        }

        /* Green */
        .general-btn {
            background-color: #17a2b8;
        }

        /* Teal */
    </style>
    <style>
        /* Apply Poppins font to the entire page */
        body {
            font-family: 'Poppins', sans-serif;


        }

        h1 {
            font-weight: 'bold';
            text-align: 'center';
        }

        /* Styling the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }


        /* Table header styling */
        th {
            font-weight: bold;
            text-align: center;
            padding: 10px;
            background-color: #f2f2f2;
        }

        /* Table cell styling */
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        /* Styling the table rows */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
    <title>Member Concern</title>
</head>

<body>

<body>
    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg" style="background-color: #004d00;">
        <div class="container-fluid">
            <!-- Logo and Brand Name -->
            <a class="navbar-brand d-flex align-items-center text-white" href="#">
                <img src="{{ asset('images/oicLogo.png') }}" alt="Logo" width="170" height="40" class="me-2">

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Member Concerns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Branch Managers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Settings</a>
                    </li>
                    <!-- Logout Button -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="post" class="d-inline">
                            @csrf
                            @method('post')
                            <button type="submit" class="nav-link btn btn-link text-white p-0 m-0" style="text-decoration: none;">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>





    <!-- Rest of the Page Content -->
    <h1 align='center'>Member Concern</h1>
    <div align='center'>
        @if(session()->has('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
        @endif
    </div>

    <!-- Your existing content remains unchanged -->
</body>


    <!-- Rest of the Page Content -->
    <div align='center'>
        @if(session()->has('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
        @endif
    </div>

    <!-- Your existing content remains unchanged -->

    <!-- Rest of the Page Content -->

    <div align='center'>
        @if(session()->has('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
        @endif
    </div>

    <!-- Your existing content remains unchanged -->


    <div align='center'>

        @if(session()->has('success'))
    <div class="alert alert-success">
        {!! session('success') !!}
    </div>
        @endif

    </div>



    <div class="container">

    <table class="table">
    <thead>
        <tr>
        <th scope="col">ID</th>
            <th scope="col">NAME</th>
            <th scope="col">BRANCH</th>
            <th scope="col">CONTACT NUMBER</th>
            <th scope="col">CONCERN RECEIVED DATE</th>
            <th scope="col">CONCERN</th>
            <th scope="col">MESSAGE</th>


            @if($authenticatedUser['account_type_id']== 7)
            <th scope="col">PREPARED BY</th>
                <!-- <th scope="col">TASK</th> -->
                <th scope="col">DAYS RESOLVED</th>
                <th scope="col">STATUS</th>
                <th scope="col">ACTION</th> <
            @else
                <th scope="col">ACTION</th> <!-- ACTION column for other users -->
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($data as $posts)
        <tr>
            <td>{{ $posts->id }}</td>
            <td>{{ $posts->name }}</td>
            @foreach($branches as $branch)
                @if($posts->branch == $branch['id'])
                    <td>{{ $branch['branch_name'] }}</td>
                @endif
            @endforeach
            <td>{{ $posts->contact_number }}</td>
            <td>{{ $posts->created_at->format('Y-m-d') }}</td>
            <td>{{ $posts->concern }}</td>
            <td>{{ $posts->message }}</td>

            @if($authenticatedUser['account_type_id'] == 7)
        
            <td>{{ $posts->endorse_by ?? 'N/A' }}</td>

                <!-- <td>{{ $posts->tasks }}</td> -->
                <td>{{ $posts->days_resolved ?? 'N/A' }}</td>
                <td>{{ $posts->status ?? 'Pending' }}</td>
                <td>
                <a href="#" id="analyzeButton" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#analyzeModal" data-id="{{ $posts->id }}"
                data-name="{{ $posts->name }}" data-branch="{{ $posts->branch}}" data-contact="{{ $posts->contact_number }}">
                ANALYZE
                </a>

                </td>

            @else
                <td>
                    <!-- Add actions for non-account_type_id == 7 -->
                    <a href="#" id="endorseButton" class="btn btn-primary" data-bs-toggle="modal"
                       data-bs-target="#endorseModal" data-id="{{ $posts->id }}" data-name="{{ $posts->name }}">
                       ENDORSE
                    </a>
                </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>



    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
    {{ $data->links('pagination::simple-bootstrap-5') }}
</div>
    </div>

    <!-- Blade Template: Access authenticated user data -->


    <!-- Modal Form for HO staff -->
    <div class="modal fade" id="endorseModal" tabindex="-1" aria-labelledby="endorseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="endorseModalLabel">Endorse Concern</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="endorseForm" action="{{ route('posts.update') }}" method="POST">
                        @csrf
                        @method('put')

                        <!-- Hidden input for the post ID -->
                        <input type="text" name="post_id" id="post_id">

                        <!-- Prepared By - Hidden Field for Authenticated User -->
                        @if($authenticatedUser)
                        <input type="text" name="endorse_by" id="endorse_by" value="{{ $authenticatedUser['id'] }}">
                        @endif

                        <!-- Endorse To - Select Dropdown -->
                        <div class="mb-3">
    <label for="endorseTo" class="form-label">Endorse To</label>
    <select class="form-select" id="endorseTo" name="endorse_to" required>
        <option value="" selected disabled>Select Branch Manager</option>

        @foreach($branches as $branch) <!-- Use a consistent variable name -->
            <option value="{{ optional($branch['branch_manager'])['id'] }}">{{optional($branch['branch_manager'])['fullname'] }}</option> <!-- Corrected variable name -->
        @endforeach
    </select>
</div>


                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">Submit Endorsement</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- modal form for Branch Managers -->
    <!-- Analyze Modal Form -->
    <div class="modal fade" id="analyzeModal" tabindex="-1" aria-labelledby="analyzeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Changed this line to use 'modal-lg' -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="analyzeModalLabel">Analyze Concern</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="analyzeForm" action="{{ route('posts.analyze') }}" method="POST">
                        @csrf
                        @method('put')

                       <!-- Hidden input for the post ID -->
                       <input type="text" name="posts_id" id="posts_id" value="">


                         <!-- Prepared By - Hidden Field for Authenticated User -->
                         @if($authenticatedUser)
                        <input type="text" name="endorse_by" id="endorse_by" value="{{ $authenticatedUser['id'] }}">
                        @endif

                        <!-- Display Name -->
                        <div class="mb-3">
                            <label for="analyzePostName" class="form-label">Member Name</label>
                            <input type="text" class="form-control" id="analyzePostName" readonly>
                        </div>

                        <!-- Display Branch -->
                        <div class="mb-3">
                            <label for="analyzeBranch" class="form-label">Branch</label>
                            <input type="text" class="form-control" name="branch_name" id="analyzeBranch" readonly>
                        </div>

                        <!-- Display Contact Number -->
                        <div class="mb-3">
                            <label for="analyzeContact" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contact_number" id="analyzeContact" readonly>
                        </div>

                        <!-- Tasks Section -->
                        <div class="mb-3">
                            <label class="form-label">Action Taken</label>
                            <div id="tasksContainer">
                                <!-- Initial Task -->
                                <input type="text" name="tasks[]" class="form-control mb-2" placeholder="Action 1" required>
                            </div>
                            <button type="button" id="addTaskButton" class="btn btn-secondary">Add Task</button>
                            <button type="button" id="removeTaskButton" class="btn btn-danger" style="display: none;">Less Task</button>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">Resolved</button>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <!-- jQuery Full Version -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


<script>

$(document).on('click', '#analyzeButton', function () {
    const postId = $(this).data('id');
    const postName = $(this).data('name');
    const postBranch = $(this).data('branch');
    const postContact = $(this).data('contact');



    $('#posts_id').val(postId);
    $('#analyzePostName').val(postName);
    $('#analyzeBranch').val(postBranch || '');
    $('#analyzeContact').val(postContact || '');
});

</script>

<script>
    $(document).ready(function() {
        // Add Task functionality
        $(document).on('click', '#addTaskButton', function () {
            const taskInput = '<input type="text" name="tasks[]" class="form-control mb-2" placeholder="Action" required>';
            $('#tasksContainer').append(taskInput);

            // Show "Remove Task" button when at least one task is added
            $('#removeTaskButton').show();
        });

        // Remove Task functionality
        $(document).on('click', '#removeTaskButton', function () {
            // Remove the last task input field
            $('#tasksContainer input').last().remove();

            // Hide "Remove Task" button if there are no more task fields
            if ($('#tasksContainer input').length === 0) {
                $('#removeTaskButton').hide();
            }
        });
    });
</script>


    <script>
        $(document).ready(function() {

            $(document).on('click', '#endorseButton', function() {
                id = $(this).attr('data-id')
                $('#post_id').val(id)
            })
        })
    </script>



    <script>
        // JavaScript to set the current date
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('exampleInputDate1');
            const currentDate = new Date().toISOString().split('T')[0]; // Get current date in 'YYYY-MM-DD' format
            dateInput.value = currentDate;
        });
    </script>

    <script>
        // Function to get the current timestamp
        function getCurrentTimestamp() {
            // Create a new Date object
            const currentDate = new Date();

            // Format the date and time
            const formattedDate = currentDate.toLocaleString(); // Example: "MM/DD/YYYY, HH:MM:SS AM/PM"

            // Set the formatted date to the input field
            document.getElementById('exampleInputDate1').value = formattedDate;
        }

        // Call the function on page load
        window.onload = getCurrentT
    </script>


    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>
