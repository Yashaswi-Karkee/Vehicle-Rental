<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
</head>
<style>
    @media screen and (max-width: 800px) {
        #main {
            width: 90vw;
            flex-direction: column;
            justify-content: center;
        }

        #left,
        #right {
            width: 100%;
            margin-bottom: 50px;
        }

        #left {
            padding-right: 0;
            padding: 20px;
        }
    }

    @media screen and (max-width: 1250px) {
        #main {
            width: 70vw;
        }
    }

    /* Close icon styles */
    .close-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        cursor: pointer;
    }
</style>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-7/12 bg-white p-8 rounded shadow-md mx-4 flex" id="main">
            <!-- Close Icon -->
            <a href="{{ route('homepage') }}"><i class="fas fa-times text-gray-600 text-2xl close-icon"></i>
            </a>
            <!-- Left Box - Profile Picture, Name, and Email -->
            <div class="w-1/2 pr-8 flex justify-center flex-col" id="left">
                <!-- Profile Picture with Edit Icon -->
                <div class="mb-6 flex items-center justify-center relative">
                    <img src="{{ asset('profile_pictures/' . $data1->profile_pic) }}" alt="Profile Picture"
                        class="w-32 h-32 rounded-full border">
                </div>

                <!-- User Name and Email with Edit Icons -->
                <div class="text-center flex justify-center">
                    <div class="mb-4 text-lg font-semibold text-gray-800 flex items-center justify-center">
                        {{ $data1->name }}
                    </div>
                </div>
                <div class="text-lg font-semibold text-gray-800 flex items-center justify-center">
                    {{ $data1->email }}
                </div>
                <a href="{{ route('edit.profile') }}"
                    class="w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition duration-300 mt-4">
                    Edit Profile
                </a>
            </div>

            <!-- Right Box - Change Password Form and Delete Account Button -->
            <div class="w-1/2 pl-8">
                @if (Session::has('success'))
                    <div role="alert" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3">
                        {{ Session::get('success') }}</div>
                @endif
                @if (Session::has('fail'))
                    <div role="alert"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ Session::get('fail') }}</div>
                @endif
                <!-- Change Password Form -->
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Change Password</h3>
                <form action="{{ route('update.password', $data1->email) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="current" class="block text-sm font-medium text-gray-600">Current
                            Password</label>
                        <input type="password" id="current-password" name="current"
                            class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    </div>
                    <span class=" text-red-600">
                        @error('current')
                            {{ $message }}
                        @enderror
                    </span>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-600">New Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    </div>
                    <span class=" text-red-600">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Confirm
                            Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    </div>
                    <span class=" text-red-600">
                        @error('password_confirmation')
                            {{ $message }}
                        @enderror
                    </span>

                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition duration-300">Change
                        Password</button>
                </form>

                <!-- Delete Account Button -->
                <form action="{{ route('delete.account', $data1->email) }}" method="POST">
                    @method('delete')
                    @csrf
                    <div class="mt-4 flex">
                        <button type="submit"
                            class="w-full text-center bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md transition duration-300">Delete
                            Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
