<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($sms['sms_firma'] == 'iletimerkezi'  ) {
    $iletibaslik = $sms['iletimerkezi_baslik'];
    $iletiuser = $sms['iletimerkezi_user'];
    $iletipass = $sms['iletimerkezi_pass'];

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
                             <text>$siteMesaj</text>
                             <receipents>
                                 <number>$telSite</number>
                             </receipents>
                     </message>
   	    		 	 <message>
                            <text>$userMesaj</text>
                             <receipents>
                                 <number>$telUser</number>
                             </receipents>
   	    		     </message>
   			 </order>
   		
   		 </request>

EOS;
    $result = sendRequest('http://api.iletimerkezi.com/v1/send-sms', $xml, array('Content-Type: text/xml'));
}


if($sms['sms_firma'] == 'netgsm'  ) {
    $netgsmbaslik = $sms['netgsm_baslik'];
    $netgsmuser = $sms['netgsm_user'];
    $netgsmpass = $sms['netgsm_pass'];
    function XMLPOST($PostAddress, $xmlData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $PostAddress);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
        $result = curl_exec($ch);
        return $result;
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<mainbody>
<header>
<company></company>
<usercode>' . $netgsmuser . '</usercode>
<password>' . $netgsmpass . '</password>
<startdate></startdate>
<stopdate></stopdate>
<type>n:n</type>
<msgheader>' . $netgsmbaslik . '</msgheader>
</header>
<body> 	
<mp><msg><![CDATA['.$siteMesaj.']]></msg><no>' . $telSite . '</no></mp> 	
<mp><msg><![CDATA['.$userMesaj.']]></msg><no>' . $telUser . '</no></mp> 
</body>
</mainbody>';
    $gelen = XMLPOST('http://api.netgsm.com.tr/xmlbulkhttppost.asp', $xml);
}
?>