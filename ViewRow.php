<?php
/*
 * ViewRow.php
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
	<meta name="generator" content="Geany 1.27" />
</head>

<body>
	<form method=\"get\" action="ViewRow.php">
	<label for="Table" class=\"label\">Table</label>
	<input type="text" name="Table" id=\"Table\" autocomplete=\"off\" value=""/>
	<input type="submit" value="Load"/>
	</form>
	<?php

	include 'DB.php';
	if(isset($_GET['Table']))
	{
		print "<table style=\"width:100%\">";
		$result=FindAll($_GET['Table']);
		
		if(count($result)===0){print "Empty Table"; die;}
		
		$notAdmin=function($key,$value){return  ;};
		
		PrintRow($result[0],$getKey,$notAdmin);
		
		foreach($result as $row)
		{
			print "<tr>";
			foreach($data as $key=>$value)
			if(!is_numeric($key) && strpos($key,"ID")===false && $key!="IsAdministrator")
			print "<th>".$dataFunction($key,$value)."</th>";
			print"</tr>";
			}
		
		print "</table>";
	}
	
	?>
</body>

</html>
