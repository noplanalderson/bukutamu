<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Manajemen User </h3>
              <nav aria-label="breadcrumb">
                <?= button($btn_add, TRUE, 'button', 'class="btn btn-md tambah-user btn-primary" data-toggle="modal" data-target="#userModal"');?>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2">Daftar User</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered w-100" id="tblUser">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Tipe User</th>
                                <th>Email</th>
                                <th>Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="User" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-grey-m1" id="accessAction"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('', 'method="post" id="userForm" accept-charset="utf-8"');?>
              <div class="row">
                  <div class="col-md-6">
                      <input type="hidden" name="id_user" id="id_user" value="">
                      <div class="form-group">
                          <label for="user_name">Username *</label>
                          <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Username" data-parsley-pattern="^[A-Za-z0-9_]{1,15}$" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="user_email">Email *</label>
                          <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Email User" required="required">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Nama *</label>
                      <input type="text" id="real_name" name="real_name" placeholder="Nama" class="form-control" required="required"/>
                      <small class="text-danger">Hanya Huruf, titik, koma, dan Spasi</small>
                    </div>
                  </div>
              </div>
              <div class="row mt-1">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="type_id">Jabatan *</label>
                          <select id="type_id" class="form-control text-white" name="type_id" required="required">
                              <option value="">Pilih Tipe User</option>
                              <?php foreach ($user_type as $type) :?>

                                  <option value="<?= $type->type_id ?>"><?= $type->type_name ?></option>
                              
                              <?php endforeach;?>
                          </select>
                      </div>
                  </div>
                  <div id="is_active_box" class="col-md-6">
                    <div class="form-check mt-4">
                      <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" id="user_status" name="user_status" value="1"> Aktivasi User <i class="input-helper"></i></label>
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="reset" data-dismiss="modal">Reset</button>
                <input type="submit" id="submitUser" class="my-3 btn btn-small btn-success" name="submit" value="Submit">
                </form>
            </div>
          </div>
        </div>
      </div>