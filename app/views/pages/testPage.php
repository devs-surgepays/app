<?php require APPROOT . '/views/inc/header.php'; ?>
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
</style>
<div class="container">
    <div class="page-inner">
        <?php echo breadcrumbs('Employee') ?>
    <!-- mAIN -->
        <div class="row">
            <div class="col-md-6 col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Personal Detail</h5>
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    <!-- mAIN -->

        <?php require APPROOT . '/views/inc/footer.php'; ?>
    </div>
</div>

<script>
    $(document).ready(function() {

    }); // /ready
</script>