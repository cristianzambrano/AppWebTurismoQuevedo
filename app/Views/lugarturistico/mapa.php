<!DOCTYPE html>
<html>
<head>
    <title>Google Maps with Custom Markers</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEaPJ0Pr1XzIi6fHfTiDdYGhdSit7FM9c"></script>
    <style>
        #map {
            height: 100%;
            width: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

<div id="map"></div>

<script>
    // Lista de lugares con sus datos desde PHP
    
    var defaultLocation = {lat: -1.023, lng: -79.464}; // Quevedo
    let map;
    function initMap() {
       

        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 14,
            styles: [
                {
                    "featureType": "poi",
                    "stylers": [
                        {"visibility": "off"}
                    ]
                },
                {
                    "featureType": "transit",
                    "stylers": [
                        {"visibility": "off"}
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "stylers": [
                        {"visibility": "off"}
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.icon",
                    "stylers": [
                        {"visibility": "off"}
                    ]
                }
            ],
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        
        

        
    }

    function fetchMarkers(location, radio, idc) {
            // Construir la URL con los parámetros
            var url = `lugar_turistico/json_getlistadoMapa?lat=${location.lat}&lng=${location.lng}&radio=${radio}&idc=${idc}`;
            
            
            fetch(url)
            .then(response => response.json())
            .then(data => {
                alert(data);
                clearMarkers();
                addMarkers(data.data);
            })
            .catch(error => console.error('Error:', error));
        }

        // Array para mantener los marcadores actuales
        var markers = [];

        function addMarkers(lugares) {
            lugares.forEach(function(lugar) {
                var marker = new google.maps.Marker({
                    position: {lat: parseFloat(lugar.lat), lng: parseFloat(lugar.lng)},
                    map: map,
                    title: lugar.nombre
                });
                
                var info = '<div><img src="assets/imgs/logos_gifs/' + lugar.logo + '" alt="' + lugar.nombre + '" style="width:250px;height:250px;">';
                info = info + '<br><strong>' + lugar.nombre + '</strong></div>';
                var infowindow = new google.maps.InfoWindow({
                    content: info
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });

                markers.push(marker);
            });
        }

   initMap();

   // Intentar obtener la ubicación del navegador
   if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(userLocation);
                fetchMarkers(userLocation, 1, 0); // Llamar con radio e idc predeterminados
            }, function() {
                fetchMarkers(defaultLocation, 1, 0); // Llamar con radio e idc predeterminados
            });
        } else {
            fetchMarkers(defaultLocation, 1, 0); // Llamar con radio e idc predeterminados
        }

        // Agregar listener para actualizar marcadores al mover el mapa
        map.addListener('idle', function() {
            var center = map.getCenter();
            fetchMarkers({lat: center.lat(), lng: center.lng()}, 1, 0); // Llamar con radio e idc predeterminados
        });


        
   function clearMarkers() {
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];
        }
    
</script>

</body>
</html>
