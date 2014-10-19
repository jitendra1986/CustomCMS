<h3><?php echo $toolbar_title ?></h3>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <?php if (isset($backups) && is_array($backups) && count($backups) > 0) : ?>
                <?php echo form_open($this->uri->uri_string(), array('style' => 'padding: 0')); ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th id="cb" class="column-check" style="width: 2em">
                                <input class="check-all" type="checkbox" />
                            </th>
                            <th><?php echo lang('db_filename'); ?></th>
                            <th><?php echo lang('bf_size'); ?></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($backups as $file => $atts) : ?>
                            <tr class="hover-toggle">
                                <td class="column-check">
                                    <input type="checkbox" value="<?php echo $file ?>" name="checked[]" />
                                </td>
                                <td><?php echo $file ?></td>
                                <td><?php echo round($atts['size'] / 1024, 3) ?> KB</td>
                                <td>
                                    <a href="/admin/developer/database/get_backup/<?php echo $file ?>" title="Download this file"><?php echo lang('bf_action_download'); ?></a> |
                                    <a href="/admin/developer/database/restore/<?php echo $file ?>" title="Restore this file"><?php echo lang('db_restore'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <?php echo lang('db_delete_note'); ?>
                                <button type="submit" name="submit" class="btn btn-labeled btn-danger" onclick="return confirm('<?php echo lang('db_backup_delete_confirm'); ?>')">
                                    <span class="btn-label">
                                        <i class="fa fa-times"></i>
                                    </span><?php echo lang('bf_action_delete'); ?>
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                </form>

            <?php else : ?>
                <div class="notification attention">
                    <p><?php echo lang('db_no_backups'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>