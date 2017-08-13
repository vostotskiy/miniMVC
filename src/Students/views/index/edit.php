<div class="container">
<div class="row">
    <?php if($student->id): ?>
    <h2>Edit student #<?= $student->id?></h2>
    <?php else:?>
    <h2>Create new student</h2>
    <?php endif?>
    <?php $this->_partial("inc/student_form.php", ['student' => $student, 'isView' => false]) ?>
</div>
</div>