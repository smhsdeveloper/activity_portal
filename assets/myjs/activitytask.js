var app = angular.module('activitytask', ['720kb.datepicker', 'timer']);
app.controller('activitytaskcontroller', ['$scope', '$http', '$interval', function ($scope, $http, $interval) {
        $scope.type = 'false';
        $scope.activity = 'false';
        $scope.workentry = 'false';
        $scope.othermoduleentry = 'false';
        $scope.otheractivityentry = 'false';
        $scope.moduletxtbx = 'FALSE';
        $scope.activitytxtbx = 'FALSE';
        $scope.othractivitybtn = 'FALSE';
        var mydata = [];
        $scope.timer = 0;

        
         $http({
            method: 'POST',
            url: myURL + 'index.php/activity/projectlist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.project = jsondata;
        });
        
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/gettabledetail',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.startwrk = jsondata;
            $scope.mySecond = 0;
            $interval(function () {
                angular.forEach($scope.startwrk, function (value, key) {
                    if (value.activity_status === 'START') {
                        value.timer = value.timer + $scope.mySecond;
                    } else {
                        value.timer = value.timer;
                    }
                    $scope.startwrk.timer = value.timer;

                });

            }, 1000);
         $scope.mySecond++;


        });
        
        $scope.SaveModule = function (){
            var data = {
                projectid:$scope.projectname,
                modulename:$scope.moduletext,
                empid:empid
            }
              $http({
                        method: 'POST',
                        url: myURL + 'index.php/activity/savemodule',
                        data: 'data=' + encodeURIComponent(angular.toJson(data)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                      if(jsondata > 0){
                        alert('Module added successfully');
                        $scope.activity = 'true';
                        $scope.otheractivityentry = 'false';
                      }else{
                        alert('Oops something went wrong...!!! ');
                        return false;
                      }
                    });
        }
        
         $scope.SaveActivity = function (){
           
              $http({
                        method: 'POST',
                        url: myURL + 'index.php/activity/saveactivity',
                        data: 'data=' + encodeURIComponent(angular.toJson($scope.activitytext)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                      if(jsondata > 0){
                        alert('Activity added successfully');
                        $scope.workentry = 'true';
                      }else{
                        alert('Oops something went wrong...!!! ');
                        return false;
                      }
                    });
        }
        

          $scope.selectproject = function () {

            if ($scope.projectname == 'NA') {
                $scope.type = 'false';
                $scope.textareavalue = '';
            } else {
                $scope.type = 'true';
                $scope.textareavalue = '';
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

        $scope.cancelactivtytxtbxbtn = function () {
            $scope.activitytxtbx = 'FALSE';
            $scope.otheractivityentry = 'false';
            $scope.othractivitybtn = 'FALSE';
        }

        $scope.selectactivity = function () {

            if ($scope.activityname == 'NA') {
                $scope.workentry = 'false';
                $scope.textareavalue = '';
            } else if ($scope.activityname == '12') {
                $scope.activitytxtbx = 'TRUE';
                $scope.otheractivityentry = 'true';
                $scope.othractivitybtn = 'TRUE';
                
            } else {
                $scope.workentry = 'true';
                $scope.textareavalue = '';
            }
        }

        $scope.cancelmodltxtbxbtn = function () {
            $scope.othermoduleentry = 'false';
            $scope.moduletxtbx = 'FALSE';
        }

        $scope.selectmodule = function () {

            if ($scope.modulename == 'NA') {

                $scope.activity = 'false';
                $scope.textareavalue = '';
            } else if ($scope.modulename == 'OTHER') {
                $scope.moduletxtbx = 'TRUE';
                $scope.othermoduleentry = 'true';
                 $http({
                    method: 'POST',
                    url: myURL + 'index.php/activity/activitylist',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.activitylist = jsondata;
                });
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

        $scope.othermodule = function () {
            $scope.othermoduleentry = 'true';
        }

        $scope.otheractivity = function () {
            $scope.otheractivityentry = 'true';
        }

        $scope.startwork = function () {
            if (confirm("Do you want to start work?")) {
                var status = '';
                angular.forEach($scope.startwrk, function (value, key) {
                    if (value.activity_status === 'START') {
                        status = 'START';
                    }

                });
                if (status === 'START') {
                    alert('You have already started Your Task please paused it');
                    return false;
                } else {
                    var data = {
                        projectid: $scope.projectname,
                        moduleid: $scope.modulename,
                        activityid: $scope.activityname,
                        workdetail: $scope.textareavalue,
                        date: myDate,
                        empid: empid
                    }

                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/activity/saveworkdetail',
                        data: 'data=' + encodeURIComponent(angular.toJson(data)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        $scope.startwrk = jsondata;
                        $scope.projectname = 'NA';
                        $scope.modulename = 'NA';
                        $scope.activityname = 'NA';
                        $scope.textareavalue = "";
                        alert('You have added a new Task please paused it');
                    });
                }
            }

        }

        $scope.startworktimer = function (index) {
            if (confirm("Do you want to start this work...?")) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/activity/checkstartwork',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    // if (jsondata < 2) {
                });

                var data = {
                    id: index,
                }
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/activity/startworkdetail',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    if (jsondata) {
                        $scope.startwrk = jsondata;
                        alert('Start work');

                    } else {
                        alert('Oops something went wrong...!!! ');
                        return false;
                    }
                });
                // }

            }

        }

        $scope.pauseworktimer = function (index) {
            if (confirm("Do you want to pause this work...?")) {
                var data = {
                    id: index,
                }
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/activity/pauseworkdetail',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    if (jsondata) {
                        $scope.startwrk = jsondata;
                        alert('Paused work');
                    } else {
                        alert('Oops something went wrong...!!! ');
                        return false;
                    }

                });

            }
        }
    }]);

app.filter('secondsToTime', function () {

    function padTime(t) {
        return t < 10 ? "0" + t : t;
    }

    return function (_seconds) {
        if (typeof _seconds !== "number" || _seconds < 0)
            return "00:00:00";

        var hours = Math.floor(_seconds / 3600),
                minutes = Math.floor((_seconds % 3600) / 60),
                seconds = Math.floor(_seconds % 60);

        return padTime(hours) + ":" + padTime(minutes) + ":" + padTime(seconds);
    };
});
