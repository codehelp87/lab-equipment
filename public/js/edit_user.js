
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
        let name = $('form#update_user_bio').find('#name').val();
        let email = $('form#update_user_bio').find('#email').val();
        let phone = $('form#update_user_bio').find('#phone').val();
        let office = $('form#update_user_bio').find('#office').val();
        let oldPassword = $('form#update_user_bio').find('#c_password').val();
        let newPassword = $('form#update_user_bio').find('#new_password').val();
        let confirmPassword = $('form#update_user_bio').find('#com_password').val();

        if (user.checkforEmptyFields().length > 0) {
          toastr.error('Filled the fields in red!');
          return false;
        }
        if (newPassword != confirmPassword) {
          return toastr.error('Both passwords does not match!');
        }
        // make a put request to the server side
        let params = {
          'name': name,
          'email': email,
          'phone': phone,
          'office': office,
          'c_password': oldPassword,
          'new_password': newPassword
        }
        user.makeAjaxCall('/users/'+email, params, 'PUT')
          .done(function(data) {
            toastr.success(data.message);
            user.clearFormFieds();
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

<<<<<<< HEAD
    clearFormFieds() {
      $('form#update_user_bio')
        .find('input[type="password"]')
        .each(function(index, el) {
          $(this).val('');
      });
    }

    makeAjaxCall(url, params, method) {
      return $.ajax({
        headers:{
        'X-CSRF-Token': $('input[name="_token"]').val()
      },
=======
    makeAjaxCall(url, params, method) {
      return $.ajax({
>>>>>>> 701eb3e4bf919ffa8085ed4afe58f37a3fca92d9
        url: url,
        type: method,
        dataType: 'json',
        data: params,
      });
    }
  }
  })(jQuery);

  $('form#update_user_bio').UpdateUserInfo();