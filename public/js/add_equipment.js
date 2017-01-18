
;(($) =>  {
  $.fn.UpdateEquipment = () => {
    return $(this).each(() => {
      let equipment = new Equipment;
      equipment.createEquipment();
      equipment.editEquipment();
      equipment.updateEquipment();
    });
  }

  class Equipment {
    createEquipment() {
      let equipment = new Equipment;
      $("form#add_more_equipment").submit(function(evt){
        // Change button text to loading
        let smtBtn = $("form#add_more_equipment").find('button#save-equipment');

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
            equipment.clearFormFields();
            smtBtn.text('Save');
            return false
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
          });
        return false;
    });
  }

  updateEquipment() {
      let equipment = new Equipment;
      $('body').on('submit', 'form.edit_equipment', function(evt) {
        evt.preventDefault();
        let form = $(document).find('form.edit_equipment');
        let id = $(this).attr('id');
        
        let formData = new FormData(form[0]);

        let assignedLab = $('form.edit_equipment').find('#assign_lab').val();//assign_lab;
        let availability = $('form.edit_equipment').find('#availability').val();//availability

        equipment.makeAjaxCall('/equipments/'+id+'/update', formData, 'POST')
          .done(function(res) {
            toastr.success(res.message);
            let newEquipment = equipment.addNewEquipmentToHtmlTable(res.equipment);
            $(document).find('table tr#edit-eqipment'+id).replaceWith(newEquipment);
            $(document).find('div#edit-eqipment'+id).slideUp();
            equipment.clearFormFields();
            return false
          })
          .fail(function(error) {
            console.log(JSON.stringify(error));
            toastr.error(JSON.stringify(error));
          });
        return false;
    });
  }

  editEquipment() {
    let equipment = new Equipment;
    $(function() {
      $('body').on('click', 'table#list-equipment a', function() {
      let _this = $(this);
      let id = _this.attr('id');
      let editMode =  $('table#list-equipment')
          .find('tr > td div.display'+id);
          
          equipment.makeAjaxRequest('/equipments/'+id, '', 'GET')
          .done(function(data) {
            editMode
              .slideDown()
              .html(data)
              .css('display', 'block');
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
          });

          return false;
    })
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
    $('form.add_more_equipment')
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

  clearFormFields() {
    $('form.add_more_equipment')
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
      processData: false
      // beforeSend: function() {
      //   $("form#add_more_equipment")
      //   .find('button#save-equipment')
      //   .text('Loading...');
      // }
    });
  }

  makeAjaxRequest(url, params, method) {
    return $.ajax({
      headers:{
        'X-CSRF-Token': $('input[name="_token"]').val()
      },
      url: url,
      type: method,
      dataType: 'html',
      data: params,
      async: false,
      cache: false,
      contentType: false,
      enctype: 'multipart/form-data',
      processData: false
      // beforeSend: function() {
      //   $("form#add_more_equipment")
      //   .find('button#save-equipment')
      //   .text('Loading...');
      // }
    });
  }
}
})(jQuery);

$('body').UpdateEquipment();