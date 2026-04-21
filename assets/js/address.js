$(document).ready(function () {
    $("#addressForm").on("submit", function (e) {
        e.preventDefault();

        // Collect data from the form
        const name = $("#name").val();
        const number = $("#number").val();
        const pin = $("#pin").val();
        const city = $("#city").val();
        const state = $("#state").val();
        const flat = $("#flat").val();
        const area = $("#area").val();

        // Save to localStorage for the next page
        localStorage.setItem("cust_name", name);
        localStorage.setItem("cust_contact", number);
        localStorage.setItem("full_address", `${flat}, ${area}, ${city}, ${state} - ${pin}`);

        // Move to the summary page
        window.location.href = "summary.html";
    });
});