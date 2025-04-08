<?php
require_once 'includes/auth.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Escanear QR</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <style>
        #scanner-container { width: 100%; max-width: 500px; margin: 0 auto; }
        #scanner { width: 100%; height: auto; }
    </style>
</head>
<body>
    <h1>Escanear Código QR</h1>
    
    <div id="scanner-container">
        <video id="scanner"></video>
    </div>
    
    <div id="result"></div>
    
    <script>
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#scanner'),
            constraints: {
                width: 480,
                height: 320,
                facingMode: "environment"
            },
        },
        decoder: {
            readers: ["qrcode_reader"]
        },
    }, function(err) {
        if (err) {
            console.error(err);
            return;
        }
        console.log("Inicialización exitosa. Escaneando...");
        Quagga.start();
    });

    Quagga.onDetected(function(result) {
        const code = result.codeResult.code;
        document.getElementById('result').innerHTML = `Código detectado: ${code}`;
        
        // Enviar código al servidor para procesar
        fetch('process_qr.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ qr_code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `view_product.php?id=${data.product_id}`;
            } else {
                alert(data.message);
            }
        });
        
        Quagga.stop();
    });
    </script>
</body>
</html>