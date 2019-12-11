var app = angular.module('exam', ['timer', 'firebase']);
app.controller('examController', ['$scope', '$http', '$firebaseObject', function($scope, $http, $firebaseObject) {
        $scope.indexcount = 0;
//        $scope.examdata = {};
        $scope.questiontype = questype;
        $scope.examkey = examkey;

        $scope.nextquestion = function(queIndex, queSetIndex) {
            $scope.examdata.questionset[queSetIndex].queitionsArr[queIndex].status = 'ANSWERD';
            $scope.indexcount = queIndex + 1;
            $scope.setindexval = queSetIndex;
        };
        $scope.skipquestion = function(questionindex, setindex) {
            $scope.examdata.questionset[setindex].queitionsArr[questionindex].status = 'skip';
            $scope.indexcount = questionindex + 1;
        };
        $scope.prequestion = function(queIndex) {
            if (queIndex == '0') {
                $scope.indexcount = 0;
            } else {
                $scope.indexcount = queIndex - 1;
            }
        };
        $scope.startExam = function(setindex) {
            $scope.examdata.questionset[setindex].examstatus = 'START';
            $scope.examdata.startexam = 'YES';
            $scope.examdata.startsetindex = setindex;
        };
        $scope.enableNext = function(questionindex, setindex) {
            $scope.examdata.questionset[setindex].queitionsArr[questionindex].enableNext = true;
        };
        $scope.submit = function(setindex) {
            if (confirm('Are you sure want to submit your test?')) {
                $scope.examdata.questionset[setindex].examstatus = 'MANUALSUBMIT';
               delete $scope.examdata.startexam;
               delete $scope.examdata.startsetindex;
//                $scope.examdata.splice('startsetindex');
            }
        };
        var myFirebaseRef = new Firebase("https://blazing-inferno-4971.firebaseio.com/32062501545402122154501215240560");

        var syncObject = $firebaseObject(myFirebaseRef);
        syncObject.$bindTo($scope, "examdata");
        
        console.log(syncObject.questionset);
    }]
        );
