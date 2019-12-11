var app = angular.module('summary', ['blockUI', '720kb.datepicker']);
app.controller('summarycontroller', function ($scope, $http, blockUI) {
    $http({
        method: 'POST',
        url: myURL + 'index.php/activity/emplist',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.emplist = jsondata;

    });
    if (empid) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/getactivitysummary',
            data: 'from=' + from + "&to=" + to + "&empid=" + empid,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.totalActivityHours = jsondata.total_activity_hour;
            $scope.summary = jsondata.summary;
        });
    }
    $scope.exportSummary = function (from, to, empid) {
        var param = empid ? 'from=' + from + "&to=" + to + "&empid=" + empid : 'from=' + from + "&to=" + to;
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/exportsummary',
            data: param,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata.status == "SUCCESS") {
                alert(jsondata.message);
                window.open(myURL + jsondata.path);
            }
        });
    };
    $scope.getReport = function (from, to, empid) {
        window.location = myURL + 'index.php/activity/viewactivitysummary/' + from + '/' + to + '/' + empid;
    };
});
var app = angular.module('projectsummary', ['blockUI', '720kb.datepicker']);
app.controller('projectsummarycontroller', function ($scope, $http, blockUI) {
    $scope.showResult = false;
    $http({
        method: 'POST',
        url: myURL + 'index.php/activity/getprojectlist',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.projectList = jsondata;
    });
    $scope.showSummary = function (prjId) {
        $scope.projectSummary = {};
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/getProjectSummary',
            data: "prjId=" + prjId,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.projectSummary = jsondata;
            $scope.showResult = true;
        });
    };
    $scope.exportSummary = function (prjId) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/exportprojectsummary',
            data: "prjId=" + prjId,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata.type == "SUCCESS") {
                alert(jsondata.message);
                window.open(myURL + jsondata.value);
            }
        });
    };
    $scope.changeShowResult = function () {
        $scope.projectSummary = {};
        $scope.showResult = false;
    };
});


//.................................Akash Giri (Month Wise Report)................................//

var app = angular.module('monthreport', ['blockUI', '720kb.datepicker']);
app.controller('monthreportcontroller', function ($scope, $http, blockUI) {

    $scope.monthname = [{"value": "01", "Month": "January"}, {"value": "02", "Month": "February"}, {"value": "03", "Month": "March"},
        {"value": "04", "Month": "April"}, {"value": "05", "Month": "May"}, {"value": "06", "Month": "June"},
        {"value": "07", "Month": "July"}, {"value": "08", "Month": "August"}, {"value": "09", "Month": "September"},
        {"value": "10", "Month": "October"}, {"value": "11", "Month": "November"}, {"value": "12", "Month": "December"}];

    $scope.year = [{"value": "2016"}, {"value": "2017"}, {"value": "2018"}];

    $http({
        method: 'POST',
        url: myURL + 'index.php/activity/projectlists',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.projectList = jsondata.value;
    });

    $scope.getreports = function () {
//        if (new Date($scope.fromdate) > new Date($scope.todate)) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/monthreports',
            data: 'data=' + encodeURIComponent(angular.toJson($scope.month)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata.value.UserList.length == 0) {
                toastr.error('No Data Found !');
                return false;
            }
            $scope.reports = jsondata.value.UserList;
            $scope.monthlist = jsondata.value.MonthList;
            $scope.grand_sum = jsondata.value.grand_totalsum;
            $scope.rating_sum = jsondata.value.rating_sum;
        });
//        } else {
//            toastr.warning('from date not greater than to date !');
//            return false;
//        }
    };

    $scope.getactiviydata = function (data, project_id, index) {

        var data = {
            'data': data,
            'project_id': project_id,
            'month_id': $scope.monthlist[index].id,
            'year': $scope.monthlist[index].year
        };
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/getactiviydata',
            data: 'data=' + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata.value.userlist.length == 0) {
                $scope.data = '';
                return false;
            } else {
                $scope.data = jsondata.value.userlist;
            }

        });
    };

    $scope.getreport = function () {
        var data = {
            'fromdate': $scope.month.fromdate,
            'todate': $scope.month.todate,
            'rating': $scope.month.rating,
            'project_id': $scope.month.project_id
        }
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/monthreports',
            data: 'data=' + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.reports = jsondata.value.UserList;
            $scope.monthlist = jsondata.value.MonthList;
            $scope.grand_sum = jsondata.value.grand_totalsum;
            $scope.rating_sum = jsondata.value.rating_sum;
        });
    };

    $scope.generateExcel = function (tableid, Filename, skpFlCls = null) {
        $(function () {
            $("#" + tableid).table2excel({
                exclude: "." + skpFlCls,
                filename: Filename + ".xls"
            });
        }
        );
    }
    ;

});

//.................................Akash Giri (Month Wise Bar Chart)................................//

var app = angular.module('barchart', ['blockUI']);
app.controller('barchartcontroller', function ($scope, $http, blockUI) {

    $http({
        method: 'POST',
        url: myURL + 'index.php/activity/projectlists',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.projectList = jsondata.value;
    });

    $scope.getchartdata = function (project_id) {
        var data = {
            'project_id': project_id
        };
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/chartdata',
            data: 'data=' + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata.value.chartdata.length == 0) {
                toastr.error('No Data Found !');
                return false;
            }
            $scope.showGraph("graphContainer", jsondata.value.chartdata, jsondata.value.category);
        });

    };


    $scope.showGraph = function (container, data, category) {
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Project wise Report'
            },
            xAxis: {
                categories: category,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Hours',
                }, labels: {
                    format: '{value}',
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f}hr</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 2
                }
            },
            series: data
        });
    };
});

//.................................Akash Giri (Top 10 project)................................//

var app = angular.module('topproject', ['blockUI', '720kb.datepicker']);
app.controller('topprojectcontroller', function ($scope, $http, blockUI) {

    $scope.monthname = [{"value": "01", "Month": "January"}, {"value": "02", "Month": "February"}, {"value": "03", "Month": "March"},
        {"value": "04", "Month": "April"}, {"value": "05", "Month": "May"}, {"value": "06", "Month": "June"},
        {"value": "07", "Month": "July"}, {"value": "08", "Month": "August"}, {"value": "09", "Month": "September"},
        {"value": "10", "Month": "October"}, {"value": "11", "Month": "November"}, {"value": "12", "Month": "December"}];

    $scope.year = [{"value": "2016"}, {"value": "2017"}, {"value": "2018"}];

    $scope.getreports = function () {
//        if (new Date($scope.fromdate) > new Date($scope.todate)) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/activity/monthreports',
            data: 'data=' + encodeURIComponent(angular.toJson($scope.month)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata.value.data.length == 0) {
                toastr.error('No Data Found !');
                return false;
            }
            $scope.data = jsondata.value.data;
            $scope.showGraph("graphContainer", jsondata.value.data, jsondata.value.category);
        });
//        } else {
//            toastr.warning('from date not greater than to date !');
//            return false;
//        }
    };


    $scope.showGraph = function (container, data, category) {
        var chart = Highcharts.chart('container', {
            title: {
                text: 'Top Ten Project'
            },
            xAxis: {
                categories: category
            },
            series: [{
                    type: 'column',
                    colorByPoint: true,
                    data: data,
                    showInLegend: false
                }]

        });


        $('#plain').click(function () {
            chart.update({
                chart: {
                    inverted: false,
                    polar: false
                }
            });
        });

        $('#inverted').click(function () {
            chart.update({
                chart: {
                    inverted: true,
                    polar: false
                }
            });
        });

        $('#polar').click(function () {
            chart.update({
                chart: {
                    inverted: false,
                    polar: true
                }
            });
        });
    };
});

//.................................Akash Giri Daily Summary................................//

var app = angular.module('dailysummary', ['blockUI']);
app.controller('dailysummarycontroller', function ($scope, $http, blockUI) {

    var data = {
        'staff_id': staff_id,
        'project_id': project_id,
        'month_id': month_id,
        'year': year
    };
    $http({
        method: 'POST',
        url: myURL + 'index.php/activity/getactiviydata',
        data: 'data=' + encodeURIComponent(angular.toJson(data)),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        if (jsondata.value.userlist.length == 0) {
            $scope.reports = '';
            return false;
        } else {
            $scope.project_name = jsondata.value.project_name.title;
            $scope.staff_name = jsondata.value.staff_name.name;
            $scope.reports = jsondata.value.userlist;
        }

    });


});
