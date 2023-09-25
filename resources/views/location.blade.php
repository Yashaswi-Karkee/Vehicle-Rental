<html>

<head>
    <title></title>
    <meta charset="utf-8" />
    <script type='text/javascript'>
        function GetMap() {
            var map = new Microsoft.Maps.Map('#myMap', {
                credentials: 'Ami9yJcL6eXX476A77s-16F4ZyLAftc745imSzr9ZWhgNMgv9CcdipqNdAUAJKMH',
                mapTypeId: Microsoft.Maps.MapTypeId.aerial,
                zoom: 15,
            });


            Microsoft.Maps.Events.addHandler(map, 'click', getLatlng);

            function getLatlng(e) {
                if (e.targetType == "map") {
                    var point = new Microsoft.Maps.Point(e.getX(), e.getY());
                    var locTemp = e.target.tryPixelToLocation(point);
                    var location = new Microsoft.Maps.Location(locTemp.latitude, locTemp.longitude);
                    console.log(location);

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
                        let pinLocation = pin.getLocation();
                        console.log(pinLocation);
                    });

                }
            }
        }


        // Request the user's location
        // navigator.geolocation.getCurrentPosition(function(position) {
        //         var loc = new Microsoft.Maps.Location(
        //             position.coords.latitude,
        //             position.coords.longitude);

        // Add a pushpin at the user's location.
        // var pin = new Microsoft.Maps.Pushpin(loc, {
        //     'draggable': true
        // });
        // map.entities.push(pin);

        // Center the map on the user's location.
        // map.setView({
        //     center: loc,
        //     zoom: 15
        // });


        // });
    </script>
    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' async defer></script>
</head>

<body>
    <div id="myMap" style="position:relative;width:600px;height:400px;"></div>
    <!-- Ride Search Container -->
    <div class="min-h-screen flex items-center justify-center pb-4">
        <div class="bg-white p-8 rounded shadow-md w-96 mx-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Search for a Ride</h2>
            <!-- Pickup Location -->
            <div class="mb-4 relative">
                <label for="pickup" class="block text-sm font-medium text-gray-600">Pickup Location</label>
                <input type="text" id="pickup" name="pickup" placeholder="Kathmandu"
                    class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none"
                    autocomplete="off">
                <div id="pickup-suggestions"
                    class="absolute z-10 mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                </div>
            </div>

            <!-- Pickup Date and Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="pickup-date" class="block text-sm font-medium text-gray-600">Pickup Date</label>
                    <input type="date" id="pickup-date" name="pickup-date"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label for="pickup-time" class="block text-sm font-medium text-gray-600">Pickup Time</label>
                    <input type="time" id="pickup-time" name="pickup-time"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
            </div>

            <!-- Drop Location -->
            <div class="mb-4 relative">
                <label for="drop" class="block text-sm font-medium text-gray-600">Drop Location</label>
                <input type="text" id="drop" name="drop" placeholder="Pokhara"
                    class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none"
                    autocomplete="off">
                <div id="drop-suggestions"
                    class="absolute z-10 mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                </div>
            </div>

            <!-- Drop Date and Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="drop-date" class="block text-sm font-medium text-gray-600">Drop Date</label>
                    <input type="date" id="drop-date" name="drop-date"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label for="drop-time" class="block text-sm font-medium text-gray-600">Drop Time</label>
                    <input type="time" id="drop-time" name="drop-time"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>
            </div>

            <!-- Vehicle Type Dropdown -->
            <div class="mb-4">
                <label for="vehicle-type" class="block text-sm font-medium text-gray-600">Vehicle Type</label>
                <div class="relative">
                    <select id="vehicle-type" name="vehicle-type"
                        class="w-full py-2 px-4 border rounded-md focus:ring focus:ring-indigo-300 focus:outline-none appearance-none cursor-pointer">
                        <option value="cycle">Cycle</option>
                        <option value="2wheeler">2 Wheeler</option>
                        <option value="4wheeler">4 Wheeler</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                        <!-- Placeholder Icon (you can replace with actual icons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Search Button -->
            <div class="mb-4">
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition duration-300">Search
                    Ride</button>
            </div>
        </div>
    </div>
</body>

</html>
