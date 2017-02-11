(function($) {
  jQuery.fn.NotifyAll = () => {
    return $(this).each(() => {
      let notify = new Notification;
      notify.createNotification();
      notify.editNotification();
      notify.updateNotification();
      notify.readNotification();
    });
  }

  class Notification {
    readNotification() {
      let notify = new Notification;
      let readLink = $(document)
        .find('table.notifications')
        .find('a.read-notification');

        readLink.on('click', function() {
          let _this = $(this);
          _this.parents('tr').next().toggle(300);
          return false;
        });
    }
    createNotification() {
      let notify = new Notification;
      $("form#notification").submit(function(evt) {
        let smtBtn = $("form#notification").find('button#save-notification');
        evt.preventDefault();
        let formData = new FormData($(this)[0]);
        let tableBody = $(document).find('table#list-notification tbody');

        notify.makeAjaxCall('/notifications/add', formData, 'POST')
          .done(function(data) {
            let newNotification = notify.addNewNotificationToHtmlTable(data.notification);
            tableBody.prepend(newNotification);

            notify.clearFormFields();
            toastr.success('Your Notification was saved successfully');

            return false
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
          });

      return false;
    });
  }

  editNotification() {
    let notify = new Notification;
    $(function() {
      $('body').on('click', 'table#list-notification a', function() {
      let _this = $(this)
      let $btn = _this.button('loading');
      let id = _this.attr('id');
      let editMode =  $('table#list-notification')
          .find('tr > td div.display'+id);
          
          notify.makeAjaxRequest('/notifications/'+id, '', 'GET')
          .done(function(data) {
            editMode
              .slideDown()
              .html(data)
              .css('display', 'block');
              $btn.button('reset')
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
            $btn.button('reset')
          });

          return false;
        })
    });
  }

  updateNotification() {
      let notify = new Notification;
      $('body').on('submit', 'form.edit_notification', function(evt) {
        evt.preventDefault();
        let form = $(document).find('form.edit_notification');
        let id = $(this).attr('id');
        
        let formData = new FormData(form[0]);

        notify.makeAjaxCall('/notifications/'+id+'/update', formData, 'POST')
          .done(function(res) {
            toastr.success(res.message);
            let newEquipment = notify.addNewNotificationToHtmlTable(res.notification);
            $(document).find('table tr#edit-notification'+id).replaceWith(newEquipment);
            $(document).find('div#edit-notification'+id).slideUp();
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
      tableRow += '<td class="text-left">'+data.title+'</td>';
      tableRow += '<td>'+date+'</td>';
      tableRow += '<td class="text-right"><a href="/notification/'+data.id+'/edit" class="edit-notification" id="notify'+data.id+'">';
      tableRow += '<i class="glyphicon glyphicon-pencil"></i> Edit</a> </td>';
      tableRow += '</tr>';
    return tableRow;
  }

  clearFormFields() {
    $('form#notification')
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

$('body').NotifyAll();