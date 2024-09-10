<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Manage Leaves</h4>
              <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">
                <i class="fa fa-plus"></i>
                Crear AP
              </button>
            </div>
          </div>
          <div class="card-body">
            <!-- Modal -->
            <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title">
                      <span class="fw-mediumbold"> Create</span>
                      <span class="fw-light"> New Leave </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
					        <form id="createApForm" action="index.php" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="modal-body">
                      <p class="small">
                        Create a new leave using this form, make sure you
                        fill them all
                      </p>
                      <div class="row">
                        <div class="col-sm-12">
                          <div id="badgeDiv" class="form-floating  form-floating-custom mb-3">
                            <input id="addbadge" name="addbadge" type="text" class="form-control" placeholder="Badge" onchange="getData()" />
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

                                <div class="d-flex">
                                  
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="septimo" id="septimo" onclick="ischecked('septimo')">
                                    <label class="form-check-label" for="septimo">
                                      Descuento de septimo
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

                                <div class="col-sm-12">
                                    <div class="form-floating form-floating-custom mb-3">
                                      <select class="form-select" name="tipohorario" id="tipohorario">
                                        <option value="Normal">Normal</option>
                                        <option value="Hibrido">Hibrido</option>
                                      </select>
                                      <label for="tipohorario"> Tipo de Horario: </label>
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
                                                <option value="1">1:00</option>
                                                <option value="30">0:30</option>
                                                <option value="0">0:00</option>
                                              </select>
                                            </td>
                                            <td><input class="form-check" type="checkbox" id="mondayOff" name="mondayOff"></td>
                                          </tr>
                                          <tr>
                                            <td>Martes</td>
                                            <td><input type="time" class="form-control" id="tuesdayIn" name="tuesdayIn"></td>
                                            <td><input type="time" class="form-control" id="tuesdayOut" name="tuesdayOut"></td>
                                            <td>
                                              <select class="form-select" name="tuesdayLunch" id="tuesdayLunch">
                                                <option value="1">1:00</option>
                                                <option value="30">0:30</option>
                                                <option value="0">0:00</option>
                                              </select>
                                            </td>
                                            <td><input class="form-check" type="checkbox" id="tuesdayOff" name="tuesdayOff"></td>
                                          </tr>
                                          <tr>
                                            <td>Miercoles</td>
                                            <td><input type="time" class="form-control" id="wednesdayIn" name="wednesdayIn"></td>
                                            <td><input type="time" class="form-control" id="wednesdayOut" name="wednesdayOut"></td>
                                            <td>
                                              <select class="form-select" name="wednesdayLunch" id="wednesdayLunch">
                                                <option value="1">1:00</option>
                                                <option value="30">0:30</option>
                                                <option value="0">0:00</option>
                                              </select>
                                            </td>
                                            <td><input class="form-check" type="checkbox" id="wednesdayOff" name="wednesdayOff"></td>
                                          </tr>
                                          <tr>
                                            <td>Jueves</td>
                                            <td><input type="time" class="form-control" id="thursdayIn" name="thursdayIn"></td>
                                            <td><input type="time" class="form-control" id="thursdayOut" name="thursdayOut"></td>
                                            <td>
                                              <select class="form-select" name="thursdayLunch" id="thursdayLunch">
                                                <option value="1">1:00</option>
                                                <option value="30">0:30</option>
                                                <option value="0">0:00</option>
                                              </select>
                                            </td>
                                            <td><input class="form-check" type="checkbox" id="thursdayOff" name="thursdayOff"></td>
                                          </tr>
                                          <tr>
                                            <td>Viernes</td>
                                            <td><input type="time" class="form-control" id="fridayIn" name="fridayIn"></td>
                                            <td><input type="time" class="form-control" id="fridayOut" name="fridayOut"></td>
                                            <td>
                                              <select class="form-select" name="fridayLunch" id="fridayLunch">
                                                <option value="1">1:00</option>
                                                <option value="30">0:30</option>
                                                <option value="0">0:00</option>
                                              </select>
                                            </td>
                                            <td><input class="form-check" type="checkbox" id="fridayOff" name="fridayOff"></td>
                                          </tr>
                                          <tr>
                                            <td>Saturday</td>
                                            <td><input type="time" class="form-control" id="saturdayIn" name="saturdayIn"></td>
                                            <td><input type="time" class="form-control" id="saturdayOut" name="saturdayOut"></td>
                                            <td>
                                              <select class="form-select" name="saturdayLunch" id="saturdayLunch">
                                                <option value="1">1:00</option>
                                                <option value="30">0:30</option>
                                                <option value="0">0:00</option>
                                              </select>
                                            </td>
                                            <td><input class="form-check" type="checkbox" id="saturdayOff" name="saturdayOff"></td>
                                          </tr>
                                          <tr>
                                            <td>Domingo</td>
                                            <td><input type="time" class="form-control" id="sundayIn" name="sundayIn"></td>
                                            <td><input type="time" class="form-control" id="sundayOut" name="sundayOut"></td>
                                            <td>
                                              <select class="form-select" name="sundayLunch" id="sundayLunch">
                                                <option value="1">1:00</option>
                                                <option value="30">0:30</option>
                                                <option value="0">0:00</option>
                                              </select>
                                            </td>
                                            <td><input class="form-check" type="checkbox" id="sundayOff" name="sundayOff"></td>
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
							   <!-- <div class="col-sm-12">
								   <p>Razón por la que solicita el cambio de día libre</p>
							   		<div class="form-check">	
										<input type="checkbox" class="form-check-input" value="Consulta Medica/Motivos de salud" id="dnotes1" name="dnotes1"> 
										<label  class="form-check-label" for="dnotes1"> Consulta Medica/Motivos de salud </label>
									</div>
								   <div class="form-check">	
										<input type="checkbox" class="form-check-input" value="Motivos Académicos" id="dnotes2" name="dnotes2"> 
										<label  class="form-check-label" for="dnotes2">Motivos Académicos</label>
									</div>
								   <div class="form-check">	
										<input type="checkbox" class="form-check-input" value="Emergencia Familiar" id="dnotes3" name="dnotes3"> 
										<label  class="form-check-label" for="dnotes3">Emergencia Familiar</label>
									</div>
								   <div class="form-check">	
										<input type="checkbox" class="form-check-input" value="Enfermedad de Familiar" id="dnotes4" name="dnotes4"> 
										<label  class="form-check-label" for="dnotes4">Enfermedad de Familiar</label>
									</div>
								   <div class="form-check">	
										<input type="checkbox" class="form-check-input" value="Requerimiento del trabajo" id="dnotes5" name="dnotes5"> 
										<label  class="form-check-label" for="dnotes5">Requerimiento del trabajo</label>
									</div>
								   <div class="form-check">	
										<input type="checkbox" class="form-check-input" value="Cambio Temporal" id="dnotes6" name="dnotes6"> 
										<label  class="form-check-label" for="dnotes6">Cambio Temporal</label>
									</div>
								   <div class="form-check">	
										<input type="checkbox" class="form-check-input" value="Motivos Legales" id="dnotes7" name="dnotes7"> 
										<label  class="form-check-label" for="dnotes7">Motivos Legales</label>
									</div>
								   <div class="form-check">	
										<input type="checkbox" class="form-check-input" value="Otros" id="dnotes8" name="dnotes8"> 
										<label  class="form-check-label" for="dnotes8">Otros</label>
									</div>
							   </div> -->
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
					  </form>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table id="add-row" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Badge</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Leave Type</th>
                    <th>Status</th>
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
                      <select id="searchStatus" type="text" class="form-control grid-filter">
                        <option value="">Select...</option>
                        <option value="0">Pending</option>
                        <option value="1">Approved</option>
                        <option value="3">Rejected</option>
                      </select>
                    </td> 
                    <td style="text-align:center;">
                    <img style="cursor: pointer;" onclick="resetform()" src="http://localhost/surge-hr/assets/img/clear-filter.png" width="25" height="25">
                    </td>                 
                  </tr>
                </thead>
                <!-- <tfoot>
                          <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Action</th>
                          </tr>
                        </tfoot> -->
                        <tbody id="gridBody">
                                            
											
											</tbody>
                <!-- <tbody>
                  <tr>
                    <td>Tiger Nixon</td>
                    <td>12345</td>
                    <td>02/02/1994</td>
                    <td>jlinares</td>
                    <td>Permiso con Goce</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                      <div class="form-button-action">
                        <button type="button" data-bs-target="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-originall-title="check"><i class="fas fa-check-double"></i></button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Charles Mingus</td>
                    <td>12345</td>
                    <td>02/02/1994</td>
                    <td>jlinares</td>
                    <td>Permiso con Goce</td>
                    <td><span class="badge badge-danger">Reject</span></td>
                    <td>
                      <div class="form-button-action">
                        <button type="button" data-bs-target="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-originall-title="check"><i class="fas fa-check-double"></i></button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Charles Mingus</td>
                    <td>12345</td>
                    <td>02/02/1994</td>
                    <td>jlinares</td>
                    <td>Permiso con Goce</td>
                    <td><span class="badge badge-success">Approved</span></td>
                    <td>
                      <div class="form-button-action">
                        <button type="button" data-bs-target="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-originall-title="check"><i class="fas fa-check-double"></i></button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody> -->
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
  </div>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>

function resetform(){
  $(".grid-filter").val("");
}

$(".grid-filter").on("change",function(){
  $('#add-row').find('input, select,textarea').each(function() {
            initialState[$(this).attr('name')] = $(this).val();
        });
        console.table(initialState)
})

  $(function() {
  $('#searchCreatedAt').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});

  $('.money2').mask("#,##0.00", {reverse: true});
	const addForm = $("#createApForm")
	const initialState = {};
  $(document).ready(function() {

    setleaveTime()
    hideAllAndShow("")
    var nowhere = "";
    var example_length = 10;
    var camposAscDesc = "";
	  var	firstload='YES';
		load(1,nowhere,example_length,camposAscDesc,firstload);

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
		  hideAllAndShow("")
      }

    });

    $(".close").click(function() {
      $(".modal").modal("hide");
      $('#createApForm')[0].reset();
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
          $("#msgArea").html("<label><small>Record Not Found!</small></label>")
        } else {
          $("#badgeDiv").removeClass("has-error");
          $("#msgArea").html("")
          $("#addName").val(myObj.fullname);
          $("#addPosition").val(myObj.positionName);
          $("#addDepartment").val(myObj.departmentName)
          $("#addEmployeeId").val(myObj.employeeId)
          $("#currentPosition").val(myObj.positionId)
          $("#currentDepartment").val(myObj.departmentId)
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

  $("#addLeaveType").on("change",function(){
    //$('#createApForm')[0].reset();
    var idLeaveType = $(this).val();
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
      $("#horas").show();
      $("#dias").hide()
    }else{
      $("#horas").hide();
      $("#dias").show()
    }
  }

  function setReasons(element,type){
    $.ajax({
      url:'<?php echo URLROOT; ?>/aps/getreasons/'+type,
      type:'GET',
      success:function(data){
        console.table(data)
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
      }
    })
  }
	
  function setDespartment(){
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
      }
    })
  }

  function setPosition(id){
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
						
						//if(val.id_reason_attrition==attrition_reason){
//							$dropdown.append($("<option value='"+val.id_reason_attrition+"' selected>"+val.name+"</option>"));
//						}else{
							$dropdown.append($("<option />").val(val.id_reason_attrition).text(val.name));
						//}
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
						//$dropdown.append($("<option />").val(val.idattrition_reasons_detail).text(val.name));
						//if(val.idattrition_reasons_detail==reasonDetail){
//							$dropdown.append($("<option value='"+val.idattrition_reasons_detail+"' selected>"+val.name+"</option>"));
//						}else{
							$dropdown.append($("<option />").val(val.idattrition_reasons_detail).text(val.name));
						//}
					});
						$dropdown.val(reasonDetail);
					}else{
						$("#reasonDetail_div").hide();
					}
					//$("#attritionReasons").show();
					
				}
		})
	}
}
	
function showAttritionReasons(step){
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
		var reasonDetail = document.getElementById("attritions").value;
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
      finHorario:{
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
                                    location.reload();
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
  
	
	function getChangedFields() {
            var changedFields = {};
            $('#createApForm').find('input, select,textarea').each(function() {
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

function load(page,where='',example_length,camposAscDesc,firstload=''){
	
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
			
			//console.log(data);
			$("#gridBody").empty();
			const result = document.getElementById('gridBody');
			
			var resultObj = JSON.parse(data);
			
			if(resultObj.fields.lentgh<1){
				result.innerHTML = "NO RECORDS FOUND";
			}else{
				
			
			//console.log(resultObj);
			var row;
			var cell,cell1,cell2,cell3,cell4,cell5,cell6,cell7,cell8,cell9,cell10,cell11,cell12,cell13,cell14,cell15;
			var f,cnum;
			var i = 0;
			var c = 1;
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
				/*cell8 = row.insertCell(8);
				cell9 = row.insertCell(9);
				cell10 = row.insertCell(10);
				cell11 = row.insertCell(11);
				cell12 = row.insertCell(12);
				cell13 = row.insertCell(13);
				cell14 = row.insertCell(14);
				cell15 = row.insertCell(15);
				cell15 = row.insertCell(15);*/
				
				cell.innerHTML = cnum;
				cell1.innerHTML = v.fullName;
				cell2.innerHTML = v.badge;
				cell3.innerHTML = v.createdAt;
				cell4.innerHTML = v.username;
				cell5.innerHTML = v.name;
        switch(v.status){
          case 1:
            cell6.innerHTML = '<span class="badge badge-success">Approved</span>';
            break;
          case 2:
            cell6.innerHTML = '<span class="badge badge-danger">Reject</span>';
            break;
          default:
            cell6.innerHTML = '<span class="badge badge-warning">Pending</span>';
            break;
        }
				
				cell7.innerHTML = `<div class="form-button-action">
                        <button type="button" data-bs-target="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-originall-title="check"><i class="fas fa-check-double"></i></button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                          <i class="fa fa-times"></i>
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
			})
				
				$("#toShow").html('<p>Showing '+resultObj.offsetToShow+' to '+ cnum + ' of '+resultObj.numrows+'</p>');
			
			$("#pagination").html(resultObj.pagination);
			}
			
			// if(where!=""){

			// 	document.getElementById("customer_id").value = where[0];

			// 	document.getElementById("first_name").value = where[1];
				
			// 	document.getElementById("second_name").value = where[2];
				
			// 	document.getElementById("phone_number").value = where[3];
				
			// 	document.getElementById("email").value = where[4];
				
			// 	document.getElementById("dob").value = where[5];
				
			// 	document.getElementById("city").value = where[6];
				
			// 	document.getElementById("state").value = where[7];
			// 	document.getElementById("zipcode").value = where[8];
			// 	document.getElementById("order_id").value = where[9];
			// 	document.getElementById("program_benefit").value = where[10];
			// 	document.getElementById("date_create").value = where[11];
			// 	document.getElementById("source").value = where[12];

			// }

		}

	})

}
/*function getChangedFields() {
    var changedFields = {};
    var ignoredFields = [
        'antecedentesPenales_delete',
        'solvenciaPNC_delete',
        'contract_delete',
        'expediente_delete',
        'antecedentesPenales',
        'solvenciaPNC',
        'contract',
        'expediente',
    ]; // Lista de campos a ignorar


    $('#addAPButton').find('input, select, textarea').each(function() {
        var name = $(this).attr('name');
        if (name && initialState.hasOwnProperty(name) && !ignoredFields.includes(name)) {
            var currentValue = $(this).val();
            var initialValue = initialState[name] == null ? '' : initialState[name];
            if (currentValue !== initialValue) {
                changedFields[name] = currentValue;
            }
        }
    });
    return changedFields;
}*/
</script>