
<?php

    $pageName = "faq";
    $title = "Frequently asked question";

?>
<?php require_once "includes/header.php"?>
<body class="header-moved loaded colour-1">

<?php require_once "includes/nav.php";?>


    <div id="content-wrapper">

       <?php require_once 'includes/news.php';?>

        <div class="blocks-container">

            <!-- BLOCK "TYPE 6" -->
            <div class="block type-6">
                <div class="container">

                    <div class="row wow fadeInDown">
                        <div class="block-header col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0">
                            <h2 class="title">FAQ</h2>
                            <div class="text">Below are some frequently asked questions. If you encounter any serious
                                confusion, feel free to contact us.
                            </div>
                        </div>
                    </div>

                    <div class="accordeon-wrapper wow fadeInUp">
                        <div class="accordeon-entry active">
                            <div class="title">My donor refused to donate or said he/she won't donate</div>
                            <div style="display: block;" class="text">
                                Kindly wait for the donor's grace time to expire. Our system will automatically assign
                                another donor to your after some time.
                                If a new donor is not assigned within 7 days, Please Contact us.
                            </div>
                        </div>

                        <div class="accordeon-entry">
                            <div class="title">My donor uploaded fake donation proof</div>
                            <div class="text">
                                Report the user immediately, and attach a copy of your bank statement to show you
                                actually didn't receive donation from donor.
                                If your report is found to be correct, the user will be blocked and his/her details
                                posted on
                                fraud list.
                            </div>
                        </div>

                        <div class="accordeon-entry">
                            <div class="title">My receiver refused to confirm me</div>
                            <div class="text">
                                If you have uploaded donation proof and your receiver refuses to confirm the donation,
                                report the user. Do note that admins will investigate using the donation proof you uploaded.
                                Whoever is found guilty will be duly penalised.
                                .</div>
                        </div>

                        <div class="accordeon-entry">
                            <div class="title">I have not gotten a Donor</div>
                            <div class="text">Donor is assigned by the system. Hence,
                                you have to wait till system gets you a Donor Your estimated wait time will be displayed.
                                It may take more or less time to get a Donor.
                                If your Donor details are not visible after 24 hrs, contact us.</div>
                        </div>

                        <div class="accordeon-entry">
                            <div class="title">I didn't get activation link after registration</div>
                            <div class="text">
                                That may be because you provided an incorrect email address while registering or
                                the registration was not successful If you're sure you provided a valid email address and registration was successful,
                                then wait for the activation link. Ensure you check your inbox and spam/junk folder.
                                If activation link does not arrive in 24 hrs, contact us
                            </div>
                        </div>

                        <div class="accordeon-entry">
                            <div class="title">I use mobile bank, can i make donation with it?</div>
                            <div class="text">
                                Yes you can, but after donation upload a screenshot of the transaction as prove of
                                payment
                                .</div>
                        </div>

                    </div>

                </div>
            </div>


        </div>

    </div>

    <?php require_once "includes/footer.php"; ?>