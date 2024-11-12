<?php
// classes/ModuleStatusGeneration.php
require_once 'DbConfig.php';
require_once 'IotModuleshistory.php';

class ModuleStatusGeneration {
    private $conn;
    private $iot_history;

    public function __construct($db) {
        $this->conn = $db;
        $this->iot_history = new IotModuleshistory($db);
    }

    public function simulate($module_id) {
        $statusOptions = ['active', 'faulty', 'inactive'];
        $shuffle=shuffle($statusOptions);
        $status = $shuffle[0];
        $measuredValue = rand(20, 100); // Random example value

        // Update module's last measured value and status in the database
        $query = "UPDATE modules SET status = ?, last_measured_value = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sdi", $status, $measuredValue, $module_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Record the module's operational iot_history
        $this->iot_history->record($module_id, $measuredValue, $status);
    }
}
?>
