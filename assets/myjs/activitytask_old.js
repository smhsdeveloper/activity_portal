var app = angular.module('activitytask', ['720kb.datepicker', 'timer', 'firebase']);
app.controller('activitytaskcontroller', ['$scope', '$http', '$firebaseObject', '$interval', function ($scope, $http, $firebaseObject, $interval) {
        $scope.type = 'false';
        $scope.activity = 'false';
        $scope.workentry = 'false';
        $scope.othermoduleentry = 'false';
        $scope.otheractivityentry = 'false';
        $scope.json = null;
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/projectlist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.project = jsondata;
        });
        $scope.selectproject = function () {
            if ($scope.projectname == 'NA') {
                $scope.type = 'false';
                $scope.textareavalue = '';
            } else {
                $scope.type = 'true';
                $scope.textareavalue = '';
                $scope.othermoduleentry = 'false';
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/activity/modulelist',
                    data: "data=" + $scope.projectname,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.module = jsondata;
                });
            }

        }
        $scope.selectactivity = function () {
            if ($scope.activityname == 'NA') {
                $scope.workentry = 'false';
                $scope.textareavalue = '';
            } else if ($scope.activityname == 'OTHER') {
                $scope.otheractivityentry = 'true';
            } else {
                $scope.workentry = 'true';
                $scope.textareavalue = '';

            }
        }
        $scope.selectmodule = function () {
            if ($scope.modulename == 'NA') {
                $scope.activity = 'false';
                $scope.textareavalue = '';
            } else if ($scope.modulename == 'OTHER') {
                $scope.othermoduleentry = 'true';
                $scope.activity = 'false';
            } else {
                $scope.activity = 'true';
                $scope.textareavalue = '';
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/activity/activitylist',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.activitylist = jsondata;
                });
            }

        }
        $scope.cancelmodule = function () {
            $scope.othermoduleentry = 'false';
        }
        $scope.cancelactivity = function () {
            $scope.otheractivityentry = 'false';
        }
        $scope.savemodule = function () {
            $http({
                method: 'POST',
                url: myURL + 'index.php/activity/moduleentry',
                data: 'data=' + $scope.projectname + '&module=' + $scope.othermodule,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {

                if (jsondata.STATUS === 'TRUE') {
                    alert(jsondata.msg);
                    $scope.othermoduleentry = 'false';

                } else {
                    alert(jsondata.msg);
                }
//            $scope.activitylist = jsondata;
            });

        }
        $scope.saveactivity = function () {
            $http({
                method: 'POST',
                url: myURL + 'index.php/activity/newactivity',
                data: 'data=' + $scope.otheractivity,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {

                if (jsondata.STATUS === 'TRUE') {
                    alert(jsondata.msg);
                    $scope.otheractivityentry = 'false';

                } else {
                    alert(jsondata.msg);
                }
//            $scope.activitylist = jsondata;
            });

        }
        $scope.startwork = function () {
            if ($scope.textareavalue === 'undefined') {
                alert('Blank');
            } else if ($scope.textareavalue === '') {
                alert('Blank');
            } else {
                var json = {
                    project_id: $scope.projectname,
                    module_id: $scope.modulename,
                    activity_id: $scope.activityname,
                    remarks: $scope.textareavalue
                }
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/activity/newtask',
                    data: 'data=' + encodeURIComponent(angular.toJson(json)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    if (jsondata.STATUS === 'TRUE') {
                        alert(jsondata.msg);
                        $scope.json = jsondata.data;
                    } else {
                        alert(jsondata.msg);
                    }
                });

//            console.log(data);
//
//            alert(data);
            }
        }
        $scope.pause =function (index){
              $scope.json[index].status = 'PAUSED'; 
        }
        $scope.start =function (index){
              $scope.json[index].status = 'START'; 
        }
       

        var myFirebaseRef = new Firebase("https://activityporta.firebaseio.com/" + myDate + '/' + empid);

        var syncObject = $firebaseObject(myFirebaseRef);
        syncObject.$bindTo($scope, "json");
         
        $scope.mySecond = 1;
        $interval(function () {
            delete $scope.json.$id;
            delete $scope.json.$priority;
            angular.forEach($scope.json, function (value, key) {
               if (value.status === 'START') {
                    value.worktime = $scope.mySecond;
                }
            });
            $scope.mySecond++;
//            angular.forEach($scope.json, function (value, key) {
//               console.log(value.status);
//            });
//
////            if ($scope.json.status === 'START') {
////                $scope.json.status.hour_worked = $scope.mySecond;
////            }
////            $scope.examdata.questionset[questype].paperduration = ($scope.examdata.questionset[questype].paperduration - $scope.mySecond);
        }, 1000);
    }]);