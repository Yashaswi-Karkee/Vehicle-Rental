@php
    use App\Models\Agency;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<style>
    /* Additional CSS styles */
    .filter-options {
        display: none;
        background-color: white;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: absolute;
        z-index: 999;

        width: 150px;
    }
</style>

<body class="bg-gray-100 font-sans">
    <!-- Top Navigation Bar -->

    <nav class="bg-white shadow-md p-4">
        <div class="flex justify-between items-center">

            <!-- Brand Logo -->
            <a href="{{ route('homepage') }}" class="ml-8">
                <img src="{{ asset('Logo/ORVS.png') }}" alt="Logo" style="width: 70px">
            </a>
            {{-- <a href="{{ route('homepage') }}" class="text-2xl font-semibold text-gray-800">Dashboard</a> --}}

            @if ($data != null)
                <!-- User Avatar and Dropdown -->
                <div class="relative inline-block text-left">
                    <div class="flex flex-row items-center gap-4 mr-8">
                        <button type="button" class="focus:outline-none" id="avatarButton">
                            @if ($data->latitude)
                                <img src="{{ asset('profile_pictures/' . $data->profile_pic) }}" alt="User Avatar"
                                    class="w-12 h-12 rounded-full border">
                            @else
                                <img src="{{ asset('profile_pictures/' . $data->profile_pic) }}" alt="User Avatar"
                                    class="w-12 h-12 rounded-full border">
                            @endif
                        </button>
                        <p class="text-md text-indigo-600">{{ $data->name }}</p>
                        <a href="{{ route('show.notification') }}">
                            @if (!$notification->isEmpty())
                                @foreach ($notification as $noti)
                                    @if ($noti->isRead == 0)
                                        @php
                                            $count = 1;
                                            break;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($count == 1)
                                    <div id="notificationIcon" class="relative cursor-pointer">
                                        <i class="fas fa-bell text-indigo-600 text-2xl"></i>
                                        <div class="absolute h-3 w-3 bg-red-500 rounded-full top-0 right-0"></div>
                                    </div>
                                @else
                                    <div id="notificationIcon" class="relative cursor-pointer">
                                        <i class="fas fa-bell text-indigo-600 text-2xl"></i>
                                    </div>
                                @endif
                            @else
                                <div id="notificationIcon" class="relative cursor-pointer">
                                    <i class="fas fa-bell text-indigo-600 text-2xl"></i>
                                </div>
                            @endif
                        </a>

                    </div>
                    <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                        style="display: none; z-index:10" id="options">
                        <div class="py-1">
                            @if ($data->latitude)
                                <a href="{{ route('user.profile.show', $data->email) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Profile</a>
                                <a href="{{ route('show.requests') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Order Requests</a>
                            @else
                                <a href="{{ route('show.requests') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">My
                                    Requests</a>
                            @endif
                            <a href="{{ route('show.pending.order') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Pending
                                Delivery</a>
                            <a href="{{ route('show.order.history') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Order History</a>
                            <a href="{{ route('settings') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Settings</a>


                            <a href="{{ route('logout') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Logout</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="space-x-4">

                    <a href="{{ route('login') }}"
                        class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4 transition duration-300">Login</a>
                    <a href="{{ route('registrationUser') }}"
                        class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4 transition duration-300">Register</a>

                </div>
            @endif

        </div>
    </nav>

    <!-- Main Content -->
    <main class="p-12 grid grid-cols-1 justify-between min-h-screen">

        <!-- Content -->
        <div class="bg-white shadow-md rounded-lg p-12">
            <!-- Search Bar -->
            <div class="mb-1 w-full flex flex-col justify-end">

                <form action="{{ route('search') }}" method="POST">
                    <div class="flex justify-end space-x-4 w-full">
                        @csrf
                        <!-- Vehicle Type Dropdown -->
                        <input type="text" name="query"
                            class=" py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none"
                            placeholder="Search">
                        <div class="relative">
                            <select
                                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:ring"
                                id="vehicleType" name="vehicleType">
                                <option value="all">All</option>
                                <option value="Cycle">Cycle</option>
                                <option value="2WD">Two-Wheeler</option>
                                <option value="4WD">Four-Wheeler</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <!-- Search Button -->

                        <button
                            class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4">
                            Search
                        </button>
                        <!-- Filter Button -->
                        {{-- <button onclick="toggleFilterOptions()"
                        class="bg-indigo-500 text-white hover:bg-indigo-600 transition duration-300 rounded-full py-2 px-4"
                        id="filterButton">Filter<i class="fas fa-filter ml-2"></i>
                    </button> --}}
                    </div>
                </form>
            </div>

            <!-- Filter Options (Initially Hidden) -->
            {{-- <div class="flex justify-end w-full">
                <div class="filter-options pt-4 pl-4" id="filterOptions">
                    <!-- Add your filter options here as anchor tags -->
                    <a class="block mb-2">Nearest first</a>
                    <a href="#" class="block mb-2">Option 2</a>
                    <!-- Add more filter options as needed -->
                </div>
            </div> --}}



            <!-- Posts Section -->
            <div class="mt-7 p-4 flex justify-center flex-wrap">
                @if ($temp == 1)

                    <!-- If No Posts Found -->
                    <p class="text-gray-600 mb-4">No posts found.</p>
                    {{-- <p class="text-gray-600 mb-4">{{ $lat }}</p> --}}
                @else
                    @foreach ($post as $p)
                        @php
                            $user = Agency::where('email', '=', $p->agencyEmail)->first();
                        @endphp
                        <!-- Sample Post -->
                        <div class="m-2 bg-white rounded-lg shadow-md p-4 border w-full" style="width: 350px">
                            <img src="{{ asset('posts_pic/' . $p->pic) }}" alt="Post Image"
                                class="w-full h-40 object-cover rounded-t-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $p->title }}</h3>
                                <p class="text-gray-600 mb-2">
                                    {{ $p->description }}
                                </p>
                                <p class="text-gray-600 mb-2">
                                    @if ($p->type == 'Cycle')
                                        <i class="fas fa-bicycle text-indigo-500 mr-2"></i>Cycle
                                    @elseif ($p->type == '2WD')
                                        <i class="fas fa-motorcycle text-indigo-500 mr-2"></i>2 Wheeler
                                    @else
                                        <i class="fas fa-car text-indigo-500 mr-2"></i>4 Wheeler
                                    @endif
                                </p>
                                <p class="text-gray-600 mb-2">
                                    <i class="fas fa-dollar-sign text-indigo-500 mr-2"></i>Rs
                                    {{ $p->rate }}/day
                                </p>
                                <p class="text-gray-600 mb-4">
                                    <i class="fas fa-cubes text-indigo-500 mr-2"></i>Available:
                                    {{ $p->quantity }}
                                </p>
                                <div class="flex flex-col mt-4 gap-2">
                                    <a href="{{ route('user.profile.show', $p->agencyEmail) }}"
                                        class="text-blue-600 hover:underline">
                                        <i class="fas fa-user text-indigo-500 mr-2"></i>{{ $user->name }}
                                    </a>
                                    <a href="tel:{{ $user->contact }}" class="text-blue-600 hover:underline">
                                        <i class="fas fa-phone text-indigo-500 mr-2"></i>{{ $user->contact }}
                                    </a>
                                    <a href="mailto:{{ $p->agencyEmail }}" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>{{ $user->email }}
                                    </a>
                                    <a href="https://www.google.com/maps?q={{ $p->latitude }},{{ $p->longitude }}"
                                        class="text-blue-600 hover:underline" class="text-gray-600 mb-8 mt-2">
                                        <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>{{ $user->address }}
                                    </a>
                                </div>
                                @if (!Session::has('loginEmail'))
                                    <div class="flex justify-between">
                                        <a href="{{ route('login') }}"
                                            class="bg-indigo-500 text-white w-6/12 text-center hover:bg-indigo-600 transition duration-300 rounded-full py-2 mr-4 mt-8">
                                            Order
                                        </a>
                                        <a href="{{ route('login') }}"
                                            class="bg-indigo-500 text-white w-6/12 text-center hover:bg-indigo-600 transition duration-300 rounded-full py-2 mt-8">
                                            View Reviews
                                        </a>
                                    </div>
                                @else
                                    <div class="flex justify-between">
                                        <a href="{{ route('order.get', [$p->id, Session::get('loginEmail'), $p->agencyEmail]) }}"
                                            class="bg-indigo-500 text-white w-5/12 text-center hover:bg-indigo-600 transition duration-300 rounded-full py-2 mt-8 mr-4">
                                            Order
                                        </a>
                                        <a href="{{ route('post.description', $p->id) }}"
                                            class="bg-indigo-500 text-white w-5/12 text-center hover:bg-indigo-600 transition duration-300 rounded-full py-2 mt-8">
                                            View Reviews
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-gray-500 text-white w-screen flex flex-col">
        <div class="w-full flex flex-row">
            <div class="w-1/2 flex justify-center">
                <img src="{{ asset('Logo/LogoGray.png') }}" alt="Logo" style="width: 200px; height:170px;">
            </div>
            <div class="w-1/2 p-4">
                <p class="text-lg mb-4">Contact Us:</p>

                <div class="text-md">
                    <a href="mailto:hello@example.com" class="hover:underline">
                        <i class="fas fa-envelope mr-2"></i> yashaswi.karkee007@gmail.com
                    </a>
                </div>
                <div class="text-md">
                    <a href="tel:9812345678" class="hover:underline">
                        <i class="fas fa-phone mr-2"></i> 9803546282
                    </a>
                </div>
                <div class="text-md">
                    <a href="https://www.google.com/maps?q=27.7307544,85.3468015" class="hover:underline">
                        <i class="fas fa-map-marker-alt mr-2"></i> Sukedhara, Kathmandu
                    </a>
                </div>
            </div>
        </div>
        <div class="w-full flex justify-center items-center py-2 bg-gray-600">
            <p class="text-sm">&copy; 2023 Online Vehicle Rental System</p>
        </div>
        {{-- <div class="text-center w-full">
            <div class="border p-4 w-full">
                <p class="text-lg">Contact Us:</p>

                <div class="flex items-center justify-center text-md">
                    <a href="mailto:hello@example.com" class="hover:underline">
                        <i class="fas fa-envelope mr-2"></i> hello@example.com
                    </a>
                </div>
                <div class="flex items-center justify-center text-md">
                    <a href="tel:9812345678" class="hover:underline">
                        <i class="fas fa-phone mr-2"></i> 9812345678
                    </a>
                </div>
                <div class="flex items-center justify-center text-md">
                    <a href="https://www.google.com/maps?q=27.7307544,85.3468015" class="hover:underline">
                        <i class="fas fa-map-marker-alt mr-2"></i> Sukedhara, Kathmandu
                    </a>
                </div>
            </div>
            <div class="border bg-gray-600 w-full">
                <p class="text-sm mt-4">&copy; 2023 Online Vehicle Rental System</p>
            </div>
        </div> --}}
    </footer>

</body>
<script type="text/javascript">
    const avtButton = document.querySelector("#avatarButton");
    const menu = document.querySelector('#options');
    var lat = document.getElementById('latitude');
    var long = document.getElementById('longitude');

    function GetMap() {

        navigator.geolocation.getCurrentPosition(function(position) {
            var center = new Microsoft.Maps.Location(
                position.coords.latitude,
                position.coords.longitude
            );

            lat.value = center.latitude;
            long.value = center.longitude;
            console.log(lat.value)
        });
    }

    function showMenu() {
        if (menu.style.display === "none") {
            menu.style.display = "block";
        } else {
            menu.style.display = "none";
        }
    }

    // function navigateToNearestFilter() {
    //     const latitude = lat.value;
    //     const longitude = long.value;
    //     const url = `/lat=${lat.value}&long=${long.value}`;
    //     window.location.href = url;
    // }

    function toggleFilterOptions() {
        const filterOpt = document.querySelector("#filterOptions");
        if (filterOpt.style.display === "block") {
            filterOpt.style.display = "none";
        } else {
            filterOpt.style.display = "block";
        }
    }

    avtButton.addEventListener("click", showMenu);
</script>
<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' async defer></script>

</html>
