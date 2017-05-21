<?php
/*
 * Register.php
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
	<title>Register</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
				<link rel="stylesheet" type="text/css" href="styles.css">
	<meta name="generator" content="Geany 1.27" />
</head>

<body>
	<?php 
	include 'Base.php';
	
	$errors=array();

	$type=isset($_POST['Worker']) ? "Worker": "User";
	
	ErrorCheck($errors,$type);
	
	if(count($errors)==0){
		
		if (move_uploaded_file($_FILES["Profile_Picture"]["tmp_name"], $pictures.basename($_FILES["Profile_Picture"]["name"]))){		
			
			$admin;
			if(isset($_POST['Worker']) || !in_array($_POST['firstName'].$_POST['familyName'],$names)) $admin= 0;
			else $admin=1;
			
			Execute($insertUser,
			array(":firstName"=>$_POST['firstName'],
				  ":familyName"=>$_POST['familyName'],
				  ":age"=>$_POST['age'], 
				  ":sex"=>$_POST['sex'],
				  ":email"=>$_POST['email'], 
				  ":secondEmail"=>$_POST['secondEmail'],
				  ":securityAnswer"=>sha1($_POST['securityA']),
				  ":password"=>sha1($_POST['password']),
				  ":pictureName"=>	$_FILES['Profile_Picture']["name"],
				  ":isAdministrator"=>$admin,
				  ":secretQuestion_ID"=>$_POST['securityQ']));
				  
				  
				  $userID=FindAllFiltered("User","FirstName=:firstName AND FamilyName=:familyName ",
									array(":firstName"=>$_POST['firstName'],":familyName"=>$_POST['familyName']))[0]['ID'];
				  
				  InsertCars(unserialize(base64_decode($_POST['cars'])),$userID);
				
				if(isset($_POST['Worker'])){
				if($userID!=null)
				Execute($insertWorker,array(":profession"=>$_POST['profession'],
										":paymentPerHour"=>ToDecimal($_POST['paymentPerHour']),
										":user_ID"=>$userID));		
				}
							
			print "The file ". basename($_FILES["Profile_Picture"]["name"]). " has been uploaded. And the worker has been created successfully.";
		}
		else
		{
			print 'Sorry, the file was not moved. The worker/user is not created';
			unlink($pictures.basename($_FILES["Profile_Picture"]["name"]));
		}
	}
	else for($x = 0; $x < count($errors); $x++) echo $errors[$x]."<br>";
	sleep(10);
	header("Location:index.php");
	?>
</body> 

</html>
