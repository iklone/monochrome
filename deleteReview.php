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

            $file = "./posts/" . $_POST["id"];

            unlink($file);
            echo "Deleted file: " . $file;
            echo "<br>";

            echo "<hr>";

        } else {
            echo "Permission denied";
        }
    ?>
    <a href="./delete.html">Delete another</a><br>
    <a href=".">Back to homepage</a>
</body>