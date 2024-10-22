<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
require_once("config.php");
// Get the Employee ID from the URL
$id = $_GET['id'];
$not_valide = false;
if (
    isset($_POST['amount']) && !empty($_POST['amount']) && isset($_POST['date']) && !empty($_POST['date'])
) {
    $amount = $_POST['amount'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    if (is_numeric($amount)) {

        $stmt = $conn->prepare("update salary set amount=?, date=? where id=?");
        $stmt->bind_param("sdi", $amount, $date, $id);

        if ($stmt->execute()) {
            header('Location:salary.php');
        } else {
            $not_valide = true;
        }
    } else {
        $not_valide = true;
    }


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
    <!-- HTML form to update the student data -->
    <div class="container w-50 shadow-lg rounded-3 py-4 px-2 my-5 ">
        <h4>Update Salary</h4>
        <form method="post" enctype="multipart/form-data">
            <h5 style='color:red'>
                <?php if ($not_valide == true) {
                    echo "Note Validate data";
                } ?>
            </h5>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" required
                    value="<?php echo $row['amount']; ?>">
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required
                    value="<?php echo $row['date']; ?>">
            </div>




            <button type="submit" class="btn btn-primary">pay</button>
        </form>
    </div>

</body>

</html>