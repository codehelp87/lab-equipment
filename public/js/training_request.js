;(($) =>  {
  $.fn.LabEquipment = () => {
    return $(this).each(() => {
      let req = new TrainingRequest;
      req.getLabEquipment();
      req.selectTrainingRequest();
    });
  }

  class TrainingRequest {
    selectTrainingRequest() {
      let selectedStudents = [];
      let studentIds = [];
      let req = new TrainingRequest;
      let smtBtn = $(document)
        .find('form#approve-request button.btn-default');
      let equipmentId = $(document)
        .find('form#approve-request input#equipment').val();

      smtBtn.on('click', function() {
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

        let modalContent = req.prepareModal(bookingDate, selectedStudents, location);
        modal.find('div.modal-body').html('');
        modal.find('div.modal-body').html(modalContent);
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
          req.makeAjaxCall(route, params, 'POST')
          .done(function(data) {
            if (data.id != undefined) {
              modal.modal('hide');
              toastr.success('Your confirmation has been sent');
              req.clearFields();
              return false;
            }
            return toastr.success(data.message);
          })
          .fail(function(error) {
            console.log(error);
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
    }

    prepareModal(bookingDate, selectedStudents, location) {
      let stuff = '<h5 class="text-center">Are you sure to confirm this request and send a confirmation email?</h5>';
      let dateSelected = '<h5 class="text-center">'+bookingDate+'</h5>';
      let trainingLocation = '<h5 class="text-center">'+location+'</h5>';
      let info = '<h5 class="text-center">If it\'s correct press ok</h5>';
      let students = '<ul style="list-style:none;">';
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