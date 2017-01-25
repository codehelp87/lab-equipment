;(($) =>  {
  $.fn.LabEquipment = () => {
    return $(this).each(() => {
      let req = new TrainingRequest;
      req.getLabEquipment();
    });
  }

  class TrainingRequest {
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
        console.log(students[i].student_id);
        tableRow += '<tr>' +
          '<td>'+students[i].student_id+'</td>' +
          '<td>'+students[i].name+'</td>' +
          '<td>'+students[i].email+'</td>' +
          '<td>'+students[i].phone+'</td>'+
          '<td>'+labProf+'</td>'+
          '<td><input type="checkbox" class="form-control training-requester" id="training-requester" value='+students[i].id+'></td>';
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