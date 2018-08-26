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
table {
	border-collapse:collapse;
}
tr {
}
td {
	height:512px;
	font-size:192px;
	vertical-align:middle;
	text-align:center;
	border:0;
	margin:0;
	padding:0;
}
td:last-child {
	text-align:right;
}
img {
	width:512px;
	height:512px;
	border:0;
	margin:0;
	padding:0;
	display:block;
}
#table input
{
	width:224px;
	height:224px;
	font-size:100%;
}
#dialog input
{
	height:256px;
	width:1536px;
	font-size:100%;
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
	document.getElementById("train_"+t+"_count").innerHTML = "&times;" + track[t];
	document.getElementById("train_"+t+"_score").innerHTML = "=&nbsp;+" + delta[t] * track[t];
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
	document.getElementById("trains_remaining").innerHTML = (stock <= 2 ? '<img width="96" height="96" style="width:96px;height:96px;display:inline;vertical-align:text-bottom;" src="images/14996_clock.png"/>&nbsp;' : '') + stock + " Train"+(stock == 1 ? "" : "s")+" Remaining";
	
	for (var key in desti) 
	{
		score += desti[key];
		tic_s += desti[key] > 0 ? 1 : 0;
		tic_f += desti[key] < 0 ? 1 : 0;
	}	
	document.getElementById("ticket_complete").innerHTML = (tic_s + tic_f)+" Ticket"+(tic_s + tic_f == 1 ? "" : "s")+" Complete ("+tic_s+" &amp; "+tic_f+")";
	
	document.getElementById("score").innerHTML = (score >= 0 ? "+" : "&minus;") + ((score >= 0 ? 1 : -1) * score);
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
		var points = v * parseInt(document.getElementById("ticket_val").value)
		if (isNaN(points) || points <= 0)
		{
			return;
		}
		desti[ticks] = points;
		ticks++;
		document.getElementById("newticket").outerHTML = '<tr height="512" id="ticket_'+ticks+'"><td><img src="images/14996_ticket_'+(v==1 ? 'pass' : 'fail')+'.png" width="512" height="512"/></td> \
			<td colspan="2"><img src="images/14996_ticket_destroy.png" width="512" height="512" onClick="destroy('+ticks+')"/></td> \
			<td>=&nbsp;'+(v==1 ? '+' : '&minus;')+(v*points)+'</td></tr>\
			<tr height="512" id="newticket"><td>&nbsp;</td> \
			<td colspan="2"><img src="images/14996_ticket_plus.png" width="512" height="512" onClick="newticket()"/></td> \
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
	delete desti[k];
	updatescore();
}

function station(s)
{
	stati += s;
	stati = Math.max(0, Math.min(3, stati));
	document.getElementById("station_count").innerHTML = "&times;" + stati;
	document.getElementById("station_score").innerHTML = "=&nbsp;+" + 4 * stati;
	updatescore();
}

function longest()
{
	longg = !longg;
	document.getElementById("longest_thumb").src = longg ? "images/14996_longest_lose.png" : "images/14996_longest_get.png";
	document.getElementById("longest_score").innerHTML = longg ? "=&nbsp;+10" : "=&nbsp;+0";
	updatescore();
}
</script>
</head>
<body>
<table id="table"><tr height="512"><td width="512"><img src="images/14996_train_1.png" width="512" height="512"/></td>
	<td id="train_1_count" width="256">&times;0</td>
    <td width="256"><input type="button" value="+" onClick="train(1, 1);"/><br/><input type="button" value="&minus;" onClick="train(1, -1);"/></td>
    <td id="train_1_score" width="512">=&nbsp;+0</td></tr>
<tr height="512"><td><img src="images/14996_train_2.png" width="512" height="512"/></td>
	<td id="train_2_count">&times;0</td>
    <td><input type="button" value="+" onClick="train(2, 1);"/><br/><input type="button" value="&minus;" onClick="train(2, -1);"/></td>
    <td id="train_2_score">=&nbsp;+0</td></tr>
<tr height="512"><td><img src="images/14996_train_3.png" width="512" height="512"/></td>
	<td id="train_3_count">&times;0</td>
    <td><input type="button" value="+" onClick="train(3, 1);"/><br/><input type="button" value="&minus;" onClick="train(3, -1);"/></td>
    <td id="train_3_score">=&nbsp;+0</td></tr>
<tr height="512"><td><img src="images/14996_train_4.png" width="512" height="512"/></td>
	<td id="train_4_count">&times;0</td>
    <td><input type="button" value="+" onClick="train(4, 1);"/><br/><input type="button" value="&minus;" onClick="train(4, -1);"/></td>
    <td id="train_4_score">=&nbsp;+0</td></tr>
<tr height="512"><td><img src="images/14996_train_6.png" width="512" height="512"/></td>
	<td id="train_6_count">&times;0</td>
    <td><input type="button" value="+" onClick="train(6, 1);"/><br/><input type="button" value="&minus;" onClick="train(6, -1);"/></td>
    <td id="train_6_score">=&nbsp;+0</td></tr>
<tr height="512"><td><img src="images/14996_train_8.png" width="512" height="512"/></td>
	<td id="train_8_count">&times;0</td>
    <td><input type="button" value="+" onClick="train(8, 1);"/><br/><input type="button" value="&minus;" onClick="train(8, -1);"/></td>
    <td id="train_8_score">=&nbsp;+0</td></tr>
<tr><td colspan="4" id="trains_remaining" style="font-size:96px; height:96px">45 Trains Remaining</td>
<tr height="512" id="newticket"><td>&nbsp;</td>
	<td colspan="2"><img src="images/14996_ticket_plus.png" width="512" height="512" onClick="newticket()"/></td>
    <td>&nbsp;</td></tr>
<tr><td colspan="4" id="ticket_complete" style="font-size:96px; height:96px">0 Tickets Complete (0 &amp; 0)</td>
<tr height="512"><td><img src="images/14996_stations.png" width="512" height="512"/></td>
	<td id="station_count">&times;3</td>
    <td><input type="button" value="+" onClick="station(1);"/><br/><input type="button" value="&minus;" onClick="station(-1);"/></td>
    <td id="station_score">=&nbsp;+12</td></tr>
<tr height="512"><td><img src="images/14996_longest.png" width="512" height="512"/></td>
	<td colspan="2"><img src="images/14996_longest_get.png" width="512" height="512" onClick="longest();" id="longest_thumb" /></td>
    <td id="longest_score">=&nbsp;+0</td></tr>
<tr style="border-top:4px solid black;"><td style="font-size:384px;text-align:right;">&Sigma;</td><td colspan="3" id="score" style="font-size:384px;">+12</td></tr></table>
<div id="dialog" style="font-size:192px;display:none;text-align:center;width:1536px;">New Ticket<br/>
	<input type="number" id="ticket_val" style="text-align:center;" placeholder="Value" min="1"/><br/>
	<input type="button" value="Sucsess" onClick="ticket(1);"/><br/>
	<input type="button" value="Fail" onClick="ticket(-1);"/><br/>
	<input type="button" value="Cancel" onClick="ticket(0);"/></div>
</body>
</html>