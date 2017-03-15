<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$objConnect = mysqli_connect("localhost",'thaihotels','Thahr30','thaihotels_tel');
//$objDB = mysql_select_db("thaihotels_tel");
//mysql_query("SET NAMES UTF8");

$resultArray = array();

$objQuery = mysqli_query($objConnect,"Select DISTINCT group1 From email Order By group1");
while($row = mysqli_fetch_array($objQuery)){
    $tmp = array();
    $tmp["group1"] = $row["group1"];
    //$tmp["prov_name"] = $row["prov_name"];
    array_push($resultArray,$tmp);
}

mysqli_close($objConnect);
	//$pid = $_POST['order_id'];
	//$name = $_POST['foods_code'];
	//$price = $_POST['price'];
	//$description = $_POST['description'];
	//$conn->getArea();
header('Content-Type: application/json');
echo json_encode($resultArray);
?>