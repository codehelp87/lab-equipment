;(($) =>  {
  $.fn.BookEquipment = () => {
    return $(this).each(() => {
      let equipment = new Equipment;
      equipment.linkToBookingDetails();
      equipment.bookEquipment();
    });
  }

  class Equipment {
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

        if (selectedTimeSlotId[0] <= 72 && selectedTimeSlotId[selectedTimeSlotId.length - 1] <= 72) {
          if (!equipment.checkDayToNight(selectedTimeSlotId)) {
            toastr.error('You can only select between 9:00AM - 9:00PM or 9:00PM - 9:00AM');
            return false;
          }
        } else {
          if (!equipment.checkNightToDay(selectedTimeSlotId)) {
            toastr.error('You can only select between 9:00PM - 9:00AM or 9:00AM - 9:00PM');
            return false;
          }
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
          'time_slot_id': selectedTimeSlotId
        }

        okBtn.on('click', function() {
          equipment.makeAjaxCall(route, params, 'POST')
          .done(function(data) {
            if (data.id != undefined) {
              modal.modal('hide');
              toastr.success('Your booking has been recorded');
              return false;
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

    prepareModal(bookingDate, selectedTimeSlot) {
      let stuff = '<h5 class="text-center">You will book</h5>';
      let dateSelected = '<h5 class="text-center">'+bookingDate+'</h5>';
      let info = '<h5 class="text-center">If it\'s correct press ok</h5>';
      let slots = '<ul>';
        for(let i = 0; i < selectedTimeSlot.length; i++) {
          slots += '<li>'+selectedTimeSlot[i]+'</li>';
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