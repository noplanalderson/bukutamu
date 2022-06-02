<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    
                    <h4 class="card-title mt-2">Pengaturan Aplikasi</h4>
                  </div>
                  <div class="card-body">
                    <?= form_open('pengaturan-aplikasi/submit', 'id="formSetting"');?>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label for="app_title">Nama Aplikasi *</label>
                            <input type="text" id="app_title" name="app_title" placeholder="Nama Aplikasi" class="form-control" value="<?= $this->app->app_title ?>" required="required" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label for="app_footer">Teks Footer *</label>
                            <input type="text" id="app_footer" name="app_footer" placeholder="Teks Footer" class="form-control" value="<?= $this->app->app_footer ?>" required="required" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label>Logo/Icon Aplikasi</label>
                            <input type="file" name="app_logo" id="logo_file" class="file-upload-default">
                            <div class="input-group col-xs-12">
                              <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                              <span class="input-group-append">
                                  <button class="file-upload-browse btn btn-primary" id="cari_logo" type="button">Cari...</button>
                              </span>
                            </div>
                            <small class="text-danger">Maksimal 5MB berekstensi png, jpg, jpeg. Dipakai untuk logo pada halaman login dan icon aplikasi.</small>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Logo Dashboard</label>
                            <input type="file" name="app_logo_dashboard" id="logo_dashboard_file" class="file-upload-default">
                            <div class="input-group col-xs-12">
                              <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                              <span class="input-group-append">
                                  <button class="file-upload-browse btn btn-primary" id="cari_logo_dashboard" type="button">Cari...</button>
                              </span>
                            </div>
                            <small class="text-danger">Maksimal 5MB berekstensi png, jpg, jpeg. Dipakai untuk logo pada sidebar dashboard.</small>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                      <button type="reset" class="btn btn-dark">Reset</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>