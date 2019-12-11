var app = angular.module('activityreportentry', ['720kb.datepicker']);
app.controller('activityreportentrycontroller', function ($scope, $http, $interval) {
    $scope.entrydate = myDate;
    $scope.changedate = function () {
        window.location = myURL + 'index.php/activity/empactivityentry/' + $scope.entrydate
    };

    GetEmployeeWorkedTime();
    function GetEmployeeWorkedTime() {
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/totalhour',
            data: 'date=' + myDate,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.totalhour = jsondata;
        });
    }
    $interval(function () {
        GetEmployeeWorkedTime();
    }, 6000);

});

var app = angular.module('empactivityview', ['blockUI', '720kb.datepicker']);
app.controller('activityviewcontroller', function ($scope, $http, blockUI) {
    if (hours.hour_worked == undefined) {
        $scope.totalhours = 0;
    } else {
        $scope.totalhours = hours.hour_worked;
    }

    $scope.getReport = function (from, to, empid) {
        window.location = myURL + 'index.php/activity/viewactivity/' + from + '/' + to + '/' + empid;
    }

    $scope.from = myDate;
    $scope.to = myDate;
//    $http({
//        method: 'POST',
//        url: myURL + 'index.php/activity/emplist',
//        data: '',
//        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
//    }).success(function (jsondata) {
//        $scope.emplist = jsondata;
//
//    });
    $http({
        method: 'POST',
        url: myURL + 'index.php/activity/emplisttype',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.emplist = jsondata;

    });
});

