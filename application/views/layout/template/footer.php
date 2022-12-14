 <!-- Main Footer -->
 <footer class="main-footer">
   <strong>Copyright &copy; 2022 <a class="text-light" href="https://hira-express.com">Hira Express</a></strong>
   Made With 💖
   <div class="float-right d-none d-sm-inline-block">
     <b>Version</b> 0.1.0
   </div>
 </footer>
 </div>

 <!-- REQUIRED SCRIPTS -->
 <!-- jQuery -->
 <script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
 <!-- Bootstrap -->
 <script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
 <!-- overlayScrollbars -->
 <script src="<?= base_url('assets/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
 <!-- AdminLTE App -->
 <script src="<?= base_url('assets/') ?>dist/js/adminlte.js"></script>

 <!-- DataTables  & Plugins -->
 <script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/jszip/jszip.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/pdfmake/pdfmake.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/pdfmake/vfs_fonts.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>

 <!-- PAGE PLUGINS -->
 <script src="<?= base_url('assets/') ?>plugins/select2/js/select2.full.min.js"></script>

 <!-- jQuery Mapael -->
 <script src="<?= base_url('assets/') ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/raphael/raphael.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
 <script src="<?= base_url('assets/') ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
 <!-- ChartJS -->
 <!-- <script src="<?= base_url('assets/') ?>plugins/chart.js/Chart.min.js"></script> -->

 <!-- <script src="<?= base_url('assets/') ?>dist/js/pages/dashboard2.js"></script> -->
 <script src="<?= base_url('assets/') ?>dist/js/pages/clock.js"></script>
 <script src="<?= base_url('assets/') ?>dist/js/pages/number-format.js"></script>
 <script src="<?= base_url('assets/') ?>dist/js/pages/custom.js"></script>

 <script>
   $(function() {
     $('.select2').select2()

     $("#dtable")
       .DataTable({
         responsive: true,
         lengthChange: false,
         autoWidth: false,
         //  buttons: ["excel", "pdf", "print"],
       })
       .buttons()
       .container()
       .appendTo("#example1_wrapper .col-md-6:eq(0)");
     //  $("#example2").DataTable({
     //    paging: true,
     //    lengthChange: false,
     //    searching: false,
     //    ordering: true,
     //    info: true,
     //    autoWidth: false,
     //    responsive: true,
     //  });
   });
 </script>
 </body>

 </html>