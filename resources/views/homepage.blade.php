<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<style>
    /* Additional CSS styles */
    .filter-options {
        display: none;
        background-color: white;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: absolute;
        z-index: 999;

        width: 150px;

        /* Adjust the width as needed */
    }
</style>

<body class="bg-gray-100 font-sans">
    <!-- Top Navigation Bar -->

    <nav class="bg-white shadow-md p-4">
        <div class="flex justify-between items-center">

            <!-- Brand Logo -->
            <a href="{{ route('homepage') }}" class="text-2xl font-semibold text-gray-800">Dashboard</a>

            @if (Session()->has('loginEmail'))
                <!-- User Avatar and Dropdown -->
                <div class="relative inline-block text-left">
                    <button type="button" class="focus:outline-none" id="avatarButton">
                        @if ($data->latitude)
                            <img src="{{ asset('profile_pictures/' . $data->profile_pic) }}" alt="User Avatar"
                                class="w-12 h-12 rounded-full">
                        @else
                            <img src="{{ asset('profile_pictures/' . $data->profile_pic) }}" alt="User Avatar"
                                class="w-12 h-12 rounded-full">
                        @endif
                    </button>
                    <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                        style="display: none" id="options">
                        <div class="py-1">
                            @if ($data->latitude)
                                <a href="{{ route('user.profile.show', $data->email) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Profile</a>
                                <a href="{{ route('show.requests') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Requests</a>
                            @else
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">My
                                    Rides</a>
                            @endif
                            <a href="{{ route('settings') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Settings</a>


                            <a href="{{ route('logout') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Logout</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="space-x-4">

                    <a href="{{ route('login') }}"
                        class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4 transition duration-300">Login</a>
                    <a href="{{ route('registrationUser') }}"
                        class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4 transition duration-300">Register</a>
                </div>
            @endif

        </div>
    </nav>
    <!-- Main Content -->
    <main class="p-12 grid grid-cols-1 justify-between">

        <!-- Content -->
        <div class="bg-white shadow-md rounded-lg p-12">
            <!-- Search Bar -->
            <div class="mb-1 w-full flex flex-col justify-end">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold mb-4">Search</h2>

                </div>
                <div class="flex justify-end space-x-4 w-full">
                    <!-- Vehicle Type Dropdown -->
                    <div class="relative">
                        <select
                            class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:ring"
                            id="vehicleType">
                            <option value="cycle">Cycle</option>
                            <option value="two-wheeler">Two-Wheeler</option>
                            <option value="four-wheeler">Four-Wheeler</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M9.293 11.293a1 1 0 011.414 0l5 5a1 1 0 01-1.414 1.414L10 12.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 010-1.414z" />
                            </svg>
                        </div>
                    </div>
                    <!-- Search Button -->
                    <button
                        class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4">
                        Search
                    </button>
                    <!-- Filter Button -->
                    <button
                        class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4"
                        id="filterButton">Filter <i class="fas fa-filter ml-2"></i></button>
                </div>
            </div>

            <!-- Filter Options (Initially Hidden) -->
            <div class="flex justify-end w-full">
                <div class="filter-options" id="filterOptions">
                    <!-- Add your filter options here as anchor tags -->
                    <a href="#" class="block mb-2">Option 1</a>
                    <a href="#" class="block mb-2">Option 2</a>
                    <!-- Add more filter options as needed -->
                </div>
            </div>
            <input type="number" id="latitude" name="latitude" value="{{ old('latitude') }}"
                step="0.00000000000000001" hidden>
            <input type="number" id="longitude" name="longitude" value="{{ old('longitude') }}"
                step="0.00000000000000001" hidden>


            <!-- Posts Section -->
            <div class="mt-7">
                <h2 class="text-xl font-semibold mb-4">Available Vehicles</h2>
                <!-- If No Posts Found -->
                <p class="text-gray-600 mb-4">No posts found.</p>
                <!-- Sample Post -->
                <div class="mb-8 bg-white rounded-lg shadow-md max-w-sm p-2">
                    <img src="post-image.jpg" alt="Post Image" class="w-full h-40 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Post Title</h3>
                        <p class="text-gray-600 mb-2">
                            Lorem ipsum dolor sit amet
                            consectetur adipisicing elit. Aliquid sit eligendi itaque praesentium culpa consectetur.
                        </p>
                        <p class="text-gray-600 mb-2">
                            <i class="fas fa-bicycle text-indigo-500 mr-2"></i>Cycle
                        </p>
                        <p class="text-gray-600 mb-2">
                            <i class="fas fa-dollar-sign text-indigo-500 mr-2"></i>Rs 500/day
                        </p>
                        <p class="text-gray-600 mb-4">
                            <i class="fas fa-cubes text-indigo-500 mr-2"></i>Available: 5
                        </p>
                        <p class="text-gray-600 mb-2">
                            <i class="fas fa-user text-indigo-500 mr-2"></i>John Doe
                        </p>
                        <p class="text-gray-600 mb-2">
                            <i class="fas fa-phone text-indigo-500 mr-2"></i>9841662237
                        </p>
                        <p class="text-gray-600 mb-2">
                            <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>123 Main Street, City, Country
                        </p>
                        <button
                            class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4 mt-2">
                            Order
                        </button>
                    </div>
                </div>
            </div>
            <!-- Add more posts here as needed -->
        </div>
        </div>
    </main>
</body>
<script>
    const avtButton = document.querySelector("#avatarButton");
    const menu = document.querySelector('#options');
    const filterButton = document.getElementById("filterButton");
    const filterOptions = document.getElementById("filterOptions");
    var lat = document.getElementById('latitude');
    var long = document.getElementById('longitude');

    function GetMap() {

        navigator.geolocation.getCurrentPosition(function(position) {
            var center = new Microsoft.Maps.Location(
                position.coords.latitude,
                position.coords.longitude
            );

            lat.value = center.latitude;
            long.value = center.longitude;
            console.log(lat.value)
        });
    }

    function showMenu() {
        if (menu.style.display === "none") {
            menu.style.display = "block";
        } else {
            menu.style.display = "none";
        }
    }

    function toggleFilterOptions() {
        if (filterOptions.style.display === "none" || filterOptions.style.display === "") {
            filterOptions.style.display = "block";
        } else {
            filterOptions.style.display = "none";
        }
    }

    avtButton.addEventListener("click", showMenu);

    filterButton.addEventListener("click", toggleFilterOptions);
</script>
<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' async defer></script>

</html>
