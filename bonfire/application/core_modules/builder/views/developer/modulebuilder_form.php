<style>
    .faded {opacity: .60;}
    .faded:hover,.faded.faded-focus,.mb_show_advanced:focus,.mb_show_advanced:hover,.mb_show_advanced_rules:focus,.mb_show_advanced_rules:hover{opacity: 1;color: black;}
    a.mb_show_advanced_rules:hover {text-decoration: none;}
    .body legend{cursor: pointer;}
    .mb_advanced{display: none;}
</style>


<h3><?php echo $toolbar_title ?>
    <br>
    <small><?php e(lang('mb_create_note')) ?></small>
</h3>    


<div class="panel panel-default">
    <div class="panel-heading"><?php echo lang('mb_form_mod_details'); ?></div>
    <div class="panel-body">
        <div class="alert alert-info fade in">
            <a class="close" data-dismiss="alert">&times;</a>
            <?php echo lang('mb_form_note'); ?>
        </div>

        <?php if (!$writeable): ?>
            <div class="alert alert-error fade in">
                <a class="close" data-dismiss="alert">&times;</a>
                <p><?php echo lang('mb_not_writeable_note'); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="top_error"><?php echo $this->session->flashdata('error') ?></div>
        <?php endif; ?>
        <?php echo form_open(current_url(), array('id' => "module_form", 'class' => "form-horizontal", 'role' => "form", 'data-parsley-validate' => '', 'novalidate' => "")); ?>
        <fieldset id="module_details">
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_mod_name'); ?></label>
                <div class="col-sm-10">
                    <input name="module_name" id="module_name" type="text" value="<?php echo set_value("module_name"); ?>" placeholder="<?php echo lang('mb_form_mod_name_ph'); ?>" required class="form-control">
                    <div><a href="#" class="mb_show_advanced small"><?php echo lang('mb_form_show_advanced'); ?></a></div>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_mod_desc'); ?></label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="module_description" id="module_description" rows="5" cols="100"><?php echo set_value("module_description", 'Your module description'); ?></textarea>
                </div>
            </div>

            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_contexts'); ?></label>
                <div class="col-sm-10">
                    <div class="checkbox c-checkbox">
                        <label>
                            <input name="contexts[]" id="contexts_public" type="checkbox" value="public" checked="checked" >
                            <span class="fa fa-check"></span><?php echo lang('mb_form_public'); ?></label>
                    </div>
                    <?php foreach (config_item('contexts') as $context) : ?>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox" name="contexts[]" id="contexts_<?php echo $context; ?>" value="<?php echo $context ?>" >
                                <span class="fa fa-check"></span><?php echo ucwords($context) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_actions'); ?></label>
                <div class="col-sm-10">
                    <?php foreach ($form_action_options as $action => $label): ?>
                        <div class="checkbox c-checkbox">
                            <label>
                                <?php
                                $data = array(
                                    'name' => 'form_action[]',
                                    'id' => 'form_action_' . $action,
                                    'value' => $action,
                                    'checked' => 'checked'
                                );

                                echo form_checkbox($data);
                                ?> 
                                <span class="fa fa-check"></span><?php echo $label; ?>
                            </label> 
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_role_id'); ?></label>
                <div class="col-sm-10">
                    <select name="role_id" id="role_id" class="form-control m-b">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['role_id'] ?>"><?php e($role['role_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label">Database Table</label>
                <div class="col-sm-10">
                    <label class="radio-inline c-radio">
                        <input name="module_db" id="db_no" type="radio" name="i-radio" value="" <?php echo set_checkbox("module_db", "", TRUE); ?>>
                        <span class="fa fa-circle"></span>None</label>
                    <label class="radio-inline c-radio">
                        <input name="module_db" id="db_create" type="radio" name="i-radio" value="new" <?php echo set_checkbox("module_db", "new"); ?>>
                        <span class="fa fa-circle"></span>Create New Table</label>
                    <label class="radio-inline c-radio">
                        <input name="module_db" id="db_exists" type="radio" name="i-radio" value="existing" <?php echo set_checkbox("module_db", "existing"); ?>>
                        <span class="fa fa-circle"></span>Build from Existing Table</label>
                </div>
            </div>

        </fieldset>
        <fieldset id="db_details">
            <h4><?php echo lang('mb_form_table_details'); ?></h4>
            <a href="#" class="mb_show_advanced small"><?php echo lang('mb_form_show_advanced'); ?></a>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_table_name'); ?></label>
                <div class="col-sm-10">
                    <input name="table_name" id="table_name" type="text" value="<?php echo set_value("table_name"); ?>" placeholder="<?php echo lang('mb_form_table_name_ph'); ?>" class="form-control">
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <div class="checkbox c-checkbox">
                        <label>
                            <input name="table_as_field_prefix" id="table_as_field_prefix" type="checkbox" value="<?php echo set_value("table_as_field_prefix", 1); ?>" checked="checked" >
                            <span class="fa fa-check"></span><?php echo lang('mb_form_table_as_field_prefix'); ?></label>
                    </div>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_delims'); ?></label>
                <div class="col-sm-10">
                    <input name="form_input_delimiters" id="form_input_delimiters" type="text" value="<?php echo set_value("form_input_delimiters", "<div class='controls'>,</div>"); ?>" class="form-control">
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_err_delims'); ?></label>
                <div class="col-sm-10">
                    <input name="form_error_delimiters" id="form_error_delimiters" type="text" value="<?php echo set_value("form_error_delimiters", "<span class='error'>,</span>"); ?>" class="form-control">
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_text_ed'); ?></label>
                <div class="col-sm-10">
                    <?php $textarea_editors = array('' => 'None', 'ckeditor' => 'CKEditor', 'xinha' => 'Xinha', 'tinymce' => 'TinyMCE', 'markitup' => 'MarkitUp!'); ?>
                    <select name="textarea_editor" id="textarea_editor" class="form-control m-b">
                        <?php foreach ($textarea_editors as $val => $label): ?>
                            <option value="<?php echo $val ?>"><?php echo $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_soft_deletes'); ?></label>
                <div class="col-sm-10">
                    <?php $truefalse = array('false' => 'False', 'true' => 'True'); ?>
                    <select name="use_soft_deletes" id="use_soft_deletes" class="form-control m-b">
                        <?php foreach ($truefalse as $val => $label): ?>
                            <option value="<?php echo $val ?>"><?php echo $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_use_created'); ?></label>
                <div class="col-sm-10">
                    <select name="use_created" id="use_created" class="form-control m-b">
                        <?php foreach ($truefalse as $val => $label): ?>
                            <option value="<?php echo $val ?>"><?php echo $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_created_field'); ?></label>
                <div class="col-sm-10">
                    <input name="created_field" id="created_field" type="text" value="<?php echo set_value("created_field", "created_on"); ?>" class="form-control">
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_use_modified'); ?></label>
                <div class="col-sm-10">
                    <select name="use_modified" id="use_modified" class="form-control m-b">
                        <?php foreach ($truefalse as $val => $label): ?>
                            <option value="<?php echo $val ?>"><?php echo $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_modified_field'); ?></label>
                <div class="col-sm-10">
                    <input name="modified_field" id="modified_field" type="text" value="<?php echo set_value("modified_field", "modified_on"); ?>" class="form-control">
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_use_status'); ?></label>
                <div class="col-sm-10">
                    <select name="use_status" id="use_status" class="form-control m-b">
                        <?php foreach ($truefalse as $val => $label): ?>
                            <option value="<?php echo $val ?>"><?php echo $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_status_field'); ?></label>
                <div class="col-sm-10">
                    <input name="status_field" id="status_field" type="text" value="<?php echo set_value("status_field", "status"); ?>" class="form-control">
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_use_position'); ?></label>
                <div class="col-sm-10">
                    <select name="use_position" id="use_position" class="form-control m-b">
                        <?php foreach ($truefalse as $val => $label): ?>
                            <option value="<?php echo $val ?>"><?php echo $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group mb_advanced">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_position_field'); ?></label>
                <div class="col-sm-10">
                    <input name="position_field" id="position_field" type="text" value="<?php echo set_value("position_field", "position"); ?>" class="form-control">
                </div>
            </div>
            <div class="alert alert-info fade in mb_new_table">
                <a class="close" data-dismiss="alert">&times;</a>
                <?php echo lang('mb_table_note'); ?>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_primarykey'); ?></label>
                <div class="col-sm-10">
                    <input name="primary_key_field" id="primary_key_field" type="text" value="<?php echo set_value("primary_key_field", (isset($existing_table_fields[0]) && $existing_table_fields[0]['primary_key']) ? $existing_table_fields[0]['name'] : 'ID'); ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('mb_form_fieldnum'); ?></label>
                <div class="col-sm-10">
                    <ul class="pagination" style="margin:0;">
                        <?php
                        $field_num_count = count($field_numbers);
                        for ($ndx = 0; $ndx < $field_num_count; $ndx++):
                            ?>
                            <li <?php
                            if ($field_numbers[$ndx] == $field_total) {
                                echo 'class="active"';
                            }
                            ?>>
                                <a href="<?php echo site_url(SITE_AREA . "/developer/builder/create_module/{$field_numbers[$ndx]}"); ?>">
                                    <?php echo $field_numbers[$ndx]; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
        </fieldset>

        <div id="all_fields">
            <?php for ($count = 1; $count <= $field_total; $count++) : ?>
                <fieldset id="field<?php echo $count; ?>_details">
                    <?php if ($count == 1) : ?>
                        <div class="alert alert-info fade in">
                            <a class="close" data-dismiss="alert">&times;</a>
                            <?php echo lang('mb_field_note'); ?>
                        </div>
                    <?php endif; ?>
                    <h4><?php echo lang('mb_form_field_details'); ?> <?php echo $count; ?></h4>
                    <div class="form-group ">
                        <label class="col-sm-2 control-label"><?php echo lang('mb_form_label'); ?></label>
                        <div class="col-sm-10">
                            <input name="view_field_label<?php echo $count; ?>" id="view_field_label<?php echo $count; ?>" type="text" value="<?php echo set_value("view_field_label{$count}", isset($existing_table_fields[$count]) ? ucwords(str_replace("_", " ", $existing_table_fields[$count]['name'])) : ''); ?>" placeholder="<?php echo lang('mb_form_label_ph'); ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-2 control-label"><?php echo lang('mb_form_fieldname'); ?></label>
                        <div class="col-sm-10">
                            <input name="view_field_name<?php echo $count; ?>" id="view_field_name<?php echo $count; ?>" type="text" value="<?php echo set_value("view_field_name{$count}", isset($existing_table_fields[$count]) ? $existing_table_fields[$count]['name'] : ''); ?>" maxlength="30" placeholder="<?php echo lang('mb_form_fieldname_ph'); ?>" class="form-control">
                        </div>
                    </div>
                    <?php
                    $view_field_types = array(
                        'input' => 'INPUT',
//                        'checkbox' => 'CHECKBOX',
                        'password' => 'PASSWORD',
//                        'radio' => 'RADIO',
                        'select' => 'SELECT',
                        'textarea' => 'TEXTAREA',
                        'ckeditor' => 'CKEDITOR',
                    );
                    ?>
                    <div class="form-group ">
                        <label class="col-sm-2 control-label"><?php echo lang('mb_form_type'); ?></label>
                        <div class="col-sm-10">
                            <select <?php echo 'id="view_field_type' . $count . '" name = "view_field_type' . $count . '"' ?> class="form-control m-b">
                                <?php foreach ($view_field_types as $val => $label): ?>
                                    <option value="<?php echo $val ?>"><?php echo $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php
                    $db_field_types = array(
                        'VARCHAR' => 'VARCHAR',
                        'BIGINT' => 'BIGINT',
                        'BINARY' => 'BINARY',
                        'BIT' => 'BIT',
                        'BLOB' => 'BLOB',
                        'BOOL' => 'BOOL',
                        'CHAR' => 'CHAR',
                        'DATE' => 'DATE',
                        'DATETIME' => 'DATETIME',
                        'DECIMAL' => 'DECIMAL',
                        'DOUBLE' => 'DOUBLE',
                        'ENUM' => 'ENUM',
                        'FLOAT' => 'FLOAT',
                        'INT' => 'INT',
                        'LONGBLOB' => 'LONGBLOB',
                        'LONGTEXT' => 'LONGTEXT',
                        'MEDIUMBLOB' => 'MEDIUMBLOB',
                        'MEDIUMINT' => 'MEDIUMINT',
                        'MEDIUMTEXT' => 'MEDIUMTEXT',
                        'SET' => 'SET',
                        'SMALLINT' => 'SMALLINT',
                        'TEXT' => 'TEXT',
                        'TIME' => 'TIME',
                        'TIMESTAMP' => 'TIMESTAMP',
                        'TINYBLOB' => 'TINYBLOB',
                        'TINYINT' => 'TINYINT',
                        'TINYTEXT' => 'TINYTEXT',
                        'VARBINARY' => 'VARBINARY',
                        'YEAR' => 'YEAR',
                    );
                    ?>
                    <div class="form-group ">
                        <label class="col-sm-2 control-label"><?php echo lang('mb_form_dbtype') ?></label>
                        <div class="col-sm-10">
                            <select <?php echo 'id = "db_field_type' . $count . '" name = "db_field_type' . $count . '"' ?> class="form-control m-b">
                                <?php foreach ($db_field_types as $val => $label): ?>
                                    <option value="<?php echo $val ?>"><?php echo $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('mb_form_length'); ?></label>
                        <div class="col-sm-10">
                            <input name="db_field_length_value<?php echo $count; ?>" id="db_field_length_value<?php echo $count; ?>" type="text" value="<?php echo set_value("db_field_length_value{$count}"); ?>" placeholder="<?php echo lang('mb_form_length_ph'); ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('mb_form_rules'); ?></label>
                        <div class="col-sm-10">
                            <?php foreach ($validation_rules as $validation_rule) : ?>
                                <label class="checkbox-inline c-checkbox">
                                    <input name="validation_rules<?php echo $count; ?>[]" id="validation_rules_<?php echo $validation_rule . $count; ?>" type="checkbox" value="<?php echo $validation_rule; ?>" <?php echo set_checkbox('validation_rules' . $count . '[]', $validation_rule); ?>> 
                                    <span class="fa fa-check"></span><?php echo lang('mb_form_' . $validation_rule); ?>
                                </label>
                            <?php endforeach; ?>
                            <br/>
                            <a class="small mb_show_advanced_rules" href="#">Toggle More Rules</a>
                        </div>

                    </div>
                    <div class="form-group mb_advanced">
                        <label class="col-sm-2 control-label"><?php echo lang('mb_form_rules_limits'); ?></label>
                        <div class="col-sm-10">
                            <?php foreach ($validation_limits as $validation_limit) : ?>
                                <label class="radio-inline c-radio">
                                    <input name="validation_rules<?php echo $count; ?>[]" id="validation_rules_<?php echo $validation_limit . $count; ?>" type="radio" value="<?php echo $validation_limit; ?>" <?php echo set_radio('validation_rules' . $count . '[]', $validation_limit); ?>>
                                    <span class="fa fa-circle"></span><?php echo lang('mb_form_' . $validation_limit); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('grid_form_field_detail'); ?></label>
                        <div class="col-sm-10">
                            <label class="checkbox-inline c-checkbox">
                                <input name="grid_search[]" type="checkbox" value="view_field_name<?php echo $count; ?>">
                                <span class="fa fa-check"></span><?php echo lang('grid_form_search_label'); ?>
                            </label>
                            <label class="checkbox-inline c-checkbox">
                                <input name="grid_sort[]" type="checkbox" value="view_field_name<?php echo $count; ?>">
                                <span class="fa fa-check"></span><?php echo lang('grid_form_sort_label'); ?>
                            </label>
                            <label class="checkbox-inline c-checkbox">
                                <input name="grid_between[]" type="checkbox" value="view_field_name<?php echo $count; ?>">
                                <span class="fa fa-check"></span><?php echo lang('grid_form_between_label'); ?>
                            </label>
                        </div>
                    </div>

                </fieldset>
            <?php endfor; ?>

        </div>

        <div class="form-actions">
            <?php if ($writeable): ?>
                <button type="submit" name="submit" value="submit" class="btn btn-labeled btn-success">
                    <span class="btn-label">
                        <i class="fa fa-check"></i>
                    </span>Build the Module
                </button>
            <?php endif; ?>
        </div>
        <?php echo form_close() ?>
    </div>
</div>