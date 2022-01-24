<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
          <footer class="footer bg-white">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?= date('Y') ?> | Buku Tamu v<?= APP_VERSION ?> by Debu Semesta</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-muted"><?= $this->app->app_footer ?></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- Password Modal-->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-grey-m1" id="exampleModalLabel">Ganti Kata Sandi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?= form_open('akun/ganti-kata-sandi', 'id="formGantiPwd" method="post"');?>
                    <div class="form-group">
                        <label for="user_password my-2">Kata Sandi *</label>
                        <div class="input-group">
                            <input id="user_password" 
                                type="password" 
                                class="form-control" 
                                placeholder="********"
                                name="user_password" 
                                data-parsley-pattern="^(?=.*[0-9])(?=.*[a-zA-Z]).{8,32}$"
                                data-parsley-errors-container="#pwd-error"
                                required="required" autocomplete="off">
                            <div class="input-group-prepend">
                                <span class="input-group-text show-btn-password"><i class="fa fa-eye password"></i></span>
                            </div>
                        </div>
                        <small class="text-danger">Kata sandi harus mengandung huruf dan angka minimal 8 karakter.</small>
                        <div id="pwd-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="user_password my-2">Ulangi Kata Sandi *</label>
                        <div class="input-group">
                            <input id="repeat_password" type="password" class="form-control" placeholder="********" name="repeat_password" data-parsley-equalto="#user_password" 
                                data-parsley-errors-container="#repeat-error" autocomplete="off">
                            <div class="input-group-prepend">
                                <span class="input-group-text show-btn-repeat"><i class="fa fa-eye repeat"></i></span>
                            </div>
                        </div>
                        <div id="repeat-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <input id="submitPassword" type="submit" class="btn btn-small btn-primary" name="submit" value="Ubah">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="akunModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-grey-m1" id="exampleModalLabel">Pengaturan Akun</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?= form_open_multipart('akun/update', 'id="formAkun" method="post"');?>
                    <div class="form-group">
                        <label for="real_name">Nama *</label>
                        <input id="real_name__akun" type="text" class="form-control" name="real_name" placeholder="Nama" required="required">
                    </div>
                    <div class="form-group">
                        <label for="user_name">Username *</label>
                        <input id="user_name__akun" type="text" class="form-control" name="user_name" placeholder="Username (ex: user_name)" data-parsley-pattern="^[A-Za-z0-9._]{3,15}$" required="required">
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email *</label>
                        <input id="user_email__akun" type="email"  class="form-control" name="user_email" placeholder="kamu@dimana.domain" required="required">
                    </div>
                    <div class="form-group">
                        <label>Foto Profil</label>
                        <input type="file" name="user_picture" id="nama_file" class="file-upload-default">
                            <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" id="cari" type="button">Cari...</button>
                            </span>
                        </div>
                    </div>
                    <div id="is_active_box" class="col-md-6">
                        <div class="form-check mt-4">
                          <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" id="subscribe_notif" name="subscribe_notif" value="1"> Terima Notifikasi <i class="input-helper"></i></label>
                        </div>
                      </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <input id="submitAkun" type="submit" class="btn btn-small btn-primary" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>