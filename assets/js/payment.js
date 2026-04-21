function payNow(upi, link) {
    // This logic detects if the user is on a mobile device
    if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        // Force open the UPI app using the deep link generated in the HTML
        window.location.href = link;
    } else {
        alert("Please complete the payment on a mobile device using PhonePe or Paytm.");
    }
}

// Timer logic for the payment page
$(document).ready(function() {
    var timer = 120; // 2 minutes
    setInterval(function () {
        var minutes = parseInt(timer / 60, 10);
        var seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        $('#offerend-time').text(minutes + ":" + seconds);
        if (--timer < 0) { timer = 0; }
    }, 1000);
});