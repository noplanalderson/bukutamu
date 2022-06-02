<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card bg-transparan col-lg-8 mx-auto">
              <div class="card-body px-4 py-4">
                <div class="text-center">
                  <img src="<?= site_url('_/uploads/sites/'.$this->app->app_logo_dashboard) ?>" class="mt-5 mb-5">
                </div>
                <?= form_open('', 'id="formTamuMasuk"');?>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="nama_tamu">Nama Lengkap *</label>
                        <input type="text" id="nama_tamu" name="nama_tamu" class="form-control bg-light text-dark border-0" placeholder="Nama Lengkap" required="required">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="nomor_telepon">No. Telepon *</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text border-light">+62</span>
                          </div>
                          <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" placeholder="No. Telepon" required="required">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="organisasi">Organisasi/Instansi *</label>
                        <input type="text" id="organisasi" name="organisasi" class="form-control bg-light text-dark border-0" placeholder="Asal Instansi/Organisasi" required="required">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="email_tamu">Email *</label>
                        <input type="email" id="email_tamu" name="email_tamu" class="form-control bg-light text-dark border-0" placeholder="Alamat Email" required="required">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="keperluan">Keperluan *</label>
                    <textarea id="keperluan" name="keperluan" class="form-control bg-light text-dark border-0" placeholder="Keperluan" required="required"></textarea>
                  </div>
                  <div class="form-group">
                    <video id="video" width="320" height="240" class="rounded" autoplay></video>
                    <canvas class="d-none rounded" id="canvas" width="320" height="240"></canvas>
                    <button type="button" id="start-camera" name="kamera_btn" class="btn btn-outline-info btn-md btn-block pt-2 pb-2 mt-2">Foto</button>
                    <button type="button" class="btn btn-outline-info btn-md btn-block pt-2 pb-2 mt-2"id="click-photo">Ambil Foto</button>
                    <input type="hidden" name="dataurl" id="dataurl" required>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-6">
                        <a href="<?= base_url('tamu/keluar') ?>" title="Checkout" class="btn btn-outline-danger btn-block pt-2 pb-2 mt-2"><i class="fas fa-sign-out-alt"></i> Keluar</a>
                      </div>
                      <div class="col-6">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary btn-md btn-block pt-2 pb-2 mt-2"><i class="fas fa-sign-in-alt"></i> Masuk </button>
                      </div>
                    </div>  
                  </div>
                  <div class="text-center mt-3">
                    <small class="text-dark">Copyright &copy; 2021 - Buku Tamu v<?= APP_VERSION ?><br/>Bidang TIK | Dinas Komunikasi dan Informatika</small>
                  </div>
                </form>
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