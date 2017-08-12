<div class="container">
<div class="row">
    <h2>Edit student #<?= $student->id?></h2>
    <?php $this->_partial("inc/student_form.php", ['student' => $student, 'isView' => false]) ?>
</div>
</div>