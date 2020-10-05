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
    body
    {
      font-family: "Garamond";
      font-size: 4vh;
	  background: black;
    }
    select
    {
      font-size: 4vh;
      font-family: "Garamond";
      background: none;
	  width: 100%;
	  color: white;
    }
    input
    {
      font-family: "Garamond";
      font-size: 4vh;
	  background: black;
	  color: white;
    }
	.strategy td
	{
		padding: 0.5vh 1vw;
		border: none;
		vertical-align: middle;
		height: 8vh;
	}
	.cell_num
	{
		width: 2vw;
	}
	.cell_title
	{
		width: 16vw;
		font-weight: bold;
	}
	.cell_name
	{
		width: 24vw;
	}
	.cell_icon
	{
		width: 6vw;
		padding: 0 1vw;
		margin: 0;
		text-align: right;
	}
	.cell_fact
	{
		width: 24vw;
		font-style: italic;
		text-align: right;
	}
	img
	{
		height: 4vw;
		padding: 0;
		margin: 0;
		vertical-align: middle;
		filter: drop-shadow(1px 1px 0 white)
				drop-shadow(-1px 1px 0 white)
				drop-shadow(1px -1px 0 white)
				drop-shadow(-1px -1px 0 white);
	}
	.strategy select
	{
	    -o-appearance: none;
	    -ms-appearance: none;
	    -webkit-appearance: none;
	    -moz-appearance: none;
	    appearance: none;
	}
	.null_0
	{
		background-color: black;
		color: white;
	}
	.choose_0
	{
		background-color: black;
		color: white;
	}
	.null_1
	{
		background-color: black;
		color: #ea1c24;
	}
	.choose_1
	{
		background-color: #ea1c24;
		color: white;
	}
	.null_2
	{
		background-color: black;
		color: #f7961e;
	}
	.choose_2
	{
		background-color: #f7961e;
		color: white;
	}
	.null_3
	{
		background-color: black;
		color: #fef000;
	}
	.choose_3
	{
		background-color: #fef000;
		color: white;
	}
	.null_4
	{
		background-color: black;
		color: #37b349;
	}
	.choose_4
	{
		background-color: #37b349;
		color: white;
	}
	.null_5
	{
		background-color: black;
		color: #00a9a0;
	}
	.choose_5
	{
		background-color: #00a9a0;
		color: white;
	}
	.null_6
	{
		background-color: black;
		color: #008dd3;
	}
	.choose_6
	{
		background-color: #008dd3;
		color: white;
	}
	.null_7
	{
		background-color: black;
		color: #164ba0;
	}
	.choose_7
	{
		background-color: #164ba0;
		color: white;
	}
	.null_8
	{
		background-color: black;
		color: #792c91;
	}
	.choose_8
	{
		background-color: #792c91;
		color: white;
	}
  </style>
  <script>
    
	var factions = {"arborec": "The Arborec",
	"letnev": "The Barony of Letnev",
	"saar": "The Clan of Saar",
	"muaat": "The Embers of Muaat",
	"hacan": "The Emirates of Hacan",
	"sol": "The Federation of Sol",
	"creuss": "The Ghosts of Creuss",
	"l1z1x": "The L1Z1X Mindnet",
	"mentak": "The Mentak Coalition",
	"naalu": "The Naalu Collectinve",
	"nekro": "The Nekro Virus",
	"norr": "The Sardaak N'orr",
	"jolnar": "The Universities of Jol-Nar",
	"winnu": "The Winnu",
	"xxcha": "The Xxcha Kingdom",
	"yin": "The Yin Brotherhood",
	"yssaril": "The Yssaril Tribes"}

    function start()
    {
        var maindiv = document.getElementById("main");
	    players = [];
	    n = 0;
	    naalu = "";
	    var options = '<option value="">&nbsp;</option>';
	    
	    for (var i=1; i<=6; i++)
	    {
		    var name = document.getElementById("p"+i+"name").value;
		    var faction = document.getElementById("p"+i+"fact").value;
		    if (name)
		    {
		  	    n += 1;
		  	    players[name] = faction;
		  	    options += '<option value="'+name+'">'+name+'</option>'
		    }
		    if (faction == "naalu")
		    {
		  	    naalu = name;
		    }
	  }
	  
          
        maindiv.innerHTML='\
            <div style="position:absolute; top:50%; right:50%; width:72vw; margin-right:-36vw; height:80vh; margin-top:-40vh;">\
            <table align="center" cellspacing="0" cellpadding="0" class="strategy">'
		    + (naalu ? '\
		    <tr id="strat_0" class="null_0"><td class="cell_num" id="num_0" onclick="pass(0)">0</td>\
		        <td class="cell_title"><select id="naalu_strat" onchange="naalu_strat()">\
		    	    <option value="">-</option>\
		    	    <option value=1>Leadership</option>\
		    		<option value=2>Diplomacy</option>\
		    		<option value=3>Politics</option>\
		    		<option value=4>Construction</option>\
		    		<option value=5>Trade</option>\
		    		<option value=6>Warefare</option>\
		    		<option value=7>Technology</option>\
		    		<option value=8>Imperial</option></select></td></td>\
		    	<td class="cell_name"><select id="play0" onchange="strategy(0)">'+options+'</select></td>\
		    	<td class="cell_fact" id="fact_0">&nbsp;</td>\
		    	<td class="cell_icon" id="icon_0">&nbsp;</td></tr>' : '') +
		    '<tr id="strat_1" class="null_1"><td class="cell_num" id="num_1" onclick="pass(1)">1</td>\
		        <td class="cell_title" id="title_1">Leadership</td>\
		    	<td class="cell_name"><select id="play1" onchange="strategy(1)">'+options+'</select></td>\
		    	<td class="cell_fact" id="fact_1">&nbsp;</td>\
		    	<td class="cell_icon" id="icon_1">&nbsp;</td></tr>\
		    <tr id="strat_2" class="null_2"><td class="cell_num" id="num_2" onclick="pass(2)">2</td>\
		        <td class="cell_title" id="title_2">Diplomacy</td>\
		    	<td class="cell_name"><select id="play2" onchange="strategy(2)">'+options+'</select></td>\
		    	<td class="cell_fact" id="fact_2">&nbsp;</td>\
		    	<td class="cell_icon" id="icon_2">&nbsp;</td></tr>\
		    <tr id="strat_3" class="null_3"><td class="cell_num" id="num_3" onclick="pass(3)">3</td>\
		        <td class="cell_title" id="title_3">Politics</td>\
		    	<td class="cell_name"><select id="play3" onchange="strategy(3)">'+options+'</select></td>\
		    	<td class="cell_fact" id="fact_3">&nbsp;</td>\
		    	<td class="cell_icon" id="icon_3">&nbsp;</td></tr>\
		    <tr id="strat_4" class="null_4"><td class="cell_num" id="num_4" onclick="pass(4)">4</td>\
		        <td class="cell_title" id="title_4">Construction</td>\
		    	<td class="cell_name"><select id="play4" onchange="strategy(4)">'+options+'</select></td>\
		    	<td class="cell_fact" id="fact_4">&nbsp;</td>\
		    	<td class="cell_icon" id="icon_4">&nbsp;</td></tr>\
		    <tr id="strat_5" class="null_5"><td class="cell_num" id="num_5" onclick="pass(5)">5</td>\
		        <td class="cell_title" id="title_5">Trade</td>\
		    	<td class="cell_name"><select id="play5" onchange="strategy(5)">'+options+'</select></td>\
		    	<td class="cell_fact" id="fact_5">&nbsp;</td>\
		    	<td class="cell_icon" id="icon_5">&nbsp;</td></tr>\
		    <tr id="strat_6" class="null_6"><td class="cell_num" id="num_6" onclick="pass(6)">6</td>\
		        <td class="cell_title" id="title_6">Warfare</td>\
		    	<td class="cell_name"><select id="play6" onchange="strategy(6)">'+options+'</select></td>\
		    	<td class="cell_fact" id="fact_6">&nbsp;</td>\
		    	<td class="cell_icon" id="icon_6">&nbsp;</td></tr>\
		    <tr id="strat_7" class="null_7"><td class="cell_num" id="num_7" onclick="pass(7)">7</td>\
		        <td class="cell_title" id="title_7">Technology</td>\
		    	<td class="cell_name"><select id="play7" onchange="strategy(7)">'+options+'</select></td>\
		    	<td class="cell_fact" id="fact_7">&nbsp;</td>\
		    	<td class="cell_icon" id="icon_7">&nbsp;</td></tr>\
		    <tr id="strat_8" class="null_8"><td class="cell_num" id="num_8" onclick="pass(8)">8</td>\
		        <td class="cell_title" id="title_8">Imperial</td>\
		    	<td class="cell_name"><select id="play8" onchange="strategy(8)">'+options+'</select></td>\
		    	<td class="cell_fact" id="fact_8">&nbsp;</td>\
		    	<td class="cell_icon" id="icon_8">&nbsp;</td></tr>\
            </table>\
            ';

	    if (naalu)
	    {
		    document.getElementById("play0").value = naalu;
			strategy(0);
	    }
    }
	
	function strategy(s)
	{
		var name = document.getElementById("play"+s).value
		if (name == "")
		{
			document.getElementById("strat_"+s).className = "null_"+s;
			document.getElementById("icon_"+s).innerHTML = "&nbsp;";
			document.getElementById("fact_"+s).innerHTML = "&nbsp;";
		}
		else
		{
			document.getElementById("strat_"+s).className = "choose_"+s;
			if (players[name])
			{
				document.getElementById("icon_"+s).innerHTML = '<img src="ti_'+players[name]+'.png"/>';
				document.getElementById("fact_"+s).innerHTML = factions[players[name]];
			}
		}
	}
	
	function naalu_strat()
	{
		for (var i=1; i<=8; i++)
		{
			if (document.getElementById("play"+i).value == "")
			{
				document.getElementById("title_"+i).style.textDecorationLine = "none";
			}
		}
		if (document.getElementById("naalu_strat").value)
		{
			document.getElementById("title_"+document.getElementById("naalu_strat").value).style.textDecorationLine = "line-through";
			document.getElementById("strat_0").className = "choose_"+document.getElementById("naalu_strat").value;
		}
		else
		{
			document.getElementById("strat_0").className = "null_0";
		}
	}
	
	function pass(s)
	{
		doohicky = document.getElementById("num_"+s);
		if (isNaN(doohicky.innerHTML))
		{
			doohicky.innerHTML = s;
		}
		else
		{
			doohicky.innerHTML = "&times;";
		}
	}
  </script>
</head>
<body>
  <div id="main">
  <div style="position:absolute; top:50%; right:50%; width:50vw; margin-right:-25vw; height:12em; margin-top:-6em;">
    <form onsubmit="start();return false;">
  <table align="center">
  <col width="24vw"/><col width="24vw"/>
  <tr>
    <td><input type="text" id="p1name" name="name" style="width:24vw;"/></td>
	<td><select id="p1fact" name="fact" style="width:24vw;"/>
	<option value="">-- Select a Faction --</option>
	<option value="arborec">The Arborec</option>
	<option value="letnev">The Barony of Letnev</option>
	<option value="saar">The Clan of Saar</option>
	<option value="muaat">The Embers of Muaat</option>
	<option value="hacan">The Emirates of Hacan</option>
	<option value="sol">The Federation of Sol</option>
	<option value="creuss">The Ghosts of Creuss</option>
	<option value="l1z1x">The L1Z1X Mindnet</option>
	<option value="mentak">The Mentak Coalition</option>
	<option value="naalu">The Naalu Collectinve</option>
	<option value="nekro">The Nekro Virus</option>
	<option value="norr">The Sardaak N'orr</option>
	<option value="jolnar">The Universities of Jol-Nar</option>
	<option value="winnu">The Winnu</option>
	<option value="xxcha">The Xxcha Kingdom</option>
	<option value="yin">The Yin Brotherhood</option>
	<option value="yssaril">The Yssaril Tribes</option></select></td>
  </tr>
  <tr>
    <td><input type="text" id="p2name" name="name" style="width:24vw;"/></td>
	<td><select id="p2fact" name="fact" style="width:24vw;"/>
	<option value="">-- Select a Faction --</option>
	<option value="arborec">The Arborec</option>
	<option value="letnev">The Barony of Letnev</option>
	<option value="saar">The Clan of Saar</option>
	<option value="muaat">The Embers of Muaat</option>
	<option value="hacan">The Emirates of Hacan</option>
	<option value="sol">The Federation of Sol</option>
	<option value="creuss">The Ghosts of Creuss</option>
	<option value="l1z1x">The L1Z1X Mindnet</option>
	<option value="mentak">The Mentak Coalition</option>
	<option value="naalu">The Naalu Collectinve</option>
	<option value="nekro">The Nekro Virus</option>
	<option value="norr">The Sardaak N'orr</option>
	<option value="jolnar">The Universities of Jol-Nar</option>
	<option value="winnu">The Winnu</option>
	<option value="xxcha">The Xxcha Kingdom</option>
	<option value="yin">The Yin Brotherhood</option>
	<option value="yssaril">The Yssaril Tribes</option></select></td>
  </tr>
  <tr>
    <td><input type="text" id="p3name" name="name" style="width:24vw;"/></td>
	<td><select id="p3fact" name="fact" style="width:24vw;"/>
	<option value="">-- Select a Faction --</option>
	<option value="arborec">The Arborec</option>
	<option value="letnev">The Barony of Letnev</option>
	<option value="saar">The Clan of Saar</option>
	<option value="muaat">The Embers of Muaat</option>
	<option value="hacan">The Emirates of Hacan</option>
	<option value="sol">The Federation of Sol</option>
	<option value="creuss">The Ghosts of Creuss</option>
	<option value="l1z1x">The L1Z1X Mindnet</option>
	<option value="mentak">The Mentak Coalition</option>
	<option value="naalu">The Naalu Collectinve</option>
	<option value="nekro">The Nekro Virus</option>
	<option value="norr">The Sardaak N'orr</option>
	<option value="jolnar">The Universities of Jol-Nar</option>
	<option value="winnu">The Winnu</option>
	<option value="xxcha">The Xxcha Kingdom</option>
	<option value="yin">The Yin Brotherhood</option>
	<option value="yssaril">The Yssaril Tribes</option></select></td>
  </tr>
  <tr>
    <td><input type="text" id="p4name" name="name" style="width:24vw;"/></td>
	<td><select id="p4fact" name="fact" style="width:24vw;"/>
	<option value="">-- Select a Faction --</option>
	<option value="arborec">The Arborec</option>
	<option value="letnev">The Barony of Letnev</option>
	<option value="saar">The Clan of Saar</option>
	<option value="muaat">The Embers of Muaat</option>
	<option value="hacan">The Emirates of Hacan</option>
	<option value="sol">The Federation of Sol</option>
	<option value="creuss">The Ghosts of Creuss</option>
	<option value="l1z1x">The L1Z1X Mindnet</option>
	<option value="mentak">The Mentak Coalition</option>
	<option value="naalu">The Naalu Collectinve</option>
	<option value="nekro">The Nekro Virus</option>
	<option value="norr">The Sardaak N'orr</option>
	<option value="jolnar">The Universities of Jol-Nar</option>
	<option value="winnu">The Winnu</option>
	<option value="xxcha">The Xxcha Kingdom</option>
	<option value="yin">The Yin Brotherhood</option>
	<option value="yssaril">The Yssaril Tribes</option></select></td>
  </tr>
  <tr>
    <td><input type="text" id="p5name" name="name" style="width:24vw;"/></td>
	<td><select id="p5fact" name="fact" style="width:24vw;"/>
	<option value="">-- Select a Faction --</option>
	<option value="arborec">The Arborec</option>
	<option value="letnev">The Barony of Letnev</option>
	<option value="saar">The Clan of Saar</option>
	<option value="muaat">The Embers of Muaat</option>
	<option value="hacan">The Emirates of Hacan</option>
	<option value="sol">The Federation of Sol</option>
	<option value="creuss">The Ghosts of Creuss</option>
	<option value="l1z1x">The L1Z1X Mindnet</option>
	<option value="mentak">The Mentak Coalition</option>
	<option value="naalu">The Naalu Collectinve</option>
	<option value="nekro">The Nekro Virus</option>
	<option value="norr">The Sardaak N'orr</option>
	<option value="jolnar">The Universities of Jol-Nar</option>
	<option value="winnu">The Winnu</option>
	<option value="xxcha">The Xxcha Kingdom</option>
	<option value="yin">The Yin Brotherhood</option>
	<option value="yssaril">The Yssaril Tribes</option></select></td>
  </tr>
  <tr>
    <td><input type="text" id="p6name" name="name" style="width:24vw;"/></td>
	<td><select id="p6fact" name="fact" style="width:24vw;"/>
	<option value="">-- Select a Faction --</option>
	<option value="arborec">The Arborec</option>
	<option value="letnev">The Barony of Letnev</option>
	<option value="saar">The Clan of Saar</option>
	<option value="muaat">The Embers of Muaat</option>
	<option value="hacan">The Emirates of Hacan</option>
	<option value="sol">The Federation of Sol</option>
	<option value="creuss">The Ghosts of Creuss</option>
	<option value="l1z1x">The L1Z1X Mindnet</option>
	<option value="mentak">The Mentak Coalition</option>
	<option value="naalu">The Naalu Collectinve</option>
	<option value="nekro">The Nekro Virus</option>
	<option value="norr">The Sardaak N'orr</option>
	<option value="jolnar">The Universities of Jol-Nar</option>
	<option value="winnu">The Winnu</option>
	<option value="xxcha">The Xxcha Kingdom</option>
	<option value="yin">The Yin Brotherhood</option>
	<option value="yssaril">The Yssaril Tribes</option></select></td>
  </tr>
  <tr><td colspan=2 align="center"><input type="submit" value="Start" style="width:24vw;" /></td></tr>
  </table>  
  </form>
  </div>
  </div>
</body>
</html>
