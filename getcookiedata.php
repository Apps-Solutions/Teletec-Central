<?php
if (isset($_SESSION["cookie_http_vars"]) && !empty($_SESSION["cookie_http_vars"])):

    foreach ($_SESSION["cookie_http_vars"] as $key => $value) {
        foreach ($_SESSION["cookie_http_vars"] as $key => $value) {
            $FORM[$key] = (!is_array($value) ? utf8_encode($value) : $value);
        }
    }
    if (!empty($FORM['MsgErr']) || !empty($FORM['MsgSas'])):
        ?>

        <div class="alert-danger text-center">
            <?php
            if (isset($FORM['MsgErr']))
                echo nl2br($FORM['MsgErr']);
            if (isset($FORM['MsgSas']))
                echo nl2br($FORM['MsgSas']);
            ?>
        </div>
    <?php endif; ?>


    <?php $_SESSION["cookie_http_vars"] = array(); ?>

<?php endif; ?>