<h3><?php echo lang('activity_filter_head'); ?></h3>	
<div class="panel panel-default">
    <div class="panel-body">
        <?php
        echo form_open(SITE_AREA . '/reports/activities/' . $vars['which'], 'class="form-horizontal constrained ajax-form"');

        $form_help = '<span class="help-inline">' . sprintf(lang('activity_filter_note'), ($vars['view_which'] == ucwords(lang('activity_date')) ? 'from before' : 'only for'), strtolower($vars['view_which'])) . '</span>';
        $form_data = array('name' => $vars['which'] . '_select', 'id' => $vars['which'] . '_select', 'class' => 'form-control m-b');
        echo form_dropdown($form_data, $select_options, $filter, lang('activity_filter_head'), '', $form_help);
        //echo form_dropdown("activity_select", $select_options, $filter,array('id' => 'activity_select', 'class' => 'span4' ) );
        unset($form_data, $form_help);
        ?>
        <div class="form-actions">
            <?php echo form_submit('filter', lang('activity_filter'), 'class="btn btn-primary"'); ?>
            <?php if ($vars['which'] == 'activity_own' && has_permission('Activities.Own.Delete')): ?>
                <button type="submit" name="delete" class="btn btn-labeled btn-danger" id="delete-activity_own"><span class="btn-label"><i class="fa fa-times"></i></span><?php echo lang('activity_own_delete'); ?></button>
            <?php elseif ($vars['which'] == 'activity_user' && has_permission('Activities.User.Delete')): ?>
                <button type="submit" name="delete" class="btn btn-labeled btn-danger" id="delete-activity_user"><span class="btn-label"><i class="fa fa-times"></i></span><?php echo lang('activity_user_delete'); ?></button>
            <?php elseif ($vars['which'] == 'activity_module' && has_permission('Activities.Module.Delete')): ?>
                <button type="submit" name="delete" class="btn btn-labeled btn-danger" id="delete-activity_module"><span class="btn-label"><i class="fa fa-times"></i></span><?php echo lang('activity_module_delete'); ?></button>
            <?php elseif ($vars['which'] == 'activity_date' && has_permission('Activities.Date.Delete')): ?>
                <button type="submit" name="delete" class="btn btn-labeled btn-danger" id="delete-activity_date"><span class="btn-label"><i class="fa fa-times"></i></span><?php echo lang('activity_date_delete'); ?></button>
            <?php endif; ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<h3><?php echo sprintf(lang('activity_view'), ($vars['view_which'] == ucwords(lang('activity_date')) ? $vars['view_which'] . ' before' : $vars['view_which']), $vars['name']); ?></h3>

<?php if (!isset($activity_content) || empty($activity_content)) : ?>
    <div class="alert alert-error fade in">
        <a class="close" data-dismiss="alert">&times;</a>
        <h4 class="alert-heading"><?php echo lang('activity_not_found'); ?></h4>
    </div>
<?php else : ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped" id="flex_table">
                    <thead>
                        <tr>
                            <th><?php echo lang('activity_user'); ?></th>
                            <th><?php echo lang('activity_activity'); ?></th>
                            <th><?php echo lang('activity_module'); ?></th>
                            <th><?php echo lang('activity_when'); ?></th>
                        </tr>
                    </thead>

                    <tfoot></tfoot>

                    <tbody>
                        <?php foreach ($activity_content as $activity) : ?>
                            <tr>
                                <td><i class="icon-user">&nbsp;</i>&nbsp;<?php e($activity->username); ?></td>
                                <td><?php echo $activity->activity; ?></td>
                                <td><?php echo $activity->module; ?></td>
                                <td><?php echo date('M j, Y g:i A', strtotime($activity->created)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
<?php endif; ?>
