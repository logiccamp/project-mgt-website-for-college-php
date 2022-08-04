<div class="position-fixed top-0 w-100 h-100 d-flex justify-content-center align-items-center" style="background: rgba(0, 0, 0, 0.9)">
    <div class="mx-auto rounded-0  text-center" style="min-width: 400px; width: 95%">
        <div class="shadow bg-white _error p-3 py-5 text-danger">
            <i class="fa fa-exclamation-triangle fa-2x"></i>
            <div></div>
            <p class="mt-3">
                <?php echo $message; ?>
            </p>

            <?php if ($button) :; ?>
                <a href="<?php echo $link == 'back' ? '#?' : $link; ?>" class="btn btn-danger" onclick="<?php echo $link == 'back' ? 'window.history.back()' : ''; ?>"><?php echo $button_text; ?></a>
            <?php endif; ?>

        </div>
    </div>
</div>