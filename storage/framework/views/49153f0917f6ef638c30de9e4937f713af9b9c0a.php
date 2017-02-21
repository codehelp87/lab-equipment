<form class="form-horizontal" id="calculate_lab_usage">
    <div class="form-group">
        <div class="col-sm-4">
            <select name="equipment" id="equipment" class="form-control" required="required">
                <option value="">Select Equipment</option>
                <?php if($equipments->count() > 0): ?>
                <?php $__currentLoopData = $equipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <option value="<?php echo e($equipment->id); ?>"><?php echo e($equipment->model_no); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-sm-4">
            <select name="session" id="session" class="form-control" required="required">
                <option value="">Select booking date</option>
                <?php
                    $year = date('Y');
                    $month = date('M');

                    for ($m = 1; $m <= 12; $m++) {
                        if ($m >= $month) {
                            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                            print '<option value='.$year.'-'.$m.'-'.'1>'.$year.'.'.$month. '</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>
</form>
<div class="table-responsive">
<table class="table table-responsive display_lab_usage" id="display_lab_usage">
    <thead>
        <tr>
            <th>Lab</th>
            <th colspan="2">Daytime (9am - 9pm)</th>
            <th>Lab</th>
            <th colspan="2">Nighttime (9pm - 9am)</th>
        </tr>
        <tr>
           <td></td>
           <td>Hours</td>
            <td>Charge</td>
            <td></td>
           <td>Hours</td>
            <td>Charge</td>
        </tr>
        
    </thead>
    <tbody>
    </tbody>
</table>
</div>
<span class="pull-left">
   <a href="#" id="download-by-equipment" class="download-by-equipment">
      <strong>Download as xlsx</strong>
    </a>
</span>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('a#download-by-equipment').click(function(){
        $('table#display_lab_usage').table2excel({
            // exclude CSS class
            exclude: '.noExl',
            name: 'lab_usage',
            fileext: ".xls",
            filename: 'lab_usage' //do not include extension
        });
    });

    $('body').on('click', 'a#download-lab-users', function() {
        $('table#lab-equipment-users').table2excel({
            // exclude CSS class
            exclude: '.noExl',
            name: 'lab_users',
            fileext: ".xls",
            filename: 'lab_usage' //do not include extension
        });
    });
})
</script>
<?php echo $__env->make('admin.lab_usage.total_lab_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>