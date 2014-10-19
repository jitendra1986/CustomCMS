<h3><?php echo $toolbar_title ?>
    <br>
    <small>Creates and sets up a new Context.</small>
</h3>
<?php if (validation_errors()) : ?>
    <div class="alert alert-error">
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo $toolbar_title ?></div>
    <div class="panel-body">
        <?php echo form_open(current_url(), 'role="form"'); ?>
        <div class="form-group">
            <label class="col-sm-2 control-label">Context Name</label>
            <div class="col-sm-10">
                <input name="context_name" type="text" placeholder="Context Name" value="<?php echo settings_item('context_name'); ?>" class="form-control">
                <span class="help-block m-b-none">Cannot contain spaces.</span>
            </div>
        </div>

        <?php if (isset($roles) && is_array($roles) && count($roles)) : ?>
            <div class="form-group">
                <label class="col-sm-2 control-label">Allow for Roles:</label>
                <div class="col-sm-10">
                    <?php foreach ($roles as $role) : ?>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox" name="roles[]" value="<?php echo $role->role_id ?>" <?php echo set_checkbox('roles[]', $role->role_id) ?> >
                                <span class="fa fa-check"></span><?php echo $role->role_name; ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <button type="submit" name="submit" value="submit" class="btn btn-labeled btn-success">
            <span class="btn-label"><i class="fa fa-check"></i>
            </span>Create It</button>
        <a class="btn btn-warning" href="<?php echo site_url(SITE_AREA . '/developer/builder') ?>">Cancel</a>
        <?php echo form_close(); ?>
    </div>
</div>