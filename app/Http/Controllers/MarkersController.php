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

        $markersDataBase = Marker::all();

        // Adiciona os marcadores do banco de dados ao mapa
        foreach ($markersDataBase as $marker) {
            app('map')->add_marker(array(
                'position' => $marker->lat.','.$marker->long,
                'title' => $marker->title, 
                'infowindow_content' => $marker->content 
            ));
        }

        // Cria o mapa
        $map = app('map')->create_map();

        // Retorna a visualização do mapa com os marcadores
        return view('map', compact('map'));

    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
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

        $marker = array();
        app('map')->add_marker($marker);
    
        $map = app('map')->create_map();
    
        return view('map', compact('map'));
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
        //
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
