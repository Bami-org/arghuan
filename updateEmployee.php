<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
require_once("config.php");
// Get the Employee ID from the URL
$id = $_GET['id'];
$not_valide = false;
if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['lastName']) && !empty($_POST['lastName']) && isset($_POST['fatherName']) && !empty($_POST['fatherName']) && isset($_POST['phone']) && !empty($_POST['phone']) && isset($_POST['type']) && !empty($_POST['type'])) {

    $name = $_POST['name'];
    $lastname = $_POST['lastName'];
    $father_name = $_POST['fatherName'];
    $photo = $_FILES['photo']['name'];
    $phone = $_POST['phone'];
    $type = $_POST['type'];
    echo $type;

    // Move uploaded file to the desired location
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $done = move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
    if (!$done) {
        $not_valide = true;
    }

    // Prepare and execute the SQL query
    if ((is_string($name) && !is_numeric($name)) && (is_string($lastname) && !is_numeric($lastname)) && (is_numeric($phone))) {

        $stmt = $conn->prepare("update employe set name=? , lastName=?, fatherName=?, photo=?, phone=?, type=? where id=?");
        $stmt->bind_param("ssssssd", $name, $lastname, $father_name, $photo, $phone, $type, $id);

        if ($stmt->execute()) {
            header('Location:employe.php');
        } else {
            $not_valide = true;
        }
    } else {
        $not_valide = true;
    }

}
// Fetch the student data using the $id
$sql = "SELECT * FROM employe WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('d', $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows != 1) {
    die("Error");

}
$row = $result->fetch_assoc();


// Display the pre-filled form with the student data
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta lang="en" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="package/all.css" />
    <link rel="stylesheet" href="package/fontawesome.min.css" />
    <link rel="stylesheet" href="package/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Update Employee</title>
    <script src="package/bootstrap.min.js" defer></script>
    <script src="script.js" defer></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Arghuan</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" id="home-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="about-link" href="student.php">Student</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="services-link" href="employe.php">Employe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-link" href="salary.php">Salary</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-link" href="course.php">Course</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-link" href="score.php">Score</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" id="services-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- HTML form to update the student data -->
    <main class="d-flex  justify-content-center align-item-center">
        <div class="container w-50 shadow-lg rounded-3 py-4 px-4 my-5">
            <h4>Update Employee</h4>
            <form method="POST" enctype="multipart/form-data">
                <h5 style='color:red'>
                    <?php if ($not_valide == true) {
                        echo "Note Validate data";
                    } ?>
                </h5>
                <div class="form-group px-4 py-4">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control " id="name" name="name" value="<?php echo $row['name']; ?>">
                </div>
                <div class="form-group px-4 py-2">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastName"
                        value="<?php echo $row['lastName']; ?>">
                </div>
                <div class="form-group px-4 py-2">
                    <label for="father_name">Father Name:</label>
                    <input type="text" class="form-control" id="father_name" name="fatherName"
                        value="<?php echo $row['fatherName']; ?>">
                </div>
                <div class="form-group px-4 py-2">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="<?php echo $row['phone']; ?>">
                </div>
                <div class="form-group px-4 py-2">
                    <select name="type" class="form-select rounded-3">
                        <option value="teacher">Teacher</option>
                        <option value="manager">Manager</option>
                        <option value="other">Employee</option>
                    </select>

                </div>
                <div class="form-group px-4 py-2">
                    <label for="photo">Photo:</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                    <img src="uploads/<?php echo $row['photo']; ?>" width="50" height="50" alt="Current Photo"
                        style="padding-top:5px">
                </div>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn btn-primary mx-4">Update</button>
            </form>
        </div>
    </main>

</body>

</html>