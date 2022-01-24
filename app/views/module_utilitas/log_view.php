<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2 float-left">Log Sistem</h4>
                    <div class="form-group form-inline float-right">
                      <label class="mr-4 mt-1 text-dark" for="range">Periode</label>
                      <?= form_open('log-sistem/data', 'id="formSysLog"'); ?>
                        <input type="text" id="range" name="range" aria-label="Periode" placeholder="Periode" class="form-control">
                      </form>
                    </div>
                  </div>
                  <div class="card-body">
                    <small class="daterange text-muted"></small>
                    <div class="table-responsive mt-3">
                      
                      <table class="table table-striped table-bordered w-100" id="tblSysLog">
                        <thead>
                            <tr>
                                <th>Tipe Log</th>
                                <th>Tanggal</th>
                                <th class="no-sort">Log</th>
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