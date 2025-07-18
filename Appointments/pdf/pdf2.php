<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Person Report</title>

    <style>
    .heading-box {
    display: inline-block;
    padding: 10px 20px;
    border: 5px solid transparent;
    border-radius: 8px;
    background-color: #F2F0EF;
    position: relative;
    overflow: hidden;
    animation: borderFadeIn 0.8s forwards;
    transition: box-shadow 0.3s ease;
    }

    /* Animate border "drawing" effect */
    @keyframes borderFadeIn {
    0% {
        border-color: transparent;
        transform: scale(0.96);
        opacity: 0;
    }
    100% {
        border-color: #E31C79;
        transform: scale(1);
        opacity: 1;
    }
    }

    .heading-box h5 {
    margin: 0;
    font-weight: bold;
    color: #333;
    z-index: 2;
    position: relative;
    }

    /* Hover glow effect */
    .heading-box:hover {
    box-shadow: 0 0 12px rgba(54, 162, 235, 0.4);
    cursor: pointer;
    }
    </style>
</head>

<body>
    <?php
$servername = "localhost";
$username = "root"; // or your actual username
$password = "";     // or your actual password
$dbname = "resourcepersonsystem"; // replace with your real DB name

$conn = mysqli_connect($servername, $username, $password, $dbname);

// === LECTURERS by status ===
$lect_status = ['Active' => 0, 'Inactive' => 0, 'On Leave' => 0];
$lect_sql = "SELECT status, COUNT(*) AS total FROM lecturers GROUP BY status";
$lect_res = mysqli_query($conn, $lect_sql);
while ($row = mysqli_fetch_assoc($lect_res)) {
    switch ($row['status']) {
        case 1: $lect_status['Active'] = $row['total']; break;
        case 2: $lect_status['Inactive'] = $row['total']; break;
        case 3: $lect_status['On Leave'] = $row['total']; break;
    }
}

$lect_data = [
    'type' => 'bar',
    'data' => [
        'labels' => array_keys($lect_status),
        'datasets' => [[
            'label' => 'Number of Lecturers',
            'data' => array_values($lect_status),
            'backgroundColor' => ['#4bc0c0', '#ff6384', '#ffce56']
        ]]
    ]
];

$lect_chart_url = 'https://quickchart.io/chart?c=' . urlencode(json_encode($lect_data));


// === APPOINTMENTS by approval_status ===
$app_status = ['Pending' => 0, 'Approved' => 0, 'Rejected' => 0];
$app_sql = "SELECT approval_status, COUNT(*) AS total FROM appointments GROUP BY approval_status";
$app_res = mysqli_query($conn, $app_sql);
while ($row = mysqli_fetch_assoc($app_res)) {
    switch ($row['approval_status']) {
        case 0: $app_status['Pending'] = $row['total']; break;
        case 1: $app_status['Approved'] = $row['total']; break;
        case 2: $app_status['Rejected'] = $row['total']; break;
    }
}

$app_data = [
    'type' => 'pie',
    'data' => [
        'labels' => array_keys($app_status),
        'datasets' => [[
            'data' => array_values($app_status),
            'backgroundColor' => ['#36a2eb', '#ff6384', '#ffce56']
        ]]
    ]
];
$app_chart_url = 'https://quickchart.io/chart?c=' . urlencode(json_encode($app_data));


// === SUBJECTS by credit_hour ===
$subj_credit = [];
$subj_sql = "SELECT credit_hour, COUNT(*) AS total FROM subjects GROUP BY credit_hour";
$subj_res = mysqli_query($conn, $subj_sql);
while ($row = mysqli_fetch_assoc($subj_res)) {
    $subj_credit[$row['credit_hour']] = $row['total'];
}

$subj_data = [
    'type' => 'bar',
    'data' => [
        'labels' => array_keys($subj_credit),
        'datasets' => [[
            'label' => 'Subjects Count',
            'data' => array_values($subj_credit),
            'backgroundColor' => ['#ffcd56', '#ff6384', '#4bc0c0', '#9966ff']
        ]]
    ],
    'options' => [
        'indexAxis' => 'y'
    ]
];
$subj_chart_url = 'https://quickchart.io/chart?c=' . urlencode(json_encode($subj_data));


// === SEMESTERS by code ===
$sem_code = [];
$sem_sql = "SELECT code, COUNT(*) AS total FROM semesters GROUP BY code";
$sem_res = mysqli_query($conn, $sem_sql);
while ($row = mysqli_fetch_assoc($sem_res)) {
    $sem_code[$row['code']] = $row['total'];
}

$sem_data = [
    'type' => 'doughnut',
    'data' => [
        'labels' => array_keys($sem_code),
        'datasets' => [[
            'data' => array_values($sem_code),
            'backgroundColor' => ['#36a2eb', '#ff6384', '#ffce56', '#4bc0c0', '#9966ff']
        ]]
    ]
];
$sem_chart_url = 'https://quickchart.io/chart?c=' . urlencode(json_encode($sem_data));

?>

<div class="col-md-12">
    <h3 class="fs-2 fw-bold text-center">REPORTING ABOUT RESOURCE PERSON SYSTEM</h3>
                <div class="tricolor_line mb-3"></div>

                <!-- lecturer graph -->
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <h4>Lecturer Status</h4>
                                <table border="1" width="50%" cellspacing="0" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($lect_status as $status => $total): ?>
                                            <tr>
                                                <td><?= h($status) ?></td>
                                                <td><?= h($total) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <img src="<?= $lect_chart_url ?>" alt="Lecturer Chart" style="width: 100%; max-width: 500px;">
                            </div>
                        </div>
                    </div>
                </div>

                <br><br><br><br><br><br><br><br><br><br><br>
                <!-- semester graph -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <h4>Semester Code</h4>
                                <table border="1" width="50%" cellspacing="0" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($sem_code as $code => $total): ?>
                                            <tr>
                                                <td><?= $code ?></td>
                                                <td><?= $total ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <img src="<?= $sem_chart_url ?>" alt="Semester Chart" style="width: 100%; max-width: 500px;">
                            </div>
                        </div>
                    </div>
                </div>

                <br><br><br><br><br><br><br><br><br><br><br>
                <!-- subject graph -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <h4>Subjects Credit Hour</h4>
                                <table border="1" width="50%" cellspacing="0" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th>Creadit Hour</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($subj_credit as $hour => $total): ?>
                                            <tr>
                                                <td><?= $hour ?></td>
                                                <td><?= $total ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <img src="<?= $subj_chart_url ?>" alt="Subject Chart" style="width: 100%; max-width: 500px;">
                            </div>
                        </div>
                    </div>
                </div>

                <br><br><br><br><br><br><br><br><br><br><br>
                <!-- appointment graph -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <h4>Appointment Approval Status</h4>
                                <table border="1" width="50%" cellspacing="0" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th>Approval Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($app_status as $status => $total): ?>
                                            <tr>
                                                <td><?= $status ?></td>
                                                <td><?= $total ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <img src="<?= $app_chart_url ?>" alt="Appointment Chart" style="width: 100%; max-width: 500px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('lectChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_keys($lect_status)) ?>,
        datasets: [{
            label: '# of Lecturers',
            data: <?= json_encode(array_values($lect_status)) ?>,
            backgroundColor: ['#4bc0c0', '#ff6384', '#ffce56']
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

new Chart(document.getElementById('appChart'), {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_keys($app_status)) ?>,
        datasets: [{
            data: <?= json_encode(array_values($app_status)) ?>,
            backgroundColor: ['#4bc0c0', '#ff6384', '#ffce56']
        }]
    }
});

new Chart(document.getElementById('subjChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_keys($subj_credit)) ?>,
        datasets: [{
            label: '# of Subjects',
            data: <?= json_encode(array_values($subj_credit)) ?>,
            backgroundColor: ['#ffc107', '#dc3545', '#4bc0c0','#9966ff']
        }]
    },
    options: {
        responsive: true,
        indexAxis: 'y',
        scales: { x: { beginAtZero: true } }
    }
});

new Chart(document.getElementById('semChart'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_keys($sem_code)) ?>,
        datasets: [{
            data: <?= json_encode(array_values($sem_code)) ?>,
            backgroundColor: ['#36a2eb', '#ff6384', '#ffce56', '#4bc0c0','#9966ff']
        }]
    }
});
</script>
</body>
</html>