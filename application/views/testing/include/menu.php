<ul id="main-menu" class="gui-controls">
    <!-- BEGIN DASHBOARD -->
    <li>
        <a href="<?php echo base_url(); ?>index.php/testing/company" class="active">
            <div class="gui-icon"><i class="md md-home"></i></div>
            <span class="title">Dashboard</span>
        </a>
    </li><!--end /menu-li -->
    <?php $menuList = GetMenuList();
    foreach ($menuList as $mainKey => $mainVal) {
        ?>
        <li class="gui-folder">
            <a>
                <div class="gui-icon"><i class="md <?php echo $mainVal['class']; ?>"></i></div>
                <span class="title"><?php echo $mainVal['menu_caption'] ?></span>
            </a>
            <ul>
                <?php if (isset($mainVal['childmenu']) && !empty($mainVal['childmenu'])) {
                    foreach ($mainVal['childmenu'] as $key => $val) {
                        ?>
                        <li>
                            <a href="<?php echo base_url() . 'index.php/' . $val['url']; ?>" ><span class="title"><?php echo $val['menu_caption']; ?></span>
                            </a>
                        </li>
        <?php }
    }
    ?>
            </ul>
        </li>
<?php } ?>

</ul>
<div class="menubar-foot-panel">
    <small class="no-linebreak hidden-folded">
        <span class="opacity-75">Copyright &copy; 2014</span> <strong>CodeCovers</strong>
    </small>
</div>