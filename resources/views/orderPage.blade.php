<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
</head>
{{-- <script>
    function validateDate() {
        // Get the current date
        var currentDate = new Date();

        // Get the value of the pick-up date input field
        var pickUpDate = new Date(document.getElementById('pickUpDate').value);

        // Compare the pick-up date with the current date
        if (pickUpDate < currentDate) {
            // Display an error message
            alert('Pick-Up Date must be in the future.');
            return false; // Prevent the form from submitting
        }
        return true; // Allow form submission if date is valid
    }
</script> --}}

<body class="bg-gray-100 font-sans p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md relative">
        <!-- Close Icon -->
        <a href="{{ route('homepage') }}" class="absolute top-2 right-2">
            <i class="fas fa-times text-gray-600 hover:text-gray-800 cursor-pointer text-2xl"></i>
        </a>
        <!-- Post Details -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Post Details</h2>
            <p><strong>Post ID:</strong> {{ $id }}</p>
            <p><strong>User Email:</strong> {{ $userEmail }}</p>
            <p><strong>Agency Email:</strong> {{ $agencyEmail }}</p>

        </div>

        <!-- Order Form -->
        <div class="order-form">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create Order</h2>
            @if (Session::has('success'))
                <div role="alert" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 mb-4">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('fail'))
                <div role="alert"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ Session::get('fail') }}
                </div>
            @endif
            <form action="{{ route('order.post', [$id, $userEmail, $agencyEmail]) }}" method="POST">
                @csrf
                <!-- Form Inputs -->
                <!-- Pick-Up Date -->
                <div class="mb-4">
                    <label for="pickUpDate" class="block text-gray-700 font-semibold mb-2">Pick-Up Date</label>
                    <input type="date" id="pickUpDate" name="pickUpDate"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                    <span class=" text-red-600">
                        @error('pickUpDate')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <!-- Drop Date -->
                <div class="mb-4">
                    <label for="dropDate" class="block text-gray-700 font-semibold mb-2">Drop Date</label>
                    <input type="date" id="dropDate" name="dropDate"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                    <span class=" text-red-600">
                        @error('dropDate')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <!-- Pick-Up Time -->
                <div class="mb-4">
                    <label for="pickUpTime" class="block text-gray-700 font-semibold mb-2">Pick-Up Time</label>
                    <input type="time" id="pickUpTime" name="pickUpTime"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <!-- Drop Time -->
                <div class="mb-4">
                    <label for="dropTime" class="block text-gray-700 font-semibold mb-2">Drop Time</label>
                    <input type="time" id="dropTime" name="dropTime"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <!-- Pick-Up Location -->
                <div class="mb-4">
                    <label for="pickUpLocation" class="block text-gray-700 font-semibold mb-2">Pick-Up Location</label>
                    <input type="text" id="pickUpLocation" name="pickUpLocation"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <!-- Drop Location -->
                <div class="mb-6">
                    <label for="dropLocation" class="block text-gray-700 font-semibold mb-2">Drop Location</label>
                    <input type="text" id="dropLocation" name="dropLocation"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                        class="w-full bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-6">Create
                        Order</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
