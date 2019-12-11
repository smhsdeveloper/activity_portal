var app = angular.module('dashboard', ['blockUI', '720kb.datepicker']);
app.controller('dashboardController', ['$scope', '$http', function ($scope, $http, blockUI) {

        $http({
            method: 'POST',
            url: myURL + 'index.php/testing/myactivity',
            data: 'data=' + userid,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.activity = jsondata;
        });
        $http({
            method: 'POST',
            url: myURL + 'index.php/testing/myrmactivity',
            data: 'data=' + userid,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.rmactivity = jsondata;
        });
        $http({
            method: 'POST',
            url: myURL + 'index.php/testing/alluser',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.alluser = jsondata;
        });
        $http({
            method: 'POST',
            url: myURL + 'index.php/testing/otpvalidation',
            data: 'date=' + today,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.otpvalidated = jsondata;
        });

        $scope.validateOTP = function (otp) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/testing/validateotp',
                data: 'data=' + otp + '&date=' + today,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.STATUS == 'SUCCESS') {
                    alert(jsondata.msg);
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/testing/otpvalidation',
                        data: 'date=' + today,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        $scope.otpvalidated = jsondata;
                    });
                } else {
                    alert(jsondata.msg);
                }
            });
        }

        $scope.myCount = 0;
        $scope.selecsingle = function (myDetail) {
            var hint = 0;
            angular.forEach(myDetail, function (value, key) {
                if (value.ischecked) {
                    hint++;
                }
            });
            if (hint == myDetail.length) {
                $scope.selectall = true;
            } else {
                $scope.selectall = false;
            }
            $scope.myCount = hint;
        };

        $scope.myCount1 = 0;
        $scope.adminselect = function (myDetail) {
            var hint = 0;
            angular.forEach(myDetail, function (value, key) {
                if (value.ischecked) {
                    hint++;
                }
            });
            if (hint == myDetail.length) {
                $scope.selectall1 = true;
            } else {
                $scope.selectall1 = false;
            }
            $scope.myCount1 = hint;
        };

        $scope.ishide1 = false;
        $scope.checkalladmin = function (myDetail) {
            angular.forEach(myDetail, function (value, key) {
                if ($scope.selectall1) {
                    $scope.ishide1 = true;
                    $scope.myCount1 = myDetail.length;
                    value.ischecked = true;
                } else {
                    $scope.ishide1 = false;
                    value.ischecked = false;
                    $scope.myCount1 = 0;
                }

            });
        };

        $scope.ishide = false;
        $scope.checkall = function (myDetail) {
            angular.forEach(myDetail, function (value, key) {
                if ($scope.selectall) {
                    $scope.ishide = true;
                    $scope.myCount = myDetail.length;
                    value.ischecked = true;
                } else {
                    $scope.ishide = false;
                    value.ischecked = false;
                    $scope.myCount = 0;
                }

            });
        };

        $scope.sendmailall = function (myDetail) {
            var hint = 0;
            angular.forEach(myDetail, function (value) {
                if (value.ischecked) {
                    hint++;
                }
            });
            if (hint > 0) {
                if (confirm('Are you sure, want to send mail !')) {
                    $('#myPleaseWait').modal('show');
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/review/sendreminder',
                        data: 'data=' + encodeURIComponent(angular.toJson(myDetail)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        $('#myPleaseWait').modal('hide');
                        $scope.myCount = 0;
                        if (jsondata.type == 'TRUE') {
                            $scope.ishide = true;
                            toastr.success(jsondata.message);
                            angular.forEach($scope.rmactivity, function (value, key) {
                                value.ischecked = false;

                            });
                            angular.forEach($scope.alluser, function (value, key) {
                                value.ischecked = false;

                            });
                            $scope.selectall = false;
                        } else {
                            $('#myPleaseWait').modal('hide');
                            toastr.warning(jsondata.message);
                            angular.forEach($scope.rmactivity, function (value, key) {
                                value.ischecked = false;

                            });
                            angular.forEach($scope.alluser, function (value, key) {
                                value.ischecked = false;

                            });
                            $scope.selectall = false;
                        }

                    });
                } else {
                    return false;
                }
            }
        };

        $scope.sendsingle = function (data) {
            var hint = 0;
            if (data.ischecked) {
                hint++;
            }
            if (hint > 0) {
                if (confirm('Are you sure, want to send mail !')) {
                    $('#myPleaseWait').modal('show');
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/review/sendsinglerem',
                        data: 'data=' + encodeURIComponent(angular.toJson(data)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        $('#myPleaseWait').modal('hide');
                        $scope.myCount = 0;
                        if (jsondata.type == 'TRUE') {
                            $scope.ishide = true;
                            toastr.success(jsondata.message);
                            angular.forEach($scope.rmactivity, function (value, key) {
                                value.ischecked = false;

                            });
                            angular.forEach($scope.alluser, function (value, key) {
                                value.ischecked = false;

                            });
                            $scope.selectall = false;
                        } else {
                            $('#myPleaseWait').modal('hide');
                            toastr.warning(jsondata.message);
                            angular.forEach($scope.rmactivity, function (value, key) {
                                value.ischecked = false;

                            });
                            angular.forEach($scope.alluser, function (value, key) {
                                value.ischecked = false;

                            });
                            $scope.selectall = false;
                        }

                    });
                } else {
                    return false;
                }
            }
        };


        $scope.showEmpDiv = false;
        //code added by dev
        $scope.RemaingTimeEmp = function () {
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/getremaintime',
                data: 'data=' + encodeURIComponent(angular.toJson({action: 'emp_time'})),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                // console.log('emp-'+jsondata.value);
                if (jsondata) {
                    // Set the date we're counting down to
                    var startDateTime = jsondata.value['start_datetime'];
                    var endDateTime = jsondata.value['end_datetime'];

                    var countDownDate = new Date(endDateTime).getTime();
                    var startCountDateTime = new Date(startDateTime).getTime();
                    var endCountDateTime = new Date(endDateTime).getTime();
                    var currentDateTime = new Date().getTime();

                    // Update the count down every 1 second
                    if (startCountDateTime <= currentDateTime && currentDateTime  <= endCountDateTime) {
                     //  alert('hhh');
                        $scope.showEmpDiv = true;
                        var x = setInterval(function () {
                            // Get todays date and time
                            var now = new Date().getTime();
                            // Find the distance between now an the count down date
                            var distance = countDownDate - now;
                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            // Output the result in an element with id="demo"
                            document.getElementById("emptimer").innerHTML = 'Time : ' + days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                            var finalTimer = 'Time : ' + days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                            // If the count down is over, write some text 
                            if (distance < 0) {
                                clearInterval(x);
                                var timerElement = angular.element(document.querySelector('#emptimer'));
                                timerElement.remove();
                            }
                            // $scope.timer = finalTimer;
                        }, 1000);
                    } else {
                        $scope.showEmpDiv = false;
//                        var timerElement = angular.element(document.querySelector('#emptimer'));
//                        timerElement.remove();
                    }
                } else {
//                    var timerElement = angular.element(document.querySelector('#emptimer'));
//                    timerElement.remove();
                }
            });
        }
        $scope.RemaingTimeEmp();
        $scope.showRmDiv = false;
        $scope.RemaingTimeRM = function () {
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/getremaintime',
                data: 'data=' + encodeURIComponent(angular.toJson({action: 'rm_time'})),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                 //console.log('rm-'+jsondata.value);
                if (jsondata) {
                    // Set the date we're counting down to
                    var startDateTime = jsondata.value['start_datetime'];
                    var endDateTime = jsondata.value['end_datetime'];

                    var countDownDate = new Date(endDateTime).getTime();
                    var startCountDateTime = new Date(startDateTime).getTime();
                    var endCountDateTime = new Date(endDateTime).getTime();
                    var currentDateTime = new Date().getTime();

                    // Update the count down every 1 second
                    if (startCountDateTime <= currentDateTime && currentDateTime  <= endCountDateTime) {
                       // alert('bbb');
                        $scope.showRmDiv = true;
                        var x = setInterval(function () {
                            // Get todays date and time
                            var now = new Date().getTime();
                            // Find the distance between now an the count down date
                            var distance = countDownDate - now;
                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            // Output the result in an element with id="demo"
                            document.getElementById("rmtimer").innerHTML = 'Time : ' + days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                            var finalTimer = 'Time : ' + days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                            // If the count down is over, write some text 
                            if (distance < 0) {
                                clearInterval(x);
                                var timerElement = angular.element(document.querySelector('#rmtimer'));
                                timerElement.remove();
                            }
                            // $scope.timer = finalTimer;
                        }, 1000);
                    } else {
                         $scope.showRmDiv = false;
//                        var timerElement = angular.element(document.querySelector('#rmtimer'));
//                        timerElement.remove();
                    }
                } else {
//                    var timerElement = angular.element(document.querySelector('#emptimer'));
//                    timerElement.remove();
                }
            });
        }
        $scope.RemaingTimeRM();

    }]);