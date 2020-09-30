
	<div class="container">
		<header>
			<div class="title">
				<h2><?= $judul1 ?></h2>
				<p>Update terakhir : <?= date(" d-m-Y H:i:s T", $update["last_update"]) ?> </p>
			</div>
			<div class="totalInfo">
				<h1><i class="fa fa-users"></i> <?= number_format($posi+$semb+$meni) ?><span> Kasus</span></h1>
			</div>
			<div class="listKasus">
				<ul>
					<li><i class="fa fa-user-plus"></i> Total Positif <span><?= number_format($posi) ?></span></li>
					<li><i class="fa fa-handshake-o"></i> Total Sembuh <span><?= number_format($semb) ?></span></li>
					<li><i class="fa fa-user-times"></i> Total Meninggal <span><?= number_format($meni) ?></span></li>
				</ul>
			</div>
			<div class="sumber">
				<p>Created By : <a href="https://facebook.com/ahmadqomaini">AHMAD QOMAINI</a></p> | <p>Design By : <a href="https://facebook.com/ferry.siregarrr">FERRY SIREGAR</a></p>
			</div>
			<div class="sharethis-inline-share-buttons"></div>
		</header>
		<main>
			<div id="mapid" style="height: 100%; width: 100%;"></div>
		</main>
		<aside>
			<div class="listProv">
				<h2><?= $judul2 ?> <span><?= $judul2ket ?></span></h2>
				<div class="search">
					<input type="seacrh" placeholder="Cari Wilayah ...">
					<span><i class="fa fa-search"></i></span>
				</div>
				<ul>
				<?php 
				foreach ($dataProv  as $data) : ?>
					<?php $total = ['positif'=>$data["attributes"]['Kasus_Posi'],
										'sembuh'=> $data["attributes"]['Kasus_Semb'],
										'meninggal'=> $data["attributes"]['Kasus_Meni']
									]?>

					<li data-prov="<?= $data["attributes"]['Provinsi'] ?>" posi="<?= $total['positif'] ?>" sem="<?= $total['sembuh'] ?>" meni="<?= $total['meninggal'] ?>"><?= $data["attributes"]['Provinsi'] ?> <span><?= array_sum($total) ?></span></li>
				<?php endforeach ?>
				</ul>
			</div>
		</aside>

		<div class="modal">
			<div class="heading">
				Detail Kasus Provinsi
				<h4></h4>
				<span class="close">&times;</span>
			</div>
			<div class="listModal">
				<ul>
					<li><i class="fa fa-user-plus" aria-hidden="true"></i> Total Positif : <span class="positif"></span></li>
					<li><i class="fa fa-handshake-o" aria-hidden="true"></i> Total Sembuh : <span class="sembuh"></span></li>
					<li><i class="fa fa-user-times" aria-hidden="true"></i> Total Meninggal : <span class="meninggal"></span></li>
				</ul>
			</div>
		</div>
	</div>
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
    <script src="<?= base_url() ?>/assets/admin/admin.js"></script>
	<script src="<?= base_url() ?>/assets/admin/chat.js"></script>
</body>
</html>