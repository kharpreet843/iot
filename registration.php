<?php
require 'modules/DbConfig.php';
require 'modules/IotModules.php';

$database = new DbConfig();
$db = $database->getConnection();
$obj_module = new IotModules($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $type = $_POST['measurement_type'];
       // $final_measured_value = $_POST['final_measured_value'];
   
      $final_measured_value = rand(20, 80); // Random initial value

    if ( $obj_module->create($name, $type,$final_measured_value)) {
        echo "Module registered successfully!";
    } else {
        echo "Error registering module.";
    }
    header("Location: module_status.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register New Module</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Register New Module</h2>
            <form method="POST" action="registration.php">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                   <div class="mb-3">
                    <label for="name" class="form-label">Measured Value:</label>
                    <input type="text" class="form-control" id="final_measured_value" name="final_measured_value" required>
                </div>
                
                <div class="mb-3">
                    <label for="measurement_type" class="form-label">Measurement Type:</label>

                    <select class="form-control" name="measurement_type">

                    <option value="temperature">Temperature</option>
                      <option value="speed">Speed</option>
                  </select>
                    <!-- <input type="text" class="form-control" id="measurement_type" name="measurement_type" required> -->
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

