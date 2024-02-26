 <!-- Main Footer -->
 <footer class="main-footer">
   <strong>Copyright &copy; <?= date('Y') ?>
     <a class="text-light" href="https://hira-express.com" class="text-light">Hira Express</a>
   </strong>
   Made With 💖
   <div class="float-right d-none d-sm-inline-block">
     <b>ver</b> 0.1.0
   </div>
 </footer>
 </div>

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

 <!-- Sweetalert -->
 <script src="<?= base_url('assets/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>

 <!-- Select2 -->
 <script src="<?= base_url('assets/') ?>plugins/select2/js/select2.full.min.js"></script>

 <script src="<?= base_url('assets/') ?>dist/js/pages/clock.js"></script>

 <script src="<?= base_url('assets/') ?>dist/js/pages/number-format.js"></script>

 <!-- Custom Script -->
 <script>
   const userlogin = $(".userlogin").data("flashdata");

   if (userlogin) {
     Swal.fire({
       icon: "success",
       title: "Login berhasil!",
       text: userlogin,
     });
   }
 </script>
 <?php if ($this->uri->segment(1) == 'armada') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/master/armada.js"></script>
 <?php } else if ($this->uri->segment(1) == 'customer') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/master/customer.js"></script>
 <?php } else if ($this->uri->segment(1) == 'karyawan') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/master/karyawan.js"></script>
 <?php } else if ($this->uri->segment(1) == 'sopir') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/master/sopir.js"></script>
 <?php } else if ($this->uri->segment(1) == 'user') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/master/user.js"></script>
 <?php } else if ($this->uri->segment(1) == 'uangmakan' && $this->uri->segment(2) == '') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/administrasi/uangmakan.js"></script>
   <script>
     const inserted = $(".inserted").data("flashdata");

     if (inserted) {
       Swal.fire({
         icon: "success",
         title: "Success",
         text: inserted,
       });
     }
   </script>
 <?php } else if ($this->uri->segment(1) == 'uangmakan' && $this->uri->segment(2) == 'addUangMakan') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/administrasi/add-uangmakan.js"></script>
 <?php } else if ($this->uri->segment(1) == 'uangmakan' && $this->uri->segment(2) == 'update') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/administrasi/update-uangmakan.js"></script>
 <?php } else if ($this->uri->segment(1) == 'order') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/trans/order.js"></script>
 <?php } else if ($this->uri->segment(1) == 'sangu') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/administrasi/sangu.js"></script>
 <?php } else if ($this->uri->segment(1) == 'penjualan') { ?>
   <script src="<?= base_url('assets/') ?>dist/js/pages/trans/penjualan.js"></script>
 <?php } ?>

 </body>

 </html>