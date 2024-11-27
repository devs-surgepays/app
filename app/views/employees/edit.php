<?php
require APPROOT . '/views/inc/header.php';

$states = (isset($data['states']) && $data['states'] != NULL) ? $data['states'] : [];
$departments = (isset($data['departments']) && $data['departments'] != NULL) ? $data['departments'] : [];
$positions = (isset($data['positions']) && $data['positions'] != NULL) ? $data['positions'] : [];
$banks = (isset($data['banks']) && $data['banks'] != NULL) ? $data['banks'] : [];
$afps = (isset($data['afps']) && $data['afps'] != NULL) ? $data['afps'] : [];
$areas = (isset($data['areas']) && $data['areas'] != NULL) ? $data['areas'] : [];
$bills = (isset($data['bills']) && $data['bills'] != NULL) ? $data['bills'] : [];
$typesDocuments = (isset($data['typesDocuments']) && $data['typesDocuments'] != NULL) ? $data['typesDocuments'] : [];
$employeeInfo = (isset($data['employeeInfo']) && $data['employeeInfo'] != NULL) ? $data['employeeInfo'] : [];
$superiors = (isset($data['superiors']) && $data['superiors'] != NULL) ? $data['superiors'] : [];
$employeeSchedule = (isset($data['employeeSchedule']) && $data['employeeSchedule'] != NULL) ? $data['employeeSchedule'] : [];
$employeeEmergencyContacts = (isset($data['employeeEmergencyContacts']) && $data['employeeEmergencyContacts'] != NULL) ? $data['employeeEmergencyContacts'] : [];
$data['employeeInfo']['contactPhone'] = (isset($data['employeeInfo']['contactPhone']) && $data['employeeInfo']['contactPhone'] != NULL) ? preg_replace('/^(.{4})/', '$1' . "-", $data['employeeInfo']['contactPhone']) : '';
$relationship = (isset($data['relationship']) && $data['relationship'] != NULL) ? $data['relationship'] : [];
$financialDependents = (isset($data['financialDependents']) && $data['financialDependents'] != NULL) ? $data['financialDependents'] : [];
$employeeDocumentsInfo = (isset($data['employeeDocumentsInfo']) && $data['employeeDocumentsInfo'] != NULL) ? $data['employeeDocumentsInfo'] : [];

?>
<style>
    .card-header h5::after {
        content: "";
        height: 30px;
        width: 3px;
        background: #51459d;
        position: absolute;
        left: 0;
        border-radius: 0 3px 3px 0;
        background: #0674b9 !important;
    }


    .file-input {
        margin-bottom: 20px;
    }

    input[type="file"] {
        display: none;
        /* Ocultar el input original */
    }

    .file-button {
        padding: 10px 15px;
        background-color: #1d9d22;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .file-button:hover {
        background-color: #43bd47;
    }

    .preview {
        font-size: 14px;
        color: #555;
    }

    .positionSelect {
        color: #1572e8 !important;
    }

    .off-color {
        background: #0674b94f !important;
    }

    .js-select-basic {
        width: 100% !important;
        /* Puedes cambiar esto a un ancho fijo si prefieres */
    }

    .select2-container {
        width: 100% !important;
        /* Para asegurar que el contenedor de Select2 se ajuste al ancho deseado */
    }

    #photo-preview:hover {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #photo-preview:hover .img-thumbnail {
        opacity: 0.6;
        transition: .3s ease;
        /* width: 130px;
        height: 90px; */
    }

    .edit-image-icon {
        display: none;
    }

    #photo-preview:hover .edit-image-icon {
        display: block;
        position: absolute;
        font-size: 20px;
        cursor: pointer;
        background: none !important;
    }

    .form-group-default .form-control,
    .form-group-default .form-select {
        margin-top: 0px;
    }

    .form-control:disabled,
    .form-control[readonly] {
        padding-left: 7px;
    }

    .disableLabel {
        padding-top: 12px !important;
        margin: 0 0 0 6px !important;
    }

    .hr-color {
        color: #cfcfcf;
    }

    .cursor-unset {
        cursor: unset;
    }

    .dropzoneMax {
        max-width: 96%;
        margin-left: 2%;
    }
</style>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <!-- <div>
                <h3 class="fw-bold mb-3">Employees</h3>
                <h6 class="op-7 mb-2">Employee management</h6>
            </div> -->
            <!-- <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round"> <i class="fa fa-add"></i> Add Employee</a>
            </div> -->
        </div>
        <!-- start/container-fluid -->

        <?php echo breadcrumbs('Employee') ?>

        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills nav-secondary nav-pills-no-bd mb-4" id="pills-tab-without-border" role="tablist">
                    <li class="nav-item submenu" role="presentation">
                        <a class="nav-link" id="tab-general-information" data-bs-toggle="pill" href="#general-information" role="tab" aria-controls="general-information" aria-selected="false" tabindex="-1">General Information</a>
                    </li>
                    <li class="nav-item submenu" role="presentation">
                        <a class="nav-link" id="tab-employee-documents" data-bs-toggle="pill" href="#employee-documents" role="tab" aria-controls="employee-documents" aria-selected="false" tabindex="-1">Documents</a>
                    </li>

                    <li class="nav-item submenu" role="presentation">
                        <a class="nav-link" id="tab-schedule" data-bs-toggle="pill" href="#schedule" role="tab" aria-controls="schedule" aria-selected="false" tabindex="-1">Schedule</a>
                    </li>
                    <li class="nav-item submenu" role="presentation">
                        <a class="nav-link " id="tab-emergency-contacts" data-bs-toggle="pill" href="#emergency-contacts" role="tab" aria-controls="emergency-contacts" aria-selected="true">Emergency Contacts</a>
                    </li>
                    <li class="nav-item submenu" role="presentation">
                        <a class="nav-link " id="tab-financial-dependents" data-bs-toggle="pill" href="#financial-dependents" role="tab" aria-controls="financial-dependents" aria-selected="true">Financial Dependents</a>
                    </li>

                </ul>
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">

                    <!-- General Information -->
                    <div class="tab-pane fade" id="general-information" role="tabpanel" aria-labelledby="tab-general-information">
                        <form id="editEmployee" method="POST" action="#" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 col-xl-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Personal Detail</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Name -->
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['firstName']; ?>" class="form-control check-changes" id="firstName" name="firstName" placeholder="First Name">
                                                        <label for="firstName">First Name <span class="text-danger">*</span>
                                                            <label id="firstName-error" class="error" for="firstName"></label></label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['secondName']; ?>" class="form-control check-changes" id="secondName" name="secondName" placeholder="Second Name">
                                                        <label for="secondName">Second Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['thirdName']; ?>" class="form-control check-changes" id="thirdName" name="thirdName" placeholder="Third Name">
                                                        <label for="thirdName">Third Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Last name -->
                                            <div class="row pt-3">
                                                <div class="col-4">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['firstLastName']; ?>" class="form-control check-changes" id="firstLastName" name="firstLastName" placeholder="First Last Name">
                                                        <label for="firstLastName">First Last Name <span class="text-danger">*</span>
                                                            <label id="firstLastName-error" class="error" for="firstLastName"></label></label>

                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['secondLastName']; ?>" class="form-control check-changes" id="secondLastName" name="secondLastName" placeholder="Second Last Name">
                                                        <label for="secondLastName">Second Last Name
                                                            <label id="secondLastName-error" class="error" for="secondLastName"></label></label>

                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['thirdLastName']; ?>" class="form-control check-changes" id="thirdLastName" name="thirdLastName" placeholder="Third Last Name">
                                                        <label for="thirdLastName">Third Last Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Phone - home phone -->
                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['contactPhone']; ?>" class="form-control phoneMark" id="contactPhone" name="contactPhone" placeholder="Contact Phone">
                                                        <label for="contactPhone">Contact Phone <span class="text-danger">*</span>
                                                            <label id="contactPhone-error" class="error" for="contactPhone"></label></label>

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['homePhone']; ?>" class="form-control phoneMark" id="homePhone" name="homePhone" placeholder="Contact Phone">
                                                        <label for="homePhone">Home Phone
                                                            <label id="homePhone-error" class="error" for="homePhone"></label></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['personalEmail']; ?>" class="form-control" id="personalEmail" name="personalEmail" placeholder="Email Personal">
                                                        <label for="personalEmail">Personal Email <span class="text-danger">*</span>
                                                            <label id="personalEmail-error" class="error" for="personalEmail"></label></label>

                                                    </div>
                                                </div>


                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="genderId" id="genderId" class="form-select form-control">
                                                            <option value="">Select</option>
                                                            <option <?php echo ("0" == $data['employeeInfo']['genderId']) ? 'selected' : '' ?> value="0">Male</option>
                                                            <option <?php echo ("1" == $data['employeeInfo']['genderId']) ? 'selected' : '' ?> value="1">Female</option>
                                                            <option <?php echo ("2" == $data['employeeInfo']['genderId']) ? 'selected' : '' ?> value="2">Other</option>
                                                        </select>
                                                        <label for="genderId">Gender</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- dob - birthMunicipality -->
                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="date" value="<?php echo $data['employeeInfo']['dob']; ?>" class="form-control" id="dob" name="dob" placeholder="dob">
                                                        <label for="dob">DOB <span class="text-danger">*</span>
                                                            <label id="dob-error" class="error" for="dob"></label></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['birthMunicipality']; ?>" class="form-control" id="birthMunicipality" name="birthMunicipality" placeholder="birthMunicipality">
                                                        <label for="birthMunicipality">Birth Municipality
                                                            <label id="birthMunicipality-error" class="error" for="birthMunicipality"></label></label>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['birthDeparment']; ?>" class="form-control" id="birthDeparment" name="birthDeparment" placeholder="birthDeparment">
                                                        <label for="birthDeparment">Birth Deparment
                                                            <label id="birthDeparment-error" class="error" for="birthDeparment"></label></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- DUI -->
                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <label class="positionSelect" for="documentTypeId">Identification Type <span class="text-danger">*</span>
                                                        <label id="documentTypeId-error" class="error" for="documentTypeId"></label></label>
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="documentTypeId" id="documentTypeId" class="form-select form-control js-select-basic">
                                                            <option value="" disabled selected>Select</option>
                                                            <option <?php echo ("1" == $data['employeeInfo']['documentTypeId']) ? 'selected' : '' ?> value="1">DUI</option>
                                                            <option <?php echo ("7" == $data['employeeInfo']['documentTypeId']) ? 'selected' : '' ?> value="7">Passport</option>
                                                            <option <?php echo ("8" == $data['employeeInfo']['documentTypeId']) ? 'selected' : '' ?> value="8">Residence card</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['documentNumber']; ?>" class="form-control" id="documentNumber" name="documentNumber" placeholder="documentNumber">
                                                        <label for="documentNumber">Identification Number <span class="text-danger">*</span>
                                                            <label id="documentNumber-error" class="error" for="documentNumber"></label></label>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="date" value="<?php echo $data['employeeInfo']['documentExpDate']; ?>" class="form-control" id="documentExpDate" name="documentExpDate" placeholder="documentExpDate">
                                                        <label for="documentExpDate">Document Exp. Date <span class="text-danger">*</span>
                                                            <label id="documentExpDate-error" class="error" for="documentExpDate"></label></label>

                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="date" value="<?php echo $data['employeeInfo']['documentExpedDate']; ?>" class="form-control" id="documentExpedDate" name="documentExpedDate" placeholder="documentExpedDate">
                                                        <label for="documentExpedDate">Document Exped. Date
                                                            <label id="documentExpedDate-error" class="error" for="documentExpedDate"></label></label>

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['documentExpedPlace']; ?>" class="form-control" id="documentExpedPlace" name="documentExpedPlace" placeholder="documentExpedPlace">
                                                        <label for="documentExpedPlace">document Exped. Place
                                                            <label id="documentExpedPlace-error" class="error" for="documentExpedPlace"></label></label>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['nationality']; ?>" class="form-control" id="nationality" name="nationality" placeholder="nationality">
                                                        <label for="nationality">Nationality</label>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- stateId - cityId - districtId -->
                                            <div class="row pt-3">
                                                <div class="col-4">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="stateId" id="stateId" class="form-select form-control">
                                                            <option value="">Select</option>
                                                            <?php for ($i = 0; $i < count($states); $i++) {
                                                                $select = ($states[$i]['stateId'] == $data['employeeInfo']['stateId']) ? 'selected' : '';
                                                                echo '<option ' . $select . ' value="' . $states[$i]['stateId'] . '">' . $states[$i]['stateName'] . '</option>';
                                                            } ?>
                                                        </select>
                                                        <label for="dob">State</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="cityId" id="cityId" class="form-select form-control">
                                                            <option value="">Select</option>
                                                        </select>
                                                        <label for="dob">City</label>
                                                    </div>
                                                    <input type="hidden" name="cityIdHidden" id="cityIdHidden" value="<?php echo $data['employeeInfo']['cityId']; ?>">
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="districtId" id="districtId" class="form-select form-control">
                                                            <option value="">Select</option>
                                                        </select>
                                                        <label for="dob">District</label>
                                                    </div>
                                                    <input type="hidden" name="districtIdHidden" id="districtIdHidden" value="<?php echo $data['employeeInfo']['districtId']; ?>">

                                                </div>
                                            </div>
                                            <!-- Address -->
                                            <div class="row pt-3">
                                                <div class="col-12">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <textarea class="form-control" id="address" name="address" placeholder="address"><?php echo $data['employeeInfo']['address']; ?></textarea>
                                                        <label for="address">Addres</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- children -->
                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select class="form-control" name="maritalStatus" id="maritalStatus">
                                                            <option value="">Select</option>
                                                            <option <?php echo ("Soltero/a" == $data['employeeInfo']['maritalStatus']) ? 'selected' : '' ?> value="Soltero/a">Soltero/a</option>
                                                            <option <?php echo ("Casado/a" == $data['employeeInfo']['maritalStatus']) ? 'selected' : '' ?> value="Casado/a">Casado/a</option>
                                                            <option <?php echo ("Separados" == $data['employeeInfo']['maritalStatus']) ? 'selected' : '' ?> value="Separados">Separados</option>
                                                            <option <?php echo ("Viudo/a" == $data['employeeInfo']['maritalStatus']) ? 'selected' : '' ?> value="Viudo/a">Viudo/a</option>
                                                            <option <?php echo ("Divorciado/a" == $data['employeeInfo']['maritalStatus']) ? 'selected' : '' ?> value="Divorciado/a">Divorciado/a</option>
                                                        </select>
                                                        <label for="maritalStatus">Marital Status</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="number" value="<?php echo $data['employeeInfo']['children']; ?>" class="form-control" id="children" name="children" placeholder="children">
                                                        <label for="children">Children <label id="children-error" class="error" for="children"></label></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Education Level -->
                                            <div class="row pt-3" style="min-height: 135px;">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['educationLevel']; ?>" class="form-control" id="educationLevel" name="educationLevel" placeholder="educationLevel">
                                                        <label for="educationLevel">Education Level</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="text" value="<?php echo $data['employeeInfo']['career']; ?>" class="form-control" id="career" name="career" placeholder="career">
                                                        <label for="career">career</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Bank Account Detail / AFP</h5>
                                        </div>
                                        <div class="card-body" style="min-height: 317px;">
                                            <!-- Bank -->
                                            <div class="row ">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="bankId" id="bankId" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php for ($i = 0; $i < count($banks); $i++) {
                                                                $select = ($banks[$i]['bankId'] == $data['employeeInfo']['bankId']) ? 'selected' : '';
                                                                echo '<option ' . $select . ' value="' . $banks[$i]['bankId'] . '">' . $banks[$i]['name'] . '</option>';
                                                            } ?>
                                                        </select>
                                                        <label for="bankId">Bank</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="number" value="<?php echo $data['employeeInfo']['bankAccount']; ?>" class="form-control" id="bankAccount" name="bankAccount">
                                                        <label for="bankAccount">Bank Account</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- AFP -->
                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="afpTypeId" id="afpTypeId" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php for ($i = 0; $i < count($afps); $i++) {
                                                                $select = ($afps[$i]['afpId'] == $data['employeeInfo']['afpTypeId']) ? 'selected' : '';
                                                                echo '<option ' . $select . ' value="' . $afps[$i]['afpId'] . '">' . $afps[$i]['name'] . '</option>';
                                                            } ?>
                                                        </select>
                                                        <label for="afpTypeId">AFP Type</label>

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="number" value="<?php echo $data['employeeInfo']['afpNumber']; ?>" name="afpNumber" id="afpNumber" placeholder="afpNumber" class="form-control">
                                                        <label for="afpNumber">AFP Number <label id="afpNumber-error" class="error" for="corporateEmail"></label> </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- SSN  -->
                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="number" value="<?php echo $data['employeeInfo']['ssn']; ?>" class="form-control" id="ssn" name="ssn" placeholder="ssn">
                                                        <label for="ssn">ISSS</label>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Company Detail</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Photo -->
                                            <div class="row">
                                                <?php if (!empty($data['employeeInfo']['photo'])) {
                                                    $name = $data['employeeInfo']['firstName'] . " " . $data['employeeInfo']['firstLastName'];
                                                    echo '<div class="col-md-3 col-sm-12 pb-4">
                                                        <div id="photo-preview" class="preview">';
                                                    echo '<img class="img-thumbnail" src="' . URLROOT . '/public/documents/photo/' . $data['employeeInfo']['photo'] . '" width="200">';
                                                    $nameButton = 'Change Photo';
                                                    $classButton = 'btn btn-danger';
                                                    echo ' <i onclick="getPhotoInfo(' . $data['employeeInfo']['badge'] . ', \'' . $name . '\', \'' . $data['employeeInfo']['photo'] . '\')" data-bs-toggle="modal" data-bs-target="#modalPhotoPreview" data-bs-target="#staticBackdrop" class="fa fa-expand edit-image-icon"></i></div></div>';
                                                } else {
                                                    echo '<div id="col-img" ><div id="photo-preview" class="preview"></div></div>';
                                                    $nameButton = 'Select Photo';
                                                    $classButton = 'btn btn-success';
                                                } ?>

                                                <div class="col-md-3 col-sm-12">
                                                    <div class="file-input">
                                                        <label for="photo">Photo:</label><br>
                                                        <input type="file" id="photo" name="photo" accept="image/*">
                                                        <button type="button" id="btn-photo" class="mt-2 <?php echo $classButton; ?>" onclick="document.getElementById('photo').click();"><?php echo $nameButton; ?></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <label for="photo">Badge:</label><br>
                                                    <a class="mt-2 btn btn-primary btn-border cursor-unset"># <?php echo $data['employeeInfo']['badge']; ?></a>
                                                </div>

                                            </div>
                                            <div class="row pt-4">
                                                <div class="col-md-4 col-sm-12 ">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <div class="form-floating form-floating-custom mb-3">
                                                            <?php $st = ($data['employeeInfo']['status'] == 1) ? 'Active' : 'Inactive'; ?>
                                                            <input disabled type="text" value="<?php echo $st; ?>" class="form-control" id="status" name="status" placeholder="status">
                                                            <label class="disableLabel" for="status">Status</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($data['employeeInfo']['status'] != 1) { ?>
                                                    <div class="col-md-4 col-sm-12 ">
                                                        <div class="form-floating form-floating-custom mb-3">
                                                            <div class="form-floating form-floating-custom mb-3">
                                                                <input disabled type="text" value="<?php echo $data['employeeInfo']['endDate']; ?>" class="form-control" id="endDate" name="endDate" placeholder="endDate">
                                                                <label class="disableLabel" for="endDate">End Date</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 ">
                                                        <div class="form-floating form-floating-custom mb-3">
                                                            <div class="form-floating form-floating-custom mb-3">
                                                                <?php $re = ($data['employeeInfo']['reHirable'] == 1) ? 'Yes' : 'No'; ?>

                                                                <input disabled type="text" value="<?php echo $re; ?>" class="form-control" id="status" name="status" placeholder="status">
                                                                <label class="disableLabel" for="status">Re-Hirable</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <!-- Departament -->
                                            <div class="row pt-4">

                                                <div class="col-6">
                                                    <label class="positionSelect" for="depId">Departament <span class="text-danger">*</span>
                                                        <label id="depId-error" class="error" for="depId"></label></label>
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="departmentId" id="departmentId" class="form-select form-control js-select-basic">
                                                            <option value="">Select</option>
                                                            <?php for ($i = 0; $i < count($departments); $i++) {
                                                                $select = ($departments[$i]['departmentId'] == $data['employeeInfo']['departmentId']) ? 'selected' : '';
                                                                echo '<option ' . $select . ' value="' . $departments[$i]['departmentId'] . '">' . $departments[$i]['name'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="positionSelect" for="areaId">Area <span class="text-danger">*</span>
                                                        <label id="areaId-error" class="error" for="areaId"></label></label>
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="areaId" id="areaId" class="form-select form-control js-select-basic">
                                                            <option value="">Select</option>
                                                            <?php for ($i = 0; $i < count($areas); $i++) {
                                                                $select = ($areas[$i]['areaId'] == $data['employeeInfo']['areaId']) ? 'selected' : '';
                                                                echo '<option ' . $select . ' value="' . $areas[$i]['areaId'] . '">' . $areas[$i]['areaName'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row pt-4">

                                                <div class="col-6">
                                                    <label class="positionSelect" for="positionId">Position <span class="text-danger">*</span>
                                                        <label id="positionId-error" class="error" for="positionId"></label></label>
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="positionId" id="positionId" class="form-select form-control js-select-basic">
                                                            <option value="">Select</option>
                                                            <?php for ($i = 0; $i < count($positions); $i++) {
                                                                $select = ($positions[$i]['positionId'] == $data['employeeInfo']['positionId']) ? 'selected' : '';
                                                                echo '<option ' . $select . '  value="' . $positions[$i]['positionId'] . '">' . $positions[$i]['positionName'] . ' | ' . $positions[$i]['positionNameEnglish'] . ' </option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="positionSelect" for="supId">Superior <span class="text-danger">*</span>
                                                        <label id="supId-error" class="error" for="supId"></label></label>
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="superiorId" id="superiorId" class="form-select form-control js-select-basic">
                                                            <option value="">Select</option>
                                                            <?php for ($i = 0; $i < count($superiors); $i++) {
                                                                $select = ($superiors[$i]['userId'] == $data['employeeInfo']['superiorId']) ? 'selected' : '';
                                                                echo '<option ' . $select . '  value="' . $superiors[$i]['userId'] . '">' . $superiors[$i]['fullname'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input disabled type="date" value="<?php echo $data['employeeInfo']['hiredDateOld']; ?>" class="form-control" id="hiredDateOld" name="hiredDateOld" placeholder="hiredDateOld">
                                                        <label class="disableLabel" for="hiredDateOld">Hired Date Old
                                                            <label id="hiredDateOld-error" class="error" for="hiredDateOld"></label></label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="date" value="<?php echo $data['employeeInfo']['hiredDate']; ?>" class="form-control" id="hiredDate" name="hiredDate" placeholder="hiredDate">
                                                        <label for="hiredDate">Hired Date <span class="text-danger">*</span>
                                                            <label id="hiredDate-error" class="error" for="hiredDate"></label></label>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- corporate Email -->
                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="email" value="<?php echo $data['employeeInfo']['corporateEmail']; ?>" class="form-control" id="corporateEmail" name="corporateEmail" placeholder="Corporate Email">
                                                        <label for="corporateEmail">Corporate Email
                                                            <label id="corporateEmail-error" class="error" for="corporateEmail"></label></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- contractType -->
                                            <div class="row pt-3">
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <select name="contractType" id="contractType" class="form-select form-control">
                                                            <option value="">Select</option>
                                                            <option <?php echo ("F" == $data['employeeInfo']['contractType']) ? 'selected' : '' ?> value="F">Full Time</option>
                                                            <option <?php echo ("PT" == $data['employeeInfo']['contractType']) ? 'selected' : '' ?> value="PT">Part Time</option>
                                                            <option <?php echo ("GS" == $data['employeeInfo']['contractType']) ? 'selected' : '' ?> value="GS">Graveyard Shift</option>
                                                        </select>
                                                        <label for="dob">contract Type</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-custom mb-3">
                                                        <input type="number" value="<?php echo $data['employeeInfo']['workHours']; ?>" class="form-control" id="workHours" name="workHours" placeholder="workHours">
                                                        <label for="corporateEmail">Work Hours</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- salary -->
                                            <?php if (getPLSalary()) { ?>
                                                <div class="row pt-3">
                                                    <div class="col-6">
                                                        <div class="form-group form-group-default">
                                                            <label for="Name">Salary</label>
                                                            <div class="input-group">
                                                                <?php
                                                                    $di =  (empty($data['employeeInfo']['salary']) || $data['employeeInfo']['salary'] <= 0) ? '' : 'disabled';
                                                                    $typeField = ($di == 'disabled') ? 'password' : 'text';
                                                                ?>
                                                                <input <?php echo $di; ?> id="salary" name="salary" type="<?php echo $typeField ?>" value="<?php echo $data['employeeInfo']['salary']; ?>" class="form-control">
                                                                <?php if ($di == 'disabled') { ?>
                                                                    <span class="input-group-text">
                                                                        <i class="fas fa-eye" id="togglePassword"></i>
                                                                    </span>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="positionSelect" for="billTo">Bill To <span class="text-danger">*</span>
                                                            <label id="billTo-error" class="error" for="billTo"></label></label>
                                                        <div class="form-floating form-floating-custom mb-3">
                                                            <select name="billTo" id="billTo" class="form-select form-control js-select-basic">
                                                                <option value="">Select</option>
                                                                <?php for ($i = 0; $i < count($bills); $i++) {
                                                                    $select = ($bills[$i]['billToId'] == $data['employeeInfo']['billTo']) ? 'selected' : '';
                                                                    echo '<option ' . $select . '  value="' . $bills[$i]['billToId'] . '">' . $bills[$i]['billName'] . '</option>';
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <hr class="hr-color">

                                            <div class="row pt-3">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" <?php echo ($data['employeeInfo']['contractSigning'] == 1) ? 'checked' : ''; ?> type="checkbox" <?php  ?> value="1" name="contractsigning" id="contractsigning">
                                                        <label class="form-check-label" for="contractsigning">
                                                            Contract Signing
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" <?php echo ($data['employeeInfo']['signingContractHeadset'] == 1) ? 'checked' : ''; ?> type="checkbox" value="1" name="signingContractHeadset" id="signingContractHeadset">
                                                        <label class="form-check-label" for="signingContractHeadset">
                                                            Headset Contract Signing
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row pt-3" style="min-height: 147px;">

                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" <?php echo ($data['employeeInfo']['signingConfidentialityAgreement'] == 1) ? 'checked' : ''; ?> type="checkbox" value="1" name="signingConfidentialityAgreement" id="signingConfidentialityAgreement">
                                                        <label class="form-check-label" for="signingConfidentialityAgreement">
                                                            Non-disclosure agreement
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" <?php echo ($data['employeeInfo']['bonus'] == 1) ? 'checked' : ''; ?> type="checkbox" value="1" name="bonus" id="bonus">
                                                        <label class="form-check-label" for="bonus">
                                                            Bono
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-xl-6 col-sm-12">

                                </div>
                            </div>
                            <div class="row d-flex justify-content-end">
                                <div class="col-2 d-flex justify-content-end">
                                    <input type="hidden" id="employeeId" name="employeeId" value="<?php echo base64_encode($data['employeeInfo']['employeeId']) ?>">
                                    <input type="hidden" id="badge" name="badge" value="<?php echo base64_encode($data['employeeInfo']['badge']) ?>">
                                    <?php $p = (getPLCreateEditDeleteInfoEmployee()) ? 'Yes' : 'No'; ?>
                                    <input type="hidden" id="disabledForm" name="disabledForm" value="<?php echo $p; ?>">
                                    <?php if (getPLCreateEditDeleteInfoEmployee()): ?>
                                        <button type="submit" class="btn btn-primary">Save Employee</button>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Employee Documents -->
                    <div class="tab-pane fade " id="employee-documents" role="tabpanel" aria-labelledby="tab-employee-documents">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Employee Documents</h5>
                                    </div>
                                    <div class="card-body" style="min-height: 880px;">
                                        <div class="row">
                                            <div class="d-flex justify-content-between pb-5">
                                                <?php if (getPLCreateEditDeleteInfoEmployee()): ?>
                                                    <button id="btn-add-emEmergencyCon" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#modalAddDocument"><i class="fa fa-plus"></i> Upload Document</button>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="tb-EmergencyContact" class="table table-hover mt-5">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Name</th>
                                                                <th style="width: 30%;" scope="col">Type</th>
                                                                <th scope="col">Managment</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($employeeDocumentsInfo)) {
                                                                $n = 1;
                                                                for ($i = 0; $i < count($employeeDocumentsInfo); $i++) {
                                                                    echo '<tr>';
                                                                    echo '<th scope="row">' . $n++ . '</th>';
                                                                    echo '<td> <a href="' . URLROOT . '/public/documents/' . $employeeDocumentsInfo[$i]['folderName'] . '/' . $employeeDocumentsInfo[$i]['document'] . '" target="_BLANK" >' . $employeeDocumentsInfo[$i]['document'] . '</a></td>';
                                                                    echo '<td> ' . $employeeDocumentsInfo[$i]['name'] . '</td>';

                                                                    echo '<td>';

                                                                    if (getPLCreateEditDeleteInfoEmployee()) {
                                                                        echo '<button id="delete_' . $employeeDocumentsInfo[$i]['employeeDocumentId'] . '_document" type="button" 
                                                                        data-documentName="' . $employeeDocumentsInfo[$i]['document'] . '" data-nameDirDocument="' . $employeeDocumentsInfo[$i]['folderName'] . '/' . $employeeDocumentsInfo[$i]['document'] . '" 
                                                                        onclick="removeDocument(' . $employeeDocumentsInfo[$i]['employeeDocumentId'] . ')"
                                                                        class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>';
                                                                    }

                                                                    echo '<a href="' . URLROOT . '/public/documents/' . $employeeDocumentsInfo[$i]['folderName'] . '/' . $employeeDocumentsInfo[$i]['document'] . '" target="_BLANK"  class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>';
                                                                    echo '</td>';
                                                                    echo '</tr>';
                                                                }
                                                            } else {
                                                                echo '<tr><td class="text-center" colspan="6">No data</td></tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule -->
                    <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="tab-schedule">
                        <form id="addEmployeeSchedule" method="POST" action="#">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Employee Schedules</h5>
                                        </div>
                                        <div class="card-body" style="min-height: 880px;">
                                            <!-- schedule -->
                                            <div class="row d-flex justify-content-center">

                                                <?php if (!empty($employeeSchedule)) { ?>

                                                    <div class="col-md-8 col-12">
                                                        <p class="fw-medium">Days: <span class="fw-light"><?php echo $employeeSchedule['days'] ?></span></p>
                                                        <p class="fw-medium mb-3">Days OFF: <span class="fw-light"><?php echo $employeeSchedule['daysOff'] ?></span></p>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Day</th>
                                                                        <th scope="col">Time</th>
                                                                        <th scope="col">Lunch</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Monday</td>
                                                                        <td class="<?php echo ($employeeSchedule['monday'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['monday'] ?></td>
                                                                        <td class="<?php echo ($employeeSchedule['mondayLunch'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['mondayLunch'] ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Tuesday</td>
                                                                        <td class="<?php echo ($employeeSchedule['tuesday'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['tuesday'] ?></td>
                                                                        <td class="<?php echo ($employeeSchedule['tuesdayLunch'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['tuesdayLunch'] ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Wednesday</td>
                                                                        <td class="<?php echo ($employeeSchedule['wednesday'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['wednesday'] ?></td>
                                                                        <td class="<?php echo ($employeeSchedule['wednesdayLunch'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['wednesdayLunch'] ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Thursday</td>
                                                                        <td class="<?php echo ($employeeSchedule['thursday'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['thursday'] ?></td>
                                                                        <td class="<?php echo ($employeeSchedule['thursdayLunch'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['thursdayLunch'] ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Friday</td>
                                                                        <td class="<?php echo ($employeeSchedule['friday'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['friday'] ?></td>
                                                                        <td class="<?php echo ($employeeSchedule['fridayLunch'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['fridayLunch'] ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Saturday</td>
                                                                        <td class="<?php echo ($employeeSchedule['saturday'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['saturday'] ?></td>
                                                                        <td class="<?php echo ($employeeSchedule['saturdayLunch'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['saturdayLunch'] ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sunday</td>
                                                                        <td class="<?php echo ($employeeSchedule['sunday'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['sunday'] ?></td>
                                                                        <td class="<?php echo ($employeeSchedule['sundayLunch'] == '-OFF-') ? 'off-color' : '' ?>"><?php echo $employeeSchedule['sundayLunch'] ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <!-- <small class="pt-5"> *PAra editar el horario crear una accion de Personal (AP).</small> -->
                                                        </div>

                                                    </div>
                                                <?php } else { ?>

                                                    <div class="col-md-8 col-12 pt-5 pb-5">
                                                        <select id="employeeScheduleStandar" class="form-select" aria-label="Default select example">
                                                            <option value="" selected>Select Employee Schedule Template</option>
                                                            <option value="0">06:00 - 15:00</option>
                                                            <option value="1">06:30 - 15:30</option>
                                                            <option value="2">07:00 - 16:00</option>
                                                            <option value="3">08:00 - 17:00</option>
                                                            <option value="4">09:00 - 18:00</option>
                                                            <option value="5">11:00 - 20:00</option>
                                                            <option value="6">12:00 - 21:00</option>
                                                            <option value="7">14:00 - 23:00</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-8 col-12">
                                                        <div class="table-responsive">

                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Day</th>
                                                                        <th scope="col">OFF</th>
                                                                        <th scope="col">Time</th>
                                                                        <th scope="col">Lunch</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Monday</td>
                                                                        <td>
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input schedule-input" type="checkbox" role="switch" id="mondayOff" name="mondayOff">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center">From <input class="form-control schedule-input validate-field-from" type="time" name="mondayFrom" id="mondayFrom"> To<input class="form-control schedule-input" type="time" name="mondayTo" id="mondayTo"></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center"><input class="form-control schedule-input" type="number" name="mondayH" id="mondayH">Hour</div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Tuesday</td>
                                                                        <td>
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input schedule-input" type="checkbox" role="switch" id="tuesdayOff">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center">From <input class="form-control schedule-input validate-field-from" type="time" name="tuesdayFrom" id="tuesdayFrom"> To<input class="form-control schedule-input" type="time" name="tuesdayTo" id="tuesdayTo"></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center"><input class="form-control schedule-input" type="number" name="tuesdayH" id="tuesdayH">Hour</div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Wednesday</td>
                                                                        <td>
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input schedule-input" type="checkbox" role="switch" id="wednesdayOff">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center">From <input class="form-control schedule-input validate-field-from" type="time" name="wednesdayFrom" id="wednesdayFrom"> To<input class="form-control schedule-input" type="time" name="wednesdayTo" id="wednesdayTo"></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center"><input class="form-control schedule-input" type="number" name="wednesdayH" id="wednesdayH">Hour</div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Thursday</td>
                                                                        <td>
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input schedule-input" type="checkbox" role="switch" id="thursdayOff">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center">From <input class="form-control schedule-input validate-field-from" type="time" name="thursdayFrom" id="thursdayFrom"> To<input class="form-control schedule-input" type="time" name="thursdayTo" id="thursdayTo"></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center"><input class="form-control schedule-input" type="number" name="thursdayH" id="thursdayH">Hour</div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Friday</td>
                                                                        <td>
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input schedule-input" type="checkbox" role="switch" id="fridayOff">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center">From <input class="form-control schedule-input validate-field-from" type="time" name="fridayFrom" id="fridayFrom"> To<input class="form-control schedule-input" type="time" name="fridayTo" id="fridayTo"></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center"><input class="form-control schedule-input" type="number" name="fridayH" id="fridayH">Hour</div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Saturday</td>
                                                                        <td>
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input schedule-input" type="checkbox" role="switch" id="saturdayOff">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center">From <input class="form-control schedule-input schedule-stand validate-field-from" type="time" name="saturdayFrom" id="saturdayFrom"> To<input class="form-control schedule-input schedule-stand" type="time" name="saturdayTo" id="saturdayTo"></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center"><input class="form-control schedule-input schedule-stand" type="number" name="saturdayH" id="saturdayH">Hour</div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sunday</td>
                                                                        <td>
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input schedule-input" type="checkbox" role="switch" id="sundayOff">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center">From <input class="form-control schedule-input schedule-stand validate-field-from" type="time" name="sundayFrom" id="sundayFrom"> To<input class="form-control schedule-input schedule-stand" type="time" name="sundayTo" id="sundayTo"></div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex gap-2 align-items-center"><input class="form-control schedule-input schedule-stand" type="number" name="sundayH" id="sundayH">Hour</div>
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>


                                                            <!-- <span class="pt-5"> * If you want to edit this schedule you would create a new AP.</span> -->
                                                        </div>

                                                    </div>

                                                    <div class="col-8 d-flex justify-content-end">
                                                        <input type="hidden" id="idEmp" name="idEmp" value="<?php echo base64_encode($data['employeeInfo']['employeeId']) ?>">
                                                        <button type="submit" class="btn btn-primary">Save Employee Schedule</button>
                                                    </div>

                                                <?php } ?> <!-- close empty schedule -->


                                            </div> <!-- row -->


                                        </div>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>

                    <!-- Emergency Contacts -->
                    <div class="tab-pane fade " id="emergency-contacts" role="tabpanel" aria-labelledby="tab-emergency-contacts">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Emergency Contacts</h5>
                                    </div>
                                    <div class="card-body" style="min-height: 880px;">
                                        <div class="row">
                                            <div class="d-flex justify-content-between">
                                                <?php if (getPLCreateEditDeleteInfoEmployee()): ?>
                                                    <button id="btn-add-emEmergencyCon" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#modalAddEmergency"><i class="fa fa-plus"></i> Add Emergency Contact</button>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-12 pt-5">
                                                <div class="table-responsive">
                                                    <table id="tb-EmergencyContact" class="table table-hover mt-5">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">FullName</th>
                                                                <th scope="col">Relationship</th>
                                                                <th scope="col">Contact Phone</th>
                                                                <th scope="col">Email</th>
                                                                <th scope="col">Managment</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($employeeEmergencyContacts)) {
                                                                $n = 1;
                                                                for ($i = 0; $i < count($employeeEmergencyContacts); $i++) {
                                                                    echo '<tr>';
                                                                    echo '<th scope="row">' . $n++ . '</th>';
                                                                    echo '<td>' . $employeeEmergencyContacts[$i]['fullName'] . '</td>';
                                                                    echo '<td>' . $employeeEmergencyContacts[$i]['relationshipNameEnglish'] . '</td>';
                                                                    echo '<td>' . $employeeEmergencyContacts[$i]['contactPhone'] . '</td>';
                                                                    echo '<td>' . $employeeEmergencyContacts[$i]['email'] . '</td>';
                                                                    echo '<td>';

                                                                    echo '<button onclick="getInfoEmergeContact(' . $employeeEmergencyContacts[$i]['emergencyContactId'] . ')" id="btn-edit-emEmergencyCon" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalEditEmergency"><i class="fa fa-edit"></i></button>';
                                                                    if (getPLCreateEditDeleteInfoEmployee()) {
                                                                        echo '<button id="delete_' . $employeeEmergencyContacts[$i]['emergencyContactId'] . '" type="button" 
                                                                    data-fullname="' . $employeeEmergencyContacts[$i]['fullName'] . '" 
                                                                    onclick="removeEmergeContact(' . $employeeEmergencyContacts[$i]['emergencyContactId'] . ')"
                                                                    class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>';
                                                                    }
                                                                    echo '</td>';
                                                                    echo '</tr>';
                                                                }
                                                            } else {
                                                                echo '<tr><td class="text-center" colspan="6">No data</td></tr>';
                                                            }

                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>

                    <!-- financial-dependents -->
                    <div class="tab-pane fade " id="financial-dependents" role="tabpanel" aria-labelledby="tab-financial-dependents">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Financial Dependents</h5>
                                    </div>
                                    <div class="card-body" style="min-height: 880px;">
                                        <div class="row">
                                            <div class="d-flex justify-content-between">
                                                <?php if (getPLCreateEditDeleteInfoEmployee()): ?>
                                                    <button id="btn-add-dependent" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#modalAddDependents"><i class="fa fa-plus"></i> Add Dependent</button>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-12 pt-5">
                                                <div class="table-responsive">
                                                    <table id="tb-EmergencyContact" class="table table-hover mt-5">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">FullName</th>
                                                                <th scope="col">Relationship</th>
                                                                <th scope="col">Age</th>
                                                                <th scope="col">Managment</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($financialDependents)) {
                                                                $n = 1;
                                                                for ($i = 0; $i < count($financialDependents); $i++) {
                                                                    echo '<tr>';
                                                                    echo '<th scope="row">' . $n++ . '</th>';
                                                                    echo '<td>' . $financialDependents[$i]['fullName'] . '</td>';
                                                                    echo '<td>' . $financialDependents[$i]['relationshipNameEnglish'] . '</td>';
                                                                    echo '<td>' . $financialDependents[$i]['age'] . '</td>';
                                                                    echo '<td>';
                                                                    echo '<button onclick="getInfoDependent(' . $financialDependents[$i]['financialDependentId'] . ')" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalEditDependents"><i class="fa fa-edit"></i></button>';

                                                                    if (getPLCreateEditDeleteInfoEmployee()) {
                                                                        echo '<button id="delete_' . $financialDependents[$i]['financialDependentId'] . '_dependent" type="button" 
                                                                        data-fullnameDependent="' . $financialDependents[$i]['fullName'] . '" 
                                                                        onclick="removeFinancialDependent(' . $financialDependents[$i]['financialDependentId'] . ')"
                                                                        class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>';
                                                                    }

                                                                    echo ' </td>';
                                                                    echo '</tr>';
                                                                }
                                                            } else {
                                                                echo '<tr><td class="text-center" colspan="6">No data</td></tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!-- MODAL -->

        <!-- Create Emerg. Contact -->
        <div class="modal fade" id="modalAddEmergency" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddEmergencyLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Emerg. Contact</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="createEmergContact" method="POST" action="">
                        <div class="modal-body">
                            <div class="row pt-3">
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>FullName <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Relationship <span class="text-danger">*</span> </label>
                                        <select class="form-control" id="relationshipId" name="relationshipId" placeholder="">
                                            <option value="">Select</option>
                                            <?php
                                            for ($i = 0; $i < count($relationship); $i++) {
                                                echo '<option value="' . $relationship[$i]['relationshipId'] . '">' . $relationship[$i]['relationshipName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row pt-3">
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Contact Phone <span class="text-danger">*</span> </label>
                                        <input id="contactPhoneEmerContact" name="contactPhoneEmerContact" type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Email </label>
                                        <input id="emailEmergContact" name="emailEmergContact" type="email" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="idEmpEmergContact" name="idEmpEmergContact" value="<?php echo base64_encode($data['employeeInfo']['employeeId']) ?>">
                            <button type="button" id="btn-cancelAddEmerge" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Create Emerg. Contact</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Upload Document -->
        <div class="modal fade" id="modalAddDocument" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddDocumentLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddDocumentLabel">Upload Emp. Document</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formUploadFile">
                        <div class="modal-body">
                            <div class="row pt-3">
                                <div class="col-12">
                                    <div class="form-group form-group-default">
                                        <label>Document Type <span class="text-danger">*</span> </label>
                                        <select class="form-control" id="docType" name="docType" placeholder="">
                                            <option value="">Select</option>
                                            <?php
                                            for ($i = 0; $i < count($typesDocuments); $i++) {
                                                echo '<option value="' . $typesDocuments[$i]['documentTypeId'] . '">' . $typesDocuments[$i]['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 docNameOther" style="display: none;">
                                    <div class="form-group form-group-default">
                                        <label>Document Name <span class="text-danger">*</span> </label>
                                        <input class="form-control" type="text" name="nameDocumentOther" id="nameDocumentOther">
                                    </div>
                                </div>

                                <div id="fileDropzone" class="dropzone dropzoneMax" class="dropzone mb-3"></div>
                                <span class="msg-dropzone text-danger"></span>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="idEmpUpload" name="idEmpUpload" value="<?php echo base64_encode($data['employeeInfo']['employeeId']) ?>">
                            <button type="button" id="btn-cancelUpload" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="uploadButton" class="btn btn-success">Add Document</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Emerg. Contact -->
        <div class="modal fade" id="modalEditEmergency" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditEmergencyLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Emerg. Contact</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="EditEmergContact" method="POST" action="">
                        <div class="modal-body">
                            <div class="row pt-3">
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>FullName <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" id="fullName_edit" name="fullName_edit" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Relationship <span class="text-danger">*</span> </label>
                                        <select class="form-control" id="relationshipId_edit" name="relationshipId_edit" placeholder="">
                                            <option value="">Select</option>
                                            <?php
                                            for ($i = 0; $i < count($relationship); $i++) {
                                                echo '<option value="' . $relationship[$i]['relationshipId'] . '">' . $relationship[$i]['relationshipName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row pt-3">
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Contact Phone <span class="text-danger">*</span> </label>
                                        <input id="contactPhone_edit" name="contactPhone_edit" type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Email </label>
                                        <input id="email_edit" name="email_edit" type="email" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="idEmpEmergContact_edit" name="idEmpEmergContact_edit" value="">
                            <button type="button" id="btn-cancelEmergeEdit" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Edit Emerg. Contact</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Create Financial Dependents -->
        <div class="modal fade" id="modalAddDependents" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddDependentsLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddDependentsLabel">Add Financial Dependent</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="createdependent" method="POST" action="">
                        <div class="modal-body">
                            <div class="row pt-3">
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>FullName <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" id="fullNameDependent" name="fullNameDependent" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Relationship <span class="text-danger">*</span> </label>
                                        <select class="form-control" id="relationshipIdDependent" name="relationshipIdDependent" placeholder="">
                                            <option value="">Select</option>
                                            <?php
                                            for ($i = 0; $i < count($relationship); $i++) {
                                                echo '<option value="' . $relationship[$i]['relationshipId'] . '">' . $relationship[$i]['relationshipName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <!-- <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>DOB </label>
                                        <input onchange="calculateAge('dobdependent')" id="dobdependent" name="dobdependent" type="date" class="form-control" placeholder="">
                                    </div>
                                </div> -->
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Age </label>
                                        <input type="number" id="ageDependent" name="ageDependent" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group form-group-default">
                                        <label>Address </label>
                                        <textarea class="form-control" name="addressDependet" id="addressDependet"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="idEmpDependents" name="idEmpDependents" value="<?php echo base64_encode($data['employeeInfo']['employeeId']) ?>">
                            <button type="button" id="btn-cancelAddFinancialDe" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Create Financial Dependent</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Financial Dependents -->
        <div class="modal fade" id="modalEditDependents" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditDependentsLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalEditDependentsLabel">Edit Financial Dependent</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editDependents" method="POST" action="">
                        <div class="modal-body">
                            <div class="row pt-3">
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>FullName <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" id="fullName_dependentEdit" name="fullName_dependentEdit" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Relationship <span class="text-danger">*</span> </label>
                                        <select class="form-control" id="relationshipId_dependentEdit" name="relationshipId_dependentEdit" placeholder="">
                                            <option value="">Select</option>
                                            <?php
                                            for ($i = 0; $i < count($relationship); $i++) {
                                                echo '<option value="' . $relationship[$i]['relationshipId'] . '">' . $relationship[$i]['relationshipName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <!-- <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>DOB </label>
                                        <input  onchange="calculateAge('dob_dependentEdit')" id="dob_dependentEdit" name="dob_dependentEdit" type="date" class="form-control" placeholder="">
                                    </div>
                                </div> -->
                                <div class="col-6">
                                    <div class="form-group form-group-default">
                                        <label>Age </label>
                                        <input id="age_dependentEdit" name="age_dependentEdit" type="number" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group form-group-default">
                                        <label>Address </label>
                                        <textarea class="form-control" name="address_dependentEdit" id="address_dependentEdit"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="financialDependentId_dependentEdit" name="financialDependentId_dependentEdit">
                            <button type="button" id="btn-cancelEditFinancialDe" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Edit Financial Dependent</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Preview Photo -->
        <div class="modal fade" id="modalPhotoPreview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalPhotoPreviewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 name-preview-photo" id="modalPhotoPreviewLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="" class="img-fluid photo-preview" alt="img badge">
                    </div>
                </div>
            </div>
        </div>


        <!-- END-MODAL -->


        <?php require APPROOT . '/views/inc/footer.php'; ?>
    </div> <!-- end/page-inner -->
</div> <!-- end/container2 -->

<script>
    Dropzone.autoDiscover = false; // IMPORTANT: Disable auto discovery to prevent Dropzone from automatically attaching to all elements with class "dropzone"
    var myDropzone = new Dropzone("#fileDropzone", {
        url: '#',
        autoProcessQueue: false, // Prevent auto-upload
        addRemoveLinks: true,
        maxFilesize: 5, // MB
        maxFiles: 1, // Maximum number of files
        acceptedFiles: '.pdf', // Allowed file types
        init: function() {
            this.on("addedfile", function(file) {
                $(".msg-dropzone").html("");

                if (this.files.length > this.options.maxFiles) {
                    this.removeFile(file);
                    $(".msg-dropzone").html("You can only upload one file.");
                }
            });
            this.on("error", function(file, errorMessage) {
                this.removeFile(file); // Remove the file if there's an error
                $(".msg-dropzone").html(errorMessage);
            });
        }
    });


    $(document).ready(function() {

        //disabledForm -- Process to disable form if the user do not have permissions.
        var dForm = $("#disabledForm").val();
        if (dForm == 'No') {
            document.getElementById("editEmployee").querySelectorAll("input, select, button,textarea").forEach(function(element) {
                element.disabled = true;
            });
            document.getElementById("modalEditEmergency").querySelectorAll("input, select, button[type='submit'],textarea").forEach(function(element) {
                element.disabled = true;
            });
            document.getElementById("editDependents").querySelectorAll("input, select, button[type='submit'], textarea").forEach(function(element) {
                element.disabled = true;
            });
            document.getElementById("addEmployeeSchedule").querySelectorAll("input, select, button[type='submit'], textarea").forEach(function(element) {
                element.disabled = true;
            });
        }

        var initialEmployeeEdit = {};
        var initialEmergeEdit = {};
        var initialDependentEdit = {};

        // table Emerge. Contact
        // $("#tb-EmergencyContact").DataTable();

        // show tab selected ---------------------------------------------------------------------------------------------
        $('.nav-link').on('click', function() {
            var tabID = $(this).attr('href').substring(1); // Get href without #
            var newURL = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tab=' + tabID;
            window.history.replaceState({
                path: newURL
            }, '', newURL);
        });
        // Valid tab names
        var validTabs = ['general-information', 'schedule', 'emergency-contacts', 'financial-dependents', 'employee-documents'];

        // Check if there's a tab parameter in the URL when the page loads
        var urlParams = new URLSearchParams(window.location.search);
        var selectedTab = urlParams.get('tab');
        // If the selected tab is invalid or doesn't exist, default to "general-information"
        if (!selectedTab || !validTabs.includes(selectedTab)) {
            selectedTab = 'general-information';
        }
        var $lastTab = $('a[href="#' + selectedTab + '"]');
        var $lastTabPane = $('#' + selectedTab);
        // Remove active classes from all tabs and panes
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('active show');
        // Add active classes to the last selected tab and its pane
        $lastTab.addClass('active');
        $lastTabPane.addClass('active show');

        // ---------------------------------------------------------------------------------------------------------

        // Capture the initial state for Employee edit
        initialEmployeeEdit = captureDataFields('editEmployee', initialEmployeeEdit);
        // console.log(initialEmployeeEdit);

        $('.phoneMark').mask('0000-0000');
        $('#contactPhoneEmerContact').mask('0000-0000');
        $('#contactPhone_edit').mask('0000-0000');
        $('#documentNumber').mask('00000000-0');
        $('#ssn').mask('000000000');
        $('.js-select-basic').select2();

        // select City
        var stateId = $("#stateId").val();
        getCities(stateId).then(function(cities) {
            $("#cityId").val($("#cityIdHidden").val())
            initialEmployeeEdit['cityId'] = $("#cityIdHidden").val();
        }).catch(function(error) {
            console.error('Error fetching cities:', error);
        });
        // select District
        var cityId = $("#cityIdHidden").val();
        getDistrict(cityId).then(function(district) {
            $("#districtId").val($("#districtIdHidden").val());
            initialEmployeeEdit['districtId'] = $("#districtIdHidden").val();

        }).catch(function(error) {
            console.error('Error fetching district:', error);
        });

        $('#employeeScheduleStandar').on('change', function() {
            var idSD = this.value;
            var sd = [
                ['06:00', '15:00', '1'],
                ['06:30', '15:30', '1'],
                ['07:00', '16:00', '1'],
                ['08:00', '17:00', '1'],
                ['09:00', '18:00', '1'],
                ['11:00', '20:00', '1'],
                ['12:00', '21:00', '1'],
                ['14:00', '23:00', '1']
            ];

            var clearableFields = document.querySelectorAll(".schedule-input");
            clearableFields.forEach(function(field) {

                field.disabled = false;

                if (field.type === "checkbox" || field.type === "radio") {
                    field.checked = false; // Desmarcar checkbox o radio
                } else {
                    field.value = ""; // Limpiar otros campos (texto, número, etc.)
                }
            });
            if (idSD != '') {
                //monday
                $('#mondayFrom').val(sd[idSD][0]);
                $('#mondayTo').val(sd[idSD][1]);
                $('#mondayH').val(sd[idSD][2]);
                // tuesday
                $('#tuesdayFrom').val(sd[idSD][0]);
                $('#tuesdayTo').val(sd[idSD][1]);
                $('#tuesdayH').val(sd[idSD][2]);
                // wednesday
                $('#wednesdayFrom').val(sd[idSD][0]);
                $('#wednesdayTo').val(sd[idSD][1]);
                $('#wednesdayH').val(sd[idSD][2]);
                // thursday
                $('#thursdayFrom').val(sd[idSD][0]);
                $('#thursdayTo').val(sd[idSD][1]);
                $('#thursdayH').val(sd[idSD][2]);
                // friday
                $('#fridayFrom').val(sd[idSD][0]);
                $('#fridayTo').val(sd[idSD][1]);
                $('#fridayH').val(sd[idSD][2]);

                // -------------------------
                document.getElementById("saturdayOff").checked = true;
                document.getElementById("sundayOff").checked = true;

                let scheduleElements = document.getElementsByClassName("schedule-stand");
                for (let i = 0; i < scheduleElements.length; i++) {
                    scheduleElements[i].disabled = true;
                }


            } else {

                document.getElementById("saturdayOff").checked = false;
                document.getElementById("sundayOff").checked = false;

                let scheduleElements = document.getElementsByClassName("schedule-stand");
                for (let i = 0; i < scheduleElements.length; i++) {
                    scheduleElements[i].disabled = false;
                }

                var clearableFields = document.querySelectorAll(".schedule-input");
                clearableFields.forEach(function(field) {

                    if (field.type === "checkbox" || field.type === "radio") {
                        field.checked = false; // Desmarcar checkbox o radio
                    } else {
                        field.value = ""; // Limpiar otros campos (texto, número, etc.)
                    }
                });
            }

        });

        $('.schedule-input[type="checkbox"]').change(function() {

            let day = this.id.replace('Off', ''); // Obtener el ID del checkbox actual


            $('#' + day + 'From, #' + day + 'To, #' + day + 'H').val(''); // Limpiar el campo
            // Deshabilitar o habilitar los campos "From" , "To" , "H" correspondientes
            if (this.checked) {
                $('#' + day + 'From, #' + day + 'To, #' + day + 'H').prop('disabled', true);
            } else {
                $('#' + day + 'From, #' + day + 'To, #' + day + 'H').prop('disabled', false);
            }
        });

        $("#documentTypeId").change(() => {
            let documentTypeId = $("#documentTypeId").val();
            if (documentTypeId == "" || documentTypeId == null) return;
            $('#documentNumber').attr("disabled", false);
            if (documentTypeId == 1) {
                $('#documentNumber').mask('00000000-0');
            } else {
                $('#documentNumber').unmask();
            }
        });

        $('.schedule-input').change(function() {
            $("#employeeScheduleStandar").val('');
        });

        $('#stateId').on('change', function() {
            var stateId = this.value;
            getCities(stateId);
        });
        $('#cityId').on('change', function() {
            var cityId = this.value;
            getDistrict(cityId);
        })

        $('#photo').on('change', function() {
            previewFile(this, '#photo-preview');
        });

        $('#docType').on('change', function() {
            if (this.value == 9) {
                $(".docNameOther").show(1000)
            } else {
                $(".docNameOther").hide(1000)

            }
        })

        $('#modalEditEmergency').on('shown.bs.modal', function() {
            initialEmergeEdit = captureDataFields('EditEmergContact', initialEmergeEdit);
            // console.log('initialEmergeEdit:', initialEmergeEdit);
        });
        $('#modalEditDependents').on('shown.bs.modal', function() {
            initialDependentEdit = captureDataFields('editDependents', initialDependentEdit);
            // console.log('initialDependentEdit:', initialDependentEdit);
        });
        // Form ADD Employee
        $('#addEmployeeSchedule').on('submit', function(e) {
            e.preventDefault();
            var filledFields = 0;
            $('.validate-field-from').each(function() {
                if ($(this).val().trim() !== '') {
                    filledFields++;
                }
            });

            if (filledFields < 3) {
                e.preventDefault();

                var content = {};
                content.message = 'To save the schedule you have to complete 3 days.';
                content.title = "Employee";
                content.icon = "fa fa-bell";

                $.notify(content, {
                    type: 'warning',
                    placement: {
                        from: 'top',
                        align: 'right',
                    },
                    time: 1000,
                    delay: 2,
                });

            } else {

                // send data

                $.ajax({
                    url: '<?php echo URLROOT; ?>/EmployeeSchedules/saveschedule',
                    method: 'POST',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        //
                    },
                    success: function(data) {
                        console.log(data)
                        var obj = JSON.parse(data);

                        if (obj.status) {
                            // success

                            swal(obj.message, {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
                            }).then((willReload) => {
                                if (willReload) {
                                    location.reload();
                                }
                            });

                        }
                    }
                })

            }



        });
        //  /Form ADD Employee

        // Form Edit Employee
        $('#editEmployee').validate({
            rules: {
                firstName: 'required',
                children: {
                    min: 0,
                    max: 10
                },
                // secondName: 'required',
                firstLastName: 'required',
                // secondLastName: 'required',
                contactPhone: 'required',
                personalEmail: 'required',
                dob: 'required',
                documentNumber: 'required',
                documentTypeId: 'required',
                documentExpDate: 'required',
                departmentId: 'required',
                positionId: 'required',
                // corporateEmail: 'required',
                hiredDate: 'required',
                billTo: 'required',

            },
            messages: {
                firstName: 'This field is required',
                // secondName: 'This field is required',
                firstLastName: 'This field is required',
                // secondLastName: 'This field is required',
                contactPhone: 'This field is required',
                personalEmail: 'This field is required',
                dob: 'This field is required',
                documentNumber: 'This field is required',
                documentTypeId: 'This field is required',
                documentExpDate: 'This field is required',
                departmentId: 'This field is required',
                positionId: 'This field is required',
                // corporateEmail: 'This field is required',
                hiredDate: 'This field is required',
                billTo: 'This field is required',
            },
            submitHandler: function(form) {

                // AFTER VALIDATION INPUT
                swal({
                    title: "Are you sure?",
                    text: "This record will be updated",
                    type: "warning",
                    buttons: {
                        cancel: {
                            visible: true,
                            text: "No, cancel!",
                            className: "btn btn-danger",
                        },
                        confirm: {
                            text: "Yes, Change it!",
                            className: "btn btn-success",
                        },
                    },

                }).then((willChange) => {
                    if (willChange) {


                        //  SEND INFORMATION

                        var formData = new FormData(form);

                        // function is called to get the JSON object of the changed fields
                        var changedFields = getChangedFields('editEmployee', initialEmployeeEdit);
                        var jsonChangedFields = JSON.stringify(changedFields);
                        formData.append('changedFields', jsonChangedFields);


                        $.ajax({
                            url: '<?php echo URLROOT; ?>/employees/editEmpProcess',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function() {

                            },
                            success: function(data) {
                                console.log("SUCCESS");
                                console.log(data);
                                var obj = JSON.parse(data);

                                if (obj.status) {

                                    swal("It has been changed successfully! ", {
                                        icon: "success",
                                        buttons: {
                                            confirm: {
                                                className: "btn btn-success",
                                            },
                                        },
                                    }).then((willReload) => {
                                        if (willReload) {
                                            location.reload();
                                        }
                                    });

                                } else {

                                    swal(obj.message, obj.messageDetails, {
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

                    } else {
                        // swal("Your imaginary file is safe!", {
                        //     buttons: {
                        //         confirm: {
                        //             className: "btn btn-success",
                        //         },
                        //     },
                        // });
                    }
                });



            }
        });
        //  /Form Edit Employee

        $("#formUploadFile").validate({
            rules: {
                docType: {
                    required: true,
                },
                nameDocumentOther: {
                    required: true,
                    maxlength: 25,
                }
            },
            messages: {
                docType: {
                    required: "Please select a document type."
                }
            },
            submitHandler: function(form) {
                // This function is called when the form is valid
                var docType = $('#docType').val();
                var idEmpUpload = $('#idEmpUpload').val();
                var nameDocumentOther = $('#nameDocumentOther').val();
                var myDropzone = Dropzone.forElement("#fileDropzone");

                if (myDropzone.files.length === 0) {
                    $(".msg-dropzone").html("This field is required");
                    return;
                }

                // Create a FormData object
                var formData = new FormData();
                formData.append('docType', docType);
                formData.append('idEmpUpload', idEmpUpload);
                formData.append('nameDocumentOther', nameDocumentOther);

                console.log(myDropzone.files)

                // Add all files from Dropzone
                myDropzone.files.forEach(function(file) {
                    formData.append('files[]', file);
                });

                console.log(formData)
                // SEND
                $.ajax({
                    url: '<?php echo URLROOT; ?>/EmployeesDocuments/uploadDocument',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        //wait
                    },
                    success: function(data) {
                        console.log(data)
                        var obj = JSON.parse(data);

                        if (obj.status) {
                            myDropzone.removeAllFiles(); // Clear files after successful upload
                            $("#docType").val("");
                            swal(obj.message, {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
                            }).then((willReload) => {
                                if (willReload) {
                                    location.reload();
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

        $('#createEmergContact').validate({
            rules: {
                fullName: 'required',
                relationship: 'required',
                contactPhoneEmerContact: 'required'
            },
            messages: {
                fullName: 'This field is required',
                relationship: 'This field is required',
                contactPhoneEmerContact: 'This field is required'
            },
            submitHandler: function(form) {

                $.ajax({
                    url: '<?php echo URLROOT; ?>/EmergencyContacts/saveEmergContact',
                    method: 'POST',
                    data: $("#createEmergContact").serialize(),
                    beforeSend: function() {
                        //wait
                    },
                    success: function(data) {
                        console.log(data)
                        var obj = JSON.parse(data);

                        if (obj.status) {

                            $("#btn-cancelAddEmerge").click();

                            swal(obj.message, {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
                            }).then((willReload) => {
                                if (willReload) {
                                    location.reload();
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

        $('#EditEmergContact').validate({
            rules: {
                fullName_edit: 'required',
                relationshipId_edit: 'required',
                contactPhone_edit: 'required'
            },
            messages: {
                fullName_edit: 'This field is required',
                relationshipId_edit: 'This field is required',
                contactPhone_edit: 'This field is required'
            },
            submitHandler: function(form) {


                swal({
                    title: "Are you sure?",
                    text: "This record will be updated",
                    type: "warning",
                    buttons: {
                        cancel: {
                            visible: true,
                            text: "No, cancel!",
                            className: "btn btn-danger",
                        },
                        confirm: {
                            text: "Yes, Change it!",
                            className: "btn btn-success",
                        },
                    },

                }).then((willChange) => {

                    if (willChange) {
                        // alert("AJAX")

                        var formData = new FormData(form);

                        // console.log(initialEmergeEdit)

                        // function is called to get the JSON object of the changed fields
                        var changedFields = getChangedFields('EditEmergContact', initialEmergeEdit);
                        var jsonChangedFields = JSON.stringify(changedFields);
                        formData.append('changedFields', jsonChangedFields);

                        $.ajax({
                            url: '<?php echo URLROOT; ?>/EmergencyContacts/editEmergContact',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function() {
                                //wait
                            },
                            success: function(data) {
                                console.log(data)
                                var obj = JSON.parse(data);

                                if (obj.status) {

                                    // click
                                    $("#btn-cancelEmergeEdit").click();

                                    swal(obj.message, {
                                        icon: "success",
                                        buttons: {
                                            confirm: {
                                                className: "btn btn-success",
                                            },
                                        },
                                    }).then((willReload) => {
                                        if (willReload) {
                                            location.reload();
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


            }
        });

        // Finance Dependents 
        $('#createdependent').validate({
            rules: {
                fullNameDependent: 'required',
                relationshipIdDependent: 'required'
            },
            messages: {
                fullNameDependent: 'This field is required',
                relationshipIdDependent: 'This field is required'
            },
            submitHandler: function(form) {

                $.ajax({
                    url: '<?php echo URLROOT; ?>/FinancialDependents/addFinancialDependent',
                    method: 'POST',
                    data: $("#createdependent").serialize(),
                    beforeSend: function() {
                        //wait
                    },
                    success: function(data) {
                        console.log(data)
                        var obj = JSON.parse(data);

                        if (obj.status) {

                            $("#btn-cancelAddFinancialDe").click();

                            swal(obj.message, {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
                            }).then((willReload) => {
                                if (willReload) {
                                    location.reload();
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

        $('#editDependents').validate({
            rules: {
                fullName_dependentEdit: 'required',
                relationshipId_dependentEdit: 'required'
            },
            messages: {
                fullName_dependentEdit: 'This field is required',
                relationshipId_dependentEdit: 'This field is required'
            },
            submitHandler: function(form) {
                swal({
                    title: "Are you sure?",
                    text: "This record will be updated",
                    type: "warning",
                    buttons: {
                        cancel: {
                            visible: true,
                            text: "No, cancel!",
                            className: "btn btn-danger",
                        },
                        confirm: {
                            text: "Yes, Change it!",
                            className: "btn btn-success",
                        },
                    },

                }).then((willChange) => {

                    if (willChange) {

                        var formData = new FormData(form);
                        var changedFields = getChangedFields('editDependents', initialDependentEdit);
                        var jsonChangedFields = JSON.stringify(changedFields);
                        formData.append('changedFields', jsonChangedFields);

                        $.ajax({
                            url: '<?php echo URLROOT; ?>/FinancialDependents/editFinancialDependent',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function() {
                                //wait
                            },
                            success: function(data) {
                                console.log(data)

                                var obj = JSON.parse(data);
                                if (obj.status) {

                                    // click
                                    $("#btn-cancelEditFinancialDe").click();

                                    swal(obj.message, {
                                        icon: "success",
                                        buttons: {
                                            confirm: {
                                                className: "btn btn-success",
                                            },
                                        },
                                    }).then((willReload) => {
                                        if (willReload) {
                                            location.reload();
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


            }
        });

        $('#togglePassword').on('click', function() {
            // Get the input field
            var input = $('#salary');

            // Check the current type of the input field
            if (input.attr('type') === 'password') {
                input.attr('type', 'text'); // Show the value
                $(this).removeClass('fa-eye').addClass('fa-eye-slash'); // Toggle the icon
            } else {
                input.attr('type', 'password'); // Hide the value
                $(this).removeClass('fa-eye-slash').addClass('fa-eye'); // Toggle the icon
            }
        });


    }); // End-ready

    function getPhotoInfo(Badge, Fullname, photo) {
        var link = '<?php echo URLROOT; ?>/public/documents/photo/' + photo;
        $('.photo-preview').attr('src', link);
        $('.name-preview-photo').html(Badge + ' | ' + Fullname);
    }

    // Function to capture the initial state of form inputs
    function captureDataFields(formId, constNameVar) {
        $('#' + formId).find('input, select, textarea, checkbox').each(function() {
            if ($(this).attr('type') === 'checkbox') {
                constNameVar[$(this).attr('name')] = $(this).is(':checked') ? 1 : 0; // Capture 0 if unchecked, 1 if checked
            } else {
                constNameVar[$(this).attr('name')] = $(this).val();
            }


        });
        return constNameVar;
    }

    function getChangedFields(formId, varNameConst) {
        var changedFields = {};
        var ignoredFields = [
            'hiredDateOld',
            'endDate',
            'reHirable',
            'status'
        ]; // Lista de campos a ignorar


        $('#' + formId).find('input, select, textarea').each(function() {
            var name = $(this).attr('name');
            if (name && varNameConst.hasOwnProperty(name) && !ignoredFields.includes(name)) {

                var currentValue = $(this).val();

                if ($(this).attr('type') === 'checkbox') {
                    currentValue = $(this).is(':checked') ? 1 : 0; // Capture 0 if unchecked, 1 if checked
                }


                var initialValue = varNameConst[name] == null ? '' : varNameConst[name];
                if (currentValue !== initialValue) {
                    changedFields[name] = currentValue;
                }
            }
        });
        // console.log(changedFields)
        return changedFields;
    }

    function previewFile(input, previewDiv) {
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var previewContent;

            if (file.type.startsWith('image/')) {
                previewContent = '<img class="img-thumbnail" src="' + e.target.result + '" width="200">';
                $('#col-img').addClass('col-3');
            } else {
                previewContent = '<span><i class="fas fa-file"></i> ' + file.name + '</span>';
            }

            $(previewDiv).html(previewContent);
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            $(previewDiv).html('');
        }
    }

    function getCities(value) {
        var stateId = value;
        // Clean District
        const districtId = document.getElementById('districtId');
        districtId.innerHTML = ''; // Clear previous options
        const optionClean = document.createElement('option');
        optionClean.value = '';
        optionClean.textContent = 'Select';
        districtId.appendChild(optionClean);
        // Clean District
        const cityId = document.getElementById('cityId');
        cityId.innerHTML = ''; // Clear previous options
        const optionCleanCity = document.createElement('option');
        optionCleanCity.value = '';
        optionCleanCity.textContent = 'Select';
        cityId.appendChild(optionCleanCity);

        // console.log("HERE " + stateId);


        return fetch('<?php echo URLROOT; ?>/employees/getCitiesByStateId/' + stateId) // api for the get request
            .then(response => response.json())
            .then(data => {
                const cityId = document.getElementById('cityId');
                cityId.innerHTML = ''; // Clear previous options
                const optionCleanCity = document.createElement('option');
                optionCleanCity.value = '';
                optionCleanCity.textContent = 'Select';
                cityId.appendChild(optionCleanCity);


                data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.cityId;
                    option.textContent = city.cityName;
                    cityId.appendChild(option);
                });
            });
    }

    function getDistrict(value) {

        var cityId = value;
        return fetch('<?php echo URLROOT; ?>/employees/getDisctrictByCityId/' + cityId) // api for the get request
            .then(response => response.json())
            .then(data => {
                const districtId = document.getElementById('districtId');
                districtId.innerHTML = ''; // Clear previous options

                const optionClean = document.createElement('option');
                optionClean.value = '';
                optionClean.textContent = 'Select';
                districtId.appendChild(optionClean);



                data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.districtId;
                    option.textContent = city.districtName;
                    districtId.appendChild(option);
                });
            });
    }

    function removeEmergeContact(idEmergencyContact) {

        let div = document.getElementById("delete_" + idEmergencyContact);
        let fullname = div.dataset.fullname;
        var text = "The record * " + fullname + " will be delete";

        swal({
            title: "Are you sure?",
            text: text,
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "No, cancel!",
                    className: "btn btn-danger",
                },
                confirm: {
                    text: "Yes, Delete it!",
                    className: "btn btn-success",
                },
            },

        }).then((willChange) => {

            if (willChange) {

                var param = {
                    'idEmergencyContact': idEmergencyContact
                };
                $.ajax({
                    url: '<?php echo URLROOT; ?>/EmergencyContacts/removeEmergContact',
                    method: 'POST',
                    data: param,
                    beforeSend: function() {},
                    success: function(data) {
                        console.log("SUCCESS");
                        console.log(data);
                        var obj = JSON.parse(data);
                        var content = {};
                        content.message = obj.message;
                        content.title = "Employee";
                        content.icon = "fa fa-bell";

                        if (obj.status) {

                            swal("The User has been delete successfully.", {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
                            }).then((willReload) => {
                                if (willReload) {
                                    location.reload();
                                }
                            });

                        } else {

                            $.notify(content, {
                                type: 'danger',
                                placement: {
                                    from: 'top',
                                    align: 'right',
                                },
                                time: 1000,
                                delay: 0,
                            });
                        }
                    }
                })
            }

        });

    }

    function removeFinancialDependent(idFinancialDependent) {
        let div = document.getElementById("delete_" + idFinancialDependent + "_dependent");
        let fullname = div.dataset.fullnamedependent;
        var text = "The record * " + fullname + " will be delete";

        swal({
            title: "Are you sure?",
            text: text,
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "No, cancel!",
                    className: "btn btn-danger",
                },
                confirm: {
                    text: "Yes, Delete it!",
                    className: "btn btn-success",
                },
            },

        }).then((willChange) => {

            if (willChange) {

                var param = {
                    'idFinancialDependent': idFinancialDependent
                };

                $.ajax({
                    url: '<?php echo URLROOT; ?>/FinancialDependents/removeFinancialDependent',
                    method: 'POST',
                    data: param,
                    beforeSend: function() {},
                    success: function(data) {
                        console.log("SUCCESS");
                        console.log(data);
                        var obj = JSON.parse(data);
                        var content = {};
                        content.message = obj.message;
                        content.title = "Employee";
                        content.icon = "fa fa-bell";

                        if (obj.status) {

                            swal("The Financial Dependent has been delete successfully.", {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
                            }).then((willReload) => {
                                if (willReload) {
                                    location.reload();
                                }
                            });

                        } else {

                            $.notify(content, {
                                type: 'danger',
                                placement: {
                                    from: 'top',
                                    align: 'right',
                                },
                                time: 1000,
                                delay: 0,
                            });
                        }
                    }
                })
            }

        });

    }

    function removeDocument(employeeDocumentId) {
        let div = document.getElementById("delete_" + employeeDocumentId + "_document");
        let fullname = div.dataset.documentname;
        let namedirdocument = div.dataset.namedirdocument;
        var text = "" + fullname + " file  will be delete.";

        swal({
            title: "Are you sure?",
            text: text,
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "No, cancel!",
                    className: "btn btn-danger",
                },
                confirm: {
                    text: "Yes, Delete it!",
                    className: "btn btn-success",
                },
            },

        }).then((willChange) => {

            if (willChange) {


                var param = {
                    'employeeDocumentId': employeeDocumentId,
                    'nameDir': namedirdocument
                };

                $.ajax({
                    url: '<?php echo URLROOT; ?>/EmployeesDocuments/removeDocument',
                    method: 'POST',
                    data: param,
                    beforeSend: function() {},
                    success: function(data) {
                        console.log("SUCCESS");
                        console.log(data);
                        var obj = JSON.parse(data);
                        var content = {};
                        content.message = obj.message;
                        content.title = "Employee Document";
                        content.icon = "fa fa-bell";

                        if (obj.status) {

                            swal("The document has been delete successfully.", {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
                            }).then((willReload) => {
                                if (willReload) {
                                    location.reload();
                                }
                            });

                        } else {

                            $.notify(content, {
                                type: 'danger',
                                placement: {
                                    from: 'top',
                                    align: 'right',
                                },
                                time: 1000,
                                delay: 0,
                            });
                        }
                    }
                })
            }

        });

    }

    function getInfoEmergeContact(id) {

        var param = {
            'emergencyContactId': id
        };
        $.ajax({
            url: '<?php echo URLROOT; ?>/emergencyContacts/getInfoEmergeContactId',
            method: 'POST',
            data: param,
            beforeSend: function() {
                //
            },
            success: function(data) {
                // console.log(data);
                var obj = JSON.parse(data);

                $("#idEmpEmergContact_edit").val(obj.emergencyContactId);
                $("#fullName_edit").val(obj.fullName);
                $("#relationshipId_edit").val(obj.relationshipId);
                $("#contactPhone_edit").val(obj.contactPhone);
                $("#email_edit").val(obj.email);

            }

        })
    }

    function getInfoDependent(id) {
        var param = {
            'financialDependentId': id
        };
        $.ajax({
            url: '<?php echo URLROOT; ?>/FinancialDependents/getFinancialDependentId',
            method: 'POST',
            data: param,
            beforeSend: function() {
                //
            },
            success: function(data) {
                // console.log(data);
                var obj = JSON.parse(data);
                $("#financialDependentId_dependentEdit").val(obj.financialDependentId);
                $("#fullName_dependentEdit").val(obj.fullName);
                $("#age_dependentEdit").val(obj.age);
                $("#relationshipId_dependentEdit").val(obj.relationshipId);
                $("#dob_dependentEdit").val(obj.dob);
                $("#address_dependentEdit").val(obj.address);
                calculateAge('dob_dependentEdit');
            }

        })
    }

    function calculateAge(field) {
        const dob = document.getElementById(field).value; // Obtener la fecha de nacimiento
        const fechaNacimiento = new Date(dob);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        const mesDiff = hoy.getMonth() - fechaNacimiento.getMonth();

        // Ajustar la edad si no ha cumplido años este año
        if (mesDiff < 0 || (mesDiff === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }

        $("#" + field + "-age").val(edad)

    }
</script>