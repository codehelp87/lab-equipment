
;(($) =>  {
  $.fn.UpdateEquipment = () => {
    return $(this).each(() => {
      let equipment = new Equipment;
      equipment.createEquipment();
    });
  }

  class Equipment {
    createEquipment() {
      let equipment = new Equipment;
      $("form#add_more_equipment").submit(function(evt){
        // Change button text to loading
        let smtBtn = $("form#add_more_equipment").find('button#save-equipment');
        smtBtn.text('Loading...');

        evt.preventDefault();
        let formData = new FormData($(this)[0]);
        let assignedLab = $('form#add_more_equipment').find('#assign_lab').val();//assign_lab;
        let availability = $('form#add_more_equipment').find('#availability').val();//availability

        if (assignedLab == '') {
          toastr.error('Assign a lab!');
          return false;
        }
        if (availability == '') {
          toastr.error('Select equipment availability!');
          return false;
        }

        equipment.makeAjaxCall('/equipments/add', formData, 'POST')
          .done(function(data) {
            toastr.success(data.message);
            let newEquipment = equipment.addNewEquipmentToHtmlTable(data.equipment);
            $('table#list-equipment').append(newEquipment);
            equipment.clearFormFieds();
            smtBtn.text('Save');
            return false
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
          });
        return false;
    });
  }

  addNewEquipmentToHtmlTable(data) {
    let status = data.availability == 1? 'Available': 'Unavailable'
    let tableRow = '<tr>';
      tableRow += '<td>'+data.model_no+'</td>';
      tableRow += '<td><img src='+data.equipment_photo+' style="width: 50px; height: 50px;"></td>';
      tableRow += '<td>';
      tableRow += '<strong>Status</strong><br>' +
        '<strong>Unit Time</strong><br>' +
        '<strong>Max Time(per day)</strong><br>' + 
        '</td>';
      tableRow += '<td>'+status+'<br>'+data.price_per_unit_time+'<br>'+data.max_reservation_time+'<br></td>';
      tableRow += '<td>' +
            '<strong>Open</strong><br>' +
            '<strong>Cancel</strong><br>' +
            '</td>' +
        '<td>' +
            '<span>30 minutes before</span><br>' +
            '<span>1 hour before</span><br>' +
            '</td>' +
            '<td><a href="#" class="edit-eqipment" id='+data.id+' title='+data.title+'>Edit</a></td>' +
      '</tr>';
    return tableRow;
  }

  checkforEmptyFields() {
    let error = [];
    $('form#add_more_equipment')
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

  clearFormFieds() {
    $('form#add_more_equipment')
      .find('input[type="text"]')
      .each(function(index, el) {
        $(this).val('');
    });
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
      async: false,
      cache: false,
      contentType: false,
      enctype: 'multipart/form-data',
      processData: false,
    });
  }
}
})(jQuery);

$('form#add_more_equipment').UpdateEquipment();