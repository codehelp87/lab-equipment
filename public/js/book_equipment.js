'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function ($) {
  jQuery.fn.BookEquipment = function () {
    return $(this).each(function () {
      var equipment = new Equipment();
      equipment.linkToBookingDetails();
      equipment.bookEquipment();
      equipment.cancelBooking();
      equipment.releaseEquipmentFromBooking();
    });
  };

  var Equipment = function () {
    function Equipment() {
      _classCallCheck(this, Equipment);
    }

    _createClass(Equipment, [{
      key: 'releaseEquipmentFromBooking',
      value: function releaseEquipmentFromBooking() {
        var equipment = new Equipment();
        var minutes = 2;
        var interval = 1000 * 60 * minutes; // where X is your every X minutes
        var route = '/equipment/booking/checking';

        $.fn.keepAlive({ url: route, timer: interval }, function (response) {
          console.log(response);
        }); //
      }
    }, {
      key: 'cancelBooking',
      value: function cancelBooking() {
        var equipment = new Equipment();
        var cancelBtn = $(document).find('button.cancel-booking');

        cancelBtn.on('click', function () {
          var _this = $(this);
          var modal = $(document).find('div.cancel_booking');
          var selectedTimeSlot = _this.attr('data-time-slot');
          var bookingDate = moment().format('MM.DD.YYYY');
          var bookingId = _this.attr('id');

          var modalContent = equipment.prepareModalForBookingCancel(bookingDate, selectedTimeSlot);
          modal.find('div.modal-body').html(modalContent);
          modal.modal('show');

          var okBtn = modal.find('button.ok');
          var route = '/bookings/' + bookingId + '/cancel';

          okBtn.on('click', function () {
            var otherCancelBtn = $('body').find('button#' + bookingId);

            equipment.makeAjaxCall(route, '', 'GET').done(function (data) {
              if (data.id != undefined) {
                modal.modal('hide');

                toastr.success('Your booking has been cancelled');

                otherCancelBtn.addClass('cancelled');
                otherCancelBtn.attr('disabled', true);
                otherCancelBtn.text('Cancelled');

                _this.addClass('cancelled');
                _this.attr('disabled', true);
                _this.text('Cancelled');
                okBtn.unbind('click');
                cancelBtn.unbind('click');
                return window.location.href = '/home/profile';
              }
              return toastr.success(data.message);
            }).fail(function (error) {
              console.log(error);
            });

            return false;
          });

          return false;
        });
      }
    }, {
      key: 'bookEquipment',
      value: function bookEquipment() {
        var MAX_BOOKING_AHEAD = 30;
        var bookBtn = $(document).find('button#book-now');
        var modal = $(document).find('div.booking-detail');
        var okBtn = modal.find('button.ok');
        var params = null;
        var equipment = new Equipment();
        var route = '/equipments/booking';
        var equipmentId = null;

        okBtn.on('click', function () {            
          equipment.makeAjaxCall(route, params, 'POST').done(function (data) {
            if (data[0].id != undefined) {
              modal.modal('hide');
              toastr.success('Your booking has been recorded');
              return window.location.href = '/equipments/' + equipment.base64Encode().encode(equipmentId) + '/booking';
            }
            return toastr.success(data.message);
          }).fail(function (error) {
            console.log(error);
          });

          return false;
        });

        bookBtn.on('click', function () {
          var selectedTimeSlot = [];
          var selectedTimeSlotId = [];
          var selectedDate = [];
          var request = [];

          equipmentId = $(this).attr('data-id');
          var checkBox = $(document).find('div.checkbox').find('input[type="checkbox"]:checked').not('input[type="checkbox"]:disabled');
          var time = $(document).find('span#time').text();

          if (time == '') {
            toastr.error('Pls select date');
            return false;
          }

          if (checkBox.size() <= 0) {
            toastr.error('Pls select a time slot');
            return false;
          }

          checkBox.each(function (index, el) {
            var _this = $(this);
            selectedTimeSlot.push(_this.val());
            selectedDate.push(_this.attr('date-time'));
            selectedTimeSlotId.push(_this.attr('id'));
          });

          var date = new Date();
          var myDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes(), date.getSeconds());

          var dateNow = moment(myDate).format('YYYY-MM-DD HH:mm');

          for (var i = 0; i < selectedDate.length; i++) {
            var currentDate = moment(dateNow);
            var dateSelected = moment(selectedDate[i]);
            var dateBehindCheck = dateSelected.diff(currentDate, 'minutes');

            if (dateBehindCheck < MAX_BOOKING_AHEAD) {
              toastr.error('Time selected: ' + selectedDate[i] + ' must be 30 minutes ahead');
              return false;
            }
          }

          var modalContent = equipment.prepareModal(selectedDate, selectedTimeSlot);
          modal.find('div.modal-body').html(modalContent);
          modal.modal('show');

          params = {
            'equipment': equipmentId,
            'time_slot': selectedTimeSlot,
            'booking_date': time,
            'time_slot_id': selectedTimeSlotId,
            'selected_date': selectedDate
          };

          return false;
        });
      }
    }, {
      key: 'prepareModalForBookingCancel',
      value: function prepareModalForBookingCancel(bookingDate, selectedTimeSlot) {
        var stuff = '<h5 class="text-center">Are you sure you want to cancel this reservation</h5>';
        var dateSelected = '<h5 class="text-center">' + bookingDate + '</h5>';
        var info = '<h5 class="text-center">If it\'s correct press Cancel Now</h5><br>';
        var timeSlot = selectedTimeSlot.split(',');

        var slots = '<ul style="padding:0; list-style: none;">';
        for (var i = 0; i < timeSlot.length; i++) {
          slots += '<li class="text-center"><h4>' + timeSlot[i].trim() + '</h4></li>';
        }
        slots += '</ul>';

        stuff += dateSelected;
        stuff += slots;
        stuff += info;

        return stuff;
      }
    }, {
      key: 'prepareModal',
      value: function prepareModal(bookingDate, selectedTimeSlot) {
        var stuff = '<h5 class="text-center">You will book</h5>';
        var dateSelected = '<h5 class="text-center">' + moment(bookingDate[bookingDate.length - 1]).format('MM.DD.YYYY ddd') + '</h5>';
        var info = '<h5 class="text-center">If it\'s correct press ok</h5>';
        var slots = '<ul style="padding:0; list-style: none;">';
        for (var i = 0; i < selectedTimeSlot.length; i++) {
          slots += '<li class="text-center"><h4>' + selectedTimeSlot[i] + '</h4></li>';
        }
        slots += '</ul>';

        stuff += dateSelected;
        stuff += slots;
        stuff += info;

        return stuff;
      }
    }, {
      key: 'linkToBookingDetails',
      value: function linkToBookingDetails() {
        var linkBtn = $(document).find('button#book-equipment');
        linkBtn.on('click', function () {
          var bookItem = $(document).find('select#book_equipment').val();

          if (bookItem != '') {
            window.location.href = '/equipments/' + bookItem + '/booking';
          }
          return false;
        });
      }
    }, {
      key: 'base64Encode',
      value: function base64Encode() {
        // Create Base64 Object
        var Base64 = { _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", encode: function encode(e) {
            var t = "";var n, r, i, s, o, u, a;var f = 0;e = Base64._utf8_encode(e);while (f < e.length) {
              n = e.charCodeAt(f++);r = e.charCodeAt(f++);i = e.charCodeAt(f++);s = n >> 2;o = (n & 3) << 4 | r >> 4;u = (r & 15) << 2 | i >> 6;a = i & 63;if (isNaN(r)) {
                u = a = 64;
              } else if (isNaN(i)) {
                a = 64;
              }t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a);
            }return t;
          }, decode: function decode(e) {
            var t = "";var n, r, i;var s, o, u, a;var f = 0;e = e.replace(/[^A-Za-z0-9+/=]/g, "");while (f < e.length) {
              s = this._keyStr.indexOf(e.charAt(f++));o = this._keyStr.indexOf(e.charAt(f++));u = this._keyStr.indexOf(e.charAt(f++));a = this._keyStr.indexOf(e.charAt(f++));n = s << 2 | o >> 4;r = (o & 15) << 4 | u >> 2;i = (u & 3) << 6 | a;t = t + String.fromCharCode(n);if (u != 64) {
                t = t + String.fromCharCode(r);
              }if (a != 64) {
                t = t + String.fromCharCode(i);
              }
            }t = Base64._utf8_decode(t);return t;
          }, _utf8_encode: function _utf8_encode(e) {
            e = e.replace(/rn/g, "n");var t = "";for (var n = 0; n < e.length; n++) {
              var r = e.charCodeAt(n);if (r < 128) {
                t += String.fromCharCode(r);
              } else if (r > 127 && r < 2048) {
                t += String.fromCharCode(r >> 6 | 192);t += String.fromCharCode(r & 63 | 128);
              } else {
                t += String.fromCharCode(r >> 12 | 224);t += String.fromCharCode(r >> 6 & 63 | 128);t += String.fromCharCode(r & 63 | 128);
              }
            }return t;
          }, _utf8_decode: function _utf8_decode(e) {
            var t = "";var n = 0;var r = c1 = c2 = 0;while (n < e.length) {
              r = e.charCodeAt(n);if (r < 128) {
                t += String.fromCharCode(r);n++;
              } else if (r > 191 && r < 224) {
                c2 = e.charCodeAt(n + 1);t += String.fromCharCode((r & 31) << 6 | c2 & 63);n += 2;
              } else {
                c2 = e.charCodeAt(n + 1);c3 = e.charCodeAt(n + 2);t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63);n += 3;
              }
            }return t;
          } };

        return Base64;
      }
    }, {
      key: 'makeAjaxCall',
      value: function makeAjaxCall(url, params, method) {
        return $.ajax({
          headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
          },
          beforeSend: function beforeSend(data) {
            console.log('Running......');
          },
          url: url,
          type: method,
          dataType: 'json',
          data: params
        });
      }
    }]);

    return Equipment;
  }();
})(jQuery);

$('body').BookEquipment();