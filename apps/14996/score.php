<!DOCTYPE html>
<html>
<head>
<title>Queensland University Games Society</title>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
<meta content="utf-8" http-equiv="encoding"/>
<meta name="author" content="Bradley Stone"/>
<meta name="version" content="v1.4"/>
<link rel="icon" href="images/fave<?php echo intval(date("z")) % 6 ?>.png"/>
<style>
html {
	margin:0;
	padding:0;
}
body
{
	margin:1vw;
	padding:0;
}
table {
	border-collapse:collapse;
}
tr {
	height:24vw;
}
td {
	height:24vw;
	font-size:12vw;
	vertical-align:middle;
	text-align:center;
	border:0;
	margin:0;
	padding:0;
	line-height:0;
	font-variant-numeric:tabular-nums;
}
td:last-child {
	text-align:right;
}
img
{
	width:24vw;
	height:24vw;
	border:0;
	margin:0;
	padding:0;
	display:block;
}
#table input
{
	width:12vw;
	height:12vw;
	font-size:8vw;
	background-color:#0000FF;
	color:#FFFFFF;
	text-align:center;
	vertical-align:middle;
	border:1vw solid white;
	margin:0;
	padding:0;
}
#dialog input[type="button"]
{
	height:24vw;
	width:96vw;
	font-size:16vw;
	background-color:#0000FF;
	color:#FFFFFF;
	border:1vw solid white;
	margin:0;
	padding:0;
}
#dialog input[type="number"]
{
	height:24vw;
	width:96vw;
	font-size:16vw;
	background-color:#FFFFFF;
	color:#0000FF;
	border:1vw solid #0000FF;
	margin:0;
	padding:0;
}
::placeholder
{
	color:#FFFFFF; 
	font-size:12vw;
	text-shadow:
		-4px -4px 0 #0000FF,
		 4px -4px 0 #0000FF,
		-4px 4px 0 #0000FF,
		 4px 4px 0 #0000FF;
}
</style>
<script language="javascript">
var track = {1:0, 2:0, 3:0, 4:0, 6:0, 8:0};
var delta = {1:1, 2:2, 3:4, 4:7, 6:15, 8:21};
var desti = {};
var ticks = 0;
var stati = 3;
var longg = false;
var scrol;
function train(t, d)
{
	
	track[t] += d;
	track[t] = track[t] < 0 ? 0 : track[t];
	document.getElementById("train_"+t+"_count").innerHTML = "&times;" + (track[t]<10 ? "&#8199;" : "")+ track[t];
	var s = delta[t] * track[t];
	document.getElementById("train_"+t+"_score").innerHTML = "=&#8199;+" + (s<100 ? "&#8199;" : "") + (s<10 ? "&#8199;" : "") + s;
	updatescore();
}

function updatescore()
{
	var score = 4 * stati + (longg ? 10 : 0);
	var stock = 45;
	var tic_s = 0;
	var tic_f = 0;
	
	[1,2,3,4,6,8].forEach(function(i)
	{
		stock -= i * track[i];
		score += delta[i] * track[i];
	});
	document.getElementById("trains_remaining").innerHTML = (stock <= 2 ? '&#x23F3;&#xFE0E;&#8199;' : '') + stock + " Train"+(stock == 1 ? "" : "s")+" Remaining";
	
	for (var key in desti) 
	{
		score += desti[key];
		tic_s += desti[key] > 0 ? 1 : 0;
		tic_f += desti[key] < 0 ? 1 : 0;
	}	
	document.getElementById("ticket_complete").innerHTML = tic_s + " Tickets Complete. " + tic_f + " Tickets Failed";
	var neg = score < 0;
	score *= (neg ? -1 : 1);
	document.getElementById("score").innerHTML = (neg ? "&minus;" : "+") + (score < 100 ? "&#8199;" : "") + (score < 10 ? "&#8199;" : "") + score;
}

function newticket()
{
	scrol = document.documentElement.scrollTop;
	document.getElementById("table").style.display = "none";
	document.getElementById("dialog").style.display = "block";
	document.documentElement.scrollTop = 0;
}

function ticket(v)
{
	if (v == 0)
	{
	}
	else
	{
		var points = parseInt(document.getElementById("ticket_val").value)
		if (isNaN(points) || points <= 0)
		{
			return;
		}
		ticks++;
		desti[String(ticks)] = v * points;
		document.getElementById("newticket").outerHTML = '<tr id="ticket_'+ticks+'"><td><img src="ticket_'+(v==1 ? 'pass' : 'fail')+'.png" width="512" height="512"/></td> \
			<td colspan="2"><img src="ticket_destroy.png" width="512" height="512" onClick="destroy('+ticks+')"/></td> \
			<td>=&#8199;' +(v==1 ? '+' : '&minus;') + (points<100 ? "&#8199;" : "") + (points<10 ? "&#8199;" : "") + points + '</td></tr>\
			<tr id="newticket"><td>&nbsp;</td> \
			<td colspan="2"><img src="ticket_plus.png" width="512" height="512" onClick="newticket()"/></td> \
			<td>&nbsp;</td>';
	}
	document.getElementById("table").style.display = "table";
	document.getElementById("dialog").style.display = "none";
	document.documentElement.scrollTop = scrol;
	document.getElementById("ticket_val").value = "";
	updatescore();
}

function destroy(k)
{
	document.getElementById("ticket_"+k).outerHTML = "";
	delete desti[String(k)];
	updatescore();
}

function station(s)
{
	stati += s;
	stati = Math.max(0, Math.min(3, stati));
	document.getElementById("station_count").innerHTML = "&times;&#8199;" + stati;
	document.getElementById("station_score").innerHTML = "=&#8199;+&#8199;" + (stati == 3 ? "" : "&#8199;") + (4 * stati);
	updatescore();
}

function longest()
{
	longg = !longg;
	document.getElementById("longest_thumb").src = longg ? "longest_lose.png" : "longest_get.png";
	document.getElementById("longest_score").innerHTML = longg ? "=&#8199;+&#8199;10" : "=&#8199;+&#8199;&#8199;0";
	updatescore();
}
</script>
</head>
<body>
<table id="table"><tr><td style="width:24vw;"><img src="train_1.png" width="512" height="512"/></td>
	<td id="train_1_count" style="width:20vw;">&times;&#8199;0</td>
    <td style="width:12vw;"><input type="button" value="+" onClick="train(1, 1);"/><br/><input type="button" value="&minus;" onClick="train(1, -1);"/></td>
    <td id="train_1_score" style="width:40vw;" >=&#8199;+&#8199;&#8199;0</td></tr>
<tr><td><img src="train_2.png" width="512" height="512"/></td>
	<td id="train_2_count">&times;&#8199;0</td>
    <td><input type="button" value="+" onClick="train(2, 1);"/><br/><input type="button" value="&minus;" onClick="train(2, -1);"/></td>
    <td id="train_2_score">=&#8199;+&#8199;&#8199;0</td></tr>
<tr><td><img src="train_3.png" width="512" height="512"/></td>
	<td id="train_3_count">&times;&#8199;0</td>
    <td><input type="button" value="+" onClick="train(3, 1);"/><br/><input type="button" value="&minus;" onClick="train(3, -1);"/></td>
    <td id="train_3_score">=&#8199;+&#8199;&#8199;0</td></tr>
<tr><td><img src="train_4.png" width="512" height="512"/></td>
	<td id="train_4_count">&times;&#8199;0</td>
    <td><input type="button" value="+" onClick="train(4, 1);"/><br/><input type="button" value="&minus;" onClick="train(4, -1);"/></td>
    <td id="train_4_score">=&#8199;+&#8199;&#8199;0</td></tr>
<tr><td><img src="train_6.png" width="512" height="512"/></td>
	<td id="train_6_count">&times;&#8199;0</td>
    <td><input type="button" value="+" onClick="train(6, 1);"/><br/><input type="button" value="&minus;" onClick="train(6, -1);"/></td>
    <td id="train_6_score">=&#8199;+&#8199;&#8199;0</td></tr>
<tr><td><img src="train_8.png" width="512" height="512"/></td>
	<td id="train_8_count">&times;&#8199;0</td>
    <td><input type="button" value="+" onClick="train(8, 1);"/><br/><input type="button" value="&minus;" onClick="train(8, -1);"/></td>
    <td id="train_8_score">=&#8199;+&#8199;&#8199;0</td></tr>
<tr style="height:6vw;"><td colspan="4" id="trains_remaining" style="font-size:4vw;height:6vw;line-height:1;">45 Trains Remaining</td>
<tr id="newticket"><td>&nbsp;</td>
	<td colspan="2"><img src="ticket_plus.png" width="512" height="512" onClick="newticket()"/></td>
    <td>&nbsp;</td></tr>
<tr style="height:6vw;"><td colspan="4" id="ticket_complete" style="font-size:4vw;height:6vw;line-height:1;">0 Tickets Complete. 0 Tickets Failed</td>
<tr><td><img src="stations.png" width="512" height="512"/></td>
	<td id="station_count">&times;&#8199;3</td>
    <td><input type="button" value="+" onClick="station(1);"/><br/><input type="button" value="&minus;" onClick="station(-1);"/></td>
    <td id="station_score">=&#8199;+&#8199;12</td></tr>
<tr><td><img src="longest.png" width="512" height="512"/></td>
	<td colspan="2"><img src="longest_get.png" width="512" height="512" onClick="longest();" id="longest_thumb" /></td>
    <td id="longest_score">=&#8199;+&#8199;&#8199;0</td></tr>
<tr style="border-top:4px solid black;height:30vw;">
	<td style="height:30vw;font-size:24vw;text-align:right;">&Sigma;</td>
    <td colspan="3" id="score" style="height:30vw;font-size:24vw;">+&#8199;12</td></tr></table>
<div id="dialog" style="font-size:16vw;display:none;text-align:center;width:96vw;">New Ticket<br/>
	<input type="number" id="ticket_val" style="text-align:center;" placeholder="Value" min="1"/><br/>
	<input type="button" value="Sucsess" onClick="ticket(1);"/><br/>
	<input type="button" value="Fail" onClick="ticket(-1);"/><br/>
	<input type="button" value="Cancel" onClick="ticket(0);"/></div>
</body>
</html>