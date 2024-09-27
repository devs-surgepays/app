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
    <div class="container-fluid">
      <?php echo breadcrumbs('Users') ?>
      <div class="col-12">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row">
              <div class="d-flex justify-content-between">
                <button id="btn-add-user" type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addUser">
                  <i class="fa fa-plus"></i> Add User</button>
              </div>
            </div>

            <!-- Table Users -->
            <div class="row pt-5">
              <div class="d-flex justify-content-between table-responsive">
                <table id="add-row" class="display table table-striped ">
                  <thead>
                    <tr>
                      <th>N.</th>
                      <th>Name</th>
                      <th>Username</th>
                      <th style="width: 10%">Action</th>
                    </tr>
                  </thead>
                  <!-- <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </tfoot> -->
                  <tbody>
                    <?php $i = 1;
                    foreach ($data["users"] as $user) : ?>
                      <tr>
                        <td><?php echo $i++;  ?></td>
                        <td><?php echo $user["fullname"]  ?></td>
                        <td><?php echo $user["username"] ?></td>
                        <td>
                          <div class="">
                            <button type="button" onclick='GetInformationUser(<?php echo $user["userId"]  ?>)' data-bs-toggle="modal" data-bs-target="#edit-user" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button>
                            <button id="delete_<?php echo $user["userId"]  ?>" type="button" data-fullname="<?php echo $user["fullname"] ?>" data-username="<?php echo $user["username"] ?>" onclick='removeUser(<?php echo $user["userId"]  ?>)' class="btn btn-sm btn-danger "><i class="fa fa-times"></i></button>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Button trigger modal -->

        <!-- Create User -->
        <div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="createUser" method="POST" action="">
                <div class="modal-body">
                  <div class="row pt-3">
                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>Badge</label>
                        <input type="text" class="form-control" id="badge" name="badge" onkeyup="getInfoEmployee()" placeholder="Badge">
                      </div>
                    </div>

                    <div class="col-6">

                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Yes" name="externalPersonal" id="externalPersonal">
                        <label class="form-check-label" for="externalPersonal">External person</label>
                      </div>
                    </div>

                  </div>

                  <div class="row pt-3">
                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>First Name <span class="text-danger">*</span> </label>
                        <input id="firstName" name="firstName" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>First Last Name <span class="text-danger">*</span></label>
                        <input id="firstLastName" name="firstLastName" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                  </div>
                  <div class="row pt-3">

                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>Username <span class="text-danger">*</span></label></label>
                        <input type="email" class="form-control" id="username" name="username" placeholder="username">
                      </div>
                    </div>

                    <div class="col-6" id="permissionLevel">
                      <div class="form-group form-group-default">
                        <label>Permission Level <span class="text-danger">*</span></label>
                        <select id="permissionLevelId" name="permissionLevelId" class="form-select">
                          <option value="">Select</option>
                          <?php for ($i = 0; $i < count($data['permissions_levels']); $i++) {
                            echo '<option value="' . $data['permissions_levels'][$i]['permissionLevelId'] . '" >' . $data['permissions_levels'][$i]['name'] . '</option>';
                          } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" id="btn-cancelCreateEmerge" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Create User</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- // create User -->

        <!-- edit User -->
        <div class="modal fade" id="edit-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit-userLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="editUser" method="POST" action="">
                <div class="modal-body">
                  <div class="row pt-3">
                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>Badge</label>
                        <input type="text" class="form-control" id="badge_edit" name="badge_edit" placeholder="Badge">
                      </div>
                    </div>

                    <div class="col-6">

                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Yes" name="externalPersonal_edit" id="externalPersonal_edit">
                        <label class="form-check-label" for="externalPersonal_edit">External person</label>
                      </div>
                    </div>
                  </div>

                  <div class="row pt-3">
                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>First Name <span class="text-danger">*</span> </label>
                        <input id="firstName_edit" name="firstName_edit" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>First Last Name <span class="text-danger">*</span></label>
                        <input id="firstLastName_edit" name="firstLastName_edit" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                  </div>
                  <div class="row pt-3">
                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>Username <span class="text-danger">*</span></label></label>
                        <input type="email" class="form-control" id="username_edit" name="username_edit" placeholder="">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>Permission Level <span class="text-danger">*</span></label>
                        <select id="permissionLevelId_edit" name="permissionLevelId_edit[]" class="form-select js-select-multiple" multiple="multiple">
                          <option value="">Select</option>
                          <?php for ($i = 0; $i < count($data['permissions_levels']); $i++) {
                            echo '<option value="' . $data['permissions_levels'][$i]['permissionLevelId'] . '" >' . $data['permissions_levels'][$i]['name'] . '</option>';
                          } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row pt-3">
                    <div class="col-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Yes" name="changePasswordCheckbox" id="changePasswordCheckbox">
                        <label class="form-check-label" for="changePasswordCheckbox">Change Password</label>
                      </div>
                    </div>
                  </div>
                  <div class="row pt-3 passwordFields" style="display: none;">
                    <div class="col-6">
                      <div class="form-group form-group-default">
                        <label>Change Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="">
                      </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <input type="hidden" name="userIdEdit" id="userIdEdit">
                  <button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Edit User</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- // edit User -->
      </div>
    </div>

    <?php require APPROOT . '/views/inc/footer.php'; ?>

    <script>

      $('#firstName, #firstLastName').prop('readonly', true);
      $('#badge_edit').prop('readonly', true);
      $('#externalPersonal_edit').prop('disabled', true);

      $('#externalPersonal').change(function() {

        if (this.checked) {
          // console.log('Checkbox is checked');
          $('#badge').prop('readonly', true);
          $('#badge').val('');
          $('#firstName, #firstLastName').prop('readonly', false);
          $("#permissionLevel").hide(); 

        } else {
          $('#badge').prop('readonly', false);
          $('#firstName, #firstLastName').prop('readonly', true);
          $('#firstName, #firstLastName').val('');
          $("#permissionLevel").show(); 

          // console.log('Checkbox is unchecked');P
        }
      });

      $('#changePasswordCheckbox').on('change', function() {
        if ($(this).is(':checked')) {
          $(".passwordFields").show(1000);
          // $('#passwordFields').removeClass('hidden');
        } else {
          $(".passwordFields").hide(1000);

          // $('#passwordFields').addClass('hidden');
        }
      });

      $("#btn-add-user").on('click', function() {
        $("#badge").val('');
        $("#firstName").val('');
        $("#firstLastName").val('');
        $("#permissionLevelId").val('');
        $("#badge").val('');
        $("#username").val('');
        $('#externalPersonal').prop('checked', false);
        $("#permissionLevel").show(); 


      });

      function getInfoEmployee() {
        const badgeValue = document.getElementById('badge').value;

        if (badgeValue.length > 3) {
          // console.log('<?php echo URLROOT ?>/employees/getEmployeeByBagde/' + badgeValue)

          fetch('<?php echo URLROOT ?>/employees/getEmployeeByBagde/' + badgeValue)
            .then(response => response.json())
            .then(data => {

              // console.log(data)
              $('#firstName').val(data.firstName);
              $('#firstLastName').val(data.firstLastName);

            })
            .catch(error => console.error('Error:', error));
        }
      }

      function GetInformationUser(idUser) {

        var param = {
          'idUser': idUser
        };
        $.ajax({
          url: '<?php echo URLROOT; ?>/users/getInformationUser',
          method: 'POST',
          data: param,
          beforeSend: function() {
            // waiit
          },
          success: function(data) {
            // console.log("SUCCESS");
            // console.log(data);
            var obj = JSON.parse(data);

            console.log(obj.firstName)

            $("#badge_edit").val(obj.badge)
            $("#userIdEdit").val(idUser)
            $("#firstName_edit").val(obj.firstName)
            $("#firstLastName_edit").val(obj.firstLastName)
            $("#username_edit").val(obj.username)
            // $("#permissionLevelId_edit").val(obj.permissionLevelId)
            // $("#permissionLevelId_edit").val([2, 4]).trigger('change');

            let permissionLevel = obj.jsonPermissionLevelId.map((a) => a.permissionLevelId);
            $('#permissionLevelId_edit').val(permissionLevel)
            $('#permissionLevelId_edit').trigger('change');

            if (obj.employeeId == 0) {
              // Person Externa
              $('#externalPersonal_edit').prop('checked', true);
              $('#firstLastName_edit, #firstName_edit').prop('readonly', false);
              $('#permissionLevelId_edit').prop('disabled', true);

            } else {
              $('#externalPersonal_edit').prop('checked', false);
              $('#firstLastName_edit, #firstName_edit').prop('readonly', true);
              $('#permissionLevelId_edit').prop('disabled', false);


            }

          }

        })
      }

      function removeUser(idUser) {


        let div = document.getElementById("delete_" + idUser);
        let fullname = div.dataset.fullname;
        var text = "The User * " + fullname + " will be delete";

        // var username = article.dataset.username;

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
              'idUser': idUser
            };
            $.ajax({
              url: '<?php echo URLROOT; ?>/users/deleteUser',
              method: 'POST',
              data: param,
              beforeSend: function() {},
              success: function(data) {
                // console.log("SUCCESS");
                // console.log(data);
                var obj = JSON.parse(data);
                var content = {};
                content.message = obj.message;
                content.title = "User";
                content.icon = "fa fa-bell";

                if (obj.status) {

                  $("#btn-cancel").click();

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


      $(document).ready(function() {
        $("#add-row").DataTable();

        let initialState = {};

        $('#edit-user').on('shown.bs.modal', function() {
          $('#changePasswordCheckbox').prop('checked', false);
          $(".passwordFields").hide();
          $("#password").val('');

          initialState = captureInitialState();
          console.log('Initial State:', initialState);

          $('.js-select-multiple').select2({
            dropdownParent: $('#edit-user')
          })

        });
        


        // Function to get changed fields
        function getChangedFields() {
          let changedFields = {};
          let ignoredFields = []; // Lista de campos a ignorar

          $('#editUser').find('input, select, textarea').each(function() {
            let name = $(this).attr('name');
            if (name && initialState.hasOwnProperty(name) && !ignoredFields.includes(name)) {
              let currentValue;
              if ($(this).attr('type') === 'checkbox') {
                currentValue = $(this).is(':checked');
              } else {
                currentValue = $(this).val();
              }
              let initialValue = initialState[name] == null ? '' : initialState[name];
              if (currentValue !== initialValue) {
                changedFields[name] = currentValue;
              }
            }
          });
          return changedFields;
        }

        // save Information
        $("#createUser").validate({
          rules: {
            firstName: 'required',
            firstLastName: 'required',
            permissionLevelId: 'required',
            username: 'required',
          },
          messages: {
            firstName: 'This field is required',
            firstLastName: 'This field is required',
            permissionLevelId: 'This field is required',
            username: 'This field is required',
          },
          submitHandler: function(form) {

            // console.log($("#createUser").serialize());
            $.ajax({
              url: '<?php echo URLROOT; ?>/users/createUserProcess',
              method: 'POST',
              data: $("#createUser").serialize(),
              beforeSend: function() {

              },
              success: function(data) {
                // console.log("SUCCESS");
                // console.log(data);
                var obj = JSON.parse(data);
                var content = {};
                content.message = obj.message;
                content.title = "User";
                content.icon = "fa fa-bell";

                if (obj.status) {

                  $("#btn-cancelCreateEmerge").click();

                  swal("The User has been create successfully.", {
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

                  swal(obj.message, {
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


        $("#editUser").validate({
          rules: {
            firstName_edit: 'required',
            firstLastName_edit: 'required',
            username_edit: 'required',
            'permissionLevelId_edit[]': {
              required: true,
              minlength: 1
            }
          },
          messages: {
            firstName_edit: 'This field is required',
            firstLastName_edit: 'This field is required',
            username_edit: 'This field is required',
            'permissionLevelId_edit[]': 'This field is required',
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

                // function is called to get the JSON object of the changed fields
                var changedFields = getChangedFields();
                var jsonChangedFields = JSON.stringify(changedFields);
                formData.append('changedFields', jsonChangedFields);

                $.ajax({
                  url: '<?php echo URLROOT; ?>/users/editUserProcess',
                  method: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  beforeSend: function() {

                  },
                  success: function(data) {

                    // console.log(data)
                    var obj = JSON.parse(data);
                    var content = {};
                    content.message = obj.message;
                    content.title = "User";
                    content.icon = "fa fa-bell";

                    if (obj.status) {

                      $("#btn-cancel").click();

                      swal("The User has been updated successfully.", {
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
        })

      });

      // Function to capture the initial state of form inputs
      function captureInitialState() {
        let state = {};
        $('#editUser').find('input, select, textarea').each(function() {
          let name = $(this).attr('name');
          if (name) {
            if ($(this).attr('type') === 'checkbox') {
              state[name] = $(this).is(':checked');
            } else {
              state[name] = $(this).val();
            }
          }
        });
        return state;
      }
    </script>