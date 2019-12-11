var app = angular.module('masterlogin', ['angucomplete']);
app.controller('masterLoginController', ['$scope', '$http', function ($scope, $http) {
        if (schoolId != '' && type != '') {
            $scope.schoolId = schoolId;
            $scope.type = type;
        } else {
            $scope.schoolId = 0;
            $scope.type = '';
        }
        $scope.myId = '';
        $scope.myErrorMsg = '';
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getschoollist',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.schoolList = jsondata;
        });
        $scope.getSchoolFullDeatil = function (mydata) {
            $scope.myErrorMsg = '';
            var data = {
                detail: mydata,
                schoolId: $scope.schoolId,
                type: $scope.type
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getfullschooldetail',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata == -1) {
                    $scope.myErrorMsg = 'No Result Found...';
                }
                else {
                    $scope.schoolDetails = jsondata;
                }
            });
        }
        $scope.masterLoginNow = function (userId) {
            var data = {
                user_id: userId,
                logintype: 'COMPANY'
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/masterloginas',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.value == 'TRUE') {
//                    alert(hellooooooooo);
                    window.location = myURL + 'index.php';
                }
                else {
                    alert(jsondata.message);
                }
            });
        }
    }]);
