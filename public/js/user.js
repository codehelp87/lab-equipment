'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function ($) {
  jQuery.fn.UpdateUserInfo = function () {
    return $(this).each(function () {
      var user = new User();
      user.updateProfile();
      user.editUserAccount();
      user.updateUserAccount();
      user.getLabUsers();
      user.getUserByStatus();
      user.changePassword();
      user.resetPassword();
      user.deleteUser();
    });
  };

  var User = function () {
    function User() {
      _classCallCheck(this, User);
    }

    _createClass(User, [{
      key: 'deleteUser',
      value: function deleteUser() {
        var user = new User();
        $('body').on('click', 'a.student-delete', function () {
          var _this = $(this);

          var $btn = _this.button('loading');
          var studentId = _this.attr('id');
          var route = _this.attr('rel');
          bootbox.confirm('Are you sure to delete?', function (result) {
            if (result) {
              user.makeAjaxCall(route, {}, 'DELETE').done(function (data) {
                if (data.message == 'deleted') {
                  $btn.button('reset');
                  _this.parents('#student-edit' + studentId).remove();
                  return toastr.success('User account has been successfully deleted ');
                }
                return toastr.error(data.message);
              }).fail(function (error) {
                console.log(error);
              });
            }
            return $btn.button('reset');
          });
        });
      }
    }, {
      key: 'resetPassword',
      value: function resetPassword() {
        var user = new User();
        var submitBtn = $('a#send-reset-password-link');
        submitBtn.on('click', function () {
          var _this = $(this);
          var $btn = $(this).button('loading');
          var userEmail = $('div#manage-user-account').find('input#email').val();

          user.makeAjaxRequest('users/password/reset', { 'email': userEmail }, 'POST').done(function (data) {
            toastr.success('Password link has been sent to your email');
            $btn.button('reset');
          }).fail(function (error) {
            console.log(error);
          });
          return false;
        });
      }
    }, {
      key: 'changePassword',
      value: function changePassword() {
        var user = new User();
        var saveBtn = $(document).find('button#change-password');
        saveBtn.on('click', function () {
          var $btn = $(this).button('loading');
          var email = $(document).find('form#change_password').find('#email').val();
          var oldPassword = $(document).find('form#change_password').find('#c_password').val();
          var newPassword = $(document).find('form#change_password').find('#new_password').val();
          var confirmPassword = $(document).find('form#change_password').find('#com_password').val();

          if (oldPassword == '') {
            toastr.error('Enter current password!');
            $btn.button('reset');
            return false;
          }
          if (newPassword == '') {
            toastr.error('Enter new password!');
            $btn.button('reset');
            return false;
          }

          if (confirmPassword == '') {
            toastr.error('Pls confirm your password!');
            $btn.button('reset');
            return false;
          }

          if (newPassword != confirmPassword) {
            toastr.error('Both passwords does not match!');
            $btn.button('reset');
            return false;
          }
          // make a put request to the server side
          var params = {
            'email': email,
            'c_password': oldPassword,
            'new_password': newPassword
          };
          user.makeAjaxCall('/users/' + email + '/password_change', params, 'PUT').done(function (data) {
            // business logic...
            $btn.button('reset');
            user.clearFormFields();
            if (data.message == 'Your password has been updated successfully') {
              return toastr.success('Your password has been updated successfully');
            }
            toastr.error(data.message);
            return false;
          }).fail(function (error) {
            toastr.error(error.toString());
          });
          return false;
        });
      }
    }, {
      key: 'clearFormFields',
      value: function clearFormFields() {
        $(document).find('form#change_password').find('input[type="password"]').each(function (index, el) {
          $(this).val('');
        });
      }
    }, {
      key: 'getUserByStatus',
      value: function getUserByStatus() {
        var user = new User();
        var select = $('form#edit-user-account #status');
        select.on('change', function () {
          var _this = $(this);
          var status = _this.val();
          var table = $('table.user-account-list tbody');

          if (_this.val() != '') {
            var route = '/users/' + status + '/view';
            user.makeAjaxCall(route, '', 'GET').done(function (data) {
              if (data.length > 0) {
                table.html(user.buildUserTable(data));
                return toastr.success('Table just populated');
              }
              return toastr.error(data.message);
            }).fail(function (error) {
              console.log('Error', error.responseText);
              return toastr.error(error.responseText);
            });
          }

          return false;
        });
      }
    }, {
      key: 'getLabUsers',
      value: function getLabUsers() {
        var user = new User();
        var select = $('form#edit-user-account #lab');
        select.on('change', function () {
          var _this = $(this);
          var labId = _this.val();
          var table = $('table.user-account-list tbody');

          if (labId > 0) {
            var route = '/labs/' + labId + '/users';
            user.makeAjaxCall(route, '', 'GET').done(function (data) {
              if (data.length > 0) {
                table.html(user.buildUserTable(data));
                return toastr.success('Table just populated');
              }
              return toastr.error(data.message);
            }).fail(function (error) {
              console.log(error);
            });
          }
          return false;
        });
      }
    }, {
      key: 'replaceUserRow',
      value: function replaceUserRow(data, index) {
        var tableRow = '';
        var counter = 0;
        //for (let user in data) {
        tableRow += '<tr id="student-edit' + data.id + '" data-index=' + index + '>' + '<td>' + index + '</td>' + '<td>' + data.student_id + '</td>' + '<td>' + data.name + '</td>' + '<td>' + data.email + '</td>' + '<td>' + data.phone + '</td>' + '<td>';
        if (data.status == 1) {
          tableRow += 'Active';
        } else {
          tableRow += 'Inactive';
        }
        tableRow += '</td>' + '<td><a href="#"  class="student-edit" id=' + data.id + '>Edit</a></td>';
        tableRow += '<td><a href="#"  class="student-delete" id=' + data.id + ' rel="/users/' + data.id + '/delete">Delete</a></td>';
        tableRow += '</tr>';
        counter++;
        //}
        return tableRow;
      }
    }, {
      key: 'buildUserTable',
      value: function buildUserTable(data) {
        var tableRow = '';
        var counter = 1;
        for (var user in data) {
          tableRow += '<tr id="student-edit' + data[user].id + '" data-index=' + counter + '>' + '<td>' + counter + '</td>' + '<td>' + data[user].student_id + '</td>' + '<td>' + data[user].name + '</td>' + '<td>' + data[user].email + '</td>' + '<td>' + data[user].phone + '</td>' + '<td>';
          if (data[user].status == 1) {
            tableRow += 'Active';
          } else {
            tableRow += 'Inactive';
          }
          tableRow += '</td>' + '<td><a href="#"  class="student-edit" id=' + data[user].id + '>Edit</a></td>';
          tableRow += '</tr>';
          counter++;
        }
        return tableRow;
      }
    }, {
      key: 'updateUserAccount',
      value: function updateUserAccount() {
        var user = new User();
        var submitBtn = $('div#manage-user-account button.ok');
        submitBtn.on('click', function () {
          var $btn = $(this).button('loading');
          var form = $(document).find('div#manage-user-account div.modal-body > form.user-account');
          var modal = $(document).find('div#manage-user-account');
          var id = form.attr('id');
          var currentTr = $(document).find('table.user-account-list').find('tr#student-edit' + id);
          var index = currentTr.attr('data-index');

          var formObject = form.find('input, select');
          user.makeAjaxCall('/users/' + id + '/update', formObject, 'POST').done(function (data) {
            // business logic...
            $btn.button('reset');

            var edittedAccount = user.replaceUserRow(data, index);
            $(document).find('tr#student-edit' + id).replaceWith(edittedAccount);
            toastr.success('User was successfully updated!');
            modal.modal('hide');
          }).fail(function (error) {
            // business logic...
            $btn.button('reset');
            toastr.error(error.toString());
          });
          return false;
        });
      }
    }, {
      key: 'editUserAccount',
      value: function editUserAccount() {
        var user = new User();
        $('body').on('click', 'a.student-edit', function () {
          var $btn = $(this).button('loading');
          var modalWrapper = $('.manage-user-account');
          var modalBody = modalWrapper.find('div.modal-body');
          var _this = $(this);
          var userId = _this.attr('id');
          user.makeAjaxRequest('/users/' + userId + '/edit', '', 'GET').done(function (data) {
            // business logic...
            $btn.button('reset');
            modalBody.html(data);
            modalWrapper.modal('show');
          }).fail(function (error) {
            console.log(error);
          });
          return false;
        });
      }
    }, {
      key: 'updateProfile',
      value: function updateProfile() {
        var user = new User();
        var saveBtn = $('#save-bio');
        saveBtn.on('click', function () {
          var $btn = $(this).button('loading');
          var name = $('form#update_user_bio').find('#name').val();
          var email = $('form#update_user_bio').find('#email').val();
          var phone = $('form#update_user_bio').find('#phone').val();
          var office = $('form#update_user_bio').find('#office').val();
          var oldPassword = $('form#update_user_bio').find('#c_password').val();
          var newPassword = $('form#update_user_bio').find('#new_password').val();
          var confirmPassword = $('form#update_user_bio').find('#com_password').val();

          if (newPassword != confirmPassword) {
            return toastr.error('Both passwords does not match!');
          }
          // make a put request to the server side
          var params = {
            'name': name,
            'email': email,
            'phone': phone,
            'office': office,
            'c_password': oldPassword,
            'new_password': newPassword
          };
          user.makeAjaxCall('/users/' + email, params, 'PUT').done(function (data) {
            // business logic...
            $btn.button('reset');
            if (data.message == 'Record updated successfully') {
              return toastr.success('Record updated successfully')
            }
            toastr.error(data.message);
            return false;
          }).fail(function (error) {
            // business logic...
            $btn.button('reset');
            toastr.error(error.toString());
          });
          return false;
        });
      }
    }, {
      key: 'makeAjaxCall',
      value: function makeAjaxCall(url, params, method) {
        return $.ajax({
          headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
          },
          url: url,
          type: method,
          dataType: 'json',
          data: params
        });
      }
    }, {
      key: 'makeAjaxRequest',
      value: function makeAjaxRequest(url, params, method) {
        return $.ajax({
          headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
          },
          url: url,
          type: method,
          //dataType: 'json',
          data: params
        });
      }
    }]);

    return User;
  }();
})(jQuery);

$('body').UpdateUserInfo();