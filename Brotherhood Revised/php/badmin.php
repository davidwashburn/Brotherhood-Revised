<?php

/* TODO - Change socket timeout to handle server restarts. Can also use this to calculate time alive
*		  - Place data into database for later statistical survey (Google has graphing API for this)
*		  - Efficiency and performance. Considering rewriting the sockets and data manipulation in C
*
*
*/

$ip = gethostbyname("play.dayzunderground.com");
$port = 2512;
steamquery($ip,$port);

/* -- FUNCTION LIBRARY --
*	- Purpose: Explose variables and functions to the interface for accessibility
*/

$info = parseinfo($a2s_info); //array

//multidimensional arrays - see helper function - dump($args) for values
$rules = parserules($a2s_rules);
$players = parseplayers($a2s_player);
// -- END FUNCTION LIBRARY --

// -- SOCKET -- Opens a socket at the specified ip/port. Queries for a2s_info, a2s_player, a2s_rules per Valve specification.
// Store those values in global variables, which we then pass to other functions to  parse the data.
function steamquery($ip, $port)
{
    global $a2s_info;
    global $a2s_player;
    global $a2s_rules;
    $info = "\xFF\xFF\xFF\xFF\x54\x53\x6F\x75\x72\x63\x65\x20\x45\x6E\x67\x69\x6E\x65\x20\x51\x75\x65\x72\x79\x00";
    $players = "\xFF\xFF\xFF\xFF\x55\xFF\xFF\xFF\xFF";
    $rules = "\xFF\xFF\xFF\xFF\x56\xFF\xFF\xFF\xFF";

    $socket = fsockopen("udp://".$ip, $port, $errno, $errstr, 10);
    //Requesting info
    fwrite($socket, $info);
    $a2s_info = fread($socket, 4096);
    //Requesting players requires a challenge response.
    fwrite($socket, $players);
    $challenge = fread($socket, 4096);
    $response = "\xFF\xFF\xFF\xFF\x55" . substr($challenge, 5);
    fwrite($socket, $response);
    $a2s_player = fread($socket, 4096);
    //Requesting rules requres a challenge response.
    fwrite($socket, $rules);
    $challenge = fread($socket, 4096);
    $response = "\xFF\xFF\xFF\xFF\x56" . substr($challenge, 5);
    fwrite($socket, $response);
    $a2s_rules = fread($socket,  4096);
    fclose($socket);
}
// -- DISPLAY FUNCTIONS --

// Display the results of a2s_info in a table
function infotable($args)
{
    $count = $args["bytes"];
    echo <<<EOT
	<div class="statsSection shadow clearfix">		
        <div class="statsCell clearfix">
            <p class="stats left">
                game
            </p>
            <p class="stats right">
                $args[game]
            </p>
        </div>
        <div class="statsCell clearfix">
            <p class="stats left short">
                name
            </p>
            <p class="stats right wide">
                <a href="https://www.reddit.com/r/dayzunderground">
                    $args[name]
                    <i class="material-icons" style="transform: translateY(28%);">keyboard_arrow_right</i>
                </a>
            </p>
        </div>
        <div class="statsCell clearfix">
            <p class="stats left">
                max players
            </p>
            <p class="stats right">
                $args[playersmax]
            </p>
        </div>
        <div class="statsCell clearfix">
            <p class="stats left">
                players
            </p>
            <p class="stats right" id="playerNumbers">
                $args[players]
            </p>
        </div>
        <div class="statsCell clearfix">
            <p class="stats left">
                server time
            </p>
            <p class="stats right">
                $args[time]
            </p>
        </div>
        <div class="statsCell clearfix">
            <p class="stats left">
                password
            </p>
            <p class="stats right">
                $args[password]
            </p>
        </div>
        <div class="statsCell clearfix hide">
            <p class="stats left">
                folder
            </p>
            <p class="stats right">
                $args[folder]
            </p>
        </div>
        <div class="statsCell clearfix hide">
            <p class="stats left">
                id
            </p>
            <p class="stats right">
                $args[id]
            </p>
        </div>
	</div>

	<div class="statsSection shadow clearfix">
        <div class="statsCell clearfix">
            <p class="stats left">
                bots
            </p>
            <p class="stats right">
                $args[bots]
            </p>
        </div>
        <div class="statsCell clearfix hide">
            <p class="stats left">
                map
            </p>
            <p class="stats right">
                $args[map]
            </p>
        </div>
        <div class="statsCell clearfix">
            <p class="stats left">
                server type
            </p>
            <p class="stats right">
                $args[server_type]
            </p>
        </div>
        <div class="statsCell clearfix">
            <p class="stats left">
                environment
            </p>
            <p class="stats right">
                $args[environment]
            </p>
        </div>
        <div class="statsCell clearfix">
            <p class="stats left">
                vac
            </p>
            <p class="stats right">
                $args[vac]
            </p>
        </div>
        <div class="statsCell clearfix">
            <p class="stats left">
                version
            </p>
            <p class="stats right">
                $args[version]
            </p>
        </div>
	</div>
EOT;
}

// Display the results of a2s_players in a table
function playertable($args)
{
    $count = $args["packet"]["bytes"];
    echo <<<EOT
	<div class="statsSection shadow clearfix">

EOT;
    for($j = 0; $j < hexdec($args["packet"]["players"]); $j++)
    {
        echo "<div class='statsCell clearfix'>" . "<p class='stats left'>" . $args["$j"]["name"] ."&nbsp;&nbsp;" . "</p>" . "<p class='hide'>" . "0" . "</p>" . "<p class='stats right'>" . $args["$j"]["time"] . "</p>" . "</div>";
    }
    echo <<<EOT
    </div>
EOT;
}

// Display the results of a2s_rules in a table
function ruletable($args)
{
    $bytes = $args["packet"]["bytes"];
    echo <<<EOT
	<div class="statsSection shadow clearfix">
EOT;
    for($i = 0; $i < hexdec($args["packet"]["rules"]); $i++)
    {
        echo "<div class='statsCell clearfix'>" . "<p class='stats left'>" . $args["$i"]["name"] . "</p>" . "<p class='stats right'>" . $args["$i"]["rule"] . "</p>" . "</div>";
    }
    echo <<<EOT
    </div>
EOT;
}
// -- END DISPLAY FUNCTIONS --

// -- PARSE FUNCTIONS --
// the parsing of info is going to be reworked
function parseinfo($args)
{
    $count = count(str_split(bin2hex($args),2));
    $packet = explode("\x00", substr($args, 6), 5);
    $server = array();

    $server['name'] = $packet[0];
    $server['map'] = $packet[1];
    $server['folder'] = $packet[2];
    $server['game'] = $packet[3];
    $inner = $packet[4];
    $server['id'] = ord(substr($inner,0,2));
    $server['players'] = ord(substr($inner, 2, 1));
    $server['playersmax'] = ord(substr($inner, 3, 1));
    $server['bots'] = ord(substr($inner, 4, 1));
    $server['server_type'] = substr($inner, 5, 1);
    $server['environment'] = substr($inner, 6, 1);
    $server['password'] = ord(substr($inner, 7, 1));
    $server['vac'] = ord(substr($inner, 8, 1));
    $server['time'] = substr($inner, 68, 5);
    $server['version'] = substr($inner, 9, 10);
    $server['bytes'] = $count;

    return $server;
}
// Read the a2s_players packet, returns the data in an array.
function parseplayers($args)
{
    $bytes = str_split(bin2hex($args),2);
    $count = count($bytes);


    $i = 0; //Initialize $i and gather the header info
    $online = array(  "packet" => array ( "destination" => gethead($bytes, $i),
        "header" => getbyte($bytes, $i),
        "players" => getbyte($bytes, $i),
        "bytes" => $count,
    ),);
    //Hexidecimal to decimal conversion	for iterating
    $players = hexdec($online['packet']['players']);
    for($j = 0; $j < $players; $j++)
    {
        $online["$j"] = array ( "index" => getbyte($bytes, $i),
            "name" => displayname(getstring($bytes, $i)),
            "score" => get32($bytes, $i),
            "time" => displaytime(get32($bytes, $i)),
        );}
    return $online;
}
// Read the a2s_rules packet, returns the data in an array.
function parserules($args)
{
    $bytes = str_split(bin2hex($args),2);
    $count = count($bytes);

    $i = 0;
    $rules = array( "packet" => array( "destination" => gethead($bytes, $i),
        "header" => getbyte($bytes, $i),
        "rules" => getbyte($bytes, $i),
        "bytes" => $count,
    ),);
    $i++; // needed to get over the initial "\x00"
    $num = hexdec($rules['packet']['rules']);

    for($j = 0; $j < $num; $j++)
    {
        $rules["$j"] = array ( "name" => displayname(getstring($bytes, $i)),
            "rule" => displayname(getstring($bytes, $i)),
        );}

    return $rules;
}
// -- END PARSE FUNCTIONS --

// -- CONVERSION FUNCTIONS --
function displayname($args)
{
    // cheated, used code : http://stackoverflow.com/questions/14674834/php-convert-string-to-hex-and-hex-to-string
    $string='';
    for ($i=0; $i < strlen($args)-1; $i+=2){
        $string .= chr(hexdec($args[$i].$args[$i+1]));
    }
    return htmlspecialchars($string);
}
function displaytime($args)
{
    // Convert to little endian float, inside an array
    $temp = unpack("f*", hex2bin($args));
    $float = implode($temp);
    $hours = floor($float / 3600);
    $minutes = floor($float / 60 % 60);
    $seconds = floor($float % 60);

    if($hours >= 1 )
        $result = sprintf("$hours". "h " .  "$minutes" . "m " . "$seconds" . "s");
    else if ($minutes >= 1)
        $result = sprintf("$minutes" . "m " . $seconds . "s");
    else
        $result = "$seconds s";

    return $result;
}
// -- END CONVERSION FUNCTIONS --

//  -- CAPTURE FUNCTIONS --
//These work together, pushing the iterator along as they are called.
// gethead will eventually be removed
function gethead($args, & $iter)
{
    $temp = $args[$iter];
    for($iter = 0; $iter < 3; $iter++)
    {
        $temp .= $args[$iter];
    }
    return $temp;
}
//A byte, 8 bits, is considered two hexidecimal characters.
function getbyte($args, & $iter)
{
    $iter++;
    return $args[$iter];
}
// All strings are ended with "\x00" according to Valve
function getstring($args, & $iter)
{
    $iter++;
    $temp = "";
    for($iter; $args[$iter] != hexdec(0); $iter++)
    {
        $temp .= $args[$iter];
    }
    return $temp;
}
// In server query packets, there is nothing longer than 32 bit.
function get32($args, & $iter)
{
    $temp = "";
    for($j = 0; $j <= 3; $j++)
    {
        $temp .= getbyte($args, $iter);
    }
    return $temp;
}
// -- END CAPTURE FUNCTIONS --

// -- HELPER FUNCTIONS --
function dump($args)
{
    echo '<pre style="float: left;">';
    print_r($args);
    echo "</pre>";
}
// -- END HELPER FUNCTIONS --
?>