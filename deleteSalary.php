<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
require_once("config.php");
// Get the Employee ID from the URL
$id = $_GET['id'];

if (isset($_POST['submit']) && !empty($_POST['submit'])) {
    // Prepare and execute the SQL query
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM salary WHERE id = ?");
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
    } else {
        $stmt->bind_param("d", $id);
        if ($stmt->execute()) {
            header('Location:salary.php');
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
// Fetch the student data using the $id
$sql = "SELECT * FROM salary WHERE id = ?";
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
    <title>Delete Salary</title>
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
                            <a class="nav-link" id="contact-link" href="employe.php">Employe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="contact-link" href="salary.php">Salary</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="services-link" href="course.php">Course</a>
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
    <div class="container w-50 shadow-lg rounded-3 py-4 px-2 my-5 ">
        <h4>Delete Salary</h4>
        <div class="py-4 px-4">
            <h5>Salary Amount</h5>
            <p><?php echo $row['amount']; ?></p>
        </div>
        <div class="py-4 px-4">
            <h5>Salary Date</h5>
            <p><?php echo $row['date']; ?></p>
        </div>
        <div class="py-4 px-4">
            <form method="post">
                <input type="hidden" name="id" value=<?php echo $id; ?>>
                <button type="submit" name="submit" value="s" class='btn btn-danger btn-sm'>Delete</button>
            </form>
        </div>

</body>

</html>