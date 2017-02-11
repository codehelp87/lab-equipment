(function(jQuery) {
  jQuery.fn.UpdateEquipment = () => {
    return jQuery(this).each(() => {
      let equipment = new Equipment;
      equipment.createEquipment();
      equipment.editEquipment();
      equipment.updateEquipment();
      equipment.deleteEquipment();
    });
  }

  class Equipment {
    deleteEquipment() {
     let equipment = new Equipment;
      jQuery('body').on('click', 'a.delete-equipment', function() {
        let _this = jQuery(this);

        let jQuerybtn = _this.button('loading');
        let equipmentId = _this.attr('id');
        let route = _this.attr('rel');
        bootbox.confirm('Are you sure to delete?', function(result)  {
          if (result) {
            equipment.makeAjaxCall(route, {}, 'DELETE')
              .done(function(data) {
                if (data.message == 'deleted') {
                  jQuerybtn.button('reset');
                  _this.parents('#edit-eqipment'+equipmentId).remove();
                  return toastr.success('Equipment has been successfully deleted ');
                }
                return toastr.error(data.message);
              })
              .fail(function(error) {
                console.log(error);
              })
          }
          return jQuerybtn.button('reset');
        })
      });
    }

    createEquipment() {
      let equipment = new Equipment;
      jQuery("form#add_more_equipment").submit(function(evt){
        // Change button text to loading
        let smtBtn = jQuery("form#add_more_equipment").find('button#save-equipment');
        evt.preventDefault();
        let formData = new FormData(jQuery(this)[0]);
        let assignedLab = jQuery('form#add_more_equipment').find('#assign_lab').val();//assign_lab;
        let availability = jQuery('form#add_more_equipment').find('#availability').val();//availability

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
            jQuery('table#list-equipment').append(newEquipment);
            equipment.clearFormFields();
            smtBtn.text('Save');
            return false;
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
          });

      return false;
    });
  }

  updateEquipment() {
      let equipment = new Equipment;
      jQuery('body').on('submit', 'form.edit_equipment', function(evt) {
        evt.preventDefault();
        let form = jQuery(document).find('form.edit_equipment');
        let id = jQuery(this).attr('id');
        
        let formData = new FormData(form[0]);

        let assignedLab = jQuery('form.edit_equipment').find('#assign_lab').val();//assign_lab;
        let availability = jQuery('form.edit_equipment').find('#availability').val();//availability

        equipment.makeAjaxCall('/equipments/'+id+'/update', formData, 'POST')
          .done(function(res) {
            toastr.success(res.message);
            let newEquipment = equipment.addNewEquipmentToHtmlTable(res.equipment);
            jQuery(document).find('table tr#edit-eqipment'+id).replaceWith(newEquipment);
            jQuery(document).find('div#edit-eqipment'+id).slideUp();
            equipment.clearFormFields();
            return false;
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
          });
        return false;
    });
  }

  editEquipment() {
    let equipment = new Equipment;
    jQuery(function() {
      jQuery('body').on('click', 'table#list-equipment a.edit-eqipment', function() {
      let _this = jQuery(this);
      let jQuerybtn = _this.button('loading');;
      let id = _this.attr('id');
      let editMode =  jQuery('table#list-equipment')
          .find('tr > td div.display'+id);
          
          equipment.makeAjaxRequest('/equipments/'+id, '', 'GET')
          .done(function(data) {
            editMode
              .slideDown()
              .html(data)
              .css('display', 'block');
              jQuerybtn.button('reset');
          })
          .fail(function(error) {
            toastr.error(JSON.stringify(error));
            jQuerybtn.button('reset');
          });

          return false;
    })
    });
  }

  addNewEquipmentToHtmlTable(data) {
    let status = data.availability == 1? 'Available': 'Unavailable'
    let tableRow = '<tr id="edit-eqipment'+data.id+'">';
      tableRow += '<td>'+data.model_no+'</td>';
      tableRow += '<td><img src='+data.equipment_photo+' style="width: 50px; height: 50px;"></td>';
      tableRow += '<td>';
      tableRow += '<strong>Status</strong><br>' +
        '<strong>Unit Time</strong><br>' +
        '<strong>Max Time(per day)</strong><br>' + 
        '</td>';
      tableRow += '<td>'+status+'<br>'+data.time_unit+' mins <br>'+data.max_reservation_time+' hours<br></td>';
      tableRow += '<td>' +
            '<strong>Open</strong><br>' +
            '<strong>Cancel</strong><br>' +
            '</td>' +
        '<td>' +
            '<span>30 minutes before</span><br>' +
            '<span>1 hour before</span><br>' +
            '</td>' +
            '<td><a href="#" class="edit-eqipment" id='+data.id+' title='+data.title+'>Edit</a></td>' +
            '<td><a href="#"  class="delete-equipment" id='+data.id+' rel="/equipments/'+data.id+'/delete">Delete</a></td>' +
      '</tr>';
    return tableRow;
  }

  checkforEmptyFields() {
    let error = [];
    jQuery('form#add_more_equipment, form.edit_equipment')
      .find('input')
      .each(function(index, el) {
        let _this = jQuery(this);
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
    jQuery('form#add_more_equipment, form.edit_equipment')
      .find('input[type="text"]')
      .each(function(index, el) {
        jQuery(this).val('');
    });
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
      async: false,
      cache: false,
      contentType: false,
      enctype: 'multipart/form-data',
      processData: false
    });
  }

  makeAjaxRequest(url, params, method) {
    return jQuery.ajax({
      headers:{
        'X-CSRF-Token': jQuery('input[name="_token"]').val()
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
    });
  }
}
})(jQuery);

jQuery('body').UpdateEquipment();