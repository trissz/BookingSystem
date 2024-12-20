document.addEventListener("DOMContentLoaded", function(event) {

    var greenIcon = new L.Icon({
        iconUrl: '/common/cdn/map_images/marker-icon-green.png',
        shadowUrl: '/common/cdn/map_images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    let center = [47.1625, 19.5033];
    const map = L.map("map").setView(center, 7);
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

    

    function generateRandomColor() {
        return '#' + Math.floor(Math.random()*16777215).toString(16);
    }

    let majorColoring = new Map();
    let visitedMajors = new Set();
    let countsByCity = { male: new Map(), female: new Map() };

    /* Optional */

    let customColors = ['#e6194B', '#f032e6', '#3cb44b', '#f58231', '#000075', '#42d4f4', '#ffe119'];
    let customColorIndex = 0;

    // Initialize majors with corresponding colors and count data
    for (let data of mapData) {
        if (!visitedMajors.has(data["major"])) {
            visitedMajors.add(data["major"]);
            //majorColoring.set(data["major"], generateRandomColor());
            majorColoring.set(data["major"], customColors[customColorIndex ++]);
        }

        if (!countsByCity.male.has(data["city"])) {
            countsByCity.male.set(data["city"], 0);
            countsByCity.female.set(data["city"], 0);
        }

        switch (data["gender"]) {
            case "fiú":
                countsByCity.male.set(data["city"], countsByCity.male.get(data["city"]) + 1);
                break;
            case "lány":
                countsByCity.female.set(data["city"], countsByCity.female.get(data["city"]) + 1);
                break;
        }
    }

    function getRelativeRadius(zoomLevel) {
        const baseRadius = 12500;
        return baseRadius / Math.pow(2, zoomLevel - 7);
    }

    function drawCircles() {
        let zoomLevel = map.getZoom();
        let circleRadius = getRelativeRadius(zoomLevel);
        let genderOffset = 0.001;

        universityOfTokajGroup.clearLayers();

        for (let data of mapData) {
            let correspondingCheckbox = document.getElementById(`checkbox-${data["major"]}`);

            if (data["latitude"] && data["longitude"] && correspondingCheckbox && correspondingCheckbox.checked) {
                let circle;
                let maleCount = countsByCity.male.get(data["city"]) || 0;
                let femaleCount = countsByCity.female.get(data["city"]) || 0;

                switch (data["gender"]) {
                    case "fiú":
                        circle = L.circle([data["latitude"], data["longitude"] - genderOffset], {
                            color: 'black',
                            weight: 1,
                            opacity: 0.8,
                            fillColor: majorColoring.get(data["major"]),
                            fillOpacity: 0.8,
                            radius: circleRadius
                        }).addTo(universityOfTokajGroup);

                        circle.bindPopup("Férfiak száma a térségből: " + maleCount);
                        break;
                    case "lány":
                        circle = L.circle([data["latitude"], data["longitude"] + genderOffset], {
                            color: 'black',
                            weight: 1,
                            opacity: 0.6,
                            fillColor: majorColoring.get(data["major"]),
                            fillOpacity: 0.6,
                            radius: circleRadius
                        }).addTo(universityOfTokajGroup);

                        circle.bindPopup("Nők száma a térségből: " + femaleCount);
                        break;
                    default:
                        break;
                }
            }
        }
    }

    function addMajorColoringLegend() {
        let legend = L.control({position: 'bottomright'});
    
        legend.onAdd = function () {
            let div = L.DomUtil.create('div', 'info legend');
            div.innerHTML += '<h4 style="width: 100%; text-align: center">Jelmagyarázat</h4>';
    
            for (let [major, color] of majorColoring) {
                div.innerHTML += `
                    <div class="legend-item">
                        <span style="display: inline-block; width: 1.5em; height: 1.5em; background-color: ${color}; opacity: 0.8; margin-right: 0.1em;"></span>
                        <span style="display: inline-block; width: 1.5em; height: 1.5em; background-color: ${color}; opacity: 0.6; margin-right: 0.3em;"></span>
                        ${major}
                        <span class="major_checkbox">
                            <input type="checkbox" id="checkbox-${major}" name="${major}" checked />
                        </span>
                    </div>
                `;
            }
    
            return div;
        };
    
        legend.addTo(map);
    }

    addMajorColoringLegend();

    mapData.forEach(data => {
        const checkbox = document.getElementById(`checkbox-${data["major"]}`);
        if (checkbox) {
            checkbox.addEventListener('change', drawCircles);
        }
    });
    
    drawCircles();

    map.on('zoomend', function() {
        drawCircles();
    });


    document.getElementById('save_leaflet_map').addEventListener('click', function() {
        saveLeafletMapAsImage();
    });

    function saveLeafletMapAsImage() {
        leafletImage(map, function(err, canvas) {
            if (err) {
                console.error(err);
                return;
            }
    
            let zoomLevel = map.getZoom();
            let mapSize = {width: map.getSize().x, height: map.getSize().y};
            let circleRadius = getRelativeRadius(zoomLevel) / Math.max(mapSize.width, mapSize.height);
    
            universityOfTokajGroup.eachLayer(function(layer) {
                if (layer instanceof L.Circle) {
                    const ctx = canvas.getContext('2d');
                    const point = map.latLngToContainerPoint(layer.getLatLng());
    
                    ctx.beginPath();
                    ctx.arc(point.x, point.y, circleRadius, 0, 2 * Math.PI, false);
                    ctx.fillStyle = layer.options.fillColor;
                    ctx.fill();
                    ctx.lineWidth = layer.options.weight;
                    ctx.strokeStyle = layer.options.color;
                    ctx.stroke();
                }
            });
    
            // Convert the canvas to a data URL
            var imgData = canvas.toDataURL('image/png');
    
            // Create a link to download the image
            var link = document.createElement('a');
            link.href = imgData;
            link.download = 'students_dormitory_map.png';
    
            // Trigger the download
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    }    


});


