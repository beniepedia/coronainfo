<?php 
namespace App\Controllers;

class Bots extends BaseController {

public function index() {
        Helper('pesantelegram');
        $fileJson = WRITEPATH . 'datacovid/nasionalData.json';
        $data = json_decode(file_get_contents($fileJson), true);
        $arr = $data[0]["features"];
        $positif = 0;
        $sembuh = 0;
        $meninggal = 0;
        $last_update = date('d/m/Y H:i:s', $data[0]['last_update']);


        foreach ($arr as $key => $value) 
        {
            $positif = $positif += $value["attributes"]["Kasus_Posi"]; 
            $sembuh = $sembuh += $value["attributes"]["Kasus_Semb"]; 
            $meninggal = $meninggal += $value["attributes"]["Kasus_Meni"];
            $provinsi[] = json_encode($value["attributes"]["Provinsi"], JSON_PRETTY_PRINT);
        }

        $update = json_decode(file_get_contents("php://input"), true); $chat_id = $update["message"]["chat"]["id"]; $name = $update["message"]["chat"]["first_name"] . ' ' . $update["message"]["chat"]["last_name"]; $pesan = $update["message"]["text"]; $hari = date('d-m-Y'); 
    
        if ($pesan == '/start') 
        {
            $text = 'Hai '.$name.', selamat datang di Bot infocorona.site. '."\n".'. Mau tau perkembangan kasus corona di indonesia?';
            $text = 'Hai '.$name.', selamat datang di Bot infocorona.site. '."\n".'. Mau tau perkembangan kasus corona di indonesia? silahkan pilih menu dibawah';
        }

        if ($pesan == 'Total Kasus' || $pesan == '/total' ) 
        {

            $text = "*TOTAL KASUS HARI INI*\n";
            $text   .= $hari . "\n\n";
            $text   .= 'Positif          : '.number_format($positif)."\n";
            $text   .= 'Sembuh       : '.number_format($sembuh)."\n";
            $text   .= 'Meninggal   : '. number_format($meninggal) . "\n";
            $text   .= 'Update         : '.$last_update;
        }

        if ($pesan == 'Provinsi') 
        {
            $text = $provinsi;
        }	   

        if ($pesan == 'Website') 
        {
            $text = 'https://infocorona.site';
        }

        if ($pesan == 'Tentang') 
        {
            $text = 'https://facebook.com/ahmadqomaini';
        }
        

        if(!empty($text)){
            sendBot($chat_id, $text);     
        } else {
            return redirect()->to(base_url());
        }


    }

}