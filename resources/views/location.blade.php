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

        //Request the user's location
        // navigator.geolocation.getCurrentPosition(function(position) {
        //         var loc = new Microsoft.Maps.Location(
        //             position.coords.latitude,
        //             position.coords.longitude);

        // Add a pushpin at the user's location.
        // var pin = new Microsoft.Maps.Pushpin(loc, {
        //     'draggable': true
        // });
        // map.entities.push(pin);

        //Center the map on the user's location.
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
</body>

</html>
