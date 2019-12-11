
var app = angular.module('activitymail', []);

app.controller('activitymailcontroller', ['$scope', '$http', function ($scope, $http) {

        $scope.sendEmail = function (staffid) {
            if (confirm('Are you sure want to send Email')) {
                if (staffid) {
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/activity/sendEmail',
                        data: 'data=' + staffid,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        if (jsondata === 'Email_Sent') {
                            alert('Email Successfully Sent');
                        } else if (jsondata === 'Contact_to _Admin') {
                            alert('Please Contact to Admin !');
                        } else if (jsondata === 'Email_Password_Not_found') {
                            alert('Email Password not Fouund!');
                        } else {
                            alert('Email not Fouund!');
                        }
                    });
                } else {
                    alert('Please Contact to Admin !');
                }
            }

        }

    }]);