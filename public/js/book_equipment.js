;(($) =>  {
  $.fn.BookEquipment = () => {
    return $(this).each(() => {
      let equipment = new Equipment;
      equipment.linkToBookingDetails();
      equipment.bookEquipment();
      equipment.cancelBooking();
    });
  }

  class Equipment {
    cancelBooking(){
      let equipment = new Equipment;
      let cancelBtn = $(document).find('button.cancel-booking');

      cancelBtn.on('click', function() {
        let _this = $(this);
        let modal = $(document).find('div.cancel_booking');
        let selectedTimeSlot = _this.attr('data-time-slot');
        let bookingDate = moment().format('MM.DD.YYYY');
        let bookingId = _this.attr('id');
        let otherCancelBtn = $(document)
          .find('button.cancel-booking#'+bookingId);
    
        let modalContent = equipment.prepareModalForBookingCancel(bookingDate, selectedTimeSlot);
        modal.find('div.modal-body').html(modalContent);
        modal.modal('show');

        let okBtn = modal.find('button.ok');
        const route = '/bookings/'+bookingId+'/cancel';

        okBtn.on('click', function() {
          console.log('Size', otherCancelBtn.size());
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
              return _this.text('Cancelled');
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
      let equipment = new Equipment;

      let bookBtn = $(document).find('button#book-now');

      bookBtn.on('click', function() {
        let selectedTimeSlot = [];
        let selectedTimeSlotId = [];
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
          selectedTimeSlotId.push(_this.attr('id'));
        });

        let flag = '';

        if (selectedTimeSlotId[0] <= 72 && selectedTimeSlotId[selectedTimeSlotId.length - 1] <= 72) {
          if (!equipment.checkDayToNight(selectedTimeSlotId)) {
            toastr.error('You can only select between 9:00AM - 9:00PM or 9:00PM - 9:00AM');
            return false;
          }
          flag = 'daytime';
        } else {
          if (!equipment.checkNightToDay(selectedTimeSlotId)) {
            toastr.error('You can only select between 9:00PM - 9:00AM or 9:00AM - 9:00PM');
            return false;
          }
          flag = 'nighttime';
        }

        let modalContent = equipment.prepareModal(time, selectedTimeSlot);
        modal.find('div.modal-body').html(modalContent);
        //alert('Hi');
        modal.modal('show');

        let okBtn = modal.find('button.ok');
        const route = '/equipments/booking';
        let params = {
          'equipment': equipmentId,
          'time_slot': selectedTimeSlot,
          'booking_date': time,
          'time_slot_id': selectedTimeSlotId,
          'timezone': flag
        }

        okBtn.on('click', function() {
          equipment.makeAjaxCall(route, params, 'POST')
          .done(function(data) {
            if (data.id != undefined) {
              modal.modal('hide');
              toastr.success('Your booking has been recorded');
              return window.location.href = '/equipments/'+equipmentId+'/booking';
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

    checkDayToNight(timeSlots) {
      const DAY_TO_NIGHT_MAX = 72; // 0 - 72
      let timeCount = timeSlots.length;
      let minCounter = 0;

      for (let i = 0; i < timeSlots.length; i++) {
        if (timeSlots[i] <= DAY_TO_NIGHT_MAX) {
          minCounter ++;
        }
      }

      if (minCounter < timeCount) {
        return false
      }
      return true;
    }

    checkNightToDay(timeSlots) {
      const NIGHT_TO_DAY_MIN = 72; // 72 to 149
      let timeCount = timeSlots.length;
      let maxCounter = 0;

      for (let i = 0; i < timeSlots.length; i++) {
        if (timeSlots[i] >= NIGHT_TO_DAY_MIN) {
          maxCounter ++;
        }
      }
      if (maxCounter < timeCount) {
        return false
      }
      return true;
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

  makeAjaxCall(url, params, method) {
      return $.ajax({
        headers:{
        'X-CSRF-Token': $('input[name="_token"]').val()
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