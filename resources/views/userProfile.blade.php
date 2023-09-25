<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <!-- User Profile Header -->
            <div class="flex items-center mb-6">
                <div class="mr-4">
                    <img src="profile-pic.jpg" alt="User Profile Picture" class="w-16 h-16 rounded-full object-cover">
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">User Name</h2>
                    <p class="text-gray-600">user@email.com</p>
                </div>
            </div>

            <!-- User Contact and Address -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Contact Information</h3>
                <p class="text-gray-600">Phone: +1 123-456-7890</p>
                <p class="text-gray-600">Address: 123 Street Name, City, Country</p>
            </div>

            <!-- My Posts Section -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ride History</h3>
                <!-- If User Has Posts -->
                <ul class="space-y-4">
                    <!-- Post Item 1 -->
                    <li>
                        <div class="border rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-800">Post Title 1</h4>
                            <p class="text-gray-600">Description for Post 1. Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit.</p>
                        </div>
                    </li>

                    <!-- Post Item 2 -->
                    <li>
                        <div class="border rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-800">Post Title 2</h4>
                            <p class="text-gray-600">Description for Post 2. Sed euismod sapien et turpis fermentum, nec
                                hendrerit risus pharetra.</p>
                        </div>
                    </li>

                    <!-- Add more post items as needed -->
                </ul>
                <!-- If User Has No Posts -->
                <p class="text-gray-600 mt-4">You have not posted anything yet.</p>
            </div>
        </div>
    </div>
</body>

</html>
