<?php require APPROOT . '/views/inc/header.php';
$employeeWorkingToday = (isset($data['employeeWorkingToday']) && $data['employeeWorkingToday'] != null) ? $data['employeeWorkingToday'] : [];
$totalUsers = (isset($data['totalUsers']) && $data['totalUsers'] != null) ? $data['totalUsers'] : [];
// $departmentName = (isset($data['departmentName']) && $data['departmentName'] != null) ? $data['departmentName'] : [];
// $totalEmployeesDepartment = (isset($data['totalEmployeesDepartment']) && $data['totalEmployeesDepartment'] != null) ? $data['totalEmployeesDepartment'] : [];
$BirthdaysOfTheMonth = (isset($data['BirthdaysOfTheMonth']) && $data['BirthdaysOfTheMonth'] != null) ? $data['BirthdaysOfTheMonth'] : [];
$totalemployeeWorkingToday = (isset($employeeWorkingToday) && $employeeWorkingToday != null) ? count($employeeWorkingToday) : 0;
$num = 1;
?>
<style>
    .scrollCard {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .birthday-card {
        position: relative;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .birthday-person {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .birthday-person img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-right: 15px;
    }

    .birthday-person h6 {
        margin: 0;
    }
    .balloon-image {
        position: absolute;
        top: -11px;
        right: -13px;
        width: 110px;
        height: auto;
        transform: rotate(4deg);

    }
</style>
<div class="container">

    <div class="page-inner">

        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">SurgePays, Inc.</h3>
                <h6 class="op-7 mb-2">San Salvador, El Salvador</h6>
            </div>
            <!-- <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round"> <i class="fa fa-add"></i> Add Employee</a>
            </div> -->
        </div>
        <?php if (cardDashboardInfo()) { ?>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div
                                        class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Active Employee</p>
                                        <h4 class="card-title"><?php echo $data['employeeTotal']; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div
                                        class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-building"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Employees Working Today</p>
                                        <h4 class="card-title"><?php echo $totalemployeeWorkingToday ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div
                                        class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-file"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">AP's Created Today</p>
                                        <h4 class="card-title">0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div
                                        class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Users</p>
                                        <h4 class="card-title"><?php echo $totalUsers; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title">Employees Working Today</div>

                        <div class="card-tools">
                            <a href="#" onclick="downloandTable_CSV()" class="btn btn-label-success btn-round btn-sm me-2"><span class="btn-label"><i class="fa fa-file-excel"></i></span>Export</a>
                            <!-- <a href="#" class="btn btn-label-info btn-round btn-sm"><span class="btn-label">i class="fa fa-print"></i></span>Print</a> -->
                        </div>
                    </div>
                    <div class="card-body scrollCard">
                        <table id="employeeWorkingToday" class="table table-bordered ">
                            <thead>
                                <tr class="dataexp">
                                    <th scope="col">#</th>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">Deparment</th>
                                    <th scope="col">Area</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Clock In</th>
                                    <th scope="col">Clock Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($employeeWorkingToday); $i++) { ?>
                                    <tr class="dataexp">
                                        <th scope="row"><?php echo $num++; ?></th>
                                        <td><?php echo $employeeWorkingToday[$i]['fullName']; ?></td>
                                        <td><?php echo $employeeWorkingToday[$i]['deparmentName']; ?></td>
                                        <td><?php echo $employeeWorkingToday[$i]['areaName']; ?></td>
                                        <td><?php echo $employeeWorkingToday[$i]['positionName']; ?></td>
                                        <td><?php echo $employeeWorkingToday[$i]['clockIn']; ?></td>
                                        <td><?php echo $employeeWorkingToday[$i]['clockOut']; ?></td>
                                    <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <!-- <img src="<?php echo URLROOT ?>/public/assets/img/ballons_1.png" alt="Globos" class="balloon-image"> -->
                        <div class="card-title"><?php echo date("F"); ?> Birthdays <i class="fa fas-"></i></div>
                    </div>
                    <div class="card-body scrollCard" style="min-height: 500px;">
                        <div class="container">
                            <div class="row justify-content-center">

                                <div class="birthday-card">

                                    <?php
                                    if (!empty($BirthdaysOfTheMonth)) {

                                        for ($i = 0; $i < count($BirthdaysOfTheMonth); $i++) {

                                            $photoo = (!empty($BirthdaysOfTheMonth[$i]["photo"])) ? $BirthdaysOfTheMonth[$i]["photo"] : 'userStandar.png';
                                            echo '<div class="birthday-person">
                                        <img src="' . URLROOT . '/public/documents/photo/' . $photoo . '" alt="..." class="avatar-img rounded-circle" />
                                        <div>
                                            <h6>' . $BirthdaysOfTheMonth[$i]["firstName"] . ' ' . $BirthdaysOfTheMonth[$i]["firstLastName"] . '</h6>
                                            <small>' . $BirthdaysOfTheMonth[$i]["formDOB"] . '</small>
                                        </div>
                                    </div>';
                                        }
                                    } else {
                                        echo "No Data";
                                    }

                                    ?>


                                    <!-- <div class="birthday-person">
                                        <img src="https://via.placeholder.com/50" alt="Hester Hogan">
                                        <div>
                                            <h6>Hester Hogan</h6>
                                            <small>32 years</small>
                                        </div>
                                    </div>
                                    <div class="birthday-person">
                                        <img src="https://via.placeholder.com/50" alt="Larry Little">
                                        <div>
                                            <h6>Larry Little</h6>
                                            <small>36 years</small>
                                        </div>
                                    </div> -->
                                    <!-- Puedes agregar más personas de cumpleaños aquí -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Line Chart</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="lineChart" width="739" height="300" style="display: block; width: 739px; height: 300px;" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Bar Chart</div>
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ex dolore asperiores eveniet et magni odit veniam, suscipit at amet temporibus quaerat quo iusto pariatur praesentium. Nulla expedita earum dolore natus.
                    </div>
                </div>
            </div>

        </div> -->


            <?php require APPROOT . '/views/inc/footer.php'; ?>
        </div> <!-- end/page-inner -->
    </div> <!-- end/container2 -->
    <script>
        function downloandTable_CSV(table_id = "employeeWorkingToday", separator = ",") {
            // Select rows from table_id
            var rows = document.querySelectorAll("table#" + table_id + " tr.dataexp"); // Take tr with class "dataexp"
            // Construct csv
            var csv = [];
            //looping through the table
            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");
                //looping through the tr
                for (var j = 0; j < cols.length; j++) {
                    // removing space from the data
                    var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, "").replace(/(\s\s)/gm, " ")
                    // removing double qoute from the data
                    data = data.replace(/"/g, `""`);
                    // Push escaped string
                    row.push(`"` + data + `"`);
                }
                csv.push(row.join(separator));
            }
            var csv_string = csv.join("\n");
            // Download it
            var filename = "export_" + table_id + "_" + new Date().toLocaleDateString() + ".csv";
            var link = document.createElement("a");
            link.style.display = "none";
            link.setAttribute("target", "_blank");
            link.setAttribute("href", "data:text/csv;charset=utf-8," + encodeURIComponent(csv_string));
            link.setAttribute("download", filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }


        // barChartEmployeesDeparment = document.getElementById("barChartEmployeesDeparment").getContext("2d");
        // var myBarChartEmployeesDeparment = new Chart(barChartEmployeesDeparment, {
        //     type: "bar",
        //     data: {
        //         labels: <?php //echo json_encode($departmentName) 
                            ?>,
        //         datasets: [{
        //             axis: 'y',
        //             label: "Deparments",
        //             backgroundColor: "#0674b9",
        //             borderColor: "#0674b9",
        //             data: <?php //echo json_encode($totalEmployeesDepartment) 
                                ?>,
        //         }, ],
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         scales: {
        //             indexAxis: 'y',
        //             // yAxes: [{
        //             //     ticks: {
        //             //         beginAtZero: true,
        //             //     },
        //             // }, ],
        //         },
        //     },
        // });

        // lineChart = document.getElementById("lineChart").getContext("2d");
        // var myLineChart = new Chart(lineChart, {
        //     type: "line",
        //     data: {
        //         labels: [
        //             "Jan",
        //             "Feb",
        //             "Mar",
        //             "Apr",
        //             "May",
        //             "Jun",
        //             "Jul",
        //             "Aug",
        //             "Sep",
        //             "Oct",
        //             "Nov",
        //             "Dec",
        //         ],
        //         datasets: [{
        //             label: "Active Users",
        //             borderColor: "#1d7af3",
        //             pointBorderColor: "#FFF",
        //             pointBackgroundColor: "#1d7af3",
        //             pointBorderWidth: 2,
        //             pointHoverRadius: 4,
        //             pointHoverBorderWidth: 1,
        //             pointRadius: 4,
        //             backgroundColor: "transparent",
        //             fill: true,
        //             borderWidth: 2,
        //             data: [
        //                 542, 480, 430, 550, 530, 453, 380, 434, 568, 610, 700, 900,
        //             ],
        //         }, ],
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         legend: {
        //             position: "bottom",
        //             labels: {
        //                 padding: 10,
        //                 fontColor: "#1d7af3",
        //             },
        //         },
        //         tooltips: {
        //             bodySpacing: 4,
        //             mode: "nearest",
        //             intersect: 0,
        //             position: "nearest",
        //             xPadding: 10,
        //             yPadding: 10,
        //             caretPadding: 10,
        //         },
        //         layout: {
        //             padding: {
        //                 left: 15,
        //                 right: 15,
        //                 top: 15,
        //                 bottom: 15
        //             },
        //         },
        //     },
        // });
    </script>