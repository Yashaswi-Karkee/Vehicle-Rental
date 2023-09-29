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
        <div class="bg-white p-6 rounded shadow-lg max-w-md min-h-screen overflow-x-auto">
            <!-- Close Icon -->
            <a href="{{ route('homepage') }}"
                class="absolute top-2 right-2 text-gray-600 hover:text-gray-800
                cursor-pointer">
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
            @if ($temp2)
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Order Requests</h2>
            @endif
            @if ($temp1)
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Pending Requests</h2>
            @endif
            <!-- Ads List -->
            @if ($order != null && count($order) > 0)
                <ul class="space-x-6 flex flex-nowrap overflow-x-scroll">
                    @foreach ($order as $or)
                        @if ($or->isCompleted == '0')
                            @php
                                $prod = Posts::where('id', '=', $or->productId)->first();
                                $user = User::where('email', '=', $or->orderedBy)->first();
                                $agency = Agency::where('email', '=', $or->orderedFrom)->first();
                            @endphp
                            <!-- Ad Item -->
                            <li class="border rounded-lg flex-shrink-0 p-2" style="width: 350px;">
                                <div class="p-4">
                                    <img class="w-full h-48 bg-cover bg-center"
                                        src="{{ asset('posts_pic/' . $prod->pic) }}" alt="productImage" />
                                    <!-- Product Details -->
                                    <h3 class="text-lg font-semibold text-gray-800 mt-2">{{ $prod->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $prod->description }}</p>
                                    <!-- Order Summary -->
                                    <div class="mt-4">
                                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Order Summary</h2>
                                        <div class="flex flex-row">

                                            <div class="mr-8">
                                                <p><strong>Ordered By:<br></strong> {{ $user->name }}</p>
                                                <p><strong>Contact No:<br></strong> {{ $user->contact }}</p>
                                                <p><strong>Ordered From:<br></strong> {{ $agency->name }}</p>
                                                <p><strong>Pick-Up Date:<br></strong> {{ $or->pickUpDate }}</p>
                                                <p><strong>Pick-Up Time:<br></strong> {{ $or->pickUpTime }} </p>
                                            </div>
                                            <div>
                                                <p><strong>Pick-Up Location:<br></strong> {{ $or->pickUpLocation }}
                                                </p>
                                                <p><strong>Drop Date:<br></strong> {{ $or->dropDate }} </p>
                                                <p><strong>Drop Time:<br></strong> {{ $or->dropTime }} </p>
                                                <p><strong>Drop Location:<br></strong> {{ $or->dropLocation }}</p>
                                                <p><strong>Total Price:<br></strong> {{ $or->totalPrice }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($temp2)
                                        <div class="mt-4 flex justify-around">
                                            {{-- <form action="{{ route('delete.order', $or->id) }}" method="POST"> --}}
                                            {{-- @csrf
                                            @method('delete') --}}
                                            <button class="text-indigo-500 hover:underline">Accept</button>
                                            {{-- </form> --}}

                                            <form action="{{ route('delete.order', $or->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="text-red-500 hover:underline">Reject</button>
                                            </form>
                                        </div>
                                    @endif
                                    @if ($temp1)
                                        <div class="mt-4 flex justify-around">
                                            {{-- <form action="{{ route('delete.order', $or->id) }}" method="POST"> --}}
                                            {{-- @csrf
                                        @method('delete') --}}
                                            <button class="text-indigo-500 hover:underline">Edit</button>
                                            {{-- </form> --}}

                                            <form action="{{ route('delete.order', $or->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="text-red-500 hover:underline">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                <div class="mt-6 p-4 rounded-lg flex items-center justify-center h-full w-full">
                    <p class="text-lg font-semibold text-gray-800">No New Requests</p>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
