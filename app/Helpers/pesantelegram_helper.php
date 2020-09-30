
<?php 
if(! function_exists('kirimpesan'))

{
    
   function kirimpesan(string $pesan){
      $token = '1210455223:AAEK6SrKXgxWjtQpv1uBVAI7-B41zohuIVw';

      $id = '1164076579';
      $data = [
         'chat_id' => $id,
         'text'=>$pesan,
         'parse_mode'=>'html'
         ];
      $send = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?".http_build_query($data));		

      return $send;
   }	
   
   function sendBot($id, string $text){
       $token = '1210455223:AAEK6SrKXgxWjtQpv1uBVAI7-B41zohuIVw';		// $id=$id;
       $key = [["Total Kasus","Provinsi"],["Website","Tentang"]];
       $res = array("keyboard"=>$key, 'resize_keyboard'=>true,"one_time_keyboard"=>false);
       $reply = json_encode($res);
       $mode='Markdown';
       $data = [
         'chat_id' => $id,
         'text'=> $text,
         'parse_mode'=> $mode,
         'reply_markup'=> $reply
       ];
       
       $kirim = file_get_contents("https://api.telegram.org/bot1210455223:AAEK6SrKXgxWjtQpv1uBVAI7-B41zohuIVw/sendMessage?".http_build_query($data));
       return $kirim;
       }
   
}?>