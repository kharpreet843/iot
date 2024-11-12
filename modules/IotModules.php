<?php
// classes/IotModules.php
require_once 'DbConfig.php';

class IotModules {
    private $conn;
    private $table_name = "iot_modules";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($name, $type, $final_measured_value) {
        // Start a transaction to ensure both inserts happen together
        $this->conn->begin_transaction();

        try {
            // Insert into iot_modules table
            $query = "INSERT INTO " . $this->table_name . " (module_name, measurement_type, status, final_measured_value, created_date) 
                      VALUES (?, ?, 'active', ?, NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sss", $name, $type, $final_measured_value);  // Ensure binding is correct (string, string, float)
            $stmt->execute();

            $module_id = $this->conn->insert_id;  // Get the newly inserted module ID

            // Set measurement unit based on type
            $measurement_unit = ($type == "temperature") ? '°C' : 'km/h';

            // Insert into iot_modules_history table
            $historyQuery = "INSERT INTO iot_modules_history (module_id, measured_value, status, no_of_items_sent, operating_time, measurement_unit)
                             VALUES (?, ?, 'active', 0, 5, ?)";
            $historyStmt = $this->conn->prepare($historyQuery);
            $historyStmt->bind_param("ids", $module_id, $final_measured_value, $measurement_unit);  // Correct binding (int, float, string)
            $historyStmt->execute();

            // Commit the transaction
            $this->conn->commit();

            // Close statements
            $stmt->close();
            $historyStmt->close();

            return true;

        } catch (Exception $e) {
            // Rollback in case of error and log the error for debugging
            $this->conn->rollback();
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function getModules() {
        $query = "
            SELECT 
              iot_modules.id, 
                iot_modules.module_name, 
                iot_modules.measurement_type, 
                iot_modules_history.measured_value, 
                iot_modules_history.status, 
                iot_modules_history.no_of_items_sent, 
                iot_modules_history.operating_time, 
                iot_modules_history.measurement_unit
            FROM 
                iot_modules 
            JOIN 
                iot_modules_history 
                ON iot_modules.id = iot_modules_history.module_id;
        ";

        $result = $this->conn->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
?>
