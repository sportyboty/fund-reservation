<script>
    // Set the date we're counting down to
    var check = 1;
    if(check==1){
        var countDownDate = new Date("Feb 18, 2017 00:35:43").getTime();

// Update the count down every 1 second
        var x = setInterval(function() {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now an the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s left to donate";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "DEADLINE PASSED";
            }
        }, 1000);
    }
</script>
<div class="row comic-sans">
    <div class="col-sm-12">
        <div class="well">
            <h1><?php echo date('d-m-Y') ?></h1>
            <h3>Welcome to NairaBank <strong><?php //echo $userInfo['accName']?></strong><font color="red" style="float: right;"
                                                                                              id="demo"></font></h3></div>

    </div>
</div>