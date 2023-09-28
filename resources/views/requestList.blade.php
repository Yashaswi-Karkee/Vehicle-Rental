@php
    use App\Models\User;
    use App\Models\Posts;
    use App\Models\Agency;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ads List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-screen-sm overflow-x-auto">
            <!-- Close Icon -->
            <a href="{{ route('homepage') }}"
                class="absolute top-2 right-2 text-gray-600 hover:text-gray-800
                cursor-pointer">
                <i class="fas fa-times text-2xl"></i>
            </a>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Order Requests</h2>

            <!-- Ads List -->
            @if ($order != null)
                <ul class="space-x-6 flex flex-nowrap overflow-x-scroll">
                    @foreach ($order as $or)
                        @if ($or->isCompleted == '0')
                            @php
                                $prod = Posts::where('id', '=', $or->productId)->first();
                                $user = User::where('email', '=', $or->orderedBy)->first();
                                $agency = Agency::where('email', '=', $or->orderedFrom)->first();
                            @endphp
                            <!-- Ad Item -->
                            <li class="border rounded-lg flex-shrink-0" style="min-width: 300px;">
                                <div class="p-4">
                                    <img class="w-full h-48 bg-cover bg-center"
                                        src="{{ asset('posts_pic/' . $prod->pic) }}" alt="productImage" />
                                    <!-- Product Details -->
                                    <h3 class="text-lg font-semibold text-gray-800 mt-2">{{ $prod->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $prod->description }}</p>
                                    <!-- Order Summary -->
                                    <div class="mt-4">
                                        <h2 class="text-2xl font-semibold text-gray-800">Order Summary</h2>
                                        <div>
                                            <p><strong>Ordered By:</strong> {{ $user->name }}</p>
                                            <p><strong>Contact No:</strong> {{ $user->contact }}</p>
                                            <p><strong>Ordered From:</strong> {{ $agency->name }}</p>
                                            <p><strong>Pick-Up Date:</strong> {{ $or->pickUpDate }}</p>
                                            <p><strong>Pick-Up Time:</strong> {{ $or->pickUpTime }} </p>
                                            <p><strong>Pick-Up Location:</strong> {{ $or->pickUpLocation }} </p>
                                        </div>
                                        <div>
                                            <p><strong>Drop Date:</strong> {{ $or->dropDate }} </p>
                                            <p><strong>Drop Time:</strong> {{ $or->dropTime }} </p>
                                            <p><strong>Drop Location:</strong> {{ $or->dropLocation }}</p>
                                            <p><strong>Total Price:</strong> {{ $or->totalPrice }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-around">
                                        <button class="text-indigo-500 hover:underline">Accept</button>
                                        <button class="text-red-500 hover:underline">Reject</button>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                <div class="mt-6 p-4 border rounded-lg flex items-center justify-center">
                    <p class="text-lg font-semibold text-gray-800">No New Requests</p>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
