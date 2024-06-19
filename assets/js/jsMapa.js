
function initMap() {
    map = new google.maps.Map(document.getElementById('divMapa'), {
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

function addMarkers(lugares) {
  
    lugares.forEach(function(lugar) {
        var marker = new google.maps.Marker({
            position: {lat: parseFloat(lugar.lat), lng: parseFloat(lugar.lng)},
            map: map,
            icon: {
                url: 'assets/icons/' + lugar.subcategoria_id + '.png',
                scaledSize: new google.maps.Size(35, 35), 
                origin: new google.maps.Point(0, 0), 
                anchor: new google.maps.Point(15, 15) 
            },
            title: 'Categoría: ' + lugar.categoria + '\nSubCategoría: ' + lugar.subcategoria + '\n' + lugar.nombre
        });

        marker.addListener('click', function() {
            ajaxShowLugarTuristicoModal(lugar.id, lugar.nombre);
        });

        markers.push(marker);
    
      });

}



function clearMarkers(markers) {
    markers.forEach(function(marker) {
            marker.setMap(null);
      });
      markers= [];
}

function fetchMarkers(location) {
    
    var idc=0, idsc=0, radio=0.1;
    if($("#regCategoria").val()>0)      idc = $("#regCategoria").val(); 
    if($("#regSubCategoria").val()>0)   idsc = $("#regSubCategoria").val();
    if($("#radioSlider").val()>0.1)     radio = $("#radioSlider").val();
  
    var url = `lugar_turistico/json_getlistadoMapa?lat=${location.lat}&lng=${location.lng}&radio=${radio}&idc=${idc}&idsc=${idsc}`;
      

    fetch(url)
    .then(response => response.json())
    .then(data => {
        clearMarkers(markers);
        addMarkers(data.data);
    })
    .catch(error => console.error('Error:', error));
}


function createCircle(center, radius) {
    return new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: center,
        radius: radius * 1000, 
    });
 }

 // Función para togglear el círculo
function toggleCircle() {
    if (circleActive) {
        circle.setMap(null);
        circle = null;
        circleActive = false;
        $('#btCirculo').removeClass('btn-secondary').addClass('btn-primary').text('Mostrar');
    } else {
        const center = map.getCenter();
        const radius = parseFloat(document.getElementById('radioSlider').value); // Obtener el valor del radio del slider
        circle = createCircle(center, radius);
        circleActive = true;
        $('#btCirculo').removeClass('btn-primary').addClass('btn-secondary').text('Ocultar');
    }
}