<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <!-- Add the link to Tailwind CSS file -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white p-6 rounded-md shadow-md" style="height: 600px; overflow-y:scroll">
        <!-- Close Button -->
        <a href="{{ route('homepage') }}" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
            <i class="fas fa-times text-xl"></i>
        </a>
        <h1 class="text-2xl font-semibold mb-4">Notifications</h1>

        <!-- Notification list -->
        @if (!$notification->isEmpty())
            <ul>
                <!-- Notification item -->
                @foreach ($notification as $notify)
                    <li class="mb-4">
                        <div class="flex items-center justify-between">
                            <div class="border-2 bg-gray-200 m-0 p-4 rounded-lg">
                                <p class="text-gray-600">{{ $notify->message }}</p>
                                <span class="text-sm text-gray-500">{{ date('M d, Y', strtotime($notify->created_at)) }}
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No notifications to display.</p>
        @endif
    </div>
</body>

</html>
