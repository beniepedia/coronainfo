<?php namespace App\Controllers;

class Globalcase extends BaseController
{

	public function __construct()
	{
		Helper('dump');
	}

	public function index()
	{
		$jsonData =  WRITEPATH . 'datacovid/globaldata.json';
		$arr =  json_decode(file_get_contents($jsonData), TRUE)[0][0];

		$active = 0;
		$recovery = 0;
		$deaths = 0;
		foreach ($arr as $row) {
			$active = $active += $row['attributes']['Confirmed'] ;
			$recovery = $recovery += $row['attributes']['Recovered'] ;
			$deaths = $deaths += $row['attributes']['Deaths'] ;
			$totalNegara[] = $row;
		}

		$data = array(
			'title' => 'Live Data Kasus COVID-19 Global',
			'uRL' => 'https://infocorona.site/globalcase',
			'ogImage' => base_url('/assets/img/ogimage.jpg'),
			'keywords' => 'Data corona indonesia, total corona indonesia, covid-19 indonesia, positif corona indonesia, jumlah total psitif corona, positif corona hari ini, jumlah kasus corona, covid 19, corona indonesia, kasus Covid19 global, total covid dunia, data corona dunia ',
			'description' => 'Menyajikan data kasus Covid-19/Corona secara live dan update setiap hari. Data yang ditampilkan adalah kasus secara nasional maupun secara global.',
			'judul1' => 'TOTAL KASUS COVID-19 GLOBAL',
			'judul2' => 'Total Kasus dari '.count($totalNegara).' Negara',
			'judul2ket' => 'Pilih nama Negara untuk informasi detail : ',
			'dataNegara' => $arr,
			'totalCase' => $active + $recovery + $deaths,
			'posi' => $active,
			'sembu' => $recovery,
			'meni' => $deaths

		);
		echo View('templates/header',$data);
		echo View('Globalcase',$data);



	}

	
}