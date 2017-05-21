<?php
/*
 * SignIn.php
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
if(isset($_POST['Sign_in_Worker'])){
			
			$worker=Login("Worker",$_POST['firstName'],$_POST['familyName'],sha1($_POST['password']));
			$found=false;
			
			if($worker!=null)
			{
				foreach(FindAllFiltered("Comment","User_ID=".$worker['User_ID']) as $comment){
					$replies=FindAllFiltered("Reply","Comment_ID=".$comment['ID']);			
					print $comment['Text']."<br>";
					foreach($replies as $reply)
					print $reply['Text']."<br>";
					
					print
					"<form method=\"post\" action=\"Reply.php\">
					<input type=\"hidden\" name=\"Comment_ID\" value=\"".$comment['ID']."\">
					<input type=\"submit\" class=\"button\" name=\"Reply Worker\" id=\"Reply\" value=\"Reply\"/ >
					</form><br><br><br>";
					}
					
				$found=true;
			}
			
	if(!$found) print 'Worker not found. Wrong password or name.';
}
if(isset($_POST['Sign_in_User'])){
			$user=Login("User",$_POST['firstName'],$_POST['familyName'],sha1($_POST['password']));
			if($user!=null)
			{
				PrintTexts($user['ID']);	
				print "<form method=\"post\" action=\"SetText.php\">
				<textarea rows=\"5\" cols=\"10\" name=\"Text\"> </textarea>
				<input type=\"hidden\" name=\"ID\" value=\"" .$user['ID']. "\">
				<input type=\"submit\" class=\"button\" name=\"Set Text\" id=\"Update\" value=\"Set Text\"/ >
				</form>";
				$found=true;
				
				if($user['IsAdministrator']!=0)
				print "<form method=\"post\" action=\"List.php\"> <input type=\"submit\" class=\"button\" value=\"Check Users\"> </form>";
			}
			else print 'USER not found. Wrong password or name.';
}
?>
</body>

</html>
