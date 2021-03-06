'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function ($) {
  jQuery.fn.LabEquipmentUsage = function () {
    return $(this).each(function () {
      var lab = new LabUsage();
      lab.getLabUsageByEquipment();
      lab.getLabUsers();
      lab.getLabUsageBySessionAndEquipment();
      lab.getSessionLabUser();
      lab.getLabUsersByNight();
      lab.getSessionLabUserByNight();
    });
  };

  var LabUsage = function () {
    function LabUsage() {
      _classCallCheck(this, LabUsage);
    }

    _createClass(LabUsage, [{
      key: 'getSessionLabUserByNight',
      value: function getSessionLabUserByNight() {
        var lab = new LabUsage();

        $('body').on('click', 'a.view-equipment-users-with-session-bynight', function () {
          var _this = $(this);
          var equipmentId = _this.attr('data-id');
          var labProf = _this.attr('id');
          var session = $(document).find('select#session').val();

          var modal = $(document).find('div#total_lab_usage');
          var modalTitle = modal.find('h4.modal-title');
          var modalBody = modal.find('div.modal-body');

          var route = '/equipments/' + equipmentId + '/labusers/sessions?mode=night';

          lab.makeAjaxCall(route, { session: session, prof: labProf }, 'GET').done(function (data) {
            console.log(data);
            modalTitle.html(data.lab_prof);
            var content = lab.prepareLabUserTable(data[1], data[0].equipment_amount);
            modalBody.html(content);
            modal.modal('show');
          }).fail(function (error) {
            console.log(error);
          });

          return false;
        });
      }
    }, {
      key: 'getSessionLabUser',
      value: function getSessionLabUser() {
        var lab = new LabUsage();

        $('body').on('click', 'a.view-equipment-users-with-session', function () {
          var _this = $(this);
          var equipmentId = _this.attr('data-id');
          var labProf = _this.attr('id');
          var session = $(document).find('select#session').val();

          var modal = $(document).find('div#total_lab_usage');
          var modalTitle = modal.find('h4.modal-title');
          var modalBody = modal.find('div.modal-body');

          var route = '/equipments/' + equipmentId + '/labusers/sessions';

          lab.makeAjaxCall(route, { session: session, prof: labProf }, 'GET').done(function (data) {
            modalTitle.html(data[0].lab_prof);
            var content = lab.prepareLabUserTable(data[1], data[0].equipment_amount);
            modalBody.html(content);
            modal.modal('show');
          }).fail(function (error) {
            console.log(error);
          });

          return false;
        });
      }
    }, {
      key: 'getLabUsageBySessionAndEquipment',
      value: function getLabUsageBySessionAndEquipment() {
        var lab = new LabUsage();
        var session = $(document).find('form#calculate_lab_usage').find('select#session');
        session.on('change', function () {
          var equipment = $(document).find('form#calculate_lab_usage').find('select#equipment').val();
          var _this = $(this);
          var table = $(document).find('table#display_lab_usage tbody');

          if (equipment == '' || equipment == undefined) {
            toastr.error('Please select an equipment');
            return false;
          }
          var session = _this.val();

          if (session != '') {
            var route = '/equipments/' + equipment + '/lab_usage_by_session';
            var params = {
              'session': session
            };

            lab.makeAjaxCall(route, params, 'GET').done(function (data) {
              if (data.total_charge_by_day == 0 && data.total_charge_by_night == 0) {
                return table.html(lab.NoEquipmentLabListing(data));
              }
              table.html(lab.NoEquipmentLabListing(data));
            }).fail(function (error) {
              console.log(error);
            });
          }
        });
      }
    }, {
      key: 'getLabUsers',
      value: function getLabUsers() {
        var lab = new LabUsage();

        $('body').on('click', 'a.view-equipment-users', function () {
          var _this = $(this);
          var equipmentId = _this.attr('data-id');
          var labProf = _this.attr('id');

          var modal = $(document).find('div#total_lab_usage');
          var modalTitle = modal.find('h4.modal-title');
          var modalBody = modal.find('div.modal-body');

          if (labProf == undefined || equipmentId == undefined) {
            modalBody.html('No student bookings available!');
            return modal.modal('show');
          }

          var route = '/equipments/' + equipmentId + '/labusers/' + labProf;

          lab.makeAjaxCall(route, '', 'GET').done(function (data) {
            modalTitle.html(data[0].lab_prof);
            var content = lab.prepareLabUserTable(data[1], data[0].equipment_amount);
            modalBody.html(content);
            modal.modal('show');
          }).fail(function (error) {
            console.log(error);
          });

          return false;
        });
      }
    }, {
      key: 'getLabUsersByNight',
      value: function getLabUsersByNight() {
        var lab = new LabUsage();

        $('body').on('click', 'a.view-equipment-users-by-night', function () {
          var _this = $(this);
          var equipmentId = _this.attr('data-id');
          var labProf = _this.attr('id');

          var modal = $(document).find('div#total_lab_usage');
          var modalTitle = modal.find('h4.modal-title');
          var modalBody = modal.find('div.modal-body');

          if (labProf == undefined || equipmentId == undefined) {
            modalBody.html('No student bookings available!');
            return modal.modal('show');
          }

          var route = '/equipments/' + equipmentId + '/labusers/' + labProf + '?mode=night';

          lab.makeAjaxCall(route, '', 'GET').done(function (data) {
            modalTitle.html(data[0].lab_prof);
            var content = lab.prepareLabUserTable(data[1], data[0].equipment_amount);
            modalBody.html(content);
            modal.modal('show');
          }).fail(function (error) {
            console.log(error);
          });

          return false;
        });
      }
    }, {
      key: 'prepareLabUserTable',
      value: function prepareLabUserTable(data, equipmentAmount) {
        var totalDayBookings = 0;
        var totalNightBookings = 0;
        var table = '<table class="table table-hover" id="lab-equipment-users">';
        table += '<thead><tr><th></th><th>Day time<br>(9am-9pm)</th><th>Night time<br>(9pm-9am)</th></tr></thead>';
        table += '<tbody>';
        for (var booking in data) {
          table += '<tr><td><strong>' + data[booking].name + '</strong></td><td><strong>' + 
         data[booking].total_daytime_booked + '</strong></td><td><strong>' + 
          data[booking].total_nighttime_booked  + '</strong></td></tr>';
          totalDayBookings += parseFloat(data[booking].total_daytime_booked);
          totalNightBookings += parseFloat(data[booking].total_nighttime_booked);
        }
        table += '<tr><td><strong>Total Hours</strong></td><td><strong>' + parseFloat(Math.round(parseFloat(totalDayBookings / 60)* 100) / 100).toFixed(2) +
        '<strong></td> <td><strong>' +  parseFloat(Math.round(parseFloat(totalNightBookings / 60) * 100) / 100).toFixed(2) + '<strong></td></tr>';
        table += '<tr><td><strong>Total Price</strong></td><td><strong>' + parseFloat(totalDayBookings * (equipmentAmount / 10)) + 
        '</strong></td><td><strong>' + parseFloat(totalNightBookings * (equipmentAmount / 10)) + 
        '</strong></td></tr>';

        table += '<tr><td><strong>Total</strong></td><td colspan="2"><strong>' + parseFloat(parseFloat(totalDayBookings * (equipmentAmount / 10)) + parseFloat(totalNightBookings * (equipmentAmount / 10)))
        '</strong></td></tr>';

        table += '</tbody>';
        table += '</table>';

        var downloadLink = '<span class="pull-left"><a href="#" id="download-lab-users" class="download-lab-users">' + '<strong>Download as xlsx</strong></a></span><br><br>';
        return table += downloadLink;
      }
    }, {
      key: 'getLabUsageByEquipment',
      value: function getLabUsageByEquipment() {
        var lab = new LabUsage();
        var selectEquipment = $(document).find('form#calculate_lab_usage').find('#equipment');

        selectEquipment.on('change', function () {
          var _this = $(this);
          var equipmentId = _this.val();
          var table = $(document).find('table#display_lab_usage tbody');
          if (equipmentId != '') {
            var route = '/equipments/' + equipmentId + '/lab_usage';

            lab.makeAjaxCall(route, '', 'GET').done(function (data) {
              table.html(lab.listEquipmentLab(data));
            }).fail(function (error) {
              console.log(error);
            });
          }
          return false;
        });
      }
    }, {
      key: 'listEquipmentLab',
      value: function listEquipmentLab(data) {
        var table = ''
        var total = 0;
        for (var usage in data) {
          var day_lab_prof_id = data[usage].day_lab_prof_id == undefined? 0: data[usage].day_lab_prof_id;
          var day_equipment_id = data[usage].day_equipment_id ==undefined? 0: data[usage].day_equipment_id;
          var day_lab_prof = data[usage].day_lab_prof == undefined? 'Nill': data[usage].day_lab_prof;
          var total_hour_by_day = data[usage].total_hour_by_day == undefined? 0: data[usage].total_hour_by_day;
          total_hour_by_day = parseFloat(Math.round(total_hour_by_day * 100) / 100).toFixed(2);

          var total_charge_by_day = data[usage].total_charge_by_day == undefined? 0: data[usage].total_charge_by_day;

          var night_lab_prof_id = data[usage].night_lab_prof_id == undefined? 0: data[usage].night_lab_prof_id;
          var night_equipment_id = data[usage].night_equipment_id ==undefined? 0: data[usage].night_equipment_id;
          var night_lab_prof = data[usage].night_lab_prof == undefined? 'Nill': data[usage].night_lab_prof;
          var total_hour_by_night = data[usage].total_hour_by_night == undefined? 0: data[usage].total_hour_by_night;
          total_hour_by_night = parseFloat(Math.round(total_hour_by_night * 100) / 100).toFixed(2);

          var total_charge_by_night = data[usage].total_charge_by_night == undefined? 0: data[usage].total_charge_by_night;

          total += parseInt(total_charge_by_day + total_charge_by_night);

          table += '<tr>' + '<td><a href="#" class="view-equipment-users" data-id=' +
            day_equipment_id + ' id=' + day_lab_prof_id + '>' + decodeURI(day_lab_prof) + '</a></td>' +
            '<td>' + total_hour_by_day + '</td>' + '<td>' + total_charge_by_day + '</td><td></td>' + 
            '<td>' +
            total_hour_by_night + '</td>' + '<td>' + total_charge_by_night + '</td>' + 
            '</tr>';

           //  '<td><a href="#" class="view-equipment-users-by-night" data-id=' + night_equipment_id +
           // ' id=' + night_lab_prof_id + '>' + decodeURI(night_lab_prof) + '</a</td>' +
        }

        table += '<tr>' + '<td colspan="5" align="right"><strong>Total</strong></td>' + 
            '<td><strong>' + parseFloat(total) + 
            '</strong></td>' + '</tr>';
        
        return table;
      }
    }, {
      key: 'NoEquipmentLabListing',
      value: function NoEquipmentLabListing(data) {
        var table = ''
        var total = 0;
        for (var usage in data) {
          var day_lab_prof_id = data[usage].day_lab_prof_id == undefined? 0: data[usage].day_lab_prof_id;
          var day_equipment_id = data[usage].day_equipment_id == undefined? 0: data[usage].day_equipment_id;
          var day_lab_prof = data[usage].day_lab_prof == undefined? 'Nill': data[usage].day_lab_prof;
          var total_hour_by_day = data[usage].total_hour_by_day == undefined? 0: data[usage].total_hour_by_day;
          total_hour_by_day = parseFloat(Math.round(total_hour_by_day * 100) / 100).toFixed(2);
          var total_charge_by_day = data[usage].total_charge_by_day == undefined? 0: data[usage].total_charge_by_day;

          var night_lab_prof_id = data[usage].night_lab_prof_id == undefined? 0: data[usage].night_lab_prof_id;
          var night_equipment_id = data[usage].night_equipment_id == undefined? 0: data[usage].night_equipment_id;
          var night_lab_prof = data[usage].night_lab_prof == undefined? 'Nill': data[usage].night_lab_prof;
          var total_hour_by_night = data[usage].total_hour_by_night == undefined? 0: data[usage].total_hour_by_night;
          total_hour_by_night = parseFloat(Math.round(total_hour_by_night * 100) / 100).toFixed(2);

          var total_charge_by_night = data[usage].total_charge_by_night == undefined? 0: data[usage].total_charge_by_night;

          total += parseInt(total_charge_by_day + total_charge_by_night);

          table += '<tr>' + '<td><a href="#" class="view-equipment-users-with-session" data-id=' +
         day_equipment_id + ' id=' + day_lab_prof_id + '>' + decodeURI(day_lab_prof) + '</a></td>' +
          '<td>' + total_hour_by_day + '</td>' + '<td>' + total_charge_by_day + '</td><td></td>' + 
          '<td>' +
            total_hour_by_night + '</td>' + '<td>' + total_charge_by_night + '</td>' + 
            '</tr>';
           //  '<td><a href="#" class="view-equipment-users-with-session-bynight" data-id=' + night_equipment_id +
           // ' id=' + night_lab_prof_id + '>' + decodeURI(night_lab_prof) + '</a</td>' + 
        }

        table += '<tr>' + '<td colspan="5" align="right"><strong>Total</strong></td>' + 
            '<td><strong>' + parseFloat(total) + 
            '</strong></td>' + '</tr>';
        
        return table;
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

    return LabUsage;
  }();
})(jQuery);

$('body').LabEquipmentUsage();