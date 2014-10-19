<?php

$view = '<h3>' . $module_name . '<br/><small>' . $module_description . '</small></h3>
<div class="panel panel-default">
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($' . $module_name_lower . ') ) {
    $' . $module_name_lower . ' = (array)$' . $module_name_lower . ';
}
$id = isset($' . $module_name_lower . '[\'' . $primary_key_field . '\']) ? $' . $module_name_lower . '[\'' . $primary_key_field . '\'] : \'\';
';
$view .= '?>';
$view .= '
<div class="panel-body">
    
<?php echo form_open($this->uri->uri_string(), \'class="form-horizontal"\'); ?>';
$on_click = '';
$xinha_names = '';
for ($counter = 1; $field_total >= $counter; $counter++) {
    $maxlength = NULL; // reset this variable
    // only build on fields that have data entered.
    //Due to the requiredif rule if the first field is set the the others must be

    if (set_value("view_field_label$counter") == NULL) {
        continue;   // move onto next iteration of the loop
    }

    $field_label = set_value("view_field_label$counter");
    $tmp_table_as_field_prefix = $this->input->post('table_as_field_prefix');
    $field_name = $db_required == 'new' && $tmp_table_as_field_prefix == 1 ? $module_name_lower . '_' . set_value("view_field_name$counter") : set_value("view_field_name$counter");
    $field_type = set_value("view_field_type$counter");

    $validation_rules = $this->input->post('validation_rules' . $counter);

    $required = '';
    if (is_array($validation_rules)) {
        // rules have been selected for this fieldset

        foreach ($validation_rules as $key => $value) {
            if ($value == 'required') {
                $required = ". lang('bf_form_label_required')"; //' <span class="required">*</span>';
            }
        }
    }

    if ($field_type != 'select') {
        $view .= <<<EOT
        <div class="form-group">
            <?php echo form_label('{$field_label}'{$required}, '{$field_name}', array('class' => "col-sm-2 control-label") ); ?><div class="col-sm-10">
            {$form_input_delimiters[0]}
EOT;
    }

    // field type
    switch ($field_type) {

        // Some consideration has gone into how these should be implemented
        // I came to the conclusion that it should just setup a mere framework
        // and leave helpful comments for the developer
        // Modulebuilder is meant to have a minimium amount of features.
        // It sets up the parts of the form that are repitive then gets the hell out
        // of the way.
        // This approach maintains these aims/goals
        case('ckeditor'):
            $view .= "<?php echo form_textarea( array( 'name' => '$field_name', 'id' => '$field_name', 'rows' => '5', 'cols' => '80', 'value' => set_value('$field_name', isset(\${$module_name_lower}['{$field_name}']) ? \${$module_name_lower}['{$field_name}'] : '') ) )?>";
            $view .= "<?php echo display_ckeditor(array('id' => '$field_name')); ?>";
            $view .= '<span class="help-block m-b-none"><?php echo form_error(\'' . $field_name . '\'); ?></span>';
            $view .= "" . $form_input_delimiters[1];
            break;

        case('textarea'):

            if (!empty($textarea_editor)) {
                // if a date field hasn't been included already then add in the jquery ui files
                if ($textarea_editor == 'xinha') {
                    //
                    if ($xinha_names != '') {
                        $xinha_names .= ', ';
                    }
                    $xinha_names .= '\'' . $field_name . '\'';
                }
            }
            $view .= "
            <?php echo form_textarea( array( 'name' => '$field_name', 'id' => '$field_name', 'rows' => '5', 'cols' => '80', 'value' => set_value('$field_name', isset(\${$module_name_lower}['{$field_name}']) ? \${$module_name_lower}['{$field_name}'] : '') ) )?>";
            $view .= '
            <span class="help-block m-b-none"><?php echo form_error(\'' . $field_name . '\'); ?></span>';
            $view .= "
        " . $form_input_delimiters[1];
            break;

        case('radio'):

            $view .= '
        <label class="checkbox c-checkbox c-checkbox-rounded">
            <input id="' . $field_name . '" name="' . $field_name . '" type="radio" class="" value="option1" <?php echo set_radio(\'' . $field_name . '\', \'option1\', TRUE); ?> />
            <span class="fa fa-check"></span>' . form_label('Radio option 1', $field_name) . '
                </label>
                <label class="checkbox c-checkbox c-checkbox-rounded">
            <input id="' . $field_name . '" name="' . $field_name . '" type="radio" class="" value="option2" <?php echo set_radio(\'' . $field_name . '\', \'option2\'); ?> />
            ' . form_label('Radio option 2', $field_name) . '
            <span class="fa fa-check"></span><?php echo form_error(\'' . $field_name . '\'); ?>
            </label>
        ' . $form_input_delimiters[1] . '

';
            break;

        case('select'):
            // decided to use ci form helper here as I think it makes selects/dropdowns a lot easier
            $select_options = array();
            if (set_value("db_field_length_value$counter") != NULL) {
                $select_options = explode(',', set_value("db_field_length_value$counter"));
            }
            $view .= '

        <?php // Change the values in this array to populate your dropdown as required ?>

';
            $view .= '<?php $options = array(';
            foreach ($select_options as $key => $option) {
                $view .= '
                ' . strip_slashes($option) . ' => ' . strip_slashes($option) . ',';
            }
            $view .= '
); ?>

        <?php echo form_dropdown(\'' . $field_name . '\', $options, set_value(\'' . $field_name . '\', isset($' . $module_name_lower . '[\'' . $field_name . '\']) ? $' . $module_name_lower . '[\'' . $field_name . '\'] : \'\'), \'' . $field_label . '\'' . $required . ')?>';
            break;

        case('checkbox'):

            $view .= <<<EOT
            <div class="checkbox c-checkbox">
            <label>
            <input type="checkbox" id="{$field_name}" name="{$field_name}" value="1" <?php echo (isset(\${$module_name_lower}['{$field_name}']) && \${$module_name_lower}['{$field_name}'] == 1) ? 'checked="checked"' : set_checkbox('{$field_name}', 1); ?>>
            <span class="fa fa-check"></span><?php echo form_error('{$field_name}'); ?>
            </label></div>

        {$form_input_delimiters[1]}
EOT;
            break;

        case('input'):
        case('password'):
        default: // input.. added bit of error detection setting select as default

            if ($field_type == 'input') {
                $type = 'text';
            } else {
                $type = 'password';
            }
            if (set_value("db_field_length_value$counter") != NULL) {
                $maxlength = 'maxlength="' . set_value("db_field_length_value$counter") . '"';
                if (set_value("db_field_type$counter") == 'DECIMAL' || set_value("db_field_type$counter") == 'FLOAT') {
                    list($len, $decimal) = explode(",", set_value("db_field_length_value$counter"));
                    $max = $len;
                    if (isset($decimal) && $decimal != 0) {
                        $max = $len + 1;        // Add 1 to allow for the
                    }
                    $maxlength = 'maxlength="' . $max . '"';
                }
            }
            $db_field_type = set_value("db_field_type$counter");

            $view .= <<<EOT

        <input id="{$field_name}" type="{$type}" class="form-control" name="{$field_name}" {$maxlength} value="<?php echo set_value('{$field_name}', isset(\${$module_name_lower}['{$field_name}']) ? \${$module_name_lower}['{$field_name}'] : ''); ?>"  />
        <span class="help-block m-b-none"><?php echo form_error('{$field_name}'); ?></span>
        {$form_input_delimiters[1]}

EOT;

            break;
    } // end switch
    if ($field_type != 'select') {
        $view .= '

        </div></div> ' . PHP_EOL;
    }
} // end for loop
//Grid Area
/* if ($this->input->post('use_position') == 'true') {
  $tmp_position_field = $this->input->post("position_field");
  $view .= "
  <div class=\"control-group <?php echo form_error('{$tmp_position_field}') ? 'error' : ''; ?>\">
  <?php echo form_label('{$tmp_position_field}', '{$tmp_position_field}', array('class' => \"control-label\") ); ?>
  {$form_input_delimiters[0]}
  <input id=\"{$tmp_position_field}\" type=\"text\" name=\"{$tmp_position_field}\" value=\"<?php echo set_value('{$tmp_position_field}', isset(\${$module_name_lower}['{$tmp_position_field}']) ? \${$module_name_lower}['{$tmp_position_field}'] : ''); ?>\"  />
  <span class=\"help-inline\"><?php echo form_error('{$tmp_position_field}'); ?></span>
  {$form_input_delimiters[1]}
  </div>
  ";
  } */
if ($this->input->post('use_status') == 'true') {
    $tmp_status_field = $this->input->post("status_field");

    $view .= "
        <?php 
        \$options = array(
                1 => 'Active',
                0 => 'Inactive'
        ); ?>
        <?php echo form_dropdown('{$tmp_status_field}', \$options, set_value('{$tmp_status_field}', isset(\${$module_name_lower}['{$tmp_status_field}']) ? \${$module_name_lower}['{$tmp_status_field}'] : ''), 'Status'. lang('bf_form_label_required'))?>
        <span class=\"help-block m-b-none\"><?php echo form_error('{$tmp_status_field}'); ?></span>
        ";
}
//Grid Area Ends

/*
 * <div class="control-group <?php echo form_error('banner_image') ? 'error' : ''; ?>">
  <?php echo form_label('Image'. lang('bf_form_label_required'), 'banner_image', array('class' => "control-label") ); ?>
  <div class='controls'>
  <input id="banner_image" type="file" name="banner_image" maxlength="255" value="<?php echo set_value('banner_image', isset($banner['banner_image']) ? $banner['banner_image'] : ''); ?>"  />
  <span class="help-inline"><?php echo form_error('banner_image'); ?></span>
  </div>


  </div>
 * 
 */

if (!empty($on_click)) {
    $on_click .= '"';
}//end if

$delete = '';

if ($action_name != 'create') {
    $delete_permission = preg_replace("/[ -]/", "_", ucfirst($module_name)) . '.' . ucfirst($controller_name) . '.Delete';

    $delete = PHP_EOL . '
    <?php if ($this->auth->has_permission(\'' . $delete_permission . '\')) : ?>

            or <button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm(\'<?php echo lang(\'' . $module_name_lower . '_delete_confirm\'); ?>\')">
            <i class="icon-trash icon-white">&nbsp;</i>&nbsp;<?php echo lang(\'' . $module_name_lower . '_delete_record\'); ?>
            </button>

    <?php endif; ?>
' . PHP_EOL;
}
if ($action_label == "Edit")
    $action_label = "Update";
$view .= PHP_EOL . '

        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="' . $action_label . ' "' . $on_click . ' />
            or <?php echo anchor(SITE_AREA .\'/' . $controller_name . '/' . $module_name_lower . '\', lang(\'' . $module_name_lower . '_cancel\'), \'class="btn btn-warning"\'); ?>
            ' . $delete . '
        </div>
    <?php echo form_close(); ?>
' . PHP_EOL;



if ($xinha_names != '') {
    $view .= PHP_EOL . '
                <script type="text/javascript">

                var xinha_plugins =
                [
                 \'Linker\'
                ];
                var xinha_editors =
                [
                  ' . $xinha_names . '
                ];

                function xinha_init()
                {
                  if(!Xinha.loadPlugins(xinha_plugins, xinha_init)) return;

                  var xinha_config = new Xinha.Config();

                  xinha_editors = Xinha.makeEditors(xinha_editors, xinha_config, xinha_plugins);

                  Xinha.startEditors(xinha_editors);
                }
                xinha_init();
                </script>' . PHP_EOL;
}

$view .= PHP_EOL . '</div></div>' . PHP_EOL;
echo $view;
?>