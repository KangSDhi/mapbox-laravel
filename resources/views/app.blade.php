<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Map</title>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.css" rel="stylesheet" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1Ijoia2FuZ3NkaGkiLCJhIjoiY2xzcHN4djVrMDFxeTJrcWtsanZhZzV0cSJ9.R9Y_doL1yNPTpsLrVfLWqw'

        const map = new mapboxgl.Map({
            container: 'map', // container ID
            // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
            style: 'mapbox://styles/mapbox/satellite-streets-v12', // style URL
            center: [111.862002, -7.152989], // starting position
            zoom: 10 // starting zoom
        });

        function AddLayer(){
            axios.get("/api/map")
                .then(({ data }) => {
                    
                    data.forEach((elm, index) => {

                        const area_map = elm.area_map.coordinates;

                        let flipInnerData = area_map.map(function(outerArray){
                            return outerArray.map(function(innerArray){
                                return [innerArray[1], innerArray[0]];
                            });
                        });

                        map.addSource(elm.nama_map, {
                            'type': 'geojson',
                            'data': {
                                'type': 'Feature',
                                'properties': {
                                    'nama_map': elm.nama_map,
                                },
                                'geometry': {
                                    'type': elm.area_map.type,
                                    'coordinates': flipInnerData
                                }
                            }
                        });

                        // Add a new layer to visualize the polygon.
                        map.addLayer({
                            'id': elm.nama_map+'fill',
                            'type': 'fill',
                            'source': elm.nama_map, // reference the data source
                            'layout': {},
                            'paint': {
                                'fill-color': elm.background_map, // blue color fill
                                'fill-opacity': 0.5
                            }
                        });
                        // Add a black outline around the polygon.
                        map.addLayer({
                            'id': elm.nama_map+'outline',
                            'type': 'line',
                            'source': elm.nama_map,
                            'layout': {},
                            'paint': {
                                'line-color': '#000',
                                'line-width': 3
                            }
                        });

                        map.on('click', elm.nama_map+'fill', (e) => {
                            console.log(e);
                            console.log(e.features[0].properties.nama_map);
                            new mapboxgl.Popup()
                                .setLngLat(e.lngLat)
                                .setHTML(e.features[0].properties.nama_map)
                                .addTo(map);
                        });

                        map.on('mouseenter', elm.nama_map+'fill', () => {
                            map.getCanvas().style.cursor = 'pointer';
                        });

                        map.on('mouseleave', elm.nama_map+'fill', () => {
                            map.getCanvas().style.cursor = '';
                        });

                    });
                })
                .catch((error) => {
                    console.error(error);
                });
        }

    
        map.on('load', () => {
            AddLayer();          
        });
    </script>
</body>
</html>