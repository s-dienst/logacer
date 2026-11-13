const map = L.map('map');
const layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

const markers = JSON.parse(
    document.getElementById(
    "markers-data"
    ).textContent
);
const boundaries = JSON.parse(
    document.getElementById(
    "boundaries"
    ).textContent
);
markers.forEach((m) => {
    var marker = L.marker([m.lat, m.long]).addTo(map);
    var popup = ""
    m.sites.forEach((s) => {
        let url = '<a href="';
        url += s.url;
        url += '" target="_blank">';
        url += s.name;
        url += "</a>";
        if ("count" in s) {
            const map_other_data = JSON.parse(document.getElementById("map_other_data").textContent);
            url += ' : ';
            url += s.count;
            url += ' (';
            // For that : see in type.php
            url += map_other_data.url_begin;
            url += s.id;
            url += map_other_data.url_end;
            url += ')';
        }
        popup += url
        popup += "<br>"
    })
    marker.bindPopup(popup);
});
map.fitBounds(boundaries, {
    padding: [30, 30],
});