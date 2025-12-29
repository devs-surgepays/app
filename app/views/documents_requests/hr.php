<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
  <div class="page-inner">

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
              <h4 class="card-title">HR Documents Requests</h4>
              <!-- refresh icon -->
              <button class="btn btn-round ml-auto" onclick="resetDateFilter()">
                <i class="fa fa-sync"></i>
                Refresh
              </button>
            </div>
          </div>
          <div class="card-body">

            <!-- modal to check checkbox to confirm download the document and the other checkbox to check if mark as printed -->
            <div class="modal fade" id="downloadAndPrintModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Download and Print</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="downloadCheckbox">
                      <label class="form-check-label" for="downloadCheckbox">
                        Download Document
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="markAsPrintedCheckbox">
                      <label class="form-check-label" for="markAsPrintedCheckbox">
                        Mark as Printed
                      </label>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmDownloadAndPrintButton">Confirm</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- modal to ask if u are sure to set document request as printed -->

            <div class="modal fade" id="confirmPrintModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Confirm Print</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to mark this document request as printed?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPrintButton">Yes, Confirm</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table id="add-row" class="display table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Request ID</th>
                    <th>Employee</th>
                    <th>Date Range</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                  <tr>
                    <td>
                      <input style="width: 110px" type="text" id="filterId" class="form-control" placeholder="Filter by ID" onkeydown="if (event.key === 'Enter') loadDocumentsRequests();">
                    </td>
                    <td>
                      <input style="width: 200px" type="text" id="filterEmployee" class="form-control" placeholder="Filter by Employee" onkeydown="if (event.key === 'Enter') loadDocumentsRequests();">
                    </td>
                    <td>
                      <div style="display:flex; gap:10px;">
                        <input style="width: 150px" type="date" id="filterDateStart" class="form-control" onchange="loadDocumentsRequests()">
                        <input style="width: 150px" type="date" id="filterDateEnd" class="form-control" onchange="loadDocumentsRequests()">
                      </div>
                    </td>
                    <td>
                      <select style="width: 200px" id="filterType" class="form-control" onchange="loadDocumentsRequests()">
                        <option value="">All Types</option>
                        <option value="1">Constancia de Trabajo</option>
                        <option value="2">Constancia de salario</option>
                    </td>
                    <td>
                      <select style="width: 150px" id="filterStatus" class="form-control" onchange="loadDocumentsRequests()">
                        <option value="">All Statuses</option>
                        <option value="1">Pending</option>
                        <option value="2">Printed</option>
                    </td>
                    <td>
                      <div style="display:flex; gap:10px;">
                        <!-- <img style="cursor: pointer;" onclick="resetform()" src="<?Php echo URLROOT; ?>/assets/img/clear-filter.png" width="25" height="25"> -->
                        <span style="align-self: center; cursor: pointer;" onclick="loadDocumentsRequests()">
                          <i class="fa fa-search" style="color: gray;"></i>
                        </span>
                        <span style="align-self: center; cursor: pointer;" onclick="resetDateFilter()">
                          <i class="fa fa-times-circle" style="color: red;"></i>
                        </span>
                      </div>
                    </td>
                  </tr>
                </thead>
                <tbody id="gridBody">


                </tbody>

              </table>
            </div>

            <div class="d-flex justify-content-between">
              <div class="showing" id="toShow"></div>
              <div class="pagination">
                <nav class="pull-right" id="pagination">

                </nav>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
    <?php require APPROOT . '/views/inc/footer.php'; ?>
  </div>
</div>

<script src="<?php echo URLROOT ?>/assets/js/custom/numberToWords.js"></script>
<script>
  $(document).ready(function() {
    loadDocumentsRequests();
  });

  function resetDateFilter() {
    $("#filterDateStart").val('');
    $("#filterDateEnd").val('');
    $("#filterId").val('');
    $("#filterEmployee").val('');
    $("#filterType").val('');
    $("#filterStatus").val('');

    loadDocumentsRequests();
  }

  $("#downloadAndPrintModal").on("show.bs.modal", function(event) {
    var button = $(event.relatedTarget);
    var requestId = button.data("request-id");
    var employeeId = button.data("employee-id");
    var documentType = button.data("document-type");
    console.log("employeeId:", employeeId);

    var confirmButton = $("#confirmDownloadAndPrintButton");
    confirmButton.off("click");
    confirmButton.on("click", function() {
      var downloadChecked = $("#downloadCheckbox").is(":checked");
      var markAsPrintedChecked = $("#markAsPrintedCheckbox").is(":checked");

      if (markAsPrintedChecked) {
        markAsPrinted(requestId);
      }

      if (downloadChecked) {
        generateDocx(employeeId, documentType);
      }

      $("#downloadAndPrintModal").modal("hide");
    });
  });

  $("#downloadAndPrintModal").on("hidden.bs.modal", function() {
    // Uncheck checkboxes
    $("#downloadCheckbox").prop("checked", false);
    $("#markAsPrintedCheckbox").prop("checked", false);
  });


  $("#confirmPrintModal").on("show.bs.modal", function(event) {
    var button = $(event.relatedTarget);
    var requestId = button.data("request-id");

    var confirmButton = $("#confirmPrintButton");
    confirmButton.off("click");
    confirmButton.on("click", function() {
      markAsPrinted(requestId);
      $("#confirmPrintModal").modal("hide");
    });
  });

  function markAsPrinted(requestId) {
    let frm = new FormData();
    frm.append('requestId', requestId);

    fetch('<?php echo URLROOT ?>/documentsRequests/markAsPrinted', {
        method: 'POST',
        body: frm
      })
      .then(response => response.text())
      .then(data => {
        loadDocumentsRequests();
      })
      .catch(error => console.error('Error marking as printed:', error));
  }


  let currentPage = 1;
  let rowsPerPage = 10;
  let cachedData = [];

  function loadDocumentsRequests() {

    if ($("#filterDateStart").val() !== '' && $("#filterDateEnd").val() === '') {
      return;
    }

    let frm = new FormData();
    frm.append('startDate', $("#filterDateStart").val());
    frm.append('endDate', $("#filterDateEnd").val());
    frm.append('requestId', $("#filterId").val());
    frm.append('employeeName', $("#filterEmployee").val());
    frm.append('documentType', $("#filterType").val());
    frm.append('status', $("#filterStatus").val());

    fetch('<?php echo URLROOT ?>/documentsRequests/getDocumentsRequests', {
        method: 'POST',
        body: frm
      })
      .then(response => response.json())
      .then(data => {

        cachedData = data; // store full dataset for pagination
        currentPage = 1; // reset page
        renderPage();
      })
      .catch(error => console.error('Error loading document requests:', error));
  }



  function renderPage() {

    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;

    let pageItems = cachedData.slice(start, end);

    let gridBody = '';

    pageItems.forEach(request => {
      const date = new Date(request.createdAt).toLocaleDateString('es-ES', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
      });

      const type = request.documentType == 1 ? 'Constancia de Trabajo' : 'Constancia de salario';
      const employeeName = request.firstName + ' ' + request.firstLastName;
      const isPending = request.status == 1;
      const status = isPending ? 'Pending' : 'Printed';
      const statusColor = isPending ? 'brown' : 'green';

      gridBody += `
          <tr>
            <td>#${request.employeeDocumentsRequestsId}</td>
            <td>${employeeName}</td>
            <td>${date}</td>
            <td>${type}</td>
            <td style="color:${statusColor}; font-weight:bold;">${status}</td>
            <td>
              ${isPending ? `
                <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#downloadAndPrintModal"
                  data-document-type="${request.documentType}"
                  data-employee-id="${request.employeeId}"
                  data-request-id="${request.employeeDocumentsRequestsId}">
                    <i class="fa fa-print" style="font-size:20px; color:royalblue;"></i>
                </button>` 
              :
                `<button class="btn btn-link"><i class="fa fa-check" style="font-size:20px; color:green;"></i></button>`
              }
            </td>
          </tr>`;
    });

    document.getElementById('gridBody').innerHTML = gridBody;

    renderPagination();
  }



  function renderPagination() {
    let totalRows = cachedData.length;
    let totalPages = Math.ceil(totalRows / rowsPerPage);

    let html = `
        <ul class="pagination justify-content-end">

            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
            </li>
    `;

    for (let i = 1; i <= totalPages; i++) {
      html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>
        `;
    }

    html += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
            </li>

        </ul>
    `;

    document.getElementById("pagination").innerHTML = html;

    // Showing text (e.g. "Showing 11–20 of 53")
    let start = (currentPage - 1) * rowsPerPage + 1;
    let end = Math.min(currentPage * rowsPerPage, totalRows);

    document.getElementById("toShow").innerHTML =
      `Showing ${start}–${end} of ${totalRows}`;
  }



  function changePage(page) {
    currentPage = page;
    renderPage();
  }

  async function generateDocx(employeeId, documentType) {

    try {

      let template_url = "";
      if (documentType == 1) {
        template_url = '<?php echo URLROOT ?>/assets/templates/constancia_laboral.docx';
      } else {
        template_url = '<?php echo URLROOT ?>/assets/templates/constancia_salarial.docx';
      }
      const response = await fetch(template_url);
      if (!response.ok) throw new Error('Failed to load template file');
      const templateArrayBuffer = await response.arrayBuffer();

      const zip = new PizZip(templateArrayBuffer);
      const doc = new window.docxtemplater(zip, {
        paragraphLoop: true,
        linebreaks: true
      });

      const frm = new FormData();
      frm.append('employeeId', employeeId);

      const dataResponse = await fetch('<?php echo URLROOT ?>/documentsRequests/getEmployeeInfo', {
        method: 'POST',
        body: frm
      });

      if (!dataResponse.ok) {
        throw new Error('Failed to fetch employee data');
      }
      const data = await dataResponse.json();
      console.log('Employee data:', data);

      if (data.error) {
        alert('Error fetching employee data: ' + data.error);
        return;
      }

      let salaryInWords = numberToWords(data.salary);
      data.salaryInWords = salaryInWords + ' DÓLARES DE LOS ESTADOS UNIDOS DE AMÉRICA (US $' + Number(data.salary).toFixed(2) + ')';

      //AFP 7.25% y ISSS 3%
      let afp = data.salary * 0.0725;
      let isss = data.salary * 0.03;
      if (isss > 30) isss = 30;

      let totalDeductions = afp + isss;
      let netSalary = data.salary - totalDeductions;

      let incomeTax = getIncomeTax(data.salary, netSalary);
      let total = netSalary - incomeTax;

      let currentDateLetters = dateInWords(new Date());
      let hireDateLetters = hiredDateInWords(new Date(data.hiredDate));

      const mappedData = {
        current_date: "San Salvador, " + new Date().toLocaleDateString('es-ES', {
          day: '2-digit',
          month: 'long',
          year: 'numeric'
        }),
        name: data.fullname,
        dui: data.documentNumber,
        date_letters: hireDateLetters,
        position: data.positionName,
        salary_letters: data.salaryInWords,
        salary: Number(data.salary).toFixed(2),
        income: incomeTax.toFixed(2),
        afp: afp.toFixed(2),
        isss: isss.toFixed(2),
        discounts: (incomeTax + afp + isss).toFixed(2),
        total: total.toFixed(2),
        current_date_letters: currentDateLetters,
        afp_type: data.afpTypeId == 1 ? 'AFP Confia' : data.afpTypeId == 2 ? 'AFP Crecer' : 'IPSFA'
      };

      doc.setData(mappedData);

      try {
        doc.render();
      } catch (renderError) {
        console.error('Template rendering error:', renderError);
        throw renderError;
      }

      const out = doc.getZip().generate({
        type: 'blob',
        mimeType: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
      });

      const safeName = (data.fullname || 'employee').replace(/\s+/g, '_');

      let documentName = "";
      if (documentType == 1) {
        documentName = `constancia_laboral_${safeName}.docx`;
      } else {
        documentName = `constancia_salarial_${safeName}.docx`;
      }

      saveAs(out, documentName);

      loadDocumentsRequests();

    } catch (error) {
      console.error('Error generating Word file:', error);
      alert('There was an error generating the document. Check console for details.');
    }
  }
</script>