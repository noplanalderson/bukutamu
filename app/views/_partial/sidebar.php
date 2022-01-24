<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
      <div class="container-scroller">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas bg-secondary" id="sidebar">
          <div class="sidebar-brand-wrapper bg-secondary d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <!-- <a class="sidebar-brand brand-logo text-center" href="<?= base_url() ?>">
              <i class="fas fa-server icon-md text-metro ml-4 mr-1 float-left"></i> <h2 class="float-right mr-5 text-metro">D C I M</h2>
            </a>
            <a class="sidebar-brand brand-logo-mini" href="<?= base_url() ?>">
              <i class="fas fa-server icon-md text-metro"></i>
             --></a>
            <a class="sidebar-brand brand-logo" href="<?= base_url() ?>"><img src="<?= site_url('_/uploads/sites/'.$this->app->app_logo_dashboard) ?>" alt="Logo Aplikasi" class='w-50 h-50 ml-5'/></a>
            <a class="sidebar-brand brand-logo-mini" href="<?= base_url() ?>"><img src="<?= site_url('_/uploads/sites/'.$this->app->app_logo) ?>" alt="Logo Aplikasi" class='w-50 h-50'/></a>
          </div>
          <ul class="nav active">
            <li class="nav-item profile">
              <div class="profile-desc">
                <div class="profile-pic">
                  <div class="count-indicator">
                    <img class="img-xs rounded-circle " src="<?= site_url('_/uploads/users/'.encrypt($this->session->userdata('uid')).'/'.$this->user->user_picture) ?>" alt="<?= $this->user->real_name ?>">
                    <span class="count bg-success"></span>
                  </div>
                  <div class="profile-name">
                    <h5 class="mb-0 font-weight-normal"><?= $this->user->real_name ?></h5>
                    <span class="text-metro"><?= $this->user->type_name ?></span>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item nav-category">
              <span class="nav-link">Navigasi</span>
            </li>
            <?php 
              foreach ($this->menus as $menu) :

              $submenus = $this->app_m->getSubMenu($menu->menu_id);
              if(empty($submenus)) {
            ?>

            <li class="nav-item menu-items">
              <a class="nav-link" href="<?= base_url($menu->menu_link) ?>">
                <span class="menu-icon">
                  <i class="<?= $menu->menu_icon ?>"></i>
                </span>
                <span class="menu-title"><?= $menu->menu_label ?></span>
              </a>
            </li>
            <?php } else { ?>

            <li class="nav-item menu-items">
              <a class="nav-link" data-toggle="collapse" href="<?= $menu->menu_link ?>" aria-expanded="false" aria-controls="<?= ltrim($menu->menu_link, '#') ?>">
                <span class="menu-icon">
                  <i class="<?= $menu->menu_icon ?>"></i>
                </span>
                <span class="menu-title"><?= $menu->menu_label ?></span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="<?= ltrim($menu->menu_link, '#') ?>">
                <ul class="nav flex-column sub-menu">
                  <?php foreach ($submenus as $submenu): ?>

                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url($submenu->menu_link) ?>">
                      <i class="<?= $submenu->menu_icon ?> text-white"></i>
                      <span class="menu-title text-white ml-1"><?= $submenu->menu_label ?></span>
                    </a>
                  </li>
                  <?php endforeach; ?>

                </ul>
              </div>
            </li>
            <?php } endforeach;?>
          
          </ul>
        </nav>