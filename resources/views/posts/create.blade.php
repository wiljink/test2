<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles */
        .custom-container {
            background-color: #004d00; /* Dark green background */
            padding: 30px;
            border-radius: 10px;
            color: #fff; /* White text for better contrast */
        }

        .custom-form {
            border: 1px solid #ccc; /* Border around the form */
            padding: 20px;
            border-radius: 5px;
            background-color: #fff; /* White background for the form */
            color: #000; /* Default black text for form content */
        }
        .button-container {
            display: flex;
            gap: 15px; /* Add gap between buttons */
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
        .loans-btn { background-color: #007bff; }      /* Blue */
        .deposits-btn { background-color: #6c757d; }   /* Gray */
        .customer-service-btn { background-color: #28a745; } /* Green */
        .general-btn { background-color: #17a2b8; }     /* Teal */
    </style>
    <title>Post</title>
</head>
<body>
    <h1 align='center'>Create Concern</h1>
    <div align='center'>
    @if(session()->has('success'))
        <div>
            {{ session('success') }}
        </div>
    @elseif(session()->has('delete'))
        <div>
            {{ session('delete') }}
        </div>
    @endif
</div>
   




<form  method="post" action="{{route('posts.store')}}">
        @csrf
        @method('post')
    <div class="container custom-container mt-5">
        <form class="custom-form">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name">
                <small id="emailHelp" class="form-text text-muted">Input Name</small>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Branch</label>
                <select class="form-control" id="exampleFormControlSelect1" name="branch">
                    <option value=" " selected>Select Branch</option>
                    <option value="1">Yacapin</option>
                    <option value="2">Cogon</option>
                    <option value="3">Puerto</option>
                    <option value="4">Carmen</option>
                    <option value="5">Agora</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Contact Number</label>
                <input type="tel" class="form-control" id="exampleInputPassword1" placeholder="Contact Number" name="contact_number">
            </div>

            <div class="form-group">
                <label for="exampleInputDate1">Date</label>
                <input type="text" class="form-control" id="exampleInputDate1" name="date" placeholder="Date" disabled>
                
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect2">Concern</label>
                <select class="form-control" id="exampleFormControlSelect2" name="concern">
                    <option value="" selected>Select Concern</option>
                    <option value="1">Loans</option>
                    <option value="2">Deposits</option>
                    <option value="3">Customer Service</option>
                    <option value="4">General</option>
                </select>
            </div>

            <div class="container">
        <div class="button-container">
            <label for="">Select Concern Type:</label>
            <button class="custom-button loans-btn">Loans</button>
            <button class="custom-button deposits-btn">Deposits</button>
            <button class="custom-button customer-service-btn">Customer Service</button>
            <button class="custom-button general-btn">General</button>
        </div>
    </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>



<script>
    // JavaScript to set the current date
    document.addEventListener('DOMContentLoaded', function () {
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>