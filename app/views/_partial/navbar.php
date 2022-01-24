<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row bg-white">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="sidebar-brand brand-logo-mini" href="<?= base_url() ?>">
              <i class="fas fa-server icon-md"></i>
            </a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown">
                <div id="jam" class="float-right text-grey-m2"></div>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="<?= site_url('_/uploads/users/'.encrypt($this->session->userdata('uid')).'/'.$this->user->user_picture)?>" alt="<?= $this->user->real_name ?>">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name text-gray"><?= $this->user->real_name ?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Akun</h6>
                  <div class="dropdown-divider mb-2"></div>
                  <small class="p-3 text-grey-m2">Login Terakhir: <?= indonesian_date(date('Y-m-d H:i:s', $this->user->last_login), false, true) ?> | Dari: <?= $this->user->ip ?></small>
                  <div class="dropdown-divider mt-2"></div>
                  <a id="akun" href="#" data-toggle="modal" data-target="#akunModal" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Pengaturan Akun</p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" id="password" href="#" data-toggle="modal" data-target="#passwordModal">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-key-variant text-warning"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Ganti Kata Sandi</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a id="keluar" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Keluar</p>
                    </div>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <div class="main-panel">