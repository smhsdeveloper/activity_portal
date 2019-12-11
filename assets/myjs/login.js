var app = angular.module('login', []);
app.controller('loginController', ['$scope', '$http', function ($scope, $http) {
        $scope.uitype = 'TRUE';
        $scope.currentuser = '';
        $scope.loginMe = function () {
            if ($scope.myForm.$valid) {
                var myData = {
                    username: $scope.username,
                    password: $scope.password
                }
                $scope.currentuser = $scope.username;
                $scope.isAjax = false;
                $http({
                    method: "POST",
                    url: myUrl + 'index.php/login/checklogindetail',
                    data: 'data=' + JSON.stringify(myData),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).
                        success(function (data) {
                            switch (data.type) {
                                case 'TRUE':
                                    //   alert(data.message);
                                    window.location = self.location;
                                    break;
                                case 'FIRSTTIMELOGIN':
                                    alert(data.message);
                                    $scope.uitype = 'FALSE';

                                    window.location = myUrl + 'index.php/login/changeidpassword';
                                    break;
                                case 'DEACTIVATED':
                                    alert(data.message);
                                    window.location = myUrl + 'index.php/login';
                                    break;
                                case 'RESET':

                                    window.location = myUrl + 'index.php/login/resetpassword';
                                    break;
                                case 'COMPANY':
//                                    alert(data.message);
                                    window.location = myUrl;
                                    break;
                                case 'DBNOTFOUND':
                                    alert(data.message);
                                    break;
                                case 'FALSE':
                                    alert(data.message);
                                    break;
                            }

                        }).
                        error(function (data) {

                            $scope.isAjax = true;

                        });
            } else {
                toastr.options.positionClass = "toast-bottom-full-width";
                toastr.error('Please enter the valid username and password  then try to login.', '');
            }
        }

        $scope.resetPassword = function () {
            if ($scope.userForm.$valid) {

                var myDataResetPassword = {
                    newpassword: $scope.newpassword,
                    reenternewpassword: $scope.reenternewpassword,
                    staff_id: staff_id
                };
                if ($scope.newpassword === $scope.reenternewpassword) {
                    $http({
                        method: 'POST',
                        url: myUrl + 'index.php/login/checkresetpassword',
                        data: 'data=' + JSON.stringify(myDataResetPassword),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (data) {
                        switch (data.type) {
                            case 'TRUE':
                                alert(data.message);
                                window.location = myUrl;
                                break;
                            case 'WRONG':
                                alert(data.message);
                                window.location = myUrl + 'index.php/login/resetpassword';
                                break;
                            case 'FALSE':
                                alert(data.message);
                                $scope.oldpassword = null;
                                break;
                        }

                    });
                } else {
                    toastr.options.positionClass = "toast-bottom-full-width";
                    toastr.error('New password and re-entered password does not match', '');
//                    $scope.newpassword = null;
//                    $scope.reenternewpassword = null;
                }

            } else {
                toastr.options.positionClass = "toast-bottom-full-width";
                toastr.error('Please enter the valid password then try to reset.', '');
            }
        }
        $scope.resetfirstPassword = function () {
            if ($scope.main.currentpassword === $scope.main.newpass) {
                alert('Your old And New Password is Same, Please enter different password');
            } else {
                var method = 'POST';
                var url = myUrl + 'index.php/login/changeuserpassword';
                var passworddata = {
                    staff_id: staff_id,
                    newpassword: $scope.main.newpass,
                    oldpassword: $scope.main.currentpassword
                }

                $http({
                    method: method,
                    url: url,
                    data: 'data=' + encodeURIComponent(angular.toJson(passworddata)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (data) {
                    switch (data.type) {
                        case 'TRUE':
                            alert(data.message);
                            window.location = myUrl + 'index.php';
                            break;
                        default:
                            alert(data.message);
                            break;
                    }
                });
            }
        }





        $scope.getolduser = function (medValue, index) {
            if ($scope.main.newuser) {
                if ($scope.main.newuser == medValue) {
                    $scope.user = 'yes';
                }
            }
        }
        $scope.getnewuser = function (medValue, index) {
            if ($scope.main.currentuser) {
                if ($scope.main.currentuser == medValue) {
                    $scope.user = 'yes';
                } else {
                    $scope.user = 'ok';
                }
            } else {
                $scope.user = 'no';
            }
        }
        $scope.verifycurrentpassword = function (medValue, index) {
            $http({
                method: 'POST',
                url: myUrl + 'index.php/login/verifypassword',
                data: 'data=' + medValue,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                if (data === 'TRUE') {
                    $scope.oldpass = 'yes';
                } else {
                    $scope.oldpass = 'NO';
                }
            });
        }

        $scope.getcurrentpassword = function (medValue, index) {
            if ($scope.main.newpass) {
                if ($scope.main.newpass == medValue) {
                    $scope.oldpass = 'yes';
                    $scope.type = 'no';
                } else {
                    $scope.oldpass = '';
                    $scope.type = '';
                }
            }
        }
        $scope.getNewpass = function (medValue, index) {
            if ($scope.main.repasword) {
                if ($scope.main.repasword == medValue) {
                    $scope.types = 'yes';
                } else {
                    $scope.types = 'no';
                }
            } else {
                $scope.type = 'no';
            }
            if ($scope.main.currentpassword) {
                if ($scope.main.currentpassword == medValue) {
                    $scope.oldpass = 'yes';
                    $scope.type = 'no';
                } else {
                    $scope.oldpass = '';
                    $scope.type = '';
                }
            } else {
                $scope.oldpass = 'no';
                $scope.type = '';
            }

        }
        $scope.getrepass = function (medValue, index) {
            if ($scope.main.newpass) {
                if ($scope.main.newpass == medValue) {
                    $scope.types = 'yes';
                } else {
                    $scope.types = 'no';
                }
            } else {
                $scope.types = 'ok';
            }

        }


        $scope.checkCount = 0;
        $scope.getmenudetails = function (id,empName) {
            $scope.empName=empName;
            $http({
                method: 'POST',
                url: myUrl + 'index.php/staff/menulist',
                data: 'data=' + encodeURIComponent(angular.toJson(id)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                $scope.menu = data.value.menuArr;
                $scope.checkCount = data.value.checkCount;
                $scope.masterid = id;

            });
        };

        $scope.save = function (data, masterid) {
            if (confirm('Do you want to save this?'))
            {
                var list = {
                    data: data,
                    emp_id: masterid
                };
                $http({
                    method: 'POST',
                    url: myUrl + 'index.php/staff/savelist',
                    data: 'data=' + encodeURIComponent(angular.toJson(list)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (data) {
                    if (data.type == 'TRUE') {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }

                });
                 $("#myModal").hide();y
            } else {
                return false;
            }
        }
        $scope.checkCountMe = function () {
            $scope.count = [];
            angular.forEach($scope.menu, function (val, key) {
                if (val.is_check === true) {
                    $scope.count.push(val.is_check);
                }
                $scope.checkCount = $scope.count.length;
            });
            $scope.checkCount = $scope.count.length;

        };
    }
]);
app.directive('ng-enter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});