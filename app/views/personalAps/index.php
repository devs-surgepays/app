<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <!-- <div>
                <h3 class="fw-bold mb-3">Employees</h3>
                <h6 class="op-7 mb-2">Employee management</h6>
            </div> -->
            <!-- <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round">Add Customer</a>
              </div> -->
        </div>

        <!-- Table Employees -->
        <div class="row">
            <?php echo breadcrumbs('Personal APs') ?>
        </div>

        <div class="row pb-3">

            <div class="d-flex justify-content-between">
                <div>
                    <label for="">Show
                        <select name="length" id="length" class="form-control-sm searchDataChange">
                            <option value="5">5</option>
                            <option selected value="10">10</option>
                            <option value="25">25</option>
                        </select> entries
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-stats card-round">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="tblPersonalAps" class="GrenTable table table-bordered tbEmployees">
                                <thead>
                                    <tr class="dataexp">
                                        <td>No.</td>
                                        <td>Id</td>
                                        <td>Created At</td>
                                        <td>AP Type</td>
                                        <td>Approved</td>
                                        <td>Action</td>
                                    </tr>
                                    <tr id="search">
                                        <th></th>
                                        <th><input class="form-control form-control-sm searchDataChange camposserch" id="serch_badge" type="text"></th>
                                        <th><input class="form-control form-control-sm searchDataChange camposserch" id="serch_badge" type="date"></th>
                                        <th><select class="form-control form-control-sm searchDataChange camposserch js-select-basic" id="serch_position">
                                                <option value="">Select</option>
                                                <?php for ($i = 0; $i < count($data['apTypes']); $i++)  echo '<option value="' . $data['apTypes'][$i]['apTypeId'] . '">' . $data['apTypes'][$i]['name'] . '</option>'; ?>
                                            </select></th>
                                        <th></th>
                                        <th> <img style="cursor: pointer;" onclick="resetform()" src="<?php echo URLROOT; ?>/assets/img/clear-filter.png" width="25" height="25">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="dataBody">
                                </tbody>
                            </table>
                            <p id="showingRows"></p>
                            <nav id="paginationRows" style="float:right;"></nav>

                            <div class="d-flex justify-content-between">
                                <div class="showing"></div>
                                <div class="pagination">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php require APPROOT . '/views/inc/footer.php'; ?>
    </div> <!-- end/page-inner -->
</div> <!-- end/container2 -->


<!-- model -->

<div class="modal fade" id="edit-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-userLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">AP #<span id="idAPShow"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUser" method="POST" action="">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group form-group-default">
                                <label>Badge</label>
                                <input type="text" disabled class="form-control" id="badgeAp" name="badgeAp" placeholder="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group form-group-default">
                                <label>AP Type</label>
                                <input type="text" disabled class="form-control" id="apTypeAP" name="apTypeAP" placeholder="">
                            </div>
                        </div>
                    </div>
                    <hr style="color: #b9b9b9;">
                    <!-- <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="smallInput">AP Type</label>
                                <input type="text" id="apTypeAP" name="apTypeAP" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                            </div>
                        </div>
                    </div> -->

                    <div id="permisoConSinGoce" class="toggleable">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Motivo</label>
                                    <input type="text" id="motivoAP" name="motivoAP" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Tipo</label>
                                    <input type="text" id="tipoAP" name="tipoAP" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="permisoDiasHora" id="permisosinconGoceDias">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="smallInput">Día</label>
                                        <input type="text" id="diaInicio" name="diaInicio" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="smallInput">Día Final</label>
                                        <input type="text" id="diaFinal" name="diaFinal" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="permisoDiasHora" id="permisosinconGoceHoras">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="smallInput">Día</label>
                                        <input type="text" id="diaInicioHora" name="diaInicioHora" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="smallInput">Hora Inicio</label>
                                        <input type="text" id="HoraInicio" name="HoraInicio" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="smallInput">Hora Final</label>
                                        <input type="text" id="horaFinal" name="horaFinal" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="smallInput">Documentos Justificados que se entregan</label>
                                    <textarea name="reason3Documents" id="reason3Documents" class="form-control" placeholder="Comments" rows="3" disabled="">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iusto commodi voluptate in, soluta nostrum ullam numquam sint nam possimus eius sed voluptatem laudantium error pariatur. Possimus harum obcaecati quasi rem!</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="SolicitudVacaciones" class="toggleable">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Inicio</label>
                                    <input type="text" id="FechaInicioVac" name="FechaInicioVac" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Final</label>
                                    <input type="text" id="fechaFinalVac" name="fechaFinalVac" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Cantidad Días</label>
                                    <input type="text" id="cantidadDias" name="cantidadDias" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Pago</label>
                                    <input type="text" id="fechaPago" name="fechaPago" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="TrasladoCambioPuesto" class="toggleable">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Departamento</label>
                                    <input type="text" id="departamentoCambio" name="departamentoCambio" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Posición</label>
                                    <input type="text" id="posicionCambio" name="posicionCambio" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Inicio Periodo de Prueba</label>
                                    <input type="text" id="inicioPeriodo" name="inicioPeriodo" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fin Periodo de Prueba</label>
                                    <input type="text" id="finPeriodo" name="finPeriodo" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="incapacidad" class="toggleable">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Inicio</label>
                                    <input type="text" id="FechaInicioInca" name="FechaInicioInca" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Final</label>
                                    <input type="text" id="fechaFinalInca" name="fechaFinalInca" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Tipo de Incapacidad</label>
                                    <input type="text" id="tipoIncapacidad" name="tipoIncapacidad" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Prorroga</label>
                                    <input type="text" id="prorroga" name="prorroga" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="SancionesDisciplinarias" class="toggleable">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Tipo de Amonestación</label>
                                    <input type="text" id="tipoAmonestacion" name="tipoAmonestacion" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="suspensionFecha">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="smallInput">Inicio Suspesión</label>
                                        <input type="text" id="inicioSuspesion" name="inicioSuspesion" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="smallInput">Fin Suspensión</label>
                                        <input type="text" id="finSuspesion" name="finSuspesion" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="cambioHorario" class="toggleable">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Inicio</label>
                                    <input type="text" id="FechaInicioHorario" name="FechaInicioHorario" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Final</label>
                                    <input type="text" id="fechaFinalHorario" name="fechaFinalHorario" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Motivo de Cambio de Horario</label>
                                    <input type="text" id="motivoCambioHorario" name="motivoCambioHorario" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p class="form-group fw-medium">Days: <span id="daysHorario" class="fw-light"></span></p>
                                <p class="form-group fw-medium mb-3">Days OFF: <span id="daysOffHorario" class="fw-light"></span></p>
                                <div class="table-responsive">
                                    <table id="tblHorarioLast" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Day</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Lunch</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>


                            </div>
                        </div>

                    </div>

                    <div id="cambioDiaLibre" class="toggleable">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha de Solicitud</label>
                                    <input type="text" id="fechaSolicitud" name="fechaSolicitud" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Día Asignado</label>
                                    <input type="text" id="diaAsignado" name="diaAsignado" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Día Solicitado</label>
                                    <input type="text" id="diaSolicitado" name="diaSolicitado" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Motivo</label>
                                    <input type="text" id="motivoCambioDia" name="motivoCambioDia" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="notificacionAusencia" class="toggleable">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Inicio</label>
                                    <input type="text" id="FechaInicioIncaNoti" name="FechaInicioIncaNoti" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Final</label>
                                    <input type="text" id="fechaFinalIncaNoti" name="fechaFinalIncaNoti" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="horasExtras" class="toggleable">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha Inicio</label>
                                    <input type="text" id="fechaDiaHorasExtras" name="fechaDiaHorasExtras" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Inicio</label>
                                    <input type="time" id="inicioHoras" name="inicioHoras" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fin</label>
                                    <input type="time" id="finHoras" name="finHoras" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Total Horas</label>
                                    <input type="text" id="totalHorasOT" name="totalHorasOT" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="retiroPersonal" class="toggleable">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Reasons</label>
                                    <input type="text" id="reasonsRetiro" name="reasonsRetiro" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Reasons Details</label>
                                    <input type="text" id="reasonsDetailsRetiro" name="reasonsDetailsRetiro" value="Horas" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Fecha de Retiro</label>
                                    <input type="text" id="fechaRetiro" name="fechaRetiro" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="ajusteSalarial" class="toggleable">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Monto</label>
                                    <input type="text" id="monto" name="monto" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Efectivo Desde</label>
                                    <input type="text" id="efectivoDesde" name="efectivoDesde" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="smallInput">Nuevo Puesto</label>
                                    <input type="text" id="nuevoPuesto" name="nuevoPuesto" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="smallInput">Comments</label>
                                <textarea name="commentsAp" id="commentsAp" class="form-control" placeholder="Comments" rows="3" disabled="">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iusto commodi voluptate in, soluta nostrum ullam numquam sint nam possimus eius sed voluptatem laudantium error pariatur. Possimus harum obcaecati quasi rem!</textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <!-- <input type="hidden" name="userIdEdit" id="userIdEdit">
                    <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Edit User</button> -->
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.js-select-basic').select2();
        readData(1, '', 10, '');
        // getInfoCard();
    });

    function readData(page, search, length, ascDesc) {
        var param = {
            'action': 'ajaxDataRows',
            'page': page,
            'search': search,
            'length': length,
            'ascDesc': ascDesc
        };

        console.log(param)

        $.ajax({
            url: '<?php echo URLROOT; ?>/personalAps/getDataRows',
            method: 'POST',
            data: param,
            beforeSend: function(obj) {
                //GIF WAITING
            },
            success: function(data) {
                console.log(data)
                var obj = JSON.parse(data)
                var rows = obj.data;
                // console.log(rows)

                var tbody = $('#tblPersonalAps tbody');
                tbody.empty(); // Limpiar tabla antes de llenar
                let rowNumber = 1;
                let totalRowShow = 0;

                if (rows.length > 0) {

                    rows.forEach(function(item) {

                        var createdAtDate = new Date(item.createdAt);

                        var year = createdAtDate.getFullYear();
                        var month = String(createdAtDate.getMonth() + 1).padStart(2, '0'); // Meses van de 0 a 11
                        var day = String(createdAtDate.getDate()).padStart(2, '0');
                        var formattDate = `${year}-${month}-${day}`;

                        // const status = (item.statusEmployee == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                        totalRowShow = obj.offset + rowNumber;
                        // const emailCorp = (item.corporateEmail === null) ? '' : item.corporateEmail;
                        // const urlEmployee = (obj.getPLFullEmployeeInfo) ? 'edit' : 'showEmployee';

                        // <td><a href="<?php echo URLROOT; ?>/employees/${urlEmployee}/${item.badge}" class="btn btn-primary btn-border">#${item.badge}</a> </td></td>

                        var row = `<tr>
                        <td>${rowNumber}</td>
                        <td>${ item.apDetailsId }</td>
                        <td>${ formattDate }</td>
                        <td>${ item.name }</td>
                        <td><span class="badge badge-success">Approved</span></td>
                        <td>
                            <button type="button" onclick="GetInformationPersonal(${ item.apDetailsId })" data-bs-toggle="modal" data-bs-target="#edit-user" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button>
                        </td>
                        </tr>`;
                        tbody.append(row);
                        rowNumber++;
                    });

                } else {
                    var row = `<tr class="text-center"><td colspan="9">No records found</td></tr>`;
                    tbody.append(row);
                }
                // showing
                $("#showingRows").html(`Showing ${obj.offsetnumShow} to ${totalRowShow} of ${obj.numrows}`);
                $("#paginationRows").html(obj.pagination);



            }
        })
    }

    function GetInformationPersonal(apDetailsId) {

        var param = {
            'apDetailsId': apDetailsId
        }

        $.ajax({
            url: '<?php echo URLROOT; ?>/personalAps/getRecordAPId',
            method: 'POST',
            data: param,
            beforeSend: function(obj) {
                //GIF WAITING
            },
            success: function(data) {
                var obj = JSON.parse(data);

                if (obj.status) {
                    var datarecord = obj.data;
                    console.log(datarecord);

                    switch (datarecord.apTypeId) {
                        case 1:
                        case 2:

                            hideAllAndShow('permisoConSinGoce')

                            $("#motivoAP").val(datarecord.reason1);
                            $("#tipoAP").val(datarecord.reason2);
                            $(".permisoDiasHora").hide();
                            if (datarecord.reason2 == "Dias") {
                                $("#diaInicio").val(datarecord.apDate1);
                                $("#diaFinal").val(datarecord.apDate2);
                                $("#permisosinconGoceDias").show();
                            } else {
                                $("#diaInicioHora").val(datarecord.apDate1);
                                $("#HoraInicio").val(datarecord.startTime);
                                $("#horaFinal").val(datarecord.endTime);
                                $("#permisosinconGoceHoras").show();
                            }
                            $("#reason3Documents").val(datarecord.reason3);

                            break;

                        case 3:
                            hideAllAndShow('SolicitudVacaciones')
                            $("#FechaInicioVac").val(datarecord.apDate1);
                            $("#fechaFinalVac").val(datarecord.apDate2);
                            $("#cantidadDias").val(calculateDays('FechaInicioVac', 'fechaFinalVac'));
                            $("#fechaPago").val(datarecord.apDate3);
                            break;

                        case 4:
                            hideAllAndShow('TrasladoCambioPuesto')
                            $("#departamentoCambio").val(datarecord.newAccountName);
                            $("#posicionCambio").val(datarecord.newPositionName);
                            $("#inicioPeriodo").val(datarecord.apDate1);
                            $("#finPeriodo").val(datarecord.apDate2);
                            break;

                        case 5:
                            hideAllAndShow('incapacidad')
                            $("#FechaInicioInca").val(datarecord.apDate1);
                            $("#fechaFinalInca").val(datarecord.apDate2);
                            $("#tipoIncapacidad").val(datarecord.reason1);
                            $("#prorroga").val(datarecord.reason2);

                            break;
                        case 6:
                            hideAllAndShow('SancionesDisciplinarias')
                            $("#tipoAmonestacion").val(datarecord.reason1);
                            $("#inicioSuspesion").val(datarecord.apDate1);
                            $("#finSuspesion").val(datarecord.apDate2);
                            $(".suspensionFecha").hide();
                            if (datarecord.reason1 == 'Suspension') {
                                $(".suspensionFecha").show();
                            }

                            break;
                        case 7:
                            hideAllAndShow('cambioHorario')
                            var dataSchedule = obj.dataScheduleLast
                            console.log(dataSchedule)

                            $("#FechaInicioHorario").val(datarecord.apDate1);
                            $("#fechaFinalHorario").val(datarecord.apDate2);
                            $("#motivoCambioHorario").val(datarecord.reason1);
                            $("#daysHorario").html(dataSchedule.days);
                            $("#daysOffHorario").html(dataSchedule.daysOff);

                            let tabla = document.getElementById("tblHorarioLast").getElementsByTagName("tbody")[0];
                            var nuevaFila = tabla.insertRow();
                            nuevaFila.insertCell().textContent = 'Monday';
                            nuevaFila.insertCell().textContent = dataSchedule.monday;
                            nuevaFila.insertCell().textContent = dataSchedule.mondayLunch;
                            var nuevaFila = tabla.insertRow();
                            nuevaFila.insertCell().textContent = 'Tuesday';
                            nuevaFila.insertCell().textContent = dataSchedule.tuesday;
                            nuevaFila.insertCell().textContent = dataSchedule.tuesdayLunch;
                            var nuevaFila = tabla.insertRow();
                            nuevaFila.insertCell().textContent = 'Wednesday';
                            nuevaFila.insertCell().textContent = dataSchedule.wednesday;
                            nuevaFila.insertCell().textContent = dataSchedule.wednesdayLunch;
                            var nuevaFila = tabla.insertRow();
                            nuevaFila.insertCell().textContent = 'Thursday';
                            nuevaFila.insertCell().textContent = dataSchedule.thursday;
                            nuevaFila.insertCell().textContent = dataSchedule.thursdayLunch;
                            var nuevaFila = tabla.insertRow();
                            nuevaFila.insertCell().textContent = 'Friday';
                            nuevaFila.insertCell().textContent = dataSchedule.friday;
                            nuevaFila.insertCell().textContent = dataSchedule.fridayLunch;
                            var nuevaFila = tabla.insertRow();
                            nuevaFila.insertCell().textContent = 'Saturday';
                            nuevaFila.insertCell().textContent = dataSchedule.saturday;
                            nuevaFila.insertCell().textContent = dataSchedule.saturdayLunch;
                            var nuevaFila = tabla.insertRow();
                            nuevaFila.insertCell().textContent = 'Sunday';
                            nuevaFila.insertCell().textContent = dataSchedule.sunday;
                            nuevaFila.insertCell().textContent = dataSchedule.sundayLunch;

                            break;
                        case 8:
                            hideAllAndShow('cambioDiaLibre')
                            $("#fechaSolicitud").val(datarecord.apDate1);
                            $("#diaAsignado").val(datarecord.apDate2);
                            $("#diaSolicitado").val(datarecord.apDate3);
                            $("#motivoCambioDia").val(datarecord.reason1);
                            break;

                        case 9:
                            hideAllAndShow('notificacionAusencia')
                            $("#FechaInicioIncaNoti").val(datarecord.apDate1);
                            $("#fechaFinalIncaNoti").val(datarecord.apDate2);
                            break;


                        case 10:
                            hideAllAndShow('horasExtras')
                            $("#fechaDiaHorasExtras").val(datarecord.apDate1);
                            $("#inicioHoras").val(datarecord.startTime);
                            $("#finHoras").val(datarecord.endTime);
                            $("#totalHorasOT").val(getTotalOT('inicioHoras', 'finHoras'));
                            break;


                        case 11:
                            hideAllAndShow('retiroPersonal')
                            $("#reasonsRetiro").val(datarecord.reason1);
                            $("#reasonsDetailsRetiro").val(datarecord.reason2);
                            $("#fechaRetiro").val(datarecord.apDate1);
                            break;

                        case 12:
                            hideAllAndShow('ajusteSalarial')
                            $("#monto").val(datarecord.newSalary);
                            $("#efectivoDesde").val(datarecord.apDate1);
                            $("#nuevoPuesto").val(datarecord.newPositionName);

                            break;

                        default:
                            hideAllAndShow('')
                    }




                    // fields commun
                    $("#idAPShow").html(datarecord.apDetailsId);
                    $("#badgeAp").val(datarecord.badge);
                    $("#apTypeAP").val(datarecord.name);

                    $("#commentsAp").val(datarecord.comment);


                } else {
                    console.log("Algo paso")
                }
            }
        })
    }

    function hideAllAndShow(elementId) {
        // Get all elements with the class name 'toggleable'
        var elements = document.querySelectorAll('.toggleable');

        // Hide all elements
        elements.forEach(function(element) {
            element.style.display = 'none';
        });

        // Show the specific element by its ID
        var elementToShow = document.getElementById(elementId);
        if (elementToShow) {
            elementToShow.style.display = 'block';
            console.info(elementId);
        } else {
            console.info('Element with ID "' + elementId + '" not found.');
            //elementToShow.style.display="none";
        }
    }

    function calculateDays(comp1Id, com2Id) {
        var startDate = new Date($("#" + comp1Id).val());
        var endDate = new Date($("#" + com2Id).val());
        // Calculate the time difference in milliseconds
        var timeDifference = endDate - startDate;
        // Convert time difference from milliseconds to days
        var dayDifference = timeDifference / (1000 * 3600 * 24);
        dayDifference = dayDifference + 1;
        return dayDifference;
    }

    function getTotalOT(com1Id, com2Id) {
        var start = $("#" + com1Id).val();
        var end = $("#" + com2Id).val();
        console.log(start)
        start = start.split(":");
        end = end.split(":");
        var startDate = new Date(0, 0, 0, start[0], start[1], 0);
        var endDate = new Date(0, 0, 0, end[0], end[1], 0);
        var diff = endDate.getTime() - startDate.getTime();
        var hours = Math.floor(diff / 1000 / 60 / 60);
        diff -= hours * 1000 * 60 * 60;
        var minutes = Math.floor(diff / 1000 / 60);

        // If using time pickers with 24 hours format, add the below line get exact hours
        if (hours < 0)
            hours = hours + 24;

        var totalHours = (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
        return totalHours;
    }

    // // Function General
    function getdataBody() {
        var search = fieldsValue()
        var ascDesc = getAscDesc();
        var length = $('select[id=length]').val();
        // var billTo = $('select[id=billToBtn]').val();
        readData(1, search, length, ascDesc);
    }


    // // Function General
    function fieldsValue() {
        const fielsearch = [];
        var lengthdata = $('.camposserch').length;

        for (let i = 0; i < lengthdata; i++) {
            var classatr = $('.camposserch')[i].value;
            fielsearch.push(classatr);
        }
        return fielsearch;
    }
    // Function General
    function getAscDesc() {
        const fieldorder = [];
        var lengthdata = $('[data-order="orderAscDesc"]').length;

        for (let i = 0; i < lengthdata; i++) {
            var classatr = $('[data-order="orderAscDesc"]')[i].className;
            fieldorder.push(classatr);
        }
        return fieldorder;
    }

    function resetform() {
        $(".camposserch").val("");
        $('.js-select-basic').val(null).trigger('change'); // Clean select2
        $('[data-order="orderAscDesc"]').removeAttr("class");
        $('[data-order="orderAscDesc"]').addClass('fa fa-sort');
        getdataBody();
    }

    // function getInfoCard() {
    //     const data = new URLSearchParams();
    //     data.append('status', $('select[id=billToBtn]').val());

    //     fetch('<?php echo URLROOT; ?>/employees/getInfoCard', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/x-www-form-urlencoded'
    //             },
    //             body: data
    //         }) // api for the get request
    //         .then(response => response.json())
    //         .then(data => {
    //             console.log(data)
    //             $(".totalEmployeeActive").html(data.TotalEmployeeActive)
    //             $(".totalEmployee").html(data.TotalEmployee)
    //             $(".customerServicesActive").html(data.CustomerServicesActive)
    //             $(".hiredToday").html(data.HiredToday)
    //         });
    // }

    // // --------------------------------------------------------------------

    $(".searchDataChange").change(function() {
        getdataBody();
    });
    $(".searchDataClick").click(function() {
        getdataBody();
    });
</script>