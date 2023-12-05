@php
    use App\Models\User;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <style>
        .star-rating {
            color: #FFD700;
            /* Gold color for stars */
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg max-w-screen-xl w-full flex items-center">
            <!-- Close Button -->
            <a href="{{ route('homepage') }}" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
                <i class="fas fa-times text-xl"></i>
            </a>
            @if (Session::has('success'))
                <div role="alert"
                    class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 rounded">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('fail'))
                <div role="alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ Session::get('fail') }}
                </div>
            @endif

            <!-- Product Information -->
            <div class="w-full md:w-1/2 p-4">
                <img src="{{ asset('posts_pic/' . $p->pic) }}" alt="Product Image" class="w-full h-auto rounded-lg">
            </div>
            <div class="w-full md:w-1/2 p-4">
                <h1 class="text-3xl font-semibold text-gray-800 mb-4">{{ $p->title }}</h1>
                <p class="text-gray-600 mb-4">{{ $p->description }}</p>
                <p class="text-gray-600 mb-4">
                    @if ($p->type == 'Cycle')
                        <i class="fas fa-bicycle text-indigo-500 mr-2"></i>Cycle
                    @elseif ($p->type == '2WD')
                        <i class="fas fa-motorcycle text-indigo-500 mr-2"></i>2 Wheeler
                    @else
                        <i class="fas fa-car text-indigo-500 mr-2"></i>4 Wheeler
                    @endif
                </p>
                <p class="text-gray-600 mb-4">
                    <i class="fas fa-dollar-sign text-indigo-500 mr-2"></i>Rs {{ $p->rate }}/day
                </p>
                <p class="text-gray-600 mb-4">
                    <i class="fas fa-cubes text-indigo-500 mr-2"></i>Available: {{ $p->quantity }}
                </p>
                <div class="mt-4 flex flex-col gap-4">
                    <a href="{{ route('user.profile.show', $p->agencyEmail) }}" class="text-blue-600 hover:underline">
                        <i class="fas fa-user text-indigo-500 mr-2"></i>{{ $user->name }}
                    </a>
                    <p class="text-blue-600 hover:underline">
                        <i class="fas fa-phone text-indigo-500 mr-2"></i>{{ $user->contact }}
                    </p>
                    <a href="mailto:{{ $p->agencyEmail }}" target="_blank" class="text-blue-600 hover:underline ">
                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>{{ $user->email }}
                    </a>
                    <a href="https://www.google.com/maps?q={{ $p->latitude }},{{ $p->longitude }}"
                        class="text-blue-600 hover:underline">
                        <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>{{ $user->address }}
                    </a>
                </div>
            </div>

            <!-- Product Reviews -->
            <div class="w-full md:w-1/2 p-4">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 overflow-y-auto">Product Reviews</h2>

                {{-- <!-- Average Star Rating -->
                @if ($reviews != null)
                    <div class="bg-gray-100 rounded-lg p-4 mb-4">
                        <div class="flex items-center mb-2">
                            <!-- Display Average Rating Stars -->
                            <div class="flex items-center mr-2">
                                @for ($i = 0; $i < round($averageRating); $i++)
                                    <div class="star-rating text-yellow-500 mr-1">
                                        <i class="fas fa-star"></i>
                                    </div>
                                @endfor
                                @for ($i = round($averageRating); $i < 5; $i++)
                                    <div class="star-rating text-gray-400">
                                        <i class="fas fa-star"></i>
                                    </div>
                                @endfor
                            </div>
                            <p class="text-gray-600 text-sm">Average Rating
                                ({{ round($averageRating, 1) }})({{ $totalReviews }} reviews)</p>
                        </div>
                    </div>
                @endif --}}
                <!-- Review Card -->
                @if ($reviews != null)
                    @foreach ($reviews as $rev)
                        @php
                            // $totalStars = 0;
                            // $totalReviews = count($reviews);
                            $us = User::where('id', $rev->UserID)->first();
                        @endphp
                        <div class="bg-gray-100 rounded-lg p-4 mb-4">
                            <div class="flex items-center mb-2">
                                <!-- Display Rating Stars -->
                                <div class="flex items-center mr-2">
                                    @for ($i = 0; $i < $rev->rating; $i++)
                                        <div class="star-rating text-yellow-500 mr-1">
                                            <i class="fas fa-star"></i>
                                        </div>
                                    @endfor
                                    @for ($i = $rev->rating; $i < 5; $i++)
                                        <div class="star-rating text-gray-400">
                                            <i class="fas fa-star text-gray-200"></i>
                                        </div>
                                    @endfor
                                </div>
                                <p class="text-gray-600 text-sm">({{ $rev->rating }}) </p>
                            </div>
                            <p class="text-gray-800 mb-4">"{{ $rev->description }}"
                            </p>
                            <p class="text-gray-600 text-sm">Posted by {{ $us->name }} on
                                {{ date('M d, Y', strtotime($rev->created_at)) }}
                            </p>
                        </div>
                    @endforeach
                @else
                    <div class="bg-gray-100 rounded-lg p-4 mb-4">
                        <p class="text-gray-600 text-md">No reviews yet.</p>
                    </div>
                @endif


            </div>
        </div>
    </div>
</body>

</html>
