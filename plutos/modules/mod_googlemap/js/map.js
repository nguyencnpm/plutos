function initialize(gmap_m_ids) {
    gmap_m_ids.forEach(function (gmap_m_id, i, arr) {
        var c_lat = cords[gmap_m_id].lat[0],
                c_lng = cords[gmap_m_id].lng[0],
                length = cords[gmap_m_id].lat.length;
        if (length > 1)
        {
            var max_lat = cords[gmap_m_id].lat[0],
                    max_lng = cords[gmap_m_id].lng[0],
                    min_lat = cords[gmap_m_id].lat[0],
                    min_lng = cords[gmap_m_id].lng[0];
            for (var i = 1; i < length; i++) {
                max_lat = (cords[gmap_m_id].lat[i] > max_lat) ? cords[gmap_m_id].lat[i] : max_lat;
                max_lng = (cords[gmap_m_id].lng[i] > max_lng) ? cords[gmap_m_id].lng[i] : max_lng;
                min_lat = (cords[gmap_m_id].lat[i] < min_lat) ? cords[gmap_m_id].lat[i] : min_lat;
                min_lng = (cords[gmap_m_id].lng[i] < min_lng) ? cords[gmap_m_id].lng[i] : min_lng;
            }
            c_lat = parseFloat(min_lat) + parseFloat((max_lat - min_lat) / 2);
            c_lng = parseFloat(min_lng) + parseFloat((max_lng - min_lng) / 2);
        }
        var mapOptions = {
            center: new google.maps.LatLng(c_lat, c_lng),
            zoom: zoom[gmap_m_id],
            scrollwheel: false,
            mapTypeId: mapType[gmap_m_id]
        };
        var map = new google.maps.Map(document.getElementById('map-canvas' + gmap_m_id),
                mapOptions);
        var bounds = new google.maps.LatLngBounds();
        var infowindow = new google.maps.InfoWindow({
            content: 'empty'
        });
        for (var i = 0; i < length; i++) {
            var myLatlng = new google.maps.LatLng(cords[gmap_m_id].lat[i], cords[gmap_m_id].lng[i]);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                id: i,
                content: cords[gmap_m_id].info[i],
                icon: cords[gmap_m_id].icon[i]
            });
            google.maps.event.addListener(marker, 'click', function () {
                infowindow.setContent(this.content);
                infowindow.open(map, this);
            });
        }
    });
}
google.maps.event.addDomListener(window, 'load', function () {
    initialize(gmap_module_ids);
});