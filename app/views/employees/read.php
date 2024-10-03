<?php require APPROOT . '/views/inc/header.php';
$employeeInfo = (isset($data['employeeInfo']) && $data['employeeInfo'] != NULL) ? $data['employeeInfo'] : [];
$emergencyContacts = (isset($data['emergencyContacts']) && $data['emergencyContacts'] != NULL) ? $data['emergencyContacts'] : [];

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

    .preview {
        font-size: 14px;
        color: #555;
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


    .cursor-unset {
        cursor: unset;
    }
</style>
<div class="container">
    <div class="page-inner">
        <?php echo breadcrumbs('Employee') ?>

        <div class="row">
            <div class="col-md-6 col-xl-6 col-sm-12">
                <!-- Personal Detail -->
                <div class="card">
                    <div class="card-header">
                        <h5>Personal Detail</h5>
                    </div>
                    <div class="card-body">

                        <div class="row pb-4">
                            <div class="col-md-3 col-sm-12">
                                <strong class="font-bold">Photo : </strong>
                                <div class="info text-sm">
                                    <div id="photo-preview" class="preview">
                                        <img class="img-thumbnail" src="<?php echo URLROOT; ?>/public/documents/photo/<?php echo $data['employeeInfo']['photo']; ?>" width="200">
                                        <i onclick="getPhotoInfo(<?php echo $data['employeeInfo']['badge']; ?>, '<?php echo $data['employeeInfo']['firstName'] . ' ' .  $data['employeeInfo']['firstLastName'] ?>', '<?php echo $data['employeeInfo']['photo']; ?>')" data-bs-toggle="modal" data-bs-target="#modalPhotoPreview"
                                            class="fa fa-expand edit-image-icon"></i>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Badge :</strong>
                                    <span><?php echo $data['employeeInfo']['badge']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Full Name :</strong>
                                    <span><?php echo $data['employeeInfo']['fullname']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Contact Phone :</strong>
                                    <span><?php echo $data['employeeInfo']['contactPhone']; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Home Phone :</strong>
                                    <span><?php echo $data['employeeInfo']['homePhone']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-6 col-sm-12">
                <!-- Company Detail -->
                <div class="card">
                    <div class="card-header">
                        <h5>Company Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Status :</strong>
                                    <span><?php echo $data['employeeInfo']['status']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Departament :</strong>
                                    <span><?php echo $data['employeeInfo']['departamentName']; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Area :</strong>
                                    <span><?php echo $data['employeeInfo']['areaName']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Position :</strong>
                                    <span><?php echo $data['employeeInfo']['positionName']; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Corporate Email :</strong>
                                    <span><?php echo $data['employeeInfo']['corporateEmail']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Hired Date :</strong>
                                    <span><?php echo $data['employeeInfo']['hiredDate']; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Hired Date old :</strong>
                                    <span><?php echo $data['employeeInfo']['hiredDateOld']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Contract Type :</strong>
                                    <span><?php echo $data['employeeInfo']['contractType']; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Work Hours :</strong>
                                    <span><?php echo $data['employeeInfo']['workHours']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">Bonus :</strong>
                                    <span><?php echo $data['employeeInfo']['bonus']; ?></span>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lx-6 col-sm-12">
                <!-- Emergency Contacts -->
                <div class="card">
                    <div class="card-header">
                        <h5>Emergency Contacts</h5>
                    </div>
                    <div class="card-body" style="min-height: 175px;">
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (!empty($emergencyContacts)) { ?>
                                    <div class="info text-sm font-style">
                                        <ul>
                                            <?php for ($i = 0; $i < count($emergencyContacts); $i++) {
                                                echo  '<li> ' . $emergencyContacts[$i]['fullName'] . ' | ' . $emergencyContacts[$i]['contactPhone'] . ' | ' . $emergencyContacts[$i]['relationshipName'] . '</li>';
                                            } ?>
                                        </ul>
                                    </div>
                                <?php } else {
                                    echo "No data";
                                } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php require APPROOT . '/views/inc/footer.php'; ?>
    </div>
</div>

<!-- Modales -->

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


<script>
    $(document).ready(function() {

    }); // /ready

    function getPhotoInfo(Badge, Fullname, photo) {
        var link = '<?php echo URLROOT; ?>/public/documents/photo/' + photo;
        $('.photo-preview').attr('src', link);
        $('.name-preview-photo').html(Badge + ' | ' + Fullname);
    }
</script>