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
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Employees</p>
                                    <h4 class="card-title totalEmployee"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Active Employee</p>
                                    <h4 class="card-title totalEmployeeActive"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-headphones"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Customer Service</p>
                                    <h4 class="card-title customerServicesActive"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="far fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Hired Today</p>
                                    <h4 class="card-title hiredToday"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table Employees -->
        <div class="row">
            <?php echo breadcrumbs('Employee') ?>
            <div class="col-12">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <!-- Table Employees -->
                        <div class="row">

                            <div class="d-flex justify-content-between">
                                <div>
                                    <label for="">Show
                                        <select name="length" id="length" class="form-control-sm searchDataChange">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="500">500</option>
                                            <option value="1000">1000</option>
                                            <option value="2500">2500</option>
                                        </select> entries
                                    </label>
                                </div>
                                <div><a href="<?php echo URLROOT ?>/employees/create" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Employee</a></div>
                            </div>
                        </div>
                        <div class="row pt-5 ">
                            <div class="table-responsive">
                                <table id="tableOrders" class="GrenTable table table-bordered tableOrders">
                                    <thead>
                                        <tr class="dataexp">
                                            <td>No.</td>
                                            <td>Badge</td>
                                            <td>Name</td>
                                            <td>Email</td>
                                            <td style="width: 135px;">
                                                <div class="searchDataClick" id="date_created" onclick="orderBy(this)">Hired Date<i data-order="orderAscDesc" id="orderby_date_created" class="fa fa-sort"></i></div>
                                            </td>
                                            <td>Department</td>
                                            <td>Position</td>
                                            <td>Status</td>
                                            <td>Actions</td>
                                        </tr>
                                        <tr id="search">
                                            <th></th>
                                            <th><input class="form-control form-control-sm searchDataChange camposserch" id="serch_badge" type="text"></th>
                                            <th><input class="form-control form-control-sm searchDataChange camposserch" id="serch_fullname" type="text"></th>
                                            <th><input class="form-control form-control-sm searchDataChange camposserch" id="serch_email" type="text"></th>
                                            <th style="width: 156px;"><input class="form-control form-control-sm searchDataChange camposserch" id="serch_hiredDate" placeholder="mm-dd-yyyy" type="date"></th>
                                            <th>
                                                <select class="form-control form-control-sm searchDataChange camposserch" id="serch_department">
                                                    <option value="">Select</option>
                                                    <?php for ($i = 0; $i < count($data['departments']); $i++)  echo '<option value="' . $data['departments'][$i]['departmentId'] . '">' . $data['departments'][$i]['name'] . '</option>'; ?>
                                                </select>
                                            </th>
                                            <th>
                                                <select class="form-control form-control-sm searchDataChange camposserch js-select-basic" id="serch_position">
                                                    <option value="">Select</option>
                                                    <?php for ($i = 0; $i < count($data['positions']); $i++)  echo '<option value="' . $data['positions'][$i]['positionId'] . '">' . $data['positions'][$i]['positionName'] . '</option>'; ?>
                                                </select>
                                            </th>
                                            <th>
                                                <select class="form-control form-control-sm searchDataChange camposserch" id="serch_status">
                                                    <option value="">Select</option>
                                                    <?php for ($i = 0; $i < count($data['status']); $i++)  echo '<option value="' . $data['status'][$i]['statusId'] . '">' . $data['status'][$i]['statusName'] . '</option>'; ?>
                                                </select>
                                            </th>

                                            <th>
                                                <img style="cursor: pointer;" onclick="resetform()" src="<?php echo URLROOT; ?>/assets/img/clear-filter.png" width="25" height="25">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="dataBody">
                                    </tbody>
                                </table>

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
        </div>
        
        <?php require APPROOT . '/views/inc/footer.php'; ?>
    </div> <!-- end/page-inner -->
</div> <!-- end/container2 -->






<script>
    $(document).ready(function() {
        $('.js-select-basic').select2();
        readData(1, '', 10, '');
        getInfoCard();
    });

    function readData(page, search, length, ascDesc) {
        var param = {
            'action': 'ajaxDataRows',
            'page': page,
            'search': search,
            'length': length,
            'ascDesc': ascDesc,
        };

        console.log(param)

        $.ajax({
            url: '<?php echo URLROOT; ?>/employees/getDataRows',
            method: 'POST',
            data: param,
            beforeSend: function(obj) {
                //GIF WAITING
            },
            success: function(data) {
                //console.log(data)
                var obj = JSON.parse(data)
                $(".dataBody").html(obj.rows).fadeIn('slow');
                $(".showing").html(obj.showing).fadeIn('slow');
                $(".pagination").html(obj.pagination).fadeIn('slow');
            }
        })
    }

    // Function General
    function getdataBody() {
        var search = fieldsValue()
        var ascDesc = getAscDesc();
        var length = $('select[id=length]').val();
        readData(1, search, length, ascDesc);
    }


    // Function General
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

    function getInfoCard() {
        fetch('<?php echo URLROOT; ?>/employees/getInfoCard') // api for the get request
            .then(response => response.json())
            .then(data => {
                console.log(data)
                $(".totalEmployeeActive").html(data.TotalEmployeeActive)
                $(".totalEmployee").html(data.TotalEmployee)
                $(".customerServicesActive").html(data.CustomerServicesActive)
                $(".hiredToday").html(data.HiredToday)
            });
    }

    // --------------------------------------------------------------------

    $(".searchDataChange").change(function() {
        getdataBody();
    });
    $(".searchDataClick").click(function() {
        getdataBody();
    });
</script>