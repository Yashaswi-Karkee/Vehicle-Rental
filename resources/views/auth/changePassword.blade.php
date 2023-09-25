<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded shadow-md w-96 mx-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Change Password</h2>
            @if (Session::has('success'))
                <div role="alert" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3">
                    {{ Session::get('success') }}</div>
            @endif
            @if (Session::has('fail'))
                <div role="alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ Session::get('fail') }}</div>
            @endif
            <form action="{{ route('password.reset.post') }}" method="POST">
                @csrf
                <input type="text" name="token" value="{{ $token }}" hidden>
                {{-- Email --}}
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
                <span class=" text-red-600">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
                <!-- New Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-600">New Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
                <span class=" text-red-600">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>

                <!-- Confirm New Password Input -->

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Confirm New
                        Password</label>
                    <input type="password" id="confirm-password" name="password_confirmation"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
                <span class=" text-red-600">
                    @error('password_confirmation')
                        {{ $message }}
                    @enderror
                </span>

                <!-- Submit Button -->
                <button type="submit"
                    class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 w-full">Change
                    Password</button>
            </form>
        </div>
    </div>
</body>

</html>
