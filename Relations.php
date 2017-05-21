<?php
/*
 * Relations.php
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
	<form method=\"get\" action="Relations.php">
	<label for="Table" class=\"label\">Table</label>
	<input type="text" name="Table" id=\"Table\" autocomplete=\"off\" value=""/>
	<input type="submit" value="Load"/>
	</form>
	<?php

	include 'DB.php';
	if(isset($_GET['Table']))
	{
		
		
		$closure= function(){				
		$foreignInformation=FetchAll("SELECT `TABLE_NAME`, `COLUMN_NAME`,`REFERENCED_TABLE_NAME`,`REFERENCED_COLUMN_NAME`                 
		FROM `INFORMATION_SCHEMA`.`KEY_COLUMN_USAGE`  
		WHERE `TABLE_SCHEMA` = Schema() AND `REFERENCED_TABLE_NAME` IS NOT NULL;");
		
		$primaryInformation=FetchAll("EXPLAIN ". $_GET['Table']);
		
		return function($key,$value) use ($foreignInformation,$primaryInformation)
		{
			$result=$key;
			foreach($primaryInformation as $row)
			if($row['Field']===$key)
			if($row['Key']==="PRI")
			$result=$result."--- PRIMARY KEY";
			
			foreach($foreignInformation as $row)
				if($row['TABLE_NAME']===$_GET['Table'])
				if($row['COLUMN_NAME']===$key)
				$result= $result."--- FOREIGN KEY FOR ".$row["REFERENCED_TABLE_NAME"].".".$row["REFERENCED_COLUMN_NAME"];
				return $result;			
		};};
		
		print "<table style=\"width:100%\">";
		$result=FindAll($_GET['Table']);
		
		if(count($result)===0){print "Empty Table"; die;}
		
		$notAdmin=function($key,$value){return  $key!="IsAdministrator";};
		
		PrintRow($result[0],$closure(),$notAdmin,true);
		
		foreach($result as $row)
		PrintRow($row,$getValue,$notAdmin,true);
		
		print "</table>";
	
	
		}
	
	?>
</body>

</html>
