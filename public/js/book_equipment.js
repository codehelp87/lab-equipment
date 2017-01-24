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
        let equipmentId = $(this).attr('data-id');
        let modal = $(document).find('div.booking-detail');
        let checkBox = $(document)
          .find('div.checkbox')
          .find('input[type="checkbox"]:checked');
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
          selectedTimeSlot.push($(this).val());
        });
        let modalContent = equipment.prepareModal(time, selectedTimeSlot);
        modal.find('div.modal-body').html(modalContent);
        //alert('Hi');
        modal.modal('show');

        let okBtn = modal.find('button.ok');
        const route = '/equipments/booking';
        let params = {
          'equipment': equipmentId,
          'time_slot': selectedTimeSlot,
          'booking_date': time
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

    // makeAjaxCall(url, params, method) {
    //   return $.ajax({
    //     headers:{
    //       'X-CSRF-Token': $('input[name="_token"]').val()
    //     },
    //     url: url,
    //     type: method,
    //     dataType: 'json',
    //     data: params,
    //     async: false,
    //     cache: false,
    //     contentType: false,
    //     enctype: 'multipart/form-data',
    //     processData: false
    //   });
    // }

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