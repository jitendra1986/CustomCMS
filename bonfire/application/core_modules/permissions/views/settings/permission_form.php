<?php
// Change the css classes to suit your needs
if (isset($permissions)) {
    $permissions = (array) $permissions;
}
$id = isset($permissions['permission_id']) ? "/" . $permissions['permission_id'] : '';
?>

<h3><?php echo $toolbar_title ?>
    <br/>
    <small><?php echo lang('permissions_details') ?></small>
</h3>

<div class="panel panel-default">
    <div class="panel-body">
        <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('permissions_name') ?><span class="required">*</span></label>
            <div class="col-sm-10">
                <input id="name" type="text" name="name" maxlength="30" value="<?php echo set_value('name', isset($permissions['name']) ? $permissions['name'] : ''); ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('permissions_description') ?></label>
            <div class="col-sm-10">
                <input id="description" type="text" name="description" maxlength="100" value="<?php echo set_value('description', isset($permissions['description']) ? $permissions['description'] : ''); ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('permissions_status') ?><span class="required">*</span></label>
            <div class="col-sm-10">
                <select name="status" id="status" class="form-control m-b">
                    <option value="active" <?php echo set_select('status', lang('permissions_active')) ?>><?php echo lang('permissions_active') ?></option>
                    <option value="inactive" <?php echo set_select('status', lang('permissions_inactive')) ?>><?php echo lang('permissions_inactive') ?></option>
                    <option value="deleted" <?php echo set_select('status', lang('permissions_deleted')) ?>><?php echo lang('permissions_deleted') ?></option>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" name="submit" class="btn btn-primary" value="<?php echo lang('permissions_save'); ?>" />
        </div>

        <?php echo form_close(); ?>
    </div>
</div>