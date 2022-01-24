(function($) {
  'use strict';
  $(function() {
    $('[data-toggle="offcanvas"]').on("click", function() {
      $('.sidebar-offcanvas').toggleClass('active')
    });
  });
})(jQuery);

(function($) {
  'use strict';
  //Open submenu on hover in compact sidebar mode and horizontal menu mode
  $(document).on('mouseenter mouseleave', '.sidebar .nav-item', function(ev) {
    var body = $('body');
    var sidebarIconOnly = body.hasClass("sidebar-icon-only");
    var sidebarFixed = body.hasClass("sidebar-fixed");
    if (!('ontouchstart' in document.documentElement)) {
      if (sidebarIconOnly) {
        if (sidebarFixed) {
          if (ev.type === 'mouseenter') {
            body.removeClass('sidebar-icon-only');
          }
        } else {
          var $menuItem = $(this);
          if (ev.type === 'mouseenter') {
            $menuItem.addClass('hover-open')
          } else {
            $menuItem.removeClass('hover-open')
          }
        }
      }
    }
  });
})(jQuery);

(function($) {
  'use strict';
  $(function() {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('.sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    function addActiveClass(element) {
      if (current === "") {
        //for root url
        if (element.attr('href').indexOf("index.html") !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
        }
      } else {
        //for other url
        if (element.attr('href').indexOf(current) !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
          if (element.parents('.submenu-item').length) {
            element.addClass('active');
          }
        }
      }
    }

    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav li a', sidebar).each(function() {
      var $this = $(this);
      addActiveClass($this);
    })

    $('.horizontal-menu .nav li a').each(function() {
      var $this = $(this);
      addActiveClass($this);
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
      if (!body.hasClass("rtl")) {
        if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {
          const settingsPanelScroll = new PerfectScrollbar('.settings-panel .tab-content .tab-pane.scroll-wrapper');
        }
        if ($('.chats').length) {
          const chatsScroll = new PerfectScrollbar('.chats');
        }
        if (body.hasClass("sidebar-fixed")) {
          var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
        }
      }
    }

    $('[data-toggle="minimize"]').on("click", function() {
      if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    //fullscreen
    $("#fullscreen-button").on("click", function toggleFullScreen() {
      if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
          document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
          document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    })
  });
})(jQuery);

(function($) {
  'use strict';
  $(function() {
    $(".nav-settings").click(function() {
      $("#right-sidebar").toggleClass("open");
    });
    $(".settings-close").click(function() {
      $("#right-sidebar,#theme-settings").removeClass("open");
    });

    $("#settings-trigger").on("click", function() {
      $("#theme-settings").toggleClass("open");
    });


    //background constants
    var navbar_classes = "navbar-danger navbar-success navbar-warning navbar-dark navbar-light navbar-primary navbar-info navbar-pink";
    var sidebar_classes = "sidebar-light sidebar-dark";
    var $body = $("body");

    //sidebar backgrounds
    $("#sidebar-default-theme").on("click", function() {
      $body.removeClass(sidebar_classes);
      $(".sidebar-bg-options").removeClass("selected");
      $(this).addClass("selected");
    });
    $("#sidebar-dark-theme").on("click", function() {
      $body.removeClass(sidebar_classes);
      $body.addClass("sidebar-dark");
      $(".sidebar-bg-options").removeClass("selected");
      $(this).addClass("selected");
    });


    //Navbar Backgrounds
    $(".tiles.primary").on("click", function() {
      $(".navbar").removeClass(navbar_classes);
      $(".navbar").addClass("navbar-primary");
      $(".tiles").removeClass("selected");
      $(this).addClass("selected");
    });
    $(".tiles.success").on("click", function() {
      $(".navbar").removeClass(navbar_classes);
      $(".navbar").addClass("navbar-success");
      $(".tiles").removeClass("selected");
      $(this).addClass("selected");
    });
    $(".tiles.warning").on("click", function() {
      $(".navbar").removeClass(navbar_classes);
      $(".navbar").addClass("navbar-warning");
      $(".tiles").removeClass("selected");
      $(this).addClass("selected");
    });
    $(".tiles.danger").on("click", function() {
      $(".navbar").removeClass(navbar_classes);
      $(".navbar").addClass("navbar-danger");
      $(".tiles").removeClass("selected");
      $(this).addClass("selected");
    });
    $(".tiles.info").on("click", function() {
      $(".navbar").removeClass(navbar_classes);
      $(".navbar").addClass("navbar-info");
      $(".tiles").removeClass("selected");
      $(this).addClass("selected");
    });
    $(".tiles.dark").on("click", function() {
      $(".navbar").removeClass(navbar_classes);
      $(".navbar").addClass("navbar-dark");
      $(".tiles").removeClass("selected");
      $(this).addClass("selected");
    });
    $(".tiles.default").on("click", function() {
      $(".navbar").removeClass(navbar_classes);
      $(".tiles").removeClass("selected");
      $(this).addClass("selected");
    });

    //Horizontal menu in mobile
    $('[data-toggle="horizontal-menu-toggle"]').on("click", function() {
      $(".horizontal-menu .bottom-navbar").toggleClass("header-toggled");
    });
    // Horizontal menu navigation in mobile menu on click
    var navItemClicked = $('.horizontal-menu .page-navigation >.nav-item');
    navItemClicked.on("click", function(event) {
      if(window.matchMedia('(max-width: 991px)').matches) {
        if(!($(this).hasClass('show-submenu'))) {
          navItemClicked.removeClass('show-submenu');
        }
        $(this).toggleClass('show-submenu');
      }        
    });

    $(window).scroll(function() {
      if(window.matchMedia('(min-width: 992px)').matches) {
        var header = $('.horizontal-menu');
        if ($(window).scrollTop() >= 71) {
          $(header).addClass('fixed-on-scroll');
        } else {
          $(header).removeClass('fixed-on-scroll');
        }
      }
    });

  });
})(jQuery);

const Toast = Swal.mixin({
     toast: true,
     position: 'bottom-end',
     showConfirmButton: false,
     timer: 5000
});

$(".show-btn-password").click(function() {
  var showBtn = $('.show-btn-password');
  var formPassword = $('#user_password').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-password d-flex hide-btn');
      $('.password').attr('class', 'fa fa-eye-slash password');
      $('#user_password').attr('type', 'text');
    }else{
      $('.password').attr('class', 'fa fa-eye password');
      $('#user_password').attr('type', 'password');
      showBtn.attr('class', 'input-group-text show-btn-password d-flex');
    }
});

$(".show-btn-repeat").click(function() {
  var showBtn = $('.show-btn-repeat');
  var formPassword = $('#repeat_password').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex hide-btn');
      $('.repeat').attr('class', 'fa fa-eye-slash repeat');
      $('#repeat_password').attr('type', 'text');
    }else{
      $('#repeat_password').attr('type', 'password');
      $('.repeat').attr('class', 'fa fa-eye repeat');
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex');
    }
});

var validasiPwd = $('#formGantiPwd').parsley();

$("#formGantiPwd").on('submit', function(e) {
  
  e.preventDefault();
  if(validasiPwd.isValid())
  {
    var formAction = $("#formGantiPwd").attr('action');
    var dataPassword = {
        user_password: $("#user_password").val(),
        repeat_password: $("#repeat_password").val(),
        bukutamu_token: $('.csrf_token').val()
    };

    $.ajax({
        type: "POST",
        url: formAction,
        data: dataPassword,
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Toast.fire({
                 type : 'error',
                 icon: 'error',
                 title: '',
                 text: data,
            });
        },
        success: function(data) {
          $('.csrf_token').val(data.token);
          $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

          if (data.result == 1) {
            Toast.fire({
                 type : 'success',
                 icon: 'success',
                 title: 'Berhasil!',
                 text: data.msg.replace( /(<([^>]+)>)/ig, ''),
            });
            $('#passwordModal').modal('hide');
          } else {
            Toast.fire({
                 type : 'error',
                 icon: 'error',
                 title: 'Gagal!',
                 text: data.msg.replace( /(<([^>]+)>)/ig, ''),
            });
          }
        }
    });
  }
    return false;
});

$(function(){
  $('#password').on('click', function() {
      $('.modal-title').html('Ganti Kata Sandi');
      $('.modal-footer button[type=submit]').html('Submit');
      $('.modal-body form').attr('action', baseURI + '/akun/ganti-kata-sandi');
    })
});

$(function(){
  $('#akun').on('click', function() {
        $('.modal-title').html('Pengaturan Akun');
        $('.modal-footer button[type=submit]').html('Submit');
        $('.modal-body form').attr('action', baseURI + '/akun/update');

        $.ajax({
            url: baseURI + '/akun',
            method: 'get',
            dataType: 'json',
            error: function(xhr, status, error) {
            var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                Toast.fire({
                     type : 'error',
                     icon: 'error',
                     title: '',
                     text: data,
                });
            },
            success: function(data){
                $('#user_name__akun').val(data.user_name);
                $('#user_email__akun').val(data.user_email);
                $('#real_name__akun').val(data.real_name);
                if(data.subscribe_notif == 1) {
                    $('#subscribe_notif').prop('checked', true);
                } else {
                    $('#subscribe_notif').prop('checked', false);
                }
            }
        });
    });
})

var validasiAkun = $('#formAkun').parsley();

$(document).ready(function(e){
  $("#formAkun").on('submit', function(e) {
    e.preventDefault();

    if(validasiAkun.isValid())
    {
      var formAction = $("#formAkun").attr('action');

      $.ajax({
          type: "POST",
          data: new FormData(this),
          processData: false,
          contentType: false,
          cache: false,
          timeout: 800000,
          url: formAction,
          dataType: 'json',
          error: function(xhr, status, error) {
          var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
              Toast.fire({
                   type : 'error',
                   icon: 'error',
                   title: '',
                   text: data,
              });
          },
          success: function(data) {
              $('.csrf_token').val(data.token);
              $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
            
            if (data.result == 1) {
              Toast.fire({
                   type : 'success',
                   icon: 'success',
                   title: 'Berhasil!',
                   text: data.msg.replace( /(<([^>]+)>)/ig, ''),
              });
              $('#akunModal').modal('hide');
              setTimeout(location.reload.bind(location), 1000);
            } else {
              Toast.fire({
                   type : 'error',
                   icon: 'error',
                   title: 'Gagal!',
                   text: data.msg.replace( /(<([^>]+)>)/ig, ''),
              });
            }
          }
      });
      return false;
    }
  });
});

(function($) {
  'use strict';
  $(function() {
    $('#cari').on('click', function() {
      var file = $(this).parent().parent().parent().find('#nama_file');
      file.trigger('click');
    });
    $('#nama_file').on('change', function() {
      $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
  });
})(jQuery);


function getFullscreenElement() {
  return document.fullscreenElement   //standard property
  || document.webkitFullscreenElement //safari/opera support
  || document.mozFullscreenElement    //firefox support
  || document.msFullscreenElement;    //ie/edge support
}

function toggleFullscreen() {
  var $card = $(this).closest('.card');
  if(getFullscreenElement()) {
    $('#fullscreen').html('<i class="mdi mdi-fullscreen mdi-36px"></i>');
    document.exitFullscreen();
  }else {
    $('#fullscreen').html('<i class="mdi mdi-fullscreen-exit mdi-36px"></i>');
    $card.requestFullscreen().catch(console.log);
  }
}

$('#fullscreen').on('click', () => {
  toggleFullscreen();
})

$('#keluar').on('click', function(e) {
  e.preventDefault();
  location.href = baseURI + '/keluar';
})

setInterval(showTime, 1000);
function showTime() {
    let time = new Date();
    let hour = time.getHours();
    let min = time.getMinutes();
    let sec = time.getSeconds();
    am_pm = " AM";
  
    if (hour > 12) {
        hour -= 12;
        am_pm = " PM";
    }
    if (hour == 0) {
        hr = 12;
        am_pm = " AM";
    }
  
    hour = hour < 10 ? "0" + hour : hour;
    min = min < 10 ? "0" + min : min;
    sec = sec < 10 ? "0" + sec : sec;
  
    let currentTime = hour + ":" + min + ":" + sec + am_pm;
  
    document.getElementById("jam").innerHTML = currentTime;
}
showTime();
