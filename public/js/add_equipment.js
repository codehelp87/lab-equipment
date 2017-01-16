
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
      let saveBtn = $('#save-equipment');
      saveBtn.on('click', function() {
      let title = $('form#add_more_equipment').find('#title').val();
      let modelNo = $('form#add_more_equipment').find('#model_no').val();
      let maker = $('form#add_more_equipment').find('#maker').val();
      let timeUnit = $('form#add_more_equipment').find('#time_unit').val();//time_unit
      let reservationTime = $('form#add_more_equipment').find('#reservation_time').val();//reservation_time
      let pricePerUnit = $('form#add_more_equipment').find('#price_per_unit').val();//price_per_unit
      let assignedLab = $('form#add_more_equipment').find('#assign_lab').val();//assign_lab;
      let availability = $('form#add_more_equipment').find('#availability').val();//availability

      if (equipment.checkforEmptyFields().length > 0) {
        toastr.error('Filled the fields in red!');
        return false;
      }
      if (assignedLab == '') {
        toastr.error('Assign a lab!');
        return false;
      }
      if (availability == '') {
        toastr.error('Select equipment availability!');
        return false;
      }
      // make a put request to the server side
      let params = {
        'title': title,
        'model_no': modelNo,
        'maker': maker,
        'time_unit' => timeUnit,
        'reservation_time' => reservationTime,
        'price_per_unit' => pricePerUnit,
        'assign_lab' => assignedLab,
        'availability' => $availability
      }
      lab.makeAjaxCall('/equipments/add', params, 'POST')
        .done(function(data) {
          toastr.success(data.message);
          equipment.clearFormFieds();
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
    });
  }
}
})(jQuery);

$('form#add_more_equipment').UpdateEquipment();