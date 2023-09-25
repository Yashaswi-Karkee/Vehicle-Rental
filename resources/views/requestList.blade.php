<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ads List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">My Posts</h2>

            @if ($data->count() > 0)
                <!-- Ads List -->
                <ul class="space-y-4">
                    <!-- Ad Item 1 -->
                    <li class="border rounded-lg p-4 flex items-center">
                        <div class="mr-4">
                            <img src="ad1.jpg" alt="Ad 1" class="w-16 h-16 rounded-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Ad Title 1</h3>
                            <p class="text-sm text-gray-600">Description for Ad 1. Lorem ipsum dolor sit amet,
                                consectetur
                                adipiscing elit.</p>
                            <div class="mt-2">
                                <button class="text-indigo-500 hover:underline">Edit</button>
                                <button class="text-red-500 hover:underline">Delete</button>
                            </div>
                        </div>
                    </li>

                    <!-- Ad Item 2 -->
                    <li class="border rounded-lg p-4 flex items-center">
                        <div class="mr-4">
                            <img src="ad2.jpg" alt="Ad 2" class="w-16 h-16 rounded-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Ad Title 2</h3>
                            <p class="text-sm text-gray-600">Description for Ad 2. Sed euismod sapien et turpis
                                fermentum,
                                nec hendrerit risus pharetra.</p>
                            <div class="mt-2">
                                <button class="text-indigo-500 hover:underline">Edit</button>
                                <button class="text-red-500 hover:underline">Delete</button>
                            </div>
                        </div>
                    </li>

                    <!-- Add more ad items as needed -->
                </ul>
            @else
                <ul class="space-y-4">
                    <!-- No Ads Created -->
                    <li class="border rounded-lg p-4 flex items-center justify-center">
                        <p class="text-lg font-semibold text-gray-800">No Ads Created</p>
                    </li>
            @endif
        </div>
    </div>
</body>

</html>
