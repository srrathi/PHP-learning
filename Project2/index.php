<?php
// FLAGS
$insert = false;
$valid_data = true;
if(isset($_POST["name"])){
    // CONNECTION VARIABLES
    $hostname = "localhost";
    $username = "root";
    $password = "";

    // CONNECTING TO DB
    $con = mysqli_connect($hostname, $username, $password);
    if (!$con) {
        die("connection to this database failed due to " . mysqli_connect_error());
    }
    // echo "Success connecting to the DB";

    // POST DATA
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $desc = $_POST['desc'];


    // DATA VALIDATION
    if (strlen($name) !=0 and 
    strlen($gender) != 0 and 
    strlen($age) != 0 and 
    strlen($email) !=0 and 
    strlen($phone) != 0){
        $valid_data = true;
    }
    else{
        $valid_data = false;
    }


    $sql_query = "INSERT INTO `college_trip`.`trip_students_data` (`name`, `age`, `gender`, `email`, `phone`, `other`, `date`) 
    VALUES ('$name', '$age', '$gender', '$email', '$phone', '$desc', current_timestamp())";

    // echo $sql_query;
    
    // INSERTING VALID DATA TO DB
    if($valid_data == true){
        if($con->query($sql_query) == true){
            $insert = true;
        }
        else{
            // echo "ERROR: ". $sql."<br>". $con->error;
            echo "<br>ERROR:  $sql <br> $con->error";
        }
    }
    

    $con->close();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to NIT-H Travel Form</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;600&display=swap"
      rel="stylesheet"
    />
  </head>

  <body>
    <div class="image_container">
      <div class="container">
        <h1>Welcome to NIT Hamirpur</h1>
        <p>
          Please Enter your detials and Submit the form to confirm your
          participation !
        </p>
        <?php 
        if($insert == true){
            // SUCCESS MESSAGE
            echo "<p class='submit_text'>
                    Thanks for Submitting the form. We are happy to see you coming with
                    us.
                </p>";
        }
        else if ($valid_data == false){
            // ERROR MESSAGE
            echo "<p class='error_text'>
                    Mandatory Fields are empty. Please fill them to submit the form.
                </p>";
        }
        ?>
        

        <form action="index.php" method="post">
          <input
            type="text"
            name="name"
            id="name"
            placeholder="Enter your Name"
          />
          <input type="text" name="age" id="age" placeholder="Enter your Age" />
          <input
            type="text"
            name="gender"
            id="gender"
            placeholder="Enter your Gender"
          />
          <input
            type="email"
            name="email"
            id="email"
            placeholder="Enter your Email"
          />
          <input
            type="phone"
            name="phone"
            id="phone"
            placeholder="Enter your Mobile Number"
          />
          <textarea
            name="desc"
            id="desc"
            cols="30"
            rows="10"
            placeholder="Enter any other information here"
          ></textarea>
          <input class="btn" type="submit" value="Submit" />
          <input class="btn" type="button" value="Reset" />
        </form>
      </div>
    </div>
    <script src="index.js"></script>
  </body>
</html>
