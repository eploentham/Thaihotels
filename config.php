<?php
	error_reporting(0);
	set_time_limit(0);
	$dbhost 			= "localhost";
	$dbuname 			= "thaihotels_reser";
	$dbpass 			= "Thahr30";
	$dbname 			= "thaihotels_reser";
	$dbtype 			= "MySQL";
	$prefix				= "tha";
	$THA_ADDRESS = '294/1 Asia Buiding Floor 2
                        Phayathai Road, Rajthevee, Bangkok 10400 Thailand.   Tel: (66) 2216 9496 Fax : (66) 2216 9499  ';
	//$base				= "";

	$sBasePath = "/tha/js_v2/";	
	$banner_path= "data-file/banner";
	$hotels_path= "data-file/hotels";
	$news_path= "data-file/news";
	$iconservice_path= "data-file/iconservice";	
	$hotel_rating_path= "data-file/hotel_rating";	
	$green_leaf_foundation_path= "data-file/green_leaf_foundation";	
	$travel_infoemation_path= "data-file/travel_infoemation";	
	$membership_path= "data-file/membership";


    require_once($base."database/db.php");
	require_once($base."function/appfile.php");
	require_once($base."function/func_sql.php");
	require_once($base."function/date_th.php");
	require_once($base."function/general.php");
	require_once($base."function/libmail.php");
	require_once($base."function/functions.php");
	require_once($base."function/nocache.inc.php");

	$sql = sql_Select(1, $prefix."_setting", "setting_id =1", 0);
			
	$query = $db->sql_query($sql);
	$setting = $db->sql_fetchrow($query);
	
	$ww = $setting['setting_width'];
	$hh =$setting['setting_height'];
	$shh = $setting['setting_sheight'];
	$sww  = $setting['setting_swidth'];		
	$perpage = $setting['setting_per_rec'];	
	$per_page = $setting['setting_per_rec_f'];	

	$PHP_SELF = $_SERVER["PHP_SELF"];
	$arr_path =  explode("/",$PHP_SELF);
	if (!$thispage)  $thispage = $arr_path[count($arr_path)-1];

	/*
	foreach($_GET as $k=>$v){
	$$k=$v;
	}

	foreach($_POST as $k=>$v){
		$$k=$v;
	}
	*/

	//echo "<script>alert('PHP_SELF=$PHP_SEFL,thispage=$thispage')</script>";
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// report mail
	//include "ref_report.php";
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>