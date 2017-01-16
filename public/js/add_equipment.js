
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