<?php
define('WP_USE_THEMES', false);
ini_set('display_errors',true);
//require('../../../wp-base/wp-load.php');
require('../../../wp-load.php');
header("Content-Type: text/html; charset=utf-8");

function check_email($email)
{
header ("x-check: xx{$email}xx");
if (preg_match( '/^([a-z0-9]+([-_\.]?[a-z0-9])+)@[a-z0-9���]+([-_\.]?[a-z0-9���])+\.[a-z]{2,4}$/i', $email)) { 
return true;
}
}

if(isset($_POST["submit"])) {
	if(check_email($_POST["email"]) == true) { 
		header('x-email: yes');
		$ch = curl_init();
	
		$key['tx_kofointerested_pi1[backurl]'] = 'http://studieninfo.physik.uni-halle.de/';
		$key['tx_kofointerested_pi1[first_name]'] = $_POST["first_name"];
		$key['tx_kofointerested_pi1[last_name]'] = $_POST["last_name"];
		$key['tx_kofointerested_pi1[email]'] = $_POST["email"];
		$key['tx_kofointerested_pi1[agreeprivacypolicy]'] = $_POST["agree"];
		
		curl_setopt($ch, CURLOPT_URL,"http://www.ich-will-wissen.de/interessenten/");
		curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $key); 
		$result=curl_exec ($ch); 
		curl_close ($ch);
		iww_cookie(urlencode($_POST["email"]));
		echo ($result);
		
		wp_mail('Torsten.Evers@rektorat.uni-halle.de, oliverbunke@gmail.com', 'Betreff: MLU Physik', $key['tx_kofointerested_pi1[first_name]'].' '.$key['tx_kofointerested_pi1[last_name]'].' || '.$key['tx_kofointerested_pi1[email]']);
	} 
	else { 
		header('x-email: no'); 
		echo "<style>a{text-decoration:none;}</style><div align='center'>Die E-Mail Adresse <strong>".$key['tx_kofointerested_pi1[email]']."</strong> ist ung�ltig!<br><br><a href='javascript:window.close()'>- Fenster schlie�en -</a></div>";
	}
}
?>
