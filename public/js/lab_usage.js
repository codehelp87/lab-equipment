(function(jQuery) {
  jQuery.fn.LabEquipmentUsage = () => {
    return jQuery(this).each(() => {
      let lab = new LabUsage;
      lab.getLabUsageByEquipment();
      lab.getLabUsers();
      lab.getLabUsageBySessionAndEquipment();
      lab.getSessionLabUser();
      lab.getLabUsersByNight();
      lab.getSessionLabUserByNight();
    });
  }

  class LabUsage {
    getSessionLabUserByNight() {
      let lab = new LabUsage;

       jQuery('body').on('click', 'a.view-equipment-users-with-session-bynight', function() {
        let _this = jQuery(this);
        let equipmentId = _this.attr('data-id');
        let labProf = _this.attr('id');
        let session = jQuery(document).find('select#session').val();

        let modal = jQuery(document).find('div#total_lab_usage');
        let modalTitle = modal.find('h4.modal-title');
        let modalBody = modal.find('div.modal-body');

        let route = '/equipments/'+equipmentId+'/labusers/sessions?mode=night';

        lab.makeAjaxCall(route, {session: session, prof: labProf}, 'GET')
          .done(function(data) {
             console.log(data)
            modalTitle.html(data.lab_prof);
            let content = lab.prepareLabUserTable(data[1], data[0].equipment_amount);
            modalBody.html(content);
            modal.modal('show');
          })
          .fail(function(error) {
            console.log(error);
          });

        return false;
       });
    }

    getSessionLabUser() {
      let lab = new LabUsage;

       jQuery('body').on('click', 'a.view-equipment-users-with-session', function() {
        let _this = jQuery(this);
        let equipmentId = _this.attr('data-id');
        let labProf = _this.attr('id');
        let session = jQuery(document).find('select#session').val();

        let modal = jQuery(document).find('div#total_lab_usage');
        let modalTitle = modal.find('h4.modal-title');
        let modalBody = modal.find('div.modal-body');

        let route = '/equipments/'+equipmentId+'/labusers/sessions';

        lab.makeAjaxCall(route, {session: session, prof: labProf}, 'GET')
          .done(function(data) {
             console.log(data)
            modalTitle.html(data.lab_prof);
            let content = lab.prepareLabUserTable(data[1], data[0].equipment_amount);
            modalBody.html(content);
            modal.modal('show');
          })
          .fail(function(error) {
            console.log(error);
          });

        return false;
       });
    }

    getLabUsageBySessionAndEquipment() {
      let lab = new LabUsage;
      let session = jQuery(document)
        .find('form#calculate_lab_usage')
        .find('select#session');
        session.on('change', function() {
          let equipment = jQuery(document)
            .find('form#calculate_lab_usage')
            .find('select#equipment')
            .val();
          let _this = jQuery(this);
          let table = jQuery(document).find('table#display_lab_usage tbody');

          if (equipment == '' || equipment == undefined) {
            toastr.error('Please select an equipment');
            return false;
          }
          let session = _this.val();

          if (session != '') {
            let route = '/equipments/'+equipment+'/lab_usage_by_session'
            let params = {
              'session': session
            }

            lab.makeAjaxCall(route, params, 'GET')
            .done(function(data) {
              if (data.total_charge_by_day == 0 && data.total_charge_by_night == 0) {
                return table.html(lab.NoEquipmentLabListing(data));
              }
              table.html(lab.NoEquipmentLabListing(data));
            })
            .fail(function(error) {
              console.log(error);
            });
          }
        });
    }
    getLabUsers() {
       let lab = new LabUsage;

       jQuery('body').on('click', 'a.view-equipment-users', function() {
        let _this = jQuery(this);
        let equipmentId = _this.attr('data-id');
        let labProf = _this.attr('id');

        let modal = jQuery(document).find('div#total_lab_usage');
        let modalTitle = modal.find('h4.modal-title');
        let modalBody = modal.find('div.modal-body');

        if (labProf == undefined || equipmentId == undefined) {
          modalBody.html('No student bookings available!');
          return modal.modal('show');
        }

        let route = '/equipments/'+equipmentId+'/labusers/'+labProf;

        lab.makeAjaxCall(route, '', 'GET')
          .done(function(data) {
            modalTitle.html(data[0].lab_prof);
            let content = lab.prepareLabUserTable(data[1], data[0].equipment_amount);
            modalBody.html(content);
            modal.modal('show');
          })
          .fail(function(error) {
            console.log(error);
          });

        return false;
       });
    }

    getLabUsersByNight() {
       let lab = new LabUsage;

       jQuery('body').on('click', 'a.view-equipment-users-by-night', function() {
        let _this = jQuery(this);
        let equipmentId = _this.attr('data-id');
        let labProf = _this.attr('id');

        let modal = jQuery(document).find('div#total_lab_usage');
        let modalTitle = modal.find('h4.modal-title');
        let modalBody = modal.find('div.modal-body');

        if (labProf == undefined || equipmentId == undefined) {
          modalBody.html('No student bookings available!');
          return modal.modal('show');
        }

        let route = '/equipments/'+equipmentId+'/labusers/'+labProf+'?mode=night';

        lab.makeAjaxCall(route, '', 'GET')
          .done(function(data) {
            modalTitle.html(data[0].lab_prof);
            let content = lab.prepareLabUserTable(data[1], data[0].equipment_amount);
            modalBody.html(content);
            modal.modal('show');
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
        table += '<tr><td><strong>Total Hours</strong></td><td><strong>'+parseFloat(total / 60)+'<strong></td></tr>';
        table += '<tr><td><strong>Total Price</strong></td><td><strong>'+parseFloat(total * (equipmentAmount / 10))+'</strong></td></tr>';
        table += '</tbody>';
        table += '</table>';

        let downloadLink = '<span class="pull-left"><a href="#" id="download-lab-users" class="download-lab-users">' + 
            '<strong>Download as xlsx</strong></a></span><br><br>';
        return table += downloadLink;
    }

    getLabUsageByEquipment() {
      let lab = new LabUsage;
      let selectEquipment = jQuery(document)
        .find('form#calculate_lab_usage')
        .find('#equipment');

        selectEquipment.on('change', function() {
          let _this = jQuery(this);
          let equipmentId = _this.val();
          let table = jQuery(document).find('table#display_lab_usage tbody');
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
            '<td><a href="#" class="view-equipment-users-by-night" data-id='+data.equipment_id+' id='+data.lab_prof_id+'>'+decodeURI(data.lab_prof)+'</a></td>' +
            '<td>'+data.total_hour_by_night+'</td>' +
            '<td>'+data.total_charge_by_night+'</td>' +
        '</tr>' +
        '<tr>' +
            '<td colspan="5" align="right"><strong>Total</strong></td>' +
            '<td><strong>'+parseInt(data.total_charge_by_day + data.total_charge_by_night)+'</strong></td>' +
        '</tr>';
        return table;
    }

    NoEquipmentLabListing(data) {
      let table = '<tr>' +
            '<td><a href="#" class="view-equipment-users-with-session" data-id='+data.equipment_id+' id='+data.lab_prof_id+'>'+decodeURI(data.lab_prof)+'</a></td>' +
            '<td>'+data.total_hour_by_day+'</td>' +
            '<td>'+data.total_charge_by_day+'</td>' +
            '<td><a href="#" class="view-equipment-users-with-session-bynight" data-id='+data.equipment_id+' id='+data.lab_prof_id+'>'+decodeURI(data.lab_prof)+'</a</td>' +
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
}
})(jQuery);

jQuery('body').LabEquipmentUsage();