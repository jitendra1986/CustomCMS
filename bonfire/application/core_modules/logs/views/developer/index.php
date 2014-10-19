<h3><?php echo $toolbar_title ?>
    <br>
    <small><?php e(lang('log_intro')) ?></small>
</h3>
<?php if ($log_threshold == 0) : ?>
    <div class="alert alert-warning fade in">
        <a class="close" data-dismiss="alert">&times;</a>
        <?php e(lang('log_not_enabled')); ?>
    </div>
<?php endif; ?>

<?php if (isset($logs) && is_array($logs) && count($logs) && count($logs) > 1) : ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <?php echo form_open(); ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="column-check"><input class="check-all" type="checkbox" /></th>
                            <th style="width: 15em;"><?php e(lang('log_date')) ?></th>
                            <th><?php e(lang('log_file')) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log) : ?>
                            <?php if ($log != 'index.html') : ?>
                                <tr>
                                    <td class="column-check">
                                        <input type="checkbox" value="<?php e($log) ?>" name="checked[]" />
                                    </td>
                                    <td>
                                        <a href="<?php e(site_url(SITE_AREA . '/developer/logs/view/' . $log)) ?>">
                                            <b><?php e(date('F j, Y', strtotime(str_replace('.php', '', str_replace('log-', '', $log))))); ?></b>
                                        </a>
                                    </td>
                                    <td><?php e($log) ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <?php echo lang('bf_with_selected'); ?>:
                                <button type="submit" name="action_delete" id="delete-me" class="btn btn-labeled btn-danger" onclick="return confirm('<?php echo lang('logs_delete_confirm'); ?>')">
                                    <span class="btn-label">
                                        <i class="fa fa-times"></i>
                                    </span>
                                    <?php echo lang('bf_action_delete') ?>
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <?php echo form_close(); ?>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
    <h3><?php echo lang('log_delete_button'); ?></h3>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open(); ?>
            <div class="alert alert-info alert-dismissable">
                <a class="close" data-dismiss="alert">&times;</a>
                <?php echo lang('log_delete_note'); ?>
            </div>

            <div class="form-actions">
                <button type="submit" name="action_delete_all" class="btn btn-labeled btn-danger" onclick="return confirm('Are you sure you want to delete all log files?')">
                    <span class="btn-label">
                        <i class="fa fa-times"></i>
                    </span>
                    <?php echo lang('log_delete_button'); ?>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
<?php else : ?>
    <div class="alert alert-info fade in notification ">
        <a class="close" data-dismiss="alert">&times;</a>
        <p><?php echo lang('log_no_logs'); ?></p>
    </div>
<?php endif; ?>



