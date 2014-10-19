<?php if (isset($user) && $user->banned) : ?>
    <div class="alert alert-warning fade in">
        <h4 class="alert-heading"><?php echo lang('us_banned_admin_note'); ?></h4>
    </div>
<?php endif; ?>



<h3><?php echo $toolbar_title ?>
    <br>
    <small><?php echo lang('us_account_details') ?></small>
</h3>

<div class="panel panel-default">
    <div class="panel-body">

        <div class="alert alert-info fade in">
            <a data-dismiss="alert" class="close alert-heading">&times;</a>
            <?php echo lang('bf_required_note'); ?>
            <?php if (isset($password_hints)) echo $password_hints; ?>
        </div>

        <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal" autocomplete="off"'); ?>

        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('bf_email') ?></label>
            <div class="col-sm-10">
                <input type="email" name="email" id="email" value="<?php echo set_value('email', isset($user) ? $user->email : '') ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('bf_username') ?></label>
            <div class="col-sm-10">
                <input type="text" name="username" id="username" value="<?php echo set_value('username', isset($user) ? $user->username : '') ?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('bf_display_name') ?></label>
            <div class="col-sm-10">
                <input type="text" name="display_name" id="display_name" value="<?php echo set_value('display_name', isset($user) ? $user->display_name : '') ?>" class="form-control">
            </div>
        </div><div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('bf_password') ?></label>
            <div class="col-sm-10">
                <input type="password" id="password" name="password" value="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('bf_password_confirm') ?></label>
            <div class="col-sm-10">
                <input type="password" name="pass_confirm" id="pass_confirm" value="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('bf_language') ?></label>
            <div class="col-sm-10">
                <select name="language" id="language" class="form-control m-b">
                    <?php if (isset($languages) && is_array($languages) && count($languages)) : ?>
                        <?php foreach ($languages as $language) : ?>
                            <option value="<?php e($language) ?>" <?php echo set_select('language', $language, isset($user->language) && $user->language == $language ? TRUE : FALSE) ?>>
                                <?php e(ucfirst($language)) ?>
                            </option>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('bf_timezone') ?></label>
            <div class="col-sm-10">
                <?php echo timezone_menu(set_value('timezones', isset($user) ? $user->timezone : $current_user->timezone)); ?>
            </div>
        </div>
        <?php if (isset($user) && has_permission('Bonfire.Roles.Manage') && has_permission('Permissions.' . $user->role_name . '.Manage') && isset($roles)) : ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('us_role'); ?></label>
                <div class="col-sm-10">
                    <select name="role_id" id="role_id" class="form-control m-b">
                        <?php if (isset($roles) && is_array($roles) && count($roles)) : ?>
                            <?php foreach ($roles as $role) : ?>

                                <?php if (has_permission('Permissions.' . ucfirst($role->role_name) . '.Manage')) : ?>
                                    <?php
                                    // check if it should be the default
                                    $default_role = FALSE;
                                    if ((isset($user) && $user->role_id == $role->role_id) || (!isset($user) && $role->default == 1)) {
                                        $default_role = TRUE;
                                    }
                                    ?>
                                    <option value="<?php echo $role->role_id ?>" <?php echo set_select('role_id', $role->role_id, $default_role) ?>>
                                        <?php e(ucfirst($role->role_name)) ?>
                                    </option>

                                <?php endif; ?>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>

        <?php Events::trigger('render_user_form'); ?>

        <?php $this->load->view('users/user_meta'); ?>

        <?php if (isset($user) && has_permission('Permissions.' . ucfirst($user->role_name) . '.Manage') && $user->id != $this->auth->user_id() && ($user->banned || $user->deleted)) : ?>

            <?php
            $field = 'activate';
            if ($user->active) : $field = 'de' . $field;
            endif;
            ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('us_account_status') ?></label>
                <div class="col-sm-10">
                    <div class="checkbox c-checkbox">
                        <label>
                            <input type="checkbox" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="1">
                            <span class="fa fa-check"></span> <?php echo lang('us_' . $field . '_note') ?></label>
                    </div>
                    <?php if ($user->deleted) : ?>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox" name="restore" id="restore" value="1">
                                <span class="fa fa-check"></span>  <?php echo lang('us_restore_note') ?></label>
                        </div>
                    <?php elseif ($user->banned) : ?>
                        <div class="checkbox c-checkbox">
                            <label>
                                <input type="checkbox" name="unban" id="unban" value="1">
                                <span class="fa fa-check"></span> <?php echo lang('us_unban_note') ?></label>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="form-actions">
            <input type="submit" name="submit" class="btn btn-primary" value="<?php echo lang('bf_action_save') . ' ' . lang('bf_user') ?> " /> <?php echo lang('bf_or') ?>
            <?php echo anchor(SITE_AREA . '/settings/users', '<i class="icon-refresh icon-white">&nbsp;</i>&nbsp;' . lang('bf_action_cancel'), 'class="btn btn-warning"'); ?>
        </div>
        <?php echo form_close(); ?>

    </div>
</div>

