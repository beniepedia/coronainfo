AIzaSyCG4v-MhwqrMvvjZ2EQRPK4ZFJrEkBPeZo

// loadMap(-0.384722, 117.079056, 5)
		
		// function loadMap(lat, lon, zoom) {
		// 	var mymap = L.map('mapid').setView([lat,lon], zoom);

		// 	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		// 	maxZoom: 18,
		// 	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
		// 		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
		// 		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		// 	id: 'mapbox/streets-v11',
		// 	tileSize: 512,
		// 	zoomOffset: -1
		// 	}).addTo(mymap);
		// 	<?php foreach ($dataProv as $key => $value) : ?>
		// 	var marker = L.marker([<?= $value['geometry']['y'] ?>, <?= $value['geometry']['x'] ?>]).addTo(mymap); 
		// 	marker.bindPopup("<b><?= $value['attributes']['Provinsi'] ?></b><br><br><div class='orange-text'>Positif : <?= $value['attributes']['Kasus_Posi'] ?></div><div class='green-text'>Sembuh : <?= $value['attributes']['Kasus_Semb'] ?></div><div class='red-text'>Meninggal : <?= $value['attributes']['Kasus_Meni'] ?></div>").openPopup();
		// 	<?php endforeach ?>
		// }

		infoWindow = new google.maps.InfoWindow;
			<?php foreach ($dataProv as $data) : ?>
				var contentString = '<?= $data['attributes']['Provinsi'] ?>';
				 var infowindow = new google.maps.InfoWindow({
		          content: contentString
		        });
				var marker = new google.maps.Marker({
			    position: {lat:<?= $data['geometry']['y'] ?>, lng: <?= $data['geometry']['x'] ?>},
			    map: map,
			    icon: iconBase + 'corona.png'
			  });
			<?php endforeach ?>

	        Try HTML5 geolocation.

	        if (navigator.geolocation) {
	          navigator.geolocation.getCurrentPosition(function(position) {
	            var pos = {
	              lat: position.coords.latitude,
	              lng: position.coords.longitude
	            };

	            infoWindow.setPosition(pos);
	            infoWindow.setContent('Lokasi terdeteksi....');
	            infoWindow.open(map);
	            map.setCenter(pos);
	          }, function() {
	            handleLocationError(true, infoWindow, map.getCenter());
	          });
	        } else {
	          // Browser doesn't support Geolocation
	          handleLocationError(false, infoWindow, map.getCenter());
	        }
	      }

	      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
	        infoWindow.setPosition(pos);
	        infoWindow.setContent(browserHasGeolocation ?
	                              'Error: The Geolocation service failed.' :
	                              'Error: Your browser doesn\'t support geolocation.');
	        infoWindow.open(map);