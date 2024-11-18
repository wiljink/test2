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
    <title>Document</title>
</head>
<body>
    <h1 align='center'>Product</h1>
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
    <div align='center'>
      <table border="1">
        <tr>
          <th>ID</th>
          <th>NAME</th>
          <th>BRANCH</th>
          <th>CONTACT NUMBER</th>
          <th>DATE</th>
          <th>CONCERN</th>
          <th>MESSAGE</th>
        </tr>
        @foreach($posts as $posts)
        <tr>
            <td>{{$posts->id}}</td>
            <td>{{$posts->name}}</td>
            <td>{{$posts->branch}}</td>
            <td>{{$posts->contact_number}}</td>
            <td>{{$posts->date}}</td>
            <td>{{$posts->concern}}</td>
            <td>{{$posts->message}}</td>
            <td>
              <a href="{{route('product.edit', ['product'=> $product])}}">Edit</a>
            </td>
            <td>
            <form action="{{ route('product.destroy', $product->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
          </form>

            </td>
        </tr>
      @endforeach
      </table>
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