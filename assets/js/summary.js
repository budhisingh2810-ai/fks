$(document).ready(function () {
    // 1. Fill in Customer Details from LocalStorage
    $("#customer-name").text(localStorage.getItem("cust_name") || "Customer");
    $("#customer-contact").text(localStorage.getItem("cust_number") || "");
    $("#customer-address").text(localStorage.getItem("cust_address") || "Address not provided");

    // 2. Fill in Product Details from LocalStorage
    $("#product-title").text(localStorage.getItem("title"));
    $("#product-brand").text(localStorage.getItem("brand"));
    $("#selling_price").text("₹" + localStorage.getItem("price"));
    $("#mrp").text("₹" + localStorage.getItem("mrp"));
    $("#item_image").attr("src", localStorage.getItem("image"));
    
    // Fill in the bottom footer prices
    $("#selling_price-footer").text("₹" + localStorage.getItem("price"));
    $("#mrp-footer").text("₹" + localStorage.getItem("mrp"));

    // 3. Fill in the Price Detail Box
    $("#total-price").text("₹" + localStorage.getItem("mrp"));
    $("#total-price1").text("₹" + localStorage.getItem("price"));
    
    // Calculate the Discount amount
    let mrpVal = parseInt(localStorage.getItem("mrp")) || 0;
    let priceVal = parseInt(localStorage.getItem("price")) || 0;
    let savings = mrpVal - priceVal;
    
    $("#disc-price").text("-₹" + savings);
    $("#discount-amt").text("₹" + savings);
});

// This function runs when the user clicks the "Continue" button at the bottom
function btnContinue() {
    const price = localStorage.getItem("price");
    const mrp = localStorage.getItem("mrp");
    // Redirect to the final payment page
    window.location.href = "payments.html?price=" + price + "&mrp=" + mrp;
}