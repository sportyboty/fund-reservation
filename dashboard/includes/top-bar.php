<?php $user = new \MerryPayout\User(); $userInfo = $user->getDetails(); ?>
<div class="top-bar comic-sans">
    <nav class="navbar navbar-default top-bar comic-sans">
        <div class="menu-bar-mobile" id="open-left"><i class="ti-menu"></i>
        </div>

        <ul class="nav navbar-nav navbar-right top-elements comic-sans">

            <li class="piluku-dropdown dropdown">
                <!-- @todo Change design here, its bit of odd or not upto usable -->

                <a href="#" class="dropdown-toggle avatar_width comic-sans" data-toggle="dropdown" role="button"
                   aria-expanded="false"><span class="avatar-holder"><img src="<?php echo $userInfo['prof_pic'] != null ? 'upload/' . $userInfo['prof_pic'] : '../images/one.png'; ?>"
                                                                          alt=""></span><span
                        class="avatar_info"><?php echo $_SESSION['username'] ?></span><span class="drop-icon"><i class="ion
                        ion-chevron-down"></i></span></a>
                <ul class="comic-sans dropdown-menu dropdown-piluku-menu  animated fadeInUp wow avatar_drop neat_drop
                dropdown-right animated"
                    data-wow-duration="1500ms" role="menu"
                    style="visibility: visible; animation-duration: 1500ms; animation-name: fadeInUp;">
                    <li>
                        <a href="edit_profile"><i class="fa fa-user"></i>Settings</a>
                    </li>
                    <li>
                        <a href="givehelp"><i class="fa fa-usd"></i>Make a Deposit</a>
                    </li>
                    <li>
                        <a href="history"> <i class="fa fa-history"></i>Money History</a>
                    </li>
                    <li>
                        <a href="referral"> <i class="fa fa-users"></i>Referral Tools</a>
                    </li>
                    <li>
                        <a href="../logout" class="logout_button"><i class="fa fa-sign-out"></i>Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

    </nav>

</div>