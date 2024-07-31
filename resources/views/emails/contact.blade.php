<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GearGeekHUB</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <div style="width: 100%; padding: 20px; box-sizing: border-box;">
        <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <h1 style="font-size: 24px; margin-bottom: 20px; color: #333333;">Pesan Baru Dari {{ $nama }}</h1>
            <p style="font-size: 16px; margin-bottom: 10px; color: #666666;"><span style="font-weight: bold; color: #333333;">Nama : </span> {{ $nama }}</p>
            <p style="font-size: 16px; margin-bottom: 10px; color: #666666;"><span style="font-weight: bold; color: #333333;">Email : </span> {{ $email }}</p>
            <p style="font-size: 16px; margin-bottom: 10px; color: #666666;"><span style="font-weight: bold; color: #333333;">Pesan : </span></p>
            <p style="font-size: 16px; margin-bottom: 10px; color: #666666;">{{ $pesan }}</p>
        </div>
        <div style="margin-top: 20px; font-size: 12px; color: #999999; text-align: center;">
            <p>Email ini dikirim dari formulir kontak situs web Anda.</p>
        </div>
    </div>
</body>
</html>


