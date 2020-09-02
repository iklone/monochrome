<head>
    <?php
        $colour = rand(0,2);
        //0: red
        //1: green
        //2: purple

        $APIseason = array("winter", "spring", "summer", "fall");
        $nameseason = array("Winter", "Spring", "Summer", "Autumn");
        $season = floor((date("n") - 1) / 3);

        $titlecolour = array("SCARLET", "JADE", "VIOLET");
        $titlefantasy = array("FANTASY", "DELUSION", "DREAM", "ILLUSION", "HALLUCINATION", "APPARITION", "PHANTASM", "AMNESIA");

        $title = "A " . $titlecolour[$colour] . " " . $titlefantasy[rand(0, sizeof($titlefantasy) - 1)];
    ?>

    <title><?php echo $title ?></title>

    <link rel = "stylesheet" type = "text/css" href = "./main.css">

    <style>
        * {
            <?php
                $forecolour = array("rgb(255, 0, 0)", "rgb(0, 200, 0)", "rgb(200, 0, 200)");
                $backcolour = array("rgb(70, 0, 0)", "rgb(0, 70, 0)", "rgb(70, 0, 70)");

                echo "color: " . $forecolour[$colour] . ";";
                echo "border-color: " . $forecolour[$colour] . ";";
                echo "background-color: " . $backcolour[$colour] . ";";
            ?>
        }
    </style>

    <script>
        window.onload = initialise();

        async function initialise() {
            await seasonalList(<?php echo date("Y") . ', "' . $APIseason[$season] . '"';?>);
            await favList();
            setipsum();
        }

        async function seasonalList(year, season) {
            response = await fetch("https://api.jikan.moe/v3/user/iklone/animelist/all?order_by=score&sort=desc&year=" + year + "&season=" + season);
            list = await response.json();
            list = list["anime"];

            //aots
            addli("aots", list[0]["title"]);

            //watching & dropped
            for (anime in list) {
                //watching
                if (list[anime]["watching_status"] == 1) {
                    addli("wfts", list[anime]["title"]);
                }
                //watching
                if (list[anime]["watching_status"] == 4) {
                    addli("dfts", list[anime]["title"]);
                }
            }
        }

        async function favList() {
            response = await fetch("https://api.jikan.moe/v3/user/iklone/profile");
            list = await response.json();
            alist = list["favorites"]["anime"];
            mlist = list["favorites"]["manga"];

            //anime
            for (anime in alist) {
                addli("aoat", alist[anime]["name"]);
            }

            //manga
            for (manga in mlist) {
                addli("moat", mlist[manga]["name"]);
            }
        }

        function addli(parentid, text) {
            parentList = document.getElementById(parentid);
            var newItem = document.createElement("li");
            var newVal = document.createTextNode(text);
            newItem.appendChild(newVal);
            parentList.appendChild(newItem);
        }
    </script>
    <script src="loremipsum.js"></script>
</head>
<body>
    <div id="head">
        <h1><a href="."><?php echo $title ?></a></h1>
        <div>
            Please only browse this website if you have watched 1000 anime.<br>
            1000以上のアニメを見てばことがなければこのサイトを読まないでください。
        </div>
        <div id="bar">
            <button>Alpha</button>
            <button>Beta</button>
            <button>Gamma</button>
        </div>
    </div>

    <div id="body">
        <table>
            <td class="bordtd" id="lbord">
                <h3>About This Website</h3>
                <p>This website is the latest incarnation of a string of otaku-themed blogs stretching over the last six years. I am the administrator and writer, iklone and I post about otaku media.</p>
                <p>This site was developed in 2020 and is meant to look like this. It is the fifth anime website I've run, the older (extant) sites are archived <a href="https://www.blogger.com/profile/05726480952560360312">here</a> if you want to look around.</p>
                <p>I post about a range of topics, primarily anime commentary and analysis (lol). I also post thoughts on otaku culture and anime-adjacent media. My favourite period of anime is around 1995 to 2005.</p>
                <hr>
                <h4>External Links:</h4>
                <ul>
                    <li><a href="https://myanimelist.net/profile/iklone">MyAnimeList</a></li>
                    <li><a href="https://twitter.com/iklone">Twitter</a></li>
                    <li><a href="https://github.com/iklone/">Github</a></li>
                </ul>
                <hr>

                <h3>GOAT Anime:</h3>
                <ul id="aoat"></ul>
                <hr>

                <h3>GOAT Manga:</h3>
                <ul id="moat"></ul>
            </td>
            <td class="feedtd">
                <?php
                    $revList = glob('./posts/*');
                    rsort($revList);

                    foreach($revList as $rev) {
                        $file = fopen($rev, "r");

                        $title = fgets($file);
                        $author = fgets($file);
                        $date = fgets($file);
                        $score = fgets($file);

                        $revNum = explode("/", $rev)[2];

                        if (isset($_GET["term"])) {
                            $include = FALSE;
                            $lterm = strtolower($_GET["term"]);

                            if (preg_match('*' . $lterm . '*', strtolower($title))) {
                                $include = TRUE;
                            }
                        } else {
                            $include = TRUE;
                        }

                        if ($include) {
                            $review = "";
                            while(! feof($file)) {
                                $review = $review . fgets($file);
                            }
                            $review = str_replace("\n", "<br>", $review);

                            echo '<article id="review' . $revNum . '">' . "\n";
                            echo "\t" . '<h3 class="revTitle"><a class="blankLink" href="./?term=' . $title . '">' . $title . '</a></h3>' . "\n";
                            echo "\t" . '<div class="revBody">' . $review . '</div>' . "\n";
                            echo "\t" . '<div class="revDate">Post #' . $revNum . ' | ' . $date . '</div>' . "\n";
                            echo '</article>';
                            echo '<hr>';
                        }
                        
                        fclose($file);
                    }
                ?>
            </td>
            <td class="bordtd">
                <h3>The <?php echo $nameseason[$season] . date(" Y") . " season"; ?>:</h3>

                <h4>AOTS:</h4>
                <ul id="aots"></ul>

                <h4>Watching:</h4>
                <ol id="wfts"></ol>

                <h4>Dropped:</h4>
                <ul id="dfts"></ul>
                <hr>
                <h3>Post Archive:</h3>
                <ul id="archive">
                    <?php
                        foreach($revList as $rev) {
                            $file = fopen($rev, "r");

                            $title = fgets($file);

                            echo '<li><a href="./?term=' . $title . '">' . $title . "</a></li>";
                        }
                    ?>
                </ul>
            </td>
        </table>
    </div>

    <div id="foot">
        This website is run by iklone in the year <?php echo date("Y"); ?>. Contact me on Twitter <a href="https://twitter.com/iklone">@iklone</a>.
    </div>
</body>