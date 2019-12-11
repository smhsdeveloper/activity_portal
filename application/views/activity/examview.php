<!--!DOCTYPE html>-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Online Exam</title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url() ?>assets/examcss/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
                display: none !important;
            }
        </style>
    </head>
    <body ng-app="exam" ng-controller="examController" class="ng-cloak">
        {{examdata}}

        <div style="width:100%;"> 
            <table style="width:100%; border-collapse: collapse;">
                <tr>
                    <td style="text-align: right; width:15%;">
                        <img src="<?php echo base_url() ?>assets/{{examdata.companylogo}}" />
                    </td>
                    <td style="text-align: left;  width:35%;">
                        <p style="font-size: 40px;font-weight:normal;">{{examdata.companyname}}</p>  
                        <p style="font-size: 15px;font-weight:normal;margin-top:-8px;margin-left: 70px">22, KG Marg, Janpath, Barakhamba, New Delhi, Delhi 110001</p>
                    </td>
                </tr> 
            </table>
        </div>
        <div ng-if="examdata.startexam">
            <div ng-if="examdata.startsetindex === questiontype">

                <div ng-if="examdata.questionset[questiontype].examstatus !== 'NOTSTART'">
                    <div ng-if="examdata.questionset[questiontype].examstatus !== 'MANUALSUBMIT'">
                        <div ng-if="examdata.questionset[questiontype].examstatus !== 'AUTOSUBMIT'">
                            <!--{{examstatus}} !== 'autocomplete' || {{examstatus}} !== 'manualcomplete'-->
                            <div class="row">                
                                <div class="col-sm-12">
                                    <section class="panel">                        
                                        <div class="panel-body"> 
                                            <div class="form-control">
                                                <span class="">{{examdata.empname}}</span>
                                                <!--{{examdata.questionset[questiontype].paperduration}}-->
                                                <!--//ng-repeat="time in examdata.questionset"-->
                                                <span class="pull-right text-bold text-danger" >Remaning Time : <timer end-time="1451628000000">{{days}} days, {{hours}} hours, {{minutes}} minutes, {{seconds}} seconds.</timer></span>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>        
                            <div class="row">
                                <div class="col-sm-4">
                                    <section class="panel">
                                        <div class="panel-body">
                                            <table class="table">
                                                <tbody >
                                                    <tr ng-repeat="que in examdata.questionset[questiontype].queitionsArr" >
                                                        <td ng-if="que.status">{{$index + 1}} {{que.que| limitTo:20}}.......<span class="pull-right">{{que.status}}</span></td>
                                                        <!--<td class="pull-right"></td>-->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-sm-8">
                                    <section class="panel">
                                        <div class="panel-body">
                                            <div ng-repeat="x in examdata.questionset">
                                                <div ng-show="$index == questiontype">

                                                    <div class="form-group">
                                                        <label for="inputSuccess" class="col-sm-12 text-center control-label col-lg-12">{{x.papername}}</label>
                                                    </div>
                                                    <div ng-repeat="questuion in x.queitionsArr">
                                                        <div ng-show="$index == indexcount">
                                                            <div class="form-group">
                                                                <label for="inputSuccess" class="col-sm-12 control-label col-lg-12">{{$index + 1}}. {{questuion.que}}</label>
                                                            </div>
                                                            <div class="col-sm-12" ng-if="questuion.quetionType == 'OBJ'">
                                                                <div class="col-sm-8" ng-repeat="option in questuion.options">
                                                                    <div class="form-group">
                                                                        <div>
                                                                            <div>
                                                                                <input type="radio" ng-model="examdata.questionset[questiontype].queitionsArr[$parent.$parent.$index].seloptions" ng-click="enableNext($index, questiontype)" value="{{option.val}}" id="{{'opt' + $parent.$parent.$index + $parent.$index + $index}}" name="{{'opt' + $parent.$parent.$index + $parent.$index}}"><label for="{{'opt' + $parent.$parent.$index + $parent.$index + $index}}">  {{option.val}}</label>
                                                                                <!--<input type="radio" ng-model="examdata.questionset[$parent.$parent.$index].queitionsArr[$parent.$index].options[$index].sts" name="{{'opt'+$parent.$parent.$index+$parent.$index}}" value="{{option.val}}"> {{option.val}}-->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12" ng-if="questuion.quetionType == 'MUL'">
                                                                <div class="col-sm-8" ng-repeat="option in questuion.options">
                                                                    <div class="form-group">
                                                                        <div>
                                                                            <div>
                                                                                <input type="checkbox" ng-model="examdata.questionset[questiontype].queitionsArr[$parent.$index].options[$index].sts" ng-click="enableNext($index, questiontype)" value="{{option.val}}"> {{option.val}}
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12" ng-if="questuion.quetionType == 'SUB'">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <div>
                                                                            <div>
                                                                                <textarea type="text" rows="5" ng-model="examdata.questionset[questiontype].queitionsArr[$parent.$index].selctedAns" ng-click="enableNext($index, questiontype)" class="form-control" placeholder="{{questuion.selctedAns}}"></textarea>
                                                                                <!--ng-trim="false" maxlength="250"-->
                                                                                <!--<span>{{250 - examdata.questionset[$parent.$parent.$index].queitionsArr[$parent.$index].selctedAns.length}} left</span>-->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <button ng-if="indexcount != 0" class="btn btn-info" ng-click="prequestion($index);">Previous</button>

                                                                    <button ng-disabled="!questuion.enableNext" ng-if="indexcount + 1 < x.queitionsArr.length" class="btn btn-info pull-right" ng-click="nextquestion($index, $parent.$parent.$index);">Next</button>
                                                                    <button ng-if="indexcount + 1 < x.queitionsArr.length" class="btn btn-primary pull-right" ng-click="skipquestion($index, $parent.$parent.$index);">Skip</button>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <center><button class="btn btn-default" ng-click="submit(questiontype);">Submit Test</button></center>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div ng-if="examdata.startsetindex !== questiontype">
                <div class="col-sm-12">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group"> 
                                    <label class="col-sm-8 ">Please submit {{examdata.questionset[examdata.startsetindex].papername}}  </label> 
                                </div>

                            </div>
                            <div class="col-sm-4">
                            </div>

                        </div>

                    </section>
                </div>
            </div>
        </div>

        <div ng-if="examdata.startexam !== 'YES'">
            
            <div class="row height-10" ng-if="examdata.questionset[questiontype].examstatus == 'NOTSTART'">                
                <div class="col-sm-12">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group"> 
                                    <label class="col-sm-8 pull-left">Welcome </label> 
                                    <span class="col-sm-4 pull-left">{{examdata.empname}}</span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-8 pull-left">Subject: </label> 
                                    <span class="col-sm-4 pull-left">{{examdata.questionset[questiontype].papername}}</span>
                                </div>
                                <div class="form-group"> 
                                    <label class="col-sm-8 pull-left">Total number of questions : </label> 
                                    <span class="col-sm-4 pull-left">{{examdata.questionset[questiontype].totalquestion}}</span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-8 pull-left">Time alloted:  </label>
                                    <span class="col-sm-4 pull-left"><mydate>{{examdata.questionset[questiontype].paperduration| date:'HH:mm'}}</mydate></span>
                                </div>

                                <div class="form-action">
                                    <div class="col-sm-4">
                                        <button class=" btn btn-primary  pull-left" ng-click="startExam(questiontype);">Start  Test</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>

                        </div>

                    </section>
                </div>

            </div>
        </div>
        <div ng-if="examdata.questionset[questiontype].examstatus === 'MANUALSUBMIT'">
            <div class="row height-10">                
                <div class="col-sm-12">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4 text-center">
                                <div class="form-group"> <label>You have Already Submited This Exam</label></div>
                            </div>
                            <div class="col-sm-4">
                            </div>

                        </div>

                    </section>
                </div>
            </div>
        </div>


    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url() ?>assets/examjs/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/examjs/angular.min.js"></script>
    <!-- Firebase -->
    <script src="https://cdn.firebase.com/js/client/2.2.4/firebase.js"></script>
    <!-- AngularFire -->
    <script src="https://cdn.firebase.com/libs/angularfire/1.1.3/angularfire.min.js"></script>
    <!-- Timer -->
    <script src="<?php echo base_url() ?>assets/examjs/angular-timer-all.min.js"></script>
    <!--<script src="<?php echo base_url() ?>assets/examjs/angular-timer-bower.js"></script>-->

    <script src="<?php echo base_url() ?>assets/exammyjs/exam.js"></script>
    <script>
            var questype = '<?php echo $examtype ?>';
            var examkey = '<?php echo $examkey ?>';
            var base_url = '<?php echo base_url(); ?>';
    </script>
</body>
</html>