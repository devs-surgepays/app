<?php
require APPROOT . '/views/inc/header.php';

$states = (isset($data['states']) && $data['states'] != NULL) ? $data['states'] : [];
$departments = (isset($data['departments']) && $data['departments'] != NULL) ? $data['departments'] : [];
$positions = (isset($data['positions']) && $data['positions'] != NULL) ? $data['positions'] : [];
$banks = (isset($data['banks']) && $data['banks'] != NULL) ? $data['banks'] : [];
$afps = (isset($data['afps']) && $data['afps'] != NULL) ? $data['afps'] : [];
$superiors = (isset($data['superiors']) && $data['superiors'] != NULL) ? $data['superiors'] : [];
$areas = (isset($data['areas']) && $data['areas'] != NULL) ? $data['areas'] : [];
$bills = (isset($data['bills']) && $data['bills'] != NULL) ? $data['bills'] : [];
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
        <!-- Table Employees -->
        <div class="container-fluid">
            <?php echo breadcrumbs('Employee') ?>
            <form id="createEmployee" method="POST" action="#">
                <div class="row">
                    <div class="col-md-6 col-xl-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Personal Detail</h5>
                            </div>
                            <div class="card-body" style="min-height: 880px;">
                                <!-- Name -->
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control check-changes" id="firstName" name="firstName" placeholder="First Name">
                                            <label for="firstName">First Name <span class="text-danger">*</span>
                                                <label id="firstName-error" class="error" for="firstName"></label></label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control check-changes" id="secondName" name="secondName" placeholder="Second Name">
                                            <label for="secondName">Second Name <span class="text-danger">*</span>
                                                <label id="secondName-error" class="error" for="secondName"></label></label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control check-changes" id="thirdName" name="thirdName" placeholder="Third Name">
                                            <label for="thirdName">Third Name</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Last name -->
                                <div class="row pt-3">
                                    <div class="col-4">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control check-changes" id="firstLastName" name="firstLastName" placeholder="First Last Name">
                                            <label for="firstLastName">First Last Name <span class="text-danger">*</span>
                                                <label id="firstLastName-error" class="error" for="firstLastName"></label></label>

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control check-changes" id="secondLastName" name="secondLastName" placeholder="Second Last Name">
                                            <label for="secondLastName">Second Last Name <span class="text-danger">*</span>
                                                <label id="secondLastName-error" class="error" for="secondLastName"></label></label>

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control check-changes" id="thirdLastName" name="thirdLastName" placeholder="Third Last Name">
                                            <label for="thirdLastName">Third Last Name</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Phone - Email -->
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control phoneMark" id="contactPhone" name="contactPhone" placeholder="Contact Phone">
                                            <label for="contactPhone">Contact Phone <span class="text-danger">*</span>
                                                <label id="contactPhone-error" class="error" for="contactPhone"></label></label>

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control phoneMark" id="homePhone" name="homePhone" placeholder="Email Personal">
                                            <label for="homePhone">Home Phone
                                                <label id="homePhone-error" class="error" for="homePhone"></label></label>

                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="personalEmail" name="personalEmail" placeholder="Email Personal">
                                            <label for="personalEmail">Personal Email <span class="text-danger">*</span>
                                                <label id="personalEmail-error" class="error" for="personalEmail"></label></label>

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select name="genderId" id="genderId" class="form-select form-control">
                                                <option value="">Select</option>
                                                <option value="0">Male</option>
                                                <option value="1">Female</option>
                                                <option value="2">Other</option>
                                            </select>
                                            <label for="dob">Gender</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- dob - Gender-->
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="date" class="form-control" id="dob" name="dob" placeholder="dob">
                                            <label for="dob">DOB <span class="text-danger">*</span>
                                                <label id="dob-error" class="error" for="dob"></label></label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" value="" class="form-control" id="birthMunicipality" name="birthMunicipality" placeholder="birthMunicipality">
                                            <label for="birthMunicipality">Birth Municipality
                                                <label id="birthMunicipality-error" class="error" for="birthMunicipality"></label></label>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" value="" class="form-control" id="birthDeparment" name="birthDeparment" placeholder="birthDeparment">
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
                                                <option value="1">DUI</option>
                                                <option value="7">Passport</option>
                                                <option value="8">Residence card</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" value="" class="form-control" id="documentNumber" name="documentNumber" placeholder="documentNumber" disabled>
                                            <label for="documentNumber">Identification Number <span class="text-danger">*</span>
                                                <label id="documentNumber-error" class="error" for="documentNumber"></label></label>
                                        </div>
                                    </div>
                                    
                                    
                                </div>

                                <div class="row pt-3">
                                <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="date" class="form-control" id="documentExpDate" name="documentExpDate" placeholder="documentExpDate">
                                            <label for="documentExpDate">Document Exp. Date <span class="text-danger">*</span>
                                                <label id="documentExpDate-error" class="error" for="documentExpDate"></label></label>

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="date" value="" class="form-control" id="documentExpedDate" name="documentExpedDate" placeholder="documentExpedDate">
                                            <label for="documentExpedDate">Document Exped. Date
                                                <label id="documentExpedDate-error" class="error" for="documentExpedDate"></label></label>

                                        </div>
                                    </div>
                                    
                                </div>

                                <!-- SSN  -->
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" value="" class="form-control" id="documentExpedPlace" name="documentExpedPlace" placeholder="documentExpedPlace">
                                            <label for="documentExpedPlace">document Exped. Place
                                                <label id="documentExpedPlace-error" class="error" for="documentExpedPlace"></label></label>

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" value="" class="form-control" id="nationality" name="nationality" placeholder="nationality">
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
                                                <?php for ($i = 0; $i < count($states); $i++)  echo '<option value="' . $states[$i]['stateId'] . '">' . $states[$i]['stateName'] . '</option>'; ?>
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
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select name="districtId" id="districtId" class="form-select form-control">
                                                <option value="">Select</option>
                                            </select>
                                            <label for="dob">District</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Address -->
                                <div class="row pt-3">
                                    <div class="col-12">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <textarea class="form-control" id="address" name="address" placeholder="address"></textarea>
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
                                                <option value="Soltero/a">Soltero/a</option>
                                                <option value="Casado/a">Casado/a</option>
                                                <option value="Separados">Separados</option>
                                                <option value="Viudo/a">Viudo/a</option>
                                                <option value="Divorciado/a">Divorciado/a</option>
                                            </select>
                                            <label for="maritalStatus">Marital Status</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="number" class="form-control" id="children" name="children" placeholder="children">
                                            <label for="maritalStatus">Children <label id="children-error" class="error" for="children"></label></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- BACKGROUND -->
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="educationLevel" name="educationLevel" placeholder="educationLevel">
                                            <label for="maritalStatus">Education Level</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="text" class="form-control" id="career" name="career" placeholder="career">
                                            <label for="career">career</label>
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
                            <div class="card-body" style="min-height: 470px;">
                                <!-- Photo -->
                                <div class="row">
                                    <div class="col-3">
                                        <div class="file-input">
                                            <label for="photo">Photo:</label><br>
                                            <input type="file" id="photo" name="photo" accept="image/*">
                                            <button type="button" class="file-button" onclick="document.getElementById('photo').click();">Select Photo</button>

                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div id="photo-preview" class="preview"></div>
                                    </div>
                                </div>
                                <!-- Departament -->
                                <div class="row pt-3">

                                    <div class="col-6">
                                        <label class="mb-2 positionSelect" for="departmentId">Departament <span class="text-danger">*</span>
                                            <label id="departmentId-error" class="error" for="departmentId"></label></label>
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select name="departmentId" id="departmentId" class="form-select form-control js-select-basic">
                                                <option value="">Select</option>
                                                <?php for ($i = 0; $i < count($departments); $i++) {

                                                    echo '<option value="' . $departments[$i]['departmentId'] . '">' . $departments[$i]['name'] . '</option>';
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
                                                    echo '<option value="' . $areas[$i]['areaId'] . '">' . $areas[$i]['areaName'] . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Departament -->
                                <div class="row pt-3">

                                    <div class="col-6">
                                        <label class="mb-2 positionSelect" for="positionId">Position <span class="text-danger">*</span>
                                            <label id="positionId-error" class="error" for="positionId"></label></label>
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select name="positionId" id="positionId" class="form-select form-control js-select-basic">
                                                <option value="">Select</option>
                                                <?php for ($i = 0; $i < count($positions); $i++)  echo '<option value="' . $positions[$i]['positionId'] . '">' . $positions[$i]['positionName'] . ' | ' . $positions[$i]['positionNameEnglish'] . ' </option>'; ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <label class="mb-2 positionSelect" for="superiorId">Superior <span class="text-danger">*</span>
                                            <label id="superiorId-error" class="error" for="superiorId"></label></label>
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
                                <!-- corporate Email -->
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="email" class="form-control" id="corporateEmail" name="corporateEmail" placeholder="Corporate Email">
                                            <label for="corporateEmail">Corporate Email
                                                <label id="corporateEmail-error" class="error" for="corporateEmail"></label></label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="date" class="form-control" id="hiredDate" name="hiredDate" placeholder="hiredDate">
                                            <label for="hiredDate">Hired Date <span class="text-danger">*</span>
                                                <label id="hiredDate-error" class="error" for="hiredDate"></label></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- contractType -->
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <select name="contractType" id="contractType" class="form-select form-control">
                                                <option value="">Select</option>
                                                <option value="F">Full Time</option>
                                                <option value="PT">Part Time</option>
                                            </select>
                                            <label for="dob">Contract Type</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="number" class="form-control" id="workHours" name="workHours" placeholder="workHours">
                                            <label for="corporateEmail">Work Hours</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- salary -->
                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="number" class="form-control" id="salary" name="salary" placeholder="salary">
                                            <label for="salary">Salary <span class="text-danger">*</span>
                                                <label id="salary-error" class="error" for="salary"></label></label>
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

                                <hr>

                                <div class="row pt-3">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="contractsigning" id="contractsigning">
                                            <label class="form-check-label" for="contractsigning">
                                                Contract Signing
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="signingContractHeadset" id="signingContractHeadset">
                                            <label class="form-check-label" for="signingContractHeadset">
                                                Headset Contract Signing
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row pt-3">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="signingConfidentialityAgreement" id="signingConfidentialityAgreement">
                                            <label class="form-check-label" for="signingConfidentialityAgreement">
                                                Non-disclosure agreement (NDA)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="bonus" id="bonus">
                                            <label class="form-check-label" for="bonus">
                                                Bono
                                            </label>
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
                                                <?php for ($i = 0; $i < count($banks); $i++)  echo '<option value="' . $banks[$i]['bankId'] . '">' . $banks[$i]['name'] . '</option>'; ?>
                                            </select>
                                            <label for="bankId">Bank</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="number" class="form-control" id="bankAccount" name="bankAccount">
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
                                                <?php for ($i = 0; $i < count($afps); $i++)  echo '<option value="' . $afps[$i]['afpId'] . '">' . $afps[$i]['name'] . '</option>'; ?>
                                            </select>
                                            <label for="afpTypeId">AFP Type</label>

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="number" name="afpNumber" id="afpNumber" placeholder="afpNumber" class="form-control">
                                            <label for="afpNumber">AFP Number</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row pt-3">
                                    <div class="col-6">
                                        <div class="form-floating form-floating-custom mb-3">
                                            <input type="number" class="form-control" id="ssn" name="ssn" placeholder="ssn">
                                            <label for="ssn">ISSS</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xl-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Document</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="file-input">
                                            <label for="antecedentesPenales">Antecedentes Penales:</label><br>
                                            <input type="file" id="antecedentesPenales" name="antecedentesPenales" accept="application/pdf">
                                            <button type="button" class="file-button" onclick="document.getElementById('antecedentesPenales').click();">Select File <i class="fa fa-upload"></i></button>
                                            <div id="antecedentesPenales-preview" class="preview"></div>
                                        </div>
                                        <div class="file-input">
                                            <label for="solvenciaPNC">Solvencia PNC:</label><br>
                                            <input type="file" id="solvenciaPNC" name="solvenciaPNC" accept="application/pdf">
                                            <button type="button" class="file-button" onclick="document.getElementById('solvenciaPNC').click();">Select File <i class="fa fa-upload"></i></button>
                                            <div id="solvenciaPNC-preview" class="preview"></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="file-input">
                                            <label for="contract">Contract:</label><br>
                                            <input type="file" id="contract" name="contract" accept="application/pdf">
                                            <button type="button" class="file-button" onclick="document.getElementById('contract').click();">Select File <i class="fa fa-upload"></i></button>
                                            <div id="contract-preview" class="preview"></div>
                                        </div>
                                        <div class="file-input">
                                            <label for="expediente">Expediente:</label><br>
                                            <input type="file" id="expediente" name="expediente" accept="application/pdf">
                                            <button type="button" class="file-button" onclick="document.getElementById('expediente').click();">Select File <i class="fa fa-upload"></i></button>
                                            <div id="expediente-preview" class="preview"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6 col-sm-12">

                    </div>
                </div>

                <div class="row d-flex justify-content-end">
                    <div class="col-2 d-flex justify-content-end"><button type="submit" class="btn btn-primary">Create Employee</button></div>
                </div>
            </form>

        </div> <!-- end/container-fluid -->
        <?php require APPROOT . '/views/inc/footer.php'; ?>

    </div>
</div>
</div>

<script>
    $('#stateId').on('change', function() {
        var stateId = this.value;

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


        fetch('<?php echo URLROOT; ?>/employees/getCitiesByStateId/' + stateId) // api for the get request
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
    })
    $('#cityId').on('change', function() {
        var cityId = this.value;
        fetch('<?php echo URLROOT; ?>/employees/getDisctrictByCityId/' + cityId) // api for the get request
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
    })
    $("#documentTypeId").change(() => {
        let documentTypeId = $("#documentTypeId").val();
        if(documentTypeId == "" || documentTypeId == null) return;
        $('#documentNumber').attr("disabled", false);
        if(documentTypeId == 1) {
            $('#documentNumber').mask('00000000-0');
        } else {
            $('#documentNumber').unmask();
        }
    });
    $(document).ready(function() {

        $('.phoneMark').mask('0000-0000');
        $('#ssn').mask('000000000');
        $('.js-select-basic').select2();

        // Initial State Storage: When the document is ready, we store the initial values of the form fields in the initialState object.
        var initialState = {};
        $('#createEmployee').find('input, select').each(function() {
            if ($(this).attr('type') === 'checkbox') {
                initialState[$(this).attr('name')] = $(this).is(':checked') ? 1 : 0;
            } else {
                initialState[$(this).attr('name')] = $(this).val();
            }

        });
        // console.log(initialState)

        $('#photo').on('change', function() {
            previewFile(this, '#photo-preview');
        });
        $('#antecedentesPenales').on('change', function() {
            previewFile(this, '#antecedentesPenales-preview');
        });
        $('#solvenciaPNC').on('change', function() {
            previewFile(this, '#solvenciaPNC-preview');
        });
        $('#contract').on('change', function() {
            previewFile(this, '#contract-preview');
        });
        $('#expediente').on('change', function() {
            previewFile(this, '#expediente-preview');
        });

        // Function to get changed fields
        function getChangedFields() {
            var changedFields = {};
            $('#createEmployee').find('input, select').each(function() {
                var name = $(this).attr('name');

                if ($(this).attr('type') === 'checkbox') {
                    var currentValue = $(this).is(':checked') ? 1 : 0;
                } else {
                    var currentValue = $(this).val();
                }
                if (currentValue !== initialState[name]) {
                    changedFields[name] = currentValue;
                }
            });
            return changedFields;
        }

        function previewFile(input, previewDiv) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                var previewContent;

                if (file.type.startsWith('image/')) {
                    previewContent = '<img class="img-thumbnail" src="' + e.target.result + '" width="200">';
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

        // validate FORM
        $('#createEmployee').validate({
            rules: {
                firstName: 'required',
                children: {
                    min: 0,
                    max: 10
                },
                secondName: 'required',
                firstLastName: 'required',
                secondLastName: 'required',
                contactPhone: 'required',
                personalEmail: 'required',
                dob: 'required',
                documentNumber: 'required',
                documentExpDate: 'required',
                departmentId: 'required',
                areaId: 'required',
                positionId: 'required',
                superiorId: 'required',
                // corporateEmail: 'required',
                hiredDate: 'required',
                salary: 'required',
                billTo: 'required',
                documentTypeId: 'required'

            },
            messages: {
                firstName: 'This field is required',
                secondName: 'This field is required',
                firstLastName: 'This field is required',
                secondLastName: 'This field is required',
                contactPhone: 'This field is required',
                personalEmail: 'This field is required',
                dob: 'This field is required',
                documentNumber: 'This field is required',
                documentExpDate: 'This field is required',
                departmentId: 'This field is required',
                areaId: 'This field is required',
                positionId: 'This field is required',
                superiorId: 'This field is required',
                // corporateEmail: 'This field is required',
                hiredDate: 'This field is required',
                salary: 'This field is required',
                billTo: 'This field is required',
                documentTypeId: 'This field is required'
            },
            submitHandler: function(form) {

                var formData = new FormData(form);

                // function is called to get the JSON object of the changed fields
                var changedFields = getChangedFields();
                var jsonChangedFields = JSON.stringify(changedFields);
                formData.append('changedFields', jsonChangedFields);

                // console.log(jsonChangedFields)

                $.ajax({
                    url: '<?php echo URLROOT; ?>/employees/createEmpProcess',
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

                            resetForm();

                            // console.log("ALL GOOD");
                            var content = {};
                            content.message = obj.message;
                            content.title = "Employee";
                            content.icon = "fa fa-bell";
                            content.url = '<?php echo URLROOT; ?>/employees/';
                            // content.target = "_blank";


                            // if (obj.fieldError.length === 0) {
                            let listItem = `<ul>`;
                            for (const key in obj.fieldError) {
                                if (obj.fieldError.hasOwnProperty(key)) {
                                    listItem += `<li>${key}: ${obj.fieldError[key]}</li>`;
                                }
                            }
                            listItem += `</ul>`;
                            content.message += listItem;
                            // }

                            $.notify(content, {
                                type: 'success',
                                placement: {
                                    from: 'top',
                                    align: 'right',
                                },
                                time: 1000,
                                delay: 0,
                            });


                        } else {
                            // console.log("ALL BAD");
                            var content = {};

                            content.message = 'Error!!';
                            content.message += obj.message;
                            content.title = "Employee";
                            content.icon = "fa fa-times-circle";


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

                        console.log(obj);

                    }
                })

            }
        });



    }); // /ready

    function resetForm() {
        const form = document.getElementById('createEmployee');

        // Reset text, date, and file inputs
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {

            if (input.type === 'checkbox') {
                input.checked = false; // Reset checkbox inputs
            }else {
                input.value = '';
            }
        });

        // Reset textarea inputs
        const textareas = form.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.value = '';
        });

        // select basic
        $('.js-select-basic').val(null).trigger('change'); // Clean select2


        // Reset select inputs
        const selects = form.querySelectorAll('select');
        selects.forEach(select => {
            select.selectedIndex = 0; // Reset to the first option
        });

        // preview clean
        $("#photo-preview").html('');
        $("#antecedentesPenales-preview").html('');
        $("#solvenciaPNC-preview").html('');
        $("#contract-preview").html('');
        $("#expediente-preview").html('');

        // focus
        $("#firstName").focus();
    }
</script>