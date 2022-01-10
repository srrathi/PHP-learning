<?php
$valid_data = true;
$insert = false;
$update = false;
$delete = false;

// CONNECTION VARIABLES
$serverhost = "localhost";
$username = "root";
$password = "";
$database = "notes_php";

// CONNECTING WITH DATABASE
$con = mysqli_connect($serverhost, $username, $password, $database);

if (!$con) {
  die("Sorry database connection failed : " . mysqli_connect_error());
}

// HANDLING CREATE NOTE REQUEST AND STORING DATA IN DATABASE
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["snoEdit"])) {
  $title = $_POST["title"];
  $description = $_POST["description"];

  if (strlen($title) == 0 and strlen($description) == 0) {
    $valid_data = false;
  } else {
    $sql_query = "INSERT INTO `notes_php`.`notes` (`sno`, `title`, `description`, `timestamp`) VALUES (NULL, ' $title ', ' $description ', current_timestamp());";

    // echo $sql_query;

    // INSERTING VALID DATA TO DB

    if ($con->query($sql_query) == true) {
      $insert = true;
      // echo "Data Inserrted to DB successfully<br>";
    } else {
      // echo "ERROR: ". $sql."<br>". $con->error;
      echo "<br>ERROR:  $sql_query <br> $con->error";
    }
    // $con->close();
  }
}

// UPDATE NOTE
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["snoEdit"])) {
  $editTitle = $_POST["titleEdit"];
  $editDesc = $_POST["descriptionEdit"];
  $sno = $_POST["snoEdit"];
  if (strlen($editTitle) == 0 and strlen($editDesc) == 0) {
    $valid_data = false;
  } else {
    $sql_query = "UPDATE `notes_php`.`notes` SET `title` = '$editTitle', `description` = ' $editDesc' WHERE `notes`.`sno` = '$sno';";
    if ($con->query($sql_query) == true) {
      $update = true;
      // echo "Data Inserrted to DB successfully<br>";
    } else {
      // echo "ERROR: ". $sql."<br>". $con->error;
      echo "<br>ERROR:  $sql_query <br> $con->error";
    }
  }
}

// DELETE NOTE
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
  $sno = $_GET["delete"];

  $sql_query = "DELETE FROM `notes_php`.`notes` WHERE `notes_php`.`notes`.`sno` = '$sno';";
  if ($con->query($sql_query) == true) {
    $delete = true;
    // echo "Data Inserrted to DB successfully<br>";
  } else {
    // echo "ERROR: ". $sql."<br>". $con->error;
    echo "<br>ERROR:  $sql <br> $con->error";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <link rel="stylesheet" crossorigin="anonymous" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
  <title>iNotes PHP - Notes maker</title>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
</head>

<body>

  <!-- EDIT MODAL -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="POST">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" />
            </div>
            <div class="mb-3">
              <label for="desc" class="form-label">Note Description</label>
              <textarea id="descEdit" class="form-control" name="descriptionEdit" aria-label="With textarea"></textarea>
            </div>

            <button type="submit" class="btn btn-dark">Update Note</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">PHP iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- SVGS FOR ALERT -->
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
  </svg>


  <!-- ALERTS FOR DIFFERENT ACTIONS -->
  <div class="container my-4">
    <?php
    if ($insert == true) {
      echo "<div class='alert alert-success d-flex align-items-center alert-dismissible fade show' role='alert'>
            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
            <div>
              Note has been added successfully!
            </div>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    }
    if ($update == true) {
      echo "<div class='alert alert-success d-flex align-items-center alert-dismissible fade show' role='alert'>
            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
            <div>
              Note has been updated successfully!
            </div>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    }
    if ($delete == true) {
      echo "<div class='alert alert-success d-flex align-items-center alert-dismissible fade show' role='alert'>
            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
            <div>
              Note has been deleted successfully!
            </div>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    }
    if ($valid_data == false) {
      echo "<div class='alert alert-danger d-flex align-items-center alert-dismissible fade show' role='alert'>
            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
            <div>
              Please add Title and Description of Note!
            </div>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    }
    ?>

    <!-- NOTE CREATION FORM -->
    <h2>Add a Note</h2>
    <form action="index.php" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" />
      </div>
      <div class="mb-3">
        <label for="desc" class="form-label">Note Description</label>
        <textarea id="desc" class="form-control" name="description" aria-label="With textarea"></textarea>
      </div>

      <button type="submit" class="btn btn-dark">Add Note</button>
    </form>
  </div>


  <!-- ALL NOTES IN DATA TABLE -->
  <div class="container my-4">
    <table id="myTable" class="table">
      <thead>
        <tr>
          <th scope="col">S.NO</th>
          <th scope="col">TITLE</th>
          <th scope="col">DESCRIPTION</th>
          <th scope="col">ACTIONS</th>
        </tr>
      </thead>
      <tbody>

        <!-- LISTING ALL NOTES -->
        <?php
        $sql_query = "SELECT * FROM `notes_php`.`notes`;";
        $result = mysqli_query($con, $sql_query);
        $sno = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          // echo $row["sno"] . ". Title - " . $row["title"] . "<br>Description - " . $row["description"] . "<br>";
          $sno++;
          echo "<tr>
                  <th scope='row'>" . $sno . "</th>
                  <td>" . $row["title"] . "</td>
                  <td>" . $row["description"] . "</td>
                  <td>
                    <button class='btn btn-sm edit btn-secondary' onclick='updateNoteFunction(this," . $row['sno'] . " )'  data-bs-toggle='modal' data-bs-target='#editModal'><i class='far fa-edit'></i></button> 
                    <button class='btn btn-sm btn-danger' onclick='deleteNoteFunction(" . $row['sno'] . " )'><i class='fas fa-trash'></i></button>
                  </td>
                </tr>";
        }
        ?>

      </tbody>
    </table>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  <script>
    // FUNCTION FOR UPDATING NOTE
    const updateNoteFunction = (e, sno) => {
      const tr = e.parentNode.parentNode;
      const titleEdit = tr.getElementsByTagName("td")[0].innerText;
      const descEdit = tr.getElementsByTagName("td")[1].innerText;
      document.getElementById("snoEdit").value = sno;
      document.getElementById("titleEdit").value = titleEdit;
      document.getElementById("descEdit").value = descEdit;
      console.log(sno, titleEdit, descEdit)
    }

    // FUNCTION FOR DELETING NOTE
    const deleteNoteFunction = (sno) => {
      if (confirm("Are you sure you want to delete this Note ?")) {
        window.location = `index.php?delete=${sno}`;
        console.log("Yes")
      } else {
        console.log("No")
      }
    }
  </script>
</body>

</html>