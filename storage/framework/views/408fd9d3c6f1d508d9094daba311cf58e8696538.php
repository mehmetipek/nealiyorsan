<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">Aramalar</div>
                            <div class="col-md text-md-right"><a href="<?php echo e(route('admin.search.create')); ?>" class="btn btn-success btn-sm">Yeni Arama
                                    Oluştur</a></div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>
                        <table class="table table-striped">
                            <thead>
                            <th>id</th>
                            <th>Kullanıcı</th>
                            <th>Kategori</th>
                            <th>Kelimeler</th>
                            <th>Durum</th>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $searchlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $search): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($search->id); ?></td>
                                <td><?php echo e($search->user->name); ?></td>
                                <td><?php echo e($search->category->name); ?></td>
                                <td><?php echo e($search->keywords); ?></td>
                                <td><?php echo e($search->status); ?></td>
                            </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5"><?php echo e($searchlogs->render()); ?></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mehmet/Desktop/GitProjects/nealiyorsan/resources/views/admin/search/index.blade.php ENDPATH**/ ?>