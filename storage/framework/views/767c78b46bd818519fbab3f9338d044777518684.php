<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md">Kategoriler</div>
                            <div class="col-md text-md-right"><a href="<?php echo e(route('admin.category.create', ['parent_id' => $parent_id])); ?>" class="btn btn-success btn-sm">Yeni Kategori Ekle</a></div>
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
                                    <th>ID</th>
                                    <th>Adı</th>
                                    <th>Durum</th>
                                    <th>İlan Sayısı</th>
                                    <th>Düzenle</th>
                                    <th>Alt Kategoriler</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($category->id); ?></td>
                                    <td><?php echo e($category->name); ?></td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('status categories')): ?>
                                            <a href="<?php echo e(route('admin.category.status', ['category_id' => $category->id])); ?>">
                                                <?php echo \App\Helpers\Helpers::badgeStatus($category->status); ?>

                                            </a>
                                            <?php else: ?>

                                            <?php echo \App\Helpers\Helpers::badgeStatus($category->status); ?>

                                            <a href="javascript:void(0)"  data-trigger="hover" data-toggle="popover" title="Yardım" data-content="Kategori Açma/Kapama yetkiniz yok. Lütfen yöneticiniz ile görüşün.">
                                                <i class="icon-help-circled text-danger"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td></td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit categories')): ?>
                                        <a href="<?php echo e(route('admin.category.edit', ['category_id' => $category->id])); ?>" class="btn btn-success btn-sm">Düzenle</a>
                                            <?php else: ?>
                                            <a type="button" class="" data-trigger="hover" data-toggle="popover" title="Yardım" data-content="Kategori Düzenleme yetkiniz yok. Lütfen yöneticiniz ile görüşün.">
                                            <i class="icon-help-circled text-danger"></i>
                                            </a>
                                            <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.category.index', ['parent_id' => $category->id])); ?>" class="btn btn-success btn-sm">Alt Kategoriler</a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5">
                                    <?php echo e($categories->render()); ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mehmet/Desktop/GitProjects/nealiyorsan/resources/views/admin/category/index.blade.php ENDPATH**/ ?>