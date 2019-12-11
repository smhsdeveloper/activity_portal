var app = angular.module('otp', ['720kb.datepicker']);
app.controller('otpController', ['$scope', '$http', function($scope, $http) {
        $scope.datea = currentDate;
        $scope.seleDate = function(date) {
            $scope.datea = date;
            $http({
                method: 'POST',
                url: myURL + 'index.php/activity/otpvalidate',
                data: 'data=' + $scope.datea,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(jsondata) {
                $scope.otpstatus = jsondata;
            });
        }
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/otpvalidate',
            data: 'data=' + $scope.datea,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(jsondata) {
            $scope.otpstatus = jsondata;
        });

    }]);