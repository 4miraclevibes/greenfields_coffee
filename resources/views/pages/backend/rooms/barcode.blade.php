<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - {{ $room->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            margin: 0;
            background: #f5f5f5;
        }

        .barcode-container {
            background: white;
            border: 2px solid #333;
            padding: 30px;
            margin: 20px auto;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .room-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2d5a27;
        }

        .qr-code-container {
            margin: 20px auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px solid #dee2e6;
        }

        #qrcode {
            display: inline-block;
        }

        .url {
            font-size: 14px;
            color: #666;
            word-break: break-all;
            margin-top: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .instructions {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
            font-weight: bold;
        }

        .sub-instructions {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .print-button {
            margin-top: 20px;
            padding: 15px 30px;
            background: #4a7c59;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .print-button:hover {
            background: #2d5a27;
        }

        @media print {
            body {
                margin: 0;
                background: white;
            }
            .barcode-container {
                border: 2px solid #333;
                box-shadow: none;
            }
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="barcode-container">
        <div class="room-name">{{ $room->name }}</div>

        <div class="qr-code-container">
            <img id="qrcode" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ url('/transaction/' . $room->id) }}" alt="QR Code" style="width: 300px; height: 300px; border: 2px solid #333; border-radius: 5px; display: block; margin: 0 auto;">
        </div>

        <div class="url">{{ url('/transaction/' . $room->id) }}</div>

        <div class="instructions">
            Scan QR Code untuk memesan kopi
        </div>

        <div class="sub-instructions">
            Arahkan kamera HP ke QR Code di atas
        </div>

        <button class="print-button" onclick="window.print()">
            🖨️ Print QR Code
        </button>
    </div>

</body>
</html>
