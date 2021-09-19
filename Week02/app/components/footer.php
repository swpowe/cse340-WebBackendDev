    <footer>
        <p>© PHP Motors, All rights reserverd.</p>
        <p>All images used are believed to be in "Fair Use." Please notify the author if any are not and they will be removed.</p>
        <?php
        date_default_timezone_set('US/Mountain'); 
        echo "Last modified: " . date("F d Y H:i:s.", filemtime("index.php"));
        ?>
    </footer>