var app = angular.module('sms', ['blockUI']);
app.controller('smsController', function ($scope, $http, blockUI) {
    $scope.myStudentList = null;
    $scope.base_url = myURL;
    $scope.type = null;
    $scope.myAllStudentList = null;
    $scope.myStaffList = null;
    $scope.message = "";
    $scope.myCount = 0;
    $scope.myPostData = null;
    $scope.sectionId = 0;
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getallstaff',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.myStaffList = jsondata.stafflist;
        $scope.myDepList = jsondata.department;
        $scope.myDesigList = jsondata.designation;
    });
//getAllClassList
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getallsectionlist',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.mySectionList = jsondata.section;

    });
    $scope.getStudentList = function () {

        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getstudentlist/' + $scope.sectionId,
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.myStudentList = jsondata.student_list;
        });
    }
    $scope.smsSend = function () {
        if ($scope.type == null) {
            alert("Please Select type from (Send SMS to staff or Send sms to Student");
        } else if ($scope.message == "") {
            alert("Please fill the message content then try to send sms.");
        } else if ($scope.myCount == 0) {
            alert("Please select atleast 1 " + $scope.type + " to send SMS.");
        } else {
            var data = {
                detail: $scope.myPostData,
                message: $scope.message,
                type: $scope.type
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/sendsmsnow',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                window.location = self.location;
            });
        }
    }
    $scope.getCheckedMemberCount = function () {
        var myDetail = null;
        if ($scope.type == null) {
            return 0;
        }
        if ($scope.type == "STAFF") {
            myDetail = $scope.myStaffList;
        } else if ($scope.type == "STUDENT") {
            myDetail = $scope.myStudentList;
        }
        var hint = 0;
        $.each(myDetail, function (key, value) {
            if (value.smsSend) {
                hint++;
            }
        });
        $scope.myCount = hint;
        $scope.myPostData = myDetail;
        return hint;
    }
    $scope.cancelMessage = function () {
        {
            $scope.message = '';
        }
    }
    $scope.smsSendAllParent = function () {
        if ($scope.selectAll == true) {
           $scope.selectAll = true;
        }
        else {
            $scope.selectAll = false;
        }
        angular.forEach($scope.myStudentList, function (myAllStudentList) {
            myAllStudentList.smsSend = $scope.selectAll;
        });
    }
    $scope.smsSendAllStaff = function () {
        if ($scope.selectAllStaff == true) {
           $scope.selectAllStaff = true;
        }
        else {
            $scope.selectAllStaff = false;
        }
        angular.forEach($scope.myStaffList, function (myAllStaffList) {
            myAllStaffList.smsSend = $scope.selectAllStaff;
        });
    }

});
