$("#toggleTheme").click(function(){
    $(".themeDrop").toggle(100)
})



try {
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