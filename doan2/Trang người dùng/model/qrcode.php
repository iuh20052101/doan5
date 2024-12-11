<?php
function generateTicketQR($ticket_data) {
    $qrDir = 'qrcode/';
    if (!file_exists($qrDir)) {
        mkdir($qrDir, 0777, true);
    }

    $qrtext = "";
    foreach($ticket_data as $key => $value) {
        $qrtext .= "$key: $value\n";
    }
    
    $timestamp = time();
    $qrimage = $qrDir . 'ticket-' . $ticket_data['id'] . '-' . $timestamp . '.png';

    try {
        if (!extension_loaded('gd')) {
            return "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrtext);
        }

        $result = Builder::create()
            ->writer(new PngWriter())
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(10)
            ->data($qrtext)
            ->build();

        $result->saveToFile($qrimage);
        return $qrimage;

    } catch (Exception $e) {
        error_log("QR Code generation error: " . $e->getMessage());
        return "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrtext);
    }
} 