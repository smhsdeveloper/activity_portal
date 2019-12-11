<?php

/**********************staffapp activity *********************************/
$route['staffapp/login'] = "staffapp/staffapp_controller/loginMe";
$route['staffapp/dashboard'] = "staffapp/staffapp_controller/myDashboardData";
$route['staffapp/projectlist'] = "staffapp/staffapp_controller/taskEntry";
$route['staffapp/modulelist'] = "staffapp/staffapp_controller/moduleList";
$route['staffapp/activitylist'] = "staffapp/staffapp_controller/activityList";
$route['staffapp/taskdetails'] = "staffapp/staffapp_controller/getTaskDetails";
$route['staffapp/restart'] = "staffapp/staffapp_controller/restartTask";
$route['staffapp/stoptask'] = "staffapp/staffapp_controller/stopTask";
$route['staffapp/reports'] = "staffapp/staffapp_controller/reports";
$route['staffapp/fulltaskdetail'] = "staffapp/staffapp_controller/getfulltaskdetail";
$route['staffapp/checkstartwork'] = "staffapp/staffapp_controller/checkstartwork";
$route['staffapp/punchActivty'] = "staffapp/staffapp_controller/punchActivity";

$route['staffapp/todaytasks'] = "staffapp/staffapp_controller/getTodayTaskDetails";
$route['staffapp/savetask'] = "staffapp/staffapp_controller/saveTaskDetails";
$route['staffapp/projectfulldata'] = "staffapp/staffapp_controller/projectFullData";