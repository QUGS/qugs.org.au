<!DOCTYPE html>
<html>
<head>
<title>Queensland University Games Society</title>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
<meta content="utf-8" http-equiv="encoding"/>
<meta name="author" content="Bradley Stone"/>
<meta name="version" content="v1.4"/>
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
}
table {
	border-collapse:collapse;
	border:0;
	margin:0;
	padding:0;
	font-size:8vw;
}
tr {
	border:0;
	margin:0;
	padding:0;
}
td {
	border:0;
	margin:0;
	vertical-align:middle;
}
td:first-child {
	text-align:right;
	font-family:"Consolas", "Lucida Console", monospace;
	padding-right:4vw;
}
input {
	height:12vw;
	width:96vw;
	margin:0;
	padding:0;
	border:0;
	font-size:8vw;
	background-color:#0000FF;
	color:#FFFFFF;
}
input:disabled {
	background-color:#000000;
}
div {
	margin:0;
	padding:2vw;
	border:0;
}
</style>
<script language="javascript">
var d = [
	{rank:  1, char: "Parrot"},
	{rank:  2, char: "Monkey"},
	{rank:  3, char: "Begger"},
	{rank:  4, char: "Recruiter"},
	{rank:  5, char: "Cabin Boy"},
	{rank:  6, char: "Preacher"},
	{rank:  7, char: "Barkeep"},
	{rank:  8, char: "Waitress"},
	{rank:  9, char: "Carpenter"},
	{rank: 10, char: "French Officer"},
	{rank: 11, char: "Voodoo Witch"},
	{rank: 12, char: "Freed Slace"},
	{rank: 13, char: "Mutineer"},
	{rank: 14, char: "Brute"},
	{rank: 15, char: "Gunner"},
	{rank: 16, char: "Topman"},
	{rank: 17, char: "Spanish Spy"},
	{rank: 18, char: "Cook"},
	{rank: 19, char: "Bosun"},
	{rank: 20, char: "Amorer"},
	{rank: 21, char: "Merchant"},
	{rank: 22, char: "Surgeon"},
	{rank: 23, char: "Treasurer"},
	{rank: 24, char: "Gambler"},
	{rank: 25, char: "Governor&rsquo;s Daughter"},
	{rank: 26, char: "Quarter&ndash;Master"},
	{rank: 27, char: "Granny Wetta"},
	{rank: 28, char: "First Mate"},
	{rank: 29, char: "Captain"},
	{rank: 30, char: "Spanish Governor"},
];
for (var i = 0; i < d.length; i++)
{
	var j = Math.floor(Math.random() * i);
	var t = d[i];
	d[i] = d[j];
	d[j] = t;
}

function week(w)
{
	var r = [];
	for (var i = 0; i < ((w == 1) ? 9 : 6); i++)
	{
		r.push(d.pop());
	}
	r.sort(function(a,b){return a.rank-b.rank;});
	var s = "<table>";
	for (var i = 0; i < ((w == 1) ? 9 : 6); i++)
	{
		var c = r.pop();
		s += "<tr><td>"+c.rank+"</td><td>"+c.char+"</td></tr>";
	}
	s += "</table>";
	document.getElementById("list"+w).innerHTML = s;
	if (w!=3)
	{
		document.getElementById("list"+(w+1)).innerHTML = "<input type=\"button\" value=\"Week "+(w==1 ? "Two" : "Three")+"\" onClick=\"week("+(w+1)+")\"/>";
	}
}

</script>
</head>
<body>
<div id="list1"><input type="button" value="Week One" onClick="week(1)"/></div>
<div id="list2"><input type="button" value="Week Two" disabled/></div>
<div id="list3"><input type="button" value="Week Three" disabled/></div>
</body>
</html>