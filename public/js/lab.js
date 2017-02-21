'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function ($) {
  jQuery.fn.UpdateEquipmentLab = function () {
    return $(this).each(function () {
      var lab = new Lab();
      lab.createLab();
      lab.assignUserToLab();
      //lab.getLabEquipment();
      lab.contactAdmin();
    });
  };

  var Lab = function () {
    function Lab() {
      _classCallCheck(this, Lab);
    }

    _createClass(Lab, [{
      key: 'contactAdmin',
      value: function contactAdmin() {
        var link = $(document).find('a.open-modal');
        link.on('click', function () {
          var modalDialog = $(document).find('div.contact-admin');
          modalDialog.modal('show');
          return false;
        });
      }
    }, {
      key: 'getLabEquipment',
      value: function getLabEquipment() {
        var lab = new Lab();
        var selectLab = $(document).find('form#training_request').find('select#lab');
        var equipments = $(document).find('form#training_request').find('select#equipment');

        selectLab.on('change', function () {
          var _this = $(this);
          var labId = _this.val();

          var route = '/labs/' + labId + '/equipments';

          var modalDialog = $(document).find('div.contact-admin');

          if (_this.val() != '') lab.makeAjaxCall(route, '', 'GET').done(function (data) {
            var labEquipments = data[1];

            if (labEquipments.length > 0 && labEquipments[0].availability != undefined) {
              var options = '';
              // Get the lab professor details and add it to the modal form
              var modal = modalDialog.find('div.modal-body'); //.html(lab.adminInfo(data[0]));
              var content = lab.adminInfo(data[0]);
              modal.html(content);

              for (var equipment in labEquipments) {
                options += '<option value=' + labEquipments[equipment].id + '>' + labEquipments[equipment].model_no + '</option>';
              }
              equipments.html(options);

              return toastr.success('Lab Equipments has been added');
            }

            return toastr.error('Lab Equipments not available');
          }).fail(function (error) {
            console.log(error);
          });
          return false;
        });
      }
    }, {
      key: 'adminInfo',
      value: function adminInfo(profDetails) {
        var content = '<span class="text-center"><strong>Please contact the admin via email</strong></span> <br><br>' + '<address> ' + '<strong>Name:</strong> ' + decodeURI(profDetails.name) + ' <br> ' + '<strong>Email:</strong> ' + decodeURI(profDetails.email) + '</address> ';

        return content;
      }
    }, {
      key: 'assignUserToLab',
      value: function assignUserToLab() {
        var lab = new Lab();
        var saveBtn = $('#save-lab-user');
        saveBtn.on('click', function () {
          var $btn = $(this).button('loading');
          var user = $('form#assign_user_to_lab').find('#user').val();
          var labId = $('form#assign_user_to_lab').find('#lab').val();

          if (user == '') {
            toastr.error('Choose a user to assign to lab!');
            return false;
          }

          if (labId == '') {
            toastr.error('Choose lab!');
            return false;
          }
          // make a put request to the server side
          var params = { 'user': user };

          lab.makeAjaxCall('/labs/' + labId + '/add', params, 'PUT').done(function (data) {
            // business logic...
            $btn.button('reset');
            if (data.message == 200) {
              toastr.success('User was assigned to Lab successfully');
              return false;
            }
            toastr.error(data.message);
            return false;
          }).fail(function (error) {
            // business logic...
            $btn.button('reset');
            toastr.error(error.toString());
          });
          return false;
        });
      }
    }, {
      key: 'createLab',
      value: function createLab() {
        var lab = new Lab();
        var saveBtn = $('#save-lab');
        saveBtn.on('click', function () {
          var title = $('form#manage_lab').find('#title').val();

          if (lab.checkforEmptyFields().length > 0) {
            toastr.error('Filled the fields in red!');
            return false;
          }
          // make a put request to the server side
          var params = {
            'title': title,
            //'model_no': modelNo
          };

          lab.makeAjaxCall('/labs/add', params, 'POST').done(function (data) {
            console.log(data);
            var newLab = lab.appendNewLab(data.lab);
            $('table#list-labs').append(newLab);

            toastr.success(data.message);
            lab.checkforEmptyFields();
            lab.clearFormFields();
            return false;
          }).fail(function (error) {
            toastr.error(error.toString());
          });
          return false;
        });
      }
    },
    {
      key: 'appendNewLab',
      value: function appendNewLab(data) {
        var tableRow = '<tr id="edit-lab' + data.id + '">';
        tableRow += '<td>' + data.title + '</td>';
        tableRow += '<td><a href="#" class="edit-lab" id=' + data.id + ' title=' + data.title + '>Edit</a></td>' + 
        '<td><a href="#"  class="delete-lab" id=' + data.id + ' rel="/labs/' + data.id + '/delete">Delete</a></td>' +
        '</tr>';
        return tableRow;
      }
    },
     {
      key: 'checkforEmptyFields',
      value: function checkforEmptyFields() {
        var error = [];
        $('form#manage_lab').find('input').each(function (index, el) {
          var _this = $(this);
          if (_this.val() == '') {
            error.push(_this.attr('id'));
            _this.css('border', '1px solid red');
          } else {
            _this.css('border', '1px solid #ccc');
          }
        });
        return error;
      }
    }, {
      key: 'clearFormFields',
      value: function clearFormFields() {
        $('form#manage_lab').find('input[type="text"]').each(function (index, el) {
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
          data: params
        });
      }
    }]);

    return Lab;
  }();
})(jQuery);

$('body').UpdateEquipmentLab();