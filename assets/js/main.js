$("#toggleTheme").click(function(){
    $(".themeDrop").toggle(100)
})



try {
    $(".navbar-toggler").on("click", function(){
        $("#navbarColor01").toggle(500)
    })
    $("#showDropZonePicture").on("click", function(){
        $("#uploadProfileImageOverlay").show(200);
    })
} catch (error) {
    console.log(error)
}



try {
    $("#closeOverlay").on("click", function(){
        $(".overlay_container").fadeOut(200);
    })
} catch (error) {
    console.log(error)
}


try {
    $("#sendFiles").on("click", function(){
        $("#fileChatOverlay").show(200);
    })
} catch (error) {
    console.log(error)
}


$(".deleteFile").on("click", function(event) {
    var doc = $(this).attr("data-doc")
    if(!confirm("Are you sure to delete? This action cannot be reversed!")) return false;
    window.location.assign(`/portal/delete-doc?doc=${doc}`)
})