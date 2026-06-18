
<footer class="footer">
  <div class="container-fluid d-flex justify-content-between">
    <nav class="pull-left">
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
    </nav>
    <div class="copyright">
      2024, made with <i class="fa fa-heart heart text-danger"></i> by
      <a href="http://www.themekita.com">ThemeKita</a>
    </div>
    <div>
      Distributed by
      <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
    </div>
  </div>
</footer>
</div>


</script>

<script src="<?php echo base_url(); ?>dist/js/core/jquery-3.7.1.min.js"></script>


<script src="<?php echo base_url(); ?>dist/js/core/popper.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/core/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/chart.js/chart.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/chart-circle/circles.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/jsvectormap/world.js"></script>
<script src="<?php echo base_url(); ?>dist/js/plugin/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/kaiadmin.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/fancybox.js"></script>
<script src="<?php echo base_url(); ?>dist/js/select2.js"></script>
<script src="<?php echo base_url(); ?>dist/js/autonumeric.js"></script>
<script src="<?php echo base_url(); ?>dist/js/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
 <script src="<?php echo base_url(); ?>dist/js/parsley.js"></script>


<script>





  $('#basic-datatables').DataTable({
    order: [[0, 'asc']],
  })

  $('body').on('shown.bs.modal', '.modal', function() {
    $(this).find('.js-example-basic-multiple').each(function() {
      var dropdownParent = $(document.body);
      if ($(this).parents('#myModal').length !== 0)
        dropdownParent = $("#myModal");
      $(this).select2({
        dropdownParent: $("#myModal")
      // ...
      });
    });
  });


  $('body').on('shown.bs.modal', '.editmodal', function() {
    $(this).find('.js-example-basic-multiple').each(function() {
      var dropdownParent = $(document.body);
      if ($(this).parents('#exampleModaledit').length !== 0)
        dropdownParent = $("#exampleModaledit");
      $(this).select2({
        dropdownParent: $("#exampleModaledit")
      // ...
      });
    });
  });



  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  });

  $('body').on('shown.bs.modal', '.modal', function() {
    $(this).find('.js-example-basic-single').each(function() {
      var dropdownParent = $(document.body);
      if ($(this).parents('#myModal').length !== 0)
        dropdownParent = $("#myModal");
      $(this).select2({
        dropdownParent: $("#myModal")
      // ...
      });
    });
  });


  $('body').on('shown.bs.modal', '.editmodal', function() {
    $(this).find('.js-example-basic-single').each(function() {
      var dropdownParent = $(document.body);
      if ($(this).parents('#exampleModaledit').length !== 0)
        dropdownParent = $("#exampleModaledit");
      $(this).select2({
        dropdownParent: $("#exampleModaledit")
      // ...
      });
    });
  });

  
  $('body').on('shown.bs.modal', '.filter', function() {
    $(this).find('.js-example-basic-single').each(function() {
      var dropdownParent = $(document.body);
      if ($(this).parents('#myModalsearch').length !== 0)
        dropdownParent = $("#myModalsearch");
      $(this).select2({
        dropdownParent: $("#myModalsearch")
      // ...
      });
    });
  });

  $('#reload').click(function(e){
    e.preventDefault();
    location.reload();
  });

  $(document).ready(function() {
    $('.js-example-basic-single').select2();
  });

  Fancybox.bind("[data-fancybox]", {
  }) 

  var pieChart = document.getElementById("pieChart").getContext("2d");
  var myPieChart = new Chart(pieChart, {
    type: "pie",
    data: {
      datasets: [
        {
          data: [50, 35, 15],
          backgroundColor: ["#1d7af3", "#f3545d", "#fdaf4b"],
          borderWidth: 0,
        },
      ],
      labels: ["Pendapatan", "Pengeluaran", "Hpp"],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: "bottom",
        labels: {
          fontColor: "rgb(154, 154, 154)",
          fontSize: 11,
          usePointStyle: true,
          padding: 20,
        },
      },
      pieceLabel: {
        render: "percentage",
        fontColor: "white",
        fontSize: 14,
      },
      tooltips: false,
      layout: {
        padding: {
          left: 20,
          right: 20,
          top: 20,
          bottom: 20,
        },
      },
    },
  });

  function notif_success(title, message, state)
  {
    var placementFrom = $("#notify_placement_from option:selected").val();
    var placementAlign = $("#notify_placement_align option:selected").val();
    var state = state;
    var style = state;
    var content = {};

    content.message = message;
    content.title = title;
    content.icon = "fa fa-bell";

    $.notify(content, {
      type: state,
      placement: {
        from: placementFrom,
        align: placementAlign,
      },
      time: 1000,
      delay: 25,
    });
  }

</script>
</body>
</html>