</div> <!-- end/main-panel -->
</div> <!-- end/wapp -->
<footer class="footer">
  <div class="container-fluid d-flex justify-content-center">
    <!-- <nav class="pull-left">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="http://www.themekita.com">
            ThemeKita
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"> Help </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"> Licenses </a>
        </li>
      </ul>
    </nav> -->
    <div class="copyright"><?php echo date('Y'); ?>,
      <a href="#">SurgePays SV</a>
    </div>
    <!-- <div>
      Distributed by
      <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
    </div> -->
  </div>
</footer>

<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.js"></script>

<script src="<?php echo URLROOT ?>/assets/js/core/jquery-3.7.1.min.js"></script>
<script src="<?php echo URLROOT ?>/assets/js/core/popper.min.js"></script>
<script src="<?php echo URLROOT ?>/assets/js/core/bootstrap.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Chart JS -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="<?php echo URLROOT ?>/assets/js/plugin/jsvectormap/world.js"></script>

<!-- Sweet Alert -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Select 2 -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/select2/select2.full.min.js"></script>

<!-- validate -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/jquery.validate/jquery.validate.min.js"></script>

<!-- Mask -->
<script src="<?php echo URLROOT ?>/assets/js/plugin/jquery.mask/jquery.mask.js"></script>

<!-- Kaiadmin JS -->
<script src="<?php echo URLROOT ?>/assets/js/kaiadmin.min.js"></script>

<!-- DropZone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
  // Check Session
  setInterval(function() {
    fetch('<?php echo URLROOT; ?>/Auths/checkSession')
      .then(response => response.json())
      .then(data => {
        // console.log(data)
        // console.log(data.session_active)
        if (data.session_active == 'inactivity') {
          window.location.href = '<?php echo URLROOT; ?>/auths/login?inactivity=true'; // Redirigir si la sesión no está activa
        }
      });
  }, 60000); // Comprueba cada minuto
</script>


<!-- Kaiadmin DEMO methods, don't include it in your project! NOTIFICATION -->
<!-- <script src="<?php echo URLROOT ?>/assets/js/setting-demo.js"></script> -->
<!-- <script src="<?php echo URLROOT ?>/assets/js/demo.js"></script> -->

<!-- <script>
 $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#177dff",
    fillColor: "rgba(23, 125, 255, 0.14)",
  });

  $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#f3545d",
    fillColor: "rgba(243, 84, 93, .14)",
  });

  $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#ffa534",
    fillColor: "rgba(255, 165, 52, .14)",
  });
</script> -->
</body>

</html>