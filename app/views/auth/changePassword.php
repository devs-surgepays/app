<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Surgepays - HR</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo URLROOT; ?>/assets/img/surge-pays-fav.png" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?php echo URLROOT; ?>/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/kaiadmin.min.css" />

   
</head>

<body class="d-flex justify-content-center align-items-center">
    <section>
        <div class="card border-light-subtle shadow-sm wrap-center" style="width: 445px;">
            <div class="row gy-3 overflow-hidden">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="pass" id="pass" placeholder="name@example.com">
                        <label for="password" class="form-label">Password</label>
                        <small id="passHelp" class="form-text text-muted text-danger"></small>

                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="passwordConfirmation" id="passwordConfirmation" value="" placeholder="Password">
                        <label for="password" class="form-label">Confirm Password </label>
                        <small id="passHelpConfirm" class="form-text text-muted text-danger"></small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-grid">
                        <input value="<?php echo $data["token"]; ?>" type="hidden" id="token" name="token">
                        <button class="btn btn-dark btn-lg" onclick="changePassword()">Change Password</button>
                        <h6 id="msgSuccess" class="text-center pt-3 text-success"></h6>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .wrap-center {
            padding: 3rem;
            /* justify-content: center;
        align-items: center;
        display: flex;
        flex-wrap: wrap; */
            margin-top: 0rem;
        }
    </style>
</body>

</html>
<script src="<?php echo URLROOT ?>/assets/js/core/jquery-3.7.1.min.js"></script>
<script src="<?php echo URLROOT ?>/assets/js/core/popper.min.js"></script>
<script src="<?php echo URLROOT ?>/assets/js/core/bootstrap.min.js"></script>
<script>
    function changePassword() {

        $.ajax({
            url: '<?php echo URLROOT; ?>/auths/processChangePassword',
            data: {
                password: $("#pass").val(),
                passwordConfirmation: $("#passwordConfirmation").val(),
                token: $("#token").val()
            },
            method: 'POST',
            success: function(data) {
                // console.log(data)
                const obj = JSON.parse(data);

                //--------------------Validation Password------------------------
                if (obj.password_err != '') {
                    $("#passHelp").html(obj.password_err)
                    $("#pass").addClass("is-invalid");

                } else {
                    $("#passHelp").html('')
                    $("#pass").removeClass("is-invalid");
                }
                //--------------------Validation Confirm Password------------------------
                if (obj.passwordConfirmation_err != '') {
                    $("#passHelpConfirm").html(obj.passwordConfirmation_err)
                    $("#passwordConfirmation").addClass("is-invalid");
                } else {
                    $("#passHelpConfirm").html('')
                    $("#passwordConfirmation").removeClass("is-invalid");
                }

                // ---------------------Redirect----------------------
                if (obj.status) {
                    $("#msgSuccess").html('Password Changed Successfully!')
                    setTimeout(() => {
                        window.location.href = '<?php echo URLROOT; ?>/pages/index'
                    }, 500);
                }

            }
        });

    }
</script>