document.addEventListener("DOMContentLoaded", function() {
    // Pull data from LocalStorage (saved on the Address page)
    const name = localStorage.getItem("cust_name") || "Customer";
    const address = localStorage.getItem("full_address") || "Address not provided";
    const contact = localStorage.getItem("cust_contact") || "";

    // Fill the HTML elements
    const nameEl = document.getElementById('customer-name');
    const addressEl = document.getElementById('customer-address');
    const contactEl = document.getElementById('customer-contact');

    if (nameEl) nameEl.innerText = name;
    if (addressEl) addressEl.innerText = address;
    if (contactEl) contactEl.innerText = "Phone number: " + contact;

    // Optional: Clear LocalStorage so the next "order" starts fresh
    // localStorage.clear(); 
});