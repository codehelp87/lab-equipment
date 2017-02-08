<h5><strong>Upcoming Booking</strong> <span class="text-danger pull-right">Cancellation is allowed until 1hr. before your reservation</span></h5> <br>
<table class="table table-hover">
    <tbody>
        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
        <?php 
            //$current = Carbon\Carbon::now(new DateTimeZone('Africa/Lagos'));
            $current = Carbon\Carbon::now(new DateTimeZone('Asia/Seoul'));
            $selectedTimeSlot = $booking->time_slot;

            $lastTimeSelected = $selectedTimeSlot[count($selectedTimeSlot) - 1];
            $hourAndMinute = explode('-', $lastTimeSelected);
            $hm = explode(':', $hourAndMinute[0]);

            $dt = new \DateTime($booking->booking_date);
            $carbon = Carbon\Carbon::instance($dt);
            $carbon->hour = (int) $hm[0];
            $carbon->minute = (int) $hm[1];
            $carbon->second = rand(10, 50);

            $lastBookingTime = round((strtotime($carbon) - strtotime($current)) / 3600, 1);
            $minutes = ($lastBookingTime * 60);
        ?>
        <tr>
            <td><strong><?php echo e($booking->equipment->title); ?></strong></td>
            <td><?php echo e($booking->equipment->model_no); ?></td>
            <td><?php echo e(date_format(new \DateTime($booking->booking_date), 'Y/m/d')); ?></td>
            <td><?php if($booking->time_slot != null): ?> <?php echo e(implode(' , ', $booking->time_slot)); ?>

            <?php endif; ?> </td>
            <td>
                <?php if($minutes <= 60 && $booking->status == 1): ?>
                <button type="button" class="btn btn-default pull-right cancel-booking inActiveBtn"  id="<?php echo e($booking->id); ?>" disabled="disabled"> Cancel</button>
                <?php else: ?>
                <?php $bookingSlot = []; if (!is_null($booking->time_slot)) { $bookingSlot = $booking->time_slot; } ?>
                <button type="button" class="btn btn-default pull-right cancel-booking" id="<?php echo e($booking->id); ?>" data-time-slot="<?php echo e(implode(' , ', $bookingSlot)); ?>" > Cancel</button>
                <?php $bookingSlot = []; ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </tbody>
</table>
