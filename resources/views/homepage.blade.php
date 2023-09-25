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
                            <a href="{{ route('user.profile.show', $data->email) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Profile</a>
                            @if ($data->latitude)
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
    <main class="p-4 grid grid-cols-1 md:grid-cols-2 justify-between">

        <!-- Content -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <!-- Search Bar -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Search</h2>
                <div class="flex space-x-4">
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
                </div>
            </div>

            <!-- Posts Section -->
            <div>
                <h2 class="text-xl font-semibold mb-4">All Posts</h2>
                <!-- If No Posts Found -->
                <p class="text-gray-600 mb-4">No posts found.</p>
                <!-- Sample Post -->
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <img src="post-image.jpg" alt="Post Image" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Post Title</h3>
                            <p class="text-gray-600">Owner: John Doe</p>
                        </div>
                    </div>
                    <p class="text-gray-600">Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <p class="text-gray-600">Vehicle Type: Cycle</p>
                    <p class="text-gray-600">Price: $50</p>
                    <p class="text-gray-600">Quantity Available: 5</p>
                    <button
                        class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4">
                        Order
                    </button>
                </div>
                <!-- Add more posts here as needed -->
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
