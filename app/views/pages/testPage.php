<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">

    <div class="page-inner">

        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">SurgePays, Inc.</h3>
                <h6 class="op-7 mb-2">San Salvador, El Salvador</h6>
            </div>
            <!-- <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round"> <i class="fa fa-add"></i> Add Employee</a>
            </div> -->
        </div>
        <div class="row">
            <?php echo breadcrumbs('Employee') ?>
        </div>
        <div class="pt-2"></div>

        <?php require APPROOT . '/views/inc/footer.php'; ?>
    </div> <!-- end/page-inner -->
</div> <!-- end/container2 -->
<script>
    $(document).ready(function() {

    }); // /ready
</script>