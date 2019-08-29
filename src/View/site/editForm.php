<form action="<?=$targetEditURL?>" method="post" class="form-group">
    <?php
    foreach ($row as $key => $value) {
        echo "<label for='" . $comments[$key] . "'>$comments[$key]<input type='text' id='" . $key . "' name='" . $key . "' value='".$value."' class='form-control'></label><br><br>\n";
    }
    // foreach ($comments as $key => $value) {
    //     echo "<label for='" . $key . "'>$key<input type='text' id='" . $key . "' name='" . $key . "' value='".$value."'></label><br><br>\n";
    // }
    ?>
    <input type="submit" value="Отправить!!!" class="btn btn-primary">
</form>