<form action="<?=$targetURL?>" method="post" class="form-group">
    <?php
    foreach ($fields as $value) {
        echo "<label for='" . $value . "'>$value<input type='text' id='" . $value . "' name='" . $value . "' class='form-control'></label><br><br>\n";
    }
    ?>
    <input type="submit" value="Отправить!!!" class='btn btn-primary'>
</form>