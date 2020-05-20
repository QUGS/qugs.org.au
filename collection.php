<?php
include("db.php");

$maint_sub = false;
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $maint_game = explode("|", mysqli_escape_string($db,$_POST['maintgame']), 2);
    $maint_desc = mysqli_escape_string($db,$_POST['maintdesrip']);
    $maint_q = 'INSERT INTO Maintenance (game, problem) VALUES ("'.$maint_game[0].'", "'.$maint_desc.'")';
    $maint_l = mysqli_query($db, $maint_q) or die(mysqli_error($db));
    mail("president@qugs.org.au", "Maintenance Request", "Game: ".$maint_game[1]."\nIssue: ".$maint_desc, "From: maintenance@qugs.org.au");
    $maint_sub = true;
}

// Select all games from database
$games_q = "SELECT bgg, name, playmin, playmax, timeplay, link, expand, app FROM Collection ORDER BY sortname";
$games_l = mysqli_query($db, $games_q) or die(mysqli_error($db));

// String to form club's games table
$table = "";
// BGG IDs of all games, to later get BGG ratings
$bggid = array();
$select = "<option value='0'>&ensp;&ndash;&ensp;Select A Game&ensp;&ndash;&ensp;</option>\n";
$option = "";

while($game = mysqli_fetch_assoc($games_l))
{
    $row = "\t<tr class=\"gamerow\" data-minp=".$game['playmin']." data-maxp=".$game['playmax']." data-time=".$game['timeplay']." data-bggid=".$game['bgg'].">
        <td><a href=\"".$game['link']."\">".$game['name']."</a>";
    // If the game has expansions, add them as a new line to the first cell
    if ($game['expand'])
    {
        $expand_q = "SELECT name, link FROM Expansions WHERE base = ".$game['bgg']." ORDER BY sort";
        $expand_l = mysqli_query($db, $expand_q) or die(mysqli_error($db));
        while($exp = mysqli_fetch_assoc($expand_l))
        {
            $row .= "<br/>\n\t\t\t+&ensp;<a href=\"".$exp['link']."\">".$exp['name']."</a>";
        }
    }
    $row .= "</td>
        <td>".$game['playmin'].($game['playmin']==$game['playmax'] ? "" : "-".$game['playmax'])."</td>
        <td>".($game['timeplay'] >= 60 ? intval($game['timeplay']/60)." hr ": "").($game['timeplay'] % 60 != 0 ? $game['timeplay']%60 ." min": "")."</td>
        <td id=s".$game['bgg'].">[Loading]</td>
        <td><a href=\"rules/r".$game['bgg'].".pdf\">Link</a></td>
        ".($game['app'] ? "<td>".$game['app']."</td>" : "<td style='color:#808080;'>N/A</td>")."</tr>\n";

    $table .= $row;
    $select .= "<option value='".$game['bgg']."|".$game['name']."'>".$game['name']."</option>\n";
    $option .= "{name:'".$game['name']."', numb:".$game['bgg']."}, ";
    array_push($bggid, $game['bgg']);
}

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
<link rel="stylesheet" type="text/css" href="style.css"/>
<style>
.collect tr:nth-child(odd)
{
    background-color: #D3D3D3;
}
.collect tr:first-child
{
    background-color: #000000;
    font-weight: bold;
    color: #FFFFFF;
}
.collect tr
{
    border-top: thin solid #000000;
    border-bottom: thin solid #000000;
}
.collect td
{
    padding: 1px 1em;
    vertical-align: top;
}
.collect tr > td:first-child
{
    text-indent: -0.5em;
    padding-left: 1.5em;
}
input[type=range]
{
    margin: 4px 1em;
    vertical-align: middle;
        -webkit-appearance: none;
}
input[type=range]::-webkit-slider-runnable-track
{
    height: 12px;
    background: #d3d3d3;
    border-radius: 6px;
}
input[type=range]::-webkit-slider-thumb
{
    height: 20px;
    width: 12px;
    background: #000000;
    margin-top: -4px;
        -webkit-appearance: none;
}
input[type=range]::-moz-range-track
{
    height: 12px;
    background: #d3d3d3;
    border-radius: 6px;
}
input[type=range]::-moz-range-thumb
{
  height: 20px;
  width: 12px;
  border: 0;
  border-radius: 0px;
  background: #000000;
  cursor: pointer;
}
.moblab
{
    display: none;
}
.desklab
{
    display: inline;
}
@media screen and (max-width: 1440px)
{
    input[type=range]
    {
        width: 100%;
        margin: 12pt 0;
    }
    input[type=range]::-webkit-slider-runnable-track
    {
        width: 100%;
        height: 24pt;
        border-radius: 12pt;
    }
    input[type=range]::-webkit-slider-thumb
    {
        height: 40pt;
        width: 40pt;
        margin-top: -8pt;
    }
    input[type=range]::-moz-range-track
    {
        width: 100%;
        height: 24pt;
        background: #d3d3d3;
        border-radius: 12pt;
    }
    input[type=range]::-moz-range-thumb
    {
        height: 40pt;
        width: 40pt;
    }
    .moblab
    {
        display: inline;
    }
    .desklab
    {
        display: none;
    }
    .collect
    {
        width: 100%;
    }
}

</style>
<script>
// Array of members' BGG username, and Discord user IDs
memb = [{bgg:"BradleySigma", disc:"@BradleySigma#7868"},
        {bgg:"lsenjov"     , disc:"@lsenjov#4288"     },
        {bgg:"_Exist"      , disc:"@Exist#8869"       }];
// Array of games, and who owns them
games = [];
// BGG IDs of games the club owns
QUGSid = [<?php echo implode(", ", $bggid);?>];

// Runs through every memer's BGG list, finding the BGG game ID of every game in their collection
function collect()
{
    // If no member remains, go to table creation
    if (memb.length == 0)
    {
        table();
        return;
    }
    // Perform a BGG API call on the first member
    var m = memb.shift();
    var bgg_req = new XMLHttpRequest();
    // Get the abbreviated details of games the member owns, excluding expansions,
    bgg_req.open("GET", "https://www.boardgamegeek.com/xmlapi2/collection?username="+m.bgg+"&brief=1&own=1&excludesubtype=boardgameexpansion");
    bgg_req.onreadystatechange=function()
    {
        // If API call sucsessful
        if (bgg_req.readyState==4 && bgg_req.status==200)
        {
            // Create array of games ("items") from API response
            var bgg_list = bgg_req.responseXML.getElementsByTagName("item");
            for (var i = 0; i < bgg_list.length; i++)
            {
                // Get the BGG ID of the game (as an integer)
                var bggid = parseInt(bgg_list[i].getAttribute("objectid"));
                // If QUGS owns the game, don't bother listing it
                if (QUGSid.indexOf(bggid) != -1) continue;
                // See if the game has already be seen in another member's collection
                var exist = false;
                for (var j = 0; j < games.length; j++)
                {
                    if (games[j].id == bggid)
                    {
                        exist = true;
                        // If seen, add this member to the array of owners
                        games[j].owner.push(m.disc);
                        break;
                    }
                }
                if (!exist)
                {
                    // If not seen, add it as a new game
                    games.push({id:bggid, owner:[m.disc]});
                }
            }
            collect();
        }
        // If BGG gives the "try again later" status, try again later
        else if (bgg_req.readyState==4 && bgg_req.status==202)
        {
            memb.push(m);
            collect();
        }
    }
    // If the API request fails (usually because BGG is down)
    bgg_req.onerror = function onError(e)
    {
        alert("Error retrieving data from Board Game Geek.\nPlease try again later.");
        console.log(e);
    }
    bgg_req.send();
}

// Creates a table with a row for every game owned by one or more members, but not the club
function table()
{
    // Array of games, with each game as an object
    // Each game will have a name, a range of players, a time, a BGG rating, a BGG ID, and one or more owners
    var details = [];
    // Perform a BGG API call on all games
    var bgg_gam = new XMLHttpRequest();
    // Creates a string of BGG game IDs, seperated by commas (with a final comma to be removed)
    var arg = "";
    for (var j = 0; j < games.length; j++)
    {
        arg += games[j].id+",";
    }
    // Get all details on all games
    bgg_gam.open("GET", "https://www.boardgamegeek.com/xmlapi2/thing?id="+arg.slice(0,-1)+"&stats=1");
    bgg_gam.onreadystatechange=function()
    {
        // If API call sucsessful
        if (bgg_gam.readyState==4 && bgg_gam.status==200)
        {
            // Create array of games ("items") from API response
            var bgg_list = bgg_gam.responseXML.getElementsByTagName("item");
            for (var i = 0; i < bgg_list.length; i++)
            {
                // Create new object for a game, and add object attributes
                var g = {};
                g.name = bgg_list[i].getElementsByTagName("name")[0].getAttribute("value");
                g.minp = parseInt(bgg_list[i].getElementsByTagName("minplayers")[0].getAttribute("value"));
                g.maxp = parseInt(bgg_list[i].getElementsByTagName("maxplayers")[0].getAttribute("value"));
                g.time = parseInt(bgg_list[i].getElementsByTagName("playingtime")[0].getAttribute("value"));
                // Use the Bayesian average ("Geekscore"), gives suppressed results for games with few ratings
                g.rate = parseFloat(bgg_list[i].getElementsByTagName("bayesaverage")[0].getAttribute("value"));
                g.id = bgg_list[i].getAttribute("id");
                // Lists owners of game, with line breaks for two or more owners
                for (var j = 0; j < games.length; j++)
                {
                    if (games[j].id == bgg_list[i].getAttribute("id"))
                    {
                        g.owner = games[j].owner[0];
                        for (var k = 1; k < games[j].owner.length; k++)
                        {
                            g.owner += "<br/>" + games[j].owner[k];
                        }
                        break;
                    }
                }
                details.push(g);
            }
            // Sorts list of games by name, ignoring "the " and "a "
            details.sort(game_comp);
            // Header of table
            var out = "<table class=\"collect\"><tr><td>Game</td><td>Players</td><td>Time</td><td>BGG Rating</td><td>Discord</td></tr>\n"
            // For every game, add a row
            for (var i = 0; i < details.length; i++)
            {
                var g = details[i];
                out += "<tr><td><a href=https://boardgamegeek.com/boardgame/"+g.id+">"+g.name+"</a></td>"
                       + "<td>"+g.minp+(g.minp == g.maxp ? "" : "-"+g.maxp)+"</td>"
                       + "<td>"+(g.time >= 60 ? ((g.time/60)|0) + " hr " : "")+(g.time%60 == 0 ? "" : g.time%60+ " min")+"</td>"
                       + (g.rate == 0 ? "<td style='color:#808080;'>N/A</td>" : "<td>"+g.rate.toFixed(2)+"</td>")
                       + "<td>"+g.owner+"</td></tr>\n";
            }
            out += "</table>";
            document.getElementById("tab").innerHTML = out;

        }
        // If BGG gives the "try again later" status, try again later
        else if (bgg_gam.readyState==4 && bgg_gam.status==202)
        {
            bgg_gam.send();
        }
    }
    bgg_gam.send();
}

// Compares the name of two games, dropping "the" and "a "
function game_comp(a,b)
{
    var aa = a.name.replace(/^the /i, "").replace(/^a /i, "");
    var bb = b.name.replace(/^the /i, "").replace(/^a /i, "");
    return aa.localeCompare(bb);
}

// Array of ratings indexed by BGG IDs (data-bggid)
ratfilt = {};
// Bypass filtering ratings until ratings have loaded
ratbypass = true;

// Gets ratings of games the club owns
function ratings()
{
    // Performs a BGG API call on all games the club owns
    var bgg_rat = new XMLHttpRequest();
    bgg_rat.open("GET", "https://www.boardgamegeek.com/xmlapi2/thing?id="+QUGSid.join()+"&stats=1");
    bgg_rat.onreadystatechange=function()
    {
        // If API call sucsessful
        if (bgg_rat.readyState==4 && bgg_rat.status==200)
        {
            // Create array of games ("items") from API response
            var bgg_list = bgg_rat.responseXML.getElementsByTagName("item");
            // For every game, get the Bayesian average ("Geekscore"), and insert it into the appropriate cell of the table
            for (var i = 0; i < bgg_list.length; i++)
            {
                r = parseFloat(bgg_list[i].getElementsByTagName("bayesaverage")[0].getAttribute("value"))
                document.getElementById("s"+bgg_list[i].getAttribute("id")).outerHTML = (r == 0 ? "<td style='color:#808080;'>N/A</td>" : "<td>"+r.toFixed(2)+"</td>");
                ratfilt[bgg_list[i].getAttribute("id")] = r;
            }
            ratbypass = false;
            // Make "BGG Rating" clickable to show filter
            document.getElementById("BGGrat").outerHTML = "<td style=\"text-decoration:underline;\" onClick=\"rateform = !rateform; document.getElementById('rateform').style.display = rateform ? 'inline' : 'none'; if(!rateform) {document.getElementById('ratemin').value=0;document.getElementById('ratemax').value=12;raterfilter();}\">BGG Rating</td>";
        }
        // If BGG gives the "try again later" status, try again later
        else if (bgg_rat.readyState==4 && bgg_rat.status==202)
        {
            bgg_rat.send()
        }
    }
    bgg_rat.send();

}

// Filter forms visibilities
playform = false;
timeform = false;
rateform = false;

// Filter games when player number filter is changed
function playerfilter(m)
{
    var playmin = document.getElementById('playmin');
    var playmax = document.getElementById('playmax');
    var pmin = parseInt(playmin.value);
    var pmax = parseInt(playmax.value);

    // If sliders overlap, move non-clicked slider to clicked slider's value
    if (pmin > pmax && m == "min")
    {
        playmax.value = pmin;
        pmax = pmin;
    }
    else if (pmax < pmin && m == "max")
    {
        playmin.value = pmax;
        pmin = pmax;
    }

    // Update slider labels
    document.getElementById('playminvald').innerHTML = pmin;
    document.getElementById('playminvalm').innerHTML = "&emsp;" + pmin;
    document.getElementById('playmaxvald').innerHTML = pmax;
    document.getElementById('playmaxvalm').innerHTML = "&emsp;" + pmax;

    // Apply filter
    filterfilter();
}

// Filter games when playing time filter is changed
function timerfilter(m)
{
    var timemin = document.getElementById('timemin');
    var timemax = document.getElementById('timemax');
    var tmin = parseInt(timemin.value);
    var tmax = parseInt(timemax.value);

    // If sliders overlap, move non-clicked slider to clicked slider's value
    if (tmin > tmax && m=="min")
    {
        timemax.value = tmin;
        tmax = tmin;
    }
    else if (tmax < tmin && m=="max")
    {
        timemin.value = tmax;
        tmin = tmax;
    }

    // Update slider labels
    var tlabs = ["15 min", "30 min", "45 min", "1 hr", "1 hr 30 min", "2 hr", "2 hr 30 min", "3 hr", "4 hr", "5 hr", "6 hr"];
    document.getElementById('timeminvald').innerHTML = tlabs[tmin];
    document.getElementById('timeminvalm').innerHTML = "&emsp;" + tlabs[tmin];
    document.getElementById('timemaxvald').innerHTML = tlabs[tmax];
    document.getElementById('timemaxvalm').innerHTML = "&emsp;" + tlabs[tmax];

    // Apply filter
    filterfilter();
}

// Filter games when BGG rating filter is changed
function raterfilter(m)
{
    var ratemin = document.getElementById('ratemin');
    var ratemax = document.getElementById('ratemax');
    var rmin = parseFloat(ratemin.value);
    var rmax = parseFloat(ratemax.value);

    // If sliders overlap, move non-clicked slider to clicked slider's value
    if (rmin > rmax && m=="min")
    {
        ratemax.value = rmin;
        rmax = rmin;
    }
    else if (rmax < rmin && m=="max")
    {
        ratemin.value = rmax;
        rmin = rmax;
    }

    // Update slider labels
    document.getElementById('rateminvald').innerHTML = rmin.toFixed(1);
    document.getElementById('rateminvalm').innerHTML = "&emsp;" + rmin.toFixed(1);
    document.getElementById('ratemaxvald').innerHTML = rmax.toFixed(1);
    document.getElementById('ratemaxvalm').innerHTML = "&emsp;" + rmax.toFixed(1);

    // Apply filter
    filterfilter();
}

function filterfilter()
{

    var pmin = parseInt(document.getElementById('playmin').value);
    var pmax = parseInt(document.getElementById('playmax').value);
    var tmin = parseInt(document.getElementById('timemin').value);
    var tmax = parseInt(document.getElementById('timemax').value);
    var tvals = [15, 30, 45, 60, 90, 120, 150, 180, 240, 300, 360];
    var rmin = parseFloat(document.getElementById('ratemin').value);
    var rmax = parseFloat(document.getElementById('ratemax').value);

    var rows = document.getElementsByClassName("gamerow");

    for (var i = 0; i < rows.length; i++)
    {
        var grate = ratfilt[rows[i].dataset.bggid];
        var gtime = rows[i].dataset.time;
        var gmin = rows[i].dataset.minp;
        var gmax = rows[i].dataset.maxp;

        rows[i].style.display = (gtime >= tvals[tmin] && gtime <= tvals[tmax] && gmax >= pmin && gmin <= pmax && grate >= rmin && grate <= rmax) ? "table-row" : "none";
    }
}

var mainthidd = true;
function maintshow()
{
    mainthidd = !mainthidd;
    document.getElementById("maintform").style.display = mainthidd ? "none" : "block";
    document.getElementById("showhide").innerHTML = mainthidd ? "Show From" : "Hide From";
}

function maintfilt()
{
    var maintgame = document.getElementById("maintgame");
    for(var i = maintgame.options.length - 1; i >= 0; i--)
    {
        maintgame.remove(i);
    }
    var option = [<?php echo $option;?>];
    maintgame.add(new Option("", 0, false, false));
    maintgame.options[0].innerHTML = "&ensp;&ndash;&ensp;Select A Game&ensp;&ndash;&ensp;"
    var compare = document.getElementById("maintfilter").value.normalize('NFD').replace(/[^\u0020-\u007e]/g, "").toLowerCase();
    var n = 0;
    for(var i = 0; i < option.length; i++)
    {
        var title = option[i].name;
        if (title.normalize('NFD').replace(/[^\u0020-\u007e]/g, "").toLowerCase().indexOf(compare) != -1)
        {
            maintgame.add(new Option(title, option[i].numb+"|"+title, false, false));
            n++;
        }
    }
    if (n != 0 && n <= 3)
    {
        maintgame.remove(0);
        maintgame.size = n;
    }
    else
    {
        maintgame.size = 1;
        if (n == 0)
        {
            maintgame.options[0].innerHTML = "&ensp;&ndash;&ensp;No Matching Games&ensp;&ndash;&ensp;";
        }
    }
    maintgame.selectedIndex = 0;
    //"Crème Brulée".normalize('NFD').replace(/[^\u0020-\u007e]/g, "")
}

function maintsub()
{
    if (document.getElementById("maintgame").value == 0)
    {
        alert("Please select a game");
        return;
    }

    if (document.getElementById("maintdesrip").value.length < 20)
    {
        alert("Please describe the issue");
        return;
    }
    document.getElementById("maintform").submit();
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
    <td style="font-family:toro; font-size: 30px;">Queensland University Games Society</td>
    <td style="width:100%">&nbsp;</td>
    <td class="navdesk"><a href="./">Home</a></td>
    <td class="navdesk"><a href="collection">Collection</a></td>
    <td class="navdesk"><a href="about">About</a></td>
    <td class="navdesk"><a href="join">Join</a></td>
    <td class="navmob">
    <select autocomplete="off" onChange="navig();" id="navig">
        <option selected hidden value=0>Menu</option>
        <option value="./">Home</option>
        <option value="collection">Collection</option>
        <option value="about">About</option>
        <option value="join">Join</option>
    </select></td></tr></table></div>
<h1>Game Collections</h1>
<h2>Games Owned By The Society</h2>
<form id="playform" style="display:none;">
<h3>Filter by Number of Players</h3>
Minimum:<label id="playminvalm" for="playmin" class="moblab">&emsp;1</label><input type="range" min=1 max=10 value=1 class="slider" id="playmin" onInput="playerfilter('min');" onChange="playerfilter('min');" autocomplete="off"><label id="playminvald" for="playmin" class="desklab">1</label><br/>
Maximum:<label id="playmaxvalm" for="playmax" class="moblab">&emsp;10</label><input type="range" min=1 max=10 value=10 class="slider" id="playmax" onInput="playerfilter('max');" onChange="playerfilter('max');" autocomplete="off"><label id="playmaxvald" for="playmax" class="desklab">10</label><br/>
</form>
<form id="timeform" style="display:none;">
<h3>Filter by Playing Time</h3>
Minimum:<label id="timeminvalm" for="timemin" class="moblab">&emsp;15 min</label><input type="range" min=0 max=10 value=0 class="slider" id="timemin" onInput="timerfilter('min');" onChange="timerfilter('min');" autocomplete="off"><label id="timeminvald" for="timemin" class="desklab">15 min</label><br/>
Maximum:<label id="timemaxvalm" for="timemax" class="moblab">&emsp;6 hr</label><input type="range" min=0 max=10 value=10 class="slider" id="timemax" onInput="timerfilter('max');" onChange="timerfilter('max');" autocomplete="off"><label id="timemaxvald" for="timemax" class="desklab">6 hr</label><br/>
</form>
<form id="rateform" style="display:none;">
<h3>Filter by BGG Rating</h3>
Minimum:<label id="rateminvalm" for="ratemin" class="moblab">&emsp;0.0</label><input type="range" min=0 max=10 value=0 step=0.2 class="slider" id="ratemin" onInput="raterfilter('min');" onChange="raterfilter('min');" autocomplete="off"><label id="rateminvald" for="ratemin" class="desklab">0.0</label><br/>
Maximum:<label id="ratemaxvalm" for="ratemax" class="moblab">&emsp;10.0</label><input type="range" min=0 max=10 value=10 step=0.2 class="slider" id="ratemax" onInput="raterfilter('max');" onChange="raterfilter('max');" autocomplete="off"><label id="ratemaxvald" for="ratemax" class="desklab">10.0</label><br/>
</form>
<table class="collect"><tr><td>Game</td><td style="text-decoration:underline;" onClick="playform = !playform; document.getElementById('playform').style.display = playform ? 'inline' : 'none'; if(!playform) {document.getElementById('playmin').value=1;document.getElementById('playmax').value=10;playerfilter();}">Players</td><td style="text-decoration:underline;" onClick="timeform = !timeform; document.getElementById('timeform').style.display = timeform ? 'inline' : 'none'; if(!timeform) {document.getElementById('timemin').value=0;document.getElementById('timemax').value=12;timerfilter();}">Time</td><td id="BGGrat">BGG Rating</td><td>Rules</td><td>Apps</td></tr>
<?php echo $table;?>
</table>
<h2>Game Collection Hire</h2>
The QUGS game collection is available to hire by UQU affiliated clubs and societies, and other organisations within the UQ community. The QUGS games collection is stored in two cases, partitioned by approximate complexity. UQU affiliated clubs and societies may hire one case for $15 or both cases for $25, for up to four hours, subject to availability. Please contact us at <a href="mailto:president@qugs.org.au">president@qugs.org.au</a> to for questions and/or bookings.
<h2>Maintenance Requests</h2>
Use this form to report broken sleeves, missing pieces or other needed repairs to games in the QUGS collection. <a onclick="maintshow();" id="showhide">Show Form</a><br/>
<form id="maintform" action="collection" method="post" style="display:none; width:480px;">
<table style="font-size:18px; text-align:right; border-spacing:4px; border-collapse:separate; width:100%;">
<tr><td width="20%">Filter:</td><td width="80%" style="padding-right:6px;"><input id="maintfilter" onkeyup="maintfilt()" style="width:100%; margin:0; padding:2px; font-size:18px;"/></td></tr>
<tr><td>Game:</td><td><select id="maintgame" name="maintgame" style="width:100%; margin:0; padding:2px; font-size:18px;">
<?php echo $select;?>
</select><br/></td></tr>
<tr><td style="vertical-align:top;">Issue:</td><td style="padding-right:6px;"><textarea name="maintdesrip" id="maintdesrip" rows="4" style="width:100%; margin:0; padding:2px; font-size:18px;"></textarea><br/></td></tr>
<tr><td>&nbsp;</td><td style="text-align:center;"><input type="button" onClick="maintsub();" value="Submit" style="width:50%; margin:0; padding:2px; font-size:18px;"/></td></tr></table>
</form>
<h2>Games Owned By Members</h2>
These games are owned by members of the club. If you wish to play one of these games at a weekly meeting, get in contact with the member via Discord.<br/>
This used the <i>Board Game Geek</i> API, and can take a short time to load. If you want to have your BGG collection listed, contact one of the executive.<br/>
<div id="tab"></div>
<script>
// Run BGG API functions after page loaded
collect();
ratings();
<?php if ($maint_sub) {echo 'alert("Thank you. Your request has been submitted.");';}?>
</script>
</body>
</html>