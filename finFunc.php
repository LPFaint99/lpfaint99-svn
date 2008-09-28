<?php function selected($i,$j,$s){
	if($s){
			if($s == $i){
				echo " selected=\"selected\"";
			}
		}
		else{
			if($i == $j){
				echo " selected=\"selected\"";
			}
		}
}
?>

<?php function monthdropdown($month){
	global $months;
	$j= date("m");
	echo "<select name=\"month\">\n";
	for($i=1;$i<13;$i++){
		echo "\t<option value=\"";
		if($i<10){ echo "0";}
		echo $i. "\"";
		selected($i,$j,$month);
		echo ">". $months[$i]."</option>\n";
	}
	echo  "</select>\n";
	}
?>

<?php function daydropdown($day){
	$j= date("d");
	echo "<select name=\"day\">\n";
	$i=0;
	while(++$i <32){
		echo "\t<option value=\"".$i."\"";		
		selected($i,$j,$day);		
		echo ">" .$i."</option>\n";
	}
	echo "</select>\n";
}
?>

<?php function yeardropdown($year,$len,$rlen){
	if(!$len){$len=3;}
	if(!$rlen){$rlen=1;}
	$len -= $rlen;
	$j= (int)date("Y");
	echo "<select name=\"year\">\n";
	for($i=($j-$rlen);$i < ($j+$len);$i++){
		echo "\t<option value=\"".($i + $j)."\"";
		selected($i,$j,$year);/* if($i==0){echo " selected=\"selected\" ";} */
		echo ">" .($i)."</option>\n";
	}
	echo "</select>\n";
}
?>

<?php function descriptionbox($description){
	echo "<input type=\"text\" name=\"description\" maxlength=\"10\" value=\""
		. $description . "\">\n";
	}
?>

<?php function accountdropdown($where,$which){
	global $accounts;
	echo "<select name=\"" . $where . " account\">\n";
	$i=1;
	while($accounts[$i]){
		echo "\t<option value=\"".$i."\"";
		selected($i,0,$which);
		echo ">".$accounts[$i++]."</option>\n";
	}
	echo "</select>\n";
}
?>

<?php function amountbox($amount){
	echo "<input type=\"number\" name=\"amount\""
		. " maxlength=\"6\" size=\"5\" value=\""
		. $amount . "\" showlength=\"4\">\n";
}
?>

<?php function edittrans($month, $day, $year,$description,
					$toAcc,$fromAcc,$amount){
	global $debug2;
	if($debug2){
	echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">"
		. "<table bordercolor=\"000\" border=2><tr>";
	}
	echo "<td>";
	monthdropdown($month);
	echo "</td><td>";
	daydropdown($day);
	echo "</td><td>";
	yeardropdown($year);
	echo "</td><td>";
	descriptionbox($description);
	echo "</td><td>";
	accountdropdown('from',$toAcc);
	echo "</td><td>";
	accountdropdown('to',$fromAcc);
	echo "</td><td>";
	amountbox($amount);
	echo "</td>";
}
?>

<?php function	currentAmount($one){
	global $page;
	$queryCurAmo = "SELECT current FROM accounts Where number =";
	if($one){
		$queryCurAmo .= $one;
	}else{
		$queryCurAmo .= $page;
	}
	$resultCurAmo = mysql_query($queryCurAmo)
		or die('Error in query: $queryCurAmo.' . mysql_error());
	if (mysql_num_rows($resultCurAmo) > 0){
		while($rowCurAmo = mysql_fetch_row($resultCurAmo)){
			$CurAmo = $rowCurAmo[0];
		}
	}else{
		echo '<b>Error No start found line 155</b>';
	}
	mysql_free_result($resultnum);
	
	$querySt = 'SELECT SUM( `Amount` )'
			. ' FROM `transactions` WHERE `';		
	$queryEnd =' Account` =';
	if($one){
		$queryEnd .= $one;
	}else{
		$queryEnd .= $page;
	}			
	$resultminus = mysql_query($querySt . 'From'. $queryEnd)	
		or die('Error in query: Line 128.'. mysql_error());
	$resultplus = mysql_query($querySt . 'To'. $queryEnd)
		or die('Error in query: Line 130.' . mysql_error());

	if (mysql_num_rows($resultplus) > 0){
		while($rowplus = mysql_fetch_row($resultplus)){		
			$CurAmo += $rowplus[0];

		}
	}else{echo 'error line 136';}
	
	if (mysql_num_rows($resultminus) > 0){
		while($rowminus = mysql_fetch_row($resultminus)){		
			$CurAmo -= $rowminus[0];
		}
	}else{echo 'error line 142';}
	mysql_free_result($resultplus);
	mysql_free_result($resultminus);
	
	return $CurAmo;
}
?>

<?php function negativeRed($num){
	if($num < 0){
		echo "<font color = red>";
	}
}
?>

<?php function isZero($i){
	if($i < .001 && $i < .002){
		return true;
	}
	else{
		return false;
	}
}
?>