'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function ($) {
  jQuery.fn.UpdateEquipment = function () {
    return $(this).each(function () {
      var equipment = new Equipment();
      equipment.createEquipment();
      equipment.editEquipment();
      equipment.updateEquipment();
      equipment.deleteEquipment();
    });
  };

  var Equipment = function () {
    function Equipment() {
      _classCallCheck(this, Equipment);
    }

    _createClass(Equipment, [{
      key: 'deleteEquipment',
      value: function deleteEquipment() {
        var equipment = new Equipment();
        $('body').on('click', 'a.delete-equipment', function () {
          var _this = $(this);

          var $btn = _this.button('loading');
          var equipmentId = _this.attr('id');
          var route = _this.attr('rel');
          bootbox.confirm('Are you sure to delete?', function (result) {
            if (result) {
              equipment.makeAjaxCall(route, {}, 'DELETE').done(function (data) {
                if (data.message == 'deleted') {
                  $btn.button('reset');
                  _this.parents('#edit-eqipment' + equipmentId).remove();
                  return toastr.success('Equipment has been successfully deleted ');
                }
                return toastr.error(data.message);
              }).fail(function (error) {
                console.log(error);
              });
            }
            return $btn.button('reset');
          });
        });
      }
    }, {
      key: 'createEquipment',
      value: function createEquipment() {
        var equipment = new Equipment();
        $("form#add_more_equipment").submit(function (evt) {
          // Change button text to loading
          var smtBtn = $("form#add_more_equipment").find('button#save-equipment');
          evt.preventDefault();
          var formData = new FormData($(this)[0]);
          var assignedLab = $('form#add_more_equipment').find('#assign_lab').val(); //assign_lab;
          var availability = $('form#add_more_equipment').find('#availability').val(); //availability

          if (assignedLab == '') {
            toastr.error('Assign a lab!');
            return false;
          }
          if (availability == '') {
            toastr.error('Select equipment availability!');
            return false;
          }

          equipment.makeAjaxCall('/equipments/add', formData, 'POST').done(function (data) {
            toastr.success(data.message);
            var newEquipment = equipment.addNewEquipmentToHtmlTable(data.equipment);
            $('table#list-equipment').append(newEquipment);
            equipment.clearFormFields();
            smtBtn.text('Save');
            return false;
          }).fail(function (error) {
            toastr.error(JSON.stringify(error));
          });

          return false;
        });
      }
    }, {
      key: 'updateEquipment',
      value: function updateEquipment() {
        var equipment = new Equipment();
        $('body').on('submit', 'form.edit_equipment', function (evt) {
          evt.preventDefault();
          var form = $(document).find('form.edit_equipment');
          var id = $(this).attr('id');

          var formData = new FormData(form[0]);

          var assignedLab = $('form.edit_equipment').find('#assign_lab').val(); //assign_lab;
          var availability = $('form.edit_equipment').find('#availability').val(); //availability

          equipment.makeAjaxCall('/equipments/' + id + '/update', formData, 'POST').done(function (res) {
            toastr.success(res.message);
            var newEquipment = equipment.addNewEquipmentToHtmlTable(res.equipment);
            $(document).find('table tr#edit-eqipment' + id).replaceWith(newEquipment);
            $(document).find('div#edit-eqipment' + id).slideUp();
            equipment.clearFormFields();
            return false;
          }).fail(function (error) {
            toastr.error(JSON.stringify(error));
          });
          return false;
        });
      }
    }, {
      key: 'editEquipment',
      value: function editEquipment() {
        var equipment = new Equipment();
        $(function () {
          $('body').on('click', 'table#list-equipment a.edit-eqipment', function () {
            var _this = $(this);
            var $btn = _this.button('loading');;
            var id = _this.attr('id');
            var editMode = $('table#list-equipment').find('tr > td div.display' + id);

            equipment.makeAjaxRequest('/equipments/' + id, '', 'GET').done(function (data) {
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
      key: 'addNewEquipmentToHtmlTable',
      value: function addNewEquipmentToHtmlTable(data) {
        var status = data.availability == 1 ? 'Available' : 'Unavailable';
        var tableRow = '<tr id="edit-eqipment' + data.id + '">';
        tableRow += '<td>' + data.model_no + '</td>';
        tableRow += '<td><img src=' + data.equipment_photo + ' style="width: 50px; height: 50px;"></td>';
        tableRow += '<td>';
        tableRow += '<strong>Status</strong><br>' + '<strong>Unit Time</strong><br>' + '<strong>Max Time(per day)</strong><br>' + '</td>';
        tableRow += '<td>' + status + '<br>' + data.time_unit + ' mins <br>' + data.max_reservation_time + ' hours<br></td>';
        tableRow += '<td>' + '<strong>Open</strong><br>' + '<strong>Cancel</strong><br>' + '</td>' + '<td>' + '<span>30 minutes before</span><br>' + '<span>1 hour before</span><br>' + '</td>' + '<td><a href="#" class="edit-eqipment" id=' + data.id + ' title=' + data.title + '>Edit</a></td>' + '<td><a href="#"  class="delete-equipment" id=' + data.id + ' rel="/equipments/' + data.id + '/delete">Delete</a></td>' + '</tr>';
        return tableRow;
      }
    }, {
      key: 'checkforEmptyFields',
      value: function checkforEmptyFields() {
        var error = [];
        $('form#add_more_equipment, form.edit_equipment').find('input').each(function (index, el) {
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
        $('form#add_more_equipment, form.edit_equipment').find('input[type="text"]').each(function (index, el) {
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

    return Equipment;
  }();
})(jQuery);

$('body').UpdateEquipment();