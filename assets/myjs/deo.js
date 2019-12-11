var app = angular.module('deo', ['blockUI']);
app.controller('deoController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getallstaffdata',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.staffData = jsondata;
        });
        $scope.loginAsTeacher = function (user_id) {
            var data = {
                user_id: user_id,
                logintype: 'DEO'
            }
              alert('Success1');
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/loginasteacher',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.value == 'TRUE') {
                    alert('Success');
                    window.location = myURL + 'index.php';
                }
                else {
                    alert(jsondata.message);
                }
            });
        }
    }]);
