<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans p-6">

    <!-- Close Icon -->
    <button class="absolute top-0 right-0 mt-2 mr-2 text-gray-600 hover:text-gray-800 focus:outline-none">
        <i class="fas fa-times"></i>
    </button>

    <!-- Post Form -->
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create Post</h2>
        <form action="{{ route('create.post.post', $email) }}" method="POST">
            <!-- Post Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
            </div>
            <span class=" text-red-600">
                @error('title')
                    {{ $message }}
                @enderror
            </span>



            <!-- Post Type Dropdown -->
            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-semibold mb-2">Vehicle Type</label>
                <select id="type" name="type"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                    <option value="Cycle">Cycle</option>
                    <option value="2WD">2 Wheeler</option>
                    <option value="4WD">4 Wheeler</option>
                </select>
            </div>
            <span class=" text-red-600">
                @error('title')
                    {{ $message }}
                @enderror
            </span>

            <!-- Post Price -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-semibold mb-2">Price</label>
                <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
            </div>
            <span class=" text-red-600">
                @error('price')
                    {{ $message }}
                @enderror
            </span>

            <!-- Post Quantity -->
            <div class="mb-6">
                <label for="quantity" class="block text-gray-700 font-semibold mb-2">Quantity</label>
                <input type="number" step="1" id="quantity" name="quantity" value="{{ old('quantity') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
            </div>
            <span class=" text-red-600">
                @error('quantity')
                    {{ $message }}
                @enderror
            </span>
            <!-- Post Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea id="description" name="description" rows="4" value="{{ old('description') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required></textarea>
            </div>
            <span class=" text-red-600">
                @error('description')
                    {{ $message }}
                @enderror
            </span>

            <!-- Post Image Upload -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-semibold mb-2">Add Image</label>
                <input type="file" id="image" name="image" value="{{ old('image') }}"
                    class="w-full focus:outline-none" accept="image/*" required>
            </div>
            <span class=" text-red-600">
                @error('image')
                    {{ $message }}
                @enderror
            </span>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                    class="w-full bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-6">Create
                    Post</button>
            </div>
        </form>
    </div>

</body>

</html>
