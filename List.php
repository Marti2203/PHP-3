<?php
/*
 * List.php
 * 
 * Copyright 2017 "" <Martin@DESKTOP-2T5PNPN>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>List</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
				<link rel="stylesheet" type="text/css" href="styles.css">
	<meta name="generator" content="Geany 1.27" />
</head>

<body>
<?php
	include 'Base.php';
	
	$elements=FindAll(isset($_POST['Worker']) ? "Worker" : "User");
	
	$workerIDs;
	foreach(FindAll("Worker") as $worker) array_push($workerIDs,$worker['User_ID']);
	
	foreach($elements as $element)
	{
		if(isset($_POST $element['ID'])
			foreach($element as $key => $value)
			if($key!='IsAdministrator' && !is_numeric($key)  && strpos($key,"ID")===false)
			echo $key."=>".$value."<br>";
			echo "Secret Question=>".Find($element['SecretQuestion_ID'],"SecretQuestion")[0]["Text"]."<br><br>";
			
						
			foreach(FindAllFiltered("CarOwnership","User_ID=".(isset($_POST['Worker']) ? $element['User_ID'] : $element['ID']),array()) as $ownership){
			foreach(Find($ownership['Car_ID'],"Car")[0] as $key=>$value)
			if(!is_numeric($key) && strpos($key,"ID")===false)
			echo $key."=>".$value."<br>"; print "<br>";}
			
			echo "<img src=\"".$pictures.$element['PictureName']."\"alt=Error>
				<form method=\"post\" action=\"Edit.php\">
				<input type=\"hidden\" name=\"User_ID\" value=\"" . (isset($_POST['Worker']) ? $element['User_ID'] : $element['ID']) . "\"> "; 
			
			
			if(isset($_POST['Worker']))
			print "<input type=\"hidden\" name=\"Worker_ID\" value=\"" . $element['ID'] . "\">
				   <input type=\"hidden\" name=\"Worker\" value=\"Worker\"/>";
				   
			print "<input type=\"submit\" class=\"button\" value=\"Edit\"/> </form>";
			
			if(isset($_POST['Worker']))
			print"<form method=\"post\" action=\"Comment.php\">
				<input type=\"hidden\" name=\"User_ID\" value=\"" .$element['User_ID']. "\">
				<input type=\"hidden\" name=\"Worker_ID\" value=\"" .$element['ID']. "\">
				<input type=\"hidden\" name=\"Worker\" value=\"Worker\"/>
				<input type=\"submit\" class=\"button\" name=\"Comment Worker\" id=\"Comment Worker\" value=\"Comment Worker\">
				</form>";
			
			print "<br><br><br>";
	}
	?>
</body>

</html>
