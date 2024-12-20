<div class="navbar">
    <div class="container">
        <div class="navbar__wrapper">
            <a href="<?= ROOT ?>/"><img src="/images/ironclad_logo.png" class="img-fluid logo" alt="Ironclad Logo" /></a>
            <nav>
                <ul class="navbar__menu">

                    <?php
                    if (!isset($_SESSION["user_id"])) {
                    ?>
                        <li class="btn btn_w"><a href="<?= ROOT ?>/about">About us</a></li>
                        <li class="btn btn_w"><a href="<?= ROOT ?>/contacts">Contacts</a></li>
                        <li class="btn"><a href="<?= ROOT ?>/gymtracker/login/">Login</a></li>
                    <?php
                    } else {
                    ?>
                        <li class="btn btn_w">
                            <a href="<?= ROOT ?>/gymtracker/dashboard/">
                                <i class="material-icons">space_dashboard</i>
                            </a>
                        </li>
                        <li class="btn btn_w">
                            <a href="<?= ROOT ?>/gymtracker/create-workout/">
                                <i class="material-icons">fitness_center</i>
                            </a>
                        </li>
                        <li class="btn btn_w">
                            <a href="<?= ROOT ?>/gymtracker/workout-tracker/">
                                <i class="material-icons">track_changes</i>
                            </a>
                        </li>
                        <li class="btn btn_w">
                            <a href="<?= ROOT ?>/gymtracker/training-schedule/">
                                <i class="material-icons">calendar_today</i>
                            </a>
                        </li>
                        <li class="btn btn_w">
                            <a href="<?= ROOT ?>/gymtracker/user-profile/">
                                <i class="material-icons">account_circle</i>
                            </a>
                        </li>
                        <li class="btn btn_w">
                            <a href="<?= ROOT ?>/gymtracker/logout/">
                                <i class="material-icons">logout</i>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>