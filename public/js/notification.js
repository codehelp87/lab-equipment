'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function ($) {
  jQuery.fn.NotifyAll = function () {
    return $(this).each(function () {
      var notify = new Notification();
      notify.createNotification();
      notify.editNotification();
      notify.updateNotification();
      notify.readNotification();
      notify.closeForm();
    });
  };

  var Notification = function () {
    function Notification() {
      _classCallCheck(this, Notification);
    }

    _createClass(Notification, [{
      key: 'readNotification',
      value: function readNotification() {
        var notify = new Notification();
        var readLink = $(document).find('table.notifications').find('a.read-notification');

        readLink.on('click', function () {
          var _this = $(this);
          _this.parents('tr').next().toggle(300);
          return false;
        });
      }
    }, {
      key: 'createNotification',
      value: function createNotification() {
        var notify = new Notification();
        $("form#notification").submit(function (evt) {
          var smtBtn = $("form#notification").find('button#save-notification');
          evt.preventDefault();
          var formData = new FormData($(this)[0]);
          var tableBody = $(document).find('table#list-notification tbody');

          notify.makeAjaxCall('/notifications/add', formData, 'POST').done(function (data) {
            var newNotification = notify.addNewNotificationToHtmlTable(data.notification);
            tableBody.prepend(newNotification);

            notify.clearFormFields();
            toastr.success('Your Notification was saved successfully');

            return false;
          }).fail(function (error) {
            toastr.error(JSON.stringify(error));
          });

          return false;
        });
      }
    }, {
      key: 'editNotification',
      value: function editNotification() {
        var notify = new Notification();
        $(function () {
          $('body').on('click', 'table#list-notification a', function () {
            var _this = $(this);
            var $btn = _this.button('loading');
            var id = _this.attr('id');
            var editMode = $('table#list-notification').find('tr > td div.display' + id);

            notify.makeAjaxRequest('/notifications/' + id, '', 'GET').done(function (data) {
              editMode.slideDown().html(data).css('display', 'block');
              $btn.button('reset');
            }).fail(function (error) {
              toastr.error(JSON.stringify(error));
              $btn.button('reset');
            });

            return false;
          });
        });
      }
    }, {
      key: 'updateNotification',
      value: function updateNotification() {
        var notify = new Notification();
        $('body').on('submit', 'form.edit_notification', function (evt) {
          evt.preventDefault();
          var form = $(document).find('form.edit_notification');
          var id = $(this).attr('id');

          var formData = new FormData(form[0]);

          notify.makeAjaxCall('/notifications/' + id + '/update', formData, 'POST').done(function (res) {
            toastr.success(res.message);
            var newEquipment = notify.addNewNotificationToHtmlTable(res.notification);
            $(document).find('table tr#edit-notification' + id).replaceWith(newEquipment);
            $(document).find('div#edit-notification' + id).slideUp();
            notify.clearFormFields();
            return false;
          }).fail(function (error) {
            toastr.error(JSON.stringify(error));
          });
          return false;
        });
      }
    },{
      key: 'closeForm',
      value: function closeForm() {
        $('body').on('click', 'button.close-notification', function () {
          var notifyId = $(this).attr('id');
          $(document).find('div#edit-notification' + notifyId).slideUp();
          return false;
        });
      }
    },
    {
      key: 'addNewNotificationToHtmlTable',
      value: function addNewNotificationToHtmlTable(data) {
        var date = moment().format('YYYY/MM/DD');
        var tableRow = '<tr>';
        tableRow += '<td class="text-left">' + data.title + '</td>';
        tableRow += '<td>' + date + '</td>';
        tableRow += '<td class="text-right"><a href="/notification/' + data.id + '/edit" class="edit-notification" id="notify' + data.id + '">';
        tableRow += '<i class="glyphicon glyphicon-pencil"></i> Edit</a> </td>';
        tableRow += '</tr>';
        return tableRow;
      }
    }, {
      key: 'clearFormFields',
      value: function clearFormFields() {
        $('form#notification').find('input[type="text"], textarea').each(function (index, el) {
          $(this).val('');
        });
      }
    }, {
      key: 'makeAjaxCall',
      value: function makeAjaxCall(url, params, method) {
        return $.ajax({
          headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
          },
          url: url,
          type: method,
          dataType: 'json',
          data: params,
          async: false,
          cache: false,
          contentType: false,
          enctype: 'multipart/form-data',
          processData: false
        });
      }
    }, {
      key: 'makeAjaxRequest',
      value: function makeAjaxRequest(url, params, method) {
        return $.ajax({
          headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
          },
          url: url,
          type: method,
          dataType: 'html',
          data: params,
          async: false,
          cache: false,
          contentType: false,
          enctype: 'multipart/form-data',
          processData: false
        });
      }
    }]);

    return Notification;
  }();
})(jQuery);

$('body').NotifyAll();