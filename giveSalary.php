<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
    exit();
}

require_once('config.php');
$not_valide = false;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check posted values

    if (
        isset($_POST['amount']) && !empty($_POST['amount']) &&
        isset($_POST['date']) && !empty($_POST['date']) &&
        is_numeric($_POST['amount'])
    ) {
        $amount = $_POST['amount'];

        // Validate and format the date
        $date = $_POST['date'];
        $dateTimestamp = strtotime($date);
        if ($dateTimestamp === false) {
            $not_valide = true;
            exit();
        }
        $date = date('Y-m-d', $dateTimestamp);

        var_dump($amount, $date, $id); // Debugging values before insert

        $stmt = $conn->prepare("INSERT INTO salary (amount, date, employe_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $amount, $date, $id); // Note: "ssi" if amount is string, date is string, id is integer

        if ($stmt->execute()) {
            header('Location: salary.php');
            exit();
        } else {
            $not_valide = true;
        }

        $stmt->close();
        $conn->close();
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
    <link rel="stylesheet" href="style.css" />
    <title>Pay Salary</title>
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
                            <a class="nav-link" id="about-link" href="student.php">Student</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="services-link" href="employe.php">Employee</a>
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
    <div class="container w-50 shadow-lg rounded-3 py-4 px-2 my-5 ">
        <h4>Pay Salary</h4>
        <form method="post" enctype="multipart/form-data">
            <h5 style='color:red'>
                <?php if ($not_valide == true) {
                    echo "Note Validate data";
                } ?>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="text" class="form-control" id="amount" name="amount" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <button type="submit" class="btn btn-primary">pay</button>
        </form>
    </div>
</body>

</html>