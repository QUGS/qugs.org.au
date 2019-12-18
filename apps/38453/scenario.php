<!DOCTYPE html>
<html>
<head>
<title>Queensland University Games Society</title>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
<meta content="utf-8" http-equiv="encoding"/>
<meta name="author" content="Bradley Stone"/>
<meta name="version" content="v1.0"/>
<meta name="viewport" content="width=device-width, initial-scale=2.0">
<link rel="icon" href="images/fave<?php echo intval(date("z")) % 6 ?>.png"/>
<style>
html {
	width:100%;
	margin:0;
	padding:0;
}
body
{
	width:100%;
	margin:0;
	padding:0;
	text-align:center;
}
input
{
	height:12vw;
	width:96vw;
	margin:1vw;
	padding:0;
	border:0;
	font-size:8vw;
	background-color:#0000FF;
	color:#FFFFFF;
}
input:disabled
{
	background-color:#000000;
}
#listing
{
	height:12vw;
	width:96vw;
	margin:1vw;
	padding:0;
	border:0;
	font-size:8vw;
	color:#000000;	
}
#ordering
{
	width:96vw;
	margin:1vw;
	padding:0;
	border:0;
	font-size:4vw;
}
td
{
	width:10vw;
	margin:0;
	padding:0 1vw;
	border:0;
	text-align:right;
}
td:nth-child(3n+2)
{
	width:28vw;
	text-align:left;
}
</style>
<script>

var track = new Audio();
var playing = false;
var name = "";
var verbatim = "";
var locked = false;
var revealed = false;

function PlayMusic(file)
{
	playing = true;
	track.pause();
	track = new Audio(file);
	track.play();

	var buttons = document.getElementsByName("track");
	for (var i = 0; i < buttons.length; i++)
	{
		buttons[i].disabled = true;
	}

	document.getElementById("pause").value = "Pause";
	document.getElementById("listing").innerHTML = name;
	document.getElementById("lock").value = "Unlock";
	document.getElementById("rev").value = "Reveal";
	
	locked = true;
	revealed = false;
	document.getElementById("ordering").innerHTML = "";
}

function TestFirst()
{
	name = "First Test Run";
	PlayMusic("test_first.mp3");

	verbatim = "<tr><td>T+1</td><td>Zone Blue</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				+ "<tr><td>T+2</td><td>Zone White</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				+ "<tr><td>T+3</td><td>Zone Red</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				+ "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
}

function TestSecond()
{
	name = "Second Test Run";
	PlayMusic("test_second.mp3");

	verbatim = "<tr><td>T+1</td><td>Zone White</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				+ "<tr><td>T+2</td><td>Zone Red</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				+ "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				+ "<tr><td>T+4</td><td>Zone Blue</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
}

function Simulation()
{
	var r = Math.floor((Math.random() * 3) + 1);
	name = "Simulation #"+r;
	PlayMusic("sim_"+r+".mp3");

	verbatim = ["<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>T+5</td><td title='Unconfirmed'>[Zone Red]</td></tr>"
				 + "<tr><td>T+2</td><td>Zone Red</td><td>&nbsp;</td><td>T+6</td><td title='Serious'>ZONE BLUE</td></tr>"
				 + "<tr><td>T+3</td><td title='Serious'>ZONE WHITE</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>",

				"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+2</td><td title='Serious'>ZONE BLUE</td><td>&nbsp;</td><td>T+6</td><td title='Serious'>ZONE RED</td></tr>"
				 + "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>T+7</td><td title='Unconfirmed'>[Zone White]</td></tr>"
				 + "<tr><td>T+4</td><td>Zone White</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>",

				"<tr><td>T+1</td><td>Zone Blue</td><td>&nbsp;</td><td>T+5</td><td title='Serious'>ZONE WHITE</td></tr>"
				 + "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+3</td><td>Zone Red</td><td>&nbsp;</td><td>T+7</td><td>Zone Red</td></tr>"
				 + "<tr><td>T+4</td><td title='Unconfirmed'>[Zone Blue]</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"][r-1];
}

function AdvancedSimulation()
{
	var r = Math.floor((Math.random() * 3) + 1);
	name = "Adv. Simulation #"+r;
	PlayMusic("adv_sim_"+r+".mp3");

	verbatim = ["<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>T+5</td><td>Internal</td></tr>"
				 + "<tr><td>T+2</td><td>Internal</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+3</td><td>Zone White</td><td>&nbsp;</td><td>T+7</td><td title='Serious'>ZONE BLUE</td></tr>"
				 + "<tr><td>T+4</td><td title='Unconfirmed'>[Zone Red]</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>",

				"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+2</td><td title='Serious'>ZONE WHITE</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+3</td><td title='Unconfirmed'>[Zone Blue]</td><td>&nbsp;</td><td>T+7</td><td>Zone Red</td></tr>"
				 + "<tr><td>T+4</td><td title='Serious'>INTERNAL</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>",

				"<tr><td>T+1</td><td>Zone Red</td><td>&nbsp;</td><td>T+5</td><td title='Unconfirmed'>[Zone White]</td></tr>"
				 + "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>T+6</td><td>Internal</td></tr>"
				 + "<tr><td>T+3</td><td title='Serious'>INTERNAL</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+4</td><td>Zone Blue</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"][r-1];
}

function Mission()
{
	var r = Math.floor((Math.random() * 8) + 1);
	name = "Mission #"+r;
	PlayMusic("miss_"+r+".mp3");

	verbatim = ["<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>T+5</td><td>Internal</td></tr>" // One
				 + "<tr><td>T+2</td><td title='Serious'>ZONE WHITE</td><td>&nbsp;</td><td>T+6</td><td>Zone Blue</td></tr>"
				 + "<tr><td>T+3</td><td title='Unconfirmed'>[Internal]</td><td>&nbsp;</td><td>T+7</td><td title='Serious'>ZONE RED</td></tr>"
				 + "<tr><td>T+4</td><td>Zone Blue</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>",

				"<tr><td>T+1</td><td title='Unconfirmed'>[Zone Red]</td><td>&nbsp;</td><td>T+5</td><td>Zone White</td></tr>" // Two
				 + "<tr><td>T+2</td><td>Internal</td><td>&nbsp;</td><td>T+6</td><td title='Serious'>INTERNAL</td></tr>"
				 + "<tr><td>T+3</td><td>Zone White</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+4</td><td>Zone Red</td><td>&nbsp;</td><td>T+8</td><td>Zone Blue</td></tr>",

				"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>" // Three
				 + "<tr><td>T+2</td><td>Internal</td><td>&nbsp;</td><td>T+6</td><td title='Serious'>ZONE WHITE</td></tr>"
				 + "<tr><td>T+3</td><td>Zone Blue</td><td>&nbsp;</td><td>T+7</td><td title='Serious'>ZONE BLUE</td></tr>"
				 + "<tr><td>T+4</td><td>Internal</td><td>&nbsp;</td><td>T+8</td><td title='Unconfirmed'>[Zone Red]</td></tr>",

				"<tr><td>T+1</td><td>Zone Red</td><td>&nbsp;</td><td>T+5</td><td title='Serious'>INTERNAL</td></tr>" // Four
				 + "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>T+6</td><td title='Serious'>ZONE BLUE</td></tr>"
				 + "<tr><td>T+3</td><td title='Unconfirmed'>[Zone White]</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+4</td><td title='Serious'>ZONE RED</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>",

				"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>T+5</td><td>Zone Red</td></tr>" // Five
				 + "<tr><td>T+2</td><td title='Serious'>ZONE BLUE</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+3</td><td title='Serious'>INTERNAL</td><td>&nbsp;</td><td>T+7</td><td title='Unconfirmed'>[Internal]</td></tr>"
				 + "<tr><td>T+4</td><td>Zone Red</td><td>&nbsp;</td><td>T+8</td><td>Zone White</td></tr>",

				"<tr><td>T+1</td><td>Zone Blue</td><td>&nbsp;</td><td>T+5</td><td>Zone Blue</td></tr>" // Six
				 + "<tr><td>T+2</td><td>Internal</td><td>&nbsp;</td><td>T+6</td><td>Internal</td></tr>"
				 + "<tr><td>T+3</td><td title='Serious'>ZONE WHITE</td><td>&nbsp;</td><td>T+7</td><td title='Unconfirmed'>[Zone White]</td></tr>"
				 + "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>T+8</td><td>Zone Red</td></tr>",

				"<tr><td>T+1</td><td title='Unconfirmed'>[Zone Blue]</td><td>&nbsp;</td><td>T+5</td><td>Zone White</td></tr>" // Seven
				 + "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+3</td><td title='Serious'>ZONE RED</td><td>&nbsp;</td><td>T+6</td><td>Zone Red</td></tr>"
				 + "<tr><td>T+4</td><td title='Serious'>INTERNAL</td><td>&nbsp;</td><td>T+8</td><td>Zone White</td></tr>",

				"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>T+5</td><td title='Serious'>ZONE WHITE</td></tr>" // Eight
				 + "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"
				 + "<tr><td>T+3</td><td>Internal</td><td>&nbsp;</td><td>T+7</td><td title='Serious'>ZONE RED</td></tr>"
				 + "<tr><td>T+4</td><td title='Serious'>ZONE BLUE</td><td>&nbsp;</td><td>T+8</td><td title='Unconfirmed'>[Zone Blue]</td></tr>"][r-1];
}

function Pause()
{
	if (playing)
	{
		track.pause();
		playing = false;
		document.getElementById("pause").value = "Resume";
	}
	else
	{
		track.play();
		playing = true;
		document.getElementById("pause").value = "Pause";
	}
}

function Unlock()
{
	var buttons = document.getElementsByName("track");
	locked = !locked
	for (var i = 0; i < buttons.length; i++)
	{
		buttons[i].disabled = locked;
	}
	document.getElementById("lock").value = locked ? "Unlock" : "Lock";
}

function Reveal()
{
	revealed = !revealed;
	document.getElementById("ordering").innerHTML = revealed ? verbatim : "";
	document.getElementById("rev").value = revealed ? "Hide" : "Reveal";
}
</script>

<body>
<input type="button" value="First Test Run" name="track" onclick="TestFirst()"><br>
<input type="button" value="Second Test Run" name="track" onclick="TestSecond()"><br>
<input type="button" value="Simulation" name="track" onclick="Simulation()"><br>
<input type="button" value="Advanced Simulation" name="track" onclick="AdvancedSimulation()"><br>
<input type="button" value="Mission" name="track" onclick="Mission()"><br>

<p id="listing"></p>

<input type="button" value="Pause" id="pause" onclick="Pause()"><br>
<input type="button" value="Unlock" id="lock" onclick="Unlock()"><br>
<input type="button" value="Reveal" id="rev" onclick="Reveal()"><br>

<table id="ordering"></table>

</body>
</html>