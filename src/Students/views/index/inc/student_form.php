<div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">Student</div>
        </div>
        <div class="panel-body">
            <form id="student" class="form-horizontal" method="post">
                <div class="form-group required">
                    <label for="first_name" class="control-label col-md-4  requiredField"> First name<span
                                class="asteriskField">*</span> </label>
                    <div class="controls col-md-8 ">

                        <input class="input-md  textinput textInput form-control <?= $isView ? "hidden" : "" ?>"
                               value="<?= $student->first_name; ?>" maxlength="30" name="first_name"
                               placeholder="Choose your username" style="margin-bottom: 10px" type="text" required/>
                        <p class="form-control-static <?= $isView ? "" : "hidden" ?>"><?= $student->first_name; ?></p>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="last_name" class="control-label col-md-4  requiredField"> Last name<span
                                class="asteriskField">*</span> </label>
                    <div class="controls col-md-8 ">
                        <input class="input-md  textinput textInput form-control <?= $isView ? "hidden" : "" ?>" value="<?= $student->last_name; ?>"
                               maxlength="30" name="last_name" placeholder="Choose your username"
                               style="margin-bottom: 10px" type="text" required/>
                        <p class="form-control-static <?= $isView ? "" : "hidden" ?>"><?= $student->last_name; ?></p>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="email" class="control-label col-md-4  requiredField "> E-mail<span class="asteriskField">*</span>
                    </label>
                    <div class="controls col-md-8 ">
                        <input class="input-md emailinput form-control <?= $isView ? "hidden" : "" ?>" value="<?= $student->email; ?>" name="email"
                               placeholder="Email address" style="margin-bottom: 10px" type="email" required/>
                        <p class="form-control-static <?= $isView ? "" : "hidden" ?>"><?= $student->email; ?></p>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="date_of_birth" class="control-label col-md-4  requiredField">Date of birth<span
                                class="asteriskField">*</span> </label>
                    <div class="controls col-md-8 ">
                        <input class="input-md textinput textInput form-control <?= $isView ? "hidden" : "" ?>" value="<?= $student->date_of_birth; ?>"
                               name="date_of_birth" placeholder="Create a password" style="margin-bottom: 10px"
                               type="date" required/>
                        <p class="form-control-static <?= $isView ? "" : "hidden" ?>"><?= $student->date_of_birth; ?></p>
                    </div>
                </div>

                <div class="form-group required">
                    <label for="sex" class="control-label col-md-4  requiredField"> Gender<span
                                class="asteriskField">*</span> </label>
                    <div class="controls col-md-8 " style="margin-bottom: 10px">
                        <div class="<?= $isView ? "hidden" : "" ?>">
                        <label class="radio-inline "> <input type="radio" name="sex"
                                                            value="male" <?php echo ($student->sex == 'male') ? 'checked' : '' ?>
                                                            style="margin-bottom: 10px">Male</label>
                        <label class="radio-inline"> <input type="radio" name="sex"
                                                            value="female" <?php echo ($student->sex == 'female') ? 'checked' : '' ?>
                                                            style="margin-bottom: 10px">Female </label>
                        </div>
                        <p class="form-control-static <?= $isView ? "" : "hidden" ?>"><?= $student->sex; ?></p>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="faculty" class="control-label col-md-4  requiredField"> Group <span
                                class="asteriskField">*</span> </label>
                    <div class="controls col-md-8 ">
                        <input class="input-md textinput textInput form-control <?= $isView ? "hidden" : "" ?>" value="<?= $student->group_name; ?>"
                               name="group_name" placeholder="group name" style="margin-bottom: 10px" type="text"
                               required/>
                        <p class="form-control-static <?= $isView ? "" : "hidden" ?>"><?= $student->group_name; ?></p>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="faculty" class="control-label col-md-4  requiredField"> Faculty <span
                                class="asteriskField">*</span> </label>
                    <div class="controls col-md-8 ">
                        <input class="input-md textinput textInput form-control <?= $isView ? "hidden" : "" ?>" value="<?= $student->faculty_name; ?>"
                               name="faculty_name" placeholder="faculty name" style="margin-bottom: 10px" type="text"
                               required/>
                        <p class="form-control-static <?= $isView ? "" : "hidden" ?>"><?= $student->faculty_name; ?></p>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="aab controls col-md-4 "></div>
                    <div class="controls col-md-8 ">
                        <fieldset about="edit-controls" class="<?= $isView ? "hidden" : "" ?>">
                        <input type="submit" value="Save record" class="btn btn-primary btn btn-info"/>
                        <input type="reset" value="Reset" class="btn btn-primary btn btn-success"/>
                        </fieldset>
                        <fieldset about="view-controls" class="<?= $isView ? "" : "hidden" ?>">
                            <a href="/students/edit/<?= $student->id ?>"  class="btn btn-primary btn btn-info">Edit</a>
                            <a href="/"  class="btn btn-primary btn btn-success">Go to main</a>
                        </fieldset>


                    </div>
                </div>
                <input type="hidden" value="<?= $student->id; ?>" name="id"/>
            </form>


        </div>
    </div>
</div>