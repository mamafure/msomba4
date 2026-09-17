<!DOCTYPE html>
<html>
<head>
    <title>Checkout - MSOMBA</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 400px; width: 100%; border-radius: 10px; margin: 20px 0; }
        .checkout-container { max-width: 800px; margin: auto; padding: 20px; }
    </style>
</head>
<body>
<div class="checkout-container">
    <h2>Delivery Location</h2>
    <p>Click on the map to select your exact delivery location in Mbeya/Tanzania:</p>
    
    <div id="map"></div>

    <form action="place_order.php" method="POST">
        <input type="text" name="address" placeholder="Street/Area Name" required style="width:100%; padding:10px; margin-bottom:10px;">
        <input type="text" id="coords" name="coordinates" placeholder="Coordinates (Selected from Map)" readonly style="width:100%; padding:10px; background:#eee;">
        <button type="submit" class="add-to-cart-btn" style="width:100%; margin-top:20px;">Confirm & Place Order</button>
    </form>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize map centered in Tanzania (e.g., Mbeya)
    var map = L.map('map').setView([-8.9, 33.4], 13); 

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker;

    map.on('click', function(e) {
        if (marker) { map.removeLayer(marker); }
        marker = L.marker(e.latlng).addTo(map);
        document.getElementById('coords').value = "Lat: " + e.latlng.lat + ", Lng: " + e.latlng.lng;
    });
</script>
</body>
</html>