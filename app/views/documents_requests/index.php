<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
  <div class="page-inner">

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Documents Requests</h4>
              <button id="createDocumentRequest" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addDocumentRequest">
                <i class="fa fa-plus"></i>
                Create New Request
              </button>
            </div>
          </div>
          <div class="card-body">

            <!--Add Modal -->
            <div class="modal fade" id="addDocumentRequest" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title">
                      <span class="fw-mediumbold" id="actionspan">Create Document Request</span>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="documentType">Document Type</label>
                          <select class="form-control" id="documentType" name="documentType" required>
                            <option value="" disabled selected>Select Document Type</option>
                            <option value="1">Constancia de Trabajo</option>
                            <option value="2">Constancia de Salario</option>
                          </select>
                          <span id="fieldRequired" style="color:red; display:none;">* This field is required.</span>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <!-- sending message -->
                          <span id="sendingMessage" style="color:gray; display:none;">Sending request, please wait...</span>
                          <!-- success message -->
                          <span id="successMessage" style="color:green; display:none;">Document request sent successfully!</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer border-0">

                    <button type="submit" id="addDocumentRequestButton" class="btn btn-primary" onclick="generateDocx()">Submit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table id="add-row" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Request ID</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Status</th>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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

  let allRequests = [];
  let currentPage = 1;
  const rowsPerPage = 10;

  function loadDocumentsRequests() {
    const frm = new FormData();
    frm.append('employeeId', <?php echo json_encode($_SESSION['employeeId']); ?>);

    fetch('<?php echo URLROOT ?>/documentsRequests/getEmployeeDocumentsRequests', {
        method: 'POST',
        body: frm
      })
      .then(response => response.json())
      .then(data => {
        allRequests = data;
        currentPage = 1;
        renderTable();
        renderPagination();
      })
      .catch(error => console.error('Error loading document requests:', error));
  }

  function renderTable() {
    const gridBody = document.getElementById('gridBody');
    gridBody.innerHTML = '';

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const pageItems = allRequests.slice(start, end);

    pageItems.forEach(request => {
      const date = new Date(request.createdAt).toLocaleDateString('es-ES', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
      });

      const isPending = request.status == 1;
      const status = isPending ? 'Pending' : 'Printed';
      const statusColor = isPending ? 'brown' : 'green';

      const type = request.documentType == 1 ?
        'Constancia de Trabajo' :
        'Constancia de Salario';

      gridBody.innerHTML += `
      <tr>
        <td>#${request.employeeDocumentsRequestsId}</td>
        <td>${date}</td>
        <td>${type}</td>
        <td style="color: ${statusColor}; font-weight: bolder;">${status}</td>
      </tr>
    `;
    });

    updateShowingText(start, end);
  }

  function updateShowingText(start, end) {
    const total = allRequests.length;
    const from = total === 0 ? 0 : start + 1;
    const to = end > total ? total : end;

    document.getElementById("toShow").innerText =
      `Showing ${from} – ${to} of ${total}`;
  }

  function renderPagination() {
    const totalPages = Math.ceil(allRequests.length / rowsPerPage);
    const pagination = document.getElementById('pagination');

    pagination.innerHTML = `
    <ul class="pagination pagination-sm m-0">
      <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <button class="page-link" onclick="prevPage()"><</button>
      </li>

      <li class="page-item disabled">
        <span class="page-link"> ${currentPage} </span>
      </li>

      <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <button class="page-link" onclick="nextPage()">></button>
      </li>
    </ul>
  `;
  }

  function nextPage() {
    const totalPages = Math.ceil(allRequests.length / rowsPerPage);
    if (currentPage < totalPages) {
      currentPage++;
      renderTable();
      renderPagination();
    }
  }

  function prevPage() {
    if (currentPage > 1) {
      currentPage--;
      renderTable();
      renderPagination();
    }
  }


  async function generateDocx() {
    if ($("#documentType").val() == null || $("#documentType").val() == '') {
      $("#fieldRequired").show();
      $("#documentType").focus();
      return;
    } else {
      $("#fieldRequired").hide();
    }
    try {

      $("#sendingMessage").show();

      let template_url = "";
      if ($("#documentType").val() == 1) {
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
      frm.append('employeeId', <?php echo json_encode($_SESSION['employeeId']); ?>);

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
      console.log('Salary in words:', salaryInWords);
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
        current_date_letters: currentDateLetters
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
      const formData = new FormData();
      if ($("#documentType").val() == 1) {
        formData.append("document", out, `constancia_laboral_${safeName}.docx`);
      } else {
        formData.append("document", out, `constancia_salarial_${safeName}.docx`);
      }
      formData.append("employee", data.fullname);
      formData.append("employeeId", <?php echo json_encode($_SESSION['employeeId']); ?>);
      formData.append("documentType", $("#documentType").val());

      // Send to PHP 
      const uploadResponse = await fetch("<?php echo URLROOT ?>/documentsRequests/sendEmailWithAttachment", {
        method: "POST",
        body: formData
      });

      $("#sendingMessage").hide();

      const uploadResult = await uploadResponse.text();
      $("#successMessage").show();
      setTimeout(() => {
        $("#successMessage").hide();
        $("#documentType").val('');
        $('#addDocumentRequest').modal('hide');
        loadDocumentsRequests();
      }, 5000);
      // saveAs(out, `constancia_salarial_${safeName}.docx`);

    } catch (error) {
      console.error('Error generating Word file:', error);
      alert('There was an error generating the document. Check console for details.');
    }
  }
</script>