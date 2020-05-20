<!DOCTYPE html>
<html>
<head>
<title>Queensland University Games Society</title>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
<meta content="utf-8" http-equiv="encoding"/>
<meta name="author" content="Bradley Stone"/>
<meta name="version" content="v1.4"/>
<link rel="icon" href="images/fave<?php echo intval(date("z")) % 6 ?>.png"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<style>
html
{
    margin: 0;
    padding: 0;
}
body
{
    margin: 0;
    padding: 1vw;
}
table
{
    border-collapse: collapse;
}
td
{
    width: 24vw;
    height: 24vw;
    vertical-align: middle;
    text-align: center;
    border: 0;
    margin: 0;
    padding: 0;
    font-size: 16vw; 
    user-select: none;
    	-webkit-touch-callout: none;
    	-webkit-user-select: none;
     	-khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
}
input
{
    width: 20vw;
    height: 20vw;
    font-size: 12vw;
    vertical-align: middle;
    text-align: center;
    border: 1vw solid black;
    margin: 1vw;
    padding: 0;
    color: #000000;
}
img
{
    height: 48vw;
    width: 48vw;
    border: 0;
    margin: 0;
    padding: 0;
}
.g input
{
    background-color: #00FF00;
}
.neg
{
    background-color: #888888 !important;
}
.r input
{
    background-color: #FF0000;
}
.y input
{
    background-color: #FFFF00;
}
#skul
{
    position: absolute;
    height: 20vw;
    width: 20vw;
    left: 39vw;
    top: 15vw;
    filter: drop-shadow(1px 1px 0 white)
            drop-shadow(-1px 1px 0 white)
            drop-shadow(1px -1px 0 white)
            drop-shadow(-1px -1px 0 white);
}
</style>
<script language="javascript">
var authority = 50;
var trade = 0;
var combat = 0;
var outpost = false;
function update(s, v)
{
    switch (s)
    {
        case "a":
            authority += v;
            break;
        case "t":
            trade += v;
            break;
        case "c":
            combat += v;
            break;
    }
    trade = Math.max(trade, 0);
    combat = Math.max(combat, 0);
    document.getElementById("auth").innerHTML = (authority < 0 ? "&minus;" : "" ) + Math.abs(authority);
    document.getElementById("skul").hidden = (authority > 0);
    document.getElementById("trad").innerHTML = trade;
    document.getElementById("comb").innerHTML = combat;
}
function endturn()
{
    trade = 0;
    combat = 0;
    document.getElementById("trad").innerHTML = trade;
    document.getElementById("comb").innerHTML = combat;   
}
function defend()
{
    outpost = !outpost;
    document.getElementById("outp").src = outpost ? "outpost.png" : "nooutpost.png";
    var el = document.getElementsByClassName(outpost ? "pos" : "neg");
    el[1].disabled  = outpost;
    el[1].className = outpost ? "neg" : "pos";
    el[0].disabled  = outpost;
    el[0].className = outpost ? "neg" : "pos";
}

var dclick = false;
function newauth()
{
    if (dclick)
    {
        var a = prompt("Enter Starting Authority Value", (authority > 0) ? authority : 50);
        if (!isNaN(parseInt(a)))
        {
            authority = parseInt(a);
        }
        else if (!(a === null || a == ""))
        {
            alert("Could Not Recognise Input");
        }
        document.getElementById("auth").innerHTML = (authority < 0 ? "&minus;" : "" ) + Math.abs(authority);
    document.getElementById("skul").hidden = (authority > 0);
    }
    dclick = true;
    setTimeout(function() {dclick=false;}, 200);
}
</script>
</head>
<body>
<table>
    <tr class="g"><td><input type="button" value="&minus;1" onclick="update('a', -1);" class="pos"/></td>
        <td colspan="2" rowspan="2" style="background-image: url('authority.jpg'); background-size:cover; width: 48vw;" id="auth" onclick="newauth();">50</td>
        <td><input type="button" value="+1" onclick="update('a', 1);"/></td></tr>
        <tr class="g"><td><input type="button" value="&minus;5" onclick="update('a', -5);" class="pos"/></td>
        <td><input type="button" value="+5" onclick="update('a', 5);"/></td></tr>
    <tr class="y"><td><input type="button" value="&minus;1" onclick="update('t', -1);"/></td>
        <td colspan="2" rowspan="2" style="background-image: url('trade.jpg'); background-size:cover; width: 48vw;" id="trad">0</td>
        <td><input type="button" value="+1" onclick="update('t', 1);"/></td></tr>
        <tr class="y"><td><input type="button" value="&minus;5" onclick="update('t', -5);"/></td>
        <td><input type="button" value="+5" onclick="update('t', 5);"/></td></tr>
    <tr class="r"><td><input type="button" value="&minus;1" onclick="update('c', -1);"/></td>
        <td colspan="2" rowspan="2" style="background-image: url('combat.jpg'); background-size:cover; width: 48vw;" id="comb">0</td>
        <td><input type="button" value="+1" onclick="update('c', 1);"/></td></tr>
        <tr class="r"><td><input type="button" value="&minus;5" onclick="update('c', -5);"/></td>
        <td><input type="button" value="+5" onclick="update('c', 5);"/></td></tr>
    <tr><td colspan="2" rowspan="2" style="height: 48vw;"><img src="reset.png" onclick="endturn();"/></td><td colspan="2" rowspan="2" style="height: 48vw;"><img src="nooutpost.png" onclick="defend();" id="outp"/></td></tr><tr></tr>
</table>
<img src="skull.png" id="skul" hidden onclick="newauth();"/>
</body>
</html>