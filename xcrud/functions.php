<?php
function publish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'1\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}
function unpublish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'0\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function exception_example($postdata, $primary, $xcrud)
{
    // get random field from $postdata
    $postdata_prepared = array_keys($postdata->to_array());
    shuffle($postdata_prepared);
    $random_field = array_shift($postdata_prepared);
    // set error message
    $xcrud->set_exception($random_field, 'This is a test error', 'error');
}

function test_column_callback($value, $fieldname, $primary, $row, $xcrud)
{
    return $value . ' - nice!';
}

function after_upload_example($field, $file_name, $file_path, $params, $xcrud)
{
    $ext = trim(strtolower(strrchr($file_name, '.')), '.');
    if ($ext != 'pdf' && $field == 'uploads.simple_upload')
    {
        unlink($file_path);
        $xcrud->set_exception('simple_upload', 'This is not PDF', 'error');
    }
}

function movetop($xcrud)
{
    if ($xcrud->get('primary') !== false)
    {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item['officeCode'] == $primary && $key != 0)
            {
                array_splice($result, $key - 1, 0, array($item));
                unset($result[$key + 1]);
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}
function movebottom($xcrud)
{
    if ($xcrud->get('primary') !== false)
    {
        $primary = (int)$xcrud->get('primary');
        $db = Xcrud_db::get_instance();
        $query = 'SELECT `officeCode` FROM `offices` ORDER BY `ordering`,`officeCode`';
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item['officeCode'] == $primary && $key != $count - 1)
            {
                unset($result[$key]);
                array_splice($result, $key + 1, 0, array($item));
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE `offices` SET `ordering` = ' . $key . ' WHERE officeCode = ' . $item['officeCode'];
            $db->query($query);
        }
    }
}

function show_description($value, $fieldname, $primary_key, $row, $xcrud)
{
    $result = '';
    if ($value == '1')
    {
        $result = '<i class="fa fa-check" />' . 'OK';
    }
    elseif ($value == '2')
    {
        $result = '<i class="fa fa-circle-o" />' . 'Pending';
    }
    return $result;
}

function custom_field($value, $fieldname, $primary_key, $row, $xcrud)
{
    return '<input type="text" readonly class="xcrud-input" name="' . $xcrud->fieldname_encode($fieldname) . '" value="' . $value .
        '" />';
}
function unset_val($postdata)
{
    $postdata->del('Paid');
}

function format_phone($new_phone)
{
    $new_phone = preg_replace("/[^0-9]/", "", $new_phone);

    if (strlen($new_phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $new_phone);
    elseif (strlen($new_phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $new_phone);
    else
        return $new_phone;
}

function before_list_example($list, $xcrud)
{
    var_dump($list);
}

function after_update_test($pd, $pm, $xc)
{
    $xc->search = 0;
}

function after_upload_test($field, &$filename, $file_path, $upload_config)
{
    $filename = 'bla-bla-bla';
}

/*******************************User Defined Functions*********************************/


function CheckProjectCode($postdata, $xcrud) {
    $project_code = $postdata->get('project_code');
    $db = Xcrud_db::get_instance();
    $db->query("SELECT project_code
                FROM `mstr_project`
                WHERE project_code = '$project_code'");
    $result_project_code = $db->row();
    if ($result_project_code > 0)
     {
        $xcrud->set_exception('project_code', 'Project Code exists. Please add another project code.', 'error');
         
     }
}

function GetRevisionTypeCongestion($postdata, $xcrud) {
    
    $revision = $postdata->get('revision_type');
    $financial_year = $postdata->get('financial_year');
   
    $db = Xcrud_db::get_instance();
    $db->query("SELECT revision_type
                FROM `input_congestion_chg`
                WHERE financial_year = $financial_year
                ORDER BY revision_type DESC
                LIMIT 1");
     $result_revision_type = $db->row();
     if (($revision) == ($result_revision_type['revision_type']+1))
     {
        //echo "Data Added";
         
     }else {
         $xcrud->set_exception('revision_type', 'Revision type either exists or can be added only in an order.', 'error');
     }
}

function GetRevisionTypeFerv($postdata, $xcrud) {
    
    $revision = $postdata->get('revision_type');
    $financial_year = $postdata->get('financial_year');
   
    $db = Xcrud_db::get_instance();
    $db->query("SELECT revision_type
                FROM `input_ferv_data`
                WHERE financial_year = $financial_year
                ORDER BY revision_type DESC
                LIMIT 1");
     $result_revision_type = $db->row();
     if (($revision) == ($result_revision_type['revision_type']+1))
     {
        //echo "Data Added";
         
     }else {
         $xcrud->set_exception('revision_type', 'Revision type either exists or can be added only in an order.', 'error');
     }
}
function GetRevisionTypeTariff($postdata, $xcrud) {
    
    $revision = $postdata->get('revision_type');
    $financial_year = $postdata->get('financial_year');
   
    $db = Xcrud_db::get_instance();
    $db->query("SELECT revision_type
                FROM `input_tariff_petition_fee`
                WHERE financial_year = $financial_year
                ORDER BY revision_type DESC
                LIMIT 1");
     $result_revision_type = $db->row();
     if (($revision) == ($result_revision_type['revision_type']+1))
     {
        //echo "Data Added";
         
     }else {
         $xcrud->set_exception('revision_type', 'Revision type either exists or can be added only in an order.', 'error');
     }
}
function GetRevisionTypePublication($postdata, $xcrud) {
    
    $revision = $postdata->get('revision_type');
    $financial_year = $postdata->get('financial_year');
   
    $db = Xcrud_db::get_instance();
    $db->query("SELECT revision_type
                FROM `input_publication_fee`
                WHERE financial_year = $financial_year
                ORDER BY revision_type DESC
                LIMIT 1");
     $result_revision_type = $db->row();
     if (($revision) == ($result_revision_type['revision_type']+1))
     {
        //echo "Data Added";
         
     }else {
         $xcrud->set_exception('revision_type', 'Revision type either exists or can be added only in an order.', 'error');
     }
}
function GetRevisionTypeNrldc ($postdata, $xcrud) {
    
    $revision = $postdata->get('revision_type');
    $financial_year = $postdata->get('financial_year');
    $month = $postdata->get('month');
   
    $db = Xcrud_db::get_instance();
    $db->query("SELECT revision_type
                FROM `input_nrldc_data`
                WHERE financial_year = $financial_year AND month = $month
                ORDER BY revision_type DESC
                LIMIT 1");
     $result_revision_type = $db->row();
     if ($revision == $result_revision_type['revision_type']+1)
     {
        //echo "Data Added";
         
     }else {
         $xcrud->set_exception('revision_type', 'Revision type either exists or can be added only in an order.', 'error');
     }
}
function GetRevisionTypeIncometax ($postdata, $xcrud) {
    
    $revision = $postdata->get('revision_type');
    $financial_year = $postdata->get('financial_year');
    $quarter = $postdata->get('quarter');
   
    $db = Xcrud_db::get_instance();
    $db->query("SELECT revision_type
                FROM `input_income_tax`
                WHERE financial_year = $financial_year AND quarter = $quarter
                ORDER BY revision_type DESC
                LIMIT 1");
     $result_revision_type = $db->row();
     if ($revision == $result_revision_type['revision_type']+1)
     {
        //echo "Data Added";
         
     }else {
         $xcrud->set_exception('revision_type', 'Revision type either exists or can be added only in an order.', 'error');
     }
}

function checktemplate($postdata, $xcrud) {
    $project_code = $postdata->get('template_code');
    $db = Xcrud_db::get_instance();
    $db->query("SELECT *
                FROM `email_template`
                WHERE template_code = '$project_code'");
    $result = $db->row();
    if ($result > 0)
     {
        $xcrud->set_exception('template_code', 'Review template already exists. Please add another template.', 'error');
         
     }
}

function before_updatetempl($postdata,$primary, $xcrud) {
    $project_code = $postdata->get('template_code');
    $db = Xcrud_db::get_instance();
    $db->query("SELECT *
                FROM `email_template`
                WHERE template_code = '$project_code'");
    $result = $db->row();
    if ($result > 0)
     {
        $xcrud->set_exception('template_code', 'Review template already exists. Please add another template.', 'error');
         
     }
}