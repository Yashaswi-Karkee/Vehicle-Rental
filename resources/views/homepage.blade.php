<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

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
                            <a href="{{ route('profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Profile</a>
                            @if ($data->latitude)
                                <a href="{{ route('show.my.ads') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">My
                                    Posts</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Requests</a>
                            @else
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">My
                                    Rides</a>
                            @endif

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
    <main class="p-4 grid grid-cols-1 md:grid-cols-2 justify-between">
        <!-- Ride Search Container -->
        <div class="min-h-screen flex items-center justify-center pb-4">
            <div class="bg-white p-8 rounded shadow-md w-96 mx-4">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Search for a Ride</h2>
                <!-- Pickup Location -->
                <div class="mb-4 relative">
                    <label for="pickup" class="block text-sm font-medium text-gray-600">Pickup Location</label>
                    <input type="text" id="pickup" name="pickup" placeholder="Kathmandu"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none"
                        autocomplete="off">
                    <div id="pickup-suggestions"
                        class="absolute z-10 mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                    </div>
                </div>

                <!-- Pickup Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="pickup-date" class="block text-sm font-medium text-gray-600">Pickup Date</label>
                        <input type="date" id="pickup-date" name="pickup-date"
                            class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="pickup-time" class="block text-sm font-medium text-gray-600">Pickup Time</label>
                        <input type="time" id="pickup-time" name="pickup-time"
                            class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    </div>
                </div>

                <!-- Drop Location -->
                <div class="mb-4 relative">
                    <label for="drop" class="block text-sm font-medium text-gray-600">Drop Location</label>
                    <input type="text" id="drop" name="drop" placeholder="Pokhara"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none"
                        autocomplete="off">
                    <div id="drop-suggestions"
                        class="absolute z-10 mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                    </div>
                </div>

                <!-- Drop Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="drop-date" class="block text-sm font-medium text-gray-600">Drop Date</label>
                        <input type="date" id="drop-date" name="drop-date"
                            class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="drop-time" class="block text-sm font-medium text-gray-600">Drop Time</label>
                        <input type="time" id="drop-time" name="drop-time"
                            class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    </div>
                </div>

                <!-- Vehicle Type Dropdown -->
                <div class="mb-4">
                    <label for="vehicle-type" class="block text-sm font-medium text-gray-600">Vehicle Type</label>
                    <div class="relative">
                        <select id="vehicle-type" name="vehicle-type"
                            class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none appearance-none cursor-pointer">
                            <option value="cycle">Cycle</option>
                            <option value="2wheeler">2 Wheeler</option>
                            <option value="4wheeler">4 Wheeler</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                            <!-- Placeholder Icon (you can replace with actual icons) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Search Button -->
                <div class="mb-4">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition duration-300">Search
                        Ride</button>
                </div>
            </div>
        </div>
        <!-- Content -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Card 1 -->
                <div class="bg-indigo-500 text-white p-4 rounded-lg">
                    <h3 class="text-xl font-semibold">Total Users</h3>
                    <p class="text-4xl font-bold mt-2">1,234</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-green-500 text-white p-4 rounded-lg">
                    <h3 class="text-xl font-semibold">Revenue</h3>
                    <p class="text-4xl font-bold mt-2">$12,345</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-yellow-500 text-white p-4 rounded-lg">
                    <h3 class="text-xl font-semibold">Orders</h3>
                    <p class="text-4xl font-bold mt-2">567</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="mt-8">
                <!-- Add charts or data visualization here -->
                <p class="text-gray-600">Add charts here...</p>
            </div>
        </div>
    </main>
</body>
<script>
    const avtButton = document.querySelector("#avatarButton");
    const menu = document.querySelector('#options');

    function showMenu() {
        if (menu.style.display == "none") {
            menu.style.display = "block";
        } else {
            menu.style.display = "none";
        }
    }

    avtButton.addEventListener("click", showMenu);
</script>

</html>
