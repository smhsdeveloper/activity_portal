<?php
$app_register = array(
    "device_name",
    "device_version",
    "device_uuid",
    "device_company",
    "device_width",
    "device_height",
    "device_platform",
    "device_colordepth"
);
$app_login = array(
    "username",
    "password",
    "device_uuid"
);
$app_otpvalidation = array(
    "access_key",
    "otp"
);
$app_modulelist = array(
    "access_key",
    "project_id"
);
$app_activityentry = array("data");
switch ($action) {
    case "app_activityentry":
        $sendJsonValue = TRUE;
        break;
    default :
        $sendJsonValue = FALSE;
        break;
}
$app_dashboard = array("access_key");
$app_projectlist = $app_dashboard;
$app_activitylist = $app_dashboard;
if (!isset($$action)) {
    echo "url not found";
    exit;
}
?>
<form action="http://activity.smartechenergy.in/<?php echo $action; ?>" method="post" id="testapi">
    <?php
    foreach ($$action as $data) {
        echo $data;
        ?>
        <input type="text" id="<?php echo $data; ?>"><br>
        <?php
    }
    ?>
    <input type="hidden" name="data" id="formData">
</form>
<!--{"access_key":"rgregwt","date":"fjmfr","activity":[{"project_id":"1","module_id":"1","activity_id":"1","remarks":"aefeg","hour_worked":"esfjyge"}]}-->
<input type="button" value="Submit" id="submit">
<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
<script>
    jQuery("#submit").click(function () {
        var data = {
<?php
foreach ($$action as $data) {
    echo $data;
    ?>
                : $("#<?php echo $data; ?>").val(),
    <?php
}
?>
        };
<?php
if ($sendJsonValue) {
    ?>
            $("#formData").val(data.data);
    <?php
} else {
    ?>
            $("#formData").val(JSON.stringify(data));
    <?php
}
?>
        $("#testapi").submit();
    });
</script>