<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <style>
        a.disabled {
            pointer-events: none;
            color: grey;
            cursor: not-allowed;
        }
    </style>

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
        .expanded-column {
            width: auto; /* Or a specific value like 400px */
            max-width: 800px;
            word-wrap: break-word;
            padding: 10px;
        }
    </style>
    
    <style>
        /* Base button style */
.save-progress-btn {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Style for the loading dots */
.save-progress-btn.loading::after {
    content: '...';
    position: absolute;
    right: 10px;
    font-size: 20px;
    animation: dot-blink 1s infinite steps(1);
}

/* Animation for the dots */
@keyframes dot-blink {
    0% { content: '.'; }
    33% { content: '..'; }
    66% { content: '...'; }
    100% { content: '.'; }
}

/* Disable button when loading */
.save-progress-btn.loading {
    background-color: #ccc;
    cursor: not-allowed;
}

    </style>
    <title>Member Concern</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <!-- Common Home Menu Item (Visible for all) -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Home</a>
                </li>
                
                @if($authenticatedUser['account_type_id'] != 7)
               
                    <!-- Members Concerns (Only for non-admin users) -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('posts.index') }}">Members Concerns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('posts.facilitate') }}">Facilitated Concerns</a>
                    </li>
                    
                @endif
                

                @if($authenticatedUser['account_type_id'] == 7)
                    <!-- Endorsed Concerns (Only for users with account_type_id == 7) -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Endorsed Concerns</a>
                    </li>
                @endif

                <!-- Resolved Concerns (Visible for all) -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('posts.index') }}">Resolved Concerns</a>
                </li>

                <!-- Reports (Visible for all) -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Reports</a>
                </li>



                <!-- Logout Button (Visible for all users) -->
                @if(isset($authenticatedUser))
                    <li class="nav-item dropdown">
                        <!-- User Dropdown -->
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hello, {{ $authenticatedUser['fullname'] }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                            <!-- Logout -->
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </div>
                    </li>

                    <!-- Logout Form (Hidden) -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                    </li>
                    @endif


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

</body>




<div class="container d-flex flex-column align-items-center my-4" style="min-height: 100vh;">

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
            @if($authenticatedUser['account_type_id'] == 7)
                <th scope="col">ENDORSED BY</th>
                <th scope="col">TASK</th>
                <th scope="col">DAYS RESOLVED</th>
                <th scope="col">DATE RESOLVED</th>
                <th scope="col">RESOLVED BY</th>
                <th scope="col">STATUS</th>
            @endif
            <th scope="col">ACTION</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $posts)
            <tr>
                <td>{{ $posts->id }}</td>
                <td>{{ $posts->name }}</td>
                <td>
                    @foreach($branches as $branch)
                        @if($posts->branch == $branch['id'])
                            {{ $branch['branch_name'] }}
                        @endif
                    @endforeach
                </td>
                <td>{{ $posts->contact_number }}</td>
                <td>{{ $posts->created_at->format('Y-m-d') }}</td>
                <td>{{ $posts->concern }}</td>
                <td>{{ $posts->message }}</td>
                @if($authenticatedUser['account_type_id'] == 7)
                    <td>{{ $posts->endorse_by_fullname ?? 'N/A' }}</td>
                    <td class="expanded-column">
                        @php
                            $tasks = json_decode($posts->tasks, true);
                        @endphp
                        @if($tasks && is_array($tasks) && count($tasks) > 0)
                            <ol style="font-family: 'Poppins', sans-serif;">
                                @foreach($tasks as $task)
                                    <li>{{ $task }}</li>
                                @endforeach
                            </ol>
                        @else
                            <p style="color: red;">No tasks available.</p>
                        @endif
                    </td>
                    <td>{{ $posts->resolved_days ? json_decode($posts->resolved_days, true)['days'] ?? 'N/A' : 'N/A' }} days</td>
                    <td>{{ $posts->resolved_date ?? 'N/A' }}</td>
                    <td>{{ $posts->resolve_by ?? 'N/A' }}</td>
                    <td>{{ $posts->status ?? 'Pending' }}</td>
                @endif
                <td>
                    @if($authenticatedUser['account_type_id'] == 7)
                        @if($posts->status !== 'Resolved')
                            <a href="#" id="analyzeButton" 
                               class="btn btn-success @if($posts->status === 'Pending') disabled @endif"
                               data-bs-toggle="modal" 
                               data-bs-target="#analyzeModal" 
                               data-id="{{ $posts->id }}"
                               data-name="{{ $posts->name }}"
                               data-branch="{{ $branch['branch_name'] }}" 
                               data-contact="{{ $posts->contact_number }}"
                               data-message="{{ $posts->message }}"
                               data-tasks='{{ json_encode($tasks) }}'>
                                ANALYZE
                            </a>
                        @else
                            <a href="#" id="validateButton"
                               class="btn btn-secondary"
                               data-bs-toggle="modal"
                               data-bs-target="#validateModal"
                               data-id="{{ $posts->id }}"
                               data-name="{{ $posts->name }}"
                               data-branch="{{ $branch['branch_name'] }}"
                               data-contact="{{ $posts->contact_number }}"
                               data-message="{{ $posts->message }}">
                                VALIDATE
                            </a>
                        @endif
                    @else
                        @if($posts->status !== 'Resolved')
                            <a href="#" id="endorseButton" 
                               class="btn btn-primary @if(in_array($posts->status, ['Endorsed', 'In Progress'])) disabled @endif"
                               data-bs-toggle="modal" 
                               data-bs-target="#endorseModal" 
                               data-id="{{ $posts->id }}" 
                               data-branch="{{ $posts->branch }}"
                               data-branch-manager-id="{{ optional($posts->branch_manager)->id }}">
                                ENDORSE
                            </a>
                        @endif
                    @endif
                </td>
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
                    <input type="hidden" name="post_id" id="post_id">

                    <!-- Prepared By - Hidden Field for Authenticated User -->
                    @if($authenticatedUser)
                        <input type="hidden" name="endorse_by" id="endorse_by" value="{{ $authenticatedUser['id'] }}">
                    @endif

                    <!-- Endorse To - Select Dropdown -->
                    <div class="mb-3">
                        <label for="endorseTo" class="form-label">Endorse To</label>
                        <select class="form-select" id="endorseTo" name="endorse_to" required>
                            <option value="" selected disabled>Select Branch Manager</option>
                                @foreach($branches as $branch)
                                    @if($branch['id'] == 23)
                                        @foreach($branch['head_office_management'] as $manager)
                                            <option value="{{ $manager['id'] }}" data-branch-id="{{ $branch['id'] }}">
                                                {{ $manager['fullname'] }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="{{ optional($branch['branch_manager'])['id'] }}"
                                                data-branch-id="{{ $branch['id'] }}">
                                            {{ optional($branch['branch_manager'])['fullname'] }}
                                        </option>
                                    @endif
                                @endforeach

                        </select>
                    </div>

                    <input type="hidden" id="endorsedDate" name="endorsed_date">


                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success" id="submitEndorsement">Submit Endorsement</button>
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
                    <input type="hidden" name="posts_id" id="posts_id" value="">


                    <!-- Prepared By - Hidden Field for Authenticated User -->
                    @if($authenticatedUser)
                        <input type="hidden" name="endorse_by" id="endorse_by" value="{{ $authenticatedUser['id'] }}">
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

                    <div class="mb-3">
                        <label for="analyzeMessage" class="form-label">Message</label>
                        <textarea class="form-control" name="message" id="analyzeMessage" rows="3" readonly></textarea>

                    </div>
                    <!-- Hidden Resolved Date -->

                    <!-- Tasks Section -->
                    <div class="mb-3">
                        <label class="form-label">Action Taken</label>
                        <div id="tasksContainer">
                            <!-- Initial Task -->
                           
                            <input type="text" name="tasks[]" class="form-control mb-2" placeholder="Action 1" required>
                    </div>

                        <button type="button" id="addTaskButton" class="btn btn-secondary">Add Task</button>
                        <!-- <button type="button" id="removeTaskButton" class="btn btn-danger" style="display: none;">Less Task</button> -->
                    </div>

                    <!-- Buttons without inline JavaScript -->
                    <button id="resolvedButton" type="submit" class="btn btn-success">Resolved</button>
                    <button id="saveProgressButton" type="button" class="btn btn-primary">Save Progress</button>



                </form>
            </div>
        </div>
    </div>
</div>





<!-- jQuery Full Version -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>



<!-- endorseModal Form and disable endorse link -->
<script>
$(document).ready(function () {
    // Handle form submission for endorsing
    $('#endorseForm').on('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = $(this).serialize(); // Serialize the form data
        const endorseButton = $('#endorseButton'); // Get the endorse button

        // Disable the button immediately after form submission
        endorseButton.addClass('disabled').attr('disabled', true).text('Endorsed');

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'), // Form action URL
            data: formData,
            success: function (response) {
                // Check if the response indicates success
                if (response.success) {
                    // Hide the modal after success
                    $('#endorseModal').modal('hide');

                    // Update the button state on the page
                    endorseButton.text('Endorsed').attr('disabled', true).addClass('disabled');

                    // Redirect to the posts.index page after success
                    window.location.href = '{{ route('posts.index') }}';  // Redirect to index page
                } else {
                    alert('An error occurred: ' + response.message);
                    // Re-enable the button if there was an error
                    endorseButton.removeClass('disabled').attr('disabled', false).text('Endorse');
                }
            },
            error: function () {
                alert('An error occurred while submitting the endorsement.');
                // Re-enable the button if there was an error
                endorseButton.removeClass('disabled').attr('disabled', false).text('Endorse');
            }
        });
    });

    // Populate the endorse modal with post ID and branch manager
    $('#endorseModal').on('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var postId = button.getAttribute('data-id'); // Extract the post ID
        var branchId = button.getAttribute('data-branch'); // Extract the branch ID

        // Populate the hidden input with the post ID
        document.getElementById('post_id').value = postId;

        // Pre-select the branch manager in the dropdown
        var endorseToSelect = document.getElementById('endorseTo');
        for (let i = 0; i < endorseToSelect.options.length; i++) {
            const option = endorseToSelect.options[i];
            if (option.getAttribute('data-branch-id') === branchId) {
                option.selected = true;
                break;
            }
        }
    });
});
</script>

<!-- analyzeModal for resolved and save progress -->
 <script>
$(document).ready(function () {
    let removedTasks = [];

    // When the analyze button is clicked, populate modal fields
    $(document).on('click', '#analyzeButton', function () {
        const postId = $(this).data('id');
        const postName = $(this).data('name');
        const postBranchName = $(this).data('branch');
        const postContact = $(this).data('contact');
        const postMessage = $(this).data('message');
        const existingTasks = $(this).data('tasks') || [];

        removedTasks = []; // Reset removed tasks

        $('#posts_id').val(postId);
        $('#analyzePostName').val(postName);
        $('#analyzeBranch').val(postBranchName || '');
        $('#analyzeContact').val(postContact || '');
        $('#analyzeMessage').val(postMessage || '');

        const tasksContainer = $('#tasksContainer');
        tasksContainer.empty();

        if (existingTasks.length > 0) {
            existingTasks.forEach((task, index) => appendTask(task, index + 1, tasksContainer));
            $('#removeTaskButton').show();
        } else {
            appendTask('', 1, tasksContainer);
            $('#removeTaskButton').hide();
        }
    });

    // Add Task
    $(document).on('click', '#addTaskButton', function () {
        const taskCount = $('#tasksContainer .task-item').length + 1;
        appendTask('', taskCount, $('#tasksContainer'));
        $('#removeTaskButton').show();
    });

    // Remove Task
    $(document).on('click', '.remove-task', function () {
        const taskInput = $(this).closest('.task-item').find('input[name="tasks[]"]');
        const taskValue = taskInput.val();
        if (taskValue) removedTasks.push(taskValue);
        $(this).closest('.task-item').remove();

        if ($('#tasksContainer .task-item').length === 0) {
            appendTask('', 1, $('#tasksContainer'));
            $('#removeTaskButton').hide();
        }
    });

    // Save Progress and Resolve buttons
    $('#saveProgressButton').on('click', function () {
        handleButtonClick('In Progress', $(this));
    });

    $('#resolvedButton').on('click', function () {
        handleButtonClick('Resolved', $(this));
    });

    function handleButtonClick(status, button) {
        button.prop('disabled', true).addClass('loading');
        submitForm(status, button);
    }

    function appendTask(task, index, container) {
        const taskHtml = `
            <div class="task-item mb-2 d-flex align-items-center">
                <input type="text" name="tasks[]" class="form-control me-2" placeholder="Action ${index}" value="${task}" required>
                <button type="button" class="btn btn-danger btn-sm remove-task">Remove</button>
            </div>`;
        container.append(taskHtml);
    }

    function submitForm(status, button) {
        const analyzeForm = $('#analyzeForm')[0];
        if (!analyzeForm) return console.error('Form not found');

        const formData = new FormData(analyzeForm);

        // Add tasks and removed tasks
        const tasks = getUniqueTasks();
        tasks.forEach(task => formData.append('tasks[]', task));
        removedTasks.forEach(task => formData.append('removed_tasks[]', task));

        formData.append('status', status);

        fetch('{{ route("posts.analyze") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            body: formData
        })
            .then(response => {
                if (!response.ok) throw new Error('Failed to submit form');
                return response.text();
            })
            .then(() => {
                window.location.href = '{{ route("posts.index") }}';
            })
            .catch(error => {
                console.error('Error:', error);
                button.prop('disabled', false).removeClass('loading');
                alert('An error occurred. Please try again.');
            });
    }

    function getUniqueTasks() {
        const taskInputs = $('input[name="tasks[]"]');
        return [...new Set(taskInputs.map((_, input) => $(input).val().trim()).get())].filter(task => task);
    }
});


</script>

<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>