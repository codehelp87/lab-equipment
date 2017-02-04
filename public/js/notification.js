
;(($) =>  {
  $.fn.NotifyAll = () => {
    return $(this).each(() => {
      let notify = new Notification;
      notify.createNotification();
    });
  }

  class Notification {
    createNotification() {
      let notify = new Notification;
      $("form#notification").submit(function(evt) {
        // Change button text to loading
        let smtBtn = $("form#notification").find('button#save-notification');
        evt.preventDefault();
        let formData = new FormData($(this)[0]);

        notify.makeAjaxCall('/notifications/add', formData, 'POST')
          .done(function(data) {
            toastr.success('Your Notification was saved successfully');
            let newNotification = notify.addNewNotificationToHtmlTable(data.notification);
            $('table#admin-notification-list')
              .append(newNotification)
              .css('display', 'block');

            notify.clearFormFields();

            return false
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
          });

      return false;
    });
  }

  addNewNotificationToHtmlTable(data) {
    let date = moment().format('YYYY/MM/DD');
    let tableRow = '<tr>';
      tableRow += '<td>'+data.title+'</td>';
      tableRow += '<td>'+date+'</td>';
      tableRow += '</tr>';
    return tableRow;
  }

  clearFormFields() {
    $('form.notification')
      .find('input[type="text"], textarea')
      .each(function(index, el) {
        $(this).val('');
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
}
})(jQuery);

$('body').NotifyAll();