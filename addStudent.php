<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
// Create connection
require_once('config.php');
$not_valide = false;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['lastname']) && !empty($_POST['lastname']) && isset($_POST['father_name']) && !empty($_POST['father_name']) && isset($_POST['phone']) && !empty($_POST['phone'])) {

    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $father_name = $_POST['father_name'];
    $photo = $_FILES['photo']['name'];
    $phone = $_POST['phone'];


    // Move uploaded file to the desired location
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $done = move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
    if (!$done) {
        $not_valide = true;
    }

    // Prepare and execute the SQL query
    if ((is_string($name) && !is_numeric($name)) && (is_string($lastname) && !is_numeric($lastname)) && (is_numeric($phone))) {

        $stmt = $conn->prepare("INSERT INTO student (name, lastname, father_name, photo, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $lastname, $father_name, $photo, $phone);

        if ($stmt->execute()) {
            header('Location:student.php');
        } else {
            $not_valide = true;
        }
    } else {
        $not_valide = true;
    }


}
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
    <link rel="stylesheet" href="fontawasome/css/all.css">
    <title>New Student</title>
    <script src="package/bootstrap.min.js" defer></script>
    <script src="script.js" defer></script>
</head>

<body class="bg-gray">
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
                            <a class="nav-link active" id="about-link" href="student.php">Student</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-link" href="employe.php">Employe</a>
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
    <main class="d-flex  justify-content-center align-item-center">
        <div class="container w-50 shadow-lg rounded-3 py-4 px-4 my-5">
            <h4>Insert Student</h4>
            <form method="post" enctype="multipart/form-data">
                <h5 style='color:red'>
                    <?php if ($not_valide == true) {
                        echo "Note Validate data";
                    } ?>
                </h5>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                </div>
                <div class="mb-3">
                    <label for="father_name" class="form-label">Father Name</label>
                    <input type="text" class="form-control" id="father_name" name="father_name" required>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>

                <button type="submit" class="btn btn-primary">Insert</button>
            </form>
        </div>
    </main>
</body>

</html>