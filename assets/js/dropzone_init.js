// toastr.success('Are you the 6 fingered man?')
var uploadedFiles = [];


// Dropzone.options.uploadProfileImage = false;
$("#uploadImage").on("change", async _ =>{
    var action = $("#uploadImage").attr("data-action");
    var isInvalid = false;
    if($("#uploadImage")[0].files.length > 0){
        var files = $("#uploadImage")[0].files;
        let fileuploading_ = files.forEach(file => {
            let id = Math.floor((Math.random() * 99999999) + 1);
            var preview = "";
            let reader = new FileReader();
            reader.addEventListener("load", async () => {
                preview = reader.result
                if(action == "profile"){
                    uploadedFiles = []
                    var fileSize = getFile(file)
                    if(fileSize > 0.5) {
                        $(".upload-preview").html(`<label class="text-danger" for="uploadImage">File size too large, maximum size of 500kb</label>`)
                        isInvalid = true;
                        return false;
                    }
                    uploadedFiles = [{"id" : id, "file" : file, "preview" : preview}]
                }else{
                    await uploadedFiles.push({"id" : id, "file" : file, "preview" : preview})
                }
            });
            if (file) {
                reader.readAsDataURL(file);
            }
        })
        // Promise.all(fileuploading_).then(()=> previewFiles(uploadedFiles))
        if(isInvalid == false){
            setTimeout(() => {
                previewFiles(uploadedFiles)
            }, 1000);
        }
        
    }
    return false;
})

const previewFiles = (files) =>{
    $(".upload-preview").html("");
    if(files.length == 0){
        $(".upload-preview").html(`<label for="uploadImage">Click here to select file</label>`)
        return ;
    }
    $("#upload").attr("disabled", false)
    files.forEach(element => {
        const id = element["id"]
        
        var fileInfo = getFileInfo(element);
        if(fileInfo.get("type") == "image"){
            var preview = document.createElement('img');
            preview.src = element["preview"]    
        }else{
            var preview = document.createElement("div")
            preview.classList.add("document-body")
            preview.classList.add("d-flex")
            preview.classList.add("justify-content-center")
            preview.classList.add("align-items-center")
            preview.innerHTML = `<i class="fa fa-file-${fileInfo.get('type')}-o ${fileInfo.get('bg')}"></i>`
        }
        
        preview.style.objectFit = "contain"
        preview.style.width = "100px"
        preview.style.height = "100px"
        

        const closebutton = document.createElement("a")
        closebutton.href = "#?";
        closebutton.innerText= "x"
        closebutton.setAttribute("data-image", id)
        closebutton.classList.add("btn")
        closebutton.classList.add("btn-danger")
        closebutton.classList.add("text-white")
        closebutton.classList.add("removeImage")
        
        
        const div = document.createElement("div")
        div.classList.add("d-flex")
        div.classList.add("flex-column")
        div.classList.add("align-items-center")
         
        div.append(preview)
        div.append(closebutton)
        $(".upload-preview").append(div)
    });
   
}
function uploadFiles(action){
    if(uploadedFiles.length > 0){
        uploadedFiles.forEach(file => {
            $(".fileError").hide()
            $(".fileSuccess").hide()
            console.log(getFileInfo(file))
            $.ajax({
                url : `/backend/file_upload.php?action=${action}`,
                type : 'POST',
                data : getFileInfo(file),
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    data = JSON.parse(data)
                    if(data.status == true){
                        switch (action) {
                            case "profile":
                                $(".fileSuccess").text("Profile picture change. refereshing...")
                                $(".fileSuccess").show()
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                                break;
                        
                            default:
                                break;
                        }

                        return false;
                    };

                    $(".fileError").text("Unable to upload...")
                    $(".fileError").show()
                }
            });
        })
    }
}

function generatePreview(file){
    const reader = new FileReader();
    reader.addEventListener("load", () => {
        return reader.result;
    }, false);
    if (file) {
        reader.readAsDataURL(file);
    }
}
function getFileInfo(fileObject){
    var kb = 1024 * 1024;
    var file = fileObject["file"];
    var id = fileObject["id"];
    var file_name = file.name;
    var ext = file_name.substring(file_name.lastIndexOf("."));
    var orginal_size = file.size;
    var size = parseFloat(orginal_size/kb).toFixed(2)
    var type = getType(ext)
    var bg = getBg(ext)

    var formdata = new FormData();
    formdata.append("file", file)
    formdata.append("ext", ext)
    formdata.append("size", size)
    formdata.append("id", id)
    formdata.append("type", type)
    formdata.append("bg", bg)

    return formdata;
}

function getFile(file){
    var kb = 1024 * 1024;
    var file = file;
    var file_name = file.name;
    var ext = file_name.substring(file_name.lastIndexOf("."));
    var orginal_size = file.size;
    var size = parseFloat(orginal_size/kb).toFixed(2)
    var type = getType(ext)
    console.log(size)
    return size;
    return formdata;
}
function getType(ext){
    switch (ext) {
        case '.doc':
            return "word"
            break;
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

$("body").on("click", ".removeImage", function(){
    var image = $(this).attr("data-image");
    uploadedFiles.forEach((element,index) => {
        console.log(element.id)
        console.log(image)
        if(element.id == image){
            uploadedFiles.splice(index, 1);
        }
    });
    setTimeout(() => {
        previewFiles(uploadedFiles)
    }, 100);
})


$("body").on("click", ".change-profile", function(){
    var action = "profile" 
    if(uploadedFiles.length == 0) return false;
    uploadFiles(action);
})

$("body").on("click", ".removeall", function(){
    uploadedFiles = [];
    setTimeout(() => {
        previewFiles(uploadedFiles)
    }, 100);
})


// Dropzone.options.uploadProfileImage = false;
Dropzone.options.fileChatDropZone = {
    autoProcessQueue: false,
    maxFilesize : 20,
    uploadMultiple:true,
    init: function() {
        var submitButton = document.querySelector('#submit-all');
        myDropzone = this;
        submitButton.addEventListener("click", function() {
            myDropzone.processQueue();
        });
   
        this.on("complete", function(d) {
            console.log(d)
            if(d.upload){
                if(d.status == "error"){
                    toastr.error(d.previewElement.innerText)
                }
            }
            if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                var _this = this;
                _this.removeAllFiles();
            }
            // fetch();
        });
    },
};

