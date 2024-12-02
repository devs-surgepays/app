<?php require APPROOT . '/views/inc/header.php'; ?>
<style>
.list-inline{
  list-style-type: none; /* Remove bullets */
}
.list-inline li {
  display: inline-block;
}
</style>
<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Manage Leaves</h4>
              <button id="createModal" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">
                <i class="fa fa-plus"></i>
                Create New Leave
              </button>
            </div>
          </div>
          <div class="card-body">
          
            <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title">
                      <span class="fw-mediumbold"> Leave</span>
                      <span class="fw-light"> Approval </span>
                      </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="#" id="approveForm" method="POST" enctype>
                  <div class="modal-body">
                  <p class="small">Give your approval feedback for this Leave</p>
                  <p>Leave #: <span id="showId"></span></p>
                    <ul class="list-inline text-center">
                      <li>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="approval" id="apApproved" value="1">
                          <label class="form-check-label" for="apApproved">
                          <span class="badge text-bg-success"><i class="fa fa-check"></i> Approve</span>
                          </label>
                        </div>
                      </li>
                      <li>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="approval" id="apReject" value="2">
                          <label class="form-check-label" for="apReject">
                          <span class="badge text-bg-danger"><i class="fa fa-times"></i> Reject</span>
                          </label>
                        </div>
                      </li>
                      <li>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="approval" id="apCancel" value="3">
                          <label class="form-check-label" for="apCancel">
                          <span class="badge text-bg-secondary"><i class="fa fa-ban"></i> Cancel</span>
                          </label>
                        </div>
                      </li>
                    </ul>
                    <label id="approval-error" class="error" for="approval"></label>
                      <?php //echo $_SESSION['permissionLevelId']; ?> 
                  </div>
                  <div class="modal-footer border-0">
                    <button type="submit" id="saveApApproval" class="btn btn-primary">
                      Save
                    </button>
                    <button type="button" class="btn btn-danger closeModal" data-dismiss="modal">
                      Close
                    </button>
                  </div>
                  <input type="hidden" id="leave_id" name="leave_id">
                  
                  </form>
                </div>
              </div>
            </div>
            <!--Add Modal -->
            <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title">
                      <span class="fw-mediumbold" id="actionspan"> Create</span>
                      <span class="fw-light"> Leave </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
					        <form id="createApForm" action="index.php" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <div id="badgeDiv" class="form-floating  form-floating-custom mb-3">
                            <input id="addbadge" name="addbadge" type="text" class="form-control" placeholder="Badge" onkeyup="getData()" />
                            <label for="addbadge">Badge</label>
                            <div id="msgArea"></div>
                          </div>
                        </div>
                        <div class="col-sm-12">
                          <div class="form-floating form-floating-custom mb-3">

                            <input id="addName" name="addName" type="text" class="form-control" placeholder="fill name" readonly />
                            <label>Name</label>
                          </div>
                        </div>
                        <div class="col-md-6 pe-0">
                          <div class="form-floating form-floating-custom mb-3">

                            <input id="addPosition" name="addPosition" type="text" class="form-control" placeholder="fill position" readonly />
                            <label>Position</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating form-floating-custom mb-3">

                            <input id="addDepartment" name="addDepartment"  type="text" class="form-control" placeholder="fill department" readonly />
                            <label>Department</label>
                          </div>
                        </div>
                        <div class="col-sm-12">
                          <div class="form-floating form-floating-custom mb-3">

                            <select class="form-select" id="addLeaveType" name="addLeaveType">
                              <option value="">Select...</option>
                              <?php
                              foreach ($data['apTypes'] as $items) {
                                echo "<option value='" . $items['apTypeId'] . "'>" . $items['name'] . "</option>";
                              }
                              ?>
                            </select>
                            <label>Leave type</label>
                          </div>
                        </div>
                        <!-- change Area -->
                         <!-- PERMISO CON GOCE / PERMISO SIN GOCE -->
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
                        </div>
                              <!-- SOLICITUD DE VACAIONES -->
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
                               </div>
                            <!-- TRASLADO CAMBIO DE PUESTO -->
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
                             </div>
                             <!-- INCAPACIDAD -->
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
                                    <input class="form-check-input" type="radio" name="tipoIncapacidad" id="isss" value="ISSS">
                                    <label class="form-check-label" for="isss">
                                      Seguro Social
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipoIncapacidad" id="asesuisa" value="ASESUISA">
                                    <label class="form-check-label" for="asesuisa">
                                    ASESUISA
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipoIncapacidad" id="particular" value="Particular">
                                    <label class="form-check-label" for="particular">
                                      Particular
                                    </label>
                                  </div>
                                  
                                </div>
                                <div class="form-check"><input type="checkbox" id="prorroga" name="prorroga" value="No" onclick="ischecked('prorroga')" class="form-check-input"><label for="prorroga">Prorroga</label></div>
                                </div>
                             </div>
                             <!-- Sanciones Disciplinarias -->
                             <div id="sanciones" class="toggleable">
                             <div class="d-flex">
                                  <div class="form-check">
                                    <input class="form-check-input tipoSus" type="radio" name="tipoSancion" id="sancionVerbal" value="Verbal">
                                    <label class="form-check-label" for="sancionVerbal">
                                      Verbal
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input tipoSus" type="radio" name="tipoSancion" id="sancionEscrita" value="Escrita">
                                    <label class="form-check-label" for="sancionEscrita">
                                      Escrita
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input tipoSus" type="radio" name="tipoSancion" id="suspension" value="Suspension">
                                    <label class="form-check-label" for="suspension">
                                      Suspensón
                                    </label>
                                  </div>
                                </div>

                                <!-- <div class="d-flex">
                                  
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="septimo" id="septimo" onclick="ischecked('septimo')">
                                    <label class="form-check-label" for="septimo">
                                      Descuento de septimo
                                    </label>
                                  </div>
                                </div> -->
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
                            <div id="cambiohorario" class="toggleable">
                              <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="inicioHorario" id="inicioHorario">
                                    <label>Fecha Inicio</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="date" placeholder="Dia" name="finHorario" id="finHorario">
                                    <label>Fecha Fin</label>
                                    </div>
                                </div>

                                <div class="col-sm-12">
										<div class="form-floating form-floating-custom mb-3">	
											<select class="form-select" name="motivo_horario" id="motivo_horario"></select>
									<label for="motivo_horario"> Motivo Cambio de Horario: </label>
									</div>								
								</div>

                                <!-- <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">
                                      <select class="form-select" name="tipohorario" id="tipohorario">
                                        <option value="Normal">Normal</option>
                                        <option value="Hibrido">Hibrido</option>
                                      </select>
                                      <label for="tipohorario"> Tipo de Horario: </label>
                                    </div>
                                </div> -->
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
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('thursdayOff')" data-day="thursday"  type="checkbox" id="thursdayOff" name="thursdayOff"></td>
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
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('fridayOff')" data-day="friday"  type="checkbox" id="fridayOff" name="fridayOff"></td>
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
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('saturdayOff')" data-day="saturday"  type="checkbox" id="saturdayOff" name="saturdayOff"></td>
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
                                            <td><input class="form-check dayOff" value="ON" onChange="isOffchecked('sundayOff')" data-day="sunday"  type="checkbox" id="sundayOff" name="sundayOff"></td>
                                          </tr>
                                        <tbody>

                                        </tbody>
                                    </table>
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
                                    <input class="form-control" type="time" name="inicioOt" id="inicioOt" onchange="getTotalOT()"s>
                                    <label>Inicio</label>
                                    </div>
                                </div>
							  <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">
                                    <input class="form-control" type="time" name="finOt" id="finOt" onchange="getTotalOT()"s>
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
									<label for="monto">Tipo de Retiro</label>
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
								  	<input type="text" class="form-control money2" name="monto" id="monto" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$">
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
						  </div>
                        <!-- end chnage Area-->
                        <div class="col-sm-12">
                          <div class="form-floating form-floating-custom mb-3">
                            <textarea name="addComments" id="addComments" class="form-control" placeholder="Comments" row="5"></textarea>
                            <label for="addComments">Comments</label>
                          </div>
                        </div>

                      </div>
                      <input type="hidden" id="addEmployeeId" name="addEmployeeId">
                      <input type="hidden" id="idApType" name="idApType">
                    
                  </div>
                  <div class="modal-footer border-0">
                    <button type="submit" id="addAPButton" class="btn btn-primary">
                      Add
                    </button>
                    <button type="button" class="btn btn-danger closeModal" data-dismiss="modal">
                      Close
                    </button>
                  </div>
                  <input type="hidden" id="Action" name="Action">
                  <input type="hidden" id="apId" name="apId">
                  <input type="hidden" id="scheduleId" name="scheduleId">
					  </form>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table id="add-row" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Leave #</th>
                    <th>Employee Name</th>
                    <th>Badge</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Leave Type</th>
                    <th>By M</th>
                    <th>By HR</th>
                    <th>By WF</th>
                    <th>By Sup</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input id="searchFullname" type="text" class="form-control grid-filter"></td>
                    <td><input id="searchBadge" type="text" class="form-control grid-filter"></td>
                    <td><input id="searchCreatedAt" type="text" class="form-control grid-filter"></td>
                    <td><input id="searchCreatedBy" type="text" class="form-control grid-filter"></td>
                    <td>
                      <select id="searchLeaveType" type="text" class="form-control grid-filter">
                      <option value="">Select...</option>
                              <?php
                              foreach ($data['apTypes'] as $items) {
                                echo "<option value='" . $items['apTypeId'] . "'>" . $items['name'] . "</option>";
                              }
                              ?>
                      </select>
                    </td>
                    <td>
                      <select id="searchByM" type="text" class="form-control grid-filter">
                        <option value="">Select...</option>
                        <option value="0">Pending</option>
                        <option value="1">Approved</option>
                        <option value="3">Rejected</option>
                      </select>
                    </td>
                    <td>
                      <select id="searchByHR" type="text" class="form-control grid-filter">
                        <option value="">Select...</option>
                        <option value="0">Pending</option>
                        <option value="1">Approved</option>
                        <option value="3">Rejected</option>
                      </select>
                    </td>
                    <td>
                      <select id="searchByWF" type="text" class="form-control grid-filter">
                        <option value="">Select...</option>
                        <option value="0">Pending</option>
                        <option value="1">Approved</option>
                        <option value="3">Rejected</option>
                      </select>
                    </td>
                    <td>
                      <select id="searchBySup" type="text" class="form-control grid-filter">
                        <option value="">Select...</option>
                        <option value="0">Pending</option>
                        <option value="1">Approved</option>
                        <option value="3">Rejected</option>
                      </select>
                    </td>
                    <td style="text-align:center;">
                    <img style="cursor: pointer;" onclick="resetform()" src="<?Php echo URLROOT; ?>/assets/img/clear-filter.png" width="25" height="25">
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




<script>
  //This button open createModal in order to create a new Leave
$("#createModal").click(function(){
  $("#Action").val("Insert");
  $("#actionspan").text("Create");
  $("#addAPButton").text("Create");
  $('#addLeaveType').prop('disabled', true);
})

//This function help to reset each filter of the grid 
function resetform(){
  $(".grid-filter").val("");
  $('#searchCreatedAt').daterangepicker({
      opens: 'left'
    // }, function(start, end, label) {
    //   console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    // });
  });
}

//this action get all changed fields 
$(".grid-filter").on("change",function(){
  $('#add-row').find('input, select,textarea').each(function() {
            initialState[$(this).attr('name')] = $(this).val();
        });
        console.table(initialState)
})

  $(function() {
    $('#searchCreatedAt').daterangepicker({
      opens: 'left'
    // }, function(start, end, label) {
    //   console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    // });
  });
});

  $('.money2').mask("#,##0.00", {reverse: true});
	const addForm = $("#createApForm")
  const approveForm = $("#approveForm")
	const initialState = {};
  $(document).ready(function() {

    setleaveTime()
    hideAllAndShow("")
    var nowhere = camposValue();
    var example_length = 10;
    var camposAscDesc = "";
	  var	firstload='YES';
		readData(1,nowhere,example_length,camposAscDesc,firstload);

    $("#addRowButton").click(function() {
      // $("#add-row")
      //   .dataTable()
      //   .fnAddData([
      //     $("#addName").val(),
      //     $("#addPosition").val(),
      //     $("#addOffice").val(),
      //     action,
      //   ]);
      $("#addRowModal").modal("hide");
    });

    $(".btn").click(function() {
      if ($(this).data('dismiss') == "modal") {
        $(".modal").modal("hide");
        $('#createApForm')[0].reset();
        $('#approveForm')[0].reset();
        $("#approval-error").html('');
        $("#Action").val('');
		    hideAllAndShow("")
      }

    });

    $(".close").click(function() {
      $(".modal").modal("hide");
      $('#createApForm')[0].reset();
      $('#approveForm')[0].reset();
      $("#approval-error").html('');
    });
	  
	  
	  
        $('#createApForm').find('input, select,textarea').each(function() {
            initialState[$(this).attr('name')] = $(this).val();
        });
        //console.table(initialState)
	  
	
	    
  });
	
$(".tipoSus").on('change',function(){
  if($(this).is(":checked")){
    if($(this).val()=="Suspension"){
      //console.log("suspension");
      $("#diasSuspension").show()
    }else{
      $("#diasSuspension").hide()
    }
  }
})

  function getData() {
    var badge = $("#addbadge").val();
    
    //console.log(badge)
	  
    $.ajax({
      url: "<?php echo URLROOT; ?>/aps/getEmployeeInfo/" + badge,
      method: "GET",
      success: function(data) {
        //console.log(data)
        myObj = JSON.parse(data)
        if (myObj.msg == "error") {
          $("#badgeDiv").addClass("has-error");
          $("#msgArea").html("<label><small>Record Not Found!</small></label>");
          $('#addLeaveType').prop('disabled', true);
          hideAllAndShow("");
        } else {
          $("#badgeDiv").removeClass("has-error");
          $("#msgArea").html("")
          $("#addName").val(myObj.fullname);
          $("#addPosition").val(myObj.positionName);
          $("#addDepartment").val(myObj.departmentName)
          $("#addEmployeeId").val(myObj.employeeId)
          $("#currentPosition").val(myObj.positionId)
          $("#currentDepartment").val(myObj.departmentId);
          $('#addLeaveType').prop('disabled', false);
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

function getLastSchedule(id,type){
  //console.log(employeeId)
  $.ajax({
      url: "<?php echo URLROOT; ?>/aps/getEmployeeSchedule/" + id+"/"+type,
      method: "GET",
      success: function(data) {
        //console.log(data)
        myObj = JSON.parse(data)
        console.table(myObj)
        const daysObj = myObj.days.split('');
        let start,end;
        //console.log(daysObj)
        $("#scheduleId").val("")
        $("#scheduleId").val(myObj.scheduleId)
        daysObj.forEach(function(day,index){
          //console.log(day)
          switch(index){
            case 0:
              if(myObj.monday=="-OFF-"){
                $("#mondayOff").prop("checked",true).trigger("change");
                //$("#mondayIn").val("").prop("disabled",true);
                //$("#mondayOut").val("").prop("disabled",true);
                //$("#mondayLunch").val("").prop("disabled",true);
                setScheduleInputs("monday","","","",true)
              }else{
                [start, end] = myObj.monday.split(' - ');
                $("#mondayOff").prop("checked",false)
                // $("#mondayIn").val(start).prop("disabled",false);
                // $("#mondayOut").val(end).prop("disabled",false);
                // $("#mondayLunch").val(myObj.mondayLunch).prop("disabled",false);
                setScheduleInputs("monday",start,end,myObj.mondayLunch,false)
              }
              start="";
              end="";
              break;
            case 1:
              if(myObj.tuesday=="-OFF-"){
                $("#tuesdayOff").prop("checked",true).trigger("change");
                // $("#tuesdayIn").val("").prop("disabled",true);
                // $("#tuesdayOut").val("").prop("disabled",true);
                // $("#tuesdayLunch").val("").prop("disabled",true);
                setScheduleInputs("tuesday","","","",true)
              }else{
                [start, end] = myObj.tuesday.split(' - ');
                //.log("tuesday:"+start+"-"+end)
                $("#tuesdayOff").prop("checked",false)
                // $("#tuesdayIn").val(start).prop("disabled",false);
                // $("#tuesdayOut").val(end).prop("disabled",false);
                // $("#tuesdayLunch").val(myObj.tuesdayLunch).prop("disabled",false);
                setScheduleInputs("tuesday",start,end,myObj.tuesdayLunch,false)
              }
              start="";
              end=""
              break;
            case 2:
              if(myObj.wednesday=="-OFF-"){
                $("#wednesdayOff").prop("checked",true).trigger("change");
                // $("#wednesdayIn").val("").prop("disabled",true);
                // $("#wednesdayOut").val("").prop("disabled",true);
                // $("#wednesdayLunch").val("").prop("disabled",true);
                setScheduleInputs("wednesday","","","",true)

              }else{
                [start, end] = myObj.wednesday.split(' - ');
                $("#wednesdayOff").prop("checked",false)
                // $("#wednesdayIn").val(start).prop("disabled",false);
                // $("#wednesdayOut").val(end).prop("disabled",false);
                // $("#wednesdayLunch").val(myObj.wednesdayLunch).prop("disabled",false);
                setScheduleInputs("wednesday",start,end,myObj.wednesdayLunch,false)
              }
              start="";
              end=""
              break;
            case 3:
              if(myObj.thursday=="-OFF-"){
                $("#thursdayOff").prop("checked",true).trigger("change");
                // $("#thursdayIn").val("").prop("disabled",true);
                // $("#thursdayOut").val("").prop("disabled",true);
                // $("#thursdayLunch").val("").prop("disabled",true);
                setScheduleInputs("thursday","","","",true)

              }else{
                [start, end] = myObj.thursday.split(' - ');
                $("#thursdayOff").prop("checked",false)
                // $("#thursdayIn").val(start).prop("disabled",false);
                // $("#thursdayOut").val(end).prop("disabled",false);
                // $("#thursdayLunch").val(myObj.thursdayLunch).prop("disabled",false);
                setScheduleInputs("thursday",start,end,myObj.thursdayLunch,false)
              }
              start="";
              end=""
              break;
            case 4:
              if(myObj.friday=="-OFF-"){
                $("#fridayOff").prop("checked",true).trigger("change");
                // $("#fridayIn").val("").prop("disabled",true);
                // $("#fridayOut").val("").prop("disabled",true);
                // $("#fridayLunch").val("").prop("disabled",true);
                setScheduleInputs("friday","","","",true)

              }else{
                [start, end] = myObj.friday.split(' - ');
                $("#fridayOff").prop("checked",false)
                // $("#fridayIn").val(start).prop("disabled",false);
                // $("#fridayOut").val(end).prop("disabled",false);
                // $("#fridayLunch").val(myObj.fridayLunch).prop("disabled",false);
                setScheduleInputs("friday",start,end,myObj.fridayLunch,false)
              }
              start="";
              end=""
              break;
            case 5:
              if(myObj.saturday=="-OFF-"){
                $("#saturdayOff").prop("checked",true).trigger("change");
                // $("#saturdayIn").val("").prop("disabled",true);
                // $("#saturdayOut").val("").prop("disabled",true);
                // $("#saturdayLunch").val("").prop("disabled",true);
                setScheduleInputs("saturday","","","",true)

              }else{
                [start, end] = myObj.saturday.split(' - ');
                $("#saturdayOff").prop("checked",false)
                // $("#saturdayIn").val(start).prop("disabled",false);
                // $("#saturdayOut").val(end).prop("disabled",false);
                // $("#saturdayLunch").val(myObj.saturdayLunch).prop("disabled",false);
                setScheduleInputs("saturday",start,end,myObj.saturdayLunch,false)
              }
              start="";
              end=""
              break;
            case 6:
              if(myObj.sunday=="-OFF-"){
                $("#sundayOff").prop("checked",true).trigger("change");
                // $("#sundayIn").val("").prop("disabled",true);
                // $("#sundayOut").val("").prop("disabled",true);
                // $("#sundayLunch").val("").prop("disabled",true);
                setScheduleInputs("sunday","","","",true)

              }else{
                [start, end] = myObj.sunday.split(' - ');
                $("#sundayOff").prop("checked",false)
                // $("#sundayIn").val(start).prop("disabled",false);
                // $("#sundayOut").val(end).prop("disabled",false);
                // $("#sundayLunch").val(myObj.sundayLunch).prop("disabled",false);
                setScheduleInputs("sunday",start,end,myObj.sundayLunch,false)
              }
              start="";
              end=""
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

function showSetLeaveAreas(idLeaveType){
  switch(idLeaveType){
      case '1':
          hideAllAndShow("permisoConSinGoce") 
          setReasons('motivo_permiso',1);
        break;
      case '2':
        hideAllAndShow("permisoConSinGoce")
        setReasons('motivo_permiso',1);
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
        setReasons('motivo_horario',3);
        console.log("Cambio de Horario")
        break;
      case '8':
        hideAllAndShow("cambiodialibre");
        setReasons('motivo_cambio',2);
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
}

  $("#addLeaveType").on("change",function(){
    //$('#createApForm')[0].reset();
    var idLeaveType = $(this).val();
    var employeeId = $("#addEmployeeId").val();
    console.log(idLeaveType)
    switch(idLeaveType){
      case '1':
          hideAllAndShow("permisoConSinGoce") 
          setReasons('motivo_permiso',1);
        break;
      case '2':
        hideAllAndShow("permisoConSinGoce")
        setReasons('motivo_permiso',1);
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
          setReasons('motivo_horario',3);
          getLastSchedule(employeeId,"Last");    
        break;
      case '8':
        hideAllAndShow("cambiodialibre");
        setReasons('motivo_cambio',2);
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
  })


  function setleaveTime(){
    var leaveTime = $("#tiempopermiso").val()
    //console.log(leaveTime)
    if(leaveTime=="Horas"){
      $("#dia2").val('')
      $("#horas").show();
      $("#dias").hide()
    }else{
      $("#hora_inicio").val('');
      $("#hora_final").val('');
      $("#horas").hide();
      $("#dias").show()
    }
  }

  function setReasons(element,type,option=null){
    $.ajax({
      url:'<?php echo URLROOT; ?>/aps/getreasons/'+type,
      type:'GET',
      success:function(data){
        //console.table(data)
        var reasonObj = JSON.parse(data)
        var $dropdown = $("#"+element);
						$dropdown.empty();
						
						$dropdown.append($("<option />").val('').text('--Seleccione--'));
					$.each(reasonObj, function(key,val) {
						
						//if(val.id_reason_attrition==attrition_reason){
//							$dropdown.append($("<option value='"+val.id_reason_attrition+"' selected>"+val.name+"</option>"));
//						}else{
							$dropdown.append($("<option />").val(val.description).text(val.description));
						//}
					});
          if (option){
            $("#"+element).val(option)
          }
      }
    })
  }
	
  function setDespartment(option=null){
    $.ajax({
      url:'<?php echo URLROOT; ?>/aps/getdepartments',
      type:'GET',
      success:function(data){
        //console.table(data)
        var dptosObj = JSON.parse(data)
        var $dropdown = $("#newDepartment");
						$dropdown.empty();
						
						$dropdown.append($("<option />").val('').text('--Seleccione--'));
					$.each(dptosObj, function(key,val) {
						
						//if(val.id_reason_attrition==attrition_reason){
//							$dropdown.append($("<option value='"+val.id_reason_attrition+"' selected>"+val.name+"</option>"));
//						}else{
							$dropdown.append($("<option />").val(val.departmentId).text(val.name));
						//}
					});
          if(option){
            $("#newDepartment").val(option);
          }
      }
    })
  }

  function setPosition(id,option=null){
    $.ajax({
      url:'<?php echo URLROOT; ?>/aps/getpositions',
      type:'GET',
      success:function(data){
        //console.table(data)
        var positionObj = JSON.parse(data)
        var $dropdown = $("#"+id);
						$dropdown.empty();
						
						$dropdown.append($("<option />").val('').text('--Seleccione--'));
					$.each(positionObj, function(key,val) {
						
						//if(val.id_reason_attrition==attrition_reason){
//							$dropdown.append($("<option value='"+val.id_reason_attrition+"' selected>"+val.name+"</option>"));
//						}else{
							$dropdown.append($("<option />").val(val.positionId).text(val.positionName));
						//}
					});
          if(option){
            $("#"+id).val(option)
          }
      }
    })
  }

$("#tipoRetiro").on('change',function(){
	showAttritionReasons('reasonType');
});	
	$("#attritions").on('change',function(){ 
	showAttritionReasons('reasonsDetail');
});

function attitionReasons(myvar){
	//console.log(myvar[0]);
	var reasonType = myvar[0].attrition_type;
	var attrition_reason = myvar[0].attrition_reason;
	var reasonDetail = myvar[0].attrition_reason_detail;
		$.ajax({
		url: 'ajax_funciones/ajax_attrition.php',
                type: 'post',
                data: {reasonType:reasonType,step:'reasonType'},
                success:function(response){
					var reasonObj = JSON.parse(response);
					console.log(reasonObj);
					if(reasonObj.length>0){
						$("#attritionReasons").show();
						$("#reasonDetail_div").hide();
					var $dropdown = $("#attritions");
						$dropdown.empty();
						console.log('creando select');
						$dropdown.append($("<option />").val('').text('--Seleccione--'));
					$.each(reasonObj, function(key,val) {
							$dropdown.append($("<option />").val(val.id_reason_attrition).text(val.name));
					});
						
						$dropdown.val(attrition_reason);
					}else{
						$("#attritionReasons").hide();
						$("#reasonDetail_div").hide();
					}
				}
	})
	//console.log(reasonDetail);
	if(reasonDetail){
		$.ajax({
			url: 'ajax_funciones/ajax_attrition.php',
                type: 'post',
                data: {id_reasonType:attrition_reason,step:'reasonsDetail'},
                success:function(response){
					var detailsObj = JSON.parse(response);
					console.log(detailsObj);
					if(detailsObj.length>0){
						$("#reasonDetail_div").show();
					var $dropdown = $("#reasonsDetails");
						$dropdown.empty();
						$dropdown.append($("<option />").val('').text('--Seleccione--'));
					$.each(detailsObj, function(key,val) {
							$dropdown.append($("<option />").val(val.idattrition_reasons_detail).text(val.name));
			
					});
						$dropdown.val(reasonDetail);
					}else{
						$("#reasonDetail_div").hide();
					}
					
				}
		})
	}
}
	
function showAttritionReasons(step,option=null,option2=null){
	if(step=="reasonType"){
		var reasonType = document.getElementById("tipoRetiro").value;
	//var step = "reasonType";
	
	$.ajax({
		url: '<?php echo URLROOT; ?>/aps/getattritionreasons',
                type: 'post',
                data: {reasonType:reasonType,step:step},
                success:function(response){
					var reasonObj = JSON.parse(response);
					//console.log(reasonObj);
					if(reasonObj.length>0){
						$("#attritionReasons").show();
						$("#attritions").val('');
						$("#reasonsDetails").val('')
						$("#reasonDetail_div").hide();
					var $dropdown = $("#attritions");
						$dropdown.empty();
						console.log('creando select');
						$dropdown.append($("<option />").val('').text('--Seleccione--'));
					$.each(reasonObj, function(key,val) {
							$dropdown.append($("<option />").val(val.attritionReasonId).text(val.name));
					});
          if(option){
            $("#attritions").val(option);
          }
					}else{
						$("#attritionReasons").hide();
					  $("#reasonDetail_div").hide();
            $dropdown.empty();
						//$dropdown.val('');
					}
				}
	})
	console.log(reasonType);
	}
	
	if(step=="reasonsDetail"){
    if(option){
      var reasonDetail = option;
    }else{
      var reasonDetail = document.getElementById("attritions").value;
    }
		
		console.log(reasonDetail);
		$.ajax({
			url: '<?php echo URLROOT; ?>/aps/getAttritionReasons',
                type: 'post',
                data: {id_reasonType:reasonDetail,step:step},
                success:function(response){
					var detailsObj = JSON.parse(response);
					if(detailsObj.length>0){
						$("#reasonDetail_div").show();
					var $dropdown = $("#reasonsDetails");
						$dropdown.empty();
						$dropdown.append($("<option />").val('').text('--Seleccione--'));
					$.each(detailsObj, function(key,val) {
						//$dropdown.append($("<option />").val(val.idattrition_reasons_detail).text(val.name));
						$dropdown.append($("<option />").val(val.attritionReasonDetailId).text(val.name));
					});
          if(option2){
            $("#reasonsDetails").val(option2);
          }
					}else{
						$("#reasonDetail_div").hide();
						$dropdown.empty();
					}
					//$("#attritionReasons").show();
					
				}
		})
		console.log(reasonDetail);
	}
}
	
	
		
	addForm.validate({
		rules:{
			addbadge:{
				required:true,
				digits:true
			},
			addLeaveType:{
				required:true
			},
			motivo_permiso:{
				required:true
			},
			inicioVacaciones:{
				required:true
			},
      tiempopermiso:{
        required:true
      },
      dia1:{
        required:true
      },
      dia2:{
        required:true
      },
      hora_inicio:{
        required:true
      },
      hora_final:{
        required:true
      },
      newDepartment:{
        required:true
      },
      newPosition:{
        required:true
      },
      inicioPrueba:{
        required:true
      },
      finPrueba:{
        required:true
      },
      tipoIncapacidad:{
        required:true
      },
      inicioIncapacidad:{
        required:true
      },
      finIncapacidad:{
        required:true
      },
      tipoSancion:{
        required:true
      },
      inicioSuspension:{
        required:true
      },
      finSuspension:{
        required:true
      },
      inicioAusencia:{
        required:true
      },
      finAusencia:{
        required:true
      },
      fechaOt:{
        required:true
      },
      inicioOt:{
        required:true
      },
      finOt:{
        required:true
      },
      tipoRetiro:{
        required:true
      },
      attritions:{
        required:true
      },
      reasonsDetails:{
        required:true
      },
      fechaRetiro:{
        required:true
      },
      monto:{
        required:true
      },
      diaEfectivo:{
        required:true
      },
      fechaSolicitud:{
        required:true
      },
      diaAsignado:{
        required:true
      },
      diaSolicitado:{
        required:true
      },
      motivo_cambio:{
        required:true
      },
      inicioHorario:{
        required:true
      },
      motivo_horario:{
        required:true
      }



		},
		errorElement: 'span',
		/*errorClass: 'invalid-feedback',*/
		errorPlacement: function(error, element) {
		  error.insertAfter(element);
		}
	})
	
	
	  $("#addAPButton").click(function(e){
		e.preventDefault();
		//validator.myForm;
		//const visibleSection = $('.toggleable:not([style*="display: none"])');

		if (addForm.valid()) {
		  var changedFields = getChangedFields();
      //var jsonChangedFields = JSON.stringify(changedFields);
      console.table(changedFields)
      
      $.ajax({
        url:"<?php echo URLROOT; ?>/aps/saveAP",
        type:"POST",
        data:changedFields,
        success:function(data){
          console.log(data)
          var myObj = JSON.parse(data)
          if(myObj.status=="success"){
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
                                  var myArray = camposValue();
                                  //console.log(myArray);
                                  var camposAscDesc = '';
                                  var example_length = 10;
                                  readData(1,myArray,example_length,camposAscDesc,'');
                                }
                            });
          }else{
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
			
		/*$.ajax({
			url:'<?php //echo URLROOT; ?>/aps/saveAP',
		})*/
	})
	
	function captureInitialState() {
    var initialState = {};
    $('#addAPButton').find('input, select, textarea').each(function() {
       initialState[$(this).attr('name')] = $(this).val();
    });
     return initialState;
  }

  function ischecked(idelement) {
    var check;
    if ($('#' + idelement).is(':checked')) {
      $('#' + idelement).val('Yes');
    } else {
      $('#' + idelement).val('No');
    }
    return check;
  }

  function isOffchecked(idelement) {
    var check;
    if ($('#' + idelement).is(':checked')) {
      $('#' + idelement).val('OFF');
    } else {
      $('#' + idelement).val('ON');
    }
    return check;
  }
  
	
	function getChangedFields() {
            var changedFields = {};
            $('#createApForm').find('input,select,textarea').each(function() {
                var name = $(this).attr('name');
                var currentValue = $(this).val();
                if (currentValue !== initialState[name]) {
                    changedFields[name] = currentValue;
                }
            });
            return changedFields;
        }

  function calculateDays() {
            var startDate = new Date($("#inicioVacaciones").val());
            var endDate = new Date($("#finVacaciones").val());

            // Calculate the time difference in milliseconds
            var timeDifference = endDate - startDate;

            // Convert time difference from milliseconds to days
            var dayDifference = timeDifference / (1000 * 3600 * 24);

            $("#totalDias").val(dayDifference);
        }
  function getTotalOT() {
    var start = $("#inicioOt").val();
    var end = $("#finOt").val();
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
    $("#totalOt").val(totalHours)
}

function readData(page,where='',example_length,camposAscDesc,firstload=''){
	
	var search="";

	var parametros = {action:"ajax",page:page,search:where,example_length:example_length,camposAscDesc:camposAscDesc,firstload:firstload};
	console.log(parametros)

	$("#loader").fadeIn('slow');

	$.ajax({

		url:'<?php echo URLROOT;?>/aps/read',
		
		type:'POST',

		data: {action:"ajax",page:page,search:where,length:example_length,camposAscDesc:camposAscDesc,firstload:firstload},
		

		beforeSend: function(objeto){

		//$("#loader").html("<img src='../assets/img/ajax-loader.gif'>");

		},

		success:function(data){
			
			
			$("#gridBody").empty();
			const result = document.getElementById('gridBody');
			
			var resultObj = JSON.parse(data);
			console.log(resultObj.fields==0);
			if(resultObj.fields==0){
        row = result.insertRow(0);
				cell= row.insertCell(0);
				cell.innerHTML = "<p>NO RECORDS FOUND</p>";
        cell.colSpan = 11
			}else{
				
			
			//console.log(resultObj);
			var row;
			var cell,cell1,cell2,cell3,cell4,cell5,cell6,cell7,cell8,cell9,cell10,cell11,cell12,cell13,cell14,cell15;
			var f,cnum;
			var i = 0;
			var c = 1;
      var printButton="";
      var enable="";
			$.each(resultObj.fields, function(k, v) {
				
				//console.log(v);
				//f = JSON.parse(v)
				cnum = resultObj.offset + c;
				row = result.insertRow(i);
				cell= row.insertCell(0);
				cell1 = row.insertCell(1);
				cell2 = row.insertCell(2);
				cell3 = row.insertCell(3);
				cell4 = row.insertCell(4);
				cell5 = row.insertCell(5);
				cell6 = row.insertCell(6);
				cell7 = row.insertCell(7);
				cell8 = row.insertCell(8);
				cell9 = row.insertCell(9);
				cell10 = row.insertCell(10);
				/*cell11 = row.insertCell(11);
				cell12 = row.insertCell(12);
				cell13 = row.insertCell(13);
				cell14 = row.insertCell(14);
				cell15 = row.insertCell(15);
				cell15 = row.insertCell(15);*/
				
				//cell.innerHTML = cnum;
        cell.innerHTML = v.apDetailsId
				cell1.innerHTML = v.fullName;
				cell2.innerHTML = v.badge;
				cell3.innerHTML = v.createdAt;
				cell4.innerHTML = v.username;
				cell5.innerHTML = v.name;
        printButton="disabled";
        switch(v.aprovedByM){
          case 1:
            cell6.innerHTML = '<span class="badge badge-success">Approved</span>';
            printButton = "";
            break;
          case 2:
            cell6.innerHTML = '<span class="badge badge-danger">Rejected</span>';
            break;
          case 3:
            cell6.innerHTML = '<span class="badge badge-secondary">Cancelled</span>';
            break;
          default:
            cell6.innerHTML = '<span class="badge badge-warning">Pending</span>';
        
            break;
        }
        switch(v.aprovedByHR){
          case 1:
            cell7.innerHTML = '<span class="badge badge-success">Approved</span>';
            printButton = "";
            
            break;
          case 2:
            cell7.innerHTML = '<span class="badge badge-danger">Rejected</span>';
            break;
          case 3:
            cell7.innerHTML = '<span class="badge badge-secondary">Cancelled</span>';
            break;
          default:
            cell7.innerHTML = '<span class="badge badge-warning">Pending</span>';
            
            break;
        }
        switch(v.aprovedByWf){
          case 1:
            cell8.innerHTML = '<span class="badge badge-success">Approved</span>';
            break;
          case 2:
            cell8.innerHTML = '<span class="badge badge-danger">Rejected</span>';
            break;
          case 3:
            cell8.innerHTML = '<span class="badge badge-secondary">Cancelled</span>';
            break;
          default:
            cell8.innerHTML = '<span class="badge badge-warning">Pending</span>';
            
            break;
        }
        switch(v.aprovedBySup){
          case 1:
            cell9.innerHTML = '<span class="badge badge-success">Approved</span>';
            break;
          case 2:
            cell9.innerHTML = '<span class="badge badge-danger">Rejected</span>';
            break;
          case 3:
            cell9.innerHTML = '<span class="badge badge-secondary">Cancelled</span>';
            break;
          default:
            cell9.innerHTML = '<span class="badge badge-warning">Pending</span>';
            
            break;
        }
        //btnsuccess="btn-success";
        btnwarning="btn-warning";
        if(v.aprovedByM>=1 || v.aprovedByHR>=1){
          enable="disabled";
          //btnsuccess="";
          btnwarning="";
        }
				
				cell10.innerHTML = `<div class="form-button-action">
                        <button type="button" title="" class="btn btn-link btn-lg btn-success aproveModal" data-leaveId="${v.apDetailsId}" data-bs-toggle="modal" data-bs-target="#approveModal">
                        <i class="fas fa-check-double"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-lg ${btnwarning} updateModal" data-bs-toggle="modal" data-bs-target="#addRowModal" data-leaveId="${v.apDetailsId}" ${enable}>
                          <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-link" ${printButton}>
                         <i class="fa fa-print"></i>
                        </button>
                      </div>`;
				/*cell8.innerHTML = v.address2;
				cell7.innerHTML = v.city;
				cell8.innerHTML = v.state;
				cell9.innerHTML = v.zipcode;
				cell10.innerHTML = v.order_id;
				cell11.innerHTML = getProgramName(v.program_benefit);
				cell12.innerHTML = v.date_create;
				cell13.innerHTML = v.source;
				cell14.innerHTML = v.tookstaff;*/
				/*cell15.innerHTML = '<div class="pull-right"><a href="https://secure-order-forms.com/surgephone/acp_landings/dashboard_dev/records/edit/'+v.id+'" class="btn btn-outline-dark btn-sm" type="button"><i class="fa fa-pencil"></i>&nbsp;Edit</a></div>';
				cell14.innerHTML = '<div class="pull-right"><button class="btn btn-outline-primary btn-sm modalView" type="button" style="margin-right: 10px;" data-idorder="'+v.id+'"><i class="fa fa-eye"></i>&nbsp;View</button><a href="https://secure-order-forms.com/surgephone/acp_landings/dashboard/records/edit/'+v.id+'" class="btn btn-outline-dark btn-sm" type="button"><i class="fa fa-pencil"></i>&nbsp;Edit</a></div>';
				*/
				
				i++;
				c++;
        printButton="";
        enable="";
			})
				
				$("#toShow").html('<p>Showing '+resultObj.offsetToShow+' to '+ cnum + ' of '+resultObj.numrows+'</p>');
			
			$("#pagination").html(resultObj.pagination);
			}

		}

	})

}


function camposValue(){
		var ArrayCampos=[];

		var name = $( "#searchFullname" ).val();
		var badge = $( "#searchBadge" ).val();
		var bydate = $( "#searchCreatedAt" ).val();
    var spltDate = bydate.split("-")
  var start,end;
   start = spltDate[0].trim()
   end = spltDate[1].trim()
	var user = $( "#searchCreatedBy" ).val();
	var aptype = $( "#searchLeaveType" ).val();
	var status_m = $( "#searchByM" ).val();
  var status_hr = $( "#searchByHR" ).val();
  var status_wf = $( "#searchByWF" ).val();
  var status_sup = $( "#searchBySup" ).val();

		var ArrayCampos = [
			name,
			badge,
      bydate,
			user,
			aptype,
			status_m,
      status_hr,
      status_wf,
      status_sup
		];

		return ArrayCampos;
	}
	
	$( ".grid-filter" ).change(function() {
	var myArray = camposValue();
	console.log(myArray);
	var camposAscDesc = '';
    var example_length = 10;
    readData(1,myArray,example_length,camposAscDesc,'');
	
});

$(document).on('click', '.aproveModal', function(){
  var leaveId = $(this).data("leaveid");
  $("#showId").html(leaveId)
  $("#leave_id").val(leaveId)
  //console.log(leaveId)
})

approveForm.validate({
  rules:{
    approval:{
      required:true
    }
  },
  messages:{
    approval:"This field is required, please select one status"
  }
});

$("#saveApApproval").on("click",function(e){
  e.preventDefault();
  if (approveForm.valid()) {
		  //var changedFields = getChangedFields();
      //var jsonChangedFields = JSON.stringify(changedFields);
      //console.table(changedFields)
      var approveValue=$("input[type='radio'][name='approval']:checked").val();
      var leaveId = $("#leave_id").val();
      console.log(approveValue);
      $.ajax({
        url:"<?php echo URLROOT; ?>/aps/approveAP",
        type:"POST",
        data:{status:approveValue,id:leaveId},
        success:function(data){
          console.log(data)
          var myObj = JSON.parse(data)
          if(myObj.response=="success"){
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
                                 $('#approveForm')[0].reset();
		                             //hideAllAndShow("")
                                   //location.reload();
                                   var myArray = camposValue();
                                    console.log(myArray);
                                    var camposAscDesc = '';
                                      var example_length = 10;
                                      readData(1,myArray,example_length,camposAscDesc,'');
                               }
                           });
          }else{
           swal('Error', myObj.message, {
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
})

$(document).on('click', '.updateModal', function(){
  var leaveId = $(this).data("leaveid");
  $("#actionspan").text("Update");
  $("#addAPButton").text("Edit")
  $("#Action").val("Update");
  $("#apId").val(leaveId);
  console.log(leaveId)
  $.ajax({
    url:"<?Php echo URLROOT; ?>/aps/getleave/"+leaveId,
    type:"GET",
    success:function(data){
      console.log(data)
      var myObj = JSON.parse(data)
      $("#addbadge").val(myObj.badge);
      $('#addbadge').trigger('keyup');
      $("#addLeaveType").val(myObj.apTypeId);
      var apType = myObj.apTypeId;
      $("#addComments").val(myObj.comment)
      //showSetLeaveAreas(apType)
      console.log(apType)
      switch(apType){
        case 1:
          hideAllAndShow("permisoConSinGoce") 
          setReasons('motivo_permiso',1,myObj.reason1);
          console.log(myObj.reason1);
          $("#dia1").val(myObj.apDate1);
          var reason2 = myObj.reason2;
          if(reason2=="Horas"){
            $("#tiempopermiso").val("Horas");
            $('#tiempopermiso').trigger('change');
            $("#hora_inicio").val(myObj.startTime);
            $("#hora_final").val(myObj.endTime)
          }else{
            $("#tiempopermiso").val("Dias");
            $('#tiempopermiso').trigger('change');
            $("#dia2").val(myObj.apDate2);
          }
          
          //document.getElementById("motivo_permiso").value = myObj.reason1;
          break;
        case 2: 
          hideAllAndShow("permisoConSinGoce") 
          setReasons('motivo_permiso',1,myObj.reason1);
          //console.log(myObj.reason1);
          $("#dia1").val(myObj.apDate1);
          var reason2 = myObj.reason2;
          if(reason2=="Horas"){
            $("#tiempopermiso").val("Horas");
            $('#tiempopermiso').trigger('change');
            $("#hora_inicio").val(myObj.startTime);
            $("#hora_final").val(myObj.endTime)
          }else{
            $("#tiempopermiso").val("Dias");
            $('#tiempopermiso').trigger('change');
            $("#dia2").val(myObj.apDate2);
          }
          break;
        case 3:
          hideAllAndShow("vacaciones");
          $("#inicioVacaciones").val(myObj.apDate1);
          $("#finVacaciones").val(myObj.apDate2);
          calculateDays();
          break;
        case 4:
          hideAllAndShow("traslados")
          setDespartment(myObj.newAccount);
          setPosition('newPosition',myObj.newPosition);
          $("#inicioPrueba").val(myObj.apDate1);
          $("#finPrueba").val(myObj.apDate2);
          break;
        case 5:
          hideAllAndShow("incapacidad");
          $("#inicioIncapacidad").val(myObj.apDate1);
          $("#finIncapacidad").val(myObj.apDate2);
          if(myObj.reason1=="ISSS"){
            $("#isss").prop('checked', true);
          }else if(myObj.reason1=="ASESUISA"){
            $("#asesuisa").prop('checked', true);
          }else{
            $("#particular").prop('checked', true);
          }

          if(myObj.reason2=="Prorroga"){
            $("#prorroga").prop('checked', true);
            $("#prorroga").val("Yes")
          }
          break;
        case 6:
          hideAllAndShow("sanciones");
          switch(myObj.reason1){
            case "Verbal":
              $("#sancionVerbal").prop('checked', true);
              break;
            case "Escrita":
              $("#sancionEscrita").prop('checked', true);
              break;
            case "Suspension":
              $("#suspension").prop('checked', true);
              $('#tiempopermiso').trigger('change');
              $("#inicioSuspension").val(myObj.apDate1);
              $("#finSuspension").val(myObj.apDate2);
              break;
          }
          break;
        case 7:
          hideAllAndShow("cambiohorario")
          setReasons('motivo_horario',3,myObj.reason1);
          $("#inicioHorario").val(myObj.apDate1);
          $("#finHorario").val(myObj.apDate2);
          getLastSchedule(myObj.scheduleId,"Edit");
          break;
        case 8:
          hideAllAndShow("cambiodialibre");
          setReasons('motivo_cambio',2,myObj.reason1);
          $("#fechaSolicitud").val(myObj.apDate1);
          $("#diaAsignado").val(myObj.apDate2);
          $("#diaSolicitado").val(myObj.apDate3);
          break;
        case 9:
          hideAllAndShow("ausencia");
          $("#inicioAusencia").val(myObj.apDate1);
          $("#finAusencia").val(myObj.apDate2);
          break;
        case 10:
        hideAllAndShow("horasExtra");
          $("#fechaOt").val(myObj.apDate1);
          $("#inicioOt").val(myObj.startTime);
          $("#finOt").val(myObj.endTime);
          getTotalOT();
          break;
        case 11:
          hideAllAndShow("retiros");
          $("#tipoRetiro").val(myObj.withdrawalType);
          $("#fechaRetiro").val(myObj.apDate1);
          showAttritionReasons('reasonType',myObj.attritionsId1);
          console.log(myObj.attritionsId2)
          if(myObj.attritionsId2){
            showAttritionReasons('reasonsDetail',myObj.attritionsId1,myObj.attritionsId2);
          }
          break;
        case 12:
          hideAllAndShow("ajusteSalarial");
          $("#monto").val(myObj.newSalary);
          $("#diaEfectivo").val(myObj.apDate1);
          setPosition('newPosition2',myObj.newPosition);
          break;

      }

    }
  })
  
})

$(".dayOff").on("change",function(){
  var day = $(this).data("day")
  if($(this).is(":checked")){
    console.log(day)
    //$("#"+day+"In").val("").prop("disabled",true).rules('remove','required');
    //$("#"+day+"Out").val("").prop("disabled",true).rules('remove','required');
    //$("#"+day+"Lunch").val("").prop("disabled",true).rules('remove','required');
    setScheduleInputs(day,"","","",true)
  }else{
    console.log("is not checked")
    setScheduleInputs(day,"","","",false)
    //$("#"+day+"In").prop("disabled",false).rules('add', {required: true});
    //$("#"+day+"Out").prop("disabled",false).rules('add', {required: true});
    //$("#"+day+"Lunch").prop("disabled",false).rules('add', {required: true});
 
  }
})

function setScheduleInputs(day,inVal,outVal,lunchVal,checked){
  if(checked==true){
    $("#"+day+"In").val("").prop("disabled",true).rules('remove','required');
    $("#"+day+"Out").val("").prop("disabled",true).rules('remove','required');
    $("#"+day+"Lunch").val("").prop("disabled",true).rules('remove','required');
  }else{
    $("#"+day+"In").val(inVal).prop("disabled",false).rules('add', {required: true});
    $("#"+day+"Out").val(outVal).prop("disabled",false).rules('add', {required: true});
    $("#"+day+"Lunch").val(lunchVal).prop("disabled",false).rules('add', {required: true});
  }
}
</script>