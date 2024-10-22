<?php
if (!isset($_COOKIE['arghona'])) {
    header("Location: login.php");
}
require_once("config.php");
// Handle form submission
$sql = "select *from employe";
$stmt = $conn->prepare($sql);
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
    <link rel="stylesheet" href="css/student.css">
    <title>Management Employee</title>
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
    <main class="d-flex  justify-content-center align-item-center">
        <div class="container w-80 shadow-lg rounded-3 py-4 px-4 my-5 ">
            <div class="title">
                <h4>Employee Management</h4>
                <a href="addEmploye.php" class='btn btn-primary btn-md my-2 mx-2'><span class="fa fa-plus"></span></a>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>L/Name</th>
                        <th>F/Name</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Photo</th>
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
                            echo "<td>" . $row["lastName"] . "</td>";
                            echo "<td>" . $row["fatherName"] . "</td>";
                            echo "<td>" . $row["phone"] . "</td>";
                            echo "<td>" . $row["type"] . "</td>";

                            echo "<td><img src='uploads/" . $row["photo"] . "' width='50' height='50'></td>";
                            echo "<td class='icons'>
                                    <a href='updateEmployee.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'><span class='fa fa-edit'></span></a>
                                    <a href='deleteEmployee.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'><span class='fa fa-trash'></span></a>
                                    <a href='giveSalary.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'><span class='fa fa-credit-card'></span></a>

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
    </main>
    <footer class="bg-dark text-white py-3">
        <div class="container">
            <p class="mb-0">&copy; 2023 Your Site. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>