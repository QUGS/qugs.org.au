<?php
include("db.php");

if($_SERVER['REQUEST_METHOD'] != 'POST' || !password_verify($_POST['exec'], "$2y$10$1oWCnF.MZLJfq9eUkwwEPeeatxJfbIaYpfUOBs.XvldQywtrv2eai"))
{
	echo "<!DOCTYPE html>
		<html>
		<head>
		<title>QUGS Membership</title>
		<meta content=\"text/html;charset=utf-8\" http-equiv=\"Content-Type\">
		<meta content=\"utf-8\" http-equiv=\"encoding\">
		<meta name=\"author\" content=\"Bradley Stone\"/>
		<link rel=\"icon\" href=\"images/fave".(intval(date("z")) % 6).".png\" />
		<style>
		body
		#horizon        
		{
			text-align: center;
			position: absolute;
			top: 50%;
			left: 0px;
			width: 100%;
			height: 1px;
			overflow: visible;
			visibility: visible;
			display: block;
		}
		#content    
		{
			margin-left: -50%;
			position: absolute;
			top: -2vmin;
			left: 50%;
			width: 100%;
			height: 4vmin;
			visibility: visible;
			font-size: 4vmin;
		}
		input
		{
			font-size:3vmin;
		}
		</style>
		</head>
		<body>
			<div id=\"horizon\">
				<div id=\"content\">
						<form method=\"post\" action=\"membership\">
							Executive Password:
							<input type=\"password\" name=\"exec\" id=\"exec\"/>
							<input type=\"submit\" value=\"Submit\"/>
						</form>
				</div>
			</div>";
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {echo "<script>alert(\"Password Incorrect\")</script>";}
		echo "</body>
		</html>";
	exit();
}
$time_q = "SET time_zone = 'Australia/Brisbane';";
mysqli_query($db, $time_q) or die(mysqli_error($db));

$memb_q = "SELECT fname, lname, email, phone, gender, student, number, year, faculty, school, international, receipt, stripe, joined FROM Membership ORDER BY joined, lname;";
$memb_l = mysqli_query($db, $memb_q) or die(mysqli_error($db));
$memb_t = "";
$n = 0;
while($memb_r = mysqli_fetch_assoc($memb_l))
{
	$n += 1;
	$memb_t .= "\n\t<tr>
		<td>".$n."</td>
		<td>".$memb_r['fname']." ".$memb_r['lname']."</td>
		<td>".$memb_r['email']."</td>
		".($memb_r['phone'] ? "<td>".$memb_r['phone']."</td>" : "<td style='color:#808080;'>N/A</td>")."
		<td>".strtoupper($memb_r['gender'])."</td>
		".($memb_r['student'] ? "<td>".$memb_r['number']."</td>" : "<td style='color:#808080;'>N/A</td>")."
		".($memb_r['student'] ? "<td>".strtoupper($memb_r['year'])."</td>" : "<td style='color:#808080;'>N/A</td>")."
		".($memb_r['student'] ? "<td>".strtoupper($memb_r['faculty'] == "eai" ? "eait" : $memb_r['faculty'])."</td>" : "<td style='color:#808080;'>N/A</td>")."
		".($memb_r['student'] ? "<td>".strtoupper($memb_r['school'])."</td>" : "<td style='color:#808080;'>N/A</td>")."
		".($memb_r['student'] ? "<td>".($memb_r['international'] ? "&#x2713;" : "&#x2717;")."</td>" : "<td style='color:#808080;'>N/A</td>")."
		<td>".(($memb_r['receipt'] || $memb_r['stripe']) ? ($memb_r['receipt'].$memb_r['stripe']) : "???")."</td>
		".($memb_r['joined'] ? "<td>".date("H:i&\\e\\m\\sp;jS M, Y", strtotime($memb_r['joined']))."</td>" : "<td style='color:#808080;'>N/A</td>")."</tr>";
}

$gen_q = "SELECT gender, COUNT(membid) AS c FROM Membership GROUP BY gender ORDER BY c DESC;";
$gen_l = mysqli_query($db, $gen_q) or die(mysqli_error($db));
$gen_t = "";
while($gen_r = mysqli_fetch_assoc($gen_l))
{
	$gen_t .= "\n\t<tr>
		<td>".($gen_r['gender'] == "m" ? "Male" : ($gen_r['gender'] == "f" ? "Female" : "Other"))."</td>
		<td>".$gen_r['c']."</td>
		<td>".round(100*$gen_r['c']/$n, 0, PHP_ROUND_HALF_EVEN)."%</td></tr>";
}

$stud_q = "SELECT student, COUNT(membid) AS c FROM Membership GROUP BY student ORDER BY student DESC;";
$stud_l = mysqli_query($db, $stud_q) or die(mysqli_error($db));
$stud_r = mysqli_fetch_assoc($stud_l);
$stud_t = "\n\t<tr>
		<td>UQ Student</td>
		<td>".$stud_r['c']."</td>
		<td>".round(100*$stud_r['c']/$n, 0, PHP_ROUND_HALF_EVEN)."%</td></tr>";
$s = $stud_r['c'];
$stud_r = mysqli_fetch_assoc($stud_l);
$stud_t .= "\n\t<tr>
		<td>Non&ndash;Student</td>
		<td>".$stud_r['c']." (&or;".floor(3*$s/7).")</td>
		<td>".round(100*$stud_r['c']/$n, 0, PHP_ROUND_HALF_EVEN)."% (&or;30%)</td></tr>";

$year_q = "SELECT year, COUNT(membid) AS c FROM Membership WHERE year IS NOT NULL GROUP BY year ORDER BY year ASC;";
$year_l = mysqli_query($db, $year_q) or die(mysqli_error($db));
$year_t = "";
while($year_r = mysqli_fetch_assoc($year_l))
{
	$year_t .= "\n\t<tr>\t\t<td>";
		switch ($year_r['year'])
		{
			case "1":
				$year_t .= "First";
				break;
			case "2":
				$year_t .= "Second";
				break;
			case "3":
				$year_t .= "Third";
				break;
			case "4":
				$year_t .= "Fourth";
				break;
			case "5+":
				$year_t .= "Fifth +";
				break;
			case "pg":
				$year_t .= "Post&ndash;Graduate";
				break;
		}
		$year_t .= "</td>
		<td>".$year_r['c']."</td>
		<td>".round(100*$year_r['c']/$s, 0, PHP_ROUND_HALF_EVEN)."%</td></tr>";
}

$fac_q = "SELECT faculty, COUNT(membid) AS c FROM Membership WHERE faculty IS NOT NULL GROUP BY faculty ORDER BY faculty = 'oth' ASC, c DESC;";
$fac_l = mysqli_query($db, $fac_q) or die(mysqli_error($db));
$fac_t = "";
while($fac_r = mysqli_fetch_assoc($fac_l))
{
	$fac_t .= "\n\t<tr>
		<td>".strtoupper($fac_r['faculty'] == "eai" ? "eait" : $fac_r['faculty'])."</td>
		<td>";
	switch ($fac_r['faculty'])
	{
		case "bel":
			$fac_t .= "Business, Economics and Law";
			break;
		case "eai":
			$fac_t .= "Engineering, Architecture and Information Technology";
			break;
		case "hbs":
			$fac_t .= "Health and Behavioural Sciences";
			break;
		case "hss":
			$fac_t .= "Humanities and Social Sciences";
			break;
		case "med":
			$fac_t .= "Medicine";
			break;
		case "sci":
			$fac_t .= "Science";
			break;
		case "oth":
			$fac_t .= "Other";
			break;
	}
	$fac_t .= "</td>
		<td>".$fac_r['c']."</td>
		<td>".round(100*$fac_r['c']/$s, 0, PHP_ROUND_HALF_EVEN)."%</td></tr>";
	$f = $fac_r['c'];
	
	$scho_q = "SELECT school, COUNT(membid) AS c FROM Membership WHERE faculty = '".$fac_r['faculty']."' GROUP BY school ORDER BY school = 'oth_' ASC, c DESC;";
	$scho_l = mysqli_query($db, $scho_q) or die(mysqli_error($db));
	while($scho_r = mysqli_fetch_assoc($scho_l))
	{
		$fac_t .= "\n\t<tr style=\"font-style:italic;\">
			<td>&emsp;".strtoupper($scho_r['school'])."</td>
			<td>&emsp;";
		switch ($scho_r['school'])
		{
			case "buis":
				$fac_t .= "Business";
				break;
			case "econ":
				$fac_t .= "Economics";
				break;
			case "law":
				$fac_t .= "Law";
				break;
			case "arch":
				$fac_t .= "Architecture";
				break;
			case "chee":
				$fac_t .= "Chemical Engineering";
				break;
			case "civ":
				$fac_t .= "Civil Engineering";
				break;
			case "mech":
				$fac_t .= "Mechanical &amp; Mining Engineering";
				break;
			case "itee":
				$fac_t .= "Information Technology &amp; Electrical Engineering";
				break;
			case "dent":
				$fac_t .= "Dentisty";
				break;
			case "hrs":
				$fac_t .= "Health &amp; Rehabilitation Sciences";
				break;
			case "hmns":
				$fac_t .= "Human Movement &amp; Nutrition Sciences";
				break;
			case "nmsw":
				$fac_t .= "Nursing, Midwifery &amp; Social Work";
				break;
			case "phar":
				$fac_t .= "Pharmacy";
				break;
			case "psyc":
				$fac_t .= "Psycology";
				break;
			case "biom":
				$fac_t .= "Biomedical Sciences";
				break;
			case "pubh":
				$fac_t .= "Public Health";
				break;
			case "comm":
				$fac_t .= "Comminication &amp; Arts";
				break;
			case "edu":
				$fac_t .= "Education";
				break;
			case "hist":
				$fac_t .= "Historical &amp; Philosophical Inquiry";
				break;
			case "lang":
				$fac_t .= "Languages &amp; Culture";
				break;
			case "mus":
				$fac_t .= "Music";
				break;
			case "poli":
				$fac_t .= "Political Science &amp; International Studies";
				break;
			case "soci":
				$fac_t .= "Social Science";
				break;
			case "agri":
				$fac_t .= "Agriculture &amp; Food Science";
				break;
			case "biol":
				$fac_t .= "Biological Sciences";
				break;
			case "envi":
				$fac_t .= "Earth &amp; Environmental Sciences";
				break;
			case "chem":
				$fac_t .= "Chemical &amp; Molecular Biosciences";
				break;
			case "math":
				$fac_t .= "Maths &amp; Phyisics";
				break;
			case "vet":
				$fac_t .= "Veterinary Science";
				break;
			case "oth_":
				$fac_t .= "Other";
				break;
		}
		$fac_t .= "</td>
			<td>".$scho_r['c']."</td>
		<td>".round(100*$scho_r['c']/$s, 0, PHP_ROUND_HALF_EVEN)."%&ensp;&bull;&ensp;".round(100*$scho_r['c']/$f, 0, PHP_ROUND_HALF_EVEN)."%</td></tr>";
	}
}

$int_q = "SELECT international, COUNT(membid) AS c FROM Membership WHERE international IS NOT NULL GROUP BY international ORDER BY c DESC;";
$int_l = mysqli_query($db, $int_q) or die(mysqli_error($db));
$int_t = "";
while($int_r = mysqli_fetch_assoc($int_l))
{
	$int_t .= "\n\t<tr>
		<td>".($int_r['international'] ? "International" : "Domestic")."</td>
		<td>".$int_r['c']."</td>
		<td>".round(100*$int_r['c']/$s, 0, PHP_ROUND_HALF_EVEN)."%</td></tr>";
}

$pay_q = "SELECT 'Stripe' AS p, COUNT(membid) AS c FROM Membership WHERE stripe IS NOT NULL UNION SELECT 'Life Member' AS p, COUNT(membid) AS c FROM Membership WHERE receipt = 'Life Member' UNION SELECT 'Cash' AS p, COUNT(membid) AS c FROM Membership WHERE receipt != 'Life Member' AND receipt != '' AND stripe IS NULL UNION SELECT '???' AS p, COUNT(membid) AS c FROM Membership WHERE receipt = '' AND stripe IS NULL ORDER BY c DESC";
$pay_l = mysqli_query($db, $pay_q) or die(mysqli_error($db));
$pay_t = "";
while($pay_r = mysqli_fetch_assoc($pay_l))
{
	if($pay_r['c'])
	{
		$pay_t .= "\n\t<tr>
			<td>".$pay_r['p']."</td>
			<td>".$pay_r['c']."</td>
			<td>".round(100*$pay_r['c']/$n, 0, PHP_ROUND_HALF_EVEN)."%</td></tr>";
	}
}

$quo_q = "SELECT COUNT(membid) AS c FROM Membership WHERE receipt != 'Life Member' OR receipt IS NULL;";
$quo_l = mysqli_query($db, $quo_q) or die(mysqli_error($db));
$quo_r = mysqli_fetch_assoc($quo_l);
$quo_c = $quo_r['c'];
$quo_n = ceil(sqrt($quo_c + 125));
$quo_p = round(100*$quo_n/$n, 2, PHP_ROUND_HALF_EVEN);

?>
<!DOCTYPE html>
<html>
<head>
<title>Queensland University Games Society</title>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
<meta content="utf-8" http-equiv="encoding"/>
<meta name="author" content="Bradley Stone"/>
<meta name="version" content="v1.3"/>
<link rel="icon" href="images/fave<?php echo intval(date("z")) % 6 ?>.png"/>
<style>
table
{
	border-collapse: collapse;
}
table tr:nth-child(odd)
{
	background-color: #D3D3D3;
}
table tr:first-child
{
	background-color: #000000;
	font-weight: bold;
	color: #FFFFFF;
}
table tr
{
	border-top: thin solid #000000;
	border-bottom: thin solid #000000;
}
table td
{
	padding: 1px 1em;
    vertical-align: top;
}
table tr > td:first-child
{
	text-indent: -0.5em;
	padding-left: 1.5em;
	font-weight: bold;
}
.memb tr > td:nth-child(2), .fac tr > td:nth-child(2)
{
	font-weight: bold;
}

</style>
<script>
</script>
</head>
<body>
<table class="memb">
	<tr>
        <td>#</td>
        <td>Name</td>
        <td>E&ndash;Mail</td>
        <td>Phone</td>
        <td>Gender</td>
        <td>Student No.</td>
        <td>Year</td>
        <td>Faculty</td>
        <td>School</td>
        <td>International</td>
        <td>Receipt</td>
        <td>Join Date</td></tr><?php echo $memb_t;?></table>
<br/>

<table class="gen">
	<tr>
        <td>Gender</td>
        <td>Number</td>
        <td>Percentage</td></tr><?php echo $gen_t;?></table>
<br/>

<table class="stud">
	<tr>
        <td>&nbsp;</td>
        <td>Count</td>
        <td>Percentage</td></tr><?php echo $stud_t;?></table>
<br/>

<table class="year">
	<tr>
        <td>Year</td>
        <td>Count</td>
        <td>Percentage</td></tr><?php echo $year_t;?></table>
<br/>

<table class="fac">
	<tr>
        <td colspan="2">Faculty/School</td>
        <td>Count</td>
        <td>Percentage</td></tr><?php echo $fac_t;?></table>
<br/>

<table class="int">
	<tr>
		<td>&nbsp;</td>
    	<td>Count</td>
    	<td>Percentage</td></tr><?php echo $int_t;?></table>
<br/>

<table class="pay">
	<tr>
        <td>Payment Method</td>
        <td>Count</td>
        <td>Percentage</td></tr><?php echo $pay_t;?></table>
<br/>

Quorum: <?php echo $quo_n;?> (<?php echo $quo_p;?>%)<br/>
+1 quorum if +<?php echo $quo_n*$quo_n-124-$quo_c;?> members.
</body>
</html>