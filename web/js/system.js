/*                         _
                        _ooOoo_
                       o8888888o
                       88" . "88
                       (| -_- |)
                       O\  =  /O
                    ____/`---'\____
                  .'  \\|     |//  `.
                 /  \\|||  :  |||//  \
                /  _||||| -:- |||||_  \
                |   | \\\  -  /'| |   |
                | \_|  `\`---'//  |   |
                \  .-\__ '-. -'__/-.  /
              ___`. .'  /--.--\  '. .'__
           ."" '<  `.__\_<|>_/__.'  _>  \"".
          | | : `- \`. ;'. _/; .'/ /  -'  ; |
          \ \ `-.  \_\_`. _.' _/_/  -'  _-' /
===========`-.'___`-.__\ \___ / __.-'_.-'_.-'===========
       "อบัคยา ปรมาลาภา" - การไม่มีบัคเป็นลาภอันประเสริฐ
*/
var System = {
  helper: {
    DataTable: {}
  },
  global: {},
  template: {},
  settings: {
    pace_module: true,
    toastr_module: true
  },
  controller: {
    'number_format': function ($view, number) {
      number = parseFloat(number);
      System.view($view).update(number.toLocaleString());
    },
    'get_filename': function ($view, file_input) {
      if (!file_input.files || !file_input.files[0]) return 'ยังไม่ได้เลือกไฟล์';
      System.view($view).update(file_input.files[0].name);
    },
    'get_imagebase64': function ($view, file_input) {
      System.readImage(file_input, function(e) {
        System.view($view).update(e.target.result);
      });
    },
    'get_image_status': function ($view, file_input) {
      var status = (System.readImage(file_input) == 'sucess') ? true : false;
      System.view($view).update(status);
    }
  }
};

System.helper.scrollTop = function () {
  return document.scrollTop || document.documentElement.scrollTop || document.body.scrollTop
}
System.helper.winHeight = function () {
  return window.innerHeight || document.documentElement.clientHeight;
}
System.helper.winWidth = function () {
  return window.innerWidth || document.documentElement.clientWidth;
}

System.setupAjax = function () {
  // toggle Pace on akax start
  $(document).ajaxStart(function () {
    if (System.settings.pace_module && typeof (Pace) != 'undefined') {
      Pace.restart();
    }
  });
  // setup ajax
  $.ajaxSetup({
    type: 'POST',
    dataType: 'json',
    catch: false,
    error: function (xhr, status, error) {
      var message;
      if (xhr.status === 0) {
        message = 'Not connected.\nPlease verify your network connection.';
      } else if (xhr.status == 404) {
        message = 'The requested page not found. [404]';
      } else if (xhr.status == 500) {
        message = 'Internal Server Error [500].';
      } else if (status === 'parsererror') {
        message = 'Requested JSON parse failed.';
      } else if (status === 'timeout') {
        message = 'Time out error.';
      } else if (status === 'abort') {
        message = 'Ajax request aborted.';
      } else {
        message = 'Uncaught Error.\n' + xhr.responseText;
      }
      System.notification('error', message);
      console.log(xhr.responseText);
    }
  });
}

System.initTemplate = function () {
  $('.z-template').each(function (index, el) {
    var $template = $(el);
    var id = $template.attr('id');
    if (id) {
      System.template[id] = $template.html();
      $template.remove();
    }
  });
}
System.compileTemplate = function (templateID, data) {
  if (typeof (System.template[templateID]) == 'undefined') {
    var $template = $('#' + templateID);
    if ($template.length > 0) {
      System.template[templateID] = $template.html();
      $template.remove();
    } else {
      console.error('Undefined Template ID: ' + templateID);
      return null;
    }
  }
  var html = System.template[templateID];
  for (var key in data) {
    if (typeof (data[key]) != 'undefined') {
      var re = new RegExp('{{' + key + '}}', 'g');
      html = html.replace(re, data[key]);
    }
  }
  return html;
}
System.helper.imgUrl = function (url) {
  return 'style="background-image: url(\'' + url + '\')"';
}
System.helper.imgSrc = function (url) {
  return 'src="' + url + '"';
}
System.helper.videoYoutube = function (code) {
  return 'src="https://www.youtube.com/embed/' + code + '"';
}
System.helper.td = function (html, customClass) {
  customClass = (typeof (customClass) != 'undefined') ? customClass : '';
  return '<td class="' + customClass + '">' + html + '</td>';
}
System.helper.tr = function (html, customClass) {
  customClass = (typeof (customClass) != 'undefined') ? customClass : '';
  return '<tr class="' + customClass + '">' + html + '</tr>';
}
System.helper.short_text = function (text, length) {
  length = (typeof (length) != 'undefined') ? length : 200;
  var raw_text = $(text).text();
  if (raw_text.length > length) {
    return raw_text.substring(0, length) + '...';
  } else {
    return raw_text;
  }
}

System.helper.DataTable.lengthMenu = [
  [10, 25, 50, 100, -1],
  [10, 25, 50, 100, 'ทั้งหมด']
];
System.helper.DataTable.language = {
  'decimal': '',
  'emptyTable': 'ไม่พบข้อมูล',
  'info': 'แสดงข้อมูลแถวที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ แถว',
  'infoEmpty': 'ไม่พบข้อมูล',
  'infoFiltered': '(ค้นหาจากข้อมูลทั้งหมด _MAX_ แถว)',
  'infoPostFix': '',
  'thousands': ',',
  'lengthMenu': 'แสดง _MENU_ แถว',
  'loadingRecords': 'กำลังโหลด...',
  'processing': '<i class="fa fa-spinner fa-pulse"></i> กำลังประมวลผล...',
  'search': 'ค้นหา',
  'zeroRecords': 'ไม่พบข้อมูลที่ค้นหา',
  'paginate': {
    'first': '<i class="fa fa-step-backward"></i>',
    'last': '<i class="fa fa-step-forward"></i>',
    'previous': '<i class="fa fa-chevron-left"></i>',
    'next': '<i class="fa fa-chevron-right"></i>'
  },
  'aria': {
    'sortAscending': ': จัดเรียงจากน้อยไปมาก',
    'sortDescending': ': จัดเรียงจากมากไปน้อย'
  }
}

System.handleAnimation = function () {
  $(window).on('scroll', function () {
    $('.viewpoint-animate').each(function (index, el) {
      var $this = $(el);
      var rect = $this[0].getClientRects();
      var currTop = rect[0].top;
      var winHeight = window.innerHeight;
      var animationName = $this.data('animation');
      if (currTop < (winHeight * 0.95)) {
        $this.addClass(animationName + ' animated');
        $this.removeClass('viewpoint-animate');
      }
    });;
  });

  // $('.aniview').AniView({
  //   'animateThreshold': 50,
  //   'scrollPollInterval': 10
  // });
  $(window).scroll();
}

System.handleScrollTop = function () {
  // Back To Top
  var offset = 450;
  var duration = 500;
  var upToTop = $('.btn-to-top');

  if (upToTop) {
    $(window).on('scroll', function () {
      if (upToTop) {
        if ($(this).scrollTop() > offset) {
          upToTop.fadeIn(duration);
        } else {
          upToTop.fadeOut(duration);
        }
      }
    });

    upToTop.on('click', function (event) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: 0
      }, duration);
      return false;
    });
  }
}

System.handleEqualHeight = function (scope) {
  var setEqualHeight = debounce(function () {
    $(scope).each(function (idx, ele) {
      var $elements = $(ele).find('.eq-height');
      $elements.css('min-height', 'auto');
      var max_height = 0;

      for (var i = 0; i < $elements.length; i++) {
        var curr_height = $($elements[i]).outerHeight();
        if (i == 0) {
          max_height = curr_height;
        } else if (curr_height > max_height) {
          max_height = curr_height;
        }
      }
      $elements.css('min-height', max_height + 'px');
    });
  }, 250);

  setTimeout(function () {
    setEqualHeight();
    window.addEventListener('resize', setEqualHeight);
  });
}

// require smoothscroll.js
System.smoothScroll = function () {
  /* Scroll Like Mac*/
  SmoothScroll({
    keyboardSupport: false,
    animationTime: 300, // [ms]
    stepSize: 50 // [px]
  });
}

System.handleLanguage = function () {
  var lang = Cookies.get('language');
  if (typeof (lang) != 'undefined') {
    System.switchLanguage(lang);
  } else {
    $('.lang-switch[data-default-lang="true"]').addClass('active');
  }

  $(document).on('click', '.lang-switch', function (e) {
    e.preventDefault();
    var lang = $(this).data('lang');
    if (typeof (lang) != 'undefined') {
      System.switchLanguage(lang);
    }
  });
}
System.switchLanguage = function (lang) {
  Cookies.set('language', lang);
  $('.lang-switch').removeClass('active');
  $('.lang-switch[data-lang="' + lang + '"]').addClass('active');
  $('.multi-language').each(function (index, el) {
    var $this = $(el);
    var text = $this.data('lang-' + lang);
    if (typeof (text) != 'undefined') {
      $this.html(text);
    }
  });
}
System.refreshLanguage = function () {
  var lang = Cookies.get('language');
  if (typeof (lang) != 'undefined') {
    System.switchLanguage(lang);
  }
}

System.helper.submitFlag = function () {
  var rd = Math.floor((Math.random() * 10000) + 1);
  return {
    'html': '<input name="flag" type="text" class="form-control" id="flag_' + rd + '" required="required" style="display:none;">',
    'id': '#flag_' + rd
  }
}
// require toastr.js
System.notification = function (type, message, options) {
  if (System.settings.toastr_module) {
    var progressbar = true;
    var position = 'toast-bottom-right';
    var timeout = 3;
    var exTimeout = 1;
    if (typeof (options) !== 'undefined') {
      progressbar = (typeof (options.progressbar) === 'undefined') ? progressbar : options.progressbar;
      position = (typeof (options.position) === 'undefined') ? position : options.position;
      timeout = (typeof (options.timeout) === 'undefined') ? timeout : options.timeout;
      exTimeout = (typeof (options.exTimeout) === 'undefined') ? exTimeout : options.exTimeout;
    }
    toastr.options.progressBar = progressbar;
    toastr.options.positionClass = position;
    toastr.options.timeOut = parseInt(timeout, 10) * 1000;
    toastr.options.extendedTimeOut = parseInt(exTimeout, 10) * 1000;
    if (type === 'info') {
      toastr.info(message);
    } else if (type === 'success') {
      toastr.success(message);
    } else if (type === 'warning') {
      toastr.warning(message);
    } else if (type === 'error') {
      toastr.error(message);
    }
  } else {
    alert(message);
  }
}
System.confirm = function (title, text, onOK, onCancel) {
  swal({
    title: title,
    text: text,
    type: 'question',
    showCancelButton: true,
    confirmButtonText: '<i class="fa fa-check"></i> ตกลง',
    cancelButtonText: '<i class="fa fa-times"></i> ยกเลิก',
    confirmButtonClass: 'btn btn-primary mr-2',
    cancelButtonClass: 'btn btn-link',
    buttonsStyling: false
  }).then(function () {
    if (typeof (onOK) === 'function') onOK();
  }, function (dismiss) {
    if (typeof (onCancel) === 'function') onCancel(dismiss);
  });
}

System.alert = function (title, text, onOK) {
  swal({
    title: title,
    text: text,
    type: 'warning',
    confirmButtonText: '<i class="fa fa-check"></i> ตกลง',
    confirmButtonClass: 'btn btn-primary',
    buttonsStyling: false
  }).then(function () {
    if (typeof (onOK) === 'function') onOK();
  }, function (dismiss) {
    if (typeof (onCancel) === 'function') onCancel(dismiss);
  });
}

System.readImage = function (fileInput, onSuccess) {
  if (!fileInput.files || !fileInput.files[0]) return false;
  var imgPath = $(fileInput)[0].value;
  var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

  if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
    if (typeof (FileReader) != "undefined") {
      var reader = new FileReader();
      reader.onload = function (e) {
        // get loaded data and render thumbnail.
        if (typeof (onSuccess) === 'function') onSuccess(e);
      };
      // read the image file as a data URL.
      reader.readAsDataURL(fileInput.files[0]);
      return 'success';
    } else {
      return 'not support';
    }
  } else {
    return 'invalid type';
  }
}

System.initTooltip = function () {
  $('[data-toggle="tooltip"], .toggle-tooltip').tooltip({
    'container': 'body'
  });
}

System.detectIE = function () {
  /**
   * detect IE
   * returns version of IE or false, if browser is not Internet Explorer
   */
  var ua = window.navigator.userAgent;

  // Test values; Uncomment to check result …

  // IE 10
  // ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';

  // IE 11
  // ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';

  // Edge 12 (Spartan)
  // ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';

  // Edge 13
  // ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';

  var msie = ua.indexOf('MSIE ');
  if (msie > 0) {
    // IE 10 or older => return version number
    return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
  }

  var trident = ua.indexOf('Trident/');
  if (trident > 0) {
    // IE 11 => return version number
    var rv = ua.indexOf('rv:');
    return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
  }

  var edge = ua.indexOf('Edge/');
  if (edge > 0) {
    // Edge (IE 12+) => return version number
    return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
  }

  // other browser
  return false;
}

System.handleIE = function () {
  // Get IE or Edge browser version
  var version = System.detectIE();
  if (version === false) {
    // other browser
  } else if (version >= 12) {
    // ms edge
  } else {
    // ie 11 below
    System.alert('ตรวจพบบราวเซอร์รุ่นเก่า', 'กรุณาใช้บราวเซอร์รุ่นใหม่เพื่อประสิทธิภาพการใช้งานที่ดีกว่า');
  }
}

System.handleFocusModalInput = function () {
  $(document).on('click', '.toggle-modal', function (e) {
    e.preventDefault();
    var $this = $(this);
    $($this.data('target')).modal().on('shown.bs.modal', function () {
      $($this.data('target')).find('[autofocus]').focus();
    });
  });
}

System.handleConfirm = function () {
  $(document).on('click', '.toggle-confirm, [data-toggle="confirm"]', function (e) {
    e.preventDefault();
    var $this = $(this);
    System.confirm($this.data('message'), '', function () {
      $this.parents('form').submit();
    }, function () { });
  });
}

System.handleAlert = function () {
  $(document).on('click', '.toggle-alert, [data-toggle="alert"]', function (e) {
    e.preventDefault();
    var $this = $(this);
    System.alert('', $this.data('message'));
  });
}

System.initDatatable = function () {
  // init datatable & plugins
  System.global.datatables = {};
  $('.w-data-table').each(function (idx, ele) {
    var $this = $(this);
    var id = $this.attr('id');
    var $datatable = $this.DataTable({
      'language': System.helper.DataTable.language,
      'lengthMenu': System.helper.DataTable.lengthMenu,
      'columnDefs': [{
        'targets': 'no-sort',
        'orderable': false
      }],
      'bDestroy': true
    });
    if (typeof (id) != 'undefined') {
      System.global.datatables[id] = $datatable;
    }
    if ($this.hasClass('no-search')) {
      var $parent = $this.parent('.dataTables_wrapper');
      var $filter = $parent.find('.dataTables_filter');
      $filter.remove();
    }
  });

  // init datatable search
  $('.w-data-table-search').each(function (idx, ele) {
    var $this = $(this);
    var table_id = $this.attr('for');
    if (typeof (table_id) != 'undefined') {
      var $datatable = System.global.datatables[table_id];
      // binding event

      $this.on('keyup', function (e) {
        $datatable.search($this.val()).draw();
      });
    }
  });
}

System.initFormInput = function () {
  // disable input number on mouse wheel
  $('input[type=number]').on('mousewheel', function (e) { $(this).blur(); });

  // select all string in textbox on focus
  $(document).on('click', '.select-focus', function (e) {
    var $this = $(this);
    $this.select();
  });

  // autofill required input
  $('input[required]').each(function (idx, ele) {
    if (ele.type == 'number') {
      $(ele).change(function (e) {
        if (this.value == '') {
          this.value = 0;
        }
      });
    }
    else if (ele.type == 'text') {
      $(ele).change(function (e) {
        this.value = $.trim(this.value);
      });
    }
  });

  $('textarea[required]').each(function (idx, ele) {
    $(ele).change(function (e) {
      this.value = $.trim(this.value);
    });
  });

  $('.dropdown-link').each(function (idx, ele) {
    $(ele).change(function (e) {
      window.location.href = this.value;
    });
  });

  $('[data-toggle="select2"]').select2();
}

System.initZyserMVC = function () {
  $('[data-toggle="model"]').each(function (idx, ele) {
    var $model = $(ele);
    var model_name = $model.attr('name');
    $('[data-model="' + model_name + '"]').each(function (v_idx, v_ele) {
      var $view = $(v_ele);

      var controller_name = $view.data('controller');
      $model.on('change', function (e) {
        var html = $model.val();
        var use_val = $view.data('val');
        if (typeof (use_val) != 'undefined' && use_val == false) {
          html = $model[0];
        }
        if (typeof (controller_name) != 'undefined' && typeof (System.controller[controller_name]) != 'undefined') {
          System.controller[controller_name]($view, html);
        } else {
          System.view($view).update(html);
        }
      });
      $model.trigger('change');
    });
  });
}

System.model = function (model_name) {
  var $model = $('[data-toggle="model"][name="' + model_name + '"]');
  $model.update = function (value) {
    $model.val(value);
    $model.trigger('change');
  }
  return $model;
}

System.view = function ($view) {
  var tag_name = $view[0].tagName;
  $view.update = function (value) {
    var target_attr = $view.data('attr');
    if (typeof (target_attr) != 'undefined') {
      $view.prop(target_attr, value);
    } else {
      if (tag_name == 'INPUT') {
        $view.val(value);
      } else {
        $view.html(value);
      }
    }
  }
  return $view;
}

System.handleLogout = function () {
  $(document).on('click', 'a[href="logout.php"], .btn-logout', function (e) {
    e.preventDefault();
    var link = this.href;
    var onOK = function () {
      window.location.href = link;
    }
    var onCalcel = function () { }

    System.confirm('คุณต้องการออกจากระบบ?', '', onOK, onCalcel);
  });
}

System.helper.typeaheadMatcher = function (strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;
    // an array that will be populated with substring matches
    matches = [];
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function (i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });

    cb(matches);
  };
}
System.helper.zeroFill = function (width, number, pad) {
  if (pad === undefined) pad = '0';
  width -= number.toString().length;
  if (width > 0) return new Array(width + (/\./.test(number) ? 2 : 1)).join(pad) + number;
  return number + '';
}

System.toggleNavbar = function () {
  if ($(window).width() < 992) {
    $('.nav-link.dropdown-toggle').attr('data-toggle', 'dropdown');
  }
}

// run
$(document).ready(function () {
  System.setupAjax();
  System.initTemplate();
  //System.handleLanguage();
  System.toggleNavbar();
  System.handleScrollTop();
  System.smoothScroll();
  System.handleAnimation();
  // System.handleEqualHeight('.has-eq-height');
  System.handleIE();
  System.handleFocusModalInput();
  System.handleConfirm();
  System.handleAlert();
  System.handleLogout();


  $('.debug-control .control-btn').on('click', function (e) {
    var $this = $(this);
    var $container = $this.parents('.debug-control');
    var $content = $container.find('.control-content');
    $this.toggleClass('open');
    $content.toggleClass('open');
  });

  System.initTooltip();
  System.initDatatable();
  System.initFormInput();

  System.initZyserMVC();
});

// Plugin -- Get Data from Query String
(function ($) {
  $.QueryString = (function (paramsArray) {
    let params = {};

    for (let i = 0; i < paramsArray.length; ++i) {
      let param = paramsArray[i]
        .split('=', 2);

      if (param.length !== 2)
        continue;

      params[param[0]] = decodeURIComponent(param[1].replace(/\+/g, " "));
    }

    return params;
  })(window.location.search.substr(1).split('&'))
})(jQuery);

