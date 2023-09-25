<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex items-center justify-center">
        <!-- Login Card -->
        <div class="bg-white p-8 rounded shadow-md w-96 mx-4">
            <!-- Close Icon -->
            <a href="{{ route('homepage') }}"><i
                    class="fas fa-times text-gray-600 text-2xl absolute top-4 right-4 cursor-pointer"></i></a>
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Login</h2>
            <form action="{{ route('loginUser') }}" method="POST">
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
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4 flex justify-end">
                    <a class="block text-sm font-medium text-indigo-500 hover:underline cursor-pointer"
                        href="{{ route('email.verify.get') }}">Forgot
                        Password?</a>
                </div>
                <div class="mb-4">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition duration-300">Login</button>
                </div>
            </form>
            <p class="text-sm text-gray-600 flex justify-center">Don't have an account?<a
                    href="{{ route('registrationUser') }}" class="text-indigo-500 hover:underline mx-1">Register
                    here</a></p>
        </div>
    </div>
</body>

</html>
