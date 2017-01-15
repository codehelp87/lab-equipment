
;(($) =>  {
  $.fn.UpdateEquipmentLab = () => {
    return $(this).each(() => {
      lab = new Lab;
      lab.createLab();
    });
  }

  class Lab {
    createLab() {
      lab = new Lab;
      let saveBtn = $('#save-lab');
      saveBtn.on('click', function() {
        let title = $('form#manage_lab').find('#title').val();
        let modelNo = $('form#manage_lab').find('#model_no').val();
        let assignedUser = $('form#manage_lab').find('#assign_user').val();

        if (lab.checkforEmptyFields().length > 0) {
          toastr.error('Filled the fields in red!');
          return false;
        }
        if (assignedUser == '') {
          toastr.error('Assign a user!');
          return false;
        }
        // make a put request to the server side
        let params = {
          'title': title,
          'model_no': modelNo,
          'user': assignedUser,
        }
        lab.makeAjaxCall('/labs/add', params, 'POST')
          .done(function(data) {
            toastr.success(data.message);
            lab.clearFormFieds();
            return false
          })
          .fail(function(error) {
            toastr.error(error.toString());
          });
        return false;
      });
    }

    checkforEmptyFields() {
      let error = [];
      $('form#manage_lab')
        .find('input')
        .each(function(index, el) {
          let _this = $(this);
          if (_this.val() == '') {
            error.push(_this.attr('id'));
            _this.css('border', '1px solid red');
          } else {
            _this.css('border', '1px solid #ccc');
          }
        });
      return error;
    }

    clearFormFieds() {
      $('form#manage_lab')
        .find('input[type="text"]')
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
      });
    }
  }
  })(jQuery);

  $('form#manage_lab').UpdateEquipmentLab();