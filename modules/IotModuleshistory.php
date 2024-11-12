<?php
// classes/IotModuleshistory.php
require_once 'DbConfig.php';

class IotModulesHistory {
    private $conn;
    private $table_name = 'iot_modules_history';

    public function __construct($db) {
        $this->conn = $db;
    }

 public function storeHistory($module_id, $measured_value, $status, $no_of_items_sent, $measurement_unit) {
    // SQL query to insert data
    $query = "INSERT INTO " . $this->table_name . " (module_id, measured_value, status, no_of_items_sent, measurement_unit) 
              VALUES (?, ?, ?, ?, ?)";

    // Debugging: Print the query and the parameters
  //  echo "Query: " . $query . "<br>";
  //  echo "Parameters: " . $module_id . ", " . $measured_value . ", " . $status . ", " . $no_of_items_sent . ", " . $measurement_unit . "<br>";

    // Prepare the statement
    $stmt = $this->conn->prepare($query);

    // Check for any errors while preparing the query
    if (!$stmt) {
        die('Error preparing query: ' . $this->conn->error);
    }

    // Bind parameters
    $stmt->bind_param("idsis", $module_id, $measured_value, $status, $no_of_items_sent, $measurement_unit);

    // Execute the query
    if ($stmt->execute()) {
        return true;
    } else {
        die('Error executing query: ' . $stmt->error);
    }

    // Close the statement
    //$stmt->close();
}


}

?>
