

<?php $__env->startSection('title', 'Newsfeed'); ?>

<?php $__env->startSection('content'); ?>

    
    <?php echo $__env->make('components.create-post', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php $__empty_1 = true; $__currentLoopData = $feed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <?php if($item['type'] === 'post'): ?>

            <?php echo $__env->make('components.post-card', [
                'post' => $item['data']
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($item['type'] === 'shared'): ?>

            <?php echo $__env->make('components.shared-post-card', [
                'shared' => $item['data']
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

        <div class="bg-white rounded-2xl p-10 text-center border-2 border-dashed border-orange-200">

            <span class="text-5xl block mb-4">
                🏜️
            </span>

            <p class="text-gray-400 font-medium">
                It's a bit quiet in the forest.
            </p>

        </div>

    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dikit\Desktop\projects\newsfeedfacebook\resources\views/newsfeed.blade.php ENDPATH**/ ?>