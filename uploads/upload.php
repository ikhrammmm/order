<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = "uploads/";
    $file = $_FILES["paymentProof"];
    $filePath = $uploadDir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $orderDetails = $_POST["orderDetails"];

        // Generate WhatsApp Message
        $whatsappMessage = "Nama: $name\nNo Telefon: $phone\nAlamat: $address\n$orderDetails\n\nBukti pembayaran: Lihat lampiran.";
        $encodedMessage = urlencode($whatsappMessage);
        $whatsappUrl = "https://wa.me/01136631534?text=$encodedMessage";

        echo json_encode(["status" => "success", "message" => "Order submitted!", "redirect" => $whatsappUrl]);
    } else {
        echo json_encode(["status" => "error", "message" => "File upload failed."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
