<head>
    <?php include "./header.php";?>

    <title><?php echo $lowertitle ?></title>
    <link rel="icon" type="image/png" href="<?php echo $iconcolour[$colour];?>"/>
    <meta name="description" content="A blog about anime, manga and otaku culture run by iklone. My taste is better than yours.">

    <link rel = "stylesheet" type = "text/css" href = "./main.css">
</head>
<body>
    <?php include "./head.php";?>

    <div id="body">
        <table>
            <td class="bordtd" id="lbord">
                <?php include "./lbord.php";?>
            </td>
            <td class="feedtd">
                <form id="searchForm">
                    <input type="text" id="term" name="term" placeholder="Search"
                        <?php
                            if (isset($_GET["term"])) {
                                echo 'value="' . $_GET["term"] . '"';
                            }
                        ?>
                        >
                    <button type="submit" class="redButton">Search</button>
                </form>

                <div id="resultNum"></div>
                <hr>

                <?php
                    $resultNum = 0;

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
                            $resultNum++;
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
            <td class="bordtd" id="rbord">
                <?php include "./rbord.php";?>
            </td>
        </table>
    </div>

    <?php include "./foot.php";?>

    <script>
        document.getElementById("resultNum").innerHTML = "<?php
            if ($resultNum == 0) {
                echo "No posts found";
            } else {
                echo $resultNum . " posts listed";
            }
            ?>";

        window.onload = initialise();
    </script>
</body>