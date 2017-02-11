(function(jQuery) {
  jQuery.fn.UpdateUserInfo = () => {
    return jQuery(this).each(() => {
      let user = new User;
      user.updateProfile();
      user.editUserAccount();
      user.updateUserAccount();
      user.getLabUsers();
      user.getUserByStatus();
      user.changePassword();
      user.resetPassword();
      user.deleteUser();
    });
  }

  class User {
    deleteUser() {
      let user = new User;
      jQuery('body').on('click', 'a.student-delete', function() {
        let _this = jQuery(this);

        let jQuerybtn = _this.button('loading');
        let studentId = _this.attr('id');
        let route = _this.attr('rel');
        bootbox.confirm('Are you sure to delete?', function(result)  {
          if (result) {
            user.makeAjaxCall(route, {}, 'DELETE')
              .done(function(data) {
                if (data.message == 'deleted') {
                  jQuerybtn.button('reset');
                  _this.parents('#student-edit'+studentId).remove();
                  return toastr.success('User account has been successfully deleted ');
                }
                return toastr.error(data.message);
              })
              .fail(function(error) {
                console.log(error);
              })
          }
          return jQuerybtn.button('reset');
        })
      });
    }

    resetPassword() {
      let user = new User;
      let submitBtn = jQuery('a#send-reset-password-link');
      submitBtn.on('click', function() {
        let _this = jQuery(this);
        var jQuerybtn = jQuery(this).button('loading')
        let userEmail = jQuery('div#manage-user-account').find('input#email').val();

        user.makeAjaxRequest('users/password/reset', {'email': userEmail}, 'POST')
        .done(function(data) {
          toastr.success('Password link has been sent to your email');
          jQuerybtn.button('reset');
        })
        .fail(function(error) {
          console.log(error)
        })
        return false;
      });
    }
    changePassword() {
      let user = new User;
      let saveBtn = jQuery(document).find('button#change-password');
      saveBtn.on('click', function() {
        var jQuerybtn = jQuery(this).button('loading')
        let email = jQuery(document).find('form#change_password').find('#email').val();
        let oldPassword = jQuery(document).find('form#change_password').find('#c_password').val();
        let newPassword = jQuery(document).find('form#change_password').find('#new_password').val();
        let confirmPassword = jQuery(document).find('form#change_password').find('#com_password').val();

        if (oldPassword == '') {
          toastr.error('Enter current password!');
          jQuerybtn.button('reset')
          return false;
        }
        if (newPassword == '') {
          toastr.error('Enter new password!');
          jQuerybtn.button('reset')
          return false;
        }

        if (confirmPassword == '') {
          toastr.error('Pls confirm your password!');
          jQuerybtn.button('reset')
          return false;
        }

        if (newPassword != confirmPassword) {
          toastr.error('Both passwords does not match!');
          jQuerybtn.button('reset')
          return false;
        }
        // make a put request to the server side
        let params = {
          'email': email,
          'c_password': oldPassword,
          'new_password': newPassword
        }
        user.makeAjaxCall('/users/'+email+'/password_change', params, 'PUT')
          .done(function(data) {
            // business logic...
            jQuerybtn.button('reset');
            toastr.success(data.message);
            user.clearFormFields();
            return false
          })
          .fail(function(error) {
            toastr.error(error.toString());
          });
        return false;
      });
    }

    clearFormFields() {
      jQuery(document)
        .find('form#change_password')
        .find('input[type="password"]')
        .each(function(index, el) {
          jQuery(this).val('');
        });
    }

    getUserByStatus() {
      let user = new User;
      let select = jQuery('form#edit-user-account #status');
        select.on('change', function() {
          let _this = jQuery(this);
          let status = _this.val();
          let table = jQuery('table.user-account-list tbody');

          if (_this.val() != '') {
            let route = '/users/'+status+'/view';
            user.makeAjaxCall(route, '', 'GET')
              .done(function(data) {
                if (data.length > 0) {
                  table.html(user.buildUserTable(data));
                  return toastr.success('Table just populated');
                }
                return toastr.error(data.message);
              })
              .fail(function(error) {
                console.log('Error', error.responseText);
                return toastr.error(error.responseText);
              });
          }

        return false;
      });
    }

    getLabUsers() {
      let user = new User;
      let select = jQuery('form#edit-user-account #lab');
          select.on('change', function() {
            let _this = jQuery(this);
            let labId = _this.val();
            let table = jQuery('table.user-account-list tbody');

            if (labId > 0) {
              let route = '/labs/'+labId+'/users';
              user.makeAjaxCall(route, '', 'GET')
                .done(function(data) {
                  if (data.length > 0) {
                    table.html(user.buildUserTable(data));
                    return toastr.success('Table just populated');
                  }
                  return toastr.error(data.message);
                })
                .fail(function(error) {
                  console.log(error);
                });
            }
          return false;
      });
    }

    replaceUserRow(data, index) {
      let tableRow = '';
      let counter = 0;
      //for (let user in data) {
        tableRow += '<tr id="student-edit'+data.id+'" data-index='+index+'>' +
          '<td>'+index+'</td>' +
          '<td>'+data.student_id+'</td>' +
          '<td>'+data.name+'</td>' +
          '<td>'+data.email+'</td>' +
          '<td>'+data.phone+'</td>'+
          '<td>';
          if (data.status == 1) {
            tableRow += 'Active'; 
          } else {
            tableRow += 'Inactive';
          }
          tableRow += '</td>' + 
          '<td><a href="#"  class="student-edit" id='+data.id+'>Edit</a></td>';
          tableRow += '<td><a href="#"  class="student-delete" id='+data.id+' rel="/users/'+data.id+'/delete">Delete</a></td>';
         tableRow += '</tr>';
         counter ++;
      //}
      return tableRow;
    }

    buildUserTable(data) {
      let tableRow = '';
      let counter = 1;
      for (let user in data) {
        tableRow += '<tr id="student-edit'+data[user].id+'" data-index='+counter+'>' +
          '<td>'+counter+'</td>' +
          '<td>'+data[user].student_id+'</td>' +
          '<td>'+data[user].name+'</td>' +
          '<td>'+data[user].email+'</td>' +
          '<td>'+data[user].phone+'</td>'+
          '<td>';
          if (data[user].status == 1) {
            tableRow += 'Active'; 
          } else {
            tableRow += 'Inactive';
          }
          tableRow += '</td>' + 
          '<td><a href="#"  class="student-edit" id='+data[user].id+'>Edit</a></td>';
         tableRow += '</tr>';
        counter++;
      }
      return tableRow;
    }

    updateUserAccount() {
      let user = new User;
      let submitBtn = jQuery('div#manage-user-account button.ok');
      submitBtn.on('click', function() {
        var jQuerybtn = jQuery(this).button('loading')
        let form = jQuery(document).find('div#manage-user-account div.modal-body > form.user-account');
        let modal = jQuery(document).find('div#manage-user-account');
        let id = form.attr('id');
        let currentTr = jQuery(document)
          .find('table.user-account-list')
          .find('tr#student-edit'+id)
        let index = currentTr.attr('data-index');

        let formObject = form.find('input, select');
        user.makeAjaxCall('/users/'+id+'/update', formObject, 'POST')
          .done(function(data) {
            // business logic...
            jQuerybtn.button('reset');

            let edittedAccount = user.replaceUserRow(data, index);
            jQuery(document).find('tr#student-edit'+id).replaceWith(edittedAccount);
            toastr.success('User was successfully updated!');
            modal.modal('hide');
          })
          .fail(function(error) {
            // business logic...
            jQuerybtn.button('reset')
            toastr.error(error.toString());
          })
         return false;
      });
    }

    editUserAccount() {
      let user = new User;
      jQuery('body').on('click', 'a.student-edit', function() {
        var jQuerybtn = jQuery(this).button('loading')
        let modalWrapper = jQuery('.manage-user-account');
        let modalBody = modalWrapper.find('div.modal-body');
        let _this = jQuery(this);
        let userId = _this.attr('id');
        user.makeAjaxRequest('/users/'+userId+'/edit', '', 'GET')
          .done(function(data) {
            // business logic...
            jQuerybtn.button('reset')
            modalBody.html(data);
            modalWrapper.modal('show');
          })
          .fail(function(error) {
            console.log(error)
          })
        return false;
      });
    }

    updateProfile() {
      let user = new User;
      let saveBtn = jQuery('#save-bio');
      saveBtn.on('click', function() {
        var jQuerybtn = jQuery(this).button('loading')
        let name = jQuery('form#update_user_bio').find('#name').val();
        let email = jQuery('form#update_user_bio').find('#email').val();
        let phone = jQuery('form#update_user_bio').find('#phone').val();
        let office = jQuery('form#update_user_bio').find('#office').val();
        let oldPassword = jQuery('form#update_user_bio').find('#c_password').val();
        let newPassword = jQuery('form#update_user_bio').find('#new_password').val();
        let confirmPassword = jQuery('form#update_user_bio').find('#com_password').val();

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
            // business logic...
            jQuerybtn.button('reset')
            toastr.success(data.message);
            return false
          })
          .fail(function(error) {
            // business logic...
            jQuerybtn.button('reset')
            toastr.error(error.toString());
          });
        return false;
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
      });
    }

     makeAjaxRequest(url, params, method) {
      return jQuery.ajax({
        headers:{
        'X-CSRF-Token': jQuery('input[name="_token"]').val()
      },
        url: url,
        type: method,
        //dataType: 'json',
        data: params,
      });
    }
  }
  })(jQuery);

  jQuery('body').UpdateUserInfo();