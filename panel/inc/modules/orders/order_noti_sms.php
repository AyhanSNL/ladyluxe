<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php

if($sms['sms_firma'] == 'iletimerkezi'  ) {
    $iletibaslik = $sms['iletimerkezi_baslik'];
    $iletiuser = $sms['iletimerkezi_user'];
    $iletipass = $sms['iletimerkezi_pass'];
    $mesaj = $mesaj_icerik;
    $tel = $numara;
    function sendRequest($site_name, $send_xml, $header_type)
    {

        //die('SITENAME:'.$site_name.'SEND XML:'.$send_xml.'HEADER TYPE '.var_export($header_type,true));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $site_name);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $send_xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_type);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $result = curl_exec($ch);

        return $result;
    }

    $username = $iletiuser;
    $password = $iletipass;
    $orgin_name = $iletibaslik;

    $xml = <<<EOS
   		 <request>
   			 <authentication>
   				 <username>{$username}</username>
   				 <password>{$password}</password>
   			 </authentication>

   			 <order>
   	    		 <sender>{$orgin_name}</sender>
   	    		 <sendDateTime>01/05/2013 18:00</sendDateTime>
   	    		 <message>
   	        		 <text>{$mesaj}</text>
   	        		 <receipents>
   	            		 <number>{$tel}</number>
   	        		 </receipents>
   	    		 </message>
   			 </order>
   		
   		 </request>

EOS;
    $result = sendRequest('http://api.iletimerkezi.com/v1/send-sms', $xml, array('Content-Type: text/xml'));
}


if($sms['sms_firma'] == 'netgsm'  ) {
    $usa = $sms['netgsm_user'];
    $paso = $sms['netgsm_pass'];
    $baslik = $sms['netgsm_baslik'];
    $mesaj = $mesaj_icerik;
    $tel = $numara;
    function sendsms($msg, $telno, $header, $username, $pass)
    {
        $startdate = date('d.m.Y H:i');
        $startdate = str_replace('.', '', $startdate);
        $startdate = str_replace(':', '', $startdate);
        $startdate = str_replace(' ', '', $startdate);

        $stopdate = date('d.m.Y H:i', strtotime('+1 day'));
        $stopdate = str_replace('.', '', $stopdate);
        $stopdate = str_replace(':', '', $stopdate);
        $stopdate = str_replace(' ', '', $stopdate);
        $url = "http://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=$telno&message=$msg&msgheader=$header&startdate=$startdate&stopdate=$stopdate";
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;

    }
    $mesaj = html_entity_decode($mesaj, ENT_COMPAT, "UTF-8");
    $mesaj = rawurlencode($mesaj);
    $baslik = html_entity_decode($baslik, ENT_COMPAT, "UTF-8");
    $baslik = rawurlencode($baslik);
    sendsms($mesaj, $tel, $baslik, $usa, $paso);
}
?>