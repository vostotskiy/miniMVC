<div class="container">
    <div class="row">


        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Students</h4></div>
                <div class="panel-body">
                    <div class="col-md-2">
                    <a href="students/create" class="btn btn-lg btn-success col-xs-12">
                        <span class="glyphicon glyphicon-plus pull-left"></span> Add student
                    </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="mytable" class="table table-bordred table-striped">

                    <thead>

                    <th><input type="checkbox" id="checkall" /></th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of birth</th>
                    <th>Sex</th>
                    <th>Group</th>
                    <th>Faculty</th>
                    <th colspan="3">Options</th>
                    </thead>
                    <tbody>
                    <?php if(!count($students)):?>
                    <tr>
                        <td colspan="10"><p>No records found</p></td>
                    </tr>
                    <?php else:?>
                        <?php foreach ($students as $student):?>
                    <tr>
                        <td><input type="checkbox" class="checkthis" /></td>
                        <td><?= $student->first_name; ?></td>
                        <td><?= $student->last_name; ?></td>
                        <td><?= date("D, d M y",strtotime($student->date_of_birth));?></td>
                        <td><?= $student->sex; ?></td>
                        <td><?= $student->group; ?></td>
                        <td><?= $student->faculty; ?></td>
                        <td>
                            <div class="row" style="display: inline-block; float: none; white-space: nowrap;">
                                <a href="students/view/<?=$student->id?>" data-toggle="tooltip" data-placement="top" data-title="view" class="btn btn-info">
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                </a>
                                <a href="students/edit/<?=$student->id?>" data-toggle="tooltip" data-placement="top" data-title="edit"  class="btn btn-success">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
<!--                                @todo add confirm dialog-->
                                <a href="students/delete/<?=$student->id?>" data-toggle="tooltip" data-placement="top" data-title="remove"  class="btn btn-danger">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                     <?php endforeach;?>
                    <?php endif;?>
                    </tbody>

                </table>

                <div class="clearfix"></div>
<!--                @todo add pagination-->
<!--                <ul class="pagination pull-right">-->
<!--                    <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>-->
<!--                    <li class="active"><a href="#">1</a></li>-->
<!--                    <li><a href="#">2</a></li>-->
<!--                    <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>-->
<!--                </ul>-->

            </div>

        </div>
    </div>

</div>
