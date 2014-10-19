<?php foreach ($meta_fields as $field): ?>
    <?php if ((isset($field['admin_only']) && $field['admin_only'] === TRUE && isset($current_user) && $current_user->role_id == 1) || !isset($field['admin_only']) || $field['admin_only'] === FALSE):
        ?>
        <?php if (!isset($frontend_only) || ($frontend_only === TRUE && (!isset($field['frontend']) || $field['frontend'] === TRUE))): ?>
            <?php if ($field['form_detail']['type'] == 'dropdown'): ?>
                <?php echo form_dropdown($field['form_detail']['settings'], $field['form_detail']['options'], set_value($field['name'], isset($user->$field['name']) ? $user->$field['name'] : ''), $field['label']); ?>
            <?php elseif ($field['form_detail']['type'] == 'checkbox'): ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $field['label']; ?></label>
                    <div class="col-sm-10">
                        <?php
                        $form_method = 'form_' . $field['form_detail']['type'];
                        $checked = (isset($user->$field['name']) && $field['form_detail']['value'] == set_value($field['name'], isset($user->$field['name']) ? $user->$field['name'] : '')) ? TRUE : FALSE;
                        echo form_checkbox($field['form_detail']['settings'], $field['form_detail']['value'], $checked);
                        ?>
                    </div>
                </div>

            <?php elseif ($field['form_detail']['type'] == 'state_select' && is_callable('state_select')) : ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo lang('user_meta_state'); ?></label>
                    <div class="col-sm-10">
                        <?php echo state_select(set_value($field['name'], isset($user->$field['name']) ? $user->$field['name'] : 'SC'), 'SC', 'US', $field['name'], 'form-control m-b'); ?>
                    </div>
                </div>

            <?php elseif ($field['form_detail']['type'] == 'country_select' && is_callable('country_select')) : ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo lang('user_meta_country'); ?></label>
                    <div class="col-sm-10">
                        <?php echo country_select(set_value($field['name'], isset($user->$field['name']) ? $user->$field['name'] : 'US'), 'US', 'country', 'form-control m-b'); ?>
                    </div>
                </div>
                <?php
            else:


                $form_method = 'form_' . $field['form_detail']['type'];
                if (is_callable($form_method)) {
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $field['label'] ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="street_name" value="" id="street_name" maxlength="100" class="form-control">
                        </div>
                    </div>
                    <?php
                }


            endif;
        endif;
        ?>
    <?php endif; ?>
<?php endforeach; ?>
