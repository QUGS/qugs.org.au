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
html
{
    width: 100%;
    margin: 0;
    padding: 0;
}
body
{
    width: 100%;
    margin: 0;
    padding: 8px;
}
table
{
    border-collapse: collapse;
    border: 0;
    margin: 0;
    padding: 0;
}
tr
{
    border: 0;
    margin: 0;
    padding: 0;
}
td
{
    border: 0;
    margin: 0;
    padding: 0;
}
#options
{
    font-size: 12vw;
}
#options img
{
    width: 18vw;
    height: 12vw;
}
#kingdoms
{
    font-size: 6vw;
}
#kingdoms img
{
    width: 9vw;
    height: 6vw;
}
input
{
    height: 12vw;
    width: 12vw;
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 8vw;
    background-color: #0000FF;
    color: #FFFFFF;
}
input.have
{
    border: 0.5vw solid #0000FF;
    background-color: #FFFFFF;
    color: #0000FF;
}
a
{
    color: #0000FF;
}
s
{
    text-decoration: line-through double;
}
</style>
<script language="javascript">
var cards = [
    {name: "Cellar", cat: ["Action"], expand: "Base", cost: 2}, 
    {name: "Chapel", cat: ["Action"], expand: "Base", cost: 2},
    {name: "Moat", cat: ["Action", "Reaction"], expand: "Base", cost: 2},
    {name: "Harbinger", cat: ["Action"], expand: "Base", cost: 3},
    {name: "Merchant", cat: ["Action"], expand: "Base", cost: 3},
    {name: "Vassal", cat: ["Action"], expand: "Base", cost: 3},
    {name: "Village", cat: ["Action"], expand: "Base", cost: 3},
    {name: "Workshop", cat: ["Action"], expand: "Base", cost: 3},
    {name: "Bureaucrat", cat: ["Action", "Attack"], expand: "Base", cost: 4},
    {name: "Gardens", cat: ["Victory"], expand: "Base", cost: 4},
    {name: "Militia", cat: ["Action", "Attack"], expand: "Base", cost: 4},
    {name: "Moneylender", cat: ["Action"], expand: "Base", cost: 4},
    {name: "Poacher", cat: ["Action"], expand: "Base", cost: 4},
    {name: "Remodel", cat: ["Action"], expand: "Base", cost: 4},
    {name: "Smithy", cat: ["Action"], expand: "Base", cost: 4},
    {name: "Throne Room", cat: ["Action"], expand: "Base", cost: 4},
    {name: "Bandit", cat: ["Action", "Attack"], expand: "Base", cost: 5},
    {name: "Council Room", cat: ["Action"], expand: "Base", cost: 5},
    {name: "Festival", cat: ["Action"], expand: "Base", cost: 5},
    {name: "Laboratory", cat: ["Action"], expand: "Base", cost: 5},
    {name: "Library", cat: ["Action"], expand: "Base", cost: 5},
    {name: "Market", cat: ["Action"], expand: "Base", cost: 5},
    {name: "Mine", cat: ["Action"], expand: "Base", cost: 5},
    {name: "Senty", cat: ["Action"], expand: "Base", cost: 5},
    {name: "Witch", cat: ["Action", "Attack"], expand: "Base", curser: true, cost: 5},
    {name: "Artisan", cat: ["Action"], expand: "Base", cost: 6},
    {name: "Chancellor", cat: ["Action"], expand: "Base", cost: 3},
    {name: "Woodcutter", cat: ["Action"], expand: "Base", cost: 3},
    {name: "Feast", cat: ["Action"], expand: "Base", cost: 4},
    {name: "Spy", cat: ["Action", "Attack"], expand: "Base", cost: 4},
    {name: "Thief", cat: ["Action", "Attack"], expand: "Base", cost: 4},
    {name: "Adventurer", cat: ["Action"], expand: "Base", cost: 6},
    {name: "Courtyard", cat: ["Action"], expand: "Intrigue", cost: 2},
    {name: "Lurker", cat: ["Action"], expand: "Intrigue", cost: 2},
    {name: "Pawn", cat: ["Action"], expand: "Intrigue", cost: 2},
    {name: "Masquerade", cat: ["Action"], expand: "Intrigue", cost: 3},
    {name: "Shanty Town", cat: ["Action"], expand: "Intrigue", cost: 3},
    {name: "Steward", cat: ["Action"], expand: "Intrigue", cost: 3},
    {name: "Swindler", cat: ["Action", "Attack"], expand: "Intrigue", cost: true, curser: 3},
    {name: "Wishing Well", cat: ["Action"], expand: "Intrigue", cost: 3},
    {name: "Baron", cat: ["Action"], expand: "Intrigue", cost: 4},
    {name: "Bridge", cat: ["Action"], expand: "Intrigue", cost: 4},
    {name: "Conspirator", cat: ["Action"], expand: "Intrigue", cost: 4},
    {name: "Diplomat", cat: ["Action", "Reaction"], expand: "Intrigue", cost: 4},
    {name: "Ironworks", cat: ["Action"], expand: "Intrigue", cost: 4},
    {name: "Mill", cat: ["Action", "Victory"], expand: "Intrigue", cost: 4},
    {name: "Mining Village", cat: ["Action"], expand: "Intrigue", cost: 4},
    {name: "Secret Passage", cat: ["Action"], expand: "Intrigue", cost: 4},
    {name: "Courtier", cat: ["Action"], expand: "Intrigue", cost: 5},
    {name: "Duke", cat: ["Victory"], expand: "Intrigue", cost: 5},
    {name: "Minion", cat: ["Action", "Attack"], expand: "Intrigue", cost: 5},
    {name: "Patrol", cat: ["Action"], expand: "Intrigue", cost: 5},
    {name: "Replace", cat: ["Action", "Attack"], expand: "Intrigue", curser: true, cost: 5},
    {name: "Torturer", cat: ["Action", "Attack"], expand: "Intrigue", curser: true, cost: 5},
    {name: "Trading Post", cat: ["Action"], expand: "Intrigue", cost: 5},
    {name: "Upgrade", cat: ["Action"], expand: "Intrigue", cost: 5},
    {name: "Harem", cat: ["Treasure", "Victory"], expand: "Intrigue", cost: 6},
    {name: "Nobels", cat: ["Action", "Victory"], expand: "Intrigue", cost: 6},
    {name: "Transmute", cat: ["Action"], expand: "Alchemy", potion: true, cost: 0},
    {name: "Vineyard", cat: ["Victory"], expand: "Alchemy", potion: true, cost: 0},
    {name: "Herbalist", cat: ["Action"], expand: "Alchemy", cost: 2},
    {name: "Apothecary", cat: ["Action"], expand: "Alchemy", potion: true, cost: 2},
    {name: "Scrying Pool", cat: ["Action", "Attack"], expand: "Alchemy", potion: true, cost: 2},
    {name: "University", cat: ["Action"], expand: "Alchemy", potion: true, cost: 2},
    {name: "Alchemist", cat: ["Action"], expand: "Alchemy", potion: true, cost: 3},
    {name: "Familiar", cat: ["Action", "Attack"], expand: "Alchemy", curser: true, potion: true, cost: 3},
    {name: "Philosopher’s Stone", cat: ["Treasure"], expand: "Alchemy", potion: true, cost: 3},
    {name: "Golem", cat: ["Action"], expand: "Alchemy", potion: true, cost: 4},
    {name: "Apprentice", cat: ["Action"], expand: "Alchemy", cost: 5},
    {name: "Possession", cat: ["Action"], expand: "Alchemy", potion: true, cost: 6},
    {name: "Loan", cat: ["Treasure"], expand: "Prosperity", cost: 3},
    {name: "Trade Route", cat: ["Action"], expand: "Prosperity", cost: 3},
    {name: "Watchtower", cat: ["Action", "Reaction"], expand: "Prosperity", cost: 3},
    {name: "Bishop", cat: ["Action"], expand: "Prosperity", cost: 4},
    {name: "Monument", cat: ["Action"], expand: "Prosperity", cost: 4},
    {name: "Quarry", cat: ["Treasure"], expand: "Prosperity", cost: 4},
    {name: "Talisman", cat: ["Treasure"], expand: "Prosperity", cost: 4},
    {name: "Worker’s Village", cat: ["Action"], expand: "Prosperity", cost: 4},
    {name: "City", cat: ["Action"], expand: "Prosperity", cost: 5},
    {name: "Contraband", cat: ["Treasure"], expand: "Prosperity", cost: 5},
    {name: "Counting House", cat: ["Action"], expand: "Prosperity", cost: 5},
    {name: "Mint", cat: ["Action"], expand: "Prosperity", cost: 5},
    {name: "Mountebank", cat: ["Action", "Attack"], expand: "Prosperity", curser: true, cost: 5},
    {name: "Rabble", cat: ["Action", "Attack"], expand: "Prosperity", cost: 5},
    {name: "Royal Seal", cat: ["Treasure"], expand: "Prosperity", cost: 5},
    {name: "Vault", cat: ["Action"], expand: "Prosperity", cost: 5},
    {name: "Venture", cat: ["Treasure"], expand: "Prosperity", cost: 5},
    {name: "Goons", cat: ["Action", "Attack"], expand: "Prosperity", cost: 6},
    {name: "Grand Market", cat: ["Action"], expand: "Prosperity", cost: 6},
    {name: "Hoard", cat: ["Treasure"], expand: "Prosperity", cost: 6},
    {name: "Bank", cat: ["Treasure"], expand: "Prosperity", cost: 7},
    {name: "Expand", cat: ["Action"], expand: "Prosperity", cost: 7},
    {name: "Forge", cat: ["Action"], expand: "Prosperity", cost: 7},
    {name: "King’s Court", cat: ["Action"], expand: "Prosperity", cost: 7},
    {name: "Peddler", cat: ["Action"], expand: "Prosperity", cost: 8},
    {name: "Hamlet", cat: ["Action"], expand: "Cornucopia", cost: 2},
    {name: "Forture Teller", cat: ["Action", "Attack"], expand: "Cornucopia", cost: 3},
    {name: "Menagerie", cat: ["Action"], expand: "Cornucopia", cost: 3},
    {name: "Farming Village", cat: ["Action"], expand: "Cornucopia", cost: 4},
    {name: "Horse Traders", cat: ["Action", "Reaction"], expand: "Cornucopia", cost: 4},
    {name: "Remake", cat: ["Action"], expand: "Cornucopia", cost: 4},
    {name: "Tournament", cat: ["Action"], expand: "Cornucopia", curser: true, setup: true, cost: 4},
    {name: "Young Witch", cat: ["Action", "Attack"], expand: "Cornucopia", curser: true, setup: true, cost: 4},
    {name: "Harvest", cat: ["Action"], expand: "Cornucopia", cost: 5},
    {name: "Horn of Plenty", cat: ["Treasure"], expand: "Cornucopia", cost: 5},
    {name: "Hunting Party", cat: ["Action", "Attack"], expand: "Cornucopia", cost: 5},
    {name: "Jester", cat: ["Action"], expand: "Cornucopia", curser: true, cost: 5},
    {name: "Fairgrounds", cat: ["Victory"], expand: "Cornucopia", cost: 6},
    {name: "Crossroads", cat: ["Action"], expand: "Hinterlands", cost: 2},
    {name: "Duchess", cat: ["Action"], expand: "Hinterlands", cost: 2},
    {name: "Fool’s Gold", cat: ["Treasure", "Reaction"], expand: "Hinterlands", cost: 2},
    {name: "Develop", cat: ["Action"], expand: "Hinterlands", cost: 3},
    {name: "Oasis", cat: ["Action"], expand: "Hinterlands", cost: 3},
    {name: "Oracle", cat: ["Action", "Attack"], expand: "Hinterlands", cost: 3},
    {name: "Scheme", cat: ["Action"], expand: "Hinterlands", cost: 3},
    {name: "Tunnel", cat: ["Victory", "Reaction"], expand: "Hinterlands", cost: 3},
    {name: "Jack of All Trades", cat: ["Action"], expand: "Hinterlands", cost: 4},
    {name: "Noble Brigand", cat: ["Action", "Attack"], expand: "Hinterlands", cost: 4},
    {name: "Nomad Camp", cat: ["Action"], expand: "Hinterlands", cost: 4},
    {name: "Silk Road", cat: ["Victory"], expand: "Hinterlands", cost: 4},
    {name: "Spice Merchant", cat: ["Action"], expand: "Hinterlands", cost: 4},
    {name: "Trader", cat: ["Action", "Reaction"], expand: "Hinterlands", cost: 4},
    {name: "Cache", cat: ["Treasure"], expand: "Hinterlands", cost: 5},
    {name: "Cartographer", cat: ["Action"], expand: "Hinterlands", cost: 5},
    {name: "Embassy", cat: ["Action"], expand: "Hinterlands", cost: 5},
    {name: "Haggler", cat: ["Action"], expand: "Hinterlands", cost: 5},
    {name: "Highway", cat: ["Action"], expand: "Hinterlands", cost: 5},
    {name: "Ill-Gotten Gains", cat: ["Treasure"], expand: "Hinterlands", curser: true, cost: 5},
    {name: "Inn", cat: ["Action"], expand: "Hinterlands", cost: 5},
    {name: "Mandarin", cat: ["Action"], expand: "Hinterlands", cost: 5},
    {name: "Margrave", cat: ["Action", "Attack"], expand: "Hinterlands", cost: 5},
    {name: "Stables", cat: ["Action"], expand: "Hinterlands", cost: 5},
    {name: "Border Village", cat: ["Action"], expand: "Hinterlands", cost: 6},
    {name: "Farmland", cat: ["Victory"], expand: "Hinterlands", cost: 6},
    {name: "Black Market", cat: ["Action"], expand: "Promo", setup: true, cost: 3},
    {name: "Envoy", cat: ["Action"], expand: "Promo", cost: 4},
    {name: "Prince", cat: ["Action"], expand: "Promo", cost: 8},
    {name: "Sauna/Avanto", cat: ["Action"], expand: "Promo", cost: 4},
];
var choice = {"Base": true, "Intrigue": true, "Alchemy": true, "Prosperity": true, "Cornucopia": true, "Hinterlands": true, "Promo": true};
var catags = {"Attack": 0, "Treasure": 0, "Victory": 0, "Reaction": 0, "Action": 0};
var cost_limit = 99;
var kingdoms = [];
var remove = [];
var bane = {};
var blackmarket = [];

function chose(s)
{
    choice[s] = !choice[s];
    document.getElementById(s.toLowerCase()).innerHTML = '<img height="8vw" width="12vw" src="'+s.toLowerCase()+'.png"/>&nbsp;'+(choice[s] ? '' : '<s>')+s+(choice[s] ? '' : '</s>')+'</a>';
}
function minim(s, v)
{
    if (s == "Cost")
    {
        cost_limit = v;
        document.getElementById('cost99').className = "";
        document.getElementById('cost3').className = "";
        document.getElementById('cost2').className = "";
    }
    else
    {
        catags[s] = v;
        document.getElementById(s.toLowerCase()+'0').className = "";
        document.getElementById(s.toLowerCase()+'1').className = "";
        document.getElementById(s.toLowerCase()+'2').className = "";
    }
    document.getElementById(s.toLowerCase()+v).className = "have";
}
function shuffle(a)
{
    for (i = a.length - 1; i > 0; i--)
    {
        j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
}

function compare(a, b)
{
    if (a.expand == b.expand)
    {
        return a.name.localeCompare(b.name);
    }
    var expord = {"Base": 0, "Intrigue": 1, "Alchemy": 3, "Prosperity": 4, "Cornucopia": 5, "Hinterlands": 6, "Promo": 999};
    return expord[a.expand] - expord[b.expand];
}

function lock(c, n)
{
    document.getElementById(c.toLowerCase() + (n ? "uu" : "ll")).hidden = false;
    document.getElementById(c.toLowerCase() + (n ? "ll" : "uu")).hidden = true;
    if (n)
    {
        remove.push(c);
    }
    else if (remove.indexOf(c) != -1)
    {
        remove.splice(remove.indexOf(c), 1);
    }
}

function DoTheThing()
{
    shuffle(cards);
    var special = [];
    var potion = false;
    var curse = false;
    var n;
    var catags_ = Object.assign({}, catags);
    for (var t in catags_)
    {
        n = 0;
        while (catags_[t] > 0)
        {
            var c = cards.shift();
            if (!choice[c.expand] || (c.cat.indexOf(t) == -1))
            {
                cards.push(c);
                n++;
                if (n > cards.length)
                {
                    while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                    alert("Not enough kingdom cards. Please select more.");
                    return;
                }
                continue;
            }
            kingdoms.push(c);
            c.cat.forEach(function(i) {catags_[i]--;});
            if (c.setup) {special.push(c.name);}
            potion = (c.expand == "Alchemy" ? true : potion);
            curse = (c.curser ? true : curse);
        }
    }
    n = 0;
    // costs up to 15 coin, excluding specials (e.g. potions)
    var cost_chosen = Array(16).fill(0)
    while (kingdoms.length < 10)
    {
        var c = cards.shift();
        if (!choice[c.expand] || cost_chosen[c.cost] >= cost_limit)
        {
            cards.push(c);
            n++;
            if (n > cards.length)
            {
                while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                alert("Not enough kingdom cards. Please select more.");
                return;
            }
            continue;
        }
        kingdoms.push(c);
        if (c.setup) {special.push(c.name);}
        potion = (c.expand == "Alchemy" ? true : potion);
        cost_chosen[c.cost] += 1
        curse = (c.curser ? true : curse);
    }
    while (special.length > 0)
    {
        var s = special.pop();
        n = 0;
        switch(s)
        {
            case "Young Witch":
                var c = cards.shift();
                while (!choice[c.expand] || c.cost < 2 || c.cost > 3 || c.potion)
                {
                    cards.push(c);
                    n++;
                    if (n > cards.length)
                    {
                        while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                        alert("Not enough kingdom cards. Please select more.");
                        return;
                    }
                    var c = cards.shift();
                }
                bane = c;
                if (c.setup) {special.push(c.name);}
                potion = (c.expand == "Alchemy" ? true : potion);
                curse = (c.curser ? true : curse);
                break;
            case "Black Market":
                if (cards.length < 20)
                {
                    while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                    alert("Not enough kingdom cards. Please select more.");
                    return;
                }
                while (blackmarket.length < 20)
                {
                    var c = cards.shift();
                    if (!choice[c.expand])
                    {
                        n++;
                        if (n > cards.length)
                        {
                            while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                            alert("Not enough kingdom cards. Please select more.");
                            return;
                        }
                        cards.push(c);
                        continue;
                    }
                    blackmarket.push(c);
                    if (c.setup) {special.push(c.name);}
                    potion = (c.expand == "Alchemy" ? true : potion);
                    curse = (c.curser ? true : curse);
                }
                break;
        }
    }
    document.getElementById("options").style.display = "none";
    var prosp = kingdoms[Math.floor(Math.random() * 10)].expand == "Prosperity";
    txt = '<table><tr><td><img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="treasure.png"/> Copper<br/>'
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="treasure.png"/> Silver<br/>'
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="treasure.png"/> Gold<br/>'
          + (prosp ? '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="treasure.png"/> Platinum<br/>' : "")
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="victory.png"/> Estate<br/>'
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="victory.png"/> Duchy<br/>'
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="victory.png"/> Province<br/>'
          + (prosp ? '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="victory.png"/> Colony<br/>' : "")
          + (potion ? '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="potion.png"/> Potion<br/>' : "")
          + '<img height="8vw" width="12vw" src="spacer.png"/>'
		  + (curse ? '<img height="8vw" width="12vw" src="curse.png"/> Curse<br/>' : '<img height="8vw" width="12vw" src="nocurse.png"/> <s>Curse</s><br/>');
    kingdoms.sort(compare);
    kingdoms.forEach(function(i)
    {
        txt += '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+i.name+'\', 1)" id="'+i.name.toLowerCase()+'ll"/>'
               + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+i.name+'\', 0)" id="'+i.name.toLowerCase()+'uu" hidden/>'
               + '<img height="8vw" width="12vw" src="'+i.expand.toLowerCase()+'.png"/> '+i.name+'<br/>';
        switch (i.name)
        {
            case "Young Witch":
                txt += '<img height="8vw" width="12vw" src="spacer.png"/>'
                       + '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+bane.name+'\', 1)" id="'+bane.name.toLowerCase()+'ll"/>'
                       + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+bane.name+'\', 0)" id="'+bane.name.toLowerCase()+'uu" hidden/>'
                       + '&#11208;<img height="8vw" width="12vw" src="'+bane.expand.toLowerCase()+'.png"/> '+bane.name+'<br/>';
                switch (bane.name)
                {
                    case "Black Market":
                        blackmarket.sort(compare);
                        blackmarket.forEach(function(j)
                        {
                            txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                                   + '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+j.name+'\', 1)" id="'+j.name.toLowerCase()+'ll"/>'
                                   + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+j.name+'\', 0)" id="'+j.name.toLowerCase()+'uu" hidden/>'
                                   + '&#11208;<img height="8vw" width="12vw" src="'+j.expand.toLowerCase()+'.png"/> '+j.name+'<br/>';
                            switch (j.name)
                            {
                                case "Tournament":
                                    txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                                           + '&#11208;<img height="8vw" width="12vw" src="cornucopia.png"/> <i>Prizes (5)</i><br/>';
                                    break;
                            }
                        });
                        break;
                }
                break;
            case "Black Market":
                blackmarket.sort(compare);
                blackmarket.forEach(function(j)
                {
                    txt += '<img height="8vw" width="12vw" src="spacer.png"/>'
                           + '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+j.name+'\', 1)" id="'+j.name.toLowerCase()+'ll"/>'
                           + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+j.name+'\', 0)" id="'+j.name.toLowerCase()+'uu" hidden/>'
                           + '&#11208;<img height="8vw" width="12vw" src="'+j.expand.toLowerCase()+'.png"/> '+j.name+'<br/>';
                    switch (j.name)
                    {
                        case "Young Witch":
                            txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                                   + '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+bane.name+'\', 1)" id="'+bane.name.toLowerCase()+'ll"/>'
                                   + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+bane.name+'\', 0)" id="'+bane.name.toLowerCase()+'uu" hidden/>'
                                   + '&#11208;<img height="8vw" width="12vw" src="'+bane.expand.toLowerCase()+'.png"/> '+bane.name+'<br/>';
                            break;
                        case "Tournament":
                            txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                                   + '&#11208;<img height="8vw" width="12vw" src="cornucopia.png"/> <i>Prizes (5)</i><br/>';
                            break;
                    }
                });
                break;
            case "Tournament":
                txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                       + '&#11208;<img height="8vw" width="12vw" src="cornucopia.png"/> <i>Prizes (5)</i><br/>';
                break;
        }
    });
    txt += '</td></tr><tr><td style="text-align:center;"><input type="button" style="width:48vw;" value="Rechoose" onClick="ReDoTheThing()"/></td></tr></table>';
    document.getElementById("kingdoms").innerHTML = txt;
    document.documentElement.scrollTop = 0;
}

function ReDoTheThing()
{
    shuffle(cards);
    var special = [];
    var potion = false;
    var curse = false;
    var catags_ = Object.assign({}, catags);
    var n;
   
    for (var i = kingdoms.length-1; i >= 0; i--)
    {
        var c = kingdoms[i];
        if (remove.indexOf(c.name) != -1)
        {
            kingdoms.splice(i, 1);
            switch (c.name)
            {
                case "Young Witch":
                    cards.push(bane);
                    bane = {};
                    break;
                case "Black Market":
                    while (blackmarket.length > 0)
                    {
                        cards.push(blackmarket.pop());
                    }
                    break;
            }
        }
        else
        {
            potion = (c.expand == "Alchemy" ? true : potion);
            curse = (c.curser ? true : curse);
            c.cat.forEach(function(j) {
                catags_[j]--;
            });
            if (c.setup) {special.push(c.name);}
        }
    }
   
    blackmarket.forEach(function(i) {
        if (remove.indexOf(i.name) != -1)
        {
            blackmarket.splice(blackmarket.indexOf(i), 1);
            switch (i.name)
            {
                case "Young Witch":
                    cards.push(bane);
                    bane = {};
                    break;
            }
        }
        else
        {
            potion = (i.expand == "Alchemy" ? true : potion);
            curse = (i.curser ? true : curse);
            if (i.setup) {special.push(i.name);}
        }
    });
   
    if (bane && remove.indexOf(bane.name) != -1)
    {
        switch (bane.name)
        {
            case "Black Market":
                while (blackmarket.length > 0)
                {
                    cards.push(blackmarket.pop());
                }
                break;
        }
        bane = {};
    }
    remove = [];
    if (cards.length + kingdoms.length < 10)
    {
        while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
        alert("Not enough kingdom cards. Please select more.");
        return;
    }
   
    for (var t in catags_)
    {
        n = 0;
        while (catags_[t] > 0)
        {
            var c = cards.shift();
            if (!choice[c.expand] || (c.cat.indexOf(t) == -1))
            {
                cards.push(c);
                n++;
                if (n > cards.length)
                {
                    while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                    alert("Not enough kingdom cards. Please select more.");
                    return;
                }
                continue;
            }
            kingdoms.push(c);
            c.cat.forEach(function(i) {catags_[i]--;});
            if (c.setup) {special.push(c.name);}
            potion = (c.expand == "Alchemy" ? true : potion);
            curse = (c.curser ? true : curse);
        }
    }
    n = 0;
    while (kingdoms.length < 10)
    {
        var c = cards.shift();
        if (!choice[c.expand])
        {
            cards.push(c);
            n++;
            if (n > cards.length)
            {
                while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                alert("Not enough kingdom cards. Please select more.");
                return;
            }
            continue;
        }
        kingdoms.push(c);
        if (c.setup) {special.push(c.name);}
        potion = (c.expand == "Alchemy" ? true : potion);
        curse = (c.curser ? true : curse);
    }
    while (special.length > 0)
    {
        var s = special.pop();
        n = 0;
        switch(s)
        {
            case "Young Witch":
                var c = cards.shift();
                while (!choice[c.expand] || !c.ywcost)
                {
                    cards.push(c);
                    n++;
                    if (n > cards.length)
                    {
                        while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                        alert("Not enough kingdom cards. Please select more.");
                        return;
                    }
                    var c = cards.shift();
                }
                bane = c;
                if (c.setup) {special.push(c.name);}
                potion = (c.expand == "Alchemy" ? true : potion);
                curse = (c.curser ? true : curse);
                break;
            case "Black Market":
                if (cards.length < 20)
                {
                    while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                    alert("Not enough kingdom cards. Please select more.");
                    return;
                }
                while (blackmarket.length < 20)
                {
                    var c = cards.shift();
                    if (!choice[c.expand])
                    {
                        n++;
                        if (n > cards.length)
                        {
                            while (kingdoms.length > 0) {cards.push(kingdoms.pop());}
                            alert("Not enough kingdom cards. Please select more.");
                            return;
                        }
                        cards.push(c);
                        continue;
                    }
                    blackmarket.push(c);
                    if (c.setup) {special.push(c.name);}
                    potion = (c.expand == "Alchemy" ? true : potion);
                    curse = (c.curser ? true : curse);
                }
                break;
        }
    }
    var prosp = kingdoms[Math.floor(Math.random() * 10)].expand == "Prosperity";
    txt = '<table><tr><td><img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="treasure.png"/> Copper<br/>'
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="treasure.png"/> Silver<br/>'
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="treasure.png"/> Gold<br/>'
          + (prosp ? '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="treasure.png"/> Platinum<br/>' : "")
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="victory.png"/> Estate<br/>'
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="victory.png"/> Duchy<br/>'
          + '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="victory.png"/> Province<br/>'
          + (prosp ? '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="victory.png"/> Colony<br/>' : "")
          + (potion ? '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="potion.png"/> Potion<br/>' : "")
          + '<img height="8vw" width="12vw" src="spacer.png"/>'
		  + (curse ? '<img height="8vw" width="12vw" src="curse.png"/>Curse<br/>' : '<img height="8vw" width="12vw" src="nocurse.png"/><s>Curse</s><br/>');
    kingdoms.sort(compare);
    kingdoms.forEach(function(i)
    {
        txt += '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+i.name+'\', 1)" id="'+i.name.toLowerCase()+'ll"/>'
               + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+i.name+'\', 0)" id="'+i.name.toLowerCase()+'uu" hidden/>'
               + '<img height="8vw" width="12vw" src="'+i.expand.toLowerCase()+'.png"/> '+i.name+'<br/>';
        switch (i.name)
        {
            case "Young Witch":
                txt += '<img height="8vw" width="12vw" src="spacer.png"/>'
                       + '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+bane.name+'\', 1)" id="'+bane.name.toLowerCase()+'ll"/>'
                       + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+bane.name+'\', 0)" id="'+bane.name.toLowerCase()+'uu" hidden/>'
                       + '&#11208;<img height="8vw" width="12vw" src="'+bane.expand.toLowerCase()+'.png"/> '+bane.name+'<br/>';
                switch (bane.name)
                    {
                        case "Black Market":
                            blackmarket.sort(compare);
                            blackmarket.forEach(function(j)
                            {
                                txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                                       + '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+j.name+'\', 1)" id="'+j.name.toLowerCase()+'ll"/>'
                                       + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+j.name+'\', 0)" id="'+j.name.toLowerCase()+'uu" hidden/>'
                                       + '&#11208;<img height="8vw" width="12vw" src="'+j.expand.toLowerCase()+'.png"/> '+j.name+'<br/>';
                                switch (j.name)
                                {
                                    case "Tournament":
                                        txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                                               + '&#11208;<img height="8vw" width="12vw" src="cornucopia.png"/> <i>Prizes (5)</i><br/>';
                                        break;
                                }
                            });
                            break;
                    }
                break;
            case "Black Market":
                blackmarket.sort(compare);
                blackmarket.forEach(function(j)
                {
                    txt += '<img height="8vw" width="12vw" src="spacer.png"/>'
                           + '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+j.name+'\', 1)" id="'+j.name.toLowerCase()+'ll"/>'
                           + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+j.name+'\', 0)" id="'+j.name.toLowerCase()+'uu" hidden/>'
                           + '&#11208;<img height="8vw" width="12vw" src="'+j.expand.toLowerCase()+'.png"/> '+j.name+'<br/>';
                    switch (j.name)
                    {
                        case "Young Witch":
                            txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                                   + '<img height="8vw" width="12vw" src="locked.png" onClick="lock(\''+bane.name+'\', 1)" id="'+bane.name.toLowerCase()+'ll"/>'
                                   + '<img height="8vw" width="12vw" src="unlocked.png" onClick="lock(\''+bane.name+'\', 0)" id="'+bane.name.toLowerCase()+'uu" hidden/>'
                                   + '&#11208;<img height="8vw" width="12vw" src="'+bane.expand.toLowerCase()+'.png"/> '+bane.name+'<br/>';
                            break;
                        case "Tournament":
                            txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                                   + '&#11208;<img height="8vw" width="12vw" src="cornucopia.png"/> <i>Prizes (5)</i><br/>';
                            break;
                    }
                });
                break;
            case "Tournament":
                txt += '<img height="8vw" width="12vw" src="spacer.png"/><img height="8vw" width="12vw" src="spacer.png"/>'
                       + '&#11208;<img height="8vw" width="12vw" src="cornucopia.png"/> <i>Prizes (5)</i><br/>';
                break;
        }
    });
    txt += '</td></tr><tr><td style="text-align:center;"><input type="button" style="width:48vw;" value="Rechoose" onClick="ReDoTheThing()"/></td></tr></table>';
    document.getElementById("kingdoms").innerHTML = txt;
    document.documentElement.scrollTop = 0;
}

</script>
</head>
<body>
<div id="options">
<a id="base" onClick="chose('Base');"><img height="8vw" width="12vw" src="base.png"/>&nbsp;Base</a><br/>
<a id="alchemy" onClick="chose('Alchemy');"><img height="8vw" width="12vw" src="alchemy.png"/>&nbsp;Alchemy</a><br/>
<a id="intrigue" onClick="chose('Intrigue');"><img height="8vw" width="12vw" src="intrigue.png"/>&nbsp;Intrigue</a><br/>
<a id="prosperity" onClick="chose('Prosperity');"><img height="8vw" width="12vw" src="prosperity.png"/>&nbsp;Prosperity</a><br/>
<a id="cornucopia" onClick="chose('Cornucopia');"><img height="8vw" width="12vw" src="cornucopia.png"/>&nbsp;Cornucopia</a><br/>
<a id="hinterlands" onClick="chose('Hinterlands');"><img height="8vw" width="12vw" src="hinterlands.png"/>&nbsp;Hinterlands</a><br/>
<a id="promo" onClick="chose('Promo');"><img height="8vw" width="12vw" src="promo.png"/>&nbsp;Promo</a><br/>
<table><tr><td>Action</td>
    <td><input type="button" value="0+" onClick="minim('Action', 0)" class="have" id="action0"/>
    <input type="button" value="1+" onClick="minim('Action', 1)" id="action1"/>
    <input type="button" value="2+" onClick="minim('Action', 2)" id="action2"/></td></tr>
<tr><td>Attack</td>
    <td><input type="button" value="0+" onClick="minim('Attack', 0)" class="have" id="attack0"/>
    <input type="button" value="1+" onClick="minim('Attack', 1)" id="attack1"/>
    <input type="button" value="2+" onClick="minim('Attack', 2)" id="attack2"/></td></tr>
<tr><td>Reaction&nbsp;</td>
    <td><input type="button" value="0+" onClick="minim('Reaction', 0)" class="have" id="reaction0"/>
    <input type="button" value="1+" onClick="minim('Reaction', 1)" id="reaction1"/>
    <input type="button" value="2+" onClick="minim('Reaction', 2)" id="reaction2"/></td></tr>
<tr><td>Treasure</td>
    <td><input type="button" value="0+" onClick="minim('Treasure', 0)" class="have" id="treasure0"/>
    <input type="button" value="1+" onClick="minim('Treasure', 1)" id="treasure1"/>
    <input type="button" value="2+" onClick="minim('Treasure', 2)" id="treasure2"/></td></tr>
<tr><td>Victory</td>
    <td><input type="button" value="0+" onClick="minim('Victory', 0)" class="have" id="victory0"/>
    <input type="button" value="1+" onClick="minim('Victory', 1)" id="victory1"/>
    <input type="button" value="2+" onClick="minim('Victory', 2)" id="victory2"/></td></tr>
<tr><td style="font-size:8vw; line-height:0.8;">Duplicate</br>Costs</td>
    <td><input type="button" value="&infin;&minus;" onClick="minim('Cost', 99)" class="have" id="cost99"/>
    <input type="button" value="3&minus;" onClick="minim('Cost', 3)" id="cost3"/>
    <input type="button" value="2&minus;" onClick="minim('Cost', 2)" id="cost2"/></td></tr>
<tr><td colspan="2" style="text-align:center;"><input type="button" style="width:48vw;" value="Choose" onClick="DoTheThing()"/></td></tr></table>
</div>
<div id="kingdoms"></div>

</body>
</html>