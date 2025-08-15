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

        <div class="row">
            <div class="d-flex justify-content-end"><button id="createModal" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">Create Request</button></div>
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
                                        <td>Status</td>
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


<!-- model view-->
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

                    <div id="permisoConSinGoceView" class="toggleable">

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

                    <div id="incapacidadView" class="toggleable">
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
                        <div class="fechaVerbal">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="smallInput">Fecha de Amonestación</label>
                                        <input type="text" id="fechaAmonestacion" name="fechaAmonestacion" class="form-control form-control-sm" disabled id="smallInput" placeholder="">
                                    </div>
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

                    <div id="cambioHorarioView" class="toggleable">

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

                    <div id="cambioDiaLibreView" class="toggleable">
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

                    <div id="horasExtrasView" class="toggleable">

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

                    <div id="ajusteSalarialView" class="toggleable">
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

<!-- Modal Request AP -->
<div class="modal fade" id="addRowModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <span class="fw-mediumbold" id="actionspan"> Create Request</span>
                    <span class="fw-light"> AP </span>
                </h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createApForm" action="index.php" method="POST" enctype="application/x-www-form-urlencoded">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="badgeDiv" class="form-floating  form-floating-custom mb-3">
                                <input id="addbadge" name="addbadge" type="text" readonly class="form-control" placeholder="Badge" value="<?php echo $data['infoAgent']['badge']; ?>" />
                                <label for="addbadge">Badge</label>
                                <div id="msgArea"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-floating form-floating-custom mb-3">

                                <input id="addName" name="addName" type="text" class="form-control" placeholder="fill name" value="<?php echo $data['infoAgent']['fullName']; ?>" readonly />
                                <label>Name</label>
                            </div>
                        </div>
                        <div class="col-md-6 pe-0">
                            <div class="form-floating form-floating-custom mb-3">

                                <input id="addPosition" name="addPosition" type="text" class="form-control" placeholder="fill position" value="<?php echo $data['infoAgent']['positionName']; ?>" readonly />
                                <label>Position</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-custom mb-3">

                                <input id="addDepartment" name="addDepartment" type="text" class="form-control" placeholder="fill department" value="<?php echo $data['infoAgent']['nameDepartament']; ?>" readonly />
                                <label>Department</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-floating form-floating-custom mb-3">

                                <select class="form-control" id="addLeaveType" name="addLeaveType">
                                    <option value="">Select...</option>
                                    <?php
                                    foreach ($data['apTypes'] as $items) {
                                        if ($items['apTypeId'] == 7) {
                                            echo "<option value='" . $items['apTypeId'] . "'>" . $items['name'] . "</option>";
                                        } else {
                                            //echo "<option value='" . $items['apTypeId'] . "'>" . $items['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label>AP type</label>
                            </div>
                        </div>
                        <!-- change Area -->

                        <div id="cambiohorario" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="inicioHorario" id="inicioHorario">
                                    <label>Fecha Inicio</label>
                                </div>
                            </div>
                            <!-- <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="finHorario" id="finHorario">
                                    <label>Fecha Fin</label>
                                </div>
                            </div> -->

                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <select class="form-select" name="motivo_horario" id="motivo_horario">
                                        <option value="">Select</option>
                                        <option value="Cambio Permanente">Cambio Permanente</option>
                                    </select>
                                    <label for="motivo_horario"> Motivo Cambio de Horario: </label>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Dia</th>
                                                <th>Entrada</th>
                                                <th>Salida</th>
                                                <th>Lunch</th>
                                                <th>Dia Libre</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>Lunes</td>
                                            <td><input type="time" class="form-control" id="mondayIn" name="mondayIn"></td>
                                            <td><input type="time" class="form-control" id="mondayOut" name="mondayOut"></td>
                                            <td>
                                                <select class="form-select" name="mondayLunch" id="mondayLunch">
                                                    <option value="" selected>--:--</option>
                                                    <option value="1H">1:00</option>
                                                    <option value="30M">0:30</option>
                                                    <option value="0">0:00</option>
                                                </select>
                                            </td>
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('mondayOff')" data-day="monday" type="checkbox" id="mondayOff" name="mondayOff"></td>
                                        </tr>
                                        <tr>
                                            <td>Martes</td>
                                            <td><input type="time" class="form-control" id="tuesdayIn" name="tuesdayIn"></td>
                                            <td><input type="time" class="form-control" id="tuesdayOut" name="tuesdayOut"></td>
                                            <td>
                                                <select class="form-select" name="tuesdayLunch" id="tuesdayLunch">
                                                    <option value="" selected>--:--</option>
                                                    <option value="1H">1:00</option>
                                                    <option value="30M">0:30</option>
                                                    <option value="0">0:00</option>
                                                </select>
                                            </td>
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('tuesdayOff')" data-day="tuesday" type="checkbox" id="tuesdayOff" name="tuesdayOff"></td>
                                        </tr>
                                        <tr>
                                            <td>Miercoles</td>
                                            <td><input type="time" class="form-control" id="wednesdayIn" name="wednesdayIn"></td>
                                            <td><input type="time" class="form-control" id="wednesdayOut" name="wednesdayOut"></td>
                                            <td>
                                                <select class="form-select" name="wednesdayLunch" id="wednesdayLunch">
                                                    <option value="" selected>--:--</option>
                                                    <option value="1H">1:00</option>
                                                    <option value="30M">0:30</option>
                                                    <option value="0">0:00</option>
                                                </select>
                                            </td>
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('wednesdayOff')" data-day="wednesday" type="checkbox" id="wednesdayOff" name="wednesdayOff"></td>
                                        </tr>
                                        <tr>
                                            <td>Jueves</td>
                                            <td><input type="time" class="form-control" id="thursdayIn" name="thursdayIn"></td>
                                            <td><input type="time" class="form-control" id="thursdayOut" name="thursdayOut"></td>
                                            <td>
                                                <select class="form-select" name="thursdayLunch" id="thursdayLunch">
                                                    <option value="" selected>--:--</option>
                                                    <option value="1H">1:00</option>
                                                    <option value="30M">0:30</option>
                                                    <option value="0">0:00</option>
                                                </select>
                                            </td>
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('thursdayOff')" data-day="thursday" type="checkbox" id="thursdayOff" name="thursdayOff"></td>
                                        </tr>
                                        <tr>
                                            <td>Viernes</td>
                                            <td><input type="time" class="form-control" id="fridayIn" name="fridayIn"></td>
                                            <td><input type="time" class="form-control" id="fridayOut" name="fridayOut"></td>
                                            <td>
                                                <select class="form-select" name="fridayLunch" id="fridayLunch">
                                                    <option value="" selected>--:--</option>
                                                    <option value="1H">1:00</option>
                                                    <option value="30M">0:30</option>
                                                    <option value="0">0:00</option>
                                                </select>
                                            </td>
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('fridayOff')" data-day="friday" type="checkbox" id="fridayOff" name="fridayOff"></td>
                                        </tr>
                                        <tr>
                                            <td>Saturday</td>
                                            <td><input type="time" class="form-control" id="saturdayIn" name="saturdayIn"></td>
                                            <td><input type="time" class="form-control" id="saturdayOut" name="saturdayOut"></td>
                                            <td>
                                                <select class="form-select" name="saturdayLunch" id="saturdayLunch">
                                                    <option value="" selected>--:--</option>
                                                    <option value="1H">1:00</option>
                                                    <option value="30M">0:30</option>
                                                    <option value="0">0:00</option>
                                                </select>
                                            </td>
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('saturdayOff')" data-day="saturday" type="checkbox" id="saturdayOff" name="saturdayOff"></td>
                                        </tr>
                                        <tr>
                                            <td>Domingo</td>
                                            <td><input type="time" class="form-control" id="sundayIn" name="sundayIn"></td>
                                            <td><input type="time" class="form-control" id="sundayOut" name="sundayOut"></td>
                                            <td>
                                                <select class="form-select" name="sundayLunch" id="sundayLunch">
                                                    <option value="" selected>--:--</option>
                                                    <option value="1H">1:00</option>
                                                    <option value="30M">0:30</option>
                                                    <option value="0">0:00</option>
                                                </select>
                                            </td>
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('sundayOff')" data-day="sunday" type="checkbox" id="sundayOff" name="sundayOff"></td>
                                        </tr>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--
                        <div id="permisoConSinGoce" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <select class="form-control" name="motivo_permiso" id="motivo_permiso">
                                    </select>
                                    <label>Motivo</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <select name="tiempopermiso" id="tiempopermiso" class="form-control" onchange="setleaveTime()">
                                        <option value="">Select..</option>
                                        <option value="Horas">Horas</option>
                                        <option value="Dias">Dias</option>
                                    </select>
                                    <label>Tipo</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" id="dia1" name="dia1">
                                    <label>Dia</label>
                                </div>
                            </div>
                            <div id="horas" style="display: none;">
                                <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">
                                        <input class="form-control" type="time" placeholder="Horas" name="hora_inicio" id="hora_inicio">
                                        <label>Hora / inicio</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">
                                        <input class="form-control" type="time" placeholder="Horas" name="hora_final" id="hora_final">
                                        <label>Hora / final</label>
                                    </div>
                                </div>
                            </div>
                            <div id="dias" style="display: none;">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="dia2" id="dia2">
                                    <label>Dia final</label>
                                </div>
                            </div>
                            <div class="form-floating form-floating-custom mb-3">
                                <input class="form-control" type="text" placeholder="Documentos Justificativos" name="documentosJustificativos" id="documentosJustificativos">
                                <label>Documentos Justificativos que se entregan</label>
                            </div>

                        </div>
                        <div id="vacaciones" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="inicioVacaciones" id="inicioVacaciones" onChange="calculateDays()">
                                    <label>Fecha Inicio</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="finVacaciones" id="finVacaciones" onChange="calculateDays()">
                                    <label>Fecha Fin</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">

                                    <input class="form-control" type="number" readonly="" placeholder="Dias" name="totalDias" id="totalDias" value="0">
                                    <label>Cantidad de Días</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="fechaPago" id="fechaPago">
                                    <label>Fecha de Pago</label>
                                </div>
                            </div>
                        </div>
                        <div id="traslados" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <select class="form-control" name="newDepartment" id="newDepartment">
                                    </select>
                                    <label>Departamento</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <select class="form-control" name="newPosition" id="newPosition">
                                    </select>
                                    <label>Posicion</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input type="date" class="form-control" name="inicioPrueba" id="inicioPrueba">

                                    <label>Inicio periodo de Prueba</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input type="date" class="form-control" name="finPrueba" id="finPrueba">

                                    <label>Fin periodo de Prueba</label>
                                </div>
                            </div>
                            <input type="hidden" name="currentPosition" id="currentPosition">
                            <input type="hidden" name="currentDepartment" id="currentDepartment">
                            <input type="hidden" name="currentSalary" id="currentSalary">
                        </div>
                        <div id="incapacidad" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="inicioIncapacidad" id="inicioIncapacidad">
                                    <label>Fecha Inicio</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="finIncapacidad" id="finIncapacidad">
                                    <label>Fecha Fin</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="">Tipo Incapacidad</label>
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipoIncapacidad" id="isss" value="" onChange="getIncapacidad('isss')">
                                        <label class="form-check-label" for="isss">
                                            Seguro Social
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipoIncapacidad" id="seguroprivado" value="" onChange="getIncapacidad('Seguro médico privado')">
                                        <label class="form-check-label" for="seguroprivado">
                                            Seguro médico privado
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipoIncapacidad" id="particular" value="" onChange="getIncapacidad('particular')">
                                        <label class="form-check-label" for="particular">
                                            Particular
                                        </label>
                                    </div>

                                </div>
                                <div class="form-check"><input type="checkbox" id="prorroga" name="prorroga" value="No" onclick="ischecked('prorroga')" class="form-check-input"><label for="prorroga">Prorroga</label></div>
                            </div>
                        </div>
                        <div id="sanciones" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="fechaAmonestacion" id="fechaAmonestacion">
                                    <label>Fecha de Amonestación</label>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-check">
                                    <input class="form-check-input tipoSus" type="radio" name="tipoSancion" id="sancionVerbal" value="" onChange="setSanciones('sancionVerbal')">
                                    <label class="form-check-label" for="sancionVerbal">
                                        Verbal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input tipoSus" type="radio" name="tipoSancion" id="sancionEscrita" value="" onChange="setSanciones('sancionEscrita')">
                                    <label class="form-check-label" for="sancionEscrita">
                                        Escrita
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input tipoSus" type="radio" name="tipoSancion" id="suspension" value="" onChange="setSanciones('suspension')">
                                    <label class="form-check-label" for="suspension">
                                        Suspensión
                                    </label>
                                </div>
                            </div>
                            <div id="diasSuspension" style="display:none">
                                <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">
                                        <input class="form-control" type="date" placeholder="Dia" name="inicioSuspension" id="inicioSuspension">
                                        <label>Inicio Suspension</label>
                                    </div>
                                    <div class="form-floating form-floating-custom mb-3">
                                        <input class="form-control" type="date" placeholder="Dia" name="finSuspension" id="finSuspension">
                                        <label>Fin Suspension</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cambiodialibre" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="fechaSolicitud" id="fechaSolicitud">
                                    <label>Fecha Solicitud</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="diaAsignado" id="diaAsignado">
                                    <label>Dia Asignado</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="diaSolicitado" id="diaSolicitado">
                                    <label>Dia Solicitado</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <select class="form-control" name="motivo_cambio" id="motivo_cambio">
                                    </select>
                                    <label>Motivo</label>
                                </div>
                            </div>
                        </div>
                        <div id="ausencia" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="inicioAusencia" id="inicioAusencia">
                                    <label>Inicio</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="finAusencia" id="finAusencia">
                                    <label>Fin</label>
                                </div>
                            </div>
                        </div>
                        <div id="horasExtra" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="fechaOt" id="fechaOt">
                                    <label>Fecha</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="time" name="inicioOt" id="inicioOt" onchange="getTotalOT()" s>
                                    <label>Inicio</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="time" name="finOt" id="finOt" onchange="getTotalOT()" s>
                                    <label>Fin</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="text" name="totalOt" id="totalOt" readonly>
                                    <label>Total Horas</label>
                                </div>
                            </div>
                        </div>
                        <div id="retiros" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <select class="form-select" name="tipoRetiro" id="tipoRetiro">
                                        <option value="">Seleccione..</option>
                                        <option value="Voluntary">Voluntario</option>
                                        <option value="Involuntary">Involuntario</option>
                                    </select>
                                    <label for="tipoRetiro">Tipo de Retiro</label>
                                </div>
                            </div>

                            <div id="attritionReasons" style="display: none">
                                <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">

                                        <select class="form-select" name="attritions" id="attritions">
                                        </select>
                                        <label>Reasons</label>
                                    </div>

                                </div>

                            </div>

                            <div id="reasonDetail_div" style="display:none">
                                <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">
                                        <select class="form-select" name="reasonsDetails" id="reasonsDetails"></select>
                                        <label>Reason Details</label>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input type="date" class="form-control" name="fechaRetiro" id="fechaRetiro">
                                    <label for="fechaRetiro">Fecha de Retiro</label>
                                </div>
                            </div>

                        </div>
                        <div id="ajusteSalarial" class="toggleable">
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input type="number" class="form-control money2" name="monto" id="monto" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
                                    <label for="monto">Monto</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <input type="date" class="form-control" name="diaEfectivo" id="diaEfectivo">
                                    <label for="diaEfectivo">Efectivo desde</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating form-floating-custom mb-3">
                                    <select class="form-control" name="newPosition2" id="newPosition2">
                                    </select>
                                    <label for="newPosition2">Nuevo Puesto</label>
                                </div>
                            </div>
                        </div>-->
                        <!-- end chnage Area-->
                        <div class="col-sm-12">
                            <div class="form-floating form-floating-custom mb-3">
                                <textarea name="addComments" id="addComments" class="form-control" placeholder="Comments" row="5"></textarea>
                                <label for="addComments">Comments</label>
                            </div>
                        </div>
                        <style>
                            div#aprovedByArea>p {
                                margin-bottom: 0.2rem;
                            }

                            #aproval {
                                color: #1572e8;
                                font-size: 85% !important;
                                transform: translate3d(0, -10px, 0);
                                top: 0;
                                opacity: 1;
                                padding: .375rem 0 .75rem;

                            }
                        </style>

                        <!-- <div class="col-sm-12 mt-3">
                            <div class="form-floating form-floating-custom mb-3">
                                <span style="color: #1572e8 ;font-size: 85%!important;transform: translate3d(0,-10px,0);top: 0;opacity: 1;padding: .375rem 0 .75rem;">Aproval</span>
                                <div id="aprovedByArea">
                                    <span class="badge badge-warning">Pending</span>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <input type="hidden" id="addEmployeeId" value="<?php echo $data['infoAgent']['employeeId']; ?>" name="addEmployeeId">
                    <input type="hidden" id="idApType" name="idApType">

                </div>
                <div class="modal-footer border-0">
                    <button type="submit" id="addAPButton" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-danger closeModal" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
                <input type="hidden" id="Action" name="Action">
                <input type="hidden" id="apId" name="apId">
                <input type="hidden" id="scheduleId" name="scheduleId">
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
    const addForm = $("#createApForm");
    const initialState = {};
    addForm.validate({
        rules: {
            addbadge: {
                required: true,
                digits: true
            },
            addLeaveType: {
                required: true
            },
            motivo_permiso: {
                required: true
            },
            inicioVacaciones: {
                required: true
            },
            tiempopermiso: {
                required: true
            },
            dia1: {
                required: true
            },
            dia2: {
                required: true
            },
            hora_inicio: {
                required: true
            },
            hora_final: {
                required: true
            },
            newDepartment: {
                required: true
            },
            newPosition: {
                required: true
            },
            inicioPrueba: {
                required: true
            },
            finPrueba: {
                required: true
            },
            tipoIncapacidad: {
                required: true
            },
            inicioIncapacidad: {
                required: true
            },
            finIncapacidad: {
                required: true
            },
            tipoSancion: {
                required: true
            },
            inicioSuspension: {
                required: true
            },
            finSuspension: {
                required: true
            },
            fechaAmonestacion: {
                required: true
            },
            inicioAusencia: {
                required: true
            },
            finAusencia: {
                required: true
            },
            fechaOt: {
                required: true
            },
            inicioOt: {
                required: true
            },
            finOt: {
                required: true
            },
            tipoRetiro: {
                required: true
            },
            attritions: {
                required: true
            },
            reasonsDetails: {
                required: true
            },
            fechaRetiro: {
                required: true
            },
            monto: {
                required: true
            },
            diaEfectivo: {
                required: true
            },
            fechaSolicitud: {
                required: true
            },
            diaAsignado: {
                required: true
            },
            diaSolicitado: {
                required: true
            },
            motivo_cambio: {
                required: true
            },
            inicioHorario: {
                required: true
            },
            motivo_horario: {
                required: true
            }
        },
        errorElement: 'span',
        /*errorClass: 'invalid-feedback',*/
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });


    $(".dayOff").on("change", function() {
        var day = $(this).data("day");
        if ($(this).is(":checked")) {
            console.log(day)
            setScheduleInputs(day, "", "", "", true)
        } else {
            console.log("is not checked")
            setScheduleInputs(day, "", "", "", false)
        }
    });

    $("#addAPButton").click(function(e) {
        e.preventDefault();

        if (addForm.valid()) {
            var changedFields = getChangedFields();
            console.table(changedFields)

            $.ajax({
                url: "<?php echo URLROOT; ?>/aps/saveRequestAP",
                type: "POST",
                data: changedFields,
                success: function(data) {
                    console.log(data)
                    var myObj = JSON.parse(data)
                    if (myObj.status == "success") {
                        swal(myObj.message, {
                            icon: "success",
                            buttons: {
                                confirm: {
                                    className: "btn btn-success",
                                },
                            },
                        }).then((willReload) => {
                            if (willReload) {
                                $(".modal").modal("hide");
                                $('#createApForm')[0].reset();
                                hideAllAndShow("")
                                getdataBody();
                            }
                        });
                    } else {
                        swal('Error', obj.message, {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: "btn btn-danger",
                                },
                            },
                        });
                    }
                }
            })
        }




    });

    $('#createApForm').find('input, select,textarea').each(function() {
        initialState[$(this).attr('name')] = $(this).val();
    });

    // get information for uopdated AP modal
    $(document).on('click', '.updateModal', function() {
        //$("#aprovedByArea").html("")
        var leaveId = $(this).data("leaveid");
        $("#actionspan").text("Update");
        $("#addAPButton").text("Edit").show();
        $("#Action").val("Update");
        $("#apId").val(leaveId);
        console.log(leaveId)
        hideAllAndShow("")

        $.ajax({
            url: "<?Php echo URLROOT; ?>/aps/getleave/" + leaveId,
            type: "GET",
            success: function(data) {
                console.log(data)
                var myObj = JSON.parse(data)
                $("#addbadge").val(myObj.badge);
                $('#addbadge').trigger('keyup');
                $("#addLeaveType").val(myObj.apTypeId);
                var apType = myObj.apTypeId;

                const parser = new DOMParser();
                const htmlString = myObj.comment;
                const decodedText = parser.parseFromString(htmlString, 'text/html').body.textContent;
                $("#addComments").val(decodedText)
                console.log(decodedText);
                console.log(apType)
                switch (apType) {
                    case 7:
                        hideAllAndShow("cambiohorario")
                        //setReasons('motivo_horario', 3, myObj.reason1);
                        $("#motivo_horario").val(myObj.reason1);
                        $("#inicioHorario").val(myObj.apDate1);
                        $("#finHorario").val(myObj.apDate2);
                        getLastSchedule(myObj.scheduleId, "Edit");
                        break;
                }

                if (myObj.active == 2) { // IF its still REQUEST

                    if (myObj.status > 0) { // If its was approved or Reject - NO EDIT (disabled ALL)
                        $('#addAPButton').hide();
                        setTimeout(function() {
                            $('#addLeaveType').prop('disabled', true);
                            document.getElementById("createApForm").querySelectorAll("input, select, textarea,time").forEach(function(element) {
                                element.disabled = true;
                            });
                        }, 200);

                    } else { // Agent CAN EDIT because its a REQUEST and it has not been approved or Reject yet.
                        $('#addAPButton').show();
                        $('#addLeaveType').prop('disabled', false);
                        document.getElementById("createApForm").querySelectorAll("input, select, textarea").forEach(function(element) {
                            element.disabled = false;
                        });
                    }

                } else { // agent CAN'T EDIT because this is NOT REQUEST

                    $('#addAPButton').hide();
                    setTimeout(function() {
                        $('#addLeaveType').prop('disabled', true);
                        document.getElementById("createApForm").querySelectorAll("input, select, textarea,time").forEach(function(element) {
                            element.disabled = true;
                        });
                    }, 200);

                }



            }

        })

    })

    //This button open createModal in order to create a new Leave
    $("#createModal").click(function() {
        $("#aprovedByArea").html("")
        $("#Action").val("Insert");
        $("#actionspan").text("Create Request");
        $("#addAPButton").text("Create Request");
        $('#addLeaveType').prop('disabled', true);
        $('#addLeaveType option').eq(0).prop('selected', true);
        hideAllAndShow("");

        $("#addComments").val("");
        $('#addAPButton').show();


        setTimeout(function() {
            // $('#addLeaveType').prop('disabled', false);
            document.getElementById("createApForm").querySelectorAll("input, select, textarea,time").forEach(function(element) {
                element.disabled = false;
            });
        }, 200);

    })

    $("#addLeaveType").on("change", function() {
        var idLeaveType = $(this).val();
        var employeeId = $("#addEmployeeId").val();
        console.log(idLeaveType)

        switch (idLeaveType) {
            case '1':
                hideAllAndShow("permisoConSinGoce")
                setReasons('motivo_permiso', 1);
                break;
            case '2':
                hideAllAndShow("permisoConSinGoce")
                setReasons('motivo_permiso', 1);
                break;
            case '3':
                hideAllAndShow("vacaciones")
                break;
            case '4':
                hideAllAndShow("traslados")
                setDespartment();
                setPosition('newPosition');
                break;
            case '5':
                hideAllAndShow("incapacidad")
                break;
            case '6':
                hideAllAndShow("sanciones")
                break;
            case '7':
                hideAllAndShow("cambiohorario")
                // setReasons('motivo_horario', 3);
                getLastSchedule(employeeId, "Last");
                break;
            case '8':
                hideAllAndShow("cambiodialibre");
                setReasons('motivo_cambio', 2);
                break;
            case '9':
                hideAllAndShow("ausencia");
                break;
            case '10':
                hideAllAndShow("horasExtra");
                break;
            case '11':
                hideAllAndShow("retiros");
                break;
            case '12':
                hideAllAndShow("ajusteSalarial");
                setPosition('newPosition2');
                break;
            default:
                hideAllAndShow("")
                break;

        }
    });


    function isOffchecked(idelement) {
        var check;
        console.log(idelement)
        if ($('#' + idelement).is(':checked')) {
            $('#' + idelement).val('OFF');
        } else {
            $('#' + idelement).val('ON');
        }
        return check;
    }



    function setScheduleInputs(day, inVal, outVal, lunchVal, checked) {
        if (checked == true) {
            $("#" + day + "In").val("").prop("disabled", true).rules('remove', 'required');
            $("#" + day + "Out").val("").prop("disabled", true).rules('remove', 'required');
            $("#" + day + "Lunch").val("").prop("disabled", true).rules('remove', 'required');
        } else {
            $("#" + day + "In").val(inVal).prop("disabled", false).rules('add', {
                required: true
            });
            $("#" + day + "Out").val(outVal).prop("disabled", false).rules('add', {
                required: true
            });
            $("#" + day + "Lunch").val(lunchVal).prop("disabled", false).rules('add', {
                required: true
            });
        }
    }

    function getLastSchedule(id, type) {
        //console.log(employeeId)
        $.ajax({
            url: "<?php echo URLROOT; ?>/aps/getEmployeeSchedule/" + id + "/" + type,
            method: "GET",
            success: function(data) {
                //console.log(data)
                myObj = JSON.parse(data)
                console.table(myObj)
                const daysObj = myObj.days.split('');
                let start, end;
                //console.log(daysObj)
                $("#scheduleId").val("")
                $("#scheduleId").val(myObj.scheduleId)
                daysObj.forEach(function(day, index) {
                    //console.log(day)
                    switch (index) {
                        case 0:
                            if (myObj.monday == "-OFF-") {
                                $("#mondayOff").prop("checked", true).trigger("change");
                                //$("#mondayIn").val("").prop("disabled",true);
                                //$("#mondayOut").val("").prop("disabled",true);
                                //$("#mondayLunch").val("").prop("disabled",true);
                                setScheduleInputs("monday", "", "", "", true)
                            } else {
                                [start, end] = myObj.monday.split(' - ');
                                $("#mondayOff").prop("checked", false)
                                // $("#mondayIn").val(start).prop("disabled",false);
                                // $("#mondayOut").val(end).prop("disabled",false);
                                // $("#mondayLunch").val(myObj.mondayLunch).prop("disabled",false);
                                setScheduleInputs("monday", start, end, myObj.mondayLunch, false)
                            }
                            start = "";
                            end = "";
                            break;
                        case 1:
                            if (myObj.tuesday == "-OFF-") {
                                $("#tuesdayOff").prop("checked", true).trigger("change");
                                // $("#tuesdayIn").val("").prop("disabled",true);
                                // $("#tuesdayOut").val("").prop("disabled",true);
                                // $("#tuesdayLunch").val("").prop("disabled",true);
                                setScheduleInputs("tuesday", "", "", "", true)
                            } else {
                                [start, end] = myObj.tuesday.split(' - ');
                                //.log("tuesday:"+start+"-"+end)
                                $("#tuesdayOff").prop("checked", false)
                                // $("#tuesdayIn").val(start).prop("disabled",false);
                                // $("#tuesdayOut").val(end).prop("disabled",false);
                                // $("#tuesdayLunch").val(myObj.tuesdayLunch).prop("disabled",false);
                                setScheduleInputs("tuesday", start, end, myObj.tuesdayLunch, false)
                            }
                            start = "";
                            end = ""
                            break;
                        case 2:
                            if (myObj.wednesday == "-OFF-") {
                                $("#wednesdayOff").prop("checked", true).trigger("change");
                                // $("#wednesdayIn").val("").prop("disabled",true);
                                // $("#wednesdayOut").val("").prop("disabled",true);
                                // $("#wednesdayLunch").val("").prop("disabled",true);
                                setScheduleInputs("wednesday", "", "", "", true)

                            } else {
                                [start, end] = myObj.wednesday.split(' - ');
                                $("#wednesdayOff").prop("checked", false)
                                // $("#wednesdayIn").val(start).prop("disabled",false);
                                // $("#wednesdayOut").val(end).prop("disabled",false);
                                // $("#wednesdayLunch").val(myObj.wednesdayLunch).prop("disabled",false);
                                setScheduleInputs("wednesday", start, end, myObj.wednesdayLunch, false)
                            }
                            start = "";
                            end = ""
                            break;
                        case 3:
                            if (myObj.thursday == "-OFF-") {
                                $("#thursdayOff").prop("checked", true).trigger("change");
                                // $("#thursdayIn").val("").prop("disabled",true);
                                // $("#thursdayOut").val("").prop("disabled",true);
                                // $("#thursdayLunch").val("").prop("disabled",true);
                                setScheduleInputs("thursday", "", "", "", true)

                            } else {
                                [start, end] = myObj.thursday.split(' - ');
                                $("#thursdayOff").prop("checked", false)
                                // $("#thursdayIn").val(start).prop("disabled",false);
                                // $("#thursdayOut").val(end).prop("disabled",false);
                                // $("#thursdayLunch").val(myObj.thursdayLunch).prop("disabled",false);
                                setScheduleInputs("thursday", start, end, myObj.thursdayLunch, false)
                            }
                            start = "";
                            end = ""
                            break;
                        case 4:
                            if (myObj.friday == "-OFF-") {
                                $("#fridayOff").prop("checked", true).trigger("change");
                                // $("#fridayIn").val("").prop("disabled",true);
                                // $("#fridayOut").val("").prop("disabled",true);
                                // $("#fridayLunch").val("").prop("disabled",true);
                                setScheduleInputs("friday", "", "", "", true)

                            } else {
                                [start, end] = myObj.friday.split(' - ');
                                $("#fridayOff").prop("checked", false)
                                // $("#fridayIn").val(start).prop("disabled",false);
                                // $("#fridayOut").val(end).prop("disabled",false);
                                // $("#fridayLunch").val(myObj.fridayLunch).prop("disabled",false);
                                setScheduleInputs("friday", start, end, myObj.fridayLunch, false)
                            }
                            start = "";
                            end = ""
                            break;
                        case 5:
                            if (myObj.saturday == "-OFF-") {
                                $("#saturdayOff").prop("checked", true).trigger("change");
                                // $("#saturdayIn").val("").prop("disabled",true);
                                // $("#saturdayOut").val("").prop("disabled",true);
                                // $("#saturdayLunch").val("").prop("disabled",true);
                                setScheduleInputs("saturday", "", "", "", true)

                            } else {
                                [start, end] = myObj.saturday.split(' - ');
                                $("#saturdayOff").prop("checked", false)
                                // $("#saturdayIn").val(start).prop("disabled",false);
                                // $("#saturdayOut").val(end).prop("disabled",false);
                                // $("#saturdayLunch").val(myObj.saturdayLunch).prop("disabled",false);
                                setScheduleInputs("saturday", start, end, myObj.saturdayLunch, false)
                            }
                            start = "";
                            end = ""
                            break;
                        case 6:
                            if (myObj.sunday == "-OFF-") {
                                $("#sundayOff").prop("checked", true).trigger("change");
                                // $("#sundayIn").val("").prop("disabled",true);
                                // $("#sundayOut").val("").prop("disabled",true);
                                // $("#sundayLunch").val("").prop("disabled",true);
                                setScheduleInputs("sunday", "", "", "", true)

                            } else {
                                [start, end] = myObj.sunday.split(' - ');
                                $("#sundayOff").prop("checked", false)
                                // $("#sundayIn").val(start).prop("disabled",false);
                                // $("#sundayOut").val(end).prop("disabled",false);
                                // $("#sundayLunch").val(myObj.sundayLunch).prop("disabled",false);
                                setScheduleInputs("sunday", start, end, myObj.sundayLunch, false)
                            }
                            start = "";
                            end = ""
                            break;
                    }

                })
                // if (myObj.msg == "error") {
                //   $("#badgeDiv").addClass("has-error");
                //   $("#msgArea").html("<label><small>Record Not Found!</small></label>");
                //   $('#addLeaveType').prop('disabled', true);
                // } else {
                //   $("#badgeDiv").removeClass("has-error");
                //   $("#msgArea").html("")
                //   $("#addName").val(myObj.fullname);
                //   $("#addPosition").val(myObj.positionName);
                //   $("#addDepartment").val(myObj.departmentName)
                //   $("#addEmployeeId").val(myObj.employeeId)
                //   $("#currentPosition").val(myObj.positionId)
                //   $("#currentDepartment").val(myObj.departmentId);
                //   $('#addLeaveType').prop('disabled', false);
                // }
            }
        })
    }

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

                        console.log("statusss" + item.status);
                        console.log("active" + item.active);

                        const statusMap = {

                            0: {
                                class: "warning",
                                text: "Pending"
                            },
                            1: {
                                class: "success",
                                text: "Approved"
                            },
                            2: {
                                class: "danger",
                                text: "Reject"
                            },
                            3: {
                                class: "secondary",
                                text: "Cancel"
                            },
                        };

                        if (item.active == 1) {

                            var statusInfo = {
                                class: "success",
                                text: "Approved"
                            };

                        } else if (item.active == 2) {

                            var statusInfo = statusMap[item.aprovedByWf] || {
                                class: "warning",
                                text: "Pending"
                            };

                        }

                        var row = `<tr>
                        <td>${rowNumber}</td>
                        <td>${ item.apDetailsId }</td>
                        <td>${ formattDate }</td>
                        <td>${ item.name }</td>
                        <td><span class="badge badge-${statusInfo.class}">${statusInfo.text}</span></td>
                        <td>`;

                        if (item.active == 2) { // If its still REQUEST

                            if (item.status > 0) { // if its was approved or reject - No EDIT
                                row += ` <button type="button" onclick="GetInformationPersonal(${ item.apDetailsId })" data-bs-toggle="modal" data-bs-target="#edit-user" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button>`;
                            } else { // Agent can EDIT because its a REQUEST and it has not been approved or rejected yet.
                                row += `<button type="button" class="btn btn-sm btn-primary updateModal" data-bs-toggle="modal" data-bs-target="#addRowModal" data-leaveId="${item.apDetailsId}">
                                    <i class="fa fa-edit"></i>
                                    </button>`;
                            }
                        } else { // agent CAN'T EDIT because this is not a REQUEST
                            row += ` <button type="button" onclick="GetInformationPersonal(${ item.apDetailsId })" data-bs-toggle="modal" data-bs-target="#edit-user" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button>`;
                        }

                        row += `</td>
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

                            hideAllAndShow('permisoConSinGoceView')

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
                            hideAllAndShow('incapacidadView')
                            $("#FechaInicioInca").val(datarecord.apDate1);
                            $("#fechaFinalInca").val(datarecord.apDate2);
                            $("#tipoIncapacidad").val(datarecord.reason1);
                            $("#prorroga").val(datarecord.reason2);

                            break;
                        case 6:
                            hideAllAndShow('SancionesDisciplinarias')
                            $("#tipoAmonestacion").val(datarecord.reason1);
                            $("#fechaAmonestacion").val(datarecord.apDate1);
                            $("#inicioSuspesion").val(datarecord.apDate1);
                            $("#finSuspesion").val(datarecord.apDate2);
                            $(".suspensionFecha").hide();
                            if (datarecord.reason1 == 'Suspension') {
                                $(".suspensionFecha").show();
                            }

                            break;
                        case 7:
                            hideAllAndShow('cambioHorarioView')
                            var dataSchedule = obj.dataScheduleLast
                            console.log(dataSchedule)

                            $("#FechaInicioHorario").val(datarecord.apDate1);
                            $("#fechaFinalHorario").val(datarecord.apDate2);
                            $("#motivoCambioHorario").val(datarecord.reason1);
                            $("#daysHorario").html(dataSchedule.days);
                            $("#daysOffHorario").html(dataSchedule.daysOff);

                            let tabla = document.getElementById("tblHorarioLast").getElementsByTagName("tbody")[0];
                            tabla.innerHTML = ""; // Esto borra todas las filas actuales
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
                            hideAllAndShow('cambioDiaLibreView')
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
                            hideAllAndShow('horasExtrasView')
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
                            hideAllAndShow('ajusteSalarialView')
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

    function setReasons(element, type, option = null) {
        $.ajax({
            url: '<?php echo URLROOT; ?>/aps/getreasons/' + type,
            type: 'GET',
            success: function(data) {
                //console.table(data)
                var reasonObj = JSON.parse(data)
                var $dropdown = $("#" + element);
                $dropdown.empty();

                $dropdown.append($("<option />").val('').text('--Seleccione--'));
                $.each(reasonObj, function(key, val) {

                    //if(val.id_reason_attrition==attrition_reason){
                    //							$dropdown.append($("<option value='"+val.id_reason_attrition+"' selected>"+val.name+"</option>"));
                    //						}else{
                    $dropdown.append($("<option />").val(val.description).text(val.description));
                    //}
                });
                if (option) {
                    $("#" + element).val(option)
                }
            }
        })
    }

    // AP create
    function getChangedFields() {
        var changedFields = {};
        $('#createApForm').find('input,select,textarea').each(function() {
            var name = $(this).attr('name');
            var currentValue = $(this).val();
            console.log(currentValue)
            if (currentValue !== initialState[name]) {
                changedFields[name] = currentValue;
            }
        });
        return changedFields;
    }

    // // --------------------------------------------------------------------

    $(".searchDataChange").change(function() {
        getdataBody();
    });
    $(".searchDataClick").click(function() {
        getdataBody();
    });
</script>