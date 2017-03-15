<?php

	session_start();
	include "config.php";
	foreach($_GET as $k=>$v){
	$$k=$v;
	}

	foreach($_POST as $k=>$v){
		$$k=$v;
	}
	//print_r($_POST);
	//echo session_id();
	//print_r($_SESSION['SESSION']);

	//////////////////////////////////////////////////////////////////////////////////////////////////

	$clients_sql=sql_Select(1,$prefix."_clients","clients_user = '".$_SESSION['SESSION']['clients_name']."' and clients_pass = '".$_SESSION['SESSION']['clients_pass']."' and clients_active ='1' ",0);
		$clients_query=$db->sql_query($clients_sql);
		$result = $db->sql_fetchrow($clients_query);

		$clients_id=$result['clients_id'];
		$clients_title=$result['clients_title'];   $c_title = getn("title_name","title","title_id = '$clients_title' ");
		$clients_fname=$result['clients_fname'];
		$clients_lname=$result['clients_lname'];
		$clients_address=$result['clients_address'];
		$clients_city=$result['clients_city'];
		$clients_postal=$result['clients_postal'];
		$clients_country=$result['clients_country'];
		$clients_phone_country=$result['clients_phone_country'];
		$clients_phone_area=$result['clients_phone_area'];
		$clients_phone_number=$result['clients_phone_number'];
		$clients_phone_country2=$result['clients_phone_country2'];
		$clients_phone_area2=$result['clients_phone_area2'];
		$clients_phone_number2=$result['clients_phone_number2'];
		$clients_fax_country=$result['clients_fax_country'];
		$clients_fax_area=$result['clients_fax_area'];
		$clients_fax_number=$result['clients_fax_number'];
		$clients_primarymail=$result['clients_primarymail'];
		$clients_alternatemail=$result['clients_alternatemail'];
		$clients_passport=$result['clients_passport'];
		$clients_user=$result['clients_user'];
		$clients_pass=$result['clients_pass'];
		$clients_active=$result['clients_active'];
		$clients_lastlogin=$result['clients_lastlogin'];
		$clients_ip=$result['clients_ip'];
	//////////////////////////////////////////////////////////////////////////////////////////////////

	$hotels_id = get_var('hotels_id','request',0);
	$allot = get_var('allot','request',0);
	$checkin = get_var('checkin','request',0);
	$checkout = get_var('checkout','request',0);
	$tempselect = get_var('tempselect','request',0);
	$showtotal_allot = get_var('showtotal_allot','request',0);
	
	//////////////////////////////////////////////////////////////////////////////////////////////////	
    $str_date = RangeDate($checkin,$checkout);
	$arr_type = getarr("typeroom_id","typeroom","hotels_id = '$hotels_id' ");
	//print_r($arr_type);
	//////////////////////////////////////////////////////////////////////////////////////////////////

	$detail_sql = sql_Select(1, $prefix."_hotels", "hotels_id = '$hotels_id'", 0);
	//echo  $detail_sql ;
	$detail_query = $db->sql_query($detail_sql);
	$hotels = $db->sql_fetchrow($detail_query);
	
	$hotels_id=$hotels['hotels_id'];
	$hotels_abbreviation=$hotels['hotels_abbreviation'];
	$hotels_name=$hotels['hotels_name'];
	$hotels_overview=$hotels['hotels_overview'];
	$hotels_star=$hotels['hotels_star'];
	$hotels_pic1=$hotels['hotels_pic1'];
	$hotels_address=$hotels['hotels_address'];
	$hotels_city=$hotels['hotels_city'];
	$hotels_postal=$hotels['hotels_postal'];
	$hotels_country=$hotels['hotels_country'];
	$hotels_telephone=$hotels['hotels_telephone'];
	$hotels_fax=$hotels['hotels_fax'];
	$hotels_contactname=$hotels['hotels_contactname'];
	$hotels_contactphone=$hotels['hotels_contactphone'];
	$hotels_contactemail=$hotels['hotels_contactemail'];
	$hotels_username=$hotels['hotels_username'];
	$hotels_password=$hotels['hotels_password'];
	$hotels_status=$hotels['hotels_status'];
	$hotels_iconservice=$hotels['hotels_iconservice'];
	$hotels_facility=$hotels['hotels_facility'];
	$hotels_destination=$hotels['hotels_destination'];

	$province_name=getn("province_name_e","province","province_id = $hotels_city");

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//กำหนดค่าให้ session
	$sessionid = session_id();
	if ($Submit_form == 'IdFormAllot'){
	///print_r($_SESSION[$sessionid]);
	$_SESSION[$sessionid] = Array();

	$list_sql = "SELECT tr.typeroom_id,tr.typeroom_name
						FROM tha_typeroom as tr,tha_allotment as al WHERE  al.typeroom_id = tr.typeroom_id and al.hotels_id = '$hotels_id' and al.allotment_date in ($str_date)  and al.allotment_active = 1 and al.allotment_reserve = 0 Group by tr.typeroom_id ";
	//echo "$list_sql<br>";

	$list_query = $db->sql_query($list_sql);
	$totalrec = $db->sql_numrows($list_query);    //echo "<br>$totalrec<br>";

	if ($totalrec > 0 ){
			$no=1;$db_total_allot = 0;
			while ($allotment = $db->sql_fetchrow($list_query))
				{
					$typeroomid=$allotment['typeroom_id'];
					$typeroom_name=$allotment['typeroom_name'];

					$con_typerooms = " and typeroom_id = '$typeroomid' ";
					$str_type .= ":$typeroomid";

						if ($typeroomid == ${'box_'.$typeroomid}){

							$list_sql2 = "SELECT DATE_FORMAT(allotment_date,'%d %M %Y, %a') as a_date,allotment_date as senddate,allotment_single_prices,allotment_double_prices,allotment_triple_prices,count(allotment_id) as c_room
							FROM tha_allotment
							WHERE  allotment_date in ($str_date)  and allotment_active = 1 and allotment_reserve = 0 and  hotels_id = '$hotels_id' $con_typerooms Group by allotment_date";
							//echo "$list_sql2<br>";
							$list_query2 = $db->sql_query($list_sql2);
							$totalrec2 = $db->sql_numrows($list_query2);     		//echo "<br>$totalrec<br>";

							$num2 = $totalrec2;
							$total_price = 0;
							$checked = "checked";$q =0;
							if ($num2>0)
							  {
								while (  $allotment2= $db->sql_fetchrow($list_query2))
								{
										$allotmentdate=$allotment2['a_date'];
										$senddate=$allotment2['senddate'];
										$allotmentprices=$allotment2['allotment_single_prices'];
										$allotmentprices_double=$allotment2['allotment_double_prices'];
										$allotmentprices_triple=$allotment2['allotment_triple_prices'];
										$c_room=$allotment2['c_room'];
																													
										$str_class = "";
										if ($allotment_remark == "")  $allotment_remark = "N/A";

										$d_day = strtolower(substr($allotment_date, -3, 3));

										$getprice = number_format(getn("typeroom_$d_day","typeroom","typeroom_id = '$typeroomid' "));

										$senddate = str_replace("-","",$senddate);
										$strdata = "$senddate-$typeroomid:$c_room:$allotmentprices:$allotmentprices_double:$allotmentprices_triple";
										//echo $strdata."<br>";


										//echo 'n_single'.$senddate.'-'.$typeroomid." ".'n_double'.$senddate.'-'.$typeroomid." ".'n_triple'.$senddate.'-'.$typeroomid."<br>";
										//echo ${'n_single'.$senddate.'-'.$typeroomid} + ${'n_double'.$senddate.'-'.$typeroomid} +${'n_triple'.$senddate.'-'.$typeroomid} ."<br>";

										$n_allot_per_date = ${'n_single'.$senddate.'-'.$typeroomid} + ${'n_double'.$senddate.'-'.$typeroomid} +${'n_triple'.$senddate.'-'.$typeroomid} ;

										$price_total_per_date = ${'n_single'.$senddate.'-'.$typeroomid}*$allotmentprices + ${'n_double'.$senddate.'-'.$typeroomid}*($allotmentprices_double) +${'n_triple'.$senddate.'-'.$typeroomid}*($allotmentprices_triple)  ;
										$total_price += $price_total_per_date;

										// Record Id
										$_SESSION[$sessionid][$typeroomid][$senddate] = ${'n_single'.$senddate.'-'.$typeroomid}.":".${'n_double'.$senddate.'-'.$typeroomid}.":".${'n_triple'.$senddate.'-'.$typeroomid}.":$n_allot_per_date:$price_total_per_date";
										//echo $_SESSION[$sessionid][$typeroomid][$senddate]."<br>";
									} // end while
							  }// end if (num2)
						} // if check type
			$db_total_allot  +=$total_price;
			$no++;
			} // end while
		}//end if totalrec

	}  // end if 
	/*else{
			echo "ค่าเดิม";
	}

	echo "<BR>****************************************************<BR>";
	foreach ($_SESSION[$sessionid] as $k1 => $dd1){
			if(is_array($dd1)){
					foreach ($_SESSION[$sessionid][$k1] as $k2 => $dd2){
							echo "k1 = $k1,k2 = $k2,dd2 = $dd2 : ";
							echo "(".$_SESSION[$sessionid][$k1][$k2].")<br>";
					}// end for
			  } // end if
	  } // end for
	echo "<BR>****************************************************<BR>";


	//echo " session ".count($_SESSION[$sessionid]);
	echo "<br>-------------------------------------------<BR>";
	print_r($_SESSION);
	echo "<br>------------------------------------------<BR>";*/

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Thai Hotels Association สมาคมโรงแรมไทย</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="css/tha.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
  <tr>
    <td align="center" valign="top">
	<table width="900" border="0" cellpadding="0" cellspacing="0" class="tha">
        <tr> 
          <td width="900" align="left" valign="top"><?include("top_menu.php");?></td>
        </tr>
        <tr>
          <td align="left" valign="top">
		  <table width="900" border="0" cellpadding="0" cellspacing="0" class="tha">
              <tr>
                <td width="1" align="left" valign="top" bgcolor="BFBFBF"><img src="images/point.gif" width="1" height="1"></td>
                <td width="898" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tha">
                    <tr align="left" valign="top"> 
                      <td><table height="286" border="0" cellpadding="0" cellspacing="0" class="tha">
                          <tr align="left" valign="bottom"> 
                            <td height="33" background="images/line_topic.gif"><img src="images/topic_search_ho.gif" width="102" height="20"></td>
                            <td height="33" background="images/line_topic.gif">&nbsp;</td>
                          </tr>
                          <tr align="left" valign="top"> 
                            <td height="9"><img src="images/point.gif" width="1" height="9"></td>
                            <td><img src="images/point.gif" width="1" height="9"></td>
                          </tr>
                          <tr align="left" valign="top" bgcolor="#FFFFFF" background="images/bg_register.gif"> 
                            <td height="244" colspan="2" background="images/bg_register.gif">
							<table width="898" border="0" cellpadding="0" cellspacing="0" class="thag">
                                <tr align="left" valign="top" background="images/bg_register.gif"> 
                                  <td width="17" height="39"><img src="images/point.gif" width="17" height="1"></td>
                                  <td width="871" height="39" align="left" valign="middle" class="thabig"><img src="images/topic_hotels_details.gif" width="91" height="39"></td>
                                  <td width="10" height="39">&nbsp;</td>
                                </tr>
                                <tr align="left" valign="top" bgcolor="BFBFBF"> 
                                  <td><img src="images/point.gif" width="1" height="1"></td>
                                  <td><img src="images/point.gif" width="1" height="1"></td>
                                  <td><img src="images/point.gif" width="1" height="1"></td>
                                </tr>
                                <tr align="left" valign="top" bgcolor="#FFFFFF"> 
                                  <td height="14">&nbsp;</td>
                                  <td height="14">&nbsp;</td>
                                  <td height="14">&nbsp;</td>
                                </tr>
                                <tr align="left" valign="top" bgcolor="#FFFFFF"> 
                                  <td height="14">&nbsp;</td>
                                  <td height="14"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                      <tr align="left" valign="middle"> 
                                        <td width="52%">
										<span class="linkhotels">
										<strong><a href='search_result_sub.php?hotels_id=<?=$hotels_id?>'>
										<?=$hotels_name?>
										</a></strong></span><br> 
                                        </td>
                                        <td width="48%">
										<?php for ($i=0;$i < $hotels_star;$i++) { ?>
									  <img src="images/icon_stars.gif" width="16" height="16">
									  <? } ?></td>
                                      </tr>
                                      <tr align="left" valign="top"> 
                                        <td colspan="2"><?=$hotels_address;?></td>
                                      </tr>
                                    </table></td>
                                  <td height="14">&nbsp;</td>
                                </tr>
                                <tr align="left" valign="top" bgcolor="#FFFFFF"> 
                                  <td height="14">&nbsp;</td>
                                  <td height="14">&nbsp;</td>
                                  <td height="14">&nbsp;</td>
                                </tr>
                                <tr align="left" valign="top" bgcolor="#FFFFFF"> 
                                  <td colspan="3" bgcolor="#BFBFBF"><img src="images/point.gif" width="1" height="1"></td>
                                </tr>								
                                <tr align="left" valign="top" bgcolor="#FFFFFF"> 
                                  <td>&nbsp;</td>
                                  <td>
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
								  <SCRIPT LANGUAGE="JavaScript">
								  <!--
								  function MemberRegister(){

												FrmBooking.action = "register.php";
												FrmBooking.submit();

									}
								  //-->
								  </SCRIPT>
								  <form action='' method='post' name='FrmBooking' id="FrmBooking">	  
									  <input type="Hidden" name="hotels_id" value="<?=$hotels_id?>">
									  <input type="Hidden" name="checkin" value="<?=$checkin?>">
									  <input type="Hidden" name="checkout" value="<?=$checkout?>"> 
									  <input type="Hidden" name="thispage" value="<?=$thispage?>">
                                      <tr> 
                                        <td align="left" valign="top"><br> </td>
                                      </tr>
                                      <tr> 
                                        <td align="left" valign="top">
										<table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                            <tr> 
                                              <td colspan="2">
											  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                  <tr align="left" valign="middle"> 
                                                    <td height="15" colspan="2"><font color="081099"><strong>Booking Reservation : </strong><strong>Your 
                                                            selection : </font></td>
                                                  </tr>                                                  
                                                </table></td>
                                            </tr>
                                            <tr> 
                                              <td width="2%">&nbsp;</td>
                                              <td width="98%">&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td>&nbsp;</td>
                                              <td width="699">
											  <span class="txt_desc">** Prices Include Government Taxes and Service Charge</span>
													<table width="699" border="0" cellpadding="0" cellspacing="1" bgcolor="#BFBFBF">
													
                                                        <tr align="left" valign="middle" bgcolor="#BFBFBF" class='thag class_font_white class_bold'  style='padding:5px'> 
                                                          <td  width="30" height="18">&nbsp;</td>
                                                          <td  width="300" height="18">Period</td>
                                                          <td  width="70" height="18" align="center">Single </td>
                                                          <td  width="70" height="18" align="center">Double </td>
                                                          <td  width="70" height="18" align="center">Triple </td>
                                                          <td  width="70" height="18" align="center">Rooms </td>
                                                          <td  width="200" height="18" align="right" > &nbsp;Total  Prices&nbsp;&nbsp;</td>
                                                        </tr>														

										<?php

										
											if (is_array($_SESSION[$sessionid])){
											$db_total_allot = 0;$no=1;
											foreach ($_SESSION[$sessionid] as $k1 => $dd1){

													$list_sql = "SELECT typeroom_id,typeroom_name,typeroom_double, typeroom_triple	FROM tha_typeroom  WHERE  typeroom_id = '$k1' ";
													
													$list_query = $db->sql_query($list_sql);
													$rs_tr= $db->sql_fetchrow($list_query);
													
													$typeroomid=$rs_tr['typeroom_id'];
													$typeroom_name=$rs_tr['typeroom_name'];
													$typeroom_double=$rs_tr['typeroom_double'];
													$typeroom_triple=$rs_tr['typeroom_triple'];
													$str_type .= ":$typeroomid";
													$con_typerooms = " and typeroom_id = '$typeroomid' ";

														?>


														<tr height='20' class="thag">
														<td align="center" bgcolor="#FFFFFF"><?=$no?></td>
														<td width="" bgcolor="#FFFFFF" colspan='6'>&nbsp;<B><?=$typeroom_name?></B></td>
														</tr>
														<?php
															
														if(is_array($dd1)){
																$price_total_per_date = 0;
																foreach ($_SESSION[$sessionid][$k1] as $k2 => $dd2){
																	$session_arr = explode(":",$dd2);
																	$allotmentdate = $k2;
																	$y = substr($allotmentdate,0,4);
																	$m = substr($allotmentdate,4,2);
																	$d = substr($allotmentdate,6,4);														
																	$str_date = date("d F Y, D",mktime(0, 0, 0, $m, $d, $y));

																	$n_s = $session_arr[0];
																	$n_d = $session_arr[1];
																	$n_t = $session_arr[2];
																	$n_all = $session_arr[3];
																	$n_prices = $session_arr[4];

																	$price_total_per_date += $n_prices;

														?>
                                                        <tr align="left" valign="middle" bgcolor="#FFFFFF">
														<td height="18" width="30" align="center"></td>
														<td height="18" class="thaback2"><div style='padding:4px'><?=$str_date?></div></td>			
														<td height="18" class="thaback2" align="center"><?=$n_s?></td>
														<td height="18" class="thaback2" align="center"><?=$n_d?></td>
														<td height="18" class="thaback2" align="center"><?=$n_t?></td>
														<td height="18" align="center" class="thaback3"><?=$n_all?></td>
														<td height="18" align="right" class="thag class_total"><?=number_format($n_prices)?>&nbsp;&nbsp;THB&nbsp;&nbsp;&nbsp;</td>
                                                        </tr>
														<?php
																	}	//  end foreach
														} // end if(is_array($dd1))
														?>
															
                                                        <tr align="left" valign="middle" bgcolor="#BFBFBF">
														<td height="18" align="right" colspan='6' class="class_total" style="font-weight:bold;">
														Total&nbsp;&nbsp;
														</td>
														<td height="18" align="right" class="thag class_total" style="font-weight:bold;"><?=number_format($price_total_per_date)?>&nbsp;&nbsp;THB&nbsp;&nbsp;&nbsp;</td>
                                                        </tr>


															<?php
														$db_total_allot  +=$price_total_per_date;
														$no++;
														} // end foreach
														} // end if check array
														?>
														<tr height='20' class="thag class_total">
														<td align="right" bgcolor="#FFFFFF" colspan='6' style="font-weight:bold;">Totals&nbsp;&nbsp;
														</td>
														<td  bgcolor="#FFFFFF" align='right' style="font-weight:bold;"><?=number_format($db_total_allot)?>&nbsp;&nbsp;THB&nbsp;&nbsp;&nbsp;</td>

														</table>
                                                <br>
											  </td>
                                            </tr>
                                          </table></td>
                                      </tr>
									 <?php
									if ($_SESSION['SESSION']['clients_id']){
									//	if (true){
									 ?>
                                      <tr> 
                                        <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                            <tr align="left" valign="middle"> 
                                              <td width="100%" valign="top">
											  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                  <tr align="left" valign="middle"> 
                                                    <td height="42" colspan="4" background="images/linedetail1.gif" class="thag"><table width="871" height="41" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td width="39" height="41" rowspan="2" align="center" valign="middle" background="images/linedetail2.gif"><img src="images/point.gif" width="1" height="11"> 
                                                          </td>
                                                          <td width="794"><img src="images/point.gif" width="1" height="11"><img src="images/point.gif" width="1" height="11"></td>
                                                          <td width="38" height="41" rowspan="2" background="images/linedetail3.gif"><img src="images/point.gif" width="1" height="11"></td>
                                                        </tr>
                                                        <tr> 
                                                          <td height="32"><strong><font color="081099">Guest 
                                                            Info </font></strong></td>	
                                                        </tr>
                                                      </table></td>
                                                  </tr> 
                                                  <tr align="left" valign="middle"> 
                                                    <td width="36">&nbsp;</td>
                                                    <td width="113" height="29"></td>
													<SCRIPT LANGUAGE="JavaScript">
													<!--
													function Define_data()
													{
																FrmBooking.title.value = "<?=$c_title?>";
																FrmBooking.fname.value = "<?=$clients_fname?>";
																FrmBooking.lname.value = "<?=$clients_lname?>";
																FrmBooking.address.value = "<?=$clients_address?>";
																FrmBooking.city.value = "<?=$clients_city?>";
																FrmBooking.postal.value = "<?=$clients_postal?>";
																FrmBooking.country.value = "<?=$clients_country?>";
																FrmBooking.primarymail.value = FrmBooking.c_primarymail.value = "<?=$clients_primarymail?>";

													}
													function 	ClearData(){
															FrmBooking.title.value = FrmBooking.fname.value = FrmBooking.lname.value = FrmBooking.address.value = FrmBooking.city.value = FrmBooking.postal.value = FrmBooking.country.value = FrmBooking.primarymail.value = FrmBooking.c_primarymail.value = "";
													}
													function Frmbook(){
														
															if(FrmBooking.tele.value == ""){
																alert("Please enter 'your phone number'");
																FrmBooking.tele.focus();
																
															}
															else{														
																if(confirm("Are Your Sure with This Data ?")){
																	FrmBooking.action = "hotel_details_step2.php";
																	FrmBooking.submit();																
																}
															}
													}
													//-->
													</SCRIPT>
                                                    <td height="29" colspan="2">									
													</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td width="36">&nbsp;</td>
                                                    <td width="113" height="29"><font color="#FF0000">*</font><span class="thaback"> 
                                                      Title :</span></td>
                                                    <td height="29" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td width="10%" align="left" valign="middle"><input name="title" type="text" class="btnstyle" id="title" value=""  style="width:88px;height:18px"></td>
                                                          <td width="90%" align="left" valign="middle"></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td width="36">&nbsp;</td>
                                                    <td width="113" height="29"><font color="#FF0000">*</font><span class="thaback"> 
                                                      First Name :</span></td>
                                                    <td height="29" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td width="10%" align="left" valign="middle"><input name="fname" type="text" class="btnstyle" id="fname" value=""  style="width:320px;height:18px"></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td width="36">&nbsp;</td>
                                                    <td width="113" height="29"><font color="#FF0000">*</font><span class="thaback"> 
                                                      Last Name :</span></td>
                                                    <td  colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td width="10%" align="left" valign="middle"><input name="lname" type="text" class="btnstyle" id="lname" value=""  style="width:320px;height:18px"></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td width="36" height="0">&nbsp;</td>
                                                    <td width="113" height="0"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td height="29" align="left" valign="middle"><font color="#FF0000">* 
                                                            </font><span class="thaback">E-mail 
                                                            Address :</span></td>
                                                        </tr>
                                                      </table></td>
                                                    <td width="269" height="0"><input name="primarymail" type="text" class="btnstyle" id="primarymail" value=""  style="width:320px;height:18px"></td>
                                                    <td width="348" height="0">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td height="29"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td height="18" align="left" valign="middle"><font color="#FF0000">* 
                                                            </font><span class="thaback">Confirm 
                                                            E-mail :</span></td>
                                                        </tr>
                                                      </table></td>
                                                    <td height="29"><input name="c_primarymail" type="text" class="btnstyle" id="c_primarymail" value=""  style="width:320px;height:18px"></td>
                                                    <td height="29">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td height="29"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="5"></td>
                                                        </tr>
                                                        <tr> 
                                                          <td height="18" align="left" valign="middle"><font color="#FF0000">* 
                                                            </font><span class="thaback">Address 
                                                            :</span></td>
                                                        </tr>
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="6"></td>
                                                        </tr>
                                                      </table></td>
                                                    <td height="29"><input name="address" type="text" class="btnstyle" id="address" value=""  style="width:415px;height:18px">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td height="29"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="5"></td>
                                                        </tr>
                                                        <tr> 
                                                          <td height="18" align="left" valign="middle"><font color="#FF0000">* 
                                                            </font><span class="thaback">City 
                                                            :</span></td>
                                                        </tr>
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="6"></td>
                                                        </tr>
                                                      </table></td>
                                                    <td height="29"><input name="city" type="text" class="btnstyle" id="city" value=""  style="width:320px;height:18px"></td>
                                                    <td height="29">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td height="29"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="5"></td>
                                                        </tr>
                                                        <tr> 
                                                          <td height="18" align="left" valign="middle"><font color="#FF0000">* 
                                                            </font><span class="thaback">Country 
                                                            :</span></td>
                                                        </tr>
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="6"></td>
                                                        </tr>
                                                      </table></td>
                                                    <td height="29"><?=DropdownCountry("country", "", true, "class=\"selectstyle\"")?></td>
                                                    <td height="29">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td height="29"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="5"></td>
                                                        </tr>
                                                        <tr> 
                                                          <td height="18" align="left" valign="middle"><font color="#FF0000">* 
                                                            </font><span class="thaback">Zip 
                                                            Code :</span></td>
                                                        </tr>
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="6"></td>
                                                        </tr>
                                                      </table></td>
                                                    <td height="29"><input name="postal" type="text" class="btnstyle" id="postal" value=""  style="width:120px;height:18px"></td>
                                                    <td height="29">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td height="29"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="5"></td>
                                                        </tr>
                                                        <tr> 
                                                          <td height="18" align="left" valign="middle"><font color="#FF0000">* 
                                                            </font><span class="thaback">Telephone 
                                                            No. :</span></td>
                                                        </tr>
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="6"></td>
                                                        </tr>
                                                      </table></td>
                                                    <td height="29"><input name="tele" type="text" class="btnstyle" id="tele" value=""  style="width:320px;height:18px"></td>
                                                    <td height="29">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td height="29"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="5"></td>
                                                        </tr>
                                                        <tr> 
                                                          <td height="18" align="left" valign="middle"><font color="#FF0000"> 
                                                            &nbsp;&nbsp; </font><span class="thaback">Mobile 
                                                            :</span></td>
                                                        </tr>
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="6"></td>
                                                        </tr>
                                                      </table></td>
                                                    <td height="29"><input name="mobile" type="text" class="btnstyle" id="mobile" value=""  style="width:320px;height:18px"></td>
                                                    <td height="29">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                  </tr>
												  <SCRIPT LANGUAGE="JavaScript">
												  <!--
												  Define_data();
												  //-->
												  </SCRIPT>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td height="29" colspan="3"><table width="710" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td width="552" align="left" valign="middle"><font color="#FF0000">**</font> 
                                                            We reserve the right 
                                                            to refuse reservations 
                                                            if the personal details 
                                                            including Phone number 
                                                            are not verifiable.<font color="#FF0000">**</font> 
                                                          </td>
                                                        </tr>
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="6"></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td>&nbsp;</td>
                                                    <td height="29">&nbsp;</td>
                                                    <td height="29">&nbsp;</td>
                                                    <td height="29">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td height="43" colspan="4" background="images/linedetail1.gif"><table width="871" height="41" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td width="39" height="41" rowspan="2" align="center" valign="middle" background="images/linedetail2.gif"><img src="images/point.gif" width="1" height="11"> 
                                                          </td>
                                                          <td width="794"><img src="images/point.gif" width="1" height="11"><img src="images/point.gif" width="1" height="11"></td>
                                                          <td width="38" height="41" rowspan="2" background="images/linedetail3.gif"><img src="images/point.gif" width="1" height="11"></td>
                                                        </tr>
                                                        <tr> 
                                                          <td height="32"><strong><font color="081099">Message 
                                                            / Special Request</font></strong></td>
                                                        </tr>
                                                      </table></td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td height="0">&nbsp;</td>
                                                    <td height="0" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="thag">
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="8"></td>
                                                        </tr>
                                                        <tr> 
                                                          <td height="18" align="left" valign="middle"><font color="#FF0000"> 
                                                            <textarea name="request" class="box" id="request" style="width:440px;height:100px;scrollbar-base-color:#FFFFF;

														scrollbar-track-color:#FFFFFF;

														scrollbar-face-color:#FFFFFF;

														scrollbar-highlight-color:#FFFFF;

														scrollbar-3dlight-color:#FFFFF;

														scrollbar-darkshadow-color:#666666;

														scrollbar-shadow-color:#FFFFF;

														scrollbar-arrow-color:#666666;"></textarea><BR><BR>
                                                         <a href="javascript:ClearData();"><img src="images/clear_data_button.gif" width="88" height="27" border="0"></a></font></td>
                                                        </tr>
                                                        <tr> 
                                                          <td align="left" valign="middle"><img src="images/point.gif" width="1" height="6"></td>
                                                        </tr>
                                                      </table></td>
                                                    <td height="0">&nbsp;</td>
                                                  </tr>
                                                  <tr align="left" valign="middle"> 
                                                    <td height="0">&nbsp;</td>
                                                    <td height="0">&nbsp;</td>
                                                    <td height="0">&nbsp;</td>
                                                    <td height="0">&nbsp;</td>
                                                  </tr>
                                                </table></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                      <tr> 
                                        <td align="left" valign="top">&nbsp;</td>
                                      </tr>
									  <?php
									  }// end if
									else		{							
									  ?>
									  <SCRIPT LANGUAGE="JavaScript">
									  <!--
											function BGLogin(){
														document.getElementById('username').style.backgroundColor = "#FC8E8B";
														document.getElementById('password').style.backgroundColor = "#FC8E8B";
														document.getElementById('img_pointer').style.display = "";
														alert('Please Login Username & Password on the top of page.');
											 }
									  //-->
									  </SCRIPT>
                                      <tr> 
                                        <td align="left" valign="top">
										<table width="500" border="0" cellpadding="0" cellspacing="0" class="thag">
										<tr> 
										  <td align="left" valign="middle" class='txt_warning'>
										Please <a href="#GotoLogin" onClick="BGLogin()"><font color='#FC5C57'>Login</font></a> or <a href='javascript:MemberRegister()'><font color='#FC5C57'>Register</font></a> for to Continue Booking </td>
										</tr>
										<tr> 
										  <td align="center" valign="middle">&nbsp;</td>
										</tr>
									  </table>										
										</td>
                                      </tr>
									  <? } // end else?>
                                    </table></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr align="left" valign="top" bgcolor="#FFFFFF"> 
                                  <td colspan="3" bgcolor="BFBFBF"><img src="images/point.gif" width="1" height="1"></td>
                                </tr>
                                <tr align="left" valign="top" bgcolor="#FFFFFF"> 
                                  <td height="14" colspan="3">&nbsp;</td>
                                </tr>
                              </table></td>
                          </tr>
						  </form>
                        </table></td>
                    </tr>
                    <tr align="left" valign="top"> 
                      <td height="13">
					  <?php
					 if ($_SESSION['SESSION']['clients_id']){
					//  if (true){
					   ?>					   
					  <table width="405" border="0" cellpadding="0" cellspacing="0" class="thag">
                          <tr> 
                            <td colspan="2"><img src="images/point.gif" width="1" height="4"></td>
                          </tr>
                          <tr> 
                            <td width="141" align="right" valign="middle"><a href="javascript:Frmbook()"><img src="images/button_continue.gif" width="90" height="28" border="0"></a></td>
                            <td width="132" align="right" valign="middle"><a href="search_result.php"><img src="images/button_cancel.gif" width="76" height="28" border="0"></a></td>
                            <td width="132" align="right" valign="middle"><a href="index.php"><img src="images/button_home.gif" width="70" height="26" border="0"></a></td>
                          </tr>
                        </table>
						<?php
						}
						?>
						</td>
                    </tr>
                    <tr align="left" valign="top">
                      <td height="13">&nbsp;</td>
                    </tr>
                    <tr align="left" valign="top"> 
                      <td bgcolor="BFBFBF"><img src="images/point.gif" width="1" height="1"></td>
                    </tr>
                    <tr align="left" valign="top"> 
                      <td height="42" valign="middle"><font color="081099"><strong>Thai 
                        Hotels Association</strong></font><br> <span class="thag">294/1 Asia Buiding Floor 2
                        Phayathai Road, Rajthevee, Bangkok 10400 Thailand.   Tel: (66) 2216 9496 Fax : (66) 2216 9499  </span></td>
                    </tr>
                    <tr align="left" valign="top"> 
                      <td bgcolor="BFBFBF"><img src="images/point.gif" width="1" height="1"></td>
                    </tr>
                  </table></td>
                <td width="1" align="right" valign="top" bgcolor="BFBFBF"><img src="images/point.gif" width="1" height="1"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="left" valign="bottom">
            <?include("footer.htm");?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<map name="Map">
  <area shape="rect" coords="4,3,112,29" href="index.php">
  <area shape="rect" coords="115,2,239,29" href="index2.php">
  <area shape="rect" coords="245,3,371,30" href="directory_search.php">
</map>
</body>
</html>
