;(($) =>  {
  $.fn.LabEquipmentUsage = () => {
    return $(this).each(() => {
      let lab = new LabUsage;
      lab.getLabUsageByEquipment();
    });
  }

  class LabUsage {
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
            '<td><a href="#" class="view-equipment-users" id='+data.lab_prof_id+'>'+decodeURI(data.lab_prof)+'</a></td>' +
            '<td>'+data.total_hour_by_day+'</td>' +
            '<td>'+data.total_charge_by_day+'</td>' +
            '<td><a href="#" class="view-equipment-users" id='+data.lab_prof_id+'>'+decodeURI(data.lab_prof)+'</a></td>' +
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