    <div class="content-wrapper">
      <div class="userlogin" data-flashdata="<?= $this->session->flashdata('userlogin'); ?>"></div>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?= $title ?></h1>
            </div>
            <div class="col-sm-6">
              <div class="breadcrumb mr-1 float-sm-right">
                <span class="pt-1">Hello <?= $this->session->userdata('username') ?>, welcome to the jungle..</span>

              </div>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cart-plus"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Order DIterima</span>
                  <span class="info-box-number">
                    <?= $order ?>
                    <small> Order</small>
                  </span>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="far fa-clipboard"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Resi Dibuat</span>
                  <span class="info-box-number">
                    <?= $sales ?>
                    <small> Resi</small>
                  </span>
                </div>
              </div>
            </div>

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-portrait"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Customer</span>
                  <span class="info-box-number">
                    <?= $cust ?>
                    <small>Orang</small>
                  </span>
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-check-alt"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Kas Masuk</span>
                  <span class="info-box-number">
                    Rp. 15.000.000 &nbsp;&nbsp;
                    <small class="fas fa-arrow-down text-success"></small>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-check-alt"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Kas Keluar</span>
                  <span class="info-box-number">
                    Rp. 15.000.000 &nbsp;&nbsp;
                    <small class="fas fa-arrow-up text-danger"></small>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>