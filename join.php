<!DOCTYPE html>
<html>
<head>
<title>Queensland University Games Society</title>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
<meta content="utf-8" http-equiv="encoding"/>
<meta name="author" content="Bradley Stone"/>
<meta name="version" content="v1.4"/>
<link rel="icon" href="images/fave<?php echo intval(date("z")) % 6 ?>.png" />
<?php
// is a cash payment correct (i.e. executive password correct)
$cash = true;
// is a card payment correct (i.e. allowed by stripe)
$card = true;
// query string
$q = "";
// boolean to re-fill form
$b = true;
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$b = false;
	include("db.php");
	if ($_POST['payment'] == "cash") // if payment cash
	{
		$cash = password_verify($_POST['exec'], "$2y$10$1oWCnF.MZLJfq9eUkwwEPeeatxJfbIaYpfUOBs.XvldQywtrv2eai");
		if ($cash) // if password correct
		{
			if ($_POST['student']) // if student
			{
				$q = 'INSERT INTO Membership (
					fname,
					lname,
					email,
					gender,
					student,
					number,
					year,
					faculty,
					school,
					international,
					receipt
				) VALUES (
					"'.mysqli_escape_string($db,$_POST['fname']).'",
					"'.mysqli_escape_string($db,$_POST['lname']).'",
					"'.mysqli_escape_string($db,$_POST['email']).'",
					"'.mysqli_escape_string($db,$_POST['gender']).'",
					TRUE,
					'.mysqli_escape_string($db,$_POST['stuid']).',
					"'.mysqli_escape_string($db,$_POST['year']).'",
					"'.mysqli_escape_string($db,$_POST['faculty']).'",
					"'.mysqli_escape_string($db,$_POST['school']).'",
					'.($_POST['international'] ? 'TRUE' : 'FALSE').',
					"'.mysqli_escape_string($db,$_POST['receipt']).'"
				)';
			}
			else // if not student
			{
				$q = 'INSERT INTO Membership (
					fname,
					lname,
					email,
					gender,
					student,
					receipt
				) VALUES (
					"'.mysqli_escape_string($db,$_POST['fname']).'",
					"'.mysqli_escape_string($db,$_POST['lname']).'",
					"'.mysqli_escape_string($db,$_POST['email']).'",
					"'.mysqli_escape_string($db,$_POST['gender']).'",
					FALSE,
					"'.mysqli_escape_string($db,$_POST['receipt']).'"
				)';
			} // end if student
		} // end if password correct
	}
	else // if payment not cash
	{
		require_once("stripe-php-6.21.0/init.php");
		include("st.php");
		$card = false;
		try
		{
			$c = \Stripe\Charge::create(array('amount' => 550,'currency' => 'aud','description' => 'Example charge','source' => $_POST['stripeToken']));
			$card = $c['paid'];
		}
		catch (\Stripe\Error\Card $e)
		{
		}
		if (!$card) {} // if stripe error
		else if ($_POST['student']) // if not stripe error and student
		{
			$q = 'INSERT INTO Membership (
				fname,
				lname,
				email,
				gender,
				student,
				number,
				year,
				faculty,
				school,
				international,
				stripe,
				s_email
			) VALUES (
				"'.mysqli_escape_string($db,$_POST['fname']).'",
				"'.mysqli_escape_string($db,$_POST['lname']).'",
				"'.mysqli_escape_string($db,$_POST['email']).'",
				"'.mysqli_escape_string($db,$_POST['gender']).'",
				TRUE,'.mysqli_escape_string($db,$_POST['stuid']).',
				"'.mysqli_escape_string($db,$_POST['year']).'",
				"'.mysqli_escape_string($db,$_POST['faculty']).'",
				"'.mysqli_escape_string($db,$_POST['school']).'",
				'.($_POST['international'] ? 'TRUE' : 'FALSE').',
				"'.mysqli_escape_string($db,$_POST['stripeToken']).'",
				"'.mysqli_escape_string($db,$_POST['stripeEmail']).'"
			)';
		}
		else // if not stripe error and not student
		{
			$q = 'INSERT INTO Membership (
				fname,
				lname,
				email,
				gender,
				student,
				stripe,
				s_email
			) VALUES (
				"'.mysqli_escape_string($db,$_POST['fname']).'",
				"'.mysqli_escape_string($db,$_POST['lname']).'",
				"'.mysqli_escape_string($db,$_POST['email']).'",
				"'.mysqli_escape_string($db,$_POST['gender']).'",
				FALSE,
				"'.mysqli_escape_string($db,$_POST['stripeToken']).'",
				"'.mysqli_escape_string($db,$_POST['stripeEmail']).'"
			)';
		} // end if stripe error et al.
	} // end if payment cash
}
if ($q) // if query created
{
	mysqli_query($db, $q) or die(mysqli_error($db));
	
	//Mail Chimp
	$m = -1;	
	include("mc.php");
	$c = curl_init('https://'.substr($mailc,strpos($mailc,'-')+1).'.api.mailchimp.com/3.0/lists/9f83c50635/members/'.md5(strtolower($_POST['email'])));
	curl_setopt($c, CURLOPT_USERPWD, 'user:'.$mailc);
	curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_TIMEOUT, 10);
	curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($c, CURLOPT_POSTFIELDS, 
		json_encode(array(
			'email_address' => $_POST['email'],
			'status' => 'subscribed',
			'merge_fields'  => array(
				'FNAME'     => $_POST['fname'],
				'LNAME'     => $_POST['lname']
			)
		))
	);
	curl_exec($c);
	$m = curl_getinfo($c, CURLINFO_HTTP_CODE);
	curl_close($c);
	
	mail("president@qugs.org.au", "New Member", 
		"Name: ".($_POST['fname'] ? $_POST['fname'] : "N/A")." ".($_POST['lname'] ? $_POST['lname'] : "N/A").
		"\nEmail: ".($_POST['email'] ? $_POST['email'] : "N/A").
		"\nGender: ".($_POST['gender'] ? $_POST['gender'] : "N/A").
		"\nStudent: ".($_POST['student'] ? ("Yes".
			"\nNumber: ".($_POST['stuid'] ? $_POST['stuid'] : "N/A").
			"\nYear: ".($_POST['year'] ? $_POST['year'] : "N/A").
			"\nFaculty: ".($_POST['faculty'] ? $_POST['faculty'] : "N/A").
			"\nSchool: ".($_POST['school'] ? $_POST['school'] : "N/A").
			"\nInternational: ".($_POST['international'] ? "Yes" : "No")) 
		: "No").
		($_POST['payment'] == "cash" ? (
			"\nReceipt: ".($_POST['receipt'] ? $_POST['receipt'] : "N/A")):(
			"\nStripe Token: ".($_POST['stripeToken'] ? $_POST['stripeToken'] : "N/A").
			"\nStripe Email: ".($_POST['stripeEmail'] ? $_POST['stripeEmail'] : "N/A"))).
		"\nMailChimp: ".$m,
		"From: membership@qugs.org.au");
	echo "<style>@font-face{font-family: helv;src: url(Helv.otf);}
		a{color: #000000;text-decoration: underline;cursor: pointer;}
		body {font-size:8vmin;font-family: helv; padding: 8vmin;}</style>
		<body>Thank You, ".$_POST['fname'].", For Joining The Queensland University Games Society<br/>
		<a href='/join'>Click Here</a> Return To The Membership Form<br/>
		<a href='/'>Click Here</a> To Go To The Home Page</body></html>";
	exit();
} // end if query created
?>
<link rel="stylesheet" type="text/css" href="style.css"/>
<style>
body {
	font-size:4vmin;
	font-family: helv;
}
input {
	width:100%;
	font-size:4vmin;
	font-family: helv;
	vertical-align:middle;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
}
select {
	width:100%;
	font-size:4vmin;
	font-family: helv;
}
option {
	font-size:4vmin;
	font-family: helv;
}
input[type="checkbox"]{
	height:4vmin;
	width:4vmin;
	text-align:left;
}
table.tabform > tbody > tr > td:first-child {
	text-align:right;
	padding-right:1vmin;
}
table.tabform > tbody > tr > td:last-child {
	text-align:left;
	padding-left:1vmin;
}
</style>
<script language="javascript">
// shows/hides the row for a uq student
function uq_details()
{
	var s = document.getElementById("student").checked;
	var r = document.getElementsByClassName("studrow");
	for (var i = 0; i < r.length; i++)
	{
		r.item(i).style.visibility = s ? "visible" : "collapse";
	}
	document.getElementById("stuid").required = s;
	document.getElementById("year").required = s;
	document.getElementById("faculty").required = s;
	document.getElementById("school").required = s;
	if (s)
	{
		idcheck();
	}
	else
	{
		document.getElementById("stuid").setCustomValidity("");
	}
}

// shows/hides the rows for cash/card payments
function pay_details()
{
	var s = document.getElementById("payment").value == "cash";
	var r = document.getElementsByClassName("payrow");
	for (var i = 0; i < r.length; i++)
	{
		r.item(i).style.visibility = s ? "visible" : "collapse";
	}
	document.getElementById("receipt").required = s;
	document.getElementById("exec").required = s;
	document.getElementById("cashbuttonrow").style.visibility = s ? "visible" : "collapse";
	document.getElementById("stripebuttonrow").style.visibility = !s ? "visible" : "collapse";
}

// verifies the checksum of the student number
function idcheck()
{
	var n = parseInt(document.getElementById("stuid").value);
	if (isNaN(n) || n / Math.pow(10,7) < 1 || n / Math.pow(10,7) >= 10)
	{
		document.getElementById("stuid").setCustomValidity("Student Number Incorrect");
		return;
	}
	var k = 0;
	var c = [9, 7, 3, 9, 7, 3, 9].reverse();
	for (var i = 7; i > 0; i--)
	{
		k += c[i-1] * (n / Math.pow(10,i) | 0) % 10;
	}
	if ((k % 10) != (n%10))
	{
		document.getElementById("stuid").setCustomValidity("Student Number Incorrect");
		return;
	}
	document.getElementById("stuid").setCustomValidity("");
}

// updates the school select when a faculty is chosen
function fac_details()
{
	var s = document.getElementById("school");
	switch(document.getElementById("faculty").value)
	{
		case "bel":
			s.innerHTML = '<option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option>\
				<option value="buis">Business</option>\
				<option value="econ">Economics</option>\
				<option value="law">Law</option>\
				<option value="oth_">Other</option>';
			break;
		case "eait":
			s.innerHTML = '<option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option>\
				<option value="arch">Architecture</option>\
				<option value="chee">Chemical Engineering</option>\
				<option value="civ">Civil Engineering</option>\
				<option value="mech">Mechanical &amp; Mining Engineering</option>\
				<option value="itee">Information Technology &amp; Electrical Engineering</option>\
				<option value="oth_">Other</option>';
			break;
		case "hbs":
			s.innerHTML = '<option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option>\
				<option value="dent">Dentisty</option>\
				<option value="hrs">Health &amp; Rehabilitation Sciences</option>\
				<option value="hmns">Human Movement &amp; Nutrition Sciences</option>\
				<option value="nmsw">Nursing, Midwifery &amp; Social Work</option>\
				<option value="phar">Pharmacy</option>\
				<option value="psyc">Psycology</option>\
				<option value="oth_">Other</option>';
			break;
		case "med":
			s.innerHTML = '<option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option>\
				<option value="biom">Biomedical Sciences</option>\
				<option value="pubh">Public Health</option>\
				<option value="oth_">Other</option>';
			break;
		case "hss":
			s.innerHTML = '<option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option>\
				<option value="comm">Comminication &amp; Arts</option>\
				<option value="edu">Education</option>\
				<option value="hist">Historical &amp; Philosophical Inquiry</option>\
				<option value="lang">Languages &amp; Culture</option>\
				<option value="mus">Music</option>\
				<option value="poli">Political Science &amp; International Studies</option>\
				<option value="soci">Social Science</option>\
				<option value="oth_">Other</option>';
			break;
		case "sci":
			s.innerHTML = '<option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option>\
				<option value="agri">Agriculture &amp; Food Science</option>\
				<option value="biol">Biological Sciences</option>\
				<option value="envi">Earth &amp; Environmental Sciences</option>\
				<option value="chem">Chemical &amp; Molecular Biosciences</option>\
				<option value="math">Maths &amp; Phyisics</option>\
				<option value="vet">Veterinary Science</option>\
				<option value="oth_">Other</option>';
			break;
		case "oth":
			s.innerHTML = '<option value="oth_" selected>Other</option>';
			break;
	}
}

// the "submit" button triggers the stripe form
// a normal button triggers this, bypassing the stripe form
function cash()
{
	if(document.getElementById("form").checkValidity())
	{
		document.getElementById("form").submit();
	}
	// by "updating" the form inputs, they are checked for validitty, and highlighted if not
	document.getElementById("fname").value = document.getElementById("fname").value;
	document.getElementById("lname").value = document.getElementById("lname").value;
	document.getElementById("email").value = document.getElementById("email").value;
	document.getElementById("gender").value = document.getElementById("gender").value;
	document.getElementById("stuid").value = document.getElementById("stuid").value;
	document.getElementById("year").value = document.getElementById("year").value;
	document.getElementById("faculty").value = document.getElementById("faculty").value;
	document.getElementById("school").value = document.getElementById("school").value;
	document.getElementById("payment").value = document.getElementById("payment").value;
}

// pressing "enter" by default submits the form
// this function instead clicks the cash or stripe button as appropriate
function entre(e)
{
	if (e.keyCode == 13)
	{
		e.preventDefault();	
		if (document.getElementById("payment").value == "cash")
		{
			document.getElementById("cashbutton").click();
		}
		else if (document.getElementById("payment").value == "stripe")
		{
			document.getElementById("stripebutton").click();			
		}
	}
}

</script>
</head>
<body>
    <div class="navbarback">&nbsp;</div>
    <script>
	function navig()
	{
		var destin = document.getElementById("navig").value;
		if (destin != 0) window.location.href = destin;
	}
	</script>
    <div class="navbar"><table><tr>
    <td><img src="images/logosmall.png" height="50px" width="88px"/></td>
    <td>Queensland University Games Society</td>
    <td style="width:100%">&nbsp;</td>
    <td class="navdesk"><a href="./">Home</a></td>
    <td class="navdesk"><a href="collection">Collection</a></td>
    <td class="navdesk"><a href="about">About</a></td>
    <td class="navmob"><select autocomplete="off" onChange="navig();" id="navig"><option selected hidden value=0>Menu</option><option value="./">Home</option><option value="collection">Collection</option><option value="about">About</option></select></td></tr></table></div>
<form id="form" method="post" action="join.php">
<table align="center" class="tabform">
	<tr><td>Name:</td>
    	<td><span style="float:left; width:48%;"><input name="fname" id="fname" onKeyPress="entre(event)" placeholder="First Name" required/></span>
        <span style="float:right; width:48%;"><input name="lname" id="lname" onKeyPress="entre(event)" placeholder="Last Name" required/></span></td></tr>
    <tr><td>E&ndash;Mail:</td>
    	<td><input type="email" name="email" id="email" onKeyPress="entre(event)" placeholder="Student E&ndash;Mail or Not" required/></td></tr>
    <?php $gen = random_int(0,1);?>
    <tr><td>Gender:</td>
    	<td><select name="gender" id="gender" required><option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option><option value="<?php echo $gen ? "m" : "f";?>"><?php echo $gen ? "Male" : "Female";?></option><option value="<?php echo $gen ? "f" : "m";?>"><?php echo $gen ? "Female" : "Male";?></option><option value="o">Other</option></select></td></tr>
    <tr><td>UQ Student:</td>
    	<td><input type="checkbox" name="student" id="student" checked onChange="uq_details()" value="1"/></td></tr>
    <tr class="studrow"><td>Student Number:</td>
    	<td><input type="number" name="stuid" id="stuid" onKeyPress="entre(event)" placeholder="Eight Digits, No &ldquo;s&rdquo;" required onChange="idcheck()"/></td></tr>
    <tr class="studrow"><td>Year:</td>
    	<td><select name="year" id="year" required><option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option><option value="1">First</option><option value="2">Second</option><option value="3">Third</option><option value="4">Fourth</option><option value="5+">Fifth+</option><option value="post">Post&ndash;Graduate</option></select></td></tr>
    <tr class="studrow"><td>Faculty:</td>
    	<td><select name="faculty" id="faculty" onChange="fac_details()" required><option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option><option value="bel">Business, Economics and Law</option><option value="eait">Engineering, Architecture and Information Technology</option><option value="hbs">Health and Behavioural Sciences</option><option value="hss">Humanities and Social Sciences</option><option value="med">Medicine</option><option value="sci">Science</option><option value="oth">Other</option></select></td></tr>
    <tr class="studrow">
    	<td>School:</td><td><select name="school" id="school" required><option value="" selected>&ensp;&mdash;&ensp;Select a Faculty&ensp;&mdash;&ensp;</option></select></td></tr>
    <tr class="studrow"><td>International:</td>
    	<td><input type="checkbox" name="international" id="international" value="1"/></td></tr>
    <tr><td>Payment:</td>
    	<td><select name="payment" id="payment" onChange="pay_details()" required><option value="" selected>&ensp;&mdash;&ensp;Select an Option&ensp;&mdash;&ensp;</option><option value="cash">Cash</option><option value="stripe">Online (via <i>Stripe</i>)</option></select></td></tr>
    <tr class="payrow" style="visibility:collapse;"><td>Receipt Number:</td>
    	<td><input type="text" name="receipt" id="receipt" onKeyPress="entre(event)"/></td></tr>
    <tr class="payrow" style="visibility:collapse;"><td>Executive Password:</td>
    	<td><input type="password" name="exec" id="exec" onKeyPress="entre(event)"/></td></tr>
    <tr id="cashbuttonrow"><td>&nbsp;</td>
    	<td><input type="button" value="Join!" id="cashbutton" onClick="cash();" /></td></tr>
    <tr id="stripebuttonrow" style="visibility:collapse;"><td>&nbsp;</td>
    	<td><input type="submit" value="Pay &amp; Join!" id="stripebutton"/></td></tr>
</table>
<div style="display:none;">
	<script
        src="https://checkout.stripe.com/checkout.js"
        class="stripe-button"
        data-key="pk_test_vOUvPxmfmfK5CkEzDPvfvwDK"
        data-amount="550"
        data-name="Queensland University Games Society"
        data-description="QUGS Membership"
        data-image="images/logosmall.png"
        data-locale="auto"
        data-zip-code="true"
        data-currency="AUD"
        data-allow-remember-me="false">
    </script>
</div>
</form>
<?php
echo $b ? "" : '<script>
	document.getElementById("fname").value = "'.$_POST['fname'].'";
	document.getElementById("lname").value = "'.$_POST['lname'].'";
	document.getElementById("email").value = "'.$_POST['email'].'";
	document.getElementById("gender").value = "'.$_POST['gender'].'";
	document.getElementById("stuid").value = "'.$_POST['stuid'].'";
	document.getElementById("student").checked = '.($_POST['student'] ? 'true' : 'false').';
	uq_details()
	document.getElementById("year").value = "'.$_POST['year'].'";
	document.getElementById("faculty").value = "'.$_POST['faculty'].'";
	fac_details();
	document.getElementById("school").value = "'.$_POST['school'].'";
	document.getElementById("international").value = '.($_POST['international'] ? 'true' : 'false').';
	document.getElementById("payment").value = "'.$_POST['payment'].'";
	pay_details();
	document.getElementById("receipt").value = "'.$_POST['receipt'].'";
</script>';
echo $cash ? "" : '<script>alert("Executive Password Incorrect.");</script>';
echo $card ? "" : '<script>alert("An Error Occured With Payment.\nPlease Try Again, Or Pay With Cash (In Person).");</script>';
?>
</body>
</html>