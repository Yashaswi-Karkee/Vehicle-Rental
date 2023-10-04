<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
</head>
<style>
    @media screen and (max-width: 700px) {
        #main {
            width: 100vw;
        }
    }

    @media screen and (max-width: 1500px) {
        #main {
            width: 60vw;
        }
    }

    /* Close icon styles */
    .close-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: #999;
    }

    .close-icon:hover {
        color: #333;
    }
</style>

<body class="bg-gray-100 font-sans w-screen">
    <div class="min-h-screen flex items-center justify-center">
        <!-- Registration Card -->
        <div class="bg-white p-8 rounded shadow-md w-4/12 mx-4 relative" id="main">
            <!-- Close icon -->
            <a href="{{ route('homepage') }}" class="close-icon"><i class="fas fa-times text-xl"></i></a>
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Register</h2>
            <form action="{{ route('register-Agency') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="image"
                        class="relative rounded-full h-full w-full mb-4 cursor-pointer flex justify-center">
                        <input type="file" id="image" name="image" hidden onchange="displayImage(this)">
                        <div class="bg-gray-300 rounded-full w-32 h-32 flex items-center justify-center">
                            <div class="text-4xl text-gray-600">+</div>
                        </div>
                        <img id="profile-image" src="default-avatar.png" alt="Profile Picture"
                            class="absolute w-32 h-32 rounded-full object-cover opacity-0 transition duration-300">
                    </label>
                    <span class=" text-red-600">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">Agency Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
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
                    <label for="address" class="block text-sm font-medium text-gray-600">Address</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">
                    <label for="contact" class="block text-sm font-medium text-gray-600">Contact Number</label>
                    <input type="number" id="contact" name="contact" value="{{ old('contact') }}"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('contact')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">
                    <label for="pan_number" class="block text-sm font-medium text-gray-600">Pan Number</label>
                    <input type="text" id="pan_number" name="pan_number" value="{{ old('pan_number') }}"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('pan_number')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">
                    <label for="registration_num" class="block text-sm font-medium text-gray-600">Registration
                        Number</label>
                    <input type="text" id="registration_num" name="registration_num"
                        value="{{ old('registration_num') }}"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('registration_num')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                    <input type="password" id="Password" name="password"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Confirm
                        Password</label>
                    <input type="password" id="confirm-password" name="password_confirmation"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                    <span class=" text-red-600">
                        @error('password_confirmation')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">

                    <label for="pan_image" class="block text-sm font-medium text-gray-600 mb-4">PAN CARD</label>

                    <input type="file" id="pan_image" name="pan_image">
                    <span class=" text-red-600">
                        @error('pan_image')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">

                    <label for="registration_image" class="block text-sm font-medium text-gray-600 mb-4">Registration
                        Certificate</label>

                    <input type="file" id="registration_image" name="registration_image">
                    <span class=" text-red-600">
                        @error('registration_image')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-600">Choose Address</label>
                    <input type="number" id="latitude" name="latitude" value="{{ old('latitude') }}"
                        step="0.00000000000000001">
                    <input type="number" id="longitude" name="longitude" value="{{ old('longitude') }}"
                        step="0.00000000000000001">
                    <div id="myMap" style="position: relative;width:100%;height:400px;"></div>

                    <span class=" text-red-600">
                        @error('latitude')
                            {{ $message }}
                        @enderror
                    </span>
                    <p class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2
                        px-4 rounded mt-4 text-center w-3/12 cursor-pointer"
                        onclick="addCoordinates()">
                        Select Address</p>


                </div>
                <div class="mb-4 flex justify-between">
                    <p class="text-sm font-medium text-gray-600 flex justify-center w-full">
                        Registering as User?<a href="{{ route('registrationUser') }}"
                            class="text-indigo-500 hover:underline mx-1">Click
                            here</a></p>

                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition duration-300">Register</button>
                </div>
            </form>
            <p class="text-sm text-gray-600 flex justify-center">Already have an account? <a
                    href="{{ route('login') }}" class="text-indigo-500 hover:underline mx-1">Login here</a></p>
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
                image.style.opacity = 1;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    var lat = document.getElementById('latitude');
    var long = document.getElementById('longitude');
    var lt = lat.value;
    var lg = long.value;

    function GetMap() {

        var map = new Microsoft.Maps.Map('#myMap', {
            credentials: 'Ami9yJcL6eXX476A77s-16F4ZyLAftc745imSzr9ZWhgNMgv9CcdipqNdAUAJKMH',
            mapTypeId: Microsoft.Maps.MapTypeId.aerial,
            zoom: 15,
        });


        navigator.geolocation.getCurrentPosition(function(position) {
            var center = new Microsoft.Maps.Location(
                position.coords.latitude,
                position.coords.longitude
            );
            if (lt == "") {

                lt = center.latitude;
                lg = center.longitude;
            } else {
                center.latitude = lt.value;
                center.longitude = lg.value;
            }
            console.log(lt, lg);
            // Add a pushpin at the user 's location.
            var pin = new Microsoft.Maps.Pushpin(center, {
                'draggable': true
            });
            map.entities.push(pin);
            // Center the map on the user's location.

            map.setView({
                center: center,
                zoom: 15
            });
        });




        Microsoft.Maps.Events.addHandler(map, 'click', getLatlng);

        function getLatlng(e) {
            if (e.targetType == "map") {
                const lat = document.getElementById('latitude');
                const long = document.getElementById('longitude');
                var point = new Microsoft.Maps.Point(e.getX(), e.getY());
                var locTemp = e.target.tryPixelToLocation(point);
                var location = new Microsoft.Maps.Location(locTemp.latitude, locTemp.longitude);
                lt = locTemp.latitude;
                lg = locTemp.longitude;

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
                    var pinLocation = pin.getLocation();
                    lt = pinLocation.latitude;
                    lg = pinLocation.longitude;
                });

            }
        }

    }

    function addCoordinates() {
        lat.value = lt;
        long.value = lg;
    }
</script>
<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' async defer></script>

</html>
