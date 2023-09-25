<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex items-center justify-center">
        <!-- Registration Card -->
        <div class="bg-white p-8 rounded shadow-md w-96 mx-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Register</h2>
            <form action="{{ route('update.profile', $data1->email) }}" method="POST" enctype="multipart/form-data">
                @if (Session::has('success'))
                    <div role="alert" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3">
                        {{ Session::get('success') }}</div>
                @endif
                @if (Session::has('fail'))
                    <div role="alert"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ Session::get('fail') }}</div>
                @endif
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="image"
                        class="relative rounded-full h-full w-full mb-4 cursor-pointer flex justify-center">
                        <input type="file" id="image" name="image" hidden onchange="displayImage(this)">
                        <div class="bg-gray-300 rounded-full w-32 h-32 flex items-center justify-center">
                            <div class="text-4xl text-gray-600">+</div>
                        </div>
                        <img id="profile-image" src="{{ asset('profile_pictures/' . $data1->profile_pic) }}"
                            alt="Profile Picture"
                            class="absolute w-32 h-32 rounded-full object-cover opacity-1 transition duration-300">
                    </label>
                    <span class=" text-red-600">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </span>

                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ $data1->name }}"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input type="email" id="email" name="email" value="{{ $data1->email }}"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition duration-300">Save
                        Changes</button>
                </div>
            </form>
            <div class="mb-4 flex">
                <a href="{{ route('profile') }}"
                    class="w-full text-center py-2 px-4 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition duration-300">Go
                    Back</a>
            </div>

        </div>
    </div>
</body>
<script type="text/javascript">
    function displayImage(input) {
        const image = document.getElementById('profile-image');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                // image.style.opacity = 1;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</html>
