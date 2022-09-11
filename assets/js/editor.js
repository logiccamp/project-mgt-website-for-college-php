$("#saveDoc").on("click", function(event){
    $("#saveSpan").text('processing...')
    var content = CKEDITOR.instances.content.getData();
    var file_name = $("#file_name").val()
    let self = this;
    $.ajax({
        url : `/backend/doc_upload.php`,
        type : 'POST',
        data :  {"file_name" : file_name, "file_id" : file_id, "content" : content, "project_id" : project_id},
        success : function(data) {
            const result = JSON.parse(data);
            
            if(result.status == true){
                file_id = result["doc"];
                $("#success-alert").show();
                $("#success-alert").fadeOut(3000);
            }
            $("#saveSpan").text('Save')
        }
    })
})


$("#closeEditor").on("click", function(event){
    if(!confirm("Are you sure you want to close the editor?")){
        return false;
    }
})