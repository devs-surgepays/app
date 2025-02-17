<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"></div>
        <div class="row">
            <?php echo breadcrumbs('Reports') ?>
            <div class="col-12">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <h3 class="mb-3">Employees</h3>
                            <?php if (getPLAnotherBillTo()) { ?>
                                <div class="col-4">
                                    <select class="form-select form-select-sm searchDataChange" id="employee_billTo" name="employee_billTo">
                                        <option selected value="1">SURGEPAYS</option>
                                        <option value="2">ELITE</option>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="col-4">
                                <select class="form-select" aria-label="Default select example" required id="employee_status">
                                    <option selected disabled>Select Status</option>
                                    <option value="2">All</option>
                                    <?php echo getPLShowInactiveEmployee() ? '<option value="1">Active</option> <option value="0">Inactive</option>' : ''; ?>
                                </select>
                                <small class="required_field" id="status_error" hidden>*status is required</small>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-info btn-sm" id="download_employees">Download</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <h3 class="mb-3">APs</h3>
                            <div class="row mb-3">
                            <div class="col-12">
                                <span class="required_field" hidden id="no_data">Sorry, we couldn't find any data matching your search.</span>
                            </div>
                        </div>
                            <div class="col-4">
                                <select class="form-select" aria-label="Default select example" id="ap_type">
                                    <option disabled selected>Select type</option>
                                    <option value="-1">All</option>
                                    <?php foreach ($data["apTypes"] as $type): ?>
                                        <option value="<?php echo $type["apTypeId"]; ?>"><?php echo $type["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="required_field" id="type_error" hidden>*type is required</small>
                            </div>
                            <div class="col-4">
                                <select class="form-select" aria-label="Default select example" id="ap_approval_option">
                                    <option disabled selected>Select approval option</option>
                                    <option value="-1">All</option>
                                    <option value="00">Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                    <option value="3">Cancelled</option>
                                </select>
                                <small class="required_field" id="approval_error" hidden>*approval option is required</small>
                            </div>
                            <div class="col-4">
                                <input type="text" name="daterange" id="date_range"/>
                                <br/>
                                <small class="required_field" id="date_error" hidden>*date required</small>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <button class="btn btn-info btn-sm" id="download_aps">Download</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require APPROOT . '/views/inc/footer.php'; ?>
    </div> <!-- end/page-inner -->
</div> <!-- end/container2 -->



<style>
    #date_range {
        padding: 5px 10px 5px 10px;
        border-radius: 5px;
        border: var(--bs-border-width) solid var(--bs-border-color);
    }

    .required_field {
        color: red;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {

        $("#download_employees").click(() => {

            if ($("#employee_status").val() == "" || $("#employee_status").val() == null) {

                $("#status_error").attr("hidden", false);
                return;

            } else {

                try {

                    $("#status_error").attr("hidden", true);
                    let frm = new FormData();
                    frm.append("employee_status", $("#employee_status").val());
                    frm.append("employee_billTo", $("#employee_billTo").val());
                    fetch('<?php echo URLROOT; ?>/reports/exportEmployeesByStatus', {
                            method: "POST",
                            body: frm
                        })
                        .then((response) => response.json())
                        .then((data) => {

                            console.log($("#employee_status").val())
                            console.log(data);
                            const now = new Date();
                            const year = now.getFullYear();
                            const month = String(now.getMonth() + 1).padStart(2, '0');
                            const day = String(now.getDate()).padStart(2, '0');
                            const dateStr = `${year}-${month}-${day}`;

                            let targetHeaders = ["BADGE", "EDAD", "FECHA DE INGRESO SURGEPAYS", "FECHA DE CONTRATACION", "FECHA DE NACIMIENTO", "FECHA DE EXPEDICION DUI", "FECHA DE EXPIRACION DUI", "SALARIO"]; // Add any headers you want to format here, including the date column

                            // Create a worksheet from the data
                            let ws = XLSX.utils.json_to_sheet(data);

                            // Find the header row and get column index dynamically based on the header name
                            let headers = ws['!rows'] ? ws['!rows'][0] : Object.keys(data[0]); // Get the headers (first row)

                            // Loop through the target headers
                            targetHeaders.forEach(targetHeader => {
                                // Find the column index of the header
                                let targetColumnIndex = -1;
                                let columnLetter = '';

                                // Loop over headers to find the index
                                for (let i = 0; i < headers.length; i++) {
                                    if (headers[i] === targetHeader) {
                                        targetColumnIndex = i;
                                        columnLetter = XLSX.utils.encode_col(targetColumnIndex); // Get the column letter (e.g., "A", "B")
                                        break;
                                    }
                                }

                                // If the target column is found, apply formatting
                                if (targetColumnIndex !== -1) {
                                    // Apply specific formatting based on column name
                                    for (let row = 0; row < data.length; row++) {
                                        let cellAddress = `${columnLetter}${row + 2}`; // Adjust row index to account for header row
                                        let cell = ws[cellAddress];

                                        if (cell) {
                                            // if (targetHeader === "FECHA DE INGRESO SURGEPAYS" || targetHeader === "FECHA DE CONTRATACION" || targetHeader === "FECHA DE NACIMIENTO" || targetHeader === "FECHA DE EXPEDICION DUI" || targetHeader === "FECHA DE EXPIRACION DUI") {
                                            //     // If it's the date column, apply date formatting
                                            //     cell.t = 'd'; // Set the type to 'd' (date)
                                            //     cell.z = 'dd/mm/yyyy'; // Example date format: yyyy-mm-dd
                                            // } else 
                                            if (targetHeader === "SALARIO") {
                                                // Apply formatting for other columns like BADGE or EDAD
                                                cell.t = 'n'; // Set the type to 'n' (number)
                                                cell.z = '_($* #,##0.00_);_($* (#,##0.00);_($* "-"??_);_(@_)';  // Apply number format: plain number with no commas or decimals
                                            } else if (targetHeader === "BADGE" || targetHeader === "EDAD") {
                                                // Apply formatting for other columns like BADGE or EDAD
                                                cell.t = 'n'; // Set the type to 'n' (number)
                                                cell.z = '0';  // Apply number format: plain number with no commas or decimals
                                            }
                                        }
                                    }
                                }
                            });

                            let wb = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                            XLSX.writeFile(wb, 'employees_' + dateStr + '.xlsx');
                        });

                } catch (error) {
                    console.error('Error fetching or exporting data:', error);
                }

            }
        });

        $("#download_aps").click(() => {

            if ($("#ap_type").val() == "" || $("#ap_type").val() == null || $("#ap_approval_option").val() == "" || $("#ap_approval_option").val() == null || $("#date_range").val() == "" || $("#date_range").val() == null) {
                $("#ap_type").val() == "" || $("#ap_type").val() == null ? $("#type_error").attr("hidden", false) : $("#type_error").attr("hidden", true);
                $("#ap_approval_option").val() == "" || $("#ap_approval_option").val() == null ? $("#approval_error").attr("hidden", false) : $("#approval_error").attr("hidden", true);
                $("#date_range").val() == "" || $("#date_range").val() == null ? $("#date_error").attr("hidden", false) : $("#date_error").attr("hidden", true);

                return;
            } else {
                $("#type_error").attr("hidden", true);
                $("#approval_error").attr("hidden", true);
                $("#date_error").attr("hidden", true);

                exportApsByFilters();
            }
        });

    });

    function exportApsByFilters() {
        try {
 
            $("#type_error").attr("hidden", true);
            $("#approval_error").attr("hidden", true);
            $("#date_error").attr("hidden", true);

            let frm = new FormData();
            frm.append("ap_type", $("#ap_type").val());
            frm.append("ap_approval_option", $("#ap_approval_option").val());
            frm.append("date_range", $("#date_range").val());

            fetch('<?php echo URLROOT; ?>/reports/exportApsByFilters', {
                    method: "POST",
                    body: frm
                })
                .then((response) => response.json())
                .then((data) => {

                    if(data.length <= 0) {
                        $("#no_data").attr("hidden", false);
                        return;
                    } else {
                        $("#no_data").attr("hidden", true);
                    }
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const dateStr = `${year}-${month}-${day}`;

                    let targetHeaders = ["BADGE", "Agente", "Tipo de AP", "Procesada por", "Fecha inicio", "Fecha fin", "Comentarios", "Aprobado por HR", "Supervisor"]; // Add any headers you want to format here, including the date column

                    let ws = XLSX.utils.json_to_sheet(data);

                    let headers = ws['!rows'] ? ws['!rows'][0] : Object.keys(data[0]); // Get the headers (first row)

                    targetHeaders.forEach(targetHeader => {
                        let targetColumnIndex = -1;
                        let columnLetter = '';

                        for (let i = 0; i < headers.length; i++) {
                            if (headers[i] === targetHeader) {
                                targetColumnIndex = i;
                                columnLetter = XLSX.utils.encode_col(targetColumnIndex); // Get the column letter (e.g., "A", "B")
                                break;
                            }
                        }
                    });

                    let wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                    XLSX.writeFile(wb, 'aps_' + dateStr + '.xlsx');
                });

        } catch (error) {
            console.error('Error fetching or exporting data:', error);
        }
    }

    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            locale: {
                format: 'YYYY/MM/DD'
            }
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>