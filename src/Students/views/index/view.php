<div class="container">
    <div class="row">
        <h2>View student #<?= $student->id?> data</h2>
        <?php $this->_partial("inc/student_form.php", ['student' => $student, 'isView' => true]) ?>
    </div>
</div>