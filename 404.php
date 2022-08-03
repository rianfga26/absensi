<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #1F1B24;
            height: 100vh;
        }

        #container {
            position: absolute;
            /* top: 10%;
            left: 10%;
            right: 10%;
            bottom: 10%; */
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            /* background: url('https://www.webdesignerdepot.com/cdn-origin/uploads/2021/05/004.png'), #151729; */
            background-size: cover;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
        }

        #container .content {
            max-width: 600px;
            text-align: center;
        }

        #container .content h2 {
            font-size: 18vw;
            color: #fff;
            line-height: 1em;
        }

        #container .content h4 {
            position: relative;
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #111;
            background: #fff;
            font-weight: 300;
            padding: 10px 20px;
            display: inline-block;
        }

        #container .content p {
            color: #fff;
            font-size: 1.2em;
        }

        #container .content a {
            position: relative;
            display: inline-block;
            padding: 10px 25px;
            background: #000;
            color: #fff;
            text-decoration: none;
            margin-top: 25px;
            border-radius: 25px;
            border-bottom: 4px solid #000;
        }
    </style>
</head>
<body>
    <div id="container">
        <div class="content">
            <h2>404</h2>
            <h4>Ops! Halamannya nggak ketemu.</h4>
            <p>Halaman yang anda cari tidak ditemukan, silahkan periksa alamat url anda mungkin terdapat salah ketik.</p>
            <a href="#">Kembali ke halaman utama</a>
        </div>
    </div>
    <script type="text/javascript">
        var container = document.getElementById('container');
        window.onmousemove = function(e) {
            var x = - e.clientX / 20,
                y = - e.clientY / 20;
            container.style.backgroundPositionX = x + 'px';
            container.style.backgroundPositionY = y + 'px';
        }
    </script>
</body>
</html>