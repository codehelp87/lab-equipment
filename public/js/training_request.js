;(($) =>  {
  $.fn.LabEquipment = () => {
    return $(this).each(() => {
      let req = new TrainingRequest;
      req.getLabEquipment();
      req.selectTrainingRequest();
      req.completeTraining();
      req.getTrainingStudents();
    });
  }

  class TrainingRequest {
    completeTraining() {
      let req = new TrainingRequest;
      let selectedStudents = [];
      let studentIds = [];
      let modal = $('div#list-complete-training');
      let smtBtn = $(document)
        .find('form#complete-training button.btn-default');
        smtBtn.on('click', function() {
          let equipmentId = $(document)
            .find('form#complete-training select#equipment')
            .val();
          let equipmentName = $(document)
            .find('form#complete-training select#equipment option:selected')
            .text();
          let checkBox = $(document)
            .find('table#display-complete-training')
            .find('input[type="checkbox"]:checked');

          if (checkBox.size() <= 0) {
            toastr.error('Pls select student to add');
            return false
          }

          checkBox.each(function(index, el) {
            let _this = $(this);
            selectedStudents.push(_this.attr('data-name'));
            studentIds.push(_this.val());
          });

          let modalContent = req.prepareModalForTraniningCompleted(equipmentName, selectedStudents);
          modal.find('div.modal-body').html(modalContent);
          selectedStudents = [];
          modal.modal('show');

          let okBtn = modal.find('button.ok');
          const route = '/equipments/training/completed';
          let params = {
            'equipment': equipmentId,
            'students': studentIds,
            'equipment_name': equipmentName
          }

          okBtn.on('click', function() {
            req.makeAjaxCall(route, params, 'POST')
            .done(function(data) {
              if (data.id != undefined) {
                modal.modal('hide');
                req.clearFields();
                okBtn.unbind('click');
                return toastr.success('Your confirmation has been sent');
              }
            })
            .fail(function(error) {
              console.log(error);
            })
            return false;
          });
          return false;
        });
    }

    selectTrainingRequest() {
      let selectedStudents = [];
      let studentIds = [];
      let req = new TrainingRequest;
      let smtBtn = $(document)
        .find('form#approve-request button.btn-default');

      smtBtn.on('click', function() {
        let equipmentId = $(document)
        .find('form#approve-request select#equipment').val();

        let modal = $('div#list-accepted-request');
        let checkBox = $(document)
          .find('table#display-training-request')
          .find('input[type="checkbox"]:checked');

        let location = $(document)
          .find('form#approve-request input#location').val();
        let month = $(document)
          .find('form#approve-request select#month').val();
        let day = $(document)
          .find('form#approve-request select#day').val();
        let year = $(document)
          .find('form#approve-request select#year').val();

        if (year == '') {
          toastr.error('Pls select year');
          return false;
        }

        if (month == '') {
          toastr.error('Pls select month');
          return false;
        }

        if (day == '') {
          toastr.error('Pls select day');
          return false;
        }

        if (location == '') {
          toastr.error('Pls select training location');
          return false;
        }

        if (checkBox.size() <= 0) {
          toastr.error('Pls select student to add');
          return false
        }

        checkBox.each(function(index, el) {
          let _this = $(this);
          selectedStudents.push(_this.attr('data-name'));
          studentIds.push(_this.val());
        });

        let bookingDate = year+'/'+month+'/'+day;

        let modalContent  = req.prepareModal(bookingDate, selectedStudents, location);
        modal.find('div.modal-body').html(modalContent);
        selectedStudents = [];
        modal.modal('show');
        let okBtn = modal.find('button.ok');
        const route = '/equipments/training/confirmation';

        let params = {
          'equipment': equipmentId,
          'students': studentIds,
          'booking_date': bookingDate,
          'location': location
        }

        okBtn.on('click', function() {
          $.ajax({
              headers:{
                'X-CSRF-Token': $('input[name="_token"]').val()
              },
              url: route,
              type: 'POST',
              dataType: 'json',
              data: params,
            }).done(function(data) {
              if (data.message == 'successful') {
                modal.modal('hide');
                req.clearFields();
                okBtn.unbind('click');
                return toastr.success('Your confirmation has been sent');
              }
              return toastr.success(data.message);
            }).fail(function(error) {
              console.log(error);
            }).always(function() {
              console.log('Complete');
            });
            return false;
          });
        return false;
      });
    }

    clearFields() {
      let location = $(document)
          .find('form#approve-request input#location').val('');
        let month = $(document)
          .find('form#approve-request select#month').val('');
        let day = $(document)
          .find('form#approve-request select#day').val('');
        let year = $(document)
          .find('form#approve-request select#year').val('');

        let checkBox = $(document)
          .find('table#display-training-request, table#display-complete-training')
          .find('input[type="checkbox"]');

        checkBox.each(function(index, el) {
          $(this).attr('checked', false);
        });
    }

    prepareModal(bookingDate, selectedStudents, location) {
      let students = '';
      let stuff = '<h5 class="text-center">Are you sure to confirm this request and send a confirmation email?</h5>';
      let dateSelected = '<h5 class="text-center">'+bookingDate+'</h5>';
      let trainingLocation = '<h5 class="text-center">'+location+'</h5>';
      let info = '<h5 class="text-center">If it\'s correct press ok</h5>';
      students = '<ul style="list-style:none;">';
        for(let i = 0; i < selectedStudents.length; i++) {
          students += '<li><strong>'+decodeURI(selectedStudents[i])+'</strong></li>';
        }
      students += '</ul>';

    stuff += students;
    stuff += dateSelected;
    stuff += trainingLocation;
    stuff +=  info;

      return stuff;
    }

    prepareModalForTraniningCompleted(equipment, selectedStudents) {
      let students, stuff = '';
      let info = '<h5 class="text-center">If it\'s correct press ok</h5>';
      students = '<ul style="list-style:none;">';
        for(let i = 0; i < selectedStudents.length; i++) {
          students += '<li><strong>'+decodeURI(selectedStudents[i])+'</strong></li>';
        }
      students += '</ul>';
      let trainingInfo = '<h5 class="text-center">'+decodeURI(equipment)+' Training is completed </h5>';

      stuff += students;
      stuff += trainingInfo;
      stuff +=  info;

      return stuff;
    }

    getTrainingStudents() {
      let req = new TrainingRequest;
      let selectEquipment = $(document)
        .find('form#complete-training')
        .find('select#equipment');

      let tableBody = $(document)
        .find('form#complete-training')
        .find('table#display-complete-training tbody');

      selectEquipment.on('change', function() {
        let _this = $(this);
        let equipmentId = _this.val();
        const route = '/equipments/'+equipmentId+'/trainings';
        if (_this.val() != '') {
          req.makeAjaxCall(route, '', 'GET')
            .done(function(data) {
              if (data[1].length > 0) {
                let students = req.displayTrainingRequest(data);
                tableBody.html(students);
                return toastr.success('Student loaded');
              }
              tableBody.html('');
              return toastr.error('No requests available for this equipment');
            })
            .fail(function(error) {
              console.log(error);
            })
            .always(function() {
              console.log('Complete');
            });
        }
        return false;
      });
    }

    getLabEquipment() {
      let req = new TrainingRequest;

      let selectEquipment = $(document)
        .find('form#approve-request')
        .find('select#equipment');

      let tableBody = $(document)
        .find('form#approve-request')
        .find('table#display-training-request tbody');

      selectEquipment.on('change', function() {
        let _this = $(this);
        let equipmentId = _this.val();
        const route = '/equipments/'+equipmentId+'/students';
        if (_this.val() != '') {
          req.makeAjaxCall(route, '', 'GET')
            .done(function(data) {
              if (data[1].length > 0) {
                let students = req.displayTrainingRequest(data);
                tableBody.html(students);
                return toastr.success('Student loaded');
              }
              tableBody.html('');
              return toastr.error('No requests available for this equipment');
            })
            .fail(function(error) {
              console.log(error);
            })
            .always(function() {
              console.log('Complete');
            });
        }
        return false;
      });
    }

    displayTrainingRequest(data) {
      let tableRow = '';
      let labProf = data[0];
      let students = data[1];
      for (let i = 0; i < students.length; i++) {
        tableRow += '<tr>' +
          '<td>'+students[i].student_id+'</td>' +
          '<td>'+students[i].name+'</td>' +
          '<td>'+students[i].email+'</td>' +
          '<td>'+students[i].phone+'</td>'+
          '<td>'+labProf+'</td>'+
          '<td><input type="checkbox" class="form-control training-requester" data-name='+encodeURI(students[i].name)+' id="training-requester" value='+students[i].id+'></td>';
         tableRow += '</tr>';
      }
      return tableRow;
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

  $('form#approve-request').LabEquipment();