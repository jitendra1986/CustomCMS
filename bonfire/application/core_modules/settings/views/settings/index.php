<h3><?php echo $toolbar_title ?></h3>
<div class="panel panel-default">

    <?php if (validation_errors()) : ?>
        <div class="alert alert-block alert-error fade in">
            <a class="close" data-dismiss="alert">&times;</a>
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>
    <div class="panel-body">

        <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>

        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#main-settings" data-toggle="tab">Main Settings</a>
                </li>
                <li>
                    <a href="#security" data-toggle="tab">Security Settings</a>
                </li>

                <?php if (has_permission('Site.Developer.View')) : ?>
                    <li>
                        <a href="#developer" data-toggle="tab">Developer Settings</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">

                <!-- Start of Main Settings Tab Pane -->
                <div class="tab-pane active" id="main-settings">
                    <legend><?php echo lang('bf_site_information') ?></legend>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_site_name') ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="title" id="title" value="<?php echo set_value('site.title', isset($settings['site.title']) ? $settings['site.title'] : '') ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_site_email') ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="system_email" id="system_email" value="<?php echo set_value('site.system_email', isset($settings['site.system_email']) ? $settings['site.system_email'] : '') ?>" class="form-control">
                            <span class="help-block m-b-none"><?php echo lang('bf_site_email_help') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_site_status') ?></label>
                        <div class="col-sm-10">
                            <select name="status" id="status" class="form-control m-b">
                                <option value="1" <?php echo isset($settings) && $settings['site.status'] == 1 ? 'selected="selected"' : set_select('site.status', '1') ?>><?php echo lang('bf_online') ?></option>
                                <option value="0" <?php echo isset($settings) && $settings['site.status'] == 0 ? 'selected="selected"' : set_select('site.status', '1') ?>><?php echo lang('bf_offline') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_top_number') ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="list_limit" id="list_limit" value="<?php echo set_value('list_limit', isset($settings['site.list_limit']) ? $settings['site.list_limit'] : '') ?>" class="form-control">
                            <span class="help-block m-b-none"><?php echo lang('bf_top_number_help') ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_language') ?></label>
                        <div class="col-sm-10">
                            <select name="languages[]" id="languages" multiple="multiple" class="form-control">
                                <?php if (is_array($languages) && count($languages)): ?>
                                    <?php foreach ($languages as $language): ?>
                                        <?php $selected = in_array($language, $selected_languages) ? TRUE : FALSE; ?>
                                        <option value="<?php e($language); ?>" <?php echo set_select('languages', $language, $selected) ?>><?php e(ucfirst($language)) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <span class="help-block m-b-none"><?php echo lang('bf_language_help') ?></span>
                        </div>
                    </div>
                </div>
                <!-- Start of Security Settings Tab Pane -->
                <div class="tab-pane" id="security">
                    <legend><?php echo lang('bf_security') ?></legend>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="checkbox c-checkbox">
                                <label>
                                    <input type="checkbox" name="allow_register" id="allow_register" value="1" <?php echo $settings['auth.allow_register'] == 1 ? 'checked="checked"' : set_checkbox('auth.allow_register', 1); ?>>
                                    <span class="fa fa-check"></span><?php echo lang('bf_allow_register') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_activate_method') ?></label>
                        <div class="col-sm-10">
                            <select name="user_activation_method" id="user_activation_method" class="form-control m-b">
                                <option value="0" <?php echo $settings['auth.user_activation_method'] == 0 ? 'selected="selected"' : ''; ?>><?php echo lang('bf_activate_none') ?></option>
                                <option value="1" <?php echo $settings['auth.user_activation_method'] == 1 ? 'selected="selected"' : ''; ?>><?php echo lang('bf_activate_email') ?></option>
                                <option value="2" <?php echo $settings['auth.user_activation_method'] == 2 ? 'selected="selected"' : ''; ?>><?php echo lang('bf_activate_admin') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_login_type') ?></label>
                        <div class="col-sm-10">
                            <select name="login_type" id="login_type" class="form-control m-b">
                                <option value="email" <?php echo $settings['auth.login_type'] == 'email' ? 'selected="selected"' : ''; ?>><?php echo lang('bf_login_type_email') ?></option>
                                <option value="username" <?php echo $settings['auth.login_type'] == 'username' ? 'selected="selected"' : ''; ?>><?php echo lang('bf_login_type_username') ?></option>
                                <option value="both" <?php echo $settings['auth.login_type'] == 'both' ? 'selected="selected"' : ''; ?>><?php echo lang('bf_login_type_both') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_use_usernames') ?></label>
                        <div class="col-sm-10">
                            <label class="radio-inline c-radio">
                                <input type="radio" id="use_username" name="use_usernames" value="1" <?php echo $settings['auth.use_usernames'] == 1 ? 'checked="checked"' : set_radio('auth.use_usernames', 1); ?>>
                                <span class="fa fa-circle"></span><?php echo lang('bf_username') ?>
                            </label>
                            <label class="radio-inline c-radio">
                                <input type="radio" id="use_email" name="use_usernames" value="0" <?php echo $settings['auth.use_usernames'] == 0 ? 'checked="checked"' : set_radio('auth.use_usernames', 0); ?>>
                                <span class="fa fa-circle"></span><?php echo lang('bf_email') ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_display_name'); ?></label>
                        <div class="col-sm-10">
                            <div class="checkbox c-checkbox">
                                <label>
                                    <input type="checkbox" name="allow_name_change" id="allow_name_change" <?php echo isset($settings['auth.allow_name_change']) && $settings['auth.allow_name_change'] == 1 ? 'checked="checked"' : set_checkbox('auth.allow_remember', 1); ?>>
                                    <span class="fa fa-check"></span><?php echo lang('set_allow_name_change_note'); ?>
                                </label>
                            </div>
                            <input type="hidden" name="name_change_frequency" value="<?php echo $settings['auth.name_change_frequency'] ?>">
                            <input type="hidden" name="name_change_limit" value="<?php echo $settings['auth.name_change_limit'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <div class="checkbox c-checkbox">
                                <label>
                                    <input type="checkbox" name="allow_remember" id="allow_remember" value="1" <?php echo $settings['auth.allow_remember'] == 1 ? 'checked="checked"' : set_checkbox('auth.allow_remember', 1); ?>>
                                    <span class="fa fa-check"></span><?php echo lang('bf_allow_remember') ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_remember_time') ?></label>
                        <div class="col-sm-10">
                            <select name="remember_length" id="remember_length" class="form-control m-b">
                                <option value="604800"  <?php echo $settings['auth.remember_length'] == '604800' ? 'selected="selected"' : '' ?>>1 <?php echo lang('bf_week') ?></option>
                                <option value="1209600" <?php echo $settings['auth.remember_length'] == '1209600' ? 'selected="selected"' : '' ?>>2 <?php echo lang('bf_weeks') ?></option>
                                <option value="1814400" <?php echo $settings['auth.remember_length'] == '1814400' ? 'selected="selected"' : '' ?>>3 <?php echo lang('bf_weeks') ?></option>
                                <option value="2592000" <?php echo $settings['auth.remember_length'] == '2592000' ? 'selected="selected"' : '' ?>>30 <?php echo lang('bf_days') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo lang('bf_password_strength') ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="password_min_length" id="password_min_length" value="<?php echo set_value('password_min_length', isset($settings['auth.password_min_length']) ? $settings['auth.password_min_length'] : '') ?>" class="form-control">
                            <span class="help-block m-b-none"><?php echo lang('bf_password_length_help') ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Password Options</label>
                        <div class="col-sm-10">
                            <div class="checkbox c-checkbox">
                                <label>
                                    <input type="checkbox" name="password_force_numbers" id="password_force_numbers" value="1" <?php echo set_checkbox('password_force_numbers', 1, isset($settings['auth.password_force_numbers']) && $settings['auth.password_force_numbers'] == 1 ? TRUE : FALSE); ?> />
                                    <span class="fa fa-check"></span><?php echo lang('bf_password_force_numbers') ?>
                                </label>
                            </div>
                            <div class="checkbox c-checkbox">
                                <label>
                                    <input type="checkbox" name="password_force_symbols" id="password_force_symbols" value="1" <?php echo set_checkbox('password_force_symbols', 1, isset($settings['auth.password_force_symbols']) && $settings['auth.password_force_symbols'] == 1 ? TRUE : FALSE); ?> />
                                    <span class="fa fa-check"></span><?php echo lang('bf_password_force_symbols') ?>
                                </label>
                            </div>
                            <div class="checkbox c-checkbox">
                                <label>
                                    <input type="checkbox" name="password_force_mixed_case" id="password_force_mixed_case" value="1" <?php echo set_checkbox('password_force_mixed_case', 1, isset($settings['auth.password_force_mixed_case']) && $settings['auth.password_force_mixed_case'] == 1 ? TRUE : FALSE); ?> />
                                    <span class="fa fa-check"></span><?php echo lang('bf_password_force_mixed_case') ?>
                                </label>
                            </div>
                            <div class="checkbox c-checkbox">
                                <label>
                                    <input type="checkbox" name="password_show_labels" id="password_show_labels" value="1" <?php echo set_checkbox('password_show_labels', 1, isset($settings['auth.password_show_labels']) && $settings['auth.password_show_labels'] == 1 ? TRUE : FALSE); ?> />
                                    <span class="fa fa-check"></span><?php echo lang('bf_password_show_labels') ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (has_permission('Site.Developer.View')) : ?>
                    <div class="tab-pane" id="developer">
                        <legend>Developer</legend>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Developer Option</label>
                            <div class="col-sm-10">
                                <div class="checkbox c-checkbox">
                                    <label>
                                        <input type="checkbox" name="show_profiler" id="show_profiler" value="1" <?php echo $settings['site.show_profiler'] == 1 ? 'checked="checked"' : set_checkbox('auth.use_extended_profile', 1); ?> />
                                        <span class="fa fa-check"></span><?php echo lang('bf_show_profiler') ?>
                                    </label>
                                </div>
                                <div class="checkbox c-checkbox">
                                    <label>
                                        <input type="checkbox" name="show_front_profiler" id="show_front_profiler" value="1" <?php echo $settings['site.show_front_profiler'] == 1 ? 'checked="checked"' : set_checkbox('site.show_front_profiler', 1); ?> />
                                        <span class="fa fa-check"></span><?php echo lang('bf_show_front_profiler') ?>
                                    </label>
                                </div>
                                <div class="checkbox c-checkbox">
                                    <label>
                                        <input type="checkbox" name="do_check" id="do_check" value="1" <?php echo $settings['updates.do_check'] == 1 ? 'checked="checked"' : set_checkbox('updates.do_check', 1); ?> />
                                        <span class="fa fa-check"></span><?php echo lang('bf_do_check') ?>
                                    </label>
                                    <span class="help-block m-b-none"><?php echo lang('bf_do_check_edge') ?></span>
                                </div>
                                <div class="checkbox c-checkbox">
                                    <label>
                                        <input type="checkbox" name="bleeding_edge" id="bleeding_edge" value="1" <?php echo $settings['updates.bleeding_edge'] == 1 ? 'checked="checked"' : set_checkbox('updates.bleeding_edge', 1); ?> />
                                        <span class="fa fa-check"></span><?php echo lang('bf_update_show_edge') ?>
                                    </label>
                                    <span class="help-block m-b-none"><?php echo lang('bf_update_info_edge') ?></span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End of Developer Tab Options Pane -->
                <?php endif; ?>
            </div>
        </div>
        <div class="form-actions" style="margin-top: 10px;">
            <input type="submit" name="submit" class="btn btn-primary" value="<?php echo lang('bf_action_save') . ' ' . lang('bf_context_settings') ?>" />
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


