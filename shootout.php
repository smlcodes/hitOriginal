<?php
include 'sessionCheck.php';
error_reporting ( 0 );
include 'db.php';
include 'balance.php';
session_start ();

$a_cent = 0;
$a_bud = 0;
$a_coll = 0;
$rel_cent = 0;
$a1_cent = 0;
$a2_cent = 0;
$a3_cent = 0;
$a4_cent = 0;
$a5_cent = 0;
$a6_cent = 0;
$wk1_cent = 0;
$wk2_cent = 0;
$d25_cent = 0;
$d50_cent = 0;
$d75_cent = 0;
$d100_cent = 0;
$d125_cent = 0;
$d150_cent = 0;
$d175_cent = 0;
$d200_cent = 0;
$d250_cent = 0;
$d300_cent = 0;
$d350_cent = 0;
$d365_cent = 0;
$d400_cent = 0;
$d450_cent = 0;
$d500_cent = 0;
$d600_cent = 0;
$wk1_coll = 0;
$wk2_coll = 0;
$d25_coll = 0;
$d50_coll = 0;
$d75_coll = 0;
$d100_coll = 0;
$d125_coll = 0;
$d150_coll = 0;
$d175_coll = 0;
$d200_coll = 0;
$d250_coll = 0;
$d300_coll = 0;
$d350_coll = 0;
$d365_coll = 0;
$d400_coll = 0;
$d450_coll = 0;
$d500_coll = 0;
$d600_coll = 0;
$max_days = 0;
$max_coll = 0;
$hit = '';
static $count=0;
// ========all ID's ============
$aid = 0;
$acid = 0;
$did = 0;
$wid = 0;
$mid = 0;
$eid = 0;
$cid = 0;

$a2 = 0;
$a3 = 0;
$ac2 = 0;
$ac3 = 0;
$d2 = 0;
$d3 = 0;
$m2 = 0;
$m3 = 0;
$w2 = 0;
$w3 = 0;

$sid = $_GET ["rid"];
$uid = $_SESSION ['s_uid'];
$s_bal = $_SESSION ['s_bal'];
$ratesum = 0;

$budget = 0;

echo $sid . '  --    ' . $uid;
for($x = 1; $x <= 9; $x ++) {
	$z = 0;
	
	$tab = 's' . $x;
	echo 'Tab ---> ' . $tab;
	$sa = $tab . '_a_rate';
	$sb = $tab . '_b_rate';
	$sc = $tab . '_c_rate';
	
	$sql = "select * from tolly_" . $tab . " r WHERE r.uid = " . $uid . " and r.sid = " . $sid;
	echo $sql;
	$result = mysqli_query ( $conn, $sql );
	if (mysqli_num_rows ( $result ) > 0) {
		$row = mysqli_fetch_assoc ( $result );
		
		$a = $row [$sa];
		$b = $row [$sb];
		$c = $row [$sc];
		
		if ($a > $b && $a > $c) {
			$z = $a;
		} elseif ($b > $c) {
			$z = $b;
		} else {
			$z = $c;
		}
		
		$sql2 = "UPDATE tolly_" . $tab . " r  SET r." . $tab . "_best=" . $z . " WHERE  r.uid = " . $uid . " and r.sid = " . $sid;
		echo $sql2;
		mysqli_query ( $conn, $sql2 );
	} // IF END
	$ratesum = $ratesum + $z;
} // For Loop END
$rateavg = number_format ( ( float ) ((($ratesum / 9)) / 2), 2, '.', '' );
$ratefinal = $rateavg;
echo 'rating SUM ' . $ratesum . ' ---->  FINAL RATING : ' . $rateavg;

$point = 0;

if ((1.25 > $rateavg)) {
	$point = -1.5;
} elseif ((1.25 <= $rateavg) && ($rateavg < 2.0)) {
	$point = -1;
} elseif ((2.0 <= $rateavg) && ($rateavg < 2.5)) {
	$point = -0.5;
} elseif ((2.5 <= $rateavg) && ($rateavg < 2.85)) {
	$point = -0.2;
} elseif ((2.85 <= $rateavg) && ($rateavg < 3.25)) {
	$point = -0.1;
} elseif ((3.25 <= $rateavg) && ($rateavg < 3.5)) {
	$point = 0;
} elseif ((3.5 <= $rateavg) && ($rateavg < 3.75)) {
	$point = 0.1;
} elseif ((3.75 <= $rateavg) && ($rateavg < 4.0)) {
	$point = 0.2;
} elseif ((4.0 <= $rateavg) && ($rateavg < 4.5)) {
	$point = 0.3;
} elseif ($rateavg >= 4.5) {
	$point = 0.4;
} else {
	$point = 0;
}

// Calculate The Avergaes
$crate = 0;
$sql = "SELECT * FROM tolly_ready_for_shoot r WHERE   r.uid = " . $uid . " and r.rid = " . $sid;
$result = mysqli_query ( $conn, $sql );
if (mysqli_num_rows ( $result ) > 0) {
	
	$row = mysqli_fetch_assoc ( $result );
	$aid = $row ["aid"];
	$acid = $row ["acid"];
	$did = $row ["did"];
	$wid = $row ["wid"];
	$mid = $row ["mid"];
	$eid = $row ["eid"];
	$cid = $row ["cid"];
	$budget = $row ["sofar"];
	$rid = $row ["rid"];
	$title = $row ["title"];
	
	$sofar = $row ["sofar"];
	$dname = $row ["dname"];
	$aname = $row ["aname"];
	$acname = $row ["acname"];
	
	
	
	$a2 = $row ["a2"];
	$a3 = $row ["a3"];
	$ac2 = $row ["ac2"];
	$ac3 = $row ["ac3"];
	$d2 = $row ["d2"];
	$d3 = $row ["d3"];
	$m2 = $row ["m2"];
	$m3 = $row ["m3"];
	$w2 = $row ["w2"];
	$w3 = $row ["w3"];
	

	//===========================================================     ACTOR ==================================================
	$sql3 = "SELECT a.actor_rating,a.actor_rate FROM tolly_actor a WHERE  a.actor_id = " . $aid;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["actor_rating"];
	$rem =  $row1 ["actor_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
	if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_actor` SET `actor_rate`=".$rem.", `actor_rating`=".$ratt." WHERE  `actor_id`=". $aid;
	mysqli_query ( $conn, $sql3 );
	$count++;
	//===========================================================     ACTOR ==================================================


	//===========================================================     actress1 ==================================================
	$sql3 = "SELECT a.actress_rating,a.actress_rate FROM tolly_actress a WHERE  a.actress_id = " . $acid;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["actress_rating"];
	$rem =  $row1 ["actress_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
	if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_actress` SET `actress_rate`=".$rem.", `actress_rating`=".$ratt." WHERE  `actress_id`=". $acid;
	mysqli_query ( $conn, $sql3 );
	$count++;
	//===========================================================     actress1 ==================================================
   
	//===========================================================     director1 ==================================================
	$sql3 = "SELECT a.director_rating,a.director_rate FROM tolly_director a WHERE  a.director_id = " . $did;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	echo " <br> DIRECTOR  ==============> ".$sql3;
	$ratt = $row1 ["director_rating"];
	$rem =  $row1 ["director_rate"];
	echo "Rate  ==============> ".$ratt;
	echo "Rrem  ==============> ".$rem;
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_director` SET `director_rate`=".$rem.", `director_rating`=".$ratt." WHERE  `director_id`=". $did;
	mysqli_query ( $conn, $sql3 );
	$count++;
	//===========================================================     director1 ==================================================
	
	//===========================================================     writer1 ==================================================
	$sql3 = "SELECT a.writer_rating,a.writer_rate FROM tolly_writer a WHERE  a.writer_id = " . $wid;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["writer_rating"];
	$rem =  $row1 ["writer_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_writer` SET `writer_rate`=".$rem.", `writer_rating`=".$ratt." WHERE  `writer_id`=". $wid;
	mysqli_query ( $conn, $sql3 );
	$count++;
	//===========================================================     writer1 ==================================================
	

	//===========================================================     music1 ==================================================
	$sql3 = "SELECT a.music_rating,a.music_rate FROM tolly_music a WHERE  a.music_id = " . $mid;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["music_rating"];
	$rem =  $row1 ["music_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_music` SET `music_rate`=".$rem.", `music_rating`=".$ratt." WHERE  `music_id`=". $mid;
	mysqli_query ( $conn, $sql3 );
	$count++;
	//===========================================================     music1 ==================================================

	
	
	
//===========================================================     cine1 ==================================================
	$sql3 = "SELECT a.cine_rating,a.cine_rate FROM tolly_cine a WHERE  a.cine_id = " . $cid;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["cine_rating"];
	$rem =  $row1 ["cine_rate"];
	
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_cine` SET `cine_rate`=".$rem.", `cine_rating`=".$ratt." WHERE  `cine_id`=". $cid;
	echo "CINE  ==============> ".$sql3;
	mysqli_query ( $conn, $sql3 );
	$count++;
	//===========================================================     cine1 ==================================================
	
	
	
//===========================================================     editor1 ==================================================
	$sql3 = "SELECT a.editor_rating,a.editor_rate FROM tolly_editor a WHERE  a.editor_id = " . $eid;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["editor_rating"];
	$rem =  $row1 ["editor_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_editor` SET `editor_rate`=".$rem.", `editor_rating`=".$ratt." WHERE  `editor_id`=". $eid;
	mysqli_query ( $conn, $sql3 );
	$count++;
	//===========================================================     editor1 ==================================================
	
	
	

	//===========================================================     actress2 ==================================================
		if($ac2>0)
	{$sql3 = "SELECT a.actress_rating,a.actress_rate FROM tolly_actress a WHERE  a.actress_id = " . $ac2;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["actress_rating"];
	$rem =  $row1 ["actress_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
		if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_actress` SET `actress_rate`=".$rem.", `actress_rating`=".$ratt." WHERE  `actress_id`=". $ac2;
	mysqli_query ( $conn, $sql3 );
		$count++;
		}
	//===========================================================     actress2 ==================================================

	//===========================================================     actress3 ==================================================
		if($ac3>0)
	{$sql3 = "SELECT a.actress_rating,a.actress_rate FROM tolly_actress a WHERE  a.actress_id = " . $ac3;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["actress_rating"];
	$rem =  $row1 ["actress_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
		if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_actress` SET `actress_rate`=".$rem.", `actress_rating`=".$ratt." WHERE  `actress_id`=". $ac3;
	mysqli_query ( $conn, $sql3 );
		$count++;
		}
	//===========================================================     actress3 ==================================================
	//===========================================================     music2 ==================================================
		if($m2>0)
	{$sql3 = "SELECT a.music_rating,a.music_rate FROM tolly_music a WHERE  a.music_id = " . $m2;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["music_rating"];
	$rem =  $row1 ["music_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
		if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_music` SET `music_rate`=".$rem.", `music_rating`=".$ratt." WHERE  `music_id`=". $m2;
	mysqli_query ( $conn, $sql3 );
		$count++;
		}
	//===========================================================     music2 ==================================================
	//===========================================================     music3 ==================================================
		if($m3>0)
	{$sql3 = "SELECT a.music_rating,a.music_rate FROM tolly_music a WHERE  a.music_id = " . $m3;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["music_rating"];
	$rem =  $row1 ["music_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
		if($rem<100000)
	{	
		$rem = 150000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_music` SET `music_rate`=".$rem.", `music_rating`=".$ratt." WHERE  `music_id`=". $m3;
	mysqli_query ( $conn, $sql3 );
		$count++;
		}
	//===========================================================     music3 ==================================================
	//===========================================================     writer2 ==================================================
		if($w2>0)
	{$sql3 = "SELECT a.writer_rating,a.writer_rate FROM tolly_writer a WHERE  a.writer_id = " . $w2;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["writer_rating"];
	$rem =  $row1 ["writer_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
		if($rem<100000)
	{	
		$rem = 70000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_writer` SET `writer_rate`=".$rem.", `writer_rating`=".$ratt." WHERE  `writer_id`=". $w2;
	mysqli_query ( $conn, $sql3 );
		$count++;
		}
	//===========================================================     writer2 ==================================================
	//===========================================================     writer3 ==================================================
		if($w3>0)
	{$sql3 = "SELECT a.writer_rating,a.writer_rate FROM tolly_writer a WHERE  a.writer_id = " . $w3;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["writer_rating"];
	$rem =  $row1 ["writer_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
				if($rem<100000)
	{	
		$rem = 70000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_writer` SET `writer_rate`=".$rem.", `writer_rating`=".$ratt." WHERE  `writer_id`=". $w3;
	mysqli_query ( $conn, $sql3 );
		$count++;
		}
	//===========================================================     writer3 ==================================================
	//===========================================================     director2 ==================================================
		if($d2>0)
	{$sql3 = "SELECT a.director_rating,a.director_rate FROM tolly_director a WHERE  a.director_id = " . $d2;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["director_rating"];
	$rem =  $row1 ["director_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
				if($rem<100000)
	{	
		$rem = 70000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_director` SET `director_rate`=".$rem.", `director_rating`=".$ratt." WHERE  `director_id`=". $d2;
	mysqli_query ( $conn, $sql3 );
		$count++;
		}
	//===========================================================     director2 ==================================================
	//===========================================================     director3 ==================================================
		if($d3>0)
	{$sql3 = "SELECT a.director_rating,a.director_rate FROM tolly_director a WHERE  a.director_id = " . $d3;
	$r1 = mysqli_query ( $conn, $sql3 );
	$row1 = mysqli_fetch_assoc ( $r1 );
	$ratt = $row1 ["director_rating"];
	$rem =  $row1 ["director_rate"];
	$crate = $crate +$ratt;
	$rem = $rem+($point*1000000);
				if($rem<100000)
	{	
		$rem = 70000;
	}
	if($ratt>9.9)
	{
		$ratt=10;
	}
	$ratt = $ratt+$point;
	$sql3="UPDATE `tolly_director` SET `director_rate`=".$rem.", `director_rating`=".$ratt." WHERE  `director_id`=". $d3;
	mysqli_query ( $conn, $sql3 );
		$count++;
		}
	//===========================================================     director3 ==================================================
	
	
	
	
	echo "\n ============================= CRATE ================================";	
	echo "\n ========> ".$crate;	
	echo "\n ========> ".$count;
	
	
	
	$crate = $crate / $count;
	echo "<br>CREW -----   >  " . $crate;
}//if end

$x1 = mt_rand ( 1 * 10, 10 * 10 ) / 30;

$rateavg = number_format ( ( float ) ((($rateavg * 9) + ($crate *3)+$x1) / 19.35), 2, '.', '' );



//$rateavg = number_format ( ( float ) ( ($rateavg+$crate)/3), 2, '.', '' );

// $rateavg =0.78;
$result = 'ok';

if ((1.25 > $rateavg)) {
	$result = 'DISASTER';
} elseif ((1.25 <= $rateavg) && ($rateavg < 2.0)) {
	$result = 'UTTER FLOP';
} elseif ((2.0 <= $rateavg) && ($rateavg < 2.5)) {
	$result = 'FLOP';
} elseif ((2.5 <= $rateavg) && ($rateavg < 2.85)) {
	$result = 'BELOW AVERAGE';
} elseif ((2.85 <= $rateavg) && ($rateavg < 3.25)) {
	$result = 'AVERAGE';
} elseif ((3.25 <= $rateavg) && ($rateavg < 3.5)) {
	$result = 'ABOVE AVERAGE';
} elseif ((3.5 <= $rateavg) && ($rateavg < 3.75)) {
	$result = 'HIT';
} elseif ((3.75 <= $rateavg) && ($rateavg < 4.0)) {
	$result = 'SUPER HIT';
} elseif ((4.0 <= $rateavg) && ($rateavg < 4.5)) {
	$result = 'BLOCKBUSTER';
} elseif ($rateavg >= 4.5) {
	$result = 'INDUSTRY HIT';
} else {
	$result = 'AVERAGE';
}

$hit = $result;

// ============================= EXPECTING RELEASE CENTERS ===========================================
if ((10000000 > $budget)) {
	$rel_cent = rand ( 50, 75 );
} elseif ((10000000 <= $budget) && ($budget < 30000000)) {
	$rel_cent = rand ( 70, 125 );
} elseif ((30000000 <= $budget) && ($budget < 50000000)) {
	$rel_cent = rand ( 125, 180 );
} elseif ((50000000 <= $budget) && ($budget < 80000000)) {
	$rel_cent = rand ( 200, 250 );
} elseif ((80000000 <= $budget) && ($budget < 120000000)) {
	$rel_cent = rand ( 250, 330 );
} elseif ((120000000 <= $budget) && ($budget < 150000000)) {
	$rel_cent = rand ( 300, 400 );
} elseif ((150000000 <= $budget) && ($budget < 200000000)) {
	$rel_cent = rand ( 400, 600 );
} elseif ((200000000 <= $budget) && ($budget < 300000000)) {
	$rel_cent = rand ( 500, 800 );
} elseif ((300000000 <= $budget) && ($budget < 400000000)) {
	$rel_cent = rand ( 800, 1100 );
} elseif ((400000000 <= $budget) && ($budget < 500000000)) {
	$rel_cent = rand ( 1000, 1200 );
} elseif ((500000000 <= $budget) && ($budget < 600000000)) {
	$rel_cent = rand ( 1200, 1500 );
} elseif ((600000000 <= $budget) && ($budget < 750000000)) {
	$rel_cent = rand ( 1500, 2000 );
} elseif ((750000000 <= $budget) && ($budget < 900000000)) {
	$rel_cent = rand ( 2000, 2500 );
} elseif ((900000000 <= $budget) && ($budget < 1100000000)) {
	$rel_cent = rand ( 2500, 3000 );
} elseif ((1100000000 <= $budget) && ($budget < 1500000000)) {
	$rel_cent = rand ( 3000, 3500 );
} elseif (($budget > 1500000000)) {
	$rel_cent = rand ( 3300, 3800 );
} else {
	$rel_cent = rand ( 200, 500 );
}

centers ( $rateavg, $rel_cent );
function centers($rateavg, $rel_cent) {
	
	// ******************** CENTER STARTS *******************
	global $rel_cent, $rateavg, $result;
	// $rel_cent = 3000;
	// $rateavg =0.88;
	
	global $wk1_cent, $wk2_cent, $d25_cent, $d50_cent, $d75_cent, $d100_cent, $d125_cent, $d150_cent, $d175_cent, $d200_cent, $d250_cent, $d300_cent, $d350_cent, $d365_cent, $d400_cent, $d450_cent, $d500_cent, $d600_cent, $wk1_coll, $wk2_coll, $d25_coll, $d50_coll, $d75_coll, $d100_coll, $d125_coll, $d150_coll, $d175_coll, $d200_coll, $d250_coll, $d300_coll, $d350_coll, $d365_coll, $d400_coll, $d450_coll, $d500_coll, $d600_coll, $max_days, $max_coll;
	echo '--------> centers RATING = ' . $rateavg . '  ---CENTERS  = ' . $rel_cent;
	
	if ((1.25 > $rateavg)) // DISASTER
{
		$wk1_cent = round ( (($rel_cent / 8.5) + ($rel_cent / 8.4) + ($rel_cent / 7.75)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 9.5) + ($wk1_cent / 3.25)) / 2 );
		
		$d25_cent = round ( (($wk2_cent / 9.8) + ($wk2_cent / 7)) / 2 );
		$d50_cent = round ( (($d25_cent / 16) + ($d25_cent / 8)) / 2 );
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 425, 499 );
		}
		
		if ($d50_cent > 0) {
			$d50_cent = 0;
		}
		
		$d75_cent = round ( (($d50_cent / 19.5) + ($d50_cent / 8)) / 2 );
		$d100_cent = round ( (($d75_cent / 11.2) + ($d75_cent / 9.75)) / 2 );
		
		$d125_cent = round ( (($d100_cent / 18.35) + ($d100_cent / 5.75)) / 2 );
		$d150_cent = round ( (($d125_cent / 17.7) + ($d125_cent / 5.75)) / 2 );
		$d175_cent = round ( (($d150_cent / 18.8) + ($d150_cent / 5.75)) / 2 );
		$d200_cent = round ( (($d175_cent / 19.9) + ($d175_cent / 7)) / 2 );
		
		$d250_cent = round ( (($d200_cent / 17.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = round ( (($d250_cent / 16) + ($d250_cent / 5.75)) / 2 );
		$d350_cent = round ( (($d300_cent / 17) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 17) + ($d350_cent / 7)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 16) + ($d365_cent / 5.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 17) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 17) + ($d450_cent / 7)) / 2 );
		$d600_cent = round ( (($d500_cent / 17) + ($d500_cent / 7)) / 2 );
		
		// *******************DISATSTER -- COLLECTIONS********* COLLECTIONS **********************
		$wk1_coll = ($wk1_coll * rand ( 20000, 30000 ) * 7);
		$wk2_coll = $wk2_cent * rand ( 10000, 16000 ) * 7;
		$d25_coll = $d25_cent * rand ( 5000, 7600 ) * 25;
		$d50_coll = $d50_cent * rand ( 1000, 3000 ) * 25;
		$d75_coll = $d75_cent * rand ( 1000, 7000 ) * 25;
		$d100_coll = $d100_cent * rand ( 900, 1500 ) * 25;
		$d125_coll = $d125_cent * rand ( 400, 1100 ) * 25;
		$d150_coll = $d150_cent * rand ( 500, 800 ) * 25;
		$d175_coll = $d175_cent * rand ( 100, 500 ) * 25;
		$d200_coll = $d200_cent * rand ( 100, 400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} elseif ((1.25 <= $rateavg) && ($rateavg < 2.0)) // Utter Flop
{
		
		$wk1_cent = round ( (($rel_cent / 5.5) + ($rel_cent / 4.4) + ($rel_cent / 2.75)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 5.5) + ($wk1_cent / 3.25)) / 2 );
		
		$d25_cent = round ( (($wk2_cent / 7.8) + ($wk2_cent / 7)) / 2 );
		$d50_cent = round ( (($d25_cent / 10) + ($d25_cent / 8)) / 2 );
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 425, 499 );
		}
		if ($d50_cent > 0) {
			$d50_cent = 0;
		}
		
		$d75_cent = round ( (($d50_cent / 9.5) + ($d50_cent / 8)) / 2 );
		$d100_cent = round ( (($d75_cent / 11.2) + ($d75_cent / 9.75)) / 2 );
		
		$d125_cent = round ( (($d100_cent / 18.35) + ($d100_cent / 5.75)) / 2 );
		$d150_cent = round ( (($d125_cent / 17.7) + ($d125_cent / 5.75)) / 2 );
		$d175_cent = round ( (($d150_cent / 18.8) + ($d150_cent / 5.75)) / 2 );
		$d200_cent = round ( (($d175_cent / 19.9) + ($d175_cent / 7)) / 2 );
		
		$d250_cent = round ( (($d200_cent / 17.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = round ( (($d250_cent / 16) + ($d250_cent / 5.75)) / 2 );
		$d350_cent = round ( (($d300_cent / 17) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 17) + ($d350_cent / 7)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 16) + ($d365_cent / 5.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 17) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 17) + ($d450_cent / 7)) / 2 );
		$d600_cent = round ( (($d500_cent / 17) + ($d500_cent / 7)) / 2 );
		
		// *******************UTTER FLOP-- COLLECTIONS********* COLLECTIONS **********************
		$wk1_coll = ($wk1_coll * rand ( 20000, 30000 ) * 6) + ($rel_cent * rand ( 25000, 45000 ) * 1);
		$wk2_coll = $wk2_cent * rand ( 10000, 20000 ) * 7;
		$d25_coll = $d25_cent * rand ( 5000, 7600 ) * 25;
		$d50_coll = $d50_cent * rand ( 1000, 3000 ) * 25;
		$d75_coll = $d75_cent * rand ( 1000, 7000 ) * 25;
		$d100_coll = $d100_cent * rand ( 900, 1500 ) * 25;
		$d125_coll = $d125_cent * rand ( 400, 1100 ) * 25;
		$d150_coll = $d150_cent * rand ( 500, 800 ) * 25;
		$d175_coll = $d175_cent * rand ( 100, 500 ) * 25;
		$d200_coll = $d200_cent * rand ( 100, 400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} elseif ((2.0 <= $rateavg) && ($rateavg < 2.5)) // Flop
{
		
		$wk1_cent = round ( (($rel_cent / 4.5) + ($rel_cent / 4.4) + ($rel_cent / 2.75)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 3.5) + ($wk1_cent / 3.25)) / 2 );
		
		$d25_cent = round ( (($wk2_cent / 5.8) + ($wk2_cent / 5)) / 2 );
		$d50_cent = round ( (($d25_cent / 7) + ($d25_cent / 6)) / 2 ) - 1;
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 425, 499 );
		}
		if ($d50_cent < 0) {
			$d50_cent = 0;
		}
		
		$d75_cent = round ( (($d50_cent / 8.5) + ($d50_cent / 8)) / 2 );
		$d100_cent = round ( (($d75_cent / 9.2) + ($d75_cent / 9.75)) / 2 );
		
		$d125_cent = round ( (($d100_cent / 18.35) + ($d100_cent / 5.75)) / 2 );
		$d150_cent = round ( (($d125_cent / 17.7) + ($d125_cent / 5.75)) / 2 );
		$d175_cent = round ( (($d150_cent / 18.8) + ($d150_cent / 5.75)) / 2 );
		$d200_cent = round ( (($d175_cent / 19.9) + ($d175_cent / 7)) / 2 );
		
		$d250_cent = round ( (($d200_cent / 17.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = round ( (($d250_cent / 16) + ($d250_cent / 5.75)) / 2 );
		$d350_cent = round ( (($d300_cent / 17) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 17) + ($d350_cent / 7)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 16) + ($d365_cent / 5.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 17) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 17) + ($d450_cent / 7)) / 2 );
		$d600_cent = round ( (($d500_cent / 17) + ($d500_cent / 7)) / 2 );
		
		// *******************FLOP-- COLLECTIONS********* COLLECTIONS **********************
		$wk1_coll = ($wk1_coll * rand ( 20000, 30000 ) * 4) + ($rel_cent * rand ( 25000, 45000 ) * 3);
		$wk2_coll = $wk2_cent * rand ( 15000, 20000 ) * 7;
		$d25_coll = $d25_cent * rand ( 7000, 8600 ) * 25;
		$d50_coll = $d50_cent * rand ( 2000, 5000 ) * 25;
		$d75_coll = $d75_cent * rand ( 1000, 7000 ) * 25;
		$d100_coll = $d100_cent * rand ( 1900, 1500 ) * 25;
		$d125_coll = $d125_cent * rand ( 1400, 1100 ) * 25;
		$d150_coll = $d150_cent * rand ( 500, 800 ) * 25;
		$d175_coll = $d175_cent * rand ( 100, 500 ) * 25;
		$d200_coll = $d200_cent * rand ( 100, 400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} elseif ((2.5 <= $rateavg) && ($rateavg < 3.0)) // Below Avg
{
		
		$wk1_cent = round ( (($rel_cent / 2.5) + ($rel_cent / 2.4) + ($rel_cent / 2.75)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 2.5) + ($wk1_cent / 2.25)) / 2 );
		
		$d25_cent = 3 + round ( (($wk2_cent / 3.8) + ($wk2_cent / 3)) / 2 );
		$d50_cent = round ( (($d25_cent / 5) + ($d25_cent / 4)) / 2 );
		
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 5, 499 );
		}
		
		$d75_cent = round ( (($d50_cent / 6) + ($d50_cent / 7)) / 2 );
		$d100_cent = round ( (($d75_cent / 7.2) + ($d75_cent / 5.75)) / 2 );
		
		$d125_cent = round ( (($d100_cent / 8.35) + ($d100_cent / 5.75)) / 2 );
		$d150_cent = round ( (($d125_cent / 7.7) + ($d125_cent / 5.75)) / 2 );
		$d175_cent = round ( (($d150_cent / 8.8) + ($d150_cent / 5.75)) / 2 );
		$d200_cent = round ( (($d175_cent / 9.9) + ($d175_cent / 7)) / 2 );
		
		$d250_cent = round ( (($d200_cent / 7.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = round ( (($d250_cent / 6) + ($d250_cent / 5.75)) / 2 );
		$d350_cent = round ( (($d300_cent / 7) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 7) + ($d350_cent / 7)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 6) + ($d365_cent / 5.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 7) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 7) + ($d450_cent / 7)) / 2 );
		$d600_cent = round ( (($d500_cent / 7) + ($d500_cent / 7)) / 2 );
		
		// *******************BELOW AVG--- COLLECTIONS********* COLLECTIONS **********************
		$wk1_coll = ($wk1_coll * rand ( 30000, 35000 ) * 4) + ($rel_cent * rand ( 35000, 65000 ) * 3);
		$wk2_coll = $wk2_cent * rand ( 20000, 30000 ) * 7;
		$d25_coll = $d25_cent * rand ( 10000, 15600 ) * 25;
		$d50_coll = $d50_cent * rand ( 5000, 7000 ) * 25;
		$d75_coll = $d75_cent * rand ( 3000, 7000 ) * 25;
		$d100_coll = $d100_cent * rand ( 2000, 4500 ) * 25;
		$d125_coll = $d125_cent * rand ( 1000, 1700 ) * 25;
		$d150_coll = $d150_cent * rand ( 1500, 1800 ) * 25;
		$d175_coll = $d175_cent * rand ( 1100, 1500 ) * 25;
		$d200_coll = $d200_cent * rand ( 1000, 1400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} elseif ((3.0 <= $rateavg) && ($rateavg < 3.25)) // Average
{
		
		$wk1_cent = round ( (($rel_cent / 2.25) + ($rel_cent / 2) + ($rel_cent / 2.25)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 1.95) + ($wk1_cent / 2)) / 2 );
		
		$d25_cent = 2 + round ( (($wk2_cent / 2.8) + ($wk2_cent / 3)) / 2 );
		$d50_cent = round ( (($d25_cent / 3.7) + ($d25_cent / 3.25)) / 2 );
		
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 2, 499 );
		}
		
		$d75_cent = round ( (($d50_cent / 5) + ($d50_cent / 4.5)) / 2 );
		$d100_cent = round ( (($d75_cent / 5.2) + ($d75_cent / 4.75)) / 2 );
		
		$d125_cent = round ( (($d100_cent / 8.35) + ($d100_cent / 5.75)) / 2 );
		$d150_cent = round ( (($d125_cent / 7.7) + ($d125_cent / 5.75)) / 2 );
		$d175_cent = round ( (($d150_cent / 8.8) + ($d150_cent / 5.75)) / 2 );
		$d200_cent = round ( (($d175_cent / 9.9) + ($d175_cent / 7)) / 2 );
		
		$d250_cent = round ( (($d200_cent / 7.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = round ( (($d250_cent / 6) + ($d250_cent / 5.75)) / 2 );
		$d350_cent = round ( (($d300_cent / 7) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 7) + ($d350_cent / 7)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 6) + ($d365_cent / 5.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 7) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 7) + ($d450_cent / 7)) / 2 );
		$d600_cent = round ( (($d500_cent / 7) + ($d500_cent / 7)) / 2 );
		
		// ******************* AVG--- COLLECTIONS********* COLLECTIONS **********************
		$wk1_coll = ($wk1_coll * rand ( 30000, 40000 ) * 4) + ($rel_cent * rand ( 35000, 75000 ) * 3);
		$wk2_coll = $wk2_cent * rand ( 25000, 30000 ) * 7;
		$d25_coll = $d25_cent * rand ( 13000, 15600 ) * 25;
		$d50_coll = $d50_cent * rand ( 5000, 7000 ) * 25;
		$d75_coll = $d75_cent * rand ( 3000, 7000 ) * 25;
		$d100_coll = $d100_cent * rand ( 2000, 4500 ) * 25;
		$d125_coll = $d125_cent * rand ( 1000, 1700 ) * 25;
		$d150_coll = $d150_cent * rand ( 1500, 1800 ) * 25;
		$d175_coll = $d175_cent * rand ( 1100, 1500 ) * 25;
		$d200_coll = $d200_cent * rand ( 1000, 1400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} elseif ((3.25 <= $rateavg) && ($rateavg < 3.5)) // Above Average
{
		$wk1_cent = round ( (($rel_cent / 2.25) + ($rel_cent / 1.75) + ($rel_cent / 1.85)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 1.75) + ($wk1_cent / 1.65)) / 2 );
		
		$d25_cent = 2 + round ( (($wk2_cent / 2.55) + ($wk2_cent / 2.55)) / 2 );
		$d50_cent = 1 + round ( (($d25_cent / 3.3) + ($d25_cent / 2.75)) / 2 );
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 45, 499 );
		}
		
		$d75_cent = round ( (($d50_cent / 4.25) + ($d50_cent / 3.75)) / 2 );
		$d100_cent = round ( (($d75_cent / 4.2) + ($d75_cent / 4)) / 2 );
		
		$d125_cent = round ( (($d100_cent / 7.35) + ($d100_cent / 5.75)) / 2 );
		$d150_cent = round ( (($d125_cent / 6.7) + ($d125_cent / 5.75)) / 2 );
		$d175_cent = round ( (($d150_cent / 7.8) + ($d150_cent / 5.75)) / 2 );
		$d200_cent = round ( (($d175_cent / 7.9) + ($d175_cent / 7)) / 2 );
		
		$d250_cent = round ( (($d200_cent / 7.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = round ( (($d250_cent / 6) + ($d250_cent / 5.75)) / 2 );
		$d350_cent = round ( (($d300_cent / 7) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 7) + ($d350_cent / 7)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 6) + ($d365_cent / 5.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 7) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 7) + ($d450_cent / 7)) / 2 );
		$d600_cent = round ( (($d500_cent / 7) + ($d500_cent / 7)) / 2 );
		
		// *******************-ABOVE AVG--- COLLECTIONS********* COLLECTIONS **********************
		$wk1_coll = ($wk1_coll * rand ( 30000, 45000 ) * 2) + ($rel_cent * rand ( 35000, 75000 ) * 5);
		$wk2_coll = $wk2_cent * rand ( 25000, 33000 ) * 7;
		$d25_coll = $d25_cent * rand ( 13000, 20000 ) * 25;
		$d50_coll = $d50_cent * rand ( 6000, 9000 ) * 25;
		$d75_coll = $d75_cent * rand ( 4000, 9000 ) * 25;
		$d100_coll = $d100_cent * rand ( 2000, 4500 ) * 25;
		$d125_coll = $d125_cent * rand ( 1000, 1700 ) * 25;
		$d150_coll = $d150_cent * rand ( 1500, 1800 ) * 25;
		$d175_coll = $d175_cent * rand ( 1100, 1500 ) * 25;
		$d200_coll = $d200_cent * rand ( 1000, 1400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} elseif ((3.5 <= $rateavg) && ($rateavg < 3.75)) // HIT
{
		
		// // ******************** HIT *******************************
		$wk1_cent = round ( (($rel_cent / 1.25) + ($rel_cent / 1.35) + ($rel_cent / 1.65)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 1.25) + ($wk1_cent / 1.35)) / 2 );
		
		$d25_cent = 4 + round ( (($wk2_cent / 2.35) + ($wk2_cent / 1.75)) / 2 );
		$d50_cent = 1 + round ( (($d25_cent / 3) + ($d25_cent / 1.75)) / 2 );
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 30, 499 );
		}
		
		$d75_cent = 1 + round ( (($d50_cent / 3.5) + ($d50_cent / 3.75)) / 2 );
		$d100_cent = 1 + round ( (($d75_cent / 3) + ($d75_cent / 2)) / 2 );
		
		$d125_cent = round ( (($d100_cent / 7.35) + ($d100_cent / 5.75)) / 2 );
		$d150_cent = round ( (($d125_cent / 6) + ($d125_cent / 5.75)) / 2 );
		$d175_cent = round ( (($d150_cent / 7) + ($d150_cent / 3.75)) / 2 );
		$d200_cent = round ( (($d175_cent / 7) + ($d175_cent / 7)) / 2 );
		
		$d250_cent = round ( (($d200_cent / 7.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = round ( (($d250_cent / 6) + ($d250_cent / 5.75)) / 2 );
		$d350_cent = round ( (($d300_cent / 7) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 7) + ($d350_cent / 7)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 6) + ($d365_cent / 5.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 7) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 7) + ($d450_cent / 7)) / 2 );
		$d600_cent = round ( (($d500_cent / 7) + ($d500_cent / 7)) / 2 );
		
		// ******************** HIT ********* COLLECTIONS **********************
		$wk1_coll = ($wk1_coll * rand ( 33000, 45000 ) * 5) + ($rel_cent * rand ( 45000, 55000 ) * 2);
		$wk2_coll = $wk2_cent * rand ( 28000, 34000 ) * 7;
		$d25_coll = $d25_cent * rand ( 18000, 25000 ) * 25;
		$d50_coll = $d50_cent * rand ( 6000, 9000 ) * 25;
		$d75_coll = $d75_cent * rand ( 4000, 9000 ) * 25;
		$d100_coll = $d100_cent * rand ( 2000, 4500 ) * 25;
		$d125_coll = $d125_cent * rand ( 1000, 1700 ) * 25;
		$d150_coll = $d150_cent * rand ( 1500, 1800 ) * 25;
		$d175_coll = $d175_cent * rand ( 1100, 1500 ) * 25;
		$d200_coll = $d200_cent * rand ( 1000, 1400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} elseif ((3.75 <= $rateavg) && ($rateavg < 4.0)) {
		// ******************** SUPER HIT *******************************
		$wk1_cent = round ( (($rel_cent / 1.15) + ($rel_cent / 1.20) + ($rel_cent / 1.35)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 1.10) + ($wk1_cent / 1.20) + ($wk1_cent / 1.30)) / 3 );
		
		$d25_cent = 15 + round ( (($wk2_cent / 2.25) + ($wk2_cent / 1.55)) / 2 );
		$d50_cent = 10 + round ( (($d25_cent / 2.85) + ($d25_cent / 1.55)) / 2 );
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 100, 499 );
		}
		
		$d75_cent = 2 + round ( (($d50_cent / 3.25) + ($d50_cent / 3.5)) / 2 );
		$d100_cent = 1 + round ( (($d75_cent / 2) + ($d75_cent / 2)) / 2 );
		
		$d125_cent = round ( (($d100_cent / 4.35) + ($d100_cent / 3.75)) / 2 );
		$d150_cent = round ( (($d125_cent / 4) + ($d125_cent / 3.75)) / 2 );
		$d175_cent = round ( (($d150_cent / 4) + ($d150_cent / 3.75)) / 2 );
		$d200_cent = round ( (($d175_cent / 7) + ($d175_cent / 7)) / 2 );
		
		$d250_cent = round ( (($d200_cent / 7.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = round ( (($d250_cent / 6) + ($d250_cent / 5.75)) / 2 );
		$d350_cent = round ( (($d300_cent / 7) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 7) + ($d350_cent / 7)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 6) + ($d365_cent / 5.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 7) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 7) + ($d450_cent / 7)) / 2 );
		$d600_cent = round ( (($d500_cent / 7) + ($d500_cent / 7)) / 2 );
		
		// ******************** SUPER HIT *** COLLECTIONS****************************
		
		$wk1_coll = ($wk1_coll * rand ( 35000, 48000 ) * 5) + ($rel_cent * rand ( 45000, 60000 ) * 2);
		$wk2_coll = $wk2_cent * rand ( 30000, 37000 ) * 7;
		$d25_coll = $d25_cent * rand ( 20000, 27000 ) * 25;
		$d50_coll = $d50_cent * rand ( 9000, 11000 ) * 25;
		$d75_coll = $d75_cent * rand ( 6000, 9000 ) * 25;
		$d100_coll = $d100_cent * rand ( 2000, 4500 ) * 25;
		$d125_coll = $d125_cent * rand ( 1000, 1700 ) * 25;
		$d150_coll = $d150_cent * rand ( 1500, 1800 ) * 25;
		$d175_coll = $d175_cent * rand ( 1100, 1500 ) * 25;
		$d200_coll = $d200_cent * rand ( 1000, 1400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} elseif ((4.0 <= $rateavg) && ($rateavg < 4.5)) {
		// ******************** BLOCK BUSTER*******************************
		$wk1_cent = round ( (($rel_cent / 1.15) + ($rel_cent / 1.20) + ($rel_cent / 1.35)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 1.10) + ($wk1_cent / 1.20) + ($wk1_cent / 1.30)) / 3 );
		
		$d25_cent = 20 + round ( (($wk2_cent / 2.15) + ($wk2_cent / 1.25)) / 2 );
		$d50_cent = 15 + round ( (($d25_cent / 2.5) + ($d25_cent / 1.35)) / 2 );
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 225, 499 );
		}
		
		$d75_cent = 5 + round ( (($d50_cent / 3) + ($d50_cent / 3.25)) / 2 );
		$d100_cent = 3 + round ( (($d75_cent / 2) + ($d75_cent / 1)) / 2 );
		
		$d125_cent = 1 + round ( (($d100_cent / 3.35) + ($d100_cent / 2.75)) / 2 );
		$d150_cent = 1 + round ( (($d125_cent / 2.65) + ($d125_cent / 2.75)) / 2 );
		$d175_cent = 1 + round ( (($d150_cent / 2.8) + ($d150_cent / 4.25)) / 2 );
		$d200_cent = round ( (($d175_cent / 5) + ($d175_cent / 3)) / 2 );
		
		$d250_cent = round ( (($d200_cent / 5.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = round ( (($d250_cent / 5) + ($d250_cent / 5.75)) / 2 );
		$d350_cent = round ( (($d300_cent / 6) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 5) + ($d350_cent / 3)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 6) + ($d365_cent / 5.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 7) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 7) + ($d450_cent / 7)) / 2 );
		$d600_cent = round ( (($d500_cent / 7) + ($d500_cent / 7)) / 2 );
		
		// ------------------Block BUSTEr-- COLLECTIONS ---------
		$wk1_coll = ($wk1_coll * rand ( 50000, 70000 ) * 5) + ($rel_cent * rand ( 60000, 75000 ) * 2);
		$wk2_coll = $wk2_cent * rand ( 45000, 50000 ) * 7;
		$d25_coll = $d25_cent * rand ( 40000, 50000 ) * 25;
		$d50_coll = $d50_cent * rand ( 15000, 10000 ) * 25;
		$d75_coll = $d75_cent * rand ( 10000, 15000 ) * 25;
		$d100_coll = $d100_cent * rand ( 8000, 10000 ) * 25;
		$d125_coll = $d125_cent * rand ( 5000, 7000 ) * 25;
		$d150_coll = $d150_cent * rand ( 3500, 5000 ) * 25;
		$d175_coll = $d175_cent * rand ( 2800, 1500 ) * 25;
		$d200_coll = $d200_cent * rand ( 1000, 1400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} elseif ($rateavg >= 4.5) {
		// ******************** INDUSTRY HIT*******************************
		$wk1_cent = round ( (($rel_cent / 1.1) + ($rel_cent / 1.20) + ($rel_cent / 1.25)) / 3 );
		$wk2_cent = round ( (($wk1_cent / 1.1) + ($wk1_cent / 1.20) + ($wk1_cent / 1.2)) / 3 );
		
		$d25_cent = 25 + round ( (($wk2_cent / 2.15) + ($wk2_cent / 1.15)) / 2 );
		$d50_cent = 18 + round ( (($d25_cent / 2) + ($d25_cent / 1.25)) / 2 );
		if ($d50_cent >= 500) {
			$d50_cent = rand ( 425, 499 );
		}
		
		$d75_cent = 6 + round ( (($d50_cent / 2.5) + ($d50_cent / 3.25)) / 2 );
		$d100_cent = 3 + round ( (($d75_cent / 1) + ($d75_cent / 2)) / 2 );
		
		$d125_cent = 5 + round ( (($d100_cent / 1.35) + ($d100_cent / 2.75)) / 2 );
		$d150_cent = 3 + round ( (($d125_cent / 1.65) + ($d125_cent / 3.75)) / 2 );
		$d175_cent = 2 + round ( (($d150_cent / 1.8) + ($d150_cent / 4.25)) / 2 );
		$d200_cent = 1+round ( (($d175_cent / 2) + ($d175_cent / 3)) / 2 );
		
		$d250_cent = 1+round ( (($d200_cent / 3.35) + ($d200_cent / 5.75)) / 2 );
		$d300_cent = 1+round ( (($d250_cent / 3) + ($d250_cent / 2.75)) / 2 );
		$d350_cent = 1+round ( (($d300_cent / 4) + ($d300_cent / 3.75)) / 2 );
		$d365_cent = round ( (($d350_cent / 5) + ($d350_cent / 3)) / 2 );
		
		$d400_cent = round ( (($d365_cent / 4) + ($d365_cent / 3.75)) / 2 );
		$d450_cent = round ( (($d400_cent / 4) + ($d400_cent / 3.75)) / 2 );
		$d500_cent = round ( (($d450_cent / 4) + ($d450_cent / 5)) / 2 );
		$d600_cent = round ( (($d500_cent / 4) + ($d500_cent / 3)) / 2 );
		
		// ------------------INDUSTRY HIT-- COLLECTIONS ---------
		$wk1_coll = ($wk1_coll * rand ( 800000, 90000 ) * 5) + ($rel_cent * rand ( 90000, 100000 ) * 2);
		$wk2_coll = $wk2_cent * rand ( 70000, 80000 ) * 7;
		$d25_coll = $d25_cent * rand ( 55000, 70000 ) * 25;
		$d50_coll = $d50_cent * rand ( 25000, 40000 ) * 25;
		$d75_coll = $d75_cent * rand ( 10000, 20000 ) * 25;
		$d100_coll = $d100_cent * rand ( 8000, 15000 ) * 25;
		$d125_coll = $d125_cent * rand ( 5000, 7000 ) * 25;
		$d150_coll = $d150_cent * rand ( 3500, 5000 ) * 25;
		$d175_coll = $d175_cent * rand ( 2800, 1500 ) * 25;
		$d200_coll = $d200_cent * rand ( 1000, 1400 ) * 25;
		$d250_coll = $d250_cent * rand ( 700, 1100 ) * 50;
		$d300_coll = $d300_cent * rand ( 500, 700 ) * 50;
		$d350_coll = $d350_cent * rand ( 400, 300 ) * 50;
		$d365_coll = $d365_cent * rand ( 300, 400 ) * 15;
		$d400_coll = $d400_cent * rand ( 300, 400 ) * 25;
		$d450_coll = $d450_cent * rand ( 300, 4000 ) * 50;
		$d500_coll = $d500_cent * rand ( 300, 400 ) * 50;
		$d600_coll = $d600_cent * rand ( 300, 400 ) * 100;
		$max_coll = $wk1_coll + $wk2_coll + $d25_coll + $d50_coll + $d75_coll + $d100_coll + $d125_coll + $d150_coll + $d175_coll + $d200_coll + $d250_coll + $d300_coll + $d350_coll + $d365_coll + $d400_coll + $d450_coll + $d500_coll + $d600_coll;
		echo 'Max Collectoion : ' . $max_coll;
	} else {
		$wk1_cent = round ( $rel_cent / 4 );
		$result = 'AVERAGE';
	}
	
	// maxdays calculations
	if ($wk1_cent < 1) {
		
		$max_days = rand ( 0, 7 );
	} else if ($wk2_cent < 1) {
		$max_days = rand ( 7, 14 );
	} else if ($d25_cent < 1) {
		$max_days = rand ( 15, 24 );
	} else if ($d50_cent < 1) {
		$max_days = rand ( 26, 49 );
	} else if ($d75_cent < 1) {
		$max_days = rand ( 51, 74 );
	} else if ($d100_cent < 1) {
		$max_days = rand ( 76, 99 );
	} else if ($d125_cent < 1) {
		$max_days = rand ( 101, 124 );
	} else if ($d150_cent < 1) {
		$max_days = rand ( 125, 150 );
	} else if ($d175_cent < 1) {
		$max_days = rand ( 150, 174 );
	} else if ($d200_cent < 1) {
		$max_days = rand ( 175, 199 );
	} else if ($d250_cent < 1) {
		$max_days = rand ( 202, 249 );
	} else if ($d300_cent < 1) {
		$max_days = rand ( 250, 299 );
	} else if ($d350_cent < 1) {
		$max_days = rand ( 300, 347 );
	} else if ($d365_cent < 1) {
		$max_days = rand ( 350, 364 );
	} else if ($d400_cent < 1) {
		$max_days = rand ( 366, 397 );
	} else if ($d450_cent < 1) {
		$max_days = rand ( 400, 447 );
	} else if ($d500_cent < 1) {
		$max_days = rand ( 450, 497 );
	} else {
		$max_days = 25;
	}
}

// ----------------------- AREA CALCULATIONS ------------------------------
$a_cent = round ( $rel_cent / 6 );
$a_bud = round ( $budget / 6 );
$a_coll = round ( $max_coll / 6 );

$r1 = 0;
$r2 = 0;
$r3 = 0;

// -----Review Ratings

$min = $rateavg - 0.50;
$max = $rateavg + 0.50;

$r1 = (((rand ( $min, $max )) / 0.05) * 0.05);

$r3 = (((rand ( $min, $max )) / 0.15) * 0.15);

$r1 = $r1 + 0.25;
$r2 = $rateavg;
$r3 = $r3 - 0.25;

$profit = 0;
$profit = $max_coll - $budget;

$sql1 = "UPDATE tolly_ready_for_shoot SET status='shootout',  collection=" . $max_coll . ", profit=" . $profit . " , result='" . $result . "', progress=100, rating=" . $rateavg . " WHERE  uid = " . $uid . " and rid = " . $sid;
echo "BUDGET IS  " . $budget;
echo 'Update --->' . $sql1;
mysqli_query ( $conn, $sql1 );

$sql = "INSERT INTO tolly_release (uid, rid, rel_cen, a1_cen, a2_cen, a3_cen, a4_cen, a5_cen, a1, a2, a3, a4, a5, a6, 1w_coll, 2w_coll, 25d_coll, 50d_coll, 75d_coll, 100d_coll, 125d_coll, 150d_coll, 175d_coll, total_coll, 1w_cen, 2w_cen, 25d_cen, 50d_cen, 75d_cen, 100d_cen, 125d_cen, 150d_cen, 175d_cen, 200d_cen, 250d_cen, 300d_cen, 350d_cen, 400d_cen, max_days, max_cent, 50cen, 100cen, 175cen, notes,r1,r2,r3) VALUES
 		 (" . $uid . ", " . $sid . ", " . $rel_cent . ", " . $a_cent . ", " . $a_cent . ", " . $a_cent . ", " . $a_cent . ", " . $a_cent . ", " . $a_bud . ", " . $a_bud . ", " . $a_bud . ", " . $a_bud . ", " . $a_bud . ", " . $a_bud . ", " . $wk1_coll . ", " . $wk2_coll . ", " . $d25_coll . ", " . $d50_coll . ", " . $d75_coll . ",
 		 		 " . $d100_coll . ", " . $d125_coll . ", " . $d150_coll . ", " . $d175_coll . ", " . $max_coll . ", " . $wk1_cent . ", " . $wk2_cent . ", " . $d25_cent . ", " . $d50_cent . ", " . $d75_cent . ", " . $d100_cent . ", " . $d125_cent . ", " . $d150_cent . ",  " . $d175_cent . ", " . $d200_cent . ", " . $d250_cent . ", " . $d300_cent . ", " . $d350_cent . ", " . $d400_cent . ", " . $max_days . ", 'AAA', 'ALANKAR', '$100cent', '$175cent', 'notes', " . $r1 . ", " . $r2 . ", " . $r3 . ")";
echo $sql;
mysqli_query ( $conn, $sql );

echo $rel_cent . "<-----  CENTERS";

$news = "Shooting Completed!! <b>" . $title . "</b>, with <a href=\'actor.php?id=$aid\'>" . $aname . "</a> Direction by <a href=\'director.php?id=$did\'>" . $dname . "</a>";

$sql3 = "INSERT INTO  `tolly_news` (`news`, `heading`) VALUES ('" . $news . "', 'Shooting Completed!! ')";
echo 'News ----> ' . $sql3;
mysqli_query ( $conn, $sql3 );

// adding Json-Ajax Collections Data

header('Location: readyforrelease.php');

?>
















<!DOCTYPE html>
<html>

<head>
        <?php include 'css.php';?>
    </head>

<body class="page-header-fixed">
	<div class="overlay"></div>
	<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right"
		id="cbp-spmenu-s1">
		<h3>
			<span class="pull-left">Chat</span><a href="javascript:void(0);"
				class="pull-right" id="closeRight"><i class="fa fa-times"></i></a>
		</h3>

	</nav>
	<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right"
		id="cbp-spmenu-s2">
		<h3>
			<span class="pull-left">Sandra Smith</span> <a
				href="javascript:void(0);" class="pull-right" id="closeRight2"><i
				class="fa fa-angle-right"></i></a>
		</h3>
	</nav>
	<div class="menu-wrap">

		<button class="close-button" id="close-button">Close Menu</button>
	</div>
	<form class="search-form" action="#" method="GET">
		<div class="input-group">
			<input type="text" name="search" class="form-control search-input"
				placeholder="Search..."> <span class="input-group-btn">
				<button
					class="btn btn-default close-search waves-effect waves-button waves-classic"
					type="button">
					<i class="fa fa-times"></i>
				</button>
			</span>
		</div>
		<!-- Input Group -->
	</form>
	<!-- Search Form -->
	<main class="page-content content-wrap">
            <?php include 'navbar.php';?>
                <div class="page-sidebar sidebar">
                    <?php include('sidemenu.php');  ?>
                        <!-- Page Sidebar Inner -->
	</div>
	<!-- Page Sidebar -->

	<div class="page-inner">

		<div id="main-wrapper">
			<div class="col-md-4 center">
				<h1 class="text-xxl  text-center">
					<i class="icon-wrench"></i>
				</h1>
				<h2 class="text-xl f-white text-center" id="counter"></h2>
				<div class="details">
					<h3 class="f-white">Shooting Completed</h3>
					<p class="f-white">WE ARE COMING SOON.</p>
					<p><?php
					echo '<br>BUDGET :  ' . $budget;
					echo '<br>TOTAL COOLECTIOSN :  ' . $max_coll;
					echo '<br>	x1	:  ' . $x1;
					echo '<br>	x2	:  ' . $x2;
					echo '<br>	x3	:  ' . $x3;
					
					echo '<br><h3>RATING FINAL :  ' . $ratefinal . ' <br> RESULT : ' . $hit;
					echo '<br><h3> COUNT : '.$count;
					echo '<br>RATING :  ' . $rateavg . ' <br></h3> RESULT : ' . $hit;
					echo '<br>Release CENTERS :  ' . $rel_cent;
					echo '<br>1wk CENTERS :  ' . $wk1_cent;
					echo '<br>2wk CENTERS :  ' . $wk2_cent;
					echo '<br>25 CENTERS :  ' . $d25_cent;
					echo '<br>50 CENTERS :  ' . $d50_cent;
					echo '<br>75 CENTERS :  ' . $d75_cent;
					echo '<br>100 CENTERS :  ' . $d100_cent;
					echo '<br>125 CENTERS :  ' . $d125_cent;
					echo '<br>150 CENTERS :  ' . $d150_cent;
					echo '<br>175 CENTERS :  ' . $d175_cent;
					echo '<br>200 CENTERS :  ' . $d200_cent;
					echo '<br>255 CENTERS :  ' . $d250_cent;
					echo '<br>300 CENTERS :  ' . $d300_cent;
					echo '<br>350 CENTERS :  ' . $d350_cent;
					echo '<br>400 CENTERS :  ' . $d400_cent;
					echo '<br>500 CENTERS :  ' . $d500_cent;
					echo '<br>600 CENTERS :  ' . $d600_cent;
					
					// header('Location: readyforrelease.php');
					
					?></p>
				</div>

			</div>



		</div>
		<!-- Main Wrapper -->
		<!-- Main Wrapper -->


		<div class="page-footer">
			<p class="no-s">2015 &copy; HitandFut.com</p>
		</div>
	</div>
	<!-- Page Inner --> </main>
	<!-- Page Content -->

	<!-- Page Content -->

	<div class="cd-overlay"></div>

        <?php include 'js.php';?>
            <script type="text/javascript">
            alert('YEH');
			  
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

               

            </script>

</body>

</html>
<?php mysql_close($conn);?>
