<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">Kategoriler</div>
                            <div class="col-md text-md-right"><a href="<?php echo e(route('admin.field.create')); ?>" class="btn btn-success btn-sm">Yeni Kategori Alanı Ekle</a></div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Adı</th>
                                    <th>Tipi</th>
                                    <th>Kategori</th>
                                    <th>Düzenle</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($field->name); ?></td>
                                    <td><?php echo e($field->type); ?></td>
                                    <td><?php echo e($field->category->name); ?></td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit categories')): ?>
                                        <a href="<?php echo e(route('admin.field.edit', ['field_type_id' => $field->id])); ?>" class="btn btn-success btn-sm">Düzenle</a>
                                            <?php else: ?>
                                            <a type="button" class="" data-trigger="hover" data-toggle="popover" title="Yardım" data-content="Alan Düzenleme yetkiniz yok. Lütfen yöneticiniz ile görüşün.">
                                            <i class="icon-help-circled text-danger"></i>
                                            </a>
                                            <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3">
                                    <?php echo e($fields->render()); ?>

                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover();

        });
    </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mehmet/Desktop/GitProjects/nealiyorsan/resources/views/admin/field/index.blade.php ENDPATH**/ ?>