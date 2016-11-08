<?php 	require_once "php/badmin.php"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Brotherhood Gaming</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="description" content="">
    <meta name="author" content="David">
    <!-- Viewport for Mobile Responsiveness -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="css/stats.css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
</head>

    <body id="body">
        <div class="indexHero">
            <!-- Main Navigation Menu -->
            <div class="navFixed"></div>
            <div class="navHeader clearFix">
                <i class="navIcon material-icons floatLeft" id="navMenu">menu</i>
                <h1 class="navTitle">Brotherhood</h1>
                <i class="navIcon material-icons floatRight" id="navSearch">keyboard_arrow_down</i>
                <!-- Submenu Navigation -->
                <div class="navHeaderMenu clearFix" id="navHeaderMenu" style="display:none;">
                    <p class="navHeaderOptions">
                        <a href="index.html#indexAbout">About</a>
                    </p>
                    <p class="navHeaderOptions">
                        <a href="index.html#indexStory">Story</a>
                    </p>
                    <p class="navHeaderOptions">
                        <a href="index.html#indexRoster">Roster</a>
                    </p>
                </div>
                <!-- End Submenu Navigation -->
            </div>

            <!-- Content -->
            <div class="container">
                <div class="main clearFix">
                    <!-- Primary Content -->

                    <div class="statCenter clearFix">
                        <div class="informationRow">
                            <div class="statsHeader">
                                <p class="statsHeaderLabel floatLeft">
                                    Players
                                </p>
                                <i class="material-icons statsHeaderCollapse" id="collapseCarat3">
                                    arrow_drop_down
                                </i>
                            </div>
                            <div id="statRow3">
                                <a name="players">
                                    <?php playertable($players); ?>
                                </a>
                            </div>
                        </div>
                        <div class="informationRow">
                            <div class="statsHeader">
                                <p class="statsHeaderLabel floatLeft">
                                    General
                                </p>
                                <i class="material-icons statsHeaderCollapse" id="collapseCarat1">
                                    arrow_drop_down
                                </i>
                            </div>
                            <div  id="statRow1">
                                <?php infotable($info); ?>
                            </div>
                        </div>
                        <div class="informationRow">
                            <div class="statsHeader">
                                <p class="statsHeaderLabel floatLeft">
                                    Details
                                </p>
                                <i class="material-icons statsHeaderCollapse" id="collapseCarat2">
                                    arrow_drop_down
                                </i>
                            </div>
                            <div  id="statRow2">
                                <?php ruletable($rules); ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="overlay" id="overlay"></div>
            <!-- End Content -->

            <!-- Main Menu -->
            <div class="mainMenu shadow" id="mainMenu">
                <h3 class="menuTitle">
                    Menu
                    <i id="menuCloseButton" type="button" class="material-icons optbtn floatRight">clear</i>
                </h3>
                <div id="aboutMenuButton" class="mainMenuButton">
                    <a href="index.html">
                        <p>Home</p>
                    </a>
                </div>
                <div id="aboutMenuButton" class="mainMenuButton">
                    <p>
                        <a href="reddit.html">
                            Reddit
                        </a>
                    </p>
                </div>
                <div id="statsMenuButton" class="mainMenuButton">
                    <p>
                        <a href="stats.php">
                            Statistics
                        </a>
                    </p>
                </div>
                <div id="settingsMenuButton" class="mainMenuButton">
                    <p>Settings</p>
                </div>
                <p id="menuFooter" class="menuFooter">
                    Brotherhood Gaming (© <a href="#" target="_blank">2016</a>) is operated by <a href="#" target="_blank">fools</a>.
                    Design by <a href="#" target="_blank">Tourist and Goose</a>. Powered by
                    <a href="#" target="_blank">Hampsters.</a>
                </p>
            </div>
            <!-- End Main Menu -->

            <!-- Settings Menu -->
            <div class="settingsMenu shadow" id="settingsMenu">
                <h3 class="menuTitle">
                    Settings
                    <i id="settingsCloseButton" type="button" class="material-icons optbtn floatRight">keyboard_arrow_up</i>
                </h3>
                <a href="login.html">
                    <div id="loginMenuButton" class="mainMenuButton">
                        <p>Log In</p>
                    </div>
                </a>
                <div class="mainMenuButton">
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                        <p>Coming Soon!</p>
                    </a>
                </div>
            </div>
            <!-- End Settings Menu -->

        </div>
    </body>
</html>
