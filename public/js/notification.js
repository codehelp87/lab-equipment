(function(jQuery) {
  jQuery.fn.NotifyAll = () => {
    return jQuery(this).each(() => {
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
      let readLink = jQuery(document)
        .find('table.notifications')
        .find('a.read-notification');

        readLink.on('click', function() {
          let _this = jQuery(this);
          _this.parents('tr').next().toggle(300);
          return false;
        });
    }
    createNotification() {
      let notify = new Notification;
      jQuery("form#notification").submit(function(evt) {
        let smtBtn = jQuery("form#notification").find('button#save-notification');
        evt.preventDefault();
        let formData = new FormData(jQuery(this)[0]);
        let tableBody = jQuery(document).find('table#list-notification tbody');

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
    jQuery(function() {
      jQuery('body').on('click', 'table#list-notification a', function() {
      let _this = jQuery(this)
      let jQuerybtn = _this.button('loading');
      let id = _this.attr('id');
      let editMode =  jQuery('table#list-notification')
          .find('tr > td div.display'+id);
          
          notify.makeAjaxRequest('/notifications/'+id, '', 'GET')
          .done(function(data) {
            editMode
              .slideDown()
              .html(data)
              .css('display', 'block');
              jQuerybtn.button('reset')
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
            jQuerybtn.button('reset')
          });

          return false;
        })
    });
  }

  updateNotification() {
      let notify = new Notification;
      jQuery('body').on('submit', 'form.edit_notification', function(evt) {
        evt.preventDefault();
        let form = jQuery(document).find('form.edit_notification');
        let id = jQuery(this).attr('id');
        
        let formData = new FormData(form[0]);

        notify.makeAjaxCall('/notifications/'+id+'/update', formData, 'POST')
          .done(function(res) {
            toastr.success(res.message);
            let newEquipment = notify.addNewNotificationToHtmlTable(res.notification);
            jQuery(document).find('table tr#edit-notification'+id).replaceWith(newEquipment);
            jQuery(document).find('div#edit-notification'+id).slideUp();
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
    jQuery('form#notification')
      .find('input[type="text"], textarea')
      .each(function(index, el) {
        jQuery(this).val('');
    });
  }

  makeAjaxCall(url, params, method) {
    return jQuery.ajax({
      headers:{
        'X-CSRF-Token': jQuery('input[name="_token"]').val()
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
    return jQuery.ajax({
      headers:{
        'X-CSRF-Token': jQuery('input[name="_token"]').val()
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

jQuery('body').NotifyAll();