<h3><?php echo $toolbar_title ?></h3>
<?php echo form_open(SITE_AREA . '/settings/emailer', 'class="form-horizontal"'); ?>
<div class="panel panel-default">
    <div class="panel-heading">General Settings</div>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('em_system_email'); ?></label>
            <div class="col-sm-10">
                <input type="email" name="sender_email" id="sender_email" value="<?php echo set_value('sender_email', isset($sender_email) ? $sender_email : '') ?>" class="form-control">
                <span class="help-block m-b-none"><?php echo lang('em_system_email_note'); ?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('em_email_type'); ?></label>
            <div class="col-sm-10">
                <select name="mailtype" id="mailtype" class="form-control m-b">
                    <option value="text" <?php echo isset($mailtype) && $mailtype == 'text' ? 'selected="selected"' : ''; ?>>Text</option>
                    <option value="html" <?php echo isset($mailtype) && $mailtype == 'html' ? 'selected="selected"' : ''; ?>>HTML</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('em_email_server'); ?></label>
            <div class="col-sm-10">
                <select name="protocol" id="server_type" class="form-control m-b">
                    <option <?php echo set_select('protocol', 'mail', isset($protocol) && $protocol == 'mail' ? TRUE : FALSE); ?>>mail</option>
                    <option <?php echo set_select('protocol', 'sendmail', isset($protocol) && $protocol == 'sendmail' ? TRUE : FALSE); ?>>sendmail</option>
                    <option value="smtp" <?php echo set_select('protocol', 'smtp', isset($protocol) && $protocol == 'smtp' ? TRUE : FALSE); ?>>SMTP</option>
                </select>
                <span class="help-block m-b-none"><?php echo form_error('protocol'); ?></span>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo lang('em_settings'); ?></div>
    <div class="panel-body">
        <div class="form-group" id="mail">
            <label class="col-sm-12 control-label"><?php echo lang('em_settings_note'); ?></label>
        </div>

        <div class="form-group " id="sendmail">
            <label class="col-sm-2 control-label">Sendmail <?php echo lang('em_location'); ?></label>
            <div class="col-sm-10">
                <input type="text" name="mailpath" id="mailpath" value=" <?php echo set_value('mailpath', isset($mailpath) ? $mailpath : '/usr/sbin/sendmail') ?>" class="form-control">
                <span class="help-block m-b-none"><?php echo form_error('mailpath'); ?></span>
            </div>
        </div>
        <div  id="smtp">
            <div class="form-group">
                <label class="col-sm-2 control-label">SMTP <?php echo lang('em_server_address'); ?></label>
                <div class="col-sm-10">
                    <input type="text" name="smtp_host" id="smtp_host" value=" <?php echo set_value('smtp_host', isset($smtp_host) ? $smtp_host : '') ?>" class="form-control">
                    <span class="help-block m-b-none"><?php echo form_error('smtp_host'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">SMTP <?php echo lang('bf_username'); ?></label>
                <div class="col-sm-10">
                    <input  type="text" name="smtp_user" id="smtp_user" value=" <?php echo set_value('smtp_user', isset($smtp_user) ? $smtp_user : '') ?>" class="form-control">
                    <span class="help-block m-b-none"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">SMTP <?php echo lang('bf_password'); ?></label>
                <div class="col-sm-10">
                    <input type="password" name="smtp_pass" id="smtp_pass" value=" <?php echo set_value('smtp_pass', isset($smtp_pass) ? $smtp_pass : '') ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">SMTP <?php echo lang('em_port'); ?></label>
                <div class="col-sm-10">
                    <input type="text" name="smtp_port" id="smtp_port" value=" <?php echo set_value('smtp_port', isset($smtp_port) ? $smtp_port : 25) ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">SMTP <?php echo lang('em_timeout_secs'); ?></label>
                <div class="col-sm-10">
                    <input type="text" name="smtp_timeout" id="smtp_timeout" value=" <?php echo set_value('smtp_timeout', isset($smtp_timeout) ? $smtp_timeout : '') ?>" class="form-control">
                </div>
            </div>
        </div>

    </div>
</div>

<?php echo form_close(); ?>
<h3><?php echo lang('em_test_header'); ?>
    <br/>
    <small><?php echo lang('em_test_intro'); ?></small></h3>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo lang('em_test_settings') ?></div>
    <div class="panel-body">
        <?php echo form_open(SITE_AREA . '/settings/emailer/test', array('class' => 'form-horizontal', 'id' => 'test-form')); ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('bf_email'); ?></label>
            <div class="col-sm-10">
                <input type="email" name="email" id="test-email" value=" <?php echo set_value('test_email', settings_item('site.system_email')) ?>" class="form-control">
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" name="submit" class="btn btn-primary" value="<?php echo lang('em_test_button'); ?>" />
        </div>
        <div id="test-ajax"></div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- Test Settings -->