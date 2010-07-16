<?php
/*
Plugin Name: MultiPass Single Sign-On for Tender
Plugin URI: https://help.tenderapp.com/faqs/setup-installation/multipass
Description: Easily generate a link to share User's between WordPress and your Tender App
Version: 1.0
Author: Kenny Meyers
Author URI: http://kennymeyers.com
License: GPL2
*/

/**
 * Generates the Tender API Key
 *
 * @param string $link Your tender link http://yourapp.tender.com
 * @param string $sso_key Your Tender site Key
 * @param string $key Your Tender SSO API Key
 * @param string $text The visible text between the anchor element
 * @return void
 * @author Kenny Meyers
 */
function multipass($link="", $sso_key="", $key="", $anchor_text="Support")
{
	global $current_user;
	
	get_currentuserinfo();
	
	//Checks to see if a tender link was even entered
	if (!$link = str_replace("http://", "", $link))
	{	
		echo "You haven't entered your Tender App URL";
		return;
	}
	
	//Are the SSO Key and the API Key set?
	if ($key == "")
	{
		echo "You haven't entered your Tender Key";
		return;
	}
	elseif ($sso_key=="")
	{
		echo "You haven't entered your SSO API Key";
		return;
	}
	
	// Checks to see if the user is logged in if not just returns the link
	if (0 == $current_user->ID)
	{
		echo  '<a href="http://'.$link.'">'.$anchor_text.'</a>';
		return;
	}
	
	//Is the user's email setup?
	if ($current_user->user_email == "")
	{
		echo "You must enter your email address for support";
		return;
	}

	$tender_params = array(
		'unique_id' => $current_user->ID,
		'name'      => $current_user->display_name,
		'email'     => $current_user->user_email,
		'sso_key'   => $sso_key,
		'site_key'  => $key,
		'expires'   => date("Y-m-d H:i:s", strtotime("+30 minutes")),
		'trusted'   => true,
	);
	
	//Finally generate the Tender URL
	echo '<a href="http://'. $link  . _getTenderLink($tender_params).'">'. $anchor_text.'</a>';
}

/**
 * Generates a Tender API link, accepting parameters and doing all the
 * hashing, security-ing, and modify-ing.
 *
 * @param array $params 
 * @return void
 * @author Kenny Meyers
 */
function _getTenderLink($params)
{
	$hash= hash('sha1', $params['sso_key'] . $params['site_key'], true);
	
	//Remove the API & SSO Key from the Params
	unset($params['sso_key']);
	unset($params['site_key']); 
	
	$saltedHash = substr($hash,0,16);
	
	$iv= "OpenSSL for Ruby";

	$data = json_encode($params);
	
	for ($i = 0; $i < 16; $i++)
	{
	    $data[$i] = $data[$i] ^ $iv[$i];
	}

	$pad = 16 - (strlen($data) % 16);
	$data = $data . str_repeat(chr($pad), $pad);
	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'','cbc','');
	mcrypt_generic_init($cipher, $saltedHash, $iv);
	$encryptedData = mcrypt_generic($cipher,$data);
	mcrypt_generic_deinit($cipher);

	$multipass = urlencode(base64_encode($encryptedData));
	
	return "?sso={$multipass}";
}
?>