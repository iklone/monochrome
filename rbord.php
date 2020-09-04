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