var app = angular.module('versionapp', []);
app.controller('versionappcontroller', function ($scope, $http) {
    $http({
        method: 'POST',
        url: myURL + 'index.php/activity/gettestingproject',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
//        var response = JSON.parse(jsondata);
        if (jsondata.status === 'SUCCESS') {
            $scope.projectlist = jsondata.value;
            console.log(jsondata.value);
        } else {

        }


    });
    $scope.selectproject = function () {
        if ($scope.prjId !== '0') {
 window.location = myURL + 'index.php/activity/manageversion/' + $scope.prjId
        }else{
            
        }
    }
});