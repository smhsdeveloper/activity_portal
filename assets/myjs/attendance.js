var app = angular.module('attendance', ['720kb.datepicker']);
app.controller('attendanceController', ['$scope', '$http', function ($scope, $http) {

        $scope.entrydate = myDate;
        $http({
            method: 'POST',
            url: base_url + 'index.php/activity/attendancevis',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata.atten == 'NA') {
                $scope.type = 'true'
                $http({
                    method: 'POST',
                    url: base_url + 'index.php/activity/allempDetails',
                    data: 'date=' + myDate,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.alluser = jsondata;
                });
            } else {
                $scope.type = 'false'
                $scope.attendance = jsondata;
            }

        });
        $scope.actionClick = function (id) {
            if (confirm('Are You Sure Want to Mark Attendance As Absent')) {
                $http({
                    method: 'POST',
                    url: base_url + 'index.php/activity/markabsent',
                    data: 'data=' + id + '&date=' + myDate,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    if (jsondata.STATUS == 'TRUE') {
                        alert(jsondata.msg);
                        $http({
                            method: 'POST',
                            url: base_url + 'index.php/activity/allempDetails',
                             data: 'date=' + myDate,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            $scope.alluser = jsondata;
                        });

                    } else {
                        alert(jsondata.msg);
                    }
                });
            }

        }
    }]);