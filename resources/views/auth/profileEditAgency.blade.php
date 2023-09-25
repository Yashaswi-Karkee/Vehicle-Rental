<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
    @media screen and (max-width: 700px) {
        #main {
            width: 100vw;
        }
    }

    @media screen and (max-width: 1500px) {
        #main {
            width: 70vw;
        }
    }
</style>

<body class="bg-gray-100 font-sans w-screen">
    <div class="min-h-screen flex items-center justify-center">
        <!-- Registration Card -->
        <div class="bg-white p-8 rounded shadow-md w-4/12 mx-4 w-4/12" id="main">
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
                    <label for="name" class="block text-sm font-medium text-gray-600">Agency Name</label>
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
                    <label for="address" class="block text-sm font-medium text-gray-600">Choose Address</label>
                    <input type="number" id="latitude" name="latitude" value="{{ $data1->latitude }}"
                        step="0.00000000000000001">
                    <input type="number" id="longitude" name="longitude" value="{{ $data1->longitude }}"
                        step="0.00000000000000001">
                    <div id="myMap" style="position: relative;width:100%;height:400px;"></div>

                    <span class=" text-red-600">
                        @error('latitude')
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

    function GetMap() {

        var map = new Microsoft.Maps.Map('#myMap', {
            credentials: 'Ami9yJcL6eXX476A77s-16F4ZyLAftc745imSzr9ZWhgNMgv9CcdipqNdAUAJKMH',
            mapTypeId: Microsoft.Maps.MapTypeId.aerial,
            zoom: 15,
        });


        Microsoft.Maps.Events.addHandler(map, 'click', getLatlng);

        function getLatlng(e) {
            if (e.targetType == "map") {
                const lat = document.getElementById('latitude');
                const long = document.getElementById('longitude');
                var point = new Microsoft.Maps.Point(e.getX(), e.getY());
                var locTemp = e.target.tryPixelToLocation(point);
                var location = new Microsoft.Maps.Location(locTemp.latitude, locTemp.longitude);
                lat.value = locTemp.latitude;
                long.value = locTemp.longitude;

                for (var i = map.entities.getLength() - 1; i >= 0; i--) {
                    var pushpin = map.entities.get(i);
                    if (pushpin instanceof Microsoft.Maps.Pushpin) {
                        map.entities.removeAt(i);
                    };
                }

                var pin = new Microsoft.Maps.Pushpin(location, {
                    'draggable': true,
                });
                map.entities.push(pin);
                pin.setOptions({
                    enableHoverStyle: true
                });

                Microsoft.Maps.Events.addHandler(pin, 'dragend', function() {
                    const lat = document.getElementById('latitude');
                    const long = document.getElementById('longitude');
                    var pinLocation = pin.getLocation();
                    lat.val = pinLocation.latitude;
                    long.val = pinLocation.longitude;
                });

            }
        }

    }
</script>
<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' async defer></script>

</html>
