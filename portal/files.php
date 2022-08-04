<?php
require(__DIR__ . "/../shared/functions.php");
$pagetype = "dashboard";
$title = "Dashboard - ";
$pageIntro = "DASHBOARD";
$mode = getTheme();
$modeTheme = $mode  == "dark" ? "light" : "dark";
require("../shared/_header.php");
?>

<style>

</style>
<main style="padding-top: 20px ">
    <section>
        <div class="page container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <?php loadProjectHeader($modeTheme); ?>
                    <div class="section_wrapper bg-white shadow-sm p-3 my-4">
                        <h4 class="_primary_color">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</h4>
                        <hr>
                    </div>
                    <div class="row m-0 my-4">
                        <div class="col-12 tab-content no-bg py-2 no-border">
                            <div class="mt-4 d-flex justify-content-between">
                                <h5 class="_primary_color">Files</h5>
                                <div>
                                    <a href="" class="badge _secondary_bg text-decoration-none">View All</a>
                                </div>
                            </div>
                            <div class="tab-pane active documents documents-panel">
                                <div class="document">
                                    <div class="document-body">
                                        <i class="fa fa-file-excel-o text-success"></i>
                                    </div>
                                    <div class="document-footer">
                                        <span class="document-name"> Excel database 2016 </span>
                                        <span class="document-description"> 1.1 MB </span>
                                    </div>
                                </div>

                                <div class="document">
                                    <div class="document-body">
                                        <i class="fa fa-file-word-o text-info"></i>
                                    </div>
                                    <div class="document-footer">
                                        <span class="document-name"> Excel database 2016 </span>
                                        <span class="document-description"> 1.1 MB </span>
                                    </div>
                                </div>

                                <div class="document">
                                    <div class="document-body">
                                        <i class="fa fa-file-pdf-o text-danger"></i>
                                    </div>
                                    <div class="document-footer">
                                        <span class="document-name"> Excel database 2016 </span>
                                        <span class="document-description"> 1.1 MB </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php loadProjectSidebar($mode, $modeTheme, []); ?>
            </div>


        </div>
    </section>
</main>

<?php
require("../shared/_footer.php");
?>