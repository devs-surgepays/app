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

            <div class="col-sm-6 col-md-4">
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

            <!-- <div class="col-sm-6 col-md-4">
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
            </div> -->

            <div class="col-sm-6 col-md-4">
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

            <div class="col-sm-6 col-md-4">
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
                        <?php if (getPLAnotherBillTo()) { ?>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select class="form-select form-select-sm searchDataChange" id="billToBtn" name="billToBtn">
                                        <option selected value="1">SURGEPAYS</option>
                                        <option value="2">ELITE</option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
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
                                <?php if (getPLCreateEditDeleteInfoEmployee()) { ?>
                                    <div><a href="<?php echo URLROOT ?>/employees/create" class="btn btn-primary btn-round"><i class="fa fa-plus"></i> Add Employee</a></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row pt-5 ">
                            <div class="table-responsive">
                                <table id="tbEmployees" class="GrenTable table table-bordered tbEmployees">
                                    <thead>
                                        <tr class="dataexp">
                                            <td>No.</td>
                                            <td>Badge</td>
                                            <td>Name</td>
                                            <td>Email</td>
                                            <td>Hired Date</td>
                                            <!-- <td style="width: 135px;">
                                                <div class="searchDataClick" id="date_created" onclick="orderBy(this)">Hired Date<i data-order="orderAscDesc" id="orderby_date_created" class="fa fa-sort"></i></div>
                                            </td> -->
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
                                                    <?php for ($i = 0; $i < count($data['positions']); $i++)  echo '<option value="' . $data['positions'][$i]['positionName'] . '">' . $data['positions'][$i]['positionName'] . '</option>'; ?>
                                                </select>
                                            </th>
                                            <th>
                                                <?php if (getPLShowInactiveEmployee()) { ?>

                                                    <select class="form-control form-control-sm searchDataChange camposserch" id="serch_status">
                                                        <option value="">Select</option>
                                                        <?php for ($i = 0; $i < count($data['status']); $i++)  echo '<option value="' . $data['status'][$i]['statusId'] . '">' . $data['status'][$i]['statusName'] . '</option>'; ?>
                                                    </select>

                                                <?php } ?>
                                            </th>
                                            <th>
                                                <img style="cursor: pointer;" onclick="resetform()" src="<?php echo URLROOT; ?>/assets/img/clear-filter.png" width="25" height="25">
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
        </div>

        <?php require APPROOT . '/views/inc/footer.php'; ?>
    </div> <!-- end/page-inner -->
</div> <!-- end/container2 -->






<script>
    $(document).ready(function() {
        $('.js-select-basic').select2();
        readData(1, '', 10, '', 1);
        getInfoCard();
    });

    function readData(page, search, length, ascDesc, billTo) {
        var param = {
            'action': 'ajaxDataRows',
            'page': page,
            'search': search,
            'length': length,
            'ascDesc': ascDesc,
            'billTo': billTo,
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
                // console.log(data)
                var obj = JSON.parse(data)
                var rows = obj.data;
                // console.log(rows)

                var tbody = $('#tbEmployees tbody');
                tbody.empty(); // Limpiar tabla antes de llenar


                let rowNumber = 1;
                let totalRowShow = 0;

                if (rows.length > 0) {

                    rows.forEach(function(item) {

                        const status = (item.statusEmployee == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                        totalRowShow = obj.offset + rowNumber;
                        const emailCorp = (item.corporateEmail === null) ? '' : item.corporateEmail;
                        const urlEmployee = (obj.getPLFullEmployeeInfo) ? 'edit' : 'showEmployee';

                        var row = `<tr>
                        <td>${rowNumber}</td>
                        <td><a href="<?php echo URLROOT; ?>/employees/${urlEmployee}/${item.badge}" class="btn btn-primary btn-border">#${item.badge}</a> </td></td>
                        <td>${ item.fullName }</td>
                        <td>${ emailCorp}</td>
                        <td>${ item.formattedHiredDate }</td>
                        <td>${ item.name }</td>
                        <td>${ item.positionName }</td>
                        <td>${ status }</td>
                        <td> <a href="<?php echo URLROOT; ?>/employees/${urlEmployee}/${item.badge}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a></td>
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

                if (obj.loandingCard) getInfoCard();


            }
        })
    }

    // Function General
    function getdataBody() {
        var search = fieldsValue()
        var ascDesc = getAscDesc();
        var length = $('select[id=length]').val();
        var billTo = $('select[id=billToBtn]').val();
        readData(1, search, length, ascDesc, billTo);
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
        const data = new URLSearchParams();
        data.append('status', $('select[id=billToBtn]').val());

        fetch('<?php echo URLROOT; ?>/employees/getInfoCard', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: data
            }) // api for the get request
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