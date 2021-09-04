<style type="text/css">
  ul{
    margin-left: -60px;
  }

  li {
    display: inline-block;
    list-style-type: none;
    padding: 10px;
    text-transform: uppercase;
  }
  li span {
    display: block;
  }
</style>
<div id="countdown">
  <ul>
    <li><span id="days"></span>days</li>
    <li><span id="hours"></span>Hours</li>
    <li><span id="minutes"></span>Minutes</li>
    <li><span id="seconds"></span>Seconds</li>
  </ul>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
  $('button[name="add-to-cart"]').html("hhhhh");


  (function () {
  const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

  let countDown = "<?php echo $end_date ?>",
      x = setInterval(function() {    

        let now = new Date().getTime(),
            distance = countDown - now;

        document.getElementById("days").innerText = Math.floor(distance / (day)),
        document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
        document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
        document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

        //do something later when date is reached
        if (distance < 0) {
          console.log("gg");
        }
        //seconds
      }, 0)
  }());
</script>