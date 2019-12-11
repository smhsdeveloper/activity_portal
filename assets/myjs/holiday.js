var app = angular.module('holiday', ['720kb.datepicker']);
app.controller('holidayController', ['$scope', '$http', function($scope, $http) {
        $scope.year = year;
        $scope.month = month;
        $scope.selectYear = function() {
            window.location = base_url + 'index.php/activity/holiday/' + $scope.yearval;
        }
//        $scope.selectMonth = function() {
//            if (years === 'NA') {
//                alert('Please select Year');
//                return false;
//            } else {
//                window.location = base_url + 'index.php/activity/holiday/' + years + '/' + $scope.monthval;
//            }
//
//        }
    }]);