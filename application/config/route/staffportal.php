<?php
$route['404_override'] = '';
/* * ****************Login Controller************* */
$route['default_controller'] = "login/login_controller";
$route['login/checklogindetail'] = "login/login_controller/checklogindetail";

$route['login/resetpassword'] = "login/login_controller/resetpassword";
/* service url */$route['login/checkresetpassword'] = "login/login_controller/checkresetpassword";
/* service url */$route['login/resetforgotpassword'] = "login/login_controller/resetforgotpassword";


$route['login/changeidpassword'] = "login/login_controller/changeidalso";
$route['login/verifypassword'] = "login/login_controller/verifypassword";
$route['login/forgotpassword'] = "login/login_controller/forgotpassword";
/* service url */$route['login/changeuserpassword'] = "login/login_controller/changeidpassword";
$route['login/accountdeactivated'] = "login/login_controller/accountdeactivate";
$route['login/logout'] = "login/login_controller/logout";


/**gmail login **/

$route['server/glogin'] = "login/login_controller/gmaillogin";
$route['oauth2callback']="login/login_controller/oauthcallback";


//********************Staff Management**********************//
$route['staff/managestaff'] = "staff/staff_controller";
$route['staff/getallstaff'] = "staff/staff_controller/getstaffdetail";
$route['staff/saveallstaff'] = "staff/staff_controller/saveupdatestaffdetail";
$route['staff/savestaffprivilege'] = "staff/staff_controller/saveStaffPrivilege";
$route['staff/fetchstaffmenu/(:any)'] = "staff/staff_controller/getStaffMenu/$1";
$route['staff/getphoto/(:any)/(:any)'] = "staff/staff_controller/getStaffPhoto/$1/$1";
$route['staff/getstaffmenu/(:any)'] = "staff/staff_controller/getStaffMenu/$1";

//***************************sms**************************************
$route['staff/smsmodule'] = "staff/sms_controller";
$route['staff/getallsectionlist'] = "staff/sms_controller/getallsection";
/* serviceurl */$route['staff/getstudentlist/(:any)'] = "staff/sms_controller/getallstudent/$1";
/* service url */$route['staff/getstudentlist'] = "staff/sms_controller/getallstudent";
/* service url */$route['staff/sendsmsnow'] = "staff/sms_controller/sendsms";

//******************************Notice*********************************************
$route['staff/noticemodule'] = "staff/notice_controller";
/* service url */$route['staff/sendnotice'] = "staff/notice_controller/getnoticedeatil";
/* service url */$route['staff/senddirectnotice'] = "staff/notice_controller/noticesenddirect";

//****************************grade emtry and summary*****************************
$route['staff/cceentry'] = "staff/grade_controller";
/* service url */$route['staff/getallccenamelist'] = "staff/grade_controller/getccename";
/* service url */$route['staff/getmystudent'] = "staff/grade_controller/getmystudent";
/* service url */$route['staff/savegradedetail'] = "staff/grade_controller/savegradedetail";
/* service url */$route['staff/gradesummary'] = "staff/grade_controller/gradesummaryview";
/* service url */$route['staff/studentgradelist'] = "staff/grade_controller/getgradedetails";

/* * ********************** Attendence************* */
$route['staff/manageattendence'] = "staff/attendence_controller";
/* ServiceUrl */$route['staff/getattendencelist'] = "staff/attendence_controller/getattendence";
/* ServiceUrl */$route['staff/saveattendence'] = "staff/attendence_controller/saveattendencedetail";
/* ServiceUrl */$route['staff/markallattendence'] = "staff/attendence_controller/markallattendencedetail";

/* * ********************** Attendence Summary ************* */
$route['staff/attsummary'] = "staff/attendence_controller/attendencesummaryview";
/* ServiceUrl */$route['staff/getattsummary'] = "staff/attendence_controller/getsummary";

//***********************Manage Event **************************************
$route['staff/manageevent'] = "staff/event_controller/addevent";
$route['staff/myevents'] = "staff/event_controller/loadpage";
/* ServiceUrl */$route['staff/myevents/(:any)'] = "staff/event_controller/loadpage/$1";
/* ServiceUrl */$route['staff/myevents/(:any)/(:any)'] = "staff/event_controller/loadpage/$1/$2";
/* ServiceUrl */$route['staff/staffevent'] = "staff/event_controller/geteventstaff";
/* ServiceUrl */$route['staff/loadeventdetail'] = "staff/event_controller/loadeventdetail";
/* DONE************Manage Section- Add/Delete/update new section (9A,9B etc....) */
$route['staff/managesection'] = "staff/sectionmanagement_controller/addsection";
$route['staff/managesection/(:any)'] = "staff/sectionmanagement_controller/addsection/$1";
/* * ************************ END ***************************** */

/* MODULE : ADMIN3 *************Manage Subject -Add remove delete ******************************** */
$route['staff/managesubject'] = "staff/subjectmanagement_controller/addsubject";
$route['staff/managesubject/(:any)'] = "staff/subjectmanagement_controller/addsubject/$1";
/* * ************************ END MODULE : ADMIN3 ***************************** */

/* DONE * ************* Manage Class Teacher  ************************ */
$route['staff/manageclassteacher'] = "staff/sectionmanagement_controller/addclassteacher";
/* * ******** END Manage Class Teacher  ************************ */

/* DONE ********************Manage Subject teacher *************************** */
$route['staff/subjectteacher'] = "staff/subjectmanagement_controller/managesubjectteacher";
$route['staff/subjectteacher/(:any)'] = "staff/subjectmanagement_controller/managesubjectteacher/$1";
/* * ************************ END ***************************** */

/* DONE *******************Manage CCE ELEMENT LIST -Add remove delete  ************************ */
$route['staff/ccelist'] = "staff/ccemanagement_controller/managecce";
$route['staff/ccelist/(:any)'] = "staff/ccemanagement_controller/managecce/$1";
/* * *********** END CCE ELEMENT  ******************** */

/* DONE  ******************* MANAGE CCE TEACHER ASSIGNMENT  ****************** */
$route['staff/assigncceelement'] = "staff/ccemanagement_controller/managecee_teacher";
$route['staff/assigncceelement/(:any)'] = "staff/ccemanagement_controller/managecee_teacher/$1";
/* * ************************ END ***************************** */

//Manage Combo Management - Add new combo and add subjects to combo
$route['staff/managecombourl'] = "staff/combomanagement_controller/manage_combos";
$route['staff/managecombourl/(:any)'] = "staff/combomanagement_controller/manage_combos/$1";
$route['staff/managecombourl/(:any)/(:any)'] = "staff/combomanagement_controller/manage_combos/$1/$2";
$route['staff/managecombosectionurl'] = "staff/combomanagement_controller/manage_combos";
$route['staff/managecombosectionurl/(:any)'] = "staff/combomanagement_controller/manage_combo_and_assign_to_section/$1";
/* service url */$route['staff/combosectionsave'] = "staff/combomanagement_controller/combosectionsave";
/* service url */$route['staff/combosave'] = "staff/combomanagement_controller/save_combo";

/* * **************************CCE ENTRY MODULE**************************** */
$route['staff/ccegradeentry'] = "staff/ccemanagement_controller/ccegradeentryload";
/* service url */$route['staff/getallccenamelist'] = "staff/ccemanagement_controller/getccename";
/* service url */$route['staff/getmystudent'] = "staff/ccemanagement_controller/getmystudent";
/* service url */$route['staff/savegradedetail'] = "staff/ccemanagement_controller/savegradedetail";
/* service url */$route['staff/getallsectionlist'] = "staff/ccemanagement_controller/getallsection";

/* * **************************  VIEW CCE GRADE SUMMARY   *************************** */
$route['staff/gradesummary'] = "staff/ccemanagement_controller/gradesummaryview";
/* service url */$route['staff/studentgradelist'] = "staff/ccemanagement_controller/getgradedetails";
//********************Declare Exam Start*********************************

$route['staff/decalareexam'] = "staff/marksentry_controller/declareexam";
/* service url */$route['staff/decalareexam/(:any)'] = "staff/marksentry_controller/declareexam/$1";


//*****************************Marks Entry Start *****************************
$route['staff/marksentry'] = "staff/marksentry_controller";
/* service url */$route['staff/getmysubjectname'] = "staff/marksentry_controller/getallsubjectlist";
/* service url */$route['staff/getexamlist'] = "staff/marksentry_controller/getexamlist";
/* service url */$route['staff/getexampart'] = "staff/marksentry_controller/getexampart";
/* service url */$route['staff/saveexampart'] = "staff/marksentry_controller/saveexampart";
/* service url */$route['staff/removepart'] = "staff/marksentry_controller/removeexampart";
/* service url */$route['staff/savemarks'] = "staff/marksentry_controller/savemarksdetail";
/* service url */$route['staff/myactualmarks'] = "staff/marksentry_controller/getactualmarks";
/* service url */$route['staff/saveactualmarks'] = "staff/marksentry_controller/saveactualmarks";




/* * *************** ASSIGN COMBO TO STUDENTS ********************** */
$route['staff/assigncombo'] = "staff/combomanagement_controller/AssignSubjectCombo";
/* SeviceURL */$route['staff/combodetails'] = "staff/combomanagement_controller/loadSectiondetails";
/* SeviceURL */$route['staff/sectiondetails'] = "staff/combomanagement_controller/loadCombodetails";
/* SeviceURL */$route['staff/assigncombotostudent'] = "staff/combomanagement_controller/AssignCombo";
/* SeviceURL */$route['staff/deleteCombo'] = "staff/combomanagement_controller/DeleteCombo";
/* * ************************ END ***************************** */
/* * ************Student Profile Start****************** */
$route['staff/studentprofile'] = "staff/student_controller/loadStudentProfilePage";
$route['staff/studentprofile/(:num)'] = "staff/student_controller/loadStudentProfilePage/$1";
$route['staff/getstudphoto/(:any)/(:any)'] = "staff/student_controller/getstudentphoto/$1/$2";
/* SeviceURL */$route['staff/studentprofile/studentDetails'] = "staff/student_controller/getStudentDetails";
/* SeviceURL */$route['staff/studentprofile/issuecards'] = "staff/student_controller/issueCards";
/* * ************Staff Profile Start****************** */
$route['staff/staffprofile/(:any)'] = "staff/staff_controller/loadStaffView/$1";
/* SeviceURL */$route['staff/profiledetails'] = "staff/staff_controller/loadStaffprofile";

/* * ************Student Entry ****************** */
//$route['staff/newadmission'] = "staff/student_controller/newAdmission";
$route['staff/managestudent'] = "staff/student_controller/loadStudentView";
//$route['staff/studententry/(:num)'] = "staff/student_controller/loadStudentView/$1";
$route['staff/managestudent/(:num)'] = "staff/student_controller/loadStudentView/$1";
/* SeviceURL */$route['staff/studententry/savenewadmission'] = "staff/student_controller/saveNewAdmission";
/* SeviceURL */$route['staff/getstudentprofile'] = "staff/student_controller/getStudentProfile";
/* SeviceURL */$route['staff/saveprofile'] = "staff/student_controller/saveUpdateStundentDetail";
//*****************************Marks Entry Start *****************************
$route['staff/marksentry'] = "staff/marksentry_controller";
/* service url */$route['staff/getmysubjectname'] = "staff/marksentry_controller/getallsubjectlist";
/* service url */$route['staff/getexamlist'] = "staff/marksentry_controller/getexamlist";
/* service url */$route['staff/getexampart'] = "staff/marksentry_controller/getexampart";
/* service url */$route['staff/saveexampart'] = "staff/marksentry_controller/saveexampart";
/* service url */$route['staff/removepart'] = "staff/marksentry_controller/removeexampart";
/* service url */$route['staff/savemarks'] = "staff/marksentry_controller/savemarksdetail";
/* service url */$route['staff/myactualmarks'] = "staff/marksentry_controller/getactualmarks";

//*****************************Publish Marks**********************************
$route['staff/publishmarks'] = "staff/marksentry_controller/publishmarks";
/* service url */$route['staff/getmyclass'] = "staff/marksentry_controller/getclasslist";
/* service url */$route['staff/publishmarksdetail'] = "staff/marksentry_controller/publishmarksdetails";
/* service url */$route['staff/savepublishmarks'] = "staff/marksentry_controller/savepublishmarks";
/* service url */$route['staff/lockmarksdetail'] = "staff/marksentry_controller/lockmarksdetails";
/* service url */$route['staff/savelockmarks'] = "staff/marksentry_controller/savelockmarks";

//*****************************Blue Sheet**********************************
$route['staff/bluesheet'] = "staff/marksentry_controller/bluesheet";
/* service url */$route['staff/getstudentmarks'] = "staff/marksentry_controller/getstudentmarks";
/* service url */$route['staff/getblueexamlist'] = "staff/marksentry_controller/getblueexamlist";
/* service url */$route['staff/loadexammarks'] = "staff/marksentry_controller/loadexammarks";

/* * *************************Manage House******************************* */
$route['staff/managehouse'] = "staff/house_controller/housedetails";

/* * ************ REMARK ENTRY MODULE****************** */
$route['staff/remarkentrysub'] = "staff/remark_controller/remark_entry_subject";
$route['staff/remarkentrygen'] = "staff/remark_controller/remark_entry_gen";
/* SeviceURL */$route['staff/getstudentlistofsubject'] = "staff/remark_controller/loadremarkstudents";
/* SeviceURL */$route['staff/getstudentlistofsection'] = "staff/remark_controller/loadSectionstudents";
/* SeviceURL */$route['staff/getstaffsubjectlist'] = "staff/remark_controller/getstaffsubjects";
/* SeviceURL */$route['staff/savesubjectremarkdata'] = "staff/remark_controller/savesubjectremark";
/* SeviceURL */$route['staff/loadSectionList'] = "staff/remark_controller/loadSectionList";
/* SeviceURL */$route['staff/deleteRemark'] = "staff/remark_controller/deleteRemark";

//********************Staff Dashboard Start**********************//
$route['staff/staffdashboard'] = "staff/staff_controller/loadStaffDashboard";
$route['staff/mypic'] = "staff/staff_controller/do_upload";
/* SeviceURL */$route['staff/dashboarddatails'] = "staff/staff_controller/loadStaffDetails";
/* SeviceURL */$route['staff/cards'] = "staff/staff_controller/loadCardDetails";
/* SeviceURL */$route['staff/saveTodo'] = "staff/staff_controller/loadTodoData";
/* SeviceURL */$route['staff/deleteTodo'] = "staff/staff_controller/deleteTodoData";
/* SeviceURL */$route['staff/deleteCards'] = "staff/staff_controller/deleteCardData";
/* SeviceURL */$route['staff/issuecardDetails'] = "staff/staff_controller/loadCards";
/* ServiceURL */$route['staff/allstudentnamelist'] = "staff/staff_controller/loadstudentlist";

/* * ************Admin Dashboard Start****************** */
$route['staff/admindashboard'] = "staff/admin_controller/loadAdminDashboard";
/* SeviceURL */$route['staff/admindashboarddetails'] = "staff/admin_controller/loadAdminDetails";
/* SeviceURL */$route['staff/updateholiday'] = "staff/admin_controller/updateHolidy";
/* SeviceURL */$route['staff/loadTodayholiday'] = "staff/admin_controller/loadTodayholiday";
/* ServiceURL */$route['staff/examschedule'] = "staff/admin_controller/getexamdateschedule";





/* * *************** staff login/kit generate ********************** */
$route['staff/genstafflogin'] = "login/staffkitgeneration_controller";
/* ServiceUrl */$route['staff/getstaffdetails'] = "login/staffkitgeneration_controller/getallstaff";
/* ServiceUrl */$route['staff/updateactivestatus'] = "login/staffkitgeneration_controller/updateloginstatus";
/* ServiceUrl */$route['staff/resetpwd'] = "login/staffkitgeneration_controller/resetpassword";
/* ServiceUrl */$route['staff/sendsms'] = "login/staffkitgeneration_controller/sendsmsdetails";
/* * *************** student login/kit generate ********************** */
$route['staff/genstudlogin'] = "login/studentkitgeneration_controller";
/* ServiceUrl */$route['staff/getsections'] = "login/studentkitgeneration_controller/getallsections";
/* ServiceUrl */$route['staff/getstudents'] = "login/studentkitgeneration_controller/getallstudents";
/* ServiceUrl */$route['staff/resetpwd'] = "login/studentkitgeneration_controller/resetpassword";
/* ServiceUrl */$route['staff/updateactivestatus'] = "login/studentkitgeneration_controller/updateloginstatus";
/* ServiceUrl */$route['staff/sendsms'] = "login/studentkitgeneration_controller/sendsmsdetails";


/* * **************************Menu List Module*************************************************************** */

$route['staff/menulist'] = "staff/menulist_controller/menulist";
$route['staff/menulist/(:any)'] = "staff/menulist_controller/menulist/$1";

//***************************************** Master Login Module *********************************************//

$route['staff/masterlogin'] = "login/masterlogin_controller/masterlogin";
$route['staff/masterlogin/(:any)'] = "login/masterlogin_controller/masterlogin/$1";
/* ServiceUrl */$route['staff/getschoollist'] = "login/masterlogin_controller/getschoollist";
/* ServiceUrl */$route['staff/getfullschooldetail'] = "login/masterlogin_controller/getfullschooldetail";
/* ServiceUrl */$route['staff/getallnamelist'] = "login/masterlogin_controller/serachStudent";
/* ServiceUrl */$route['staff/masterloginas'] = "login/deo_controller/superlogin";


/* * *************************************Club Management Module************************************************ */

$route['staff/clubmanagement'] = "staff/clubmanagement_controller/addnewclub";

/* * ****************************Service Url[Add Member Module]***************************************************** */
$route['staff/addmember'] = "staff/clubmanagement_controller/addmember";
$route['staff/addmember/(:any)'] = "staff/clubmanagement_controller/addmember/$1";
$route['staff/addmember/(:any)/(:any)'] = "staff/clubmanagement_controller/addmember/$1/$2";
/* service url */$route['staff/getmemberdetail'] = "staff/clubmanagement_controller/getmemberdetails";

/* service url */$route['staff/saveattdetail'] = "staff/clubmanagement_controller/saveattdetails";


/* * ****************************Sql Report Module ****************************************** */
$route['staff/sqlreport'] = "staff/sqlreport_controller/index";
/* serviceURL */$route['staff/reportdata'] = "staff/sqlreport_controller/getsearchfield";
/* serviceUrl */$route['staff/searchdata'] = "staff/sqlreport_controller/searchreport";
$route['staff/sqlresult'] = "staff/sqlreport_controller/sqlreportresult";

/* * ********************Late attendance entry module******************************** */
$route['staff/lateattendance'] = "staff/attendence_controller/lateattendance";
/* Service url */$route['staff/studentlist'] = "staff/attendence_controller/searchstudent";
/* Service url */$route['staff/saveallattendancedata'] = "staff/attendence_controller/savelatedata";

/*********************************School Setting Module*************************************/
$route['staff/schoolsetting']="staff/schoolsetting_controller";
/* ServiceUrl */$route['staff/schoolDeatil'] = "staff/schoolsetting_controller/getschooldetail";
/*service url */ $route['staff/saveschoolDeatil']="staff/schoolsetting_controller/saveschooldeatil";

/* * *****************************************Exam date Sheet Module*********************************** */
$route['staff/examdatesheet'] = "staff/examdatesheet_controller";
/* service url */$route['staff/classlist'] = "staff/examdatesheet_controller/Sectionlist";
/* service url */$route['staff/sectiondata'] = "staff/examdatesheet_controller/sectiondata";
/* service url */$route['staff/savealldata'] = "staff/examdatesheet_controller/savealldata";
/* service url */$route['staff/addexamintable'] = "staff/examdatesheet_controller/addexamintable";

/******************************************** Review Module (Devendra) ********************************************/
$route['review/selfreview'] = "review/review_controller/empReviews";
$route['review/aprovereview'] = "review/review_controller/rmReviews";
/* service url */$route['review/empselfreview'] = "review/review_controller/saveSelfReviewEmp";
/* service url */$route['review/empreviewbyrm'] = "review/review_controller/saveEmpReviewByRMOrAdmin";
/* service url */$route['review/getallrms'] = "review/review_controller/getAllRMs";
/* service url */$route['review/rmemplist'] = "review/review_controller/getRMEmpList";

/*****menu privilege***/
$route['staff/menulist'] = "login/login_controller/getmenulists";
$route['staff/savelist'] = "login/login_controller/savelist";

// New code added by Dev
/****Review & Rating Listing (Devendra)****/
$route['review/reviewListing'] = "review/review_controller/reviewListing";
$route['review/getfinancialyears'] = "review/review_controller/getFinancialYearList";
$route['review/reviewsetting'] = "review/review_controller/reviewSetting";
$route['review/getreviewsettings'] = "review/review_controller/getReviewSettings";
$route['review/savereviewsettings'] = 'review/review_controller/saveReviewSettings';
$route['review/getmonthlist'] = "review/review_controller/getMonthList";
$route['review/savereviewsettings'] = "review/review_controller/saveReviewSettings";
$route['review/deletereviewsettings'] = "review/review_controller/deleteReviewSettings";
$route['review/getremaintime'] = "review/review_controller/getRemainTime";