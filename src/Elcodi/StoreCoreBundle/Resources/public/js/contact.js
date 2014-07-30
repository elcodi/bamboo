$(document).ready(function() {

	var yourStartLatLng = new google.maps.LatLng(51.5112, -0.1198);
	$('#map_canvas').gmap({'center': yourStartLatLng});
	$('#map_canvas').gmap('option', 'zoom', 14);
	$('#map_canvas').gmap('addMarker', { /*id:'m_1',*/ 'position': '51.5112, -0.1198', 'bounds': false } ).click(function() {
                $('#map_canvas').gmap('openInfoWindow', { 'content': 'Your Office Location' }, this);
        });
	
});