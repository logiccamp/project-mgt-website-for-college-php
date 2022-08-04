function loadChat(scroll){
    $.get(`/backend/controllers/ChatController.php?action=Get&chat=${chat_id}`).done((d)=>{
        const chat = JSON.parse(d);
        const messages = chat.messages;
        if(messages.length == 0) {
            const li = document.createElement("li")
            li.classList.add("no_messages");
            li.innerHTML = `<div class="text-center d-none"><img src='/assets/img/user_avatar_1.png' height="100" width="100" /></div> <p class='text-center'>Start Chat </p>`
            $(".msg_container_base").html(li)
            return false;
        }
        $(".msg_container_base").html("")
        
        messages.forEach(message => {
            var $dateCreated = message.date_created
            var $dateCreated = $dateCreated.replace(" ","T");
            var $date_ = moment($dateCreated, moment.defaultFormat).fromNow()
            var li = document.createElement("li");
            var isUser = "";
            var notUser = "";
            var $userImage = "";
            if(message.user.profile_image !== ""){
                $userImage = image_folder+message.user.profile_image
            }else{
                $userImage= avatar;
            }
            if(message.user_id == user_id){
                
                isUser = `<img src="${$userImage}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" height="60" width="60">`
            }else{
                notUser = `<img src="${$userImage}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" height="60" width="60">`
            }
            li.classList.add("d-flex")
            li.classList.add("justify-content-between")
            li.classList.add("mb-4")
            li.innerHTML =`
                        ${notUser}
                        <div class="card w-100">
                            <div class="card-header d-flex justify-content-between p-3">
                                <p class="fw-bold mb-0">${message.user.full_name}</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${$date_}</p>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">
                                    ${message.message}
                                </p>
                            </div>
                        </div>
                        ${isUser}
                        `
            $(".msg_container_base").append(li)
        });

        if(scroll){
            $(".msg_container_base").stop().animate({ scrollTop: $(".msg_container_base")[0].scrollHeight}, 1);
        }

    })
}

$("#sendButton").on("click", function(){
    var message = $("#messageInputBox").text()
    if(message == "") return;
    var data = {
        "message" : message,
        "user_id" : user_id,
        "chat_id" : chat_id,
        "project_id" : project_id
    }
    sendChat(data, "text")
})

$("#sendFile").on("click", function(){
    alert("Hello")
    if(uploadedFiles.length > 0){
        uploadedFiles.forEach(file => {
            $(".fileError").hide()
            $(".fileSuccess").hide()
            var data = getFileToSend(file["file"])
            sendChat(data, "file")
        })
    }
})

function sendChat(data,type){
    $.ajax({
        url : "/backend/controllers/ChatController.php?action=Create&type="+type,
        method : "POST",
        cache : false,
        data : data,
        contentType: false,
        processData: false,
        success : function(d){
            $("#messageInputBox").text('')
            loadChat(true)
        },
        error : function(error){
            console.log(error)
        },
        always : function(){
            console.log("done")
        }
    })
}


function getFileToSend(file){
    var kb = 1024 * 1024;
    var file = file;
    var file_name = file.name;
    var file_ext = file_name.substring(file_name.lastIndexOf("."));
    var orginal_size = file.size;
    var file_size = parseFloat(orginal_size/kb).toFixed(2)
    var file_type = getType(file_ext)
    var file_bg = getBg(file_ext)

    var formdata = new FormData();
    formdata.append("chat_id", chat_id)
    formdata.append("user_id", user_id)
    formdata.append("project_id", project_id)
    formdata.append("file", file)
    formdata.append("file_ext", file_ext)
    formdata.append("file_size", file_size)
    formdata.append("file_type", file_type)
    formdata.append("file_bg", file_bg)
    
    return formdata;
}



setInterval(() => {
    loadChat(false);
}, 5000);
loadChat(true);
// $(".msg_container_base").stop().animate({ scrollTop: $(".msg_container_base")[0].scrollHeight}, 1);




function getType(ext){
    switch (ext) {
        case '.doc':
            return "word"
            break;
        case '.docx':
            return "word"
            break;
        case '.rtf':
            return "word"
            break;
        case '.accdb':
            return "access"
            break;
        case '.jpg':
            return "image"
            break;
        case '.png':
            return "image"
            break;
        case '.jpeg':
            return "image"
            break;
        case '.pdf':
            return "pdf"
            break;
        case '.ppt':
            return "power-point"
            break;
        case '.pptx':
            return "power-point"
            break;
        case '.xls':
            return "excel"
            break;
        case '.xlsx':
            return "excel"
            break;
        case '.mp4':
            return "video"
            break;
        case '.mp3':
            return "audio"
            break;
        case '.wav':
            return "audio"
            break;
        case '.gif':
            return "image"
            break;
        default :
            return 'image'
    }
}

function getBg(ext){
    switch (ext) {
        case '.doc':
            return "text-primary"
            break;
        case '.docx':
            return "text-primary"
            break;
        case '.rtf':
            return "text-primary"
            break;
        case '.accdb':
            return "text-success"
            break;
        case '.jpg':
            return "text-success"
            break;
        case '.png':
            return "text-success"
            break;
        case '.jpeg':
            return "text-success"
            break;
        case '.pdf':
            return "text-danger"
            break;
        case '.ppt':
            return "text-danger"
            break;
        case '.pptx':
            return "text-danger"
            break;
        case '.xls':
            return "text-success"
            break;
        case '.xlsx':
            return "text-success"
            break;
        case '.mp4':
            return "text-dark"
            break;
        case '.mp3':
            return "text-dark"
            break;
        case '.wav':
            return "text-dark"
            break;
        case '.gif':
            return "text-success"
            break;
        default :
            return 'text-success'
    }
}