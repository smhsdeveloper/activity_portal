<?php

/* * ********************Activity module******************************** */
$route['activity/addproject'] = "activity/activity_controller/projectyentry";
$route['activity/addactivity'] = "activity/activity_controller/activityentry";
$route['activity/empactivityentry'] = "activity/activity_controller/empactivityentry";
$route['activity/moduleentry'] = "activity/activity_controller/moduleentry";
$route['activity/newactivity'] = "activity/activity_controller/newactivity";
$route['activity/newtask'] = "activity/activity_controller/newtask";
$route['activity/activityentry'] = "activity/activity_controller/taskentry";
/* Service url */$route['activity/projectlist'] = "activity/activity_controller/projectlist";
/* Service url */$route['activity/modulelist'] = "activity/activity_controller/modulelist";
/* Service url */$route['activity/activitylist'] = "activity/activity_controller/activitylist";
$route['activity/empactivityentry/(:any)'] = "activity/activity_controller/empactivityentry/$1";
$route['activity/viewactivity'] = "activity/activity_controller/viewactivity";
$route['activity/viewactivity/(:any)/(:any)/(:any)'] = "activity/activity_controller/viewactivity/$1/$2/$3";
$route['activity/addemployee'] = "activity/activity_controller/addemployee";
$route['activity/adddesignation'] = "activity/activity_controller/adddesignation";
$route['activity/addrm'] = "activity/activity_controller/adddrm";
$route['activity/userid'] = "activity/activity_controller/userid";
/* Service url */$route['activity/emplist'] = "activity/activity_controller/emplist";
/* Service url */$route['activity/emplisttype'] = "activity/activity_controller/emplisttype";
/* Service url */$route['activity/totalhour'] = "activity/activity_controller/totalhour";
$route['activity/nightservice'] = "activity/service_controller/informationofactivity";
$route['activity/morningservice'] = "activity/service_controller/reminderofactivity";
/* * **********************************************Holiday/Attendance Start**************************************************** */
$route['activity/holiday'] = "activity/activity_controller/addholiday";
$route['activity/holiday/(:any)'] = "activity/activity_controller/addholiday/$1";
$route['activity/holiday/(:any)/(:any)'] = "activity/activity_controller/addholiday/$1/$2";
$route['activity/attendance'] = "activity/activity_controller/attendance";
$route['activity/attendance/(:any)'] = "activity/activity_controller/attendance/$1";
/* * *********Service url ********* */$route['activity/allempDetails'] = "activity/activity_controller/allempDetails";
/* * *********Service url ********* */$route['activity/attendancevis'] = "activity/activity_controller/attendancevis";
/* * *********Service url ********* */$route['activity/markabsent'] = "activity/activity_controller/markabsent";

/* * **********************************************Holiday/Attendance Start**************************************************** */

/* * **********************************************Auto Service Start**************************************************** */
$route['activity/empforotp'] = "activity/auto_controller/empforotp";
$route['activity/manpower'] = "activity/auto_controller/manpower";
$route['activity/empforreminder'] = "activity/auto_controller/empforreminder";
$route['activity/adminsms'] = "activity/auto_controller/adminSMS";
/* * **********************************************Auto Service Stop**************************************************** */
$route['activity/otpdetails'] = "activity/activity_controller/otpdetails";
/* * *********Service url ********* */$route['activity/otpvalidate'] = "activity/activity_controller/otpvalidate";

/* * **********************************************Akhiesh Karn ************************************************************ */

$route['activity/viewactivitysummary'] = "activity/activity_controller/viewactivitysummary";
$route['activity/viewactivitysummary/(:any)/(:any)/(:any)'] = "activity/activity_controller/viewactivitysummary/$1/$2/$3";


$route['activity/viewprojectsummary'] = "activity/activity_controller/viewprojectsummary";


/* Service url */$route['activity/emplist'] = "activity/activity_controller/emplist";
/* Service url */$route['activity/getactivitysummary'] = "activity/activity_controller/getactivitysummary";
/* Service url */$route['activity/exportsummary'] = "activity/activity_controller/exportsummary";
/* Service url */$route['activity/getprojectlist'] = "activity/activity_controller/getprojectlist";
/* Service url */$route['activity/getProjectSummary'] = "activity/activity_controller/getProjectSummary";
/* Service url */$route['activity/exportprojectsummary'] = "activity/activity_controller/exportprojectsummary";

/* * ***********************************Nitin**************************************** */
$route['activity/saveworkdetail'] = "activity/activity_controller/saveWorkDetails";
$route['activity/startworkdetail'] = "activity/activity_controller/startWorkDetail";
$route['activity/pauseworkdetail'] = "activity/activity_controller/pauseWorkDetail";
$route['activity/gettabledetail'] = "activity/activity_controller/getTableDetail";
$route['activity/checkstartwork'] = "activity/activity_controller/checkstartwork";
$route['activity/stopactivitystatus'] = "activity/activity_controller/stopActivityStatus";
$route['activity/savemodule'] = "activity/activity_controller/saveModule";
$route['activity/saveactivity'] = "activity/activity_controller/saveActivity";
/* * ************************************Activity Email ******************************** */
$route['activity/sendEmail'] = "activity/activity_controller/sendEmail";
/* * ************************************Manage Version ******************************** */
$route['activity/manageversion'] = "activity/activity_controller/manageversion";
$route['activity/manageversion/(:any)'] = "activity/activity_controller/manageversion/$1";
$route['activity/manageversion/(:any)/(:any)'] = "activity/activity_controller/manageversion/$1/$2";
$route['activity/gettestingproject'] = "activity/activity_controller/gettestingproject";

/* * ************************************Email ******************************** */
$route['activity/getrmlist'] = "activity/email_controller/fetchrmlist";






//*************rating************/
$route['review/getemprating'] = "review/review_controller/getemprating";
$route['review/savemprating'] = "review/review_controller/saveemprating";
$route['review/getyearlist'] = "review/review_controller/getyearmonthlist";
$route['review/getemployeereviews'] = "review/review_controller/getmonthlyreviews";
$route['review/getemployeeselfreviews'] = "review/review_controller/getselfreviews";

/* * **********************************************Akash Giri************************************************************ */

$route['activity/viewactivitymonthwise'] = "activity/activity_controller/viewActivityMonthWise";
$route['activity/projectlists'] = "activity/activity_controller/getprojectlists";
$route['activity/monthreports'] = "activity/activity_controller/getmonthwisereport";
$route['activity/getactiviydata'] = "activity/activity_controller/getmonthactivitydata";
$route['activity/monthlysummary/(:any)/(:any)/(:any)/(:any)'] = "activity/activity_controller/viewdailysummary/$1/$2/$3/$4";
//*************Bar Chart****************************************************/
$route['activity/viewactivitychart'] = "activity/activity_controller/viewActiviyChart";
$route['activity/chartdata'] = "activity/activity_controller/getbarchartdata";

//*************top 10 project Bar Chart****************************************************/
$route['activity/viewprojects'] = "activity/activity_controller/viewtoptenproject";
$route['activity/chartdata'] = "activity/activity_controller/getbarchartdata";

//*************send mail by template****************************************************/
$route['review/sendreview'] = "review/review_controller/empSendReviews";
/* Service url */$route['review/getreviewtemp'] = "review/review_controller/getreviewtemplate";
/* Service url */$route['review/sendreviewemail'] = "review/review_controller/sendreviewemail";

//*************Email template****************************************************/
$route['review/emailtemplate'] = "review/review_controller/emailtemplates";

//*************Send Activity Reminder****************************************************/
$route['review/sendreminder'] = "review/review_controller/sendreminder";
$route['review/sendsinglerem'] = "review/review_controller/sendsingle";

