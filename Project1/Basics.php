<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Tutorial</title>
</head>
<style>
* {
    margin: 0;
    padding: 0;
}

.container {
    max-width: 80%;
    background-color: #898989;
    margin: 10px auto;
    padding: 24px;
}
</style>

<body>
    <div class="container">
        <h1>
            <?php 
            echo "This is the basics of Php<br>";
            $languages = array("Python", "C++", "php", "Nodejs", 25, true);
            // echo $languages[1];
            // echo "<br>";
            // echo count($languages);
            // echo "<br>";
            // echo var_dump($languages);

            $a=0;
            while ($a <= count($languages)-1) {
                # code...
                echo "The value of language is : ";
                echo $languages[$a];
                $a++;
                echo "<br>";
            }

            foreach ($languages as $value) {
                # code...
                echo $value;
                echo "<br>";
            }

            ?>
        </h1>

    </div>
</body>

</html>