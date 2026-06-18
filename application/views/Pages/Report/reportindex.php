<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<style type="text/css">
  .card-pricing .specification-list li {
    font-size: 13px;
  }
  .card.card-pricing {
    height: 602px;
  }
  .card-pricing .specification-list li {
    border-bottom: 1px solid #000 !important;
  }
</style>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">
      <h3 class="fw-bold mb-3">Tambah Retur Penjualan </h3>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 ps-md-0">
                <div class="card card-pricing" style="background-color: antiquewhite;">
                  <div class="card-header">
                    <h4 class="card-title">Laporan Master Data</h4>
                  </div>
                  <div class="card-body">
                    <ul class="specification-list">
                      <a href="<?php echo base_url(); ?>Reportmaster/reportbrand">
                        <li>
                          <span class="name-specification">Laporan Brand</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportmaster/reportcustomer">
                        <li>
                          <span class="name-specification">Laporan Customer</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportmaster/reportekspedisi">
                        <li>
                          <span class="name-specification">Laporan Ekspedisi</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportmaster/reportwarehouse">
                        <li>
                          <span class="name-specification">Laporan Gudang</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportmaster/reportcategory">
                        <li>
                          <span class="name-specification">Laporan Kategori</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportmaster/reportproduct">
                        <li>
                          <span class="name-specification">Laporan Produk</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportmaster/reportsalesman">
                        <li>
                          <span class="name-specification">Laporan Salesman</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportmaster/reportsupplier">
                        <li>
                          <span class="name-specification">Laporan Supplier</span>
                        </li>
                      </a>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-md-3 ps-md-0">
                <div class="card card-pricing" style="background-color: aliceblue;">
                  <div class="card-header">
                    <h4 class="card-title">Laporan Pembelian</h4>
                  </div>
                  <div class="card-body">
                    <ul class="specification-list">
                      <a href="<?php echo base_url(); ?>Reportpurchase/reportsubmission">
                        <li>
                          <span class="name-specification">Laporan Pengajuan</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportpurchase/reportpo">
                        <li>
                          <span class="name-specification">Laporan PO</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportpurchase/reportinputwarehouse">
                        <li>
                          <span class="name-specification">Laporan Penginputan Gudang</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportpurchase/reportpurchases">
                        <li>
                          <span class="name-specification">Laporan Pembelian</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportpurchase/reportreturpurchase">
                        <li>
                          <span class="name-specification">Laporan Retur Pembelian</span>
                        </li>
                      </a>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-md-3 ps-md-0">
                <div class="card card-pricing" style="background-color: lavenderblush;">
                  <div class="card-header">
                    <h4 class="card-title">Laporan Penjualan</h4>
                  </div>
                  <div class="card-body">
                    <ul class="specification-list">
                      <a href="<?php echo base_url(); ?>Reportsales/reportsalesorder">
                        <li>
                          <span class="name-specification">Laporan Sales Order</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportsales/reportsaless">
                        <li>
                          <span class="name-specification">Laporan Penjualan</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportsales/reportrevisisales">
                      <li>
                        <span class="name-specification">Laporan Revisi Penjualan</span>
                      </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportsales/reportretursales">
                      <li>
                        <span class="name-specification">Laporan Retur Penjualan</span>
                      </li>
                      </a>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-md-3 ps-md-0">
                <div class="card card-pricing" style="background-color: seashell;">
                  <div class="card-header">
                    <h4 class="card-title">Laporan Hutang / Piutang</h4>
                  </div>
                  <div class="card-body">
                    <ul class="specification-list">
                      <a href="<?php echo base_url(); ?>Reportpayment/reportdebtduedate">
                        <li>
                          <span class="name-specification">Laporan Hutang Jatuh Tempo</span>
                        </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportpayment/reportrepaymentduedate">
                      <li>
                        <span class="name-specification">Laporan Piutang Jatuh Tempo</span>
                      </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportpayment/reportrepayments">
                      <li>
                        <span class="name-specification">Laporan Pelunasan Hutang</span>
                      </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportpayment/reportpiutang">
                      <li>
                        <span class="name-specification">Laporan Pelunasan Piutang</span>
                      </li>
                      </a>
                    </ul>
                  </div>
                </div>
              </div>


              <div class="col-md-3 ps-md-0">
                <div class="card card-pricing" style="background-color:powderblue;">
                  <div class="card-header">
                    <h4 class="card-title">Laporan Utility</h4>
                  </div>
                  <div class="card-body">
                    <ul class="specification-list">
                      <a href="<?php echo base_url(); ?>Reportstock/stockist">
                      <li>
                        <span class="name-specification">Laporan Stok</span>
                      </li>
                      </a>
                      <a href="<?php echo base_url(); ?>Reportstock/stockcard">
                      <li>
                        <span class="name-specification">Laporan Kartu Stok</span>
                      </li>
                      </a>
                    </ul>
                  </div>
                </div>
              </div>



            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>