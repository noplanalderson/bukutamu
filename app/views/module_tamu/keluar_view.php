<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card bg-transparan col-lg-4 mx-auto">
              <div class="card-body px-4 py-4">
                <div class="text-center">
                  <img src="<?= site_url('_/uploads/sites/'.$this->app->app_logo_dashboard) ?>" class="mt-5 mb-5">
                </div>
                <?= form_open('', 'method="post" id="formTamuKeluar"'); ?>
                  <div class="form-group">
                    <label for="token_tamu">Token *</label>
                    <input type="text" class="form-control" name="token_tamu" id="token_tamu" placeholder="_ _ _ _ _ _" required />
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <a href="<?= base_url('tamu') ?>" title="Checkin" class="btn btn-primary btn-block pt-2 pb-2 mt-2"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <button type="submit" id="submit" name="submit" class="btn btn-outline-danger btn-md btn-block pt-2 pb-2 mt-2"><i class="fas fa-sign-out-alt"></i>Keluar</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="text-center mt-3">
                  <small class="text-dark">Copyright &copy; 2021 - Buku Tamu v<?= APP_VERSION ?><br/>Bidang TIK | Dinas Komunikasi dan Informatika</small>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->