<div class="navbar">
    <div class="container">
        <div class="navbar__wrapper">
            <a href="<?= ROOT ?>/"><img src="/images/ironclad_logo.png" class="img-fluid logo" alt="Ironclad Logo" /></a>
            <nav>
                <ul class="navbar__menu">
                    <li class="btn"><a href="<?= ROOT ?>/">About us</a></li>
                    <li class="btn"><a href="<?= ROOT ?>/">Contacts</a></li>
                    <?php
                    if (isset($_SESSION["user_id"])) {
                    ?>
                        <li class="btn"><a href="<?= ROOT ?>/logout/">Logout</a></li>
                    <?php
                    } else {
                    ?>
                        <li class="btn"><a href="<?= ROOT ?>/login/">Login</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>