<?php
/*
 * Comment.php
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
	<title>untitled</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
					<link rel="stylesheet" type="text/css" href="styles.css">
	<meta name="generator" content="Geany 1.27" />
</head>

<body>
	<?php 
	include 'Base.php';
if(isset($_POST['Comment_Worker']))
{
	PrintComments($_POST['Worker_UserID']);
	
		print
					"<form method=\"post\" action=\"Comment.php\">
					<input type=\"hidden\" name=\"WorkerID\" value=\"" .$_POST['WorkerID']. "\">
					<input type=\"hidden\" name=\"Worker_UserID\" value=\"" .$_POST['Worker_UserID']. "\">
					<input type=\"radio\" name=\"approval\" value=\"2\"> Disapprove<br>
					<input type=\"radio\" name=\"approval\" value=\"1\">Approve<br>
					<input type=\"radio\" name=\"approval\" value=\"0\" checked>Neutral<br>
					<textarea rows=\"5\" cols=\"10\" name=\"Text\"> </textarea>
					<input type=\"submit\" class=\"button\" name=\"Comment\" id=\"Comment\" value=\"Comment\"/ > 		
									<label for=\"firstName\" class=\"label\">First Name</label>
					<input type=\"text\" name=\"firstName\">
									<label for=\"familyName\" class=\"label\">Family Name</label>
					<input type=\"text\" name=\"familyName\">
									<label for=\"password\" class=\"label\">Password</label>
					<input type=\"password\" name=\"password\">

					</form><br><br>"; 
} 
if(isset($_POST['Comment']))
{
	$user=Login("User",$_POST['firstName'],$_POST['familyName'],sha1($_POST['password']));
	if($user!=null){print "USER DOES NOT EXIST"; die;}
	Execute($insertComment,array(":text"=>$_POST['Text'],":user_ID"=>$user['ID']
								,":workMan_ID"=>$_POST['WorkerID'],":workMan_User_ID"=>$_POST['Worker_UserID']
								,":approvalType_ID"=>$_POST['approval']));
}
	?>
</body>

</html>
