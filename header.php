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
    $iconcolour = array("./faviconRed.png", "./faviconGreen.png", "./faviconPurple.png");

    $fantasy = $titlefantasy[rand(0, sizeof($titlefantasy) - 1)];
    $title = "A " . $titlecolour[$colour] . " " . $fantasy;
    $lowertitle = ucfirst(strtolower($titlecolour[$colour])) . " " . ucfirst(strtolower($fantasy));

    $revList = glob('./posts/*');
    rsort($revList);
?>

<!--<style>
    * {
        <?php
            $forecolour = array("rgb(255, 0, 0)", "rgb(0, 200, 0)", "rgb(200, 0, 200)");
            $backcolour = array("rgb(70, 0, 0)", "rgb(0, 70, 0)", "rgb(70, 0, 70)");

            echo "color: " . $forecolour[$colour] . ";";
            echo "border-color: " . $forecolour[$colour] . ";";
            echo "background-color: " . $backcolour[$colour] . ";";
        ?>
    }
</style>-->

<script>
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function initialise() {
        setipsum();
        await seasonalList(<?php echo date("Y") . ', "' . $APIseason[$season] . '"';?>);
        await sleep(1000);
        await favList();
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

    function setipsum() {
        ipsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        ipsumClasses = document.getElementsByClassName("ipsum");

        for (ipsumClass in ipsumClasses) {
            ipsumClasses[ipsumClass].innerHTML = ipsum;
        }
    }
</script>