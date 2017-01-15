
(($) =>  {
  $.fn.UpdateUserInfo = () => {
    return $(this).each(() => {
      user = new User;
      user.updateProfile();
    });
  }

  class User {
    updateProfile() {
      user = new User;
      let saveBtn = $('#save-bio');
      saveBtn.on('click', function() {
        let name = $('form#update_user_bio').find('#name');
        let email = $('form#update_user_bio').find('#email');
        let phone = $('form#update_user_bio').find('#phone');
        let office = $('form#update_user_bio').find('#office');

        if (user.checkforEmptyFields().length > 0) {
          toastr.error('Filled the fields in red!');
        }

        return false;
      });
    }

    checkforEmptyFields() {
      let error = [];
      $('form#update_user_bio')
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

    makeAjaxCall(url, params, method) {
      return $.ajax({
        url: url,
        type: method,
        dataType: 'json',
        data: params,
      });
    }
  }
  })(jQuery);

  $('form#update_user_bio').UpdateUserInfo();