<?php
if (!isset($typemarker)) { $typemarker = 'site'; }
list($markers_data, $boundaries) = mapmarkers($sites, $typemarker);
if (isset($map_other_data)) {
    $map_other_data_json = json_encode($map_other_data);
} else {
    $map_other_data_json = json_encode(['url_begin'=>"", 'url_end'=>""]);
}
echo "<div id='map' style='display:block'></div>";
?>
<script>
const markers = <?php echo json_encode($markers_data); ?>;
const boundaries = <?php echo json_encode($boundaries); ?>;
const map_other_data = <?php echo $map_other_data_json; ?>;
// Calculez le centre
var latCenter = (boundaries[0][0] + boundaries[1][0]) / 2;
var lngCenter = (boundaries[0][1] + boundaries[1][1]) / 2;
var center = [latCenter, lngCenter];
// Définissez le niveau de zoom (vous pouvez ajuster ce niveau)
var zoomLevel = 10;
// Utilisez setView avec le centre et le niveau de zoom
const map = L.map('map').setView(center, zoomLevel);
const layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// Ajouter un group de clusters
var markersCluster = L.markerClusterGroup();

markers.forEach((m) => {
    if (m.lat && m.long) {
        var marker = L.marker([m.lat, m.long])//.addTo(map);
        var popup = "";
        m.sites.forEach((s) => {
            let url = '<a href="' + s.url + '" target="_blank">' + s.name + "</a>";
            if ("count" in s) {
                url += ' : ';
                url += s.count;
                // For that : see in type.php
                if (map_other_data.url_begin.length > 0) {
                    url += ' (' + map_other_data.url_begin + s.id + map_other_data.url_end + ')';
                }
            }
            popup += url;
            popup += "<br>";
        })
        marker.bindPopup(popup);

        // Ajout au cluster (au lieu de la carte)
        markersCluster.addLayer(marker);
    }
});

// Ajoute le cluster à la carte
map.addLayer(markersCluster);

map.fitBounds(boundaries, {
    padding: [30, 30],
});
</script>