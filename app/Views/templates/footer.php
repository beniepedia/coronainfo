<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
	<script src="<?= base_url() ?>/assets/admin/admin.js"></script>


	<script>
		


		var mapId = {lat: -0.384722, lng: 117.079056};
		var iconBase = "<?= base_url() ?>/assets/img/";
		var infoObj = [];

		function addMarker(){

			<?php  foreach ($dataProv as $row) : ?>

					var provinsi = [
						{
							provi:"<?= $row['attributes']['Provinsi'] ?>",
							posi:"<?= $row['attributes']['Kasus_Posi'] ?>",
							semb:"<?= $row['attributes']['Kasus_Semb'] ?>",
							meni:"<?= $row['attributes']['Kasus_Meni'] ?>",
							latlng:[{
								lat:<?= $row['geometry']['y'] ?>,
								lng:<?= $row['geometry']['x'] ?>
							}]

						},
					];
			

					// for(var i = 0; i < provinsi.length; i++){
					provinsi.forEach(function(el){
						var contentString = `<div class="infoWindow">
												<h2>`+ el.provi +`</h2>
												<ul>
												<li>Positif : `+ el.posi +`</li>
												<li>Sembuh : `+ el.semb +`</li>
												<li>Meninggal : `+ el.meni +`</li>
												</ul>
											</div>`;

						var marker = new google.maps.Marker({
							position: el.latlng[0],
							map: map,
							title: el.provi,
							icon: iconBase + 'corona.png'
						});

						var infowindow = new google.maps.InfoWindow({
							content: contentString
						});

						marker.addListener('click', function(){
							closeInfo();
							infowindow.open(map, marker);
							infoObj[0] = infowindow;
						});

						function closeInfo(){
							if (infoObj.length > 0) {
								infoObj[0].set("marker", null);
								infoObj[0].close();
								infoObj[0].length = 0;
							}
						}

						marker.addListener('click', toggleBounce);
						function toggleBounce() {
						  if (marker.getAnimation() !== null) {
						    marker.setAnimation(null);
						  } else {
						    marker.setAnimation(google.maps.Animation.BOUNCE);
						  }
						}
					});

			<?php endforeach ?>
		}



		function initMap() {
			map = new google.maps.Map(document.getElementById('mapid'), {
			  center: mapId,
			  zoom: 5,
			   mapTypeControl: true,
			    mapTypeControlOptions: {
			        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
			        position: google.maps.ControlPosition.TOP_LEFT
			    },
			    center: mapId,
			    gestureHandling: 'greedy',
			    fullscreenControl: true,
			    fullscreenControlOptions: {
			        position: google.maps.ControlPosition.BOTTOM_RIGHT
			    }
			});
			addMarker();
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG4v-MhwqrMvvjZ2EQRPK4ZFJrEkBPeZo&callback=initMap"
    async defer></script>
</body>
</html>