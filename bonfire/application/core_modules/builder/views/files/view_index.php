<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//Grid Area

$tmp_module_name_lower = "";
if (!$table_as_field_prefix) {
    $tmp_module_name_lower = '';
} else {
    $tmp_module_name_lower = $module_name_lower . '_';
}
$category = array();
$search = array();
$sort = array();
$pagination = "";
$hidden_fields = "";
$btn_find = "";
$btn_delete_selected = "";
$btn_reset = "";
$between = array();
$grid_category = "";
$grid_search = "";
$grid_between = "";

//status
if ($this->input->post('use_status') == 'true') {
    $category['active'] = "Active";
    $category['inactive'] = "Inactive";
}

//created
if ($this->input->post('use_created') == 'true') {
    $category['newest'] = "Newest";
    $category['oldest'] = "Oldest";
}

//category
if (!empty($category)) {
    $grid_category = $this->grid->print_category($category);
}

//search
$tmp_search_array = $this->input->post('grid_search');
if (isset($tmp_search_array) && !empty($tmp_search_array)) {
    foreach ($tmp_search_array as $value) {
        $search_v = $this->input->post($value);
        $search_v = $tmp_module_name_lower . "{$search_v}";

        $label_v = $this->input->post(str_replace("name", "label", $value));
        $search[$search_v] = $label_v;
    }
}

if (!empty($search)) {
    $grid_search = $this->grid->print_search_field_with_filter(array($search));
}

//between
$tmp_between = $this->input->post('grid_between');
if (isset($tmp_between) && !empty($tmp_between)) {
    foreach ($tmp_between as $value) {
        $between_v = $this->input->post($value);
        $between_v = $tmp_module_name_lower . "{$between_v}";
        $label_v = $this->input->post(str_replace("name", "label", $value));
        $between[$between_v] = $label_v;
    }
}

if (!empty($between)) {
    $grid_between = $this->grid->print_between($between);
}

//sort
$tmp_sort = $this->input->post('grid_sort');
if (isset($tmp_sort) && !empty($tmp_sort)) {
    foreach ($tmp_sort as $value) {
        $sort_v = $sort_v_pre = $this->input->post($value);
        $sort_v_pre = $tmp_module_name_lower . "{$sort_v}";
        $sort[$sort_v] = $sort_v_pre;
    }
}

//hidden fields
$hidden_fields = $this->grid->print_hidden_fields();

if (!empty($category) || !empty($search) || !empty($between)) {
    $btn_find = $this->grid->print_submit_button();
    $btn_reset = $this->grid->print_reset_button();
}
$btn_delete_selected = $this->grid->print_delete_button();
//Grid Area Ends


$view = <<<END
<?php if (!isset(\$ajax)) : ?>
<div class="admin-box">
	<h3>{$module_name}</h3>
        <?php
        \$attributes = array(
            'name' => 'admin_listing_form',
            'id' => 'admin_listing_form'
        );
        ?>
	<?php echo form_open(\$this->uri->uri_string().'/index', \$attributes); ?>
        <div class='grid-filters'>
        {$hidden_fields}
        <table>
        <tr>
        <td>{$grid_category}</td>
        <td>{$grid_search}</td>
        <td>{$grid_between}</td>
        <td>{$btn_find}</td>
        <td>{$btn_reset}</td>
        <td>
            <?php if (\$this->auth->has_permission('{delete_permission}')) : ?>
                {$btn_delete_selected}
            <?php endif; ?>
        </td>    
        </tr>
        </table>
        </div>
        
        
        <div id="table_content">
<?php endif; ?> 
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if (\$this->auth->has_permission('{delete_permission}') && isset(\$records) && is_array(\$records) && count(\$records)) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					{table_header}
                                        <?php if (\$this->auth->has_permission('{delete_permission}') && isset(\$records) && is_array(\$records) && count(\$records)) : ?>
					<th>Actions</th>
					<?php endif;?>
				</tr>
			</thead>
			<?php if (isset(\$records) && is_array(\$records) && count(\$records)) : ?>
			<!--tfoot>
				<?php if (\$this->auth->has_permission('{delete_permission}')) : ?>
				<tr>
					<td colspan="{cols_total}">
						<?php echo lang('bf_with_selected') ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php echo lang('{$module_name_lower}_delete_confirm'); ?>')">
					</td>
				</tr>
				<?php endif;?>
			</tfoot-->
			<?php endif; ?>
			<tbody>
			<?php if (isset(\$records) && is_array(\$records) && count(\$records)) : ?>
			<?php foreach (\$records as \$record) : ?>
				<tr>
					<?php if (\$this->auth->has_permission('{delete_permission}')) : ?>
					<td><input type="checkbox" name="checked[]" value="<?php echo \$record->{$primary_key_field} ?>" /></td>
					<?php endif;?>
					{table_records}
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="{cols_total}">No records found that match your selection.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
                <?php
                if (isset(\$pagination)) {
                    echo \$pagination;
                }
                ?>
	    <?php if (!isset(\$ajax)) : ?>
        </div>
    <?php echo form_close(); ?>
    </div>
<?php endif; ?>
END;

$headers = '';
for ($counter = 1; $field_total >= $counter; $counter++) {
    // only build on fields that have data entered.
    //Due to the required if rule if the first field is set the the others must be

    if (set_value("view_field_label$counter") == NULL) {
        continue;  // move onto next iteration of the loop
    }
    $headers .= '
					<th>' . set_value("view_field_label$counter");

    if (!empty($sort)) {
        $tmp_f = $this->input->post("view_field_name$counter");
        if (array_key_exists($tmp_f, $sort)) {
            $field = $sort[$tmp_f];
            $headers .= <<<EOT
                        <i class="icon-arrow-up sort" rel="asc" for="{$field}"></i>
                        <i class="icon-arrow-down sort" rel="desc" for="{$field}"></i>
EOT;
        }
    }

    $headers .= '</th>';
}
if ($use_position == 'true') {
    $headers .= '
					<th>Position</th>';
}
if ($use_soft_deletes == 'true') {
    $headers .= '
					<th>Deleted</th>';
}
if ($use_created == 'true') {
    $headers .= '
					<th>Created</th>';
}
if ($use_modified == 'true') {
    $headers .= '
					<th>Modified</th>';
}
if ($use_status == 'true') {
    $headers .= '
					<th>Status</th>';
}


$table_records = '';
$pencil_icon = "<i class=\"icon-pencil\">&nbsp;</i>";
$delete_icon = "<i class=\"icon-remove\">&nbsp;</i>";
for ($counter = 1; $field_total >= $counter; $counter++) {
    // only build on fields that have data entered.
    //Due to the requiredif rule if the first field is set the the others must be

    if (set_value("view_field_name$counter") == NULL || set_value("view_field_name$counter") == $primary_key_field) {
        continue;  // move onto next iteration of the loop
    }

    if ($db_required == 'new' && $table_as_field_prefix === TRUE) {
        $field_name = $module_name_lower . '_' . set_value("view_field_name$counter");
    } elseif ($db_required == 'new' && $table_as_field_prefix === FALSE) {
        $field_name = set_value("view_field_name$counter");
    } else {
        $field_name = set_value("view_field_name$counter");
    }

    if ($counter == 1) {
        $table_records .= "
				<td><?php echo \$record->" . $field_name . " ?></td>				
			";
    } else {
        $table_records .= '
				<td><?php echo $record->' . $field_name . '?></td>';
    }
}
if ($use_position == 'true') {
    $tmp_position_field = $this->input->post('position_field');
    $table_records .= <<<EOT
                 <td class="position">
                            <?php if(isset(\$max_position) && !empty(\$max_position)) {?>
                                <?php if(\$record->{$tmp_position_field} < \$max_position) { ?>
                                        &nbsp;<i rel_id="<?php echo \$record->{$primary_key_field} ?>" position="<?php echo \$record->{$tmp_position_field}  ?>" state="up" class="icon-chevron-down"></i>
                                <?php } ?>
                            <?php }?>
                            <?php if(isset(\$min_position) && !empty(\$min_position)) {?>
                                <?php if(\$record->{$tmp_position_field} > \$min_position) { ?>
                                        &nbsp;<i rel_id="<?php echo \$record->{$primary_key_field} ?>" position="<?php echo \$record->{$tmp_position_field}  ?>" state="down" class="icon-chevron-up"></i>
                                <?php } ?>
                            <?php }?>
                </td>
EOT;
    $field_total++;
}
if ($use_soft_deletes == 'true') {
    $table_records .= '
				<td><?php echo $record->deleted > 0 ? lang(\'' . $module_name_lower . '_true\') : lang(\'' . $module_name_lower . '_false\')?></td>';
    $field_total++;
}
if ($use_created == 'true') {
    $table_records .= '
				<td><?php echo $record->' . set_value("created_field") . '?></td>';
    $field_total++;
}
if ($use_modified == 'true') {
    $table_records .= '
				<td><?php echo $record->' . set_value("modified_field") . '?></td>';
    $field_total++;
}
if ($use_status == 'true') {
    $tmp_status_field = $this->input->post('status_field');
    $table_records .= <<<EOT
                <?php
                            if (\$record->{$tmp_status_field} == 1) {
                                \$status = "Active";
                                \$btn_status = "Inactive";
                                \$class = "success";
                            } else {
                                \$status = "Inactive";
                                \$btn_status = "Active";
                                \$class = "warning";
                            }
                            ?>
                            <td><span style="cursor: pointer;" class="label label-<?php echo \$class; ?> toggle_status" rel_id="<?php echo \$record->id; ?>" ><?php echo \$status ?></span></td>
EOT;
    $field_total++;
}
$table_records .= <<<EOT
            <td>            
            <?php if (\$this->auth->has_permission('{edit_permission}')) : ?>
                <?php echo anchor(SITE_AREA .'/$controller_name/$module_name_lower/edit/'.\$record->$primary_key_field, '{$pencil_icon}') ?>&nbsp;&nbsp;
            <?php endif;?>
            <?php if (\$this->auth->has_permission('{delete_permission}') && isset(\$records) && is_array(\$records) && count(\$records)) : ?>            
                <span style="cursor: pointer;" class="delete" data-original-title="" title="" rel="<?php echo \$record->{$primary_key_field};  ?>">{$delete_icon}</span>&nbsp;&nbsp;
            <?php endif;?>
            </td>
EOT;



$view = str_replace('{cols_total}', $field_total + 1, $view);
$view = str_replace('{table_header}', $headers, $view);
$view = str_replace('{table_records}', $table_records, $view);
$view = str_replace('{delete_permission}', preg_replace("/[ -]/", "_", ucfirst($module_name)) . '.' . ucfirst($controller_name) . '.Delete', $view);
$view = str_replace('{edit_permission}', preg_replace("/[ -]/", "_", ucfirst($module_name)) . '.' . ucfirst($controller_name) . '.Edit', $view);

echo $view;

unset($view, $headers);
