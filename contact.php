
<?php

    $pageName = "contact";
    $title = "Contact Us";

?>
<?php require_once 'includes/header.php'; ?>
<body class="header-moved loaded colour-1">

<!-- HEADER -->
<?php require_once 'includes/nav.php'; ?>

<div id="content-wrapper">

    <?php require_once 'includes/news.php';?>

        <div class="blocks-container">

            <!-- BLOCK "TYPE 14" -->
            <div class="block type-14">
                <img class="center-image" src="assets/img/background-14.jpg" alt="" />
                <div class="container">

                    <div class="row wow fadeInDown">
                        <div class="block-header col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0">
                            <h2 class="title">MerryPayout Support</h2>
                            <div class="text">We guarantee you 24/7 customer support</div>
                        </div>
                    </div>

                    <div class="block-button-container wow fadeInUp">
<!--                        <div class="button-description">Hot Number <a href="tel:+2348128623341 ">+2348128623341 </a> <br/> or</div>-->
                        <a class="button" href="#contact">have a question? form for suggestions and comments</a>
                    </div>

                </div>
            </div>

            <!-- BLOCK "TYPE 3" -->
            <div class="block type-3">
                <div class="container">

<!--                    <div class="row wow fadeInDown">-->
<!--                        <div class="block-header col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0">-->
<!--                            <h2 class="title">Contact Info</h2>-->
<!--                            </div>-->
<!--                    </div>-->

<!--                    <div class="row">-->
<!--                        <div class="icon-entry col-sm-4 wow fadeInUp" data-wow-delay="0.4s">-->
<!--                            <img class="img-circle" alt="" src="img/icon-121.png">-->
<!--                            <div class="content">-->
<!--                                <h3 class="title">Our Phones</h3>-->
<!--                                <div class="text"><b>Main Office Line:</b> +2348128623341  <br/> <b>Tech-->
<!--                                        Department:</b> +2348103161409 </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="icon-entry col-sm-4 wow fadeInRight" data-wow-delay="0.3s">-->
<!--                            <img class="img-circle" alt="" src="img/icon-122.png">-->
<!--                            <div class="content">-->
<!--                                <h3 class="title">Email</h3>-->
<!--                                <div class="text">-->
<!--                                    <b>Support:</b> support@merrypayout.com <br/>-->
<!--                                    <b>Clients:</b> client@merrypayout.com <br/>-->
<!--                                    <b>Technical Support:</b> tech@merrypayout.com-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                </div>
            </div>

            <!-- BLOCK "TYPE 18" -->
            <div class="block">
                <div class="container">
                    <div class="row">

                        <div class="col-md-10 col-md-offset-1 wow fadeInUp" id="contact">
                            <div class="form-block">
                                <img class="img-circle form-icon" src="assets/img/icon-123.png" alt="" />

                                <div class="form-wrapper">
                                    <div class="row">
                                        <div class="block-header col-md-8 col-md-offset-2">
                                            <h2 class="title">Contact Form</h2>
                                            <div class="text">Drop us your complaint or suggestion</div>
                                        </div>
                                    </div>
                                    <?php if ($msg1 != "")
                                        echo $msg1;
                                        ?>
                                    <form method="post">
                                        <div class="field-entry">
                                            <label for="field-1">Your Name *</label>
                                            <input type="text" name="name" id="field-1" />
                                        </div>
                                        <div class="field-entry">
                                            <label for="field-2">Email *</label>
                                            <input type="email" name="email" id="field-2" />
                                        </div>
                                        <div class="field-entry">
                                            <label for="field-3">Message</label>
                                            <textarea id="field-3" name="message"></textarea>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <div class="button">Submit<input name="contact" type="submit" value=""
                                                    /></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

  <?php require_once "includes/footer.php";?>