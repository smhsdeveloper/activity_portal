var app = angular.module('reviewSettings', ['blockUI', 'ngSanitize', 'ui.bootstrap']);

app.filter('monthName', [function () {
        return function (monthNumber) { //1 = January
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
            return monthNames[monthNumber - 1];
        }
    }]);

// New code added by Dev
app.controller('reviewSettingController', ['$scope', '$http', 'blockUI', 'uibDateParser', function ($scope, $http, blockUI, $uibDateParser) {
        $scope.dateformat = 'dd-MM-yyyy';
        $scope.hstep = 1;
        $scope.mstep = 1;
        $scope.data = {};
        $scope.data.em_start_date = new Date();
        $scope.data.em_start_time = new Date();
        $scope.data.em_end_date = new Date();
        $scope.data.em_end_time = new Date();
        $scope.data.rm_start_date = new Date();
        $scope.data.rm_start_time = new Date();
        $scope.data.rm_end_date = new Date();
        $scope.data.rm_end_time = new Date();
        $scope.data.admin_start_date = new Date();
        $scope.data.admin_start_time = new Date();
        $scope.data.admin_end_date = new Date();
        $scope.data.admin_end_time = new Date();
        $scope.ismeridian = false;
        $scope.showTable = true;
        $scope.showForm = false;
        $http({
            method: 'POST',
            url: myURL + 'index.php/review/getfinancialyears',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.fylist = jsondata.value;
        });

        $http({
            method: 'POST',
            url: myURL + 'index.php/review/getmonthlist',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.monthlist = jsondata.value;
        });
        $scope.showAddNew = false;
        $scope.pageReload = function () {
            $scope.showAddNew = true;
            var postData = {
                selectedFy: $scope.fy
            };
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/getreviewsettings',
                data: 'data=' + encodeURIComponent(angular.toJson(postData)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.reviewSettings = jsondata.value;
                if (jsondata.value.length >= 12) {
                    $scope.showAddNew = false;
                } else {
                    $scope.showAddNew = true;
                }

            });
        }

        $scope.addReviewSettings = function () {
            $scope.dateformat = 'dd-MM-yyyy';
            $scope.hstep = 1;
            $scope.mstep = 1;
            $scope.data = {};
            $scope.data.em_start_date = new Date();
            $scope.data.em_start_time = new Date();
            $scope.data.em_end_date = new Date();
            $scope.data.em_end_time = new Date();
            $scope.data.rm_start_date = new Date();
            $scope.data.rm_start_time = new Date();
            $scope.data.rm_end_date = new Date();
            $scope.data.rm_end_time = new Date();
            $scope.data.admin_start_date = new Date();
            $scope.data.admin_start_time = new Date();
            $scope.data.admin_end_date = new Date();
            $scope.data.admin_end_time = new Date();
            $scope.ismeridian = false;
            $scope.showTable = false;
            $scope.showForm = true;
        }

        $scope.saveReviewSettings = function (data) {
            
            blockUI.start();
            $http({
                method: 'POST',
                url: myURL + 'index.php/review/savereviewsettings',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                blockUI.stop();
                $scope.pageReload();
                $scope.cancelReviewSettings();
                alert(jsondata.message);
            });
        }
        $scope.cancelReviewSettings = function () {
            $scope.showTable = true;
            $scope.showForm = false;
        }
        $scope.editReviewSettings = function (data) {

            $scope.showTable = false;
            $scope.showForm = true;
            $scope.data.id = data['id'];
            $scope.data.fy = data['financial_year'];
            $scope.data.month = data['month'];
            $scope.data.em_start_date = new Date(data['start_datetime']['EMP'].replace(/-/g, '/'));
            $scope.data.em_end_date = new Date(data['end_datetime']['EMP'].replace(/-/g, '/'));
            $scope.data.rm_start_date = new Date(data['start_datetime']['RM'].replace(/-/g, '/'));
            $scope.data.rm_end_date = new Date(data['end_datetime']['RM'].replace(/-/g, '/'));
            $scope.data.admin_start_date = new Date(data['start_datetime']['ADM'].replace(/-/g, '/'));
            $scope.data.admin_end_date = new Date(data['end_datetime']['ADM'].replace(/-/g, '/'));

            $scope.data.em_start_time = new Date(data['start_datetime']['EMP'].replace(/-/g, '/'));
            $scope.data.em_end_time = new Date(data['end_datetime']['EMP'].replace(/-/g, '/'));
            $scope.data.rm_start_time = new Date(data['start_datetime']['RM'].replace(/-/g, '/'));
            $scope.data.rm_end_time = new Date(data['end_datetime']['RM'].replace(/-/g, '/'));
            $scope.data.admin_start_time = new Date(data['start_datetime']['ADM'].replace(/-/g, '/'));
            $scope.data.admin_end_time = new Date(data['end_datetime']['ADM'].replace(/-/g, '/'));

        }
        $scope.deleteReviewSettings = function (month, fy) {
            if (month != '' && fy != '') {
                var data = {'month': month, 'fy': fy};
                if (confirm('Are you Sure!')) {
                    blockUI.start();
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/review/deletereviewsettings',
                        data: 'data=' + encodeURIComponent(angular.toJson(data)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        blockUI.stop();
                        $scope.pageReload();
                        alert(jsondata.message);
                        $scope.reviewSettings = jsondata.value;
                    });
                }
            }
        }
        $scope.keys = function (obj) {
            return obj ? Object.keys(obj) : [];
        }

    }]);



