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
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-xl flex flex-col">
            <!-- Close Icon (Top Right Corner) -->
            <a class="absolute top-2 right-2 text-gray-500 hover:text-gray-800" href="{{ route('homepage') }}">
                <i class="fas fa-times text-2xl"></i>
            </a>
            @if (Session::has('success'))
                <div role="alert" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3">
                    {{ Session::get('success') }}</div>
            @endif
            @if (Session::has('fail'))
                <div role="alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ Session::get('fail') }}</div>
            @endif
            <!-- User Profile Content -->
            <div id="profileContent" class="w-full block">
                <!-- User Profile Header -->
                <div class="w-full flex flex-col justify-center items-center mb-8">
                    <div class="flex justify-center mt-4">
                        <img src="{{ asset('profile_pictures/' . $data->profile_pic) }}" alt="User Profile Picture"
                            class="w-16 h-16 rounded-full object-cover mb-8">
                    </div>
                    <div class="flex justify-center flex-col items-center">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $data->name }}</h2>
                        <p class="text-gray-600">{{ $data->email }}</p>
                    </div>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Contact Information</h3>
                    <!-- Phone Icon -->
                    <p class="text-gray-600"><i class="fas fa-phone text-indigo-500 mr-2"></i>{{ $data->contact }}</p>
                    <!-- Address Icon -->
                    <p class="text-gray-600"><i
                            class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>{{ $data->address }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Address</h3>
                    <input type="number" id="latitude" name="latitude" value="{{ $data->latitude }}"
                        step="0.00000000000000001" hidden>
                    <input type="number" id="longitude" name="longitude" value="{{ $data->longitude }}"
                        step="0.00000000000000001" hidden>
                    <div id="myMap" class="w-full bg-gray-300" style="height: 400px"></div>

                </div>
            </div>
            <!-- Ride Request Content -->
            <div id="rideRequestContent" class="w-full pl-4" style="display: none;">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">My Posts</h3>
                <!-- Sample Post -->
                <div class="mb-4 rounded-lg p-4 flex items-center shadow-lg">
                    <!-- Post Image (Left) -->
                    <div class="w-1/4">
                        <img src="post-image.jpg" alt="Post Image" class="w-full h-auto rounded-lg">
                    </div>
                    <!-- Post Details (Right) -->
                    <div class="w-3/4 pl-4">
                        <!-- Post Title -->
                        <h4 class="text-md font-semibold text-gray-800 mb-2">Post Title</h4>
                        <!-- Post Description -->
                        <p class="text-gray-600 mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <!-- Post Quantity -->
                        <p class="text-gray-600 mb-2"><strong>Quantity:</strong> 5</p>
                        <!-- Post Price -->
                        <p class="text-gray-600 mb-2"><strong>Price:</strong> Rs 500/day</p>
                        <!-- Post Type -->
                        <p class="text-gray-600 mb-2"><strong>Type:</strong> Cycle</p>
                        <!-- Edit and Delete Icons  -->
                        <div class="flex justify-end space-x-4">
                            <!-- Edit Icon -->
                            <button class="text-indigo-500 hover:text-indigo-700 focus:outline-none">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Delete Icon -->
                            <button class="text-red-500 hover:text-red-700 focus:outline-none">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end py-4">

                    <a href="{{ route('create.post.get', $data->email) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition duration-300">Create
                        Post</a>
                </div>

            </div>
            <!-- Toggle Button (Switch between Profile and Ride Requests) -->
            <button
                class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4 mt-2"
                id="toggle">My Posts</button>
        </div>

        <!-- JavaScript to Toggle Profile and Ride Requests -->
        <script>
            // Function to toggle between Profile and Ride Requests
            const toggle = document.getElementById('toggle');

            function toggleView() {
                const profileContent = document.querySelector('#profileContent');
                const rideRequestContent = document.querySelector('#rideRequestContent');

                // Toggle visibility of Profile and Ride Requests
                if (toggle.innerHTML === 'My Posts') {
                    profileContent.style.display = 'none';
                    rideRequestContent.style.display = 'block';
                    toggle.innerHTML = "View Profile";
                } else {
                    profileContent.style.display = 'block';
                    rideRequestContent.style.display = 'none';
                    toggle.innerHTML = "View Ride Requests";
                }
            }
            var lat = document.getElementById('latitude');
            var long = document.getElementById('longitude');

            function GetMap() {

                var map = new Microsoft.Maps.Map('#myMap', {
                    credentials: 'Ami9yJcL6eXX476A77s-16F4ZyLAftc745imSzr9ZWhgNMgv9CcdipqNdAUAJKMH',
                    mapTypeId: Microsoft.Maps.MapTypeId.aerial,
                    zoom: 15,
                });


                navigator.geolocation.getCurrentPosition(function(position) {
                    var center = new Microsoft.Maps.Location(
                        position.coords.latitude,
                        position.coords.longitude
                    );

                    center.latitude = lat.value;
                    center.longitude = long.value;
                    // Add a pushpin at the user 's location.
                    var pin = new Microsoft.Maps.Pushpin(center, {
                        'draggable': false
                    });
                    map.entities.push(pin);
                    // Center the map on the user's location.

                    map.setView({
                        center: center,
                        zoom: 15
                    });
                });
            }


            toggle.addEventListener("click", toggleView);
        </script>
        <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' async defer></script>
    </div>
</body>

</html>
