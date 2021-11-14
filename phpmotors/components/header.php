<header>
    <img class="header-logo" src="/phpmotors/images/site/logo.png" alt="php motors logo" />
    <h1>
        <?php if (isset($_SESSION['loggedin'])) {
            echo "<a href='/phpmotors/accounts/'><span>" . $_SESSION['clientData']['clientFirstname'] . " </span></a>"
                . '|  <a href="/phpmotors/accounts?action=Logout">Logout</a>'; //!! fix format and url
        } else {
            echo '<a href="/phpmotors/accounts?action=login">My Account</a>';
        }
        ?>
    </h1>
    <!-- <a href='/phpmotors/index.php?action=".urlencode($classification[' classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a> -->
</header>