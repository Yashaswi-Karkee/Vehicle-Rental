<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <title>Pending Requests</title>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <!-- Close Icon to Navigate to Previous Page -->
        <a href="{{ route('show.admin') }}" class="text-gray-500 hover:text-gray-700 text-xl absolute top-4 right-4">
            <!-- Use Font Awesome icon class -->
            <i class="fas fa-times text-2xl"></i>
        </a>
        @if (Session::has('success'))
            <div role="alert" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3">
                {{ Session::get('success') }}</div>
        @endif
        @if (Session::has('fail'))
            <div role="alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ Session::get('fail') }}</div>
        @endif
        <!-- User Verification Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @if ($pend == 1)
                @foreach ($agency as $ag)
                    <!-- User Verification Card 1 -->
                    <div class="bg-white rounded-lg p-4 shadow-md">
                        <h2 class="text-xl font-semibold mb-2">User Information</h2>
                        <p><strong>Email:</strong><a href="mailto:{{ $ag->email }}">{{ $ag->email }}</a>
                        </p>
                        <p><strong>Address:</strong> <a
                                href="https://www.google.com/maps?q={{ $ag->latitude }},{{ $ag->longitude }}">{{ $ag->address }}</a>
                        </p>
                        <p><strong>Contact:</strong> <a href="tel:{{ $ag->contact }}">{{ $ag->contact }} </a>
                        </p>
                        <p><strong>PAN No:</strong> {{ $ag->PAN_no }}</p>
                        <p><strong>Registration No:</strong> {{ $ag->register_number }}</p>
                        <div class="mt-4">
                            <p><strong>PAN Image:</strong></p>
                            <img src="{{ asset('PANCard/' . $ag->PAN_pic) }}" alt="PAN Image"
                                class="w-full h-auto rounded-lg">
                        </div>
                        <div class="mt-4">
                            <p><strong>Registration Image:</strong></p>
                            <img src="{{ asset('RegistrationCert/' . $ag->company_register_pic) }}"
                                alt="Registration Image" class="w-full h-auto rounded-lg">
                        </div>
                        <div class="mt-4 flex justify-between">
                            <form action="{{ route('accept.account.admin', $ag->email) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Accept</button>
                            </form>
                            <form action="{{ route('reject.account.admin', $ag->email) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Reject</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Display a message when there are no pending requests -->
                <div class="bg-white rounded-lg p-4 shadow-md text-center">
                    <p class="text-xl font-semibold mb-2">No requests at the moment</p>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
