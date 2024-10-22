<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
require_once("config.php");
// Handle form submission
$id = $_COOKIE['arghona'];
$sql = "SELECT salary.id,salary.amount, salary.date, employe.name, employe.type 
       FROM salary 
       INNER JOIN employe ON salary.employe_id = employe.id";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
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
    <link rel="stylesheet" href="css/student.css" />
    <title>Salary Management</title>
    <script src="package/bootstrap.min.js" defer></script>
    <script src="script.js" defer></script>
    <style>
        /* Add scrollable container for table */
        .table-container {
            max-height: 400px;
            /* Adjust this height as needed */
            overflow-y: auto;
        }
    </style>
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
    <main class="d-flex justify-content-center align-item-center">
        <div class="container w-80 shadow-lg rounded-3 py-4 px-2 my-5">
            <div class="title">
                <h4>Salary Management</h4>
            </div>

            <!-- Scrollable table container -->
            <div class="table-container">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["amount"] . "</td>";
                                echo "<td>" . $row["date"] . "</td>";
                                echo "<td>
                                        <a href='UpdateSalary.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'><span class='fa fa-edit'></span></a>
                                        <a href='deleteSalary.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'><span class='fa fa-trash'></span></a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>

</html>