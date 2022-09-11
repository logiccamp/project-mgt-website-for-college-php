<?php
include("../backend/Doc.php");
if (!isset($_GET["doc"])) {
    header("Location: /portal/dashboard");
}


$doc = $_GET["doc"];

$getDoc = Doc\Doc::Get("doc_id", $doc);
if ($getDoc == null) {
    header("Location: /portal/dashboard");
}

$project = $getDoc["project_id"];

Doc\Doc::DeleteDoc($doc);

header("Location: /portal/project?project=" . $project);
