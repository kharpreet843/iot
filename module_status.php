<?php
require 'modules/DbConfig.php';
require 'modules/IotModules.php';

$database = new DbConfig();
$db = $database->getConnection();
$obj_module = new IotModules($db);
$modules = $obj_module->getModules();
?>

<html>
<head>
    <title>Module Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
<div class="flex justify-center">
           <p id="error" class="text-white bg-danger p-2 text-center "></p>
       </div>
        <h2 class="text-center mb-4">Iot Module Status</h2>
  
              <a class='btn btn-primary m-2' href="/iotmonitor/registration.php">
          Register Module
            </a>
        <!-- Dynamic Module Button -->
        <?php foreach ($modules as $module) : ?>
        
        <?php endforeach; ?>

        <!-- Status Overview Table -->
        <div class="card shadow-sm mb-4">
         
            <div class="card-body">
                <h5 class="card-title">Module History</h5>
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Module Name</th>
                            <th>Measurement Type</th>
                            <th>Current Measured Value</th>
                            <th>Operating Time</th>
                            <th>No. of Items Sent</th>
                            <th>Status</th>
                                    <th>Generate History</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
if(!empty($modules)){
                        foreach ($modules as $module) : ?>
                            <tr>
                                <td><?= htmlspecialchars($module['module_name']) ?></td>
                                <td><?= htmlspecialchars($module['measurement_type']) ?></td>
                                <td><?= htmlspecialchars($module['measured_value']) ?></td>
                                <td><?= htmlspecialchars($module['operating_time']) ?></td>
                                <td><?= htmlspecialchars($module['no_of_items_sent']) ?></td>
                                <td><span class='badge <?= $module['status'] == 'active' ? 'bg-success' : 'bg-warning' ?>'><?= ucfirst($module['status']) ?></span></td>
                                 <td><button class='btn btn-primary' onclick="generateHistory(<?php echo $module['id'];?>)">Generate Module status</button></td>
                            </tr>
                        <?php endforeach; 
}else{
    echo "<tr><td colspan='5'>No Record Found</td></tr>";
}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Graph Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Evolution of the measured value.</h5>
                <div id="graph-container">
                    <!-- Embed chart here (e.g., using Chart.js or similar library) -->
                    <canvas id="measuredValueChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- JavaScript and Chart.js for graph -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Pass PHP data to JavaScript
            const modules = <?= json_encode($modules) ?>;

            // Extract the time and measured values from PHP data for chart
            const labels = modules.map(module => module.module_name); // Time labels from PHP
            const dataValues = modules.map(module => module.measured_value); // Measured values

            const ctx = document.getElementById('measuredValueChart').getContext('2d');
            const measuredValueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels, // Use dynamic time labels
                    datasets: [{
                        label: 'Measured Value',
                        data: dataValues, // Use dynamic data values
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { title: { display: true, text: 'Time' } },
                        y: { title: { display: true, text: 'Value' } }
                    }
                }
            });

            function generateHistory(moduleId) {
                // Trigger the PHP function to log the history for this module
                fetch('generate_history.php', {
                    method: 'POST',
                    body: JSON.stringify({ module_id: moduleId }),
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('History successfully generated!');
                        setTimeout(function() { location.reload(); }, 1000);
                    } else {
                        alert('Failed to generate history.');
                    }
                });
            }

 // Show notification for faulty module
function showNotification(message, type) {
    const notification = document.getElementById('error');
    //   notification.classList.add('show', type);
    notification.classList.add('toast', type,'show'); // Adds class 'toast' and the notification type (error)
    notification.innerHTML = message;  // Sets the message

  //  document.body.appendChild(notification); // Append notification to body

    // After 3 seconds, remove the notification
    // setTimeout(() => {
    //     notification.remove();
    // }, 3000);
}

// Check each module and show notifications for faulty status
modules.forEach(module => {
    if (module.status === 'faulty') {
        showNotification(`Module ${module.module_name} is faulty!`, 'error');
    }
});

        </script>
    </div>

</body>
</html>
