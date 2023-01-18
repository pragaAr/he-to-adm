 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <a href="<?= base_url('home') ?>" class="brand-link">
     <img src="<?= base_url('assets/') ?>dist/img/logo-sm.png" alt="Hira Logo Sm" class="brand-image img-circle" style="opacity: .8">
     <span class="brand-text font-weight-bold ml-3">Hira Express</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <li class="nav-item">
           <a href=" <?= base_url('home') ?>" class="nav-link <?= $this->uri->segment(1) == 'home' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-home"></i>
             <p>
               Home
             </p>
           </a>
         </li>
         <li class="nav-header">Operasional</li>
         <li class="nav-item">
           <a href="<?= base_url('armada') ?>" class="nav-link <?= $this->uri->segment(1) == 'armada' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-truck-moving"></i>
             <p>Armada</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="<?= base_url('karyawan') ?>" class="nav-link <?= $this->uri->segment(1) == 'karyawan' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-user-tie"></i>
             <p>Karyawan</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="<?= base_url('sopir') ?>" class="nav-link <?= $this->uri->segment(1) == 'sopir' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon far fa-user"></i>
             <p>Sopir</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="<?= base_url('user') ?>" class="nav-link <?= $this->uri->segment(1) == 'user' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-user-lock"></i>
             <p>User</p>
           </a>
         </li>
         <li class="nav-header">Pemasukan</li>
         <li class="nav-item">
           <a href="<?= base_url('pemasukan_kas') ?>" class="nav-link <?= $this->uri->segment(1) == 'pemasukan_kas' || $this->uri->segment(1) == '' ? 'active' : '' ?>" class="nav-link">
             <i class="nav-icon fas fa-money-check-alt"></i>
             <p>Pemasukan Kas</p>
           </a>
         </li>
         <li class="nav-header">Pengeluaran</li>
         <li class="nav-item">
           <a href="<?= base_url('uangmakan') ?>" class="nav-link <?= $this->uri->segment(1) == 'uangmakan' || $this->uri->segment(1) == '' ? 'active' : '' ?>" class="nav-link">
             <i class="nav-icon fas fa-hand-holding-usd"></i>
             <p>Uang Makan</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="<?= base_url('sangu') ?>" class="nav-link <?= $this->uri->segment(1) == 'sangu' || $this->uri->segment(1) == '' ? 'active' : '' ?>" class="nav-link">
             <i class="nav-icon fas fa-wallet"></i>
             <p>Sangu</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="<?= base_url('persensopir') ?>" class="nav-link <?= $this->uri->segment(1) == 'persensopir' || $this->uri->segment(1) == '' ? 'active' : '' ?>" class="nav-link">
             <i class="nav-icon fas fa-percentage"></i>
             <p>Persen Sopir</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="<?= base_url('pengeluaran_lain') ?>" class="nav-link <?= $this->uri->segment(1) == 'pengeluaran_lain' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-search-dollar"></i>
             <p>Lain-lain</p>
           </a>
         </li>
         <li class="nav-header">Penjualan</li>
         <li class="nav-item">
           <a href="<?= base_url('customer') ?>" class="nav-link <?= $this->uri->segment(1) == 'customer' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-portrait"></i>
             <p>Customer</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="<?= base_url('order') ?>" class="nav-link <?= $this->uri->segment(1) == 'order' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-cart-plus"></i>
             <p>Order</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="<?= base_url('penjualan') ?>" class="nav-link <?= $this->uri->segment(1) == 'penjualan' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon far fa-clipboard"></i>
             <p>
               Penjualan
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="<?= base_url('invoice') ?>" class="nav-link <?= $this->uri->segment(1) == 'invoice' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-envelope-open-text"></i>
             <p>
               Invoice
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-file-alt"></i>
             <p>
               Report Penjualan
               <i class="right fas fa-angle-right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="fas fa-minus nav-icon"></i>
                 <p>Level 2</p>
               </a>
             </li>
           </ul>
         </li>
         <li class="nav-header">Akuntansi</li>
         <li class="nav-item">
           <a href="<?= base_url('rekening') ?>" class="nav-link <?= $this->uri->segment(1) == 'rekening' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-book"></i>
             <p>Buku Rekening</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="" class="nav-link">
             <i class="nav-icon fas fa-file-invoice-dollar"></i>
             <p>LKH</p>
           </a>
         </li>
         <!-- <li class="nav-header">Report</li>
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="fas fa-circle nav-icon"></i>
             <p>Level 1</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-circle"></i>
             <p>
               Level 1
               <i class="right fas fa-angle-right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Level 2</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>
                   Level 2
                   <i class="right fas fa-angle-left"></i>
                 </p>
               </a>
               <ul class="nav nav-treeview">
                 <li class="nav-item">
                   <a href="#" class="nav-link">
                     <i class="far fa-dot-circle nav-icon"></i>
                     <p>Level 3</p>
                   </a>
                 </li>
                 <li class="nav-item">
                   <a href="#" class="nav-link">
                     <i class="far fa-dot-circle nav-icon"></i>
                     <p>Level 3</p>
                   </a>
                 </li>
                 <li class="nav-item">
                   <a href="#" class="nav-link">
                     <i class="far fa-dot-circle nav-icon"></i>
                     <p>Level 3</p>
                   </a>
                 </li>
               </ul>
             </li>
           </ul>
         </li> -->
       </ul>
     </nav>
   </div>
 </aside>