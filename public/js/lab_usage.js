;(($) =>  {
  $.fn.LabEquipmentUsage = () => {
    return $(this).each(() => {
      let lab = new LabUsage;
      lab.getLabUsageByEquipment();
    });
  }

  class LabUsage {
    getLabUsageByEquipment() {
      let selectEquipment = $(document)
        .find('form#calculate_lab_usage')
        .find('#equipment');

        selectEquipment.on('change', function() {
          let _this = $(this);
          console.log(_this.val());
          return false;
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

$('body').LabEquipmentUsage();