<?php
/*
 * Update.php
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
	<title>Update</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.27" />
</head>

<body>
	<?php
	include 'Base.php';
	$targetPosition=$pictures.basename($_FILES["Profile_Picture"]["name"]);

	$isWorker=isset($_POST['Worker']);
	$element;

	if($isWorker===true) $element=Find($_POST['Worker_ID'],"Worker")[0];
	else $element=Find($_POST['User_ID'],"User")[0];

			if(sha1($_POST['passwordOld'])!=$element['Password']){
				print 'Passwords do not match, update unsuccessful.';
				sleep(10);
				header("Location:index.php");
			}

			if(sha1($_POST['securityAOld'])!=$element['SecurityAnswer'])
			{
				print 'Secret Answers do not match, update unsuccessful.';
				sleep(10);
				header("Location:index.php");
			}

			$element['Password']=sha1($_POST['passwordNew']);
			$element['SecurityAnswer']=sha1($_POST['securityA']);
			$element['Age']=$_POST['age'];

			$cars=unserialize(base64_decode($_POST['cars']));
			$ids=unserialize(base64_decode($_POST['Car_IDs']));

			foreach($cars as $car)
			if($car->ID==-1)
			InsertCar($car,$element['ID']);

			print "<br><br>";
			
			if($ids!=null)
			foreach($ids as $id)
			RemoveOwnership($id,$element['ID']);

			if(isset($_POST['Worker'])){
			$element['Profession']=$_POST['profession'];
			$element['PaymentPerHour']=$_POST['paymentPerHour'];
			}

			if(uploadValid($_FILES["Profile_Picture"])){
				if (move_uploaded_file($_FILES["Profile_Picture"]["tmp_name"], $targetPosition)){
					$element['PictureName']=$_FILES['Profile_Picture']["name"];
					print "The file ". basename($_FILES["Profile_Picture"]["name"]). " has been uploaded. And the user has been updated successfully.";
				}
				else
				{
					print 'Sorry, the file was not moved. The worker picture is not updated';
					unlink($targetPosition);
				}
			}
			else print 'Sorry, there was an error uploading your file or you have not uploaded a file. The worker picture is not updated.';

	if(isset($_POST['Worker']))
		UpdateWorker($element,$_POST['User_ID'],$_POST['Worker_ID']);
	else UpdateUser($element,$_POST['User_ID']);
	sleep(10);
	header("Location:index.php");
	?>
</body>

</html>
