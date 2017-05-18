<div class="left-bar comic-sans" style="overflow: hidden; outline: none;"
     tabindex="0">
    <div class="admin-logo">
        <div class="logo-holder pull-left">
            <span style="font-size: 18px; font-weight: bolder;"> <span style="color:green">Twilight</span><span
                        style="color:whitesmoke">Funds</span></span>
        </div>
        <!-- logo-holder -->
        <a href="#" class="menu-bar  pull-right site-green-background "><i
                class="ti-menu"></i></a>
    </div>

    <div class="admin-logo">
        <div class="logo-holder pull-left">
            <span style="font-size: 18px; font-weight: bolder;"> <span style="color:green">Twilight</span><span
                    style="color:whitesmoke">Funds</span></span>
        </div>
        <!-- logo-holder -->
        <a href="#" class="menu-bar  pull-right"><i class="ti-menu"></i></a>
    </div>

    <!-- admin-logo -->
    <ul class="list-unstyled menu-parent" id="mainMenu">
        <li class="<?php echo $pagename == 'dashboard' ? 'current' : '';?>">
            <a href="index" class="current waves-effect waves-light">
                <i class="fa fa-home site-green"></i>
                <span class="text">Account Home</span>
            </a>
        </li>
        <li class="<?php echo $pagename == 'givehelp' ? 'current' : '';?>">
            <a href="givehelp" class="current waves-effect waves-light">
                <i class="fa fa-dollar site-green" style=""></i>
                <span class="text ">Donation list</span>
            </a>
        </li>
        <li class="<?php echo $pagename == 'confirmpayment' ? 'current' : '';?>">
            <a href="confirm_payment" class="current waves-effect waves-light">
                <i class="fa fa-thumbs-up site-green" style="color: #232c3b;"></i>
                <span class="text ">Confirm Payment</span>
            </a>
        </li>
        <li class="<?php echo $pagename == 'outgoing' ? 'current' : '';?>">
            <a href="outgoing" class="current waves-effect waves-light">
                <i class="fa fa-long-arrow-left site-green" style="color: #232c3b;"></i>
                <span class="text ">Outgoing Transactions</span>
            </a>
        </li>
        <li class="<?php echo $pagename == 'incoming' ? 'current' : '';?>">
            <a href="incoming" class="current waves-effect waves-light">
                <i class="fa fa-long-arrow-right site-green" style="color: #232c3b;"></i>
                <span class="text ">Incoming Transactions</span>
            </a>
        </li>

        <li class="<?php echo $pagename == 'history' ? 'current' : '';?>">
            <a href="history" class="current waves-effect waves-light">
                <i class="fa fa-history site-green" style=""></i>
                <span class="text ">Money History</span>
            </a>
        </li>
        <li class="<?php echo $pagename == 'referral' ? 'current' : '';?>">
            <a href="referral" class="current waves-effect waves-light">
                <i class="fa fa-users site-green" ></i>
                <span class="text ">Referral Program</span>
            </a>
        </li>
        <li class="<?php echo $pagename == 'yourreferrals' ? 'current' : '';?>">
            <a href="yourreferrals" class="current waves-effect waves-light">
                <i class="fa fa-list-alt site-green" ></i>
                <span class="text ">Your Referrals</span>
            </a>
        </li>
        <li class="<?php echo $pagename == 'editprofile' ? 'current' : '';?>">
            <a href="edit_profile" class="current waves-effect waves-light">
                <i class="fa fa-user site-green"></i>
                <span class="text ">Edit Profile</span>
            </a>
        </li>
        <li class="<?php echo $pagename == 'changepassword' ? 'current' : '';?>">
            <a href="change_passwords" class="current waves-effect waves-light">
                <i class="fa fa-lock site-green" ></i>
                <span class="text ">Change Password</span>
            </a>
        </li>
        <?php
        $user = new \MerryPayout\User();
        if ($user->isAdmin()) {
        ?>
        <li class="<?php echo $pagename == 'users' ? 'current' : '';?>">
            <a href="admin_view_users" class="current waves-effect waves-light">
                <i class="fa fa-gear site-green"></i>
                <span class="text ">Manage Users</span>
            </a>
        </li>

            <li class="<?php echo $pagename == 'list' ? 'current' : '';?>">
                <a href="admin_list_users" class="current waves-effect waves-light">
                    <i class="fa fa-list site-green" ></i>
                    <span class="text ">List</span>
                </a>
            </li>


        <?php } ?>

        <li class="<?php echo $pagename == 'req_acc' ? 'current' : '';?>">
            <a href="req_acc" class="current waves-effect waves-light">
                <i class="fa fa-bank site-green" ></i>
                <span class="text ">Request Accumulation</span>
            </a>
        </li>
        <li>
            <a href="logout" class="current waves-effect waves-light">
                <i class="fa fa-sign-out site-green"></i>
                <span class="text ">Log Out</span>
            </a>
        </li>
    </ul>
</div>