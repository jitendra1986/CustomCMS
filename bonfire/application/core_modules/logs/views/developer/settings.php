<h3><?php echo $toolbar_title ?>
    <br>
    <small><?php echo lang('log_settings') ?></small>
</h3>

<?php if ($log_threshold == 0) : ?>
    <div class="alert alert-warning fade in">
        <a class="close" data-dismiss="alert">&times;</a>				
        <?php echo lang('log_not_enabled'); ?>
    </div>
<?php endif; ?>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="alert alert-info fade in">
            <a class="close" data-dismiss="alert">&times;</a>		
            <?php echo lang('log_big_file_note'); ?>
        </div>
        <?php echo form_open(site_url(SITE_AREA . '/developer/logs/enable'), 'class="form-horizontal"'); ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('log_the_following'); ?></label>
            <div class="col-sm-10">
                <select name="log_threshold" id="log_threshold" class="form-control m-b">
                    <option value="0" <?php echo ($log_threshold == 0) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_0'); ?></option>
                    <option value="1" <?php echo ($log_threshold == 1) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_1'); ?></option>
                    <option value="2" <?php echo ($log_threshold == 2) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_2'); ?></option>
                    <option value="3" <?php echo ($log_threshold == 3) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_3'); ?></option>
                    <option value="4" <?php echo ($log_threshold == 4) ? 'selected="selected"' : ''; ?>><?php echo lang('log_what_4'); ?></option>
                </select>
                <span class="help-block m-b-none"><?php echo lang('log_what_note'); ?></span>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-labeled btn-success">
            <span class="btn-label">
                <i class="fa fa-check"></i>
            </span>
            <?php echo lang('log_save_button'); ?>
        </button>
        <?php echo form_close(); ?>
    </div>
</div>


