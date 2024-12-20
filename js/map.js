document.addEventListener("DOMContentLoaded", function(event) {

    var greenIcon = new L.Icon({
        iconUrl: '/common/cdn/map_images/marker-icon-green.png',
        shadowUrl: '/common/cdn/map_images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    let center = [48.32136917139583, 21.56666973293446];
    const map = L.map("map").setView(center, 17);
    const universityOfTokajGroup = new L.FeatureGroup().addTo(map);


    let OpenStreetMap = L.tileLayer(
        'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 18,
            attribution: '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }
    ).addTo(map);
    L.control.layers(
        {
            'OSM': OpenStreetMap,
            'Google': L.tileLayer(
                'http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}',
                {
                    attribution: 'Google'
                }
            )
        },
        {
            'University of Tokaj': universityOfTokajGroup
        },
        {
            position: 'topleft',
            collapsed: false
        }
    ).addTo(map);


    // Loop through each object in the data array
    mapData.forEach(function(pin) {
        if (pin.title === 'University of Tokaj') {
            L.marker([pin.latitude, pin.longitude], {icon: greenIcon}).addTo(map)
                .bindPopup(`
                    <strong>${pin.title}</strong><br>
                    ${pin.popup_html}
                `)
                .openPopup();
        }
        else {
            var marker = L.marker(
                [
                    pin.latitude,
                    pin.longitude
                ],
                {icon: greenIcon}
            );
            marker.bindPopup(`
                <strong>${pin.title}</strong><br>
                ${pin.popup_html}
            `)
            universityOfTokajGroup.addLayer(marker);
        }
        
    });





    map.on('click', onMapClick);


    function onMapClick(e) {
        document.getElementById('map_log').innerHTML += 'Click at: ' + e.latlng + '<br/>';
    }

});