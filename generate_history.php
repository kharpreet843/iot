<?php
// Include the Database connection and IotModulesHistory class
require_once 'modules/Dbconfig.php';
require_once 'modules/IotModulesHistory.php';

// Create a new Database object
$database = new Dbconfig();
$db = $database->getConnection();

// Function to generate random data
function generateRandomData() {
    $inputData = json_decode(file_get_contents('php://input'), true);
   // Post Module Id
      $module_id = $inputData['module_id']; // Assuming there are 10 modules, change as needed
    
    // (e.g., temperature in °C, speed in km/h, etc.)
    $measured_value = rand(10, 100); // Random range based on data
    $measurement_unit = rand(0, 1) ? '°C' : 'km/h'; // Random unit (temperature or speed)

    // Random status (active, malfunction, etc.)
    $status = rand(0, 1) ? 'active' : 'faulty';
    
    // Random data_items_sent (e.g., number of  items sent)
    $data_items_sent = rand(100, 1000);

    return [$module_id, $measured_value, $status, $data_items_sent, $measurement_unit];
}

// Generate random data
list($module_id, $measured_value, $status, $data_items_sent, $measurement_unit) = generateRandomData();

// Initialize the IotModulesHistory class
$iotModulesHistory = new IotModulesHistory($db);

// Call the storeHistory method to store the generated data
$isStored = $iotModulesHistory->storeHistory($module_id, $measured_value, $status, $data_items_sent, $measurement_unit);

// Return response based on success or failure
if ($isStored) {
    echo json_encode(['success' => true, 'message' => 'History generated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to generate history']);
}
?>
