;(($) =>  {
  $.fn.LabEquipmentUsage = () => {
    return $(this).each(() => {
      let lab = new LabUsage;
      lab.getLabUsageByEquipment();
      lab.getLabUsers();
    });
  }

  class LabUsage {
    getLabUsers() {
       let lab = new LabUsage;

       $('body').on('click', 'a.view-equipment-users', function() {
        let _this = $(this);
        let equipmentId = _this.attr('data-id');
        let labProf = _this.attr('id');
        let modal = $(document).find('div#total_lab_usage');
        let modalTitle = modal.find('h4.modal-title');
        let modalBody = modal.find('div.modal-body');

        let route = '/equipments/'+equipmentId+'/labusers/'+labProf;

        lab.makeAjaxCall(route, '', 'GET')
          .done(function(data) {
            modalTitle.html(data[0].lab_prof);
            let content = lab.prepareLabUserTable(data[1], data[0].equipment_amount);
            modalBody.html(content);
            modal.modal('show');
            //console.log(data);
            //
          })
          .fail(function(error) {
            console.log(error);
          });

        return false;
       });
    }

    prepareLabUserTable(data, equipmentAmount) {
      let total = 0;
      let table = '<table class="table table-hover" id="lab-equipment-users">';
        table += '<tbody>';
        for(let booking in data) {
          table += '<tr><td><strong>'+data[booking].name+'</strong></td><td><strong>'+data[booking].total_time_booked+'</strong></td></tr>';
          total += parseFloat(data[booking].total_time_booked);
        }
        table += '<tr><td><strong>Total Hours</strong></td><td><strong>'+parseFloat(total/60)+'<strong></td></tr>';
        table += '<tr><td><strong>Total Price</strong></td><td><strong>'+parseFloat(total * equipmentAmount)+'</strong></td></tr>';
        table += '</tbody>';
        table += '</table>';

        let downloadLink = '<span class="pull-left"><a href="#" id="download-lab-users" class="download-lab-users">' + 
            '<strong>Download as xlsx</strong></a></span><br><br>';
        return table += downloadLink;
    }

    getLabUsageByEquipment() {
      let lab = new LabUsage;
      let selectEquipment = $(document)
        .find('form#calculate_lab_usage')
        .find('#equipment');

        selectEquipment.on('change', function() {
          let _this = $(this);
          let equipmentId = _this.val();
          let table = $(document).find('table#display_lab_usage tbody');
          if (equipmentId != '') {
            let route = '/equipments/'+equipmentId+'/lab_usage';

            lab.makeAjaxCall(route, '', 'GET')
            .done(function(data) {
              table.html(lab.listEquipmentLab(data));
            })
            .fail(function(error) {
              console.log(error);
            });
          }
          return false;
        });
    }

    listEquipmentLab(data) {
      let table = '<tr>' +
            '<td><a href="#" class="view-equipment-users" data-id='+data.equipment_id+' id='+data.lab_prof_id+'>'+decodeURI(data.lab_prof)+'</a></td>' +
            '<td>'+data.total_hour_by_day+'</td>' +
            '<td>'+data.total_charge_by_day+'</td>' +
            '<td><a href="#" class="view-equipment-users" data-id='+data.equipment_id+' id='+data.lab_prof_id+'>'+decodeURI(data.lab_prof)+'</a></td>' +
            '<td>'+data.total_hour_by_night+'</td>' +
            '<td>'+data.total_charge_by_night+'</td>' +
        '</tr>' +
        '<tr>' +
            '<td colspan="5" align="right"><strong>Total</strong></td>' +
            '<td><strong>'+parseInt(data.total_charge_by_day + data.total_charge_by_night)+'</strong></td>' +
        '</tr>';
        return table;
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

$('body').LabEquipmentUsage();