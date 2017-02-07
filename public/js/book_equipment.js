;(($) =>  {
  $.fn.BookEquipment = () => {
    return $(this).each(() => {
      let equipment = new Equipment;
      equipment.linkToBookingDetails();
      equipment.bookEquipment();
      equipment.cancelBooking();
      equipment.releaseEquipmentFromBooking();
    });
  }

  class Equipment {
    releaseEquipmentFromBooking() {
      let equipment = new Equipment;
      let minutes = 2;
      let interval = 1000 * 60 * minutes; // where X is your every X minutes
      let route = '/equipment/booking/checking';

      $.fn.keepAlive({url: route, timer: interval}, function(response) {
        console.log(response);
      });//
    }

    cancelBooking(){
      let equipment = new Equipment;
      let cancelBtn = $(document).find('button.cancel-booking');

      cancelBtn.on('click', function() {
        let _this = $(this);
        let modal = $(document).find('div.cancel_booking');
        let selectedTimeSlot = _this.attr('data-time-slot');
        let bookingDate = moment().format('MM.DD.YYYY');
        let bookingId = _this.attr('id');
    
        let modalContent = equipment.prepareModalForBookingCancel(bookingDate, selectedTimeSlot);
        modal.find('div.modal-body').html(modalContent);
        modal.modal('show');

        let okBtn = modal.find('button.ok');
        const route = '/bookings/'+bookingId+'/cancel';

        okBtn.on('click', function() {
          let otherCancelBtn = $('body')
          .find('button#'+bookingId);

          equipment.makeAjaxCall(route, '', 'GET')
          .done(function(data) {
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
          })
          .fail(function(error) {
            console.log(error);
          });

          return false;
        });

        return false;
      });

    }
    bookEquipment() {
      const MAX_BOOKING_AHEAD = 30;

      let equipment = new Equipment;
      let bookBtn = $(document).find('button#book-now');

      bookBtn.on('click', function() {
        let selectedTimeSlot = [];
        let selectedTimeSlotId = [];
        let selectedDate = [];

        let equipmentId = $(this).attr('data-id');
        let modal = $(document).find('div.booking-detail');
        let checkBox = $(document)
          .find('div.checkbox')
          .find('input[type="checkbox"]:checked').not('input[type="checkbox"]:disabled');
        let time = $(document).find('span#time').text();

        if (time == '') {
          toastr.error('Pls select date');
          return false
        }

        if (checkBox.size() <= 0) {
          toastr.error('Pls select time slot');
          return false
        }

        checkBox.each(function(index, el) {
          var _this = $(this);
          selectedTimeSlot.push(_this.val());
          selectedDate.push(_this.attr('date-time'));
          selectedTimeSlotId.push(_this.attr('id'));
        });

        let date = new Date();
        let myDate = new Date(
          date.getFullYear(), 
          date.getMonth(), 
          date.getDate(), 
          date.getHours(), 
          date.getMinutes(),
          date.getSeconds()
        );

        let dateNow = moment(myDate).format('YYYY-MM-DD HH:mm');

        for(let i = 0; i < selectedDate.length; i++) {
          let currentDate = moment(dateNow);
          let dateSelected = moment(selectedDate[i]);
          let dateBehindCheck = dateSelected.diff(currentDate, 'minutes');

          if (dateBehindCheck < MAX_BOOKING_AHEAD) {
            toastr.error('Time selected: '+selectedDate[i]+ ' must be 30 minutes ahead');
            return false
          }
        }
        
        let modalContent = equipment.prepareModal(time, selectedTimeSlot);
        modal.find('div.modal-body').html(modalContent);
        modal.modal('show');

        let okBtn = modal.find('button.ok');
        const route = '/equipments/booking';
        let params = {
          'equipment': equipmentId,
          'time_slot': selectedTimeSlot,
          'booking_date': time,
          'time_slot_id': selectedTimeSlotId,
          'selected_date': selectedDate
        }

        okBtn.on('click', function() {
          equipment.makeAjaxCall(route, params, 'POST')
          .done(function(data) {
            if (data[0].id != undefined) {
              modal.modal('hide');
              toastr.success('Your booking has been recorded');
              okBtn.unbind('click');
              bookBtn.unbind('click');
              return window.location.href = '/equipments/'+equipment.base64Encode().encode(equipmentId)+'/booking';
            }
            return toastr.success(data.message);
          })
          .fail(function(error) {
            console.log(error);
          });

          return false;
        });

        return false;
      });
    }

    prepareModalForBookingCancel(bookingDate, selectedTimeSlot) {
      let stuff = '<h5 class="text-center">Are you sure you want to cancel this reservation</h5>';
      let dateSelected = '<h5 class="text-center">'+bookingDate+'</h5>';
      let info = '<h5 class="text-center">If it\'s correct press Cancel Now</h5><br>';
      let timeSlot = selectedTimeSlot.split(',');

      let slots = '<ul style="padding:0; list-style: none;">';
        for(let i = 0; i < timeSlot.length; i++) {
          slots += '<li class="text-center"><h4>'+timeSlot[i].trim()+'</h4></li>';
        }
        slots += '</ul>';

        stuff += dateSelected;
        stuff += slots;
        stuff +=  info;

      return stuff;
    }

    prepareModal(bookingDate, selectedTimeSlot) {
      let stuff = '<h5 class="text-center">You will book</h5>';
      let dateSelected = '<h5 class="text-center">'+bookingDate+'</h5>';
      let info = '<h5 class="text-center">If it\'s correct press ok</h5>';
      let slots = '<ul style="padding:0; list-style: none;">';
        for(let i = 0; i < selectedTimeSlot.length; i++) {
          slots += '<li class="text-center"><h4>'+selectedTimeSlot[i]+'</h4></li>';
        }
        slots += '</ul>';

        stuff += dateSelected;
        stuff += slots;
        stuff +=  info;

      return stuff;
    }

    linkToBookingDetails() {
      let linkBtn = $(document).find('button#book-equipment');
      linkBtn.on('click', function() {
        let bookItem = $(document)
          .find('select#book_equipment')
          .val();

        if (bookItem != '') {
          window.location.href = '/equipments/'+bookItem+'/booking';
        }
        return false;
      });
    }

    base64Encode() {
    // Create Base64 Object
    var Base64 = {_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

    return Base64;

    }

  makeAjaxCall(url, params, method) {
    return $.ajax({
      headers:{
      'X-CSRF-Token': $('input[name="_token"]').val()
    },
    beforeSend: function(data) {
      console.log('Running......')
    },
      url: url,
      type: method,
      dataType: 'json',
      data: params,
    });
  }
}
})(jQuery);

$('body').BookEquipment();