<?php
$chat = Project\Project::Chat($project['id']);
?>

<div class="my-2">
    <div class="d-flex justify-content-start">
        <a href="/portal/project?project=<?php echo $project["project_id"]; ?>" class="text-decoration-none <?php echo $modeTheme; ?>"> <span class="fa fa-diamond"></span>&nbsp; Project </a> &nbsp; &nbsp;
        <a href="/portal/chat?hash=<?php echo $chat["chat_hash"]; ?>" class="text-decoration-none <?php echo $modeTheme; ?>"> <span class="fa fa-comment-o"></span> Chat <span class="small-font">(20)</span></a> &nbsp;
        <a class="mx-2 text-decoration-none <?php echo $modeTheme; ?>" href="/portal/files?project=<?php echo $project['project_id']; ?>"><span class="fa fa-files-o"></span> Files <span class="small-font">(20)</span></a> &nbsp;
        <a href="/portal/members?project=<?php echo $project['project_id']; ?>" class="text-decoration-none <?php echo $modeTheme; ?>"> <span class="fa fa-group"></span> Members <span class="small-font"> (<?php echo Project\Project::GetMultiple("membercount", $project["id"]); ?>)</span></a>
    </div>
</div>