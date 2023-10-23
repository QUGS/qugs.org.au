<?php
include("db.php");

// Select all partners from database (ordered randomly)
$partner_q = "SELECT sponsor, logo, location, discount, website FROM Partners ORDER BY RAND()";
$partner_l = mysqli_query($db, $partner_q) or die(mysqli_error($db));

// String to form club's games table
$table = "";

while (($partner = mysqli_fetch_assoc($partner_l)))
{
    $row = "\t<tr><td><img src=\"images/" . $partner['logo'] . "\"></td>\n"
           . "\t\t<td>" . $partner['sponsor'] . "</td>\n"
           . "\t\t<td>" . $partner['location'] . "</td>\n"
           . "\t\t<td>" . $partner['discount'] . "</td>\n";
    $web = $partner['website'];
    if (substr($web, 0, strlen("https://www.")) === "https://www.")
    {
           $web = substr($web, strlen("https://www."));
    }
    if (substr($web, 0, strlen("http://www.")) === "http://www.")
    {
        $web = substr($web, strlen("http://www."));
    }
    if (substr($web, -strlen("/")) === "/")
    {
        $web = substr($web, 0, -strlen("/"));
    }
    $row .= "\t\t<td><a href=\"" . $partner['website'] . "\">" . $web . "</a></td></tr>\n";
    $table .= $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Queensland University Games Society</title>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
<meta content="utf-8" http-equiv="encoding"/>
<meta name="author" content="Bradley Stone"/>
<meta name="version" content="v1.4"/>
<link rel="icon" href="images/fave<?php echo intval(date("z")) % 6 ?>.png"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
<style>
.exec tr:nth-child(odd), .partn tr:nth-child(odd)
{
    background-color: #D3D3D3;
}
.exec tr:first-child, .partn tr:first-child
{
    background-color: #000000;
    font-weight: bold;
    color: #FFFFFF;
}
.exec tr, .partn tr
{
    border-top: thin solid #000000;
    border-bottom: thin solid #000000;
}
.partn tr:not(:first-child)
{
    height: 8vmin;
}
.exec td
{
    padding: 1px 1em;
    vertical-align: top;
}
.partn td
{
    vertical-align: middle;
}
.partn tr:not(:first-child) > td
{
    padding: 12px 1em;
}
.partn tr:first-child > td
{
    padding: 1px 1em;
}
.exec tr > td:first-child, .partn tr > td:first-child
{
    text-indent: -0.5em;
    padding-left: 1.5em;
}
.partn td > img
{
    max-width: calc(1vw + 8em);
    max-height: calc(1vw + 8em);
}
.partn td:nth-child(2)
{
    font-weight: bold;
}
.column3
{
    float: left;
    width: 240px;
    padding-bottom: 24px;
}
.column3:last-of-type
{
    width: calc(100% - 2 * 240px);
}
.column2
{
    float: left;
    width: 360px;
    padding-bottom: 24px;
}
.column2:last-of-type
{
    width: calc(100% - 360px);
}
ul
{
    padding-top: 0;
    margin-top: 0;
}
p
{
    line-height: 1.2;
    margin-bottom: 0.8em;
    margin-top: 0;
}
h1, h2
{
    line-height: 1.5;
    margin-bottom: 0;
    margin-top: 0;
}
.twi
{
    display: flex;
    flex-flow: row wrap;
    max-width: 64em;
}
.twi>li
{
    flex: 0 0 22.5em;
}
.twi>li>img
{
    height: 3ex;
    width: 3ex;
    vertical-align:middle;
}
@media screen and (max-width: 1440px)
{
    .exec, .part
    {
        width: 100%;
    }
    .column3
    {
        float: none;
        width: 100%;
        padding-bottom: 0;
    }
    .column3:last-of-type
    {
        width: 100%;
    }
    .column2
    {
        float: none;
        width: 100%;
        padding-bottom: 0;
    }
    .column2:last-of-type
    {
        width: 100%;
    }
    .twi
    {
        display: block;
    }
}

</style>
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
<h1>About the Society</h1>
<p>Established 1978, QUGS is the tabletop gaming society of the University of Queensland.</p>
<p>We enjoy playing a broad range of game genres including abstract strategy, bluffing, cooperative, deck building, drafting, engine building, press your luck, role&ndash;playing, set collection, worker placement, and many more.</p>
<p>Membership costs $5.00 for the year and being a student is not required. Everybody from complete novices to hard&ndash;core tabletop gamers are welcome. You are welcome to attend for a few weeks before joining.</p>
<p>QUGS meets on Mondays, starting at 5:00pm for board games, and on Thursdays, starting at 6:30pm for a <i>Magic: The Gathering</i> draft. We meet throughout the year, including university holidays, and usually only halt for university exam block and <i>force majeure</i>.</p>

<h2>Partners</h2>
<p>QUGS has partnered with several Brisbane based gaming businesses, who kindly provide our members with discounts and deals upon the presentation of a membership card.</p>
<p>The following table lists the QUGS partners in 2021.</p>
<table class="partn">
    <tr><td colspan="2" style="width: calc(2vw + 16em);">Partner</td>
        <td style="width: calc(1vw + 8em);">Location(s)</td>
        <td style="width: calc(1vw + 8em);">Benefit</td>
        <td style="width: calc(1vw + 8em);">Website</td></tr>
<?php echo $table;?>
</table><br/>

<h2>Executive</h2>
<table class="exec"><tr><td>Year</td>
    <td>President</td>
    <td>Secretary</td>
    <td>Treasurer</td>
    <td colspan="2">Other</td></tr>
<tr><td>1979</td>
    <td>Ken Toohey <sup>P</sup></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>David Bugler <sup>E</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>1980</td>
    <td>Noel Bugeia <sup>P</sup></td>
    <td>Ken Toohey<br/>Geoff Tuck <sup>A</sup></td>
    <td>Graham Rawlings</td>
    <td>David Bugler <sup>E</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>1981</td>
    <td>Denis Clancy</td>
    <td>Geoff Tuck</td>
    <td>Graham Rawlings</td>
    <td>David Bugler <sup>E</sup></td>
    <td>Kevin Flynn <sup>AE</sup></td></tr>
<tr><td>1982</td>
    <td>Denis Clancy<br/>Alan Bradley <sup>A</sup></td>
    <td>Noel Bugeia </td>
    <td>Jack Ford </td>
    <td>Kevin Flynn <sup>E</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>1983</td>
    <td>Alan Bradley</td>
    <td>Noel Bugeia</td>
    <td>Jack Ford</td>
    <td>Nina Williams <sup>E</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>1984</td>
    <td>Alan Bradley</td>
    <td>Steven Low</td>
    <td>Jack Ford</td>
    <td>Kevin Flynn <sup>E</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>1985</td>
    <td>Mark Marychurch</td>
    <td>Eric Topp</td>
    <td>Andrew Robinson</td>
    <td>Jack Ford <sup>E</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>1986</td>
    <td>Mark Marychurch</td>
    <td>&nbsp;</td>
    <td>Andrew Robinson</td>
    <td>Jack Ford <sup>E</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>1987</td>
    <td>Ian Jamie</td>
    <td>Paul Agapow</td>
    <td>Andrew Robinson</td>
    <td>Jack Ford <sup>E</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>1988</td>
    <td>Richard Shepherd</td>
    <td>&nbsp;</td>
    <td>Neil Mack</td>
    <td>Timo Nieminen <sup>E</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>1989</td>
    <td>Sandra Dresdock</td>
    <td>Simon Howell</td>
    <td>Neil Mack</td>
    <td>Jack Ford <sup>C</sup><br/>Stefan Stanley <sup>E</sup></td>
    <td>Timo Nieminen <sup>AE</sup></td></tr>
<tr><td>1990</td>
    <td>Paul Kinsler</td>
    <td>Taina Nieminen <sup>A</sup></td>
    <td>Neil Mack<br/>Andrew Noskoff <sup>A</sup></td>
    <td>Jack Ford <sup>C</sup><br/>Timo Nieminen <sup>E</sup></td>
    <td>Graeme Finsen <sup>AV</sup></td></tr>
<tr><td>1991</td>
    <td>Paul Kinsler</td>
    <td>Taina Nieminen</td>
    <td>Andrew Noskoff</td>
    <td>Jack Ford <sup>C</sup><br/>Timo Nieminen <sup>E</sup></td>
    <td>Gary Johnson <sup>V</sup></td></tr>
<tr><td>1992</td>
    <td>Gary Johnson</td>
    <td>Peter Fordyce</td>
    <td>Andrew Noskoff</td>
    <td>Jack Ford <sup>C</sup><br/>Nick Lawrence <sup>E</sup></td>
    <td>Justin Radomyski <sup>V</sup></td></tr>
<tr><td>1993</td>
    <td>Gary Johnson</td>
    <td>Peter Fordyce</td>
    <td>Richard Shepherd</td>
    <td>Jack Ford <sup>C</sup><br/>Nick Lawrence <sup>E</sup></td>
    <td>Justin Radomyski <sup>V</sup></td></tr>
<tr><td>1994</td>
    <td>Robert Thiem</td>
    <td>Travis Hall</td>
    <td>Gary Johnson</td>
    <td>Jack Ford <sup>C</sup><br/>Sebastian Tauchmann <sup>E</sup></td>
    <td>Mark Anderson <sup>V</sup></td></tr>
<tr><td>1995</td>
    <td>Daniel Edwards</td>
    <td>Robert Semple<br/>Travis Hall <sup>A</sup></td>
    <td>Craig Sargent</td>
    <td>Jack Ford <sup>C</sup><br/>Gary Johnson <sup>E</sup></td>
    <td>David Astley <sup>V</sup></td></tr>
<tr><td>1996</td>
    <td>Daniel Edwards</td>
    <td>David Darlington</td>
    <td>Tony Osborne</td>
    <td>Travis Hall <sup>C</sup><br/>Gary Johnson <sup>E</sup></td>
    <td>David Astley <sup>V</sup></td></tr>
<tr><td>1997</td>
    <td>Bronwyn Walker</td>
    <td>Gary Johnson</td>
    <td>Dale Edwards</td>
    <td>Travis Hall <sup>C</sup><br/>Gary Johnson <sup>E</sup></td>
    <td>Peter Fordyce <sup>V</sup></td></tr>
<tr><td>1998</td>
    <td>Peter Fordyce</td>
    <td>Ben Skellett<br/>Brad Henry <sup>A</sup></td>
    <td>Dale Edwards</td>
    <td>Travis Hall <sup>C</sup><br/>Ben Skellett <sup>E</sup><br/>Ernest Cheung <sup>AE</sup></td>
    <td>David Astley <sup>JV</sup><br/>Darryl Greensill <sup>JV</sup></td></tr>
<tr><td>1999</td>
    <td>Kate Davis <sup>A</sup></td>
    <td>Nick Frampton <sup>A</sup></td>
    <td>Aaron Rubin <sup>A</sup></td>
    <td>Gary Johnson <sup>C</sup><br/>Nick Frampton <sup>AE</sup></td>
    <td>David Astley <sup>V</sup></td></tr>
<tr><td>2000</td>
    <td>Kate Davis</td>
    <td>Nick Frampton</td>
    <td>Lawrence Wong <sup>A</sup></td>
    <td>Gary Johnson <sup>C</sup><br/>Nick Frampton <sup>E</sup></td>
    <td>David Astley <sup>JV</sup><br/>Darryl Greensill <sup>JV</sup></td></tr>
<tr><td>2001</td>
    <td>Paul Douglas</td>
    <td>Nick Frampton</td>
    <td>Lucas Papadopoulos</td>
    <td>Gary Johnson <sup>C</sup><br/>Nick Frampton <sup>E</sup><br/>David Astley <sup>JV</sup></td>
    <td>David Cowland&ndash;Cooper <sup>JV</sup><br/>Darryl Greensill  <sup>JV</sup></td></tr>
<tr><td>2002</td>
    <td>Kylie Fisher</td>
    <td>Ben Yeoh</td>
    <td>James Cooper</td>
    <td>Gary Johnson <sup>C</sup><br/>Kylie Fisher <sup>EJ</sup><br/>Nick Frampton <sup>EJ</sup><br/>Gary Johnson <sup>EJ</sup></td>
    <td>David Astley <sup>JV</sup><br/>Kevin Brake <sup>JV</sup><br/>Darryl Greensill <sup>JV</sup></td></tr>
<tr><td>2003</td>
    <td>Kylie Fisher</td>
    <td>Nicole Hoye</td>
    <td>Nikolas Moore</td>
    <td>Gary Johnson <sup>C</sup><br/>Gary Johnson <sup>EJ</sup><br/>Nicole Hoye <sup>EJ</sup></td>
    <td>David Astley <sup>JV</sup><br/>Darryl Greensill <sup>JV</sup></td></tr>
<tr><td>2004</td>
    <td>Tim Woodhams</td>
    <td>Alyssa Juergens</td>
    <td>Nikolas Moore</td>
    <td>Gary Johnson <sup>C</sup><br/>Gary Johnson <sup>E</sup><br/>David Astley <sup>JV</sup></td>
    <td>Darryl Greensill <sup>JV</sup><br/>Nicole Hoye <sup>JV</sup></td></tr>
<tr><td>2005</td>
    <td>Andrew Bautovich</td>
    <td>Alyssa Juergens</td>
    <td>Nikolas Moore</td>
    <td>Gary Johnson <sup>C</sup><br/>Gary Johnson <sup>E</sup></td>
    <td>David Astley <sup>JV</sup><br/>Tim Woodhams <sup>JV</sup></td></tr>
<tr><td>2006</td>
    <td>Brian Balzano</td>
    <td>Alyssa Juergens</td>
    <td>Nikolas Moore</td>
    <td>Gary Johnson <sup>C</sup><br/>Gary Johnson <sup>E</sup><br/>David Astley <sup>JV</sup><br/>Ernest Cheung <sup>JV</sup></td>
    <td>Eric Faccer <sup>JV</sup><br/>Darryl Greensill <sup>JV</sup><br/>Jeff Thomson <sup>JV</sup><br/>Tim Woodhams <sup>JV</sup></td></tr>
<tr><td>2007</td>
    <td>Tim Woodhams <sup>A</sup></td>
    <td>Jared Mallett <sup>A</sup></td>
    <td>Chris Burke <sup>A</sup></td>
    <td>Gary Johnson <sup>C</sup><br/>David Astley <sup>JV</sup></td>
    <td>Darryl Greensill <sup>JV</sup></td></tr>
<tr><td>2008</td>
    <td>Jared Mallett <sup>A</sup></td>
    <td>Lachlan Fraser <sup>A</sup></td>
    <td>Chris Burke <sup>A</sup></td>
    <td>Gary Johnson <sup>C</sup><br/>David Astley <sup>JV</sup></td>
    <td>Tim Woodhams <sup>JV</sup></td></tr>
<tr><td>2009</td>
    <td>Jared Mallett</td>
    <td>Lachlan Fraser</td>
    <td>Angus Fraser</td>
    <td>Gary Johnson <sup>C</sup><br/></td>
    <td>&nbsp;</td></tr>
<tr><td>2010</td>
    <td>Lachlan Fraser</td>
    <td>Devin Smith</td>
    <td>Hugh Pearce</td>
    <td>Gary Johnson <sup>C</sup><br/>Horatio Davis <sup>JV</sup></td>
    <td>Sebastian Winterflood <sup>JV</sup></td></tr>
<tr><td>2011</td>
    <td>Sebastian Winterflood</td>
    <td>Devin Smith</td>
    <td>Hugh Pearce</td>
    <td>Gary Johnson <sup>C</sup></td>
    <td>&nbsp;</td></tr>
<tr><td>2012</td>
    <td>Aidan Cockroft</td>
    <td>Jesse Irwin</td>
    <td>Maximillian von Neumann</td>
    <td>Gary Johnson <sup>C</sup><br/>Tyson Henning <sup>JV</sup></td>
    <td>Devin Smith <sup>JV</sup></td></tr>
<tr><td>2013</td>
    <td>Callum Mason</td>
    <td>Marc Lim</td>
    <td>Maximillian von Neumann</td>
    <td>Gary Johnson <sup>C</sup><br/>Tyson Henning <sup>JV</sup></td>
    <td>Devin Smith <sup>JV</sup></td></tr>
<tr><td>2014</td>
    <td>Dominik Osika <sup>A</sup></td>
    <td>Thomas Bremner <sup>A</sup></td>
    <td>Callum Mason <sup>A</sup></td>
    <td>Gary Johnson <sup>C</sup><br/></td>
    <td>&nbsp;</td></tr>
<tr><td>2015</td>
    <td>Thomas Bremner</td>
    <td>Ben Haley</td>
    <td>Alia Stark</td>
    <td>Gary Johnson <sup>C</sup></td>
    <td>Yong Ming Lim <sup>V</sup></td></tr>
<tr><td>2016</td>
    <td>Natasha Steiger</td>
    <td>Thomas Bremner</td>
    <td>Catherine Shield</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td></tr>
<tr><td>2017</td>
    <td>Lee Phillips</td>
    <td>Harvey Kay&ndash;Burman<br/>Bradley Stone <sup>A</sup></td>
    <td>Catherine Shield<br/>Rob Copel <sup>A</sup></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td></tr>
<tr><td>2018</td>
    <td>Lee Phillips</td>
    <td>Dakota Edwards<sup>A</sup></td>
    <td>Bradley Stone</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td></tr>
<tr><td>2019</td>
    <td>Bradley Stone</td>
    <td>Samuel Parchert</td>
    <td>Lee Phillips</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td></tr>
<tr><td>2020</td>
    <td>Bradley Stone</td>
    <td>Renee Bonney</td>
    <td>Lee Phillips</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td></tr>
<tr><td>2021</td>
    <td>Bradley Stone</td>
    <td>Jzi Sinn Tan</td>
    <td>Mairah Zulkepli</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td></tr>
<tr><td>2022</td>
    <td>Blaire Alexander&ndash;Gordon</td>
    <td>Jzi Sinn Tan</td>
    <td>Alexa Baxter</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td></tr>
<tr><td>2023</td>
    <td>Blaire Alexander&ndash;Gordon</td>
    <td>Noah Kneipp</td>
    <td>Alexa Baxter</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td></tr>
<tr><td>2024</td>
    <td>Blaire Alexander&ndash;Gordon</td>
    <td>Noah Kneipp</td>
    <td>Alexa Baxter</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td></tr>
</table>
<div class="column2"><sup>A</sup> Acting officer.<br/>
<sup>C</sup> Custodian.<br/>
<sup>E</sup> Editor.</div>
<div class="column2"><sup>J</sup> Joint position.<br/>
<sup>P</sup> The President was originally titled &ldquo;Chairman&rdquo;.<br/>
<sup>V</sup> Vice&ndash;President.</div>

<h2>Life Members</h2>
<ul><li>Jack Ford (1999)</li>
<li>Gary Johnson (2003)</li>
<li>Simon Brown (2018)</li></ul>

<h2>General Meeting Minutes</h2>
<ul><div class="column3">
	<li style="font-weight:bold;"><a href="minutes/m1997.txt">1997 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m1998.txt">1998 AGM</a></li>
	<li><a href="minutes/m1999_apr.txt">1999 April SGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m1999.txt">1999 AGM</a></li>
	<li><a href="minutes/m1999_dec.txt">1999 December SGM</a></li>
	<li><a href="minutes/m2000_jun.txt">2000 June SGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2000.txt">2000 AGM</a></li>
	<li><a href="minutes/m2000_dec.txt">2000 December SGM</a></li>
	<li><a href="minutes/m2001_mar.txt">2001 March SGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2001.txt">2001 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2002.txt">2002 AGM</a></li>
</div>
<div class="column3">
	<li><a href="minutes/m2003_apr.txt">2003 April SGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2003.txt">2003 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2004.txt">2004 AGM</a></li>
	<li><a href="minutes/m2005_apr.txt">2005 April SGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2005.txt">2005 AGM</a></li>
	<li><a href="minutes/m2007_mar.txt">2007 March SGM</a></li>
	<li><a href="minutes/m2007_nov.txt">2007 November SGM</a></li>
	<li><a href="minutes/m2008_oct.txt">2008 October SGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2009.txt">2009 AGM</a></li>
	<li><a href="minutes/m2010_oct.txt">2010 October SGM</a></li>
	<li><a href="minutes/m2011_oct.txt">2011 October SGM</a></li>
</div>
<div class="column3">
	<li style="font-weight:bold;"><a href="minutes/m2012.txt">2012 AGM</a></li>
	<li><a href="minutes/m2014_feb.txt">2014 February SGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2014.txt">2014 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2015.txt">2015 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2016.pdf">2016 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2017.pdf">2017 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2018.pdf">2018 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2019.pdf">2019 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2020.pdf">2020 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2021.pdf">2021 AGM</a></li>
	<li style="font-weight:bold;"><a href="minutes/m2022.pdf">2022 AGM</a></li>
	<br/><br/>
</div></ul>

<p style="font-weight:bold;"><a href="constitution.pdf">Constitution</a></p>

<h2>Queensland Wargamer</h2>
<ul><div class="column2"><li><a href="wargamer/QW01_Feb79.pdf">Issue One (February, 1979)</a></li>
<li><a href="wargamer/QW02_May79.pdf">Issue Two (May, 1979)</a></li>
<li><a href="wargamer/QW03_Oct79.pdf">Issue Three (October, 1979)</a></li>
<li><a href="wargamer/QW04_Mar80.pdf">Issue Four (March, 1980)</a></li>
<li><a href="wargamer/QW05_Apr80.pdf">Issue Five (April, 1980)</a></li>
<li><a href="wargamer/QW06_Jun80.pdf">Issue Six (June, 1980)</a></li>
<li><a href="wargamer/QW07_Oct80.pdf">Issue Seven (October, 1980)</a></li>
<li><a href="wargamer/QW08_Mar81.pdf">Issue Eight (March, 1981)</a></li>
<li><a href="wargamer/QW09_Apr81.pdf">Issue Nine (April, 1981)</a></li>
<li><a href="wargamer/QW10_Jun81.pdf">Issue Ten (June, 1981)</a></li>
<li><a href="wargamer/QW11_Oct81.pdf">Issue Eleven (October, 1981)</a></li>
<li><a href="wargamer/QW12_Jan82.pdf">Issue Twelve (January, 1982)</a></li>
<li><a href="wargamer/QW13_Feb82.pdf">Issue Thirteen (February, 1982)</a></li>
<li><a href="wargamer/QW14_May82.pdf">Issue Fourteen (May, 1982)</a></li>
<li><a href="wargamer/QW15_Nov82.pdf">Issue Fifteen (November, 1982)</a></li>
<li><a href="wargamer/QW16_Apr83.pdf">Issue Sixteen (April, 1983)</a></li>
<li><a href="wargamer/QW17_Jun83.pdf">Issue Seventeen (June, 1983)</a></li>
<li><a href="wargamer/QW18_Nov83.pdf">Issue Eighteen (November, 1983)</a></li>
<li><a href="wargamer/QW19_Sep84.pdf">Issue Nineteen (September, 1984)</a></li>
<li><a href="wargamer/QW20_May85.pdf">Issue Twenty (May, 1985)</a></li>
<li><a href="wargamer/QW21_Sep85.pdf">Issue Twenty&ndash;One (September, 1985)</a></li>
<li><a href="wargamer/QW22_May86.pdf">Issue Twenty&ndash;Two (May, 1986)</a></li>
<li><a href="wargamer/QW23_Aug86.pdf">Issue Twenty&ndash;Three (August, 1986)</a></li>
<li><a href="wargamer/QW24_Feb87.pdf">Issue Twenty&ndash;Four (February, 1987)</a></li>
<li><a href="wargamer/QW25_May87.pdf">Issue Twenty&ndash;Five (May, 1987)</a></li>
<li><a href="wargamer/QW26_Sep87.pdf">Issue Twenty&ndash;Six (September, 1987)</a></li>
<li><a href="wargamer/QW27_Jun88.pdf">Issue Twenty&ndash;Seven (June, 1988)</a></li>
<li><a href="wargamer/QW28_Apr89.pdf">Issue Twenty&ndash;Eight (April, 1989)</a></li>
<li><a href="wargamer/QW29_Feb90.pdf">Issue Twenty&ndash;Nine (February, 1990)</a></li></div>
<div class="column2"><li><a href="wargamer/QW30_Jun90.pdf">Issue Thirty (June, 1990)</a></li>
<li><a href="wargamer/QW31_Nov90.pdf">Issue Thirty&ndash;One (November, 1990)</a></li>
<li><a href="wargamer/QWaa_Feb91.pdf">Special: The Collected 00? (June, 1991)</a></li>
<li><a href="wargamer/QW32_Jun91.pdf">Issue Thirty&ndash;Two (June, 1991)</a></li>
<li><a href="wargamer/QW33_Aug91.pdf">Issue Thirty&ndash;Three (August, 1991)</a></li>
<li><a href="wargamer/QW34_Jun92.pdf">Issue Thirty&ndash;Four (June, 1992)</a></li>
<li><a href="wargamer/QW35_Nov92.pdf">Issue Thirty&ndash;Five (November, 1992)</a></li>
<li><a href="wargamer/QWbb_Feb93.pdf">Special: Intrigue at Castle Morien (February, 1993)</a></li>
<li><a href="wargamer/QW36_Jul93.pdf">Issue Thirty&ndash;Six (July, 1993)</a></li>
<li><a href="wargamer/QW37_Feb94.pdf">Issue Thirty&ndash;Seven (February, 1994)</a></li>
<li><a href="wargamer/QW38_Nov94.pdf">Issue Thirty&ndash;Eight (November, 1994)</a></li>
<li><a href="wargamer/QW39_Feb95.pdf">Issue Thirty&ndash;Nine (February, 1995)</a></li>
<li><a href="wargamer/QW40_May95.pdf">Issue Forty (May, 1995)</a></li>
<li><a href="wargamer/QW41_Sep95.pdf">Issue Forty&ndash;One (September, 1995)</a></li>
<li><a href="wargamer/QW42_Nov95.pdf">Issue Forty&ndash;Two (November, 1995)</a></li>
<li><a href="wargamer/QW43_Feb96.pdf">Issue Forty&ndash;Three (February, 1996)</a></li>
<li><a href="wargamer/QW44_May96.pdf">Issue Forty&ndash;Four (May, 1996)</a></li>
<li><a href="wargamer/QW45_Sep96.pdf">Issue Forty&ndash;Five (September, 1996)</a></li>
<li><a href="wargamer/QW46_Dec96.pdf">Issue Forty&ndash;Six (Dec, 1996)</a></li>
<li><a href="wargamer/QW47_Feb97.pdf">Issue Forty&ndash;Seven (February, 1997)</a></li>
<li><a href="wargamer/QW48_May97.pdf">Issue Forty&ndash;Eight (May, 1997)</a></li>
<li><a href="wargamer/QW49_Sep97.pdf">Issue Forty&ndash;Nine (September, 1997)</a></li>
<li><a href="wargamer/QW50_Sep98.pdf">Issue Fifty (September, 1998)</a></li>
<li><a href="wargamer/QW51_Sep99.pdf">Issue Fifty&ndash;One (September, 1999)</a></li>
<li><a href="wargamer/QW52_Apr00.pdf">Issue Fifty&ndash;Two (April, 2000)</a></li>
<li><a href="wargamer/QW53_Dec01.pdf">Issue Fifty&ndash;Three (Dec, 2001)</a></li>
<li><a href="wargamer/QW54_Sep02.pdf">Issue Fifty&ndash;Four (September, 2002)</a></li>
<li><a href="wargamer/QW55_Feb03.pdf">Issue Fifty&ndash;Five (February, 2003)</a></li>
<li><a href="wargamer/QW56_Sep04.pdf">Issue Fifty&ndash;Six (September, 2004)</a></li></div></ul>

<h2>Semi&ndash;Annual QUGS <i>Twilight Imperium</i> Champions</h2>
Twice each year, on a Monday public holiday, QUGS runs a game of <i><a href="https://boardgamegeek.com/boardgame/233078/twilight-imperium-fourth-edition">Twilight Imperium</a></i>.<br/>
Since its inception in 2019, the winners have been:
<ul class="twi">
<li>May 2019: Bradley Stone <img class="ti" src="images/ti_naalu.png" title="The Naalu Collective"/></li>
<li>Oct 2019: Logan Senjov <img class="ti" src="images/ti_hacan.png" title="The Emirates of Hacan"/></li>
<li>May 2020: Rowan Evans <img class="ti" src="images/ti_yin.png" title="The Yin Brotherhood"/></li>
<li>Oct 2020: Harvey Kay&ndash;Burman <img class="ti" src="images/ti_nekro.png" title="The Nekro Virus"/></li>
<!--li>Dec 2020: Bradley Stone <img class="ti" src="images/ti_vuilraith.png" title="The Vuil'Raith Cabal"/></li-->
<li>May 2021: Harvey Kay&ndash;Burman <img class="ti" src="images/ti_ul.png" title="The Titans of Ul"/></li>
<li>Oct 2021: Bradley Stone <img class="ti" src="images/ti_l1z1x.png" title="The L1Z1X Mindnet"/></li>
<li>May 2022: Bradley Stone <img class="ti" src="images/ti_yssaril.png" title="The Yssaril Tribes"/></li>
<li>Oct 2022: Bradley Stone <img class="ti" src="images/ti_creuss.png" title="The Ghosts of Creuss"/></li>
<li>May 2023: Bradley Stone <img class="ti" src="images/ti_argent.png" title="The Argent Flight"/></li>
<li>Oct 2023: Harvey Kay&ndash;Burman <img class="ti" src="images/ti_sol.png" title="The Federation of Sol"/></li>
</ul>

<h2>&nbsp;</h2>
<p>This website is managed through <a href="https://github.com/QUGS/QUGS">GitHub</a>.</p>
<p>Icons from <a href="https://game-icons.net/">game-icons.net</a></p>
<br/></body>
</html>
