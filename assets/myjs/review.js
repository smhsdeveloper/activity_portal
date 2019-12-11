var app = angular.module('review', ['blockUI', 'ngSanitize']);
app.controller('reviewEmpController', ['$scope', '$http', 'blockUI', '$timeout', function ($scope, $http, blockUI, $timeout) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/review/getyearlist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.yearData = jsondata.value;
        });
        $scope.slecectYear = false;
        $scope.getreviews = function () {
            $scope.slecectYear = true;
            var postData = {
                selectedPeroid: $scope.selectedYear
            };
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/getemployeeselfreviews',
                data: 'data=' + encodeURIComponent(angular.toJson(postData)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.reviewData = jsondata.value;
            });
        }


        $scope.saveSelfReviewEmp = function (data) {
            if (confirm('Do you want ?')) {
                var postData = {
                    selectedPeroid: $scope.selectedYear,
                    data: data
                }
                blockUI.start();
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/review/empselfreview',
                    data: 'data=' + encodeURIComponent(angular.toJson(postData)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    blockUI.stop();
                    if (jsondata.result == "TRUE") {
                        alert('Achievement Saved Successfully!');
                    } else {
                        alert('No Change Found');
                    }
                });
            } else {
                return false;
            }

        }
    }]);

app.controller('reviewRmController', ['$scope', '$http', 'blockUI', '$timeout', function ($scope, $http, blockUI, $timeout) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/review/getyearlist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.yearData = jsondata.value;
        });


        $scope.getreviews = function () {
            if (isAdmin) {
                if ($scope.rmid != '' && $scope.rmid) {
                    $scope.getRMEmpList();
                }
            } else {
                var postData = {
                    selectedPeroid: $scope.selectedYear
                };
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/review/getemployeereviews',
                    data: 'data=' + encodeURIComponent(angular.toJson(postData)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.reviewData = jsondata.value;

                });
            }

        }

        $scope.GetRmList = function () {
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/getallrms',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.rmData = jsondata;
            });
        }

        $scope.saveEmpReviewByRM = function (selectedObject) {
            var postData = {
                selectedPeroid: $scope.selectedYear,
                selectedEmp: selectedObject
            };
            blockUI.start();
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/empreviewbyrm',
                data: 'data=' + encodeURIComponent(angular.toJson(postData)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.result == "TRUE") {
                    if (isAdmin) {
                        $scope.getRMEmpList();
                    } else {
                        $scope.getreviews();
                    }
                    alert('Achievement Saved Successfully!');
                } else {
                    alert('Data not Save!');
                }
                blockUI.stop();
            });

        }

        $scope.getRMEmpList = function () {
            if ($scope.selectedYear && $scope.rmid != '') {
                var postData = {
                    selectedPeroid: $scope.selectedYear,
                    rmID: $scope.rmid
                };
                blockUI.start();
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/review/rmemplist',
                    data: 'data=' + encodeURIComponent(angular.toJson(postData)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    blockUI.stop();
                    $scope.reviewData = jsondata.value;

                });
            } else {
                alert('Please select month and reporting manager first.');
            }

        }

        $scope.showCopyBtn = false;
        $scope.selectedEmp = function (selectedObject) {

            $scope.overAllPreRating = 0;
            $scope.overAllRating = 0;
            $scope.selectedEmpObject = selectedObject;
            blockUI.start();
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/getemprating',
                data: 'data=' + encodeURIComponent(angular.toJson({selectedPeroid: $scope.selectedYear, emp_id: selectedObject.emp_id})),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                blockUI.stop();
                $scope.ratingData = jsondata.value;
                angular.forEach($scope.ratingData, function (val, key) {
                    if (parseFloat(val.prevrating) >= 0) {
                        $scope.showCopyBtn = true;
                    } else {
                        $scope.showCopyBtn = false;
                    }
                });
                $scope.getOverPreAll();
                $scope.getOverAll();

            });
        }
        $scope.saveEmpRating = function () {

            blockUI.start();
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/savemprating',
                data: 'data=' + encodeURIComponent(angular.toJson({selectedPeroid: $scope.selectedYear, emp_id: $scope.selectedEmpObject.emp_id, ratingData: $scope.ratingData})),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                blockUI.stop();
                alert(jsondata.message);
            });

        }


        $scope.getOverAll = function () {
            var totalRating = 0;
            angular.forEach($scope.ratingData, function (val, key) {
                if (parseFloat(val.rating) >= 0) {
                    if (parseInt(val.rating) > 10) {
                        $scope.ratingData[key].rating = 0;
                    } else {
                        totalRating = totalRating + parseFloat(val.rating);
                    }

                }
            });
            if (totalRating > 0) {
                $scope.overAllRating = (totalRating / $scope.ratingData.length);
            }

        }


        if (isAdmin) {
            $scope.GetRmList();
        }

        $scope.getOverPreAll = function () {
            var totalPreRating = 0;
            angular.forEach($scope.ratingData, function (val, key) {
                if (parseFloat(val.prevrating) >= 0) {
                    if (parseInt(val.prevrating) > 10) {
                        $scope.ratingData[key].prevrating = 0;
                    } else {
                        totalPreRating = totalPreRating + parseFloat(val.prevrating);
                    }
                }
            });
            if (totalPreRating > 0) {
                $scope.overAllPreRating = (totalPreRating / $scope.ratingData.length);
            }
        }
        $scope.ratingData = {};
        $scope.copyEmpRating = function () {
            angular.forEach($scope.ratingData, function (val, key) {
                if (parseFloat(val.prevrating) >= 0) {
                    $scope.ratingData[key].rating = angular.copy($scope.ratingData[key].prevrating);
                }
            });
            $scope.getOverAll();
        }
    }]);

app.controller('reviewAdminController', ['$scope', '$http', 'blockUI', '$timeout', function ($scope, $http, blockUI, $timeout) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/review/getallrms',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.rmData = jsondata;
        });

        $scope.updateEmpReviewByAdmin = function (selectedObject) { /////empreviewbyadmin
            if (confirm('Do you want ?')) {
                blockUI.start();
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/review/empreviewbyrm',
                    data: 'data=' + encodeURIComponent(angular.toJson(selectedObject)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    if (jsondata.result == "TRUE") {
                        alert('Achievement Saved Successfully!');
                    } else {
                        alert('Data not Save!');
                    }
                    blockUI.stop();
//                    location.reload();
                });
            } else {
                return false;
            }
        }
    }]);
// New code added by Dev
app.controller('reviewListingController', ['$scope', '$http', 'blockUI', '$timeout', function ($scope, $http, blockUI, $timeout) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/review/getyearlist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.yearData = jsondata.value;
        });

        $http({
            method: 'POST',
            url: myURL + 'index.php/review/getallrms',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.rmData = jsondata;
        });
        //$scope.reviewData = reviewData;

        $scope.pageReload = function () {
            if (isAdmin) {
                if ($scope.selectedYear && $scope.rmid) {
                    var postData = {
                        rmID: $scope.rmid,
                        selectedYear: $scope.selectedYear
                    };
                    $scope.getAllReviewsByRm(postData);
                }
            } else if (isRM) {
                if ($scope.selectedYear) {
                    var postData = {
                        selectedYear: $scope.selectedYear
                    };
                    $scope.getAllReviewsByRm(postData);
                }
            }
        }

        $scope.getAllReviewsByRm = function (postData) {

            blockUI.start();
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/reviewListing',
                data: 'data=' + encodeURIComponent(angular.toJson(postData)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                blockUI.stop();
                $scope.reviewData = jsondata;
            });
        }
        $scope.downloadExcel = function () {
            if (isAdmin) {
                if ($scope.selectedYear && $scope.rmid) {
                    var postData = {
                        rmID: $scope.rmid,
                        selectedYear: $scope.selectedYear,
                        action: 'downloadExcel',
                    };
                }
            } else if (isRM) {
                if ($scope.selectedYear) {
                    var postData = {
                        selectedYear: $scope.selectedYear,
                        action: 'downloadExcel',
                    };
                }
            }

            if (postData) {
                blockUI.start();
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/review/reviewListing',
                    data: 'data=' + encodeURIComponent(angular.toJson(postData)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    blockUI.stop();
                    window.open(jsondata);
                });
            }


        }

    }]);

app.filter('monthName', [function () {
        return function (monthNumber) { //1 = January
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
            return monthNames[monthNumber - 1];
        }
    }]);





