<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2 float-left">Data Tamu</h4>
                    <div class="form-group form-inline float-right">
                      <label class="mr-4 mt-1 text-dark" for="range">Periode</label>
                      <?= form_open('log-tamu/data', 'id="formLogTamu"'); ?>
                        <input type="text" id="range" name="range" aria-label="Periode" placeholder="Periode" class="form-control">
                      </form>
                    </div>
                  </div>
                  <div class="card-body">
                    <small class="daterange text-muted"></small>
                    <div class="table-responsive mt-3">
                      
                      <table class="table table-striped table-bordered w-100" id="tblTamu">
                        <thead>
                            <tr>
                                <th class="no-sort">Tanggal</th>
                                <th class="no-sort">Nama Tamu</th>
                                <th class="no-sort">Jam Masuk</th>
                                <th class="no-sort">Jam Keluar</th>
                                <th class="no-sort">Organisas/Instansi</th>
                                <th class="no-sort">Keperluan</th>
                                <th class="no-sort">Aksi</th>
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

      <div class="modal fade" id="tamuModal" role="dialog" aria-labelledby="Detail Tamu" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-grey-m1 float-left"></h5>
                <button class="btn btn-success export-pdf float-right" type="button">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
            <div id="data-tamu" class="p-5 modal-body">

              <div class="table-responsive">
                <table id="device_detail" class="table table-bordered w-100">
                  <tr height="50px">
                    <th colspan="2" class="title">Detail Tamu</th>
                  </tr>
                  <tr>
                    <td width="20%">Nama Tamu</td>
                    <td class="nama_tamu"></td>
                  </tr>
                  <tr>
                    <td width="20%">Tanggal Masuk</td>
                    <td class="time_in"></td>
                  </tr>
                  <tr>
                    <td width="20%">Tanggal Keluar</td>
                    <td class="time_out"></td>
                  </tr>
                  <tr>
                    <td width="20%">Organisasi/Instansi</td>
                    <td class="organisasi"></td>
                  </tr>
                  <tr>
                    <td width="20%">No. Telepon</td>
                    <td class="nomor_telepon"></td>
                  </tr>
                  <tr>
                    <td width="20%">Keperluan</td>
                    <td class="keperluan"></td>
                  </tr>
                  <tr>
                    <td width="20%">Foto Tamu</td>
                    <td class="foto_tamu"></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal">Tutup</button>
              </form>
            </div>
          </div>
        </div>
      </div>