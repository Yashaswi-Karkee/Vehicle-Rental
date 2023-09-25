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
