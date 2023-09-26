<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <!-- Link to Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
        <!-- User Profile and Ride Request Container -->
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-xl flex">
            <!-- User Profile Content -->
            <div class="w-2/3 pr-4">
                <!-- Close Icon (Top Right Corner) -->
                <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-800" onclick="closeProfile()">
                    <i class="fas fa-times"></i>
                </button>
                <!-- User Profile Header -->
                <div class="flex items-center mb-6">
                    <div class="mr-4">
                        <img src="profile-pic.jpg" alt="User Profile Picture"
                            class="w-16 h-16 rounded-full object-cover">
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">User Name</h2>
                        <p class="text-gray-600">user@email.com</p>
                    </div>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Contact Information</h3>
                    <!-- Phone Icon -->
                    <p class="text-gray-600"><i class="fas fa-phone text-indigo-500 mr-2"></i>+1 123-456-7890</p>
                    <!-- Address Icon -->
                    <p class="text-gray-600"><i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>123 Street Name,
                        City, Country</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Map</h3>
                    <!-- Map (You can replace this with your map component) -->
                    <div id="map" class="w-full h-40 bg-gray-300"></div>
                </div>
            </div>
            <!-- Ride Request Content -->
            <div class="w-8/12 pl-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ride Requests</h3>
                <!-- Scrollable Ride Requests (Replace with actual requests) -->
                <div class="h-64 overflow-y-scroll">
                    <!-- Ride Request Item 1 -->
                    <div class="mb-2 border rounded-lg p-2">
                        <h4 class="text-md font-semibold text-gray-800">Request 1</h4>
                        <p class="text-gray-600">Details for Request 1 Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit.</p>
                    </div>
                    <!-- Ride Request Item 2 -->
                    <div class="mb-2">
                        <h4 class="text-md font-semibold text-gray-800">Request 2</h4>
                        <p class="text-gray-600">Details for Request 2 Sed euismod sapien et turpis fermentum, nec
                            hendrerit risus pharetra.</p>
                    </div>
                    <!-- Add more ride request items as needed -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>
