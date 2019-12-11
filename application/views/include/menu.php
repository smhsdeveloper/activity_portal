<ul id="main-menu" class="gui-controls">
    <?php
    $urlData = explode("/", uri_string());
    $myFinalURL=array();
    $uriString="";
    for($i=0; $i<2; $i++) {
        $myFinalURL[]=$urlData[$i]; 
    }
    if(count($myFinalURL)>0){
        $uriString=  implode("/", $myFinalURL);
       
    }
    
    foreach ($this->session->userdata('staffMenu') as $value) {
        $childCount = checkSelectedChildMenu($value['childDetail'],$uriString);
        if ($childCount['count'] > 0) {
            if ($childCount['count'] == 1) {

                foreach ($value['childDetail'] as $value1) {
                    if ($value1['selected']) {
                        ?>
                        <li class="expanding">
                            <a class="<?php echo $childCount['selectedClass']; ?>" href="<?php echo base_url() . $value1['page_url']; ?>">
                                <div class="gui-icon"><i class="md <?php echo $value['class']; ?>"></i></div>
                                <span class="title"><?php echo $value1['childcaption']; ?></span>
                            </a>
                        </li>

                        <?php
                    }
                }
                ?>

                <?php
            } else {
                ?>
                <li class="gui-folder">
                    <a class="<?php echo $childCount['selectedClass']; ?>">
                        <div class="gui-icon"><i class="md <?php echo $value['class']; ?>"></i></div>
                        <span class="title"><?php echo $value['menuname']; ?></span>
                    </a>
                    <!--start submenu -->
                    <ul>
                        <?php
                        foreach ($value['childDetail'] as $value) {
                            if ($value['selected']) {
                                ?>
                                <li><a href="<?php echo base_url() . $value['page_url']; ?>" ><span class="title"><?php echo $value['childcaption']; ?></span></a></li>

                                <?php
                            }
                        }
                        ?>


                    </ul><!--end /submenu -->
                </li>
                <?php
            }
        }
    }

    function checkSelectedChildMenu($childDetail,$uriString) {
        $count = 0;
        $selectedClass="";
        foreach ($childDetail as $value) {
            if ($value['selected']) {
               
                if($value['page_url']=="index.php/$uriString"){
                 $selectedClass='active';
                }
                $count++;
            }
        }
        return array("count"=>$count,"selectedClass"=>$selectedClass);
    }
    ?>
    <!--end /menu-li -->
    <!--                         END EMAIL 
    
                             BEGIN DASHBOARD 
                            <li>
                                <a href="../layouts/builder.html" >
                                    <div class="gui-icon"><i class="md md-web"></i></div>
                                    <span class="title">Layouts</span>
                                </a>
                            </li>end /menu-li 
                             END DASHBOARD 
    
                             BEGIN UI 
                            <li class="gui-folder">
                                <a>
                                    <div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
                                    <span class="title">UI elements</span>
                                </a>
                                start submenu 
                                <ul>
                                    <li><a href="../ui/colors.html" ><span class="title">Colors</span></a></li>
    
                                    <li><a href="../ui/typography.html" ><span class="title">Typography</span></a></li>
    
                                    <li><a href="../ui/cards.html" ><span class="title">Cards</span></a></li>
    
                                    <li><a href="../ui/buttons.html" ><span class="title">Buttons</span></a></li>
    
                                    <li><a href="../ui/lists.html" ><span class="title">Lists</span></a></li>
    
                                    <li><a href="../ui/tabs.html" ><span class="title">Tabs</span></a></li>
    
                                    <li><a href="../ui/accordions.html" ><span class="title">Accordions</span></a></li>
    
                                    <li><a href="../ui/messages.html" ><span class="title">Messages</span></a></li>
    
                                    <li><a href="../ui/offcanvas.html" ><span class="title">Off-canvas</span></a></li>
    
                                    <li><a href="../ui/grid.html" ><span class="title">Grid</span></a></li>
    
                                    <li class="gui-folder">
                                        <a href="javascript:void(0);">
                                            <span class="title">Icons</span>
                                        </a>
                                        start submenu 
                                        <ul>
                                            <li><a href="../ui/icons/materialicons.html" ><span class="title">Material Design Icons</span></a></li>
    
                                            <li><a href="../ui/icons/fontawesome.html" ><span class="title">Font Awesome</span></a></li>
    
                                            <li><a href="../ui/icons/glyphicons.html" ><span class="title">Glyphicons</span></a></li>
    
                                            <li><a href="../ui/icons/skycons.html" ><span class="title">Skycons</span></a></li>
    
                                        </ul>end /submenu 
                                    </li>end /menu-li 
                                </ul>end /submenu 
                            </li>end /menu-li 
                             END UI 
    
                             BEGIN TABLES 
                            <li class="gui-folder">
                                <a>
                                    <div class="gui-icon"><i class="fa fa-table"></i></div>
                                    <span class="title">Tables</span>
                                </a>
                                start submenu 
                                <ul>
                                    <li><a href="../tables/static.html" ><span class="title">Static Tables</span></a></li>
    
                                    <li><a href="../tables/dynamic.html" ><span class="title">Dynamic Tables</span></a></li>
    
                                    <li><a href="../tables/responsive.html" ><span class="title">Responsive Table</span></a></li>
    
                                </ul>end /submenu 
                            </li>end /menu-li 
                             END TABLES 
    
                             BEGIN FORMS 
                            <li class="gui-folder">
                                <a>
                                    <div class="gui-icon"><span class="glyphicon glyphicon-list-alt"></span></div>
                                    <span class="title">Forms</span>
                                </a>
                                start submenu 
                                <ul>
                                    <li><a href="../forms/basic.html" ><span class="title">Form basic</span></a></li>
    
                                    <li><a href="../forms/advanced.html" ><span class="title">Form advanced</span></a></li>
    
                                    <li><a href="../forms/layouts.html" ><span class="title">Form layouts</span></a></li>
    
                                    <li><a href="../forms/editors.html" ><span class="title">Editors</span></a></li>
    
                                    <li><a href="../forms/validation.html" ><span class="title">Form validation</span></a></li>
    
                                    <li><a href="../forms/wizard.html" ><span class="title">Form wizard</span></a></li>
    
                                </ul>end /submenu 
                            </li>end /menu-li 
                             END FORMS 
    
                             BEGIN PAGES 
                            <li class="gui-folder">
                                <a>
                                    <div class="gui-icon"><i class="md md-computer"></i></div>
                                    <span class="title">Pages</span>
                                </a>
                                start submenu 
                                <ul>
                                    <li class="gui-folder">
                                        <a href="javascript:void(0);">
                                            <span class="title">Contacts</span>
                                        </a>
                                        start submenu 
                                        <ul>
                                            <li><a href="../pages/contacts/search.html" ><span class="title">Search</span></a></li>
    
                                            <li><a href="../pages/contacts/details.html" ><span class="title">Contact card</span></a></li>
    
                                            <li><a href="../pages/contacts/add.html" ><span class="title">Insert contact</span></a></li>
    
                                        </ul>end /submenu 
                                    </li>end /menu-li 
                                    <li class="gui-folder">
                                        <a href="javascript:void(0);">
                                            <span class="title">Search</span>
                                        </a>
                                        start submenu 
                                        <ul>
                                            <li><a href="../pages/search/results-text.html" ><span class="title">Results - Text</span></a></li>
    
                                            <li><a href="../pages/search/results-text-image.html" ><span class="title">Results - Text and Image</span></a></li>
    
                                        </ul>end /submenu 
                                    </li>end /menu-li 
                                    <li class="gui-folder">
                                        <a href="javascript:void(0);">
                                            <span class="title">Blog</span>
                                        </a>
                                        start submenu 
                                        <ul>
                                            <li><a href="../pages/blog/masonry.html" ><span class="title">Blog masonry</span></a></li>
    
                                            <li><a href="../pages/blog/list.html" ><span class="title">Blog list</span></a></li>
    
                                            <li><a href="../pages/blog/post.html" ><span class="title">Blog post</span></a></li>
    
                                        </ul>end /submenu 
                                    </li>end /menu-li 
                                    <li class="gui-folder">
                                        <a href="javascript:void(0);">
                                            <span class="title">Error pages</span>
                                        </a>
                                        start submenu 
                                        <ul>
                                            <li><a href="../pages/404.html" ><span class="title">404 page</span></a></li>
    
                                            <li><a href="../pages/500.html" ><span class="title">500 page</span></a></li>
    
                                        </ul>end /submenu 
                                    </li>end /menu-li 
                                    <li><a href="../pages/profile.html" ><span class="title">User profile<span class="badge style-accent">42</span></span></a></li>
    
                                    <li><a href="../pages/invoice.html" ><span class="title">Invoice</span></a></li>
    
                                    <li><a href="../pages/calendar.html" ><span class="title">Calendar</span></a></li>
    
                                    <li><a href="../pages/pricing.html" ><span class="title">Pricing</span></a></li>
    
                                    <li><a href="../pages/timeline.html" ><span class="title">Timeline</span></a></li>
    
                                    <li><a href="../pages/maps.html" ><span class="title">Maps</span></a></li>
    
                                    <li><a href="../pages/locked.html" ><span class="title">Lock screen</span></a></li>
    
                                    <li><a href="../pages/login.html" ><span class="title">Login</span></a></li>
    
                                    <li><a href="../pages/blank.html" ><span class="title">Blank page</span></a></li>
    
                                </ul>end /submenu 
                            </li>end /menu-li 
                             END FORMS 
    
                             BEGIN CHARTS 
                            <li>
                                <a href="../charts/charts.html" >
                                    <div class="gui-icon"><i class="md md-assessment"></i></div>
                                    <span class="title">Charts</span>
                                </a>
                            </li>end /menu-li 
                             END CHARTS 
    
                             BEGIN LEVELS 
                            <li class="gui-folder">
                                <a>
                                    <div class="gui-icon"><i class="fa fa-folder-open fa-fw"></i></div>
                                    <span class="title">Menu levels demo</span>
                                </a>
                                start submenu 
                                <ul>
                                    <li><a href="#"><span class="title">Item 1</span></a></li>
                                    <li><a href="#"><span class="title">Item 1</span></a></li>
                                    <li class="gui-folder">
                                        <a href="javascript:void(0);">
                                            <span class="title">Open level 2</span>
                                        </a>
                                        start submenu 
                                        <ul>
                                            <li><a href="#"><span class="title">Item 2</span></a></li>
                                            <li class="gui-folder">
                                                <a href="javascript:void(0);">
                                                    <span class="title">Open level 3</span>
                                                </a>
                                                start submenu 
                                                <ul>
                                                    <li><a href="#"><span class="title">Item 3</span></a></li>
                                                    <li><a href="#"><span class="title">Item 3</span></a></li>
                                                    <li class="gui-folder">
                                                        <a href="javascript:void(0);">
                                                            <span class="title">Open level 4</span>
                                                        </a>
                                                        start submenu 
                                                        <ul>
                                                            <li><a href="#"><span class="title">Item 4</span></a></li>
                                                            <li class="gui-folder">
                                                                <a href="javascript:void(0);">
                                                                    <span class="title">Open level 5</span>
                                                                </a>
                                                                start submenu 
                                                                <ul>
                                                                    <li><a href="#"><span class="title">Item 5</span></a></li>
                                                                    <li><a href="#"><span class="title">Item 5</span></a></li>
                                                                </ul>end /submenu 
                                                            </li>end /submenu-li 
                                                        </ul>end /submenu 
                                                    </li>end /submenu-li 
                                                </ul>end /submenu 
                                            </li>end /submenu-li 
                                        </ul>end /submenu 
                                    </li>end /submenu-li 
                                </ul>end /submenu 
                            </li>end /menu-li 
                             END LEVELS -->

</ul>
<div class="menubar-foot-panel">
    <small class="no-linebreak hidden-folded">
        <span class="opacity-75">Copyright &copy; 2014</span> <strong>CodeCovers</strong>
    </small>
</div>