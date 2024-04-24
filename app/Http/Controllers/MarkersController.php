<?php

namespace App\Http\Controllers;
use App\Models\Marker;

use Illuminate\Http\Request;

class MarkersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $config = array();
        $config['center'] = 'auto';
    
        $config['onboundschanged'] = 'if (!centreGot) {
                var mapCentre = map.getCenter();
                marker_0.setOptions({
                    position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
                });
            }
            centreGot = true;';        

        app('map')->initialize($config);

        try {                       
            $markersDataBase = Marker::all();
            // Adiciona os marcadores do banco de dados ao mapa
            foreach ($markersDataBase as $marker) {
                app('map')->add_marker(array(
                    'position' => $marker->lat.','.$marker->long,
                    'title' => $marker->title, 
                    'infowindow_content' => $marker->content
                    //'icon' => 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png'
                    //'label_color' => 'blue'
                ));
            }
            $conexaoDatabase = true;
        } catch (\Exception $e) {
            app('map')->initialize($config);
            // set up the marker ready for positioning
            // once we know the users location
            $marker = array();
            app('map')->add_marker($marker);       
            $conexaoDatabase = false;
        }
                
        // Cria o mapa
        $map = app('map')->create_map();

        // Retorna a visualização do mapa com os marcadores
        return view('map', compact('map', 'conexaoDatabase'));

    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {  
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /*

        let map;

        function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(-33.91722, 151.23064),
            zoom: 16,
        });

        const iconBase =
            "https://developers.google.com/maps/documentation/javascript/examples/full/images/";
        const icons = {
            parking: {
            icon: iconBase + "parking_lot_maps.png",
            },
            library: {
            icon: iconBase + "library_maps.png",
            },
            info: {
            icon: iconBase + "info-i_maps.png",
            },
        };
        const features = [
            {
            position: new google.maps.LatLng(-33.91721, 151.2263),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.91539, 151.2282),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.91747, 151.22912),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.9191, 151.22907),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.91725, 151.23011),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.91872, 151.23089),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.91784, 151.23094),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.91682, 151.23149),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.9179, 151.23463),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.91666, 151.23468),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.916988, 151.23364),
            type: "info",
            },
            {
            position: new google.maps.LatLng(-33.91662347903106, 151.22879464019775),
            type: "parking",
            },
            {
            position: new google.maps.LatLng(-33.916365282092855, 151.22937399734496),
            type: "parking",
            },
            {
            position: new google.maps.LatLng(-33.91665018901448, 151.2282474695587),
            type: "parking",
            },
            {
            position: new google.maps.LatLng(-33.919543720969806, 151.23112279762267),
            type: "parking",
            },
            {
            position: new google.maps.LatLng(-33.91608037421864, 151.23288232673644),
            type: "parking",
            },
            {
            position: new google.maps.LatLng(-33.91851096391805, 151.2344058214569),
            type: "parking",
            },
            {
            position: new google.maps.LatLng(-33.91818154739766, 151.2346203981781),
            type: "parking",
            },
            {
            position: new google.maps.LatLng(-33.91727341958453, 151.23348314155578),
            type: "library",
            },
        ];

        // Create markers.
        for (let i = 0; i < features.length; i++) {
            const marker = new google.maps.Marker({
            position: features[i].position,
            icon: icons[features[i].type].icon,
            map: map,
            });
        }
        }

        window.initMap = initMap;

        */
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
