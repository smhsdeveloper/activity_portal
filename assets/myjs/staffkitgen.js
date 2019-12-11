var app = angular.module('StaffLoginApp', ['blockUI']);
app.controller('StaffLoginAppController', function ($scope, $http, blockUI) {
    $scope.base_url = myURL;
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getstaffdetails',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.mainstaff = jsondata.myStaffList;
    });
       $scope.LoginActivatedStatus = function (Obj) {
        $scope.Obj = Obj;
        if ($scope.Obj.login_activated == 'YES') {
            if (confirm('Are you sure you want Deactivate the login')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/updateactivestatus',
                    data: 'data=' + encodeURIComponent(angular.toJson($scope.Obj)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.Obj.login_activated = jsondata.myActivatedResult;
                    $scope.ConfirmMessage="Deactivated Successfully";
                });
            }
        } else {
            if (confirm('Are you sure you want Activate the login')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/updateactivestatus',
                    data: 'data=' + encodeURIComponent(angular.toJson($scope.Obj)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.Obj.login_activated = jsondata.myActivatedResult;
                    $scope.ConfirmMessage="Activated Successfully";
                });
            }
        }
    };
    $scope.ResetPassword = function (ObjPwd) {
        $scope.ObjPwd = ObjPwd;
        if(confirm('This step will reset and send the login username and Password.Are you sure?')){
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/resetpwd',
            data: 'data=' + encodeURIComponent(angular.toJson($scope.ObjPwd)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.ObjPwd.password_reset = jsondata.myResultPwdResult;
        });
    }
    };
    
    $scope.SendSmsToStudent = function () {
        var myDetail = null;
        myDetail = $scope.mainstaff;
        var hint = 0;
        $.each(myDetail, function (key, value) {
            if (value.smsSend) {
                hint++;
            }
        });
        $scope.myPostData = myDetail;
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/sendsms',
            data: 'data=' + encodeURIComponent(angular.toJson($scope.myPostData)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
           $scope.myPostData=null; 
        });
    };

    

});
