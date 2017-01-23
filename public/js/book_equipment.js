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
      let bookBtn = $(document).find('button#book-now');
      bookBtn.on('click', function() {
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

        console.log('Size', checkBox.size());
        //alert('Hi');
        return false;
      });
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
        async: false,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false
      });
    }

  makeAjaxRequest(url, params, method) {
    return $.ajax({
      headers:{
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
}
})(jQuery);

$('body').BookEquipment();