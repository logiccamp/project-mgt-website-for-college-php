<script src="/vendors/jquery/jquery.min.js"></script>
<script src="/vendors/bootstrap/popper.min.js"></script>
<script src="/vendors/bootstrap/bootstrap.min.js"></script>
<script src="/vendors/nicescroll/nicescroll.min.js"></script>
<script src="/vendors/dropzone/dropzone.min.js"></script>
<script src="/vendors/toastr/toastr.min.js"></script>
<script src="/vendors/moment/moment.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/dropzone_init.js"></script>
<script>
    $(document).ready(function() {
        var $all_moments = $(".moment")
        for (let index = 0; index < $all_moments.length; index++) {
            const element = $all_moments[index];
            var date = element.getAttribute("data-date")
            var $dateCreated = date.replace(" ", "T");
            var $date_ = moment($dateCreated, moment.defaultFormat).fromNow()
            element.innerText = $date_
        }
    })
</script>


<?php
if ($pagetype == "dashboard") : ?>
    <script src="/assets/js/dashboard.js"></script>
<?php elseif ($pagetype == "editor") : ?>
    <script src="/assets/js/dashboard.js"></script>
    <script src="/vendors/ckeditor/ckeditor.js"></script>
    <script src="/assets/js/editor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>
<?php else : ?>
    <script src="/vendors/fontawesome/all.min.js"></script>
<?php endif; ?>

<?php
if ($loadChatBot) : ?>
    <script src="/vendors/perfect-scrollbar/js/mdb.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js" integrity="sha512-zMfrMAZYAlNClPKjN+JMuslK/B6sPM09BGvrWlW+cymmPmsUT1xJF3P4kxI3lOh9zypakSgWaTpY6vDJY/3Dig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="/assets/js/chatbot.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.5.1/jquery.nicescroll.min.js"></script>
    <script>
        $(".msg_container_base").niceScroll({
            autohidemode: false
        });
        $(".msg_container_base_").niceScroll({
            autohidemode: false
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#messageInputBox").niceScroll({
                cursorwidth: '10px',
                autohidemode: false,
                zindex: 999
            });
        });
    </script>
<?php endif; ?>
<!-- <script>
    $(document).ready(function() {
        $("html").niceScroll({
            cursorwidth: '10px',
            autohidemode: false,
            zindex: 999
        });
    });
</script> -->
</body>

</html>