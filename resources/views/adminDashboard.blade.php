<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- Navigation Bar -->
    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-semibold">Admin Dashboard</h1>
            <div class="relative group">
                <button id="avatar-button" class="flex items-center text-white focus:outline-none">
                    <img src="profile-avatar.jpg" alt="Admin Avatar" class="w-12 h-12 rounded-full mr-2 border">
                    <span class="hidden md:inline-block">Hi! Admin</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 group-hover:block hidden"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M2.293 7.293a1 1 0 011.414 0L10 13.586l6.293-6.293a1 1 0 111.414 1.414l-7 7a1 1 0 01-1.414 0l-7-7a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="dropdown-menu"
                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg hidden">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">Requests</a>
                    <a href="{{ route('logout.admin') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">Logout</a>
                </div>

            </div>
        </div>
    </nav>

    <!-- Content Section -->
    <div class="container mx-auto p-6 mt-8 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>
        <!-- Add your content here -->
    </div>

</body>
<script>
    // Function to toggle the dropdown menu
    function toggleDropdown() {
        var dropdownMenu = document.getElementById("dropdown-menu");
        dropdownMenu.classList.toggle("hidden");
    }

    // Attach a click event listener to the avatar button
    var avatarButton = document.getElementById("avatar-button");
    avatarButton.addEventListener("click", toggleDropdown);
</script>


</html>
