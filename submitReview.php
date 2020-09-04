<body>
    <?php
        echo "Starting PHP";
        echo "<br>";
        error_reporting(E_ERROR | E_PARSE);

        $password = $_POST["password"];
        $truth = "password";

        if ($password == $truth) {
            echo "Permission granted";
            echo "<br>";

            $anime = $_POST["title"];
            $review = $_POST["review"];
            $score = $_POST["score"];

            $name = $_POST["name"];
            if ($name == "") {
                $name = "iklone";
            }
            echo "Name set as " . $name;
            echo "<br>";

            $datetime = date("d M Y @ h:ia");

            echo "Datetime: " . $datetime;
            echo "<br>";

            $cIDFile = fopen("cID", "r") or die("Unable to open cID file");
            $cID = fread($cIDFile, filesize("cID"));
            fclose($cIDFile);
            echo "Read cID file. Old ID = " . $cID;
            echo "<br>";

            $cID = $cID + 1;
            $cIDFile = fopen("cID", "w") or die("Unable to open cID file");
            fwrite($cIDFile, $cID);
            fclose($cIDFile);
            echo "Updated stat file. New ID = " . $cID;
            echo "<br>";

            $fileText = $anime . "\n" . $name . "\n" . $datetime . "\n" . $score . "\n" . "$review";
            $file = fopen("./posts/" . str_pad($cID, 5, "0", STR_PAD_LEFT), "w") or die("Unable to open review file");
            fwrite($file, $fileText);
            fclose($file);
            echo "Created post file";
            echo "<hr>";

        } else {
            echo "Permission denied";
        }
    ?>
    <a href=".">Back to homepage</a>
</body>