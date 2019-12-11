var app = angular.module('testingApp', ['blockUI']);
app.controller('testingAppController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.myBugDetails = bug_details;
        $scope.remark_details1=remark_details;
        
        
        
        $scope.UpdateStatus = function (bug_id) {
            $scope.bug_id = bug_id;
            var myData = {
                bug_id: $scope.bug_id,
                developer_comment: $scope.developer_comment
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/testing/updatestatus',
                data: 'data=' + encodeURIComponent(angular.toJson(myData)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.message == 'YES') {
                    alert('Status Checked');
                } else {
                    alert('Status Already Checked');
                }
                window.location = self.location;
            });
        }
        $scope.UpdateStatusTester = function (bug_id) {
            $scope.bug_id = bug_id;
            var myData2 = {
                bug_id: $scope.bug_id,
                tester_comment: $scope.tester_comment
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/testing/updatestatustester',
                data: 'data=' + encodeURIComponent(angular.toJson(myData2)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.message == 'YES') {
                    alert('Status Done');
                } else {
                    alert('Status Already Done');
                }
                window.location = self.location;
            });
        }
        $scope.UpdatePendingStatusTester = function (bug_id) {
            $scope.bug_id = bug_id;
            var myData3 = {
                bug_id: $scope.bug_id,
                tester_comment: $scope.tester_comment
            }

            $http({
                method: 'POST',
                url: myURL + 'index.php/testing/updatestatuspending',
                data: 'data=' + encodeURIComponent(angular.toJson(myData3)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.message == 'YES') {
                    alert('Status Marked as PENDING');
                } else {
                    alert('Status Already PENDING');
                }
                window.location = self.location;
            });
        }
        $scope.SaveRemarkMessage = function () {
            var myDataRemark = {
                module_id: module_id,
                remark: $scope.remark,
                remark_from:remark_from,
                developer_id:developer_id
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/testing/saveremark',
                data: 'data=' + encodeURIComponent(angular.toJson(myDataRemark)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if(jsondata.message=='YES'){
                    window.location = self.location;
                }else{
                    alert("oops problem n message sending");
                }

            });
        }

    }]);
app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});