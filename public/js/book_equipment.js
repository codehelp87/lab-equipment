;(($) =>  {
  $.fn.BookEquipment = () => {
    return $(this).each(() => {
      let equipment = new Equipment;
      equipment.linkToBookingDetails();
    });
  }

  class Equipment {
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