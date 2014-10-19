<?php if (!$writeable): ?>
    <div class="alert alert-error">
        <p><?php echo lang('mb_not_writeable_note'); ?></p>
    </div>
<?php endif; ?>
<h3><?php echo lang('mb_exist_modules') ?></h3>
<div class="panel panel-default">
    <?php if (isset($modules) && is_array($modules) && count($modules)) : ?>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo lang('mb_table_name'); ?></th>
                            <th><?php echo lang('mb_table_version'); ?></th>
                            <th><?php echo lang('mb_table_description'); ?></th>
                            <th><?php echo lang('mb_table_author'); ?></th>
                            <th><?php echo lang('bf_actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($modules as $module => $config) : ?>
                            <tr>
                                <td><?php echo $config['name'] ?></td>
                                <td><?php e(isset($config['version']) ? $config['version'] : '---'); ?></td>
                                <td><?php e(isset($config['description']) ? $config['description'] : '---'); ?></td>
                                <td><?php e(isset($config['author']) ? $config['author'] : '---'); ?></td>
                                <td>
                                    <?php echo form_open(SITE_AREA . '/developer/builder/delete'); ?>
                                    <input type="hidden" name="module" value="<?php echo preg_replace("/[ -]/", "_", $config['name']); ?>">
                                    <button type="submit" class="btn btn-labeled btn-danger" onclick="return confirm('Really delete this module and all of its files?');">
                                        <span class="btn-label">
                                            <i class="fa fa-times"></i>
                                        </span>
                                        <?php echo lang('bf_action_delete') ?>
                                    </button>

                                    <?php echo form_close(); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="panel-body">
            <div class="table-responsive">
                <div class="alert alert-warning">
                    <p><?php e(lang('mb_no_modules')); ?> <a href="<?php echo site_url(SITE_AREA . '/developer/builder/create_module') ?>"><?php e(lang('mb_create_link')); ?></a></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>


