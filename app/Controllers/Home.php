<?php 
namespace App\Controllers;
use App\Libraries\geoplugin;


class Home extends BaseController
{
	public function __construct(){
		Helper('pesantelegram');
		$this->getLocation();
	}

	public function index()
	{

		$dataNas = WRITEPATH . 'datacovid/nasionalData.json';
		$query = json_decode(file_get_contents($dataNas), TRUE)[0]["features"] ;
		$query2 = json_decode(file_get_contents($dataNas), TRUE)[0] ;

		$totalProv = (count($query));
		$positif = 0;
		$sembuh = 0;
		$meninggal = 0;
		foreach ($query as $key => $value) {
			$positif = $positif +=  $value["attributes"]["Kasus_Posi"];
			$sembuh = $sembuh +=  $value["attributes"]["Kasus_Semb"];
			$meninggal = $meninggal +=  $value["attributes"]["Kasus_Meni"];
		}
		
		$data = [
			'title' => 'Live Data Kasus COVID-19 Nasional',
			'uRL' => 'https://infocorona.site',
			'ogImage' => base_url('/assets/img/ogimage.jpg'),
			'keywords' => 'Data corona indonesia, total corona indonesia, covid-19 indonesia, positif corona indonesia, jumlah total psitif corona, positif corona hari ini, jumlah kasus corona, covid 19, corona indonesia, kasus Covid19 global, total covid dunia, data corona dunia',
			'description' => 'Menyajikan data kasus Covid-19/Corona secara live dan update setiap hari. Data yang ditampilkan adalah kasus secara nasional maupun secara global.',
			'dataProv' => $query,
			'judul1' => 'TOTAL KASUS COVID-19 NASIONAL',
			'judul2' => 'Total Kasus Dari '.$totalProv.' Provinsi',
			'judul2ket' => 'Pilih nama provinsi untuk informasi detail : ',
			'posi' => $positif,
			'semb' => $sembuh,
			'meni' => $meninggal,
			'update' => $query2
		];

		// echo view('templates/header', $data);
		echo view('templates/header', $data);
		echo view('Home', $data);
		// echo view('templates/footer');

	}

	public function getDataJson()
	{
		$fileGlobal = 'datacovid/globaldata.json';
		$urlglobal = 'https://api.kawalcorona.com/global/';
		$fileNas = 'datacovid/nasionalData.json';
		$urlNas = 'https://services5.arcgis.com/VS6HdKS0VfIhv8Ct/arcgis/rest/services/COVID19_Indonesia_per_Provinsi/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json';

		// $this->getDataServer($fileGlobal,$globalData, 'globalData' );
		$updateDataNas = $this->getDataServer($fileNas, $urlNas);
		$updateDataGlobal = $this->getDataServer($fileGlobal, $urlglobal, 'global');

		if( $updateDataNas && $updateDataGlobal  )
		{
			$text = 
			' <strong>------ UPDATE DATA SERVER ------</strong>

			Server : Kawal Corona & BNPB
			Tanggal : '.date('d-m-Y').'
			Jam : '.date('H:i:s').'
			Status : Berhasil ';

		} else { 
			$text = 
			' <strong>------ UPDATE DATA SERVER ------</strong>

			Server : SERVER KAWAL KORONA
			Tanggal : '.date('d-m-Y').'
			Jam : '.date('H:i:s').'
			Status : Gagal ';
		}

		kirimpesan($text);
	}

	private function getDataServer($file, $url=[], $string = null)
	{
		$file = WRITEPATH . $file;

		if($string === 'global')
		{
			$urlGlobal = json_decode(file_get_contents($url), TRUE);
			$data[] = array(
				"Last_spdate"=>time(),
					$urlGlobal
				
			);

		} else {
			$urlNas = json_decode(file_get_contents($url), TRUE);
			$data[] = array(
				"last_update"=>time()
			)+$urlNas;
		}
		$jsonfile = json_encode($data, JSON_PRETTY_PRINT);

		$result = file_put_contents($file, $jsonfile);

		return $result;
	}
	//--------------------------------------------------------------------
	public function kontak(){
		$request = \Config\services::request();
		if( $request->getVar('nama'))
		{
			$nama = $request->getVar('nama');
			$email = $request->getVar('email');
			$pesan = $request->getVar('pesan');
			$text = 
			'<strong>Pesan Dari Pengunjung</strong>

			Web : infocorona.site
			Nama : '.$nama.'
			Email : '.$email.'
			Tanggal : '.date('d-m-Y').'
			Jam : '.date('H:i:s').'
			Pesan : '.$pesan.'';
			$send = kirimpesan($text);

			if ($send == TRUE ) {
				echo 1;
			}else {
				echo 0;
			}
		} else {
			return redirect()->to(base_url());
		}
	}

	private function getLocation(){
			$geoplugin = new geoPlugin();
			$geoplugin->locate();

		    $waktu = date('d/m/Y H:i:s');

		    if($geoplugin->city != '')
		    {
		    	$textTelegram =  '
		    	Ada pengunjung Website infocorona.site

				IP : '.$geoplugin->ip.'
				Provinsi : '.$geoplugin->regionName.'
				Kota : '.$geoplugin->city.'
				Negara : '.$geoplugin->countryName.'
				Kode Negara : '.$geoplugin->countryCode.'
				Latitude : '.$geoplugin->latitude.'
				Latitude : '.$geoplugin->longitude.'
				Waktu : '.$waktu.'
		    	';
		    	kirimpesan($textTelegram);    	
		    }

	}

}
