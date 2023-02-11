<?php $__env->startSection('content'); ?>
    <div class="container">
        <form method="post">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="selectCategory">Kategori Seçiniz</label>
                    <select class="form-control" id="selectCategory" name="question_category">
                        <option selected>Seçiniz</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($category['question_category']); ?>"><?php echo e($category['question_category']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <br>
                    <label for="newCategory" >Kategori Seçiniz (Yeni bir kategori eklemeyecekseniz lütfen bu alanı boş bırakın)</label>
                    <input type="text" name="new_category" id="newCategory" placeholder="Yeni Kategori">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="question">Soru</label>
                    <input type="text" class="form-control" id="question" name="question" required="required">
                    <br>
                    <label for="answer">Cevap</label>
                    <input type="text" class="form-control" id="answer" name="answer" required="required">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mehmet/Desktop/GitProjects/nealiyorsan/resources/views/admin/question/create.blade.php ENDPATH**/ ?>