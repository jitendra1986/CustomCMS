<h3><?php echo $toolbar_title ?> <?php e(isset($role) ? ': ' . $role->role_name : ''); ?><br/>
    <small><?php echo lang('role_details') ?></small>    
</h3>

<div class="panel panel-default">
    <?php if (validation_errors()) : ?>
        <div class="alert alert-error fade in">
            <a class="close" data-dismiss="alert">&times;</a>
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>
    <div class="panel-body">
        <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('role_name'); ?></label>
            <div class="col-sm-10">
                <input type="text" name="role_name" id="role_name" value="<?php echo set_value('role_name', isset($role) ? $role->role_name : '') ?>" class="form-control">
                <span class="help-block m-b-none"><?php echo form_error('role_name'); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('bf_description'); ?></label>
            <div class="col-sm-10">
                <textarea name="description" id="description" rows="3" class="form-control"><?php echo set_value('description', isset($role) ? $role->description : '') ?></textarea>
                <span class="help-block m-b-none"><?php echo form_error('description') ? form_error('description') : lang('role_max_desc_length'); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('role_default_context') ?></label>
            <div class="col-sm-10">
                <select name="default_context" id="default_context" class="form-control m-b">
                    <?php if (isset($contexts) && is_array($contexts) && count($contexts)): ?>
                        <?php foreach ($contexts as $context): ?>
                            <option value="<?php echo $context; ?>" <?php echo set_select('default_context', $context, (isset($role) && $role->default_context == $context) ? TRUE : FALSE) ?>><?php echo ucfirst($context) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <span class="help-block m-b-none"><?php echo form_error('default_context') ? form_error('default_context') : lang('role_default_context_note'); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('role_default_role') ?></label>
            <div class="col-sm-10">
                <div class="checkbox c-checkbox">
                    <label>
                        <input  type="checkbox" name="default" id="default" value="1" <?php echo set_checkbox('default', 1, isset($role) && $role->default == 1 ? TRUE : FALSE) ?>>
                        <span class="fa fa-check"></span><?php echo lang('role_default_note'); ?>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('role_can_delete_role'); ?>?</label>
            <div class="col-sm-10">
                <label class="radio-inline c-radio">
                    <input type="radio" name="can_delete" id="can_delete_yes" value="1" <?php echo set_radio('can_delete', 1, isset($role) && $role->can_delete == 1 ? TRUE : FALSE) ?>>
                    <span class="fa fa-circle"></span>Yes
                </label>
                <label class="radio-inline c-radio">
                    <input type="radio" name="can_delete" id="can_delete_no" value="0" <?php echo set_radio('can_delete', 0, isset($role) && $role->can_delete == 0 ? TRUE : FALSE) ?>>
                    <span class="fa fa-circle"></span>No
                </label>
                <span class="help-block m-b-none"><?php echo lang('role_can_delete_note'); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <input type="text" class="form-control">
                <span class="help-block m-b-none"></span>
            </div>
        </div>




        <!-- Permissions -->
        <?php if (has_permission('Bonfire.Permissions.Manage')) : ?>
            <fieldset>
                <legend><?php echo lang('role_permissions'); ?></legend>
                <br/>
                <p class="intro"><?php echo lang('role_permissions_check_note'); ?></p>

                <?php echo modules::run('roles/settings/matrix'); ?>

            </fieldset>
        <?php endif; ?>

        <div class="form-actions">
            <input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('role_save_role'); ?>" /> or <?php echo anchor(SITE_AREA . '/settings/roles', lang('bf_action_cancel'),'class="btn btn-warning"'); ?>
            <?php if (isset($role) && $role->can_delete == 1 && has_permission('Bonfire.Roles.Delete')): ?>
                <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('<?php echo lang('role_delete_confirm') . ' ' . lang('role_delete_note') ?>')"><i class="icon-trash icon-white">&nbsp;</i>&nbsp;<?php echo lang('role_delete_role'); ?></button>
            <?php endif; ?>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>
