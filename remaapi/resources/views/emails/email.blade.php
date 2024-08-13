<html lang="en">
    <body>
        <main class="container">
            <div class="bg-light p-5 rounded">
                <h1>API 異常</h1>
                <p class="lead">發生問題的API名稱:{{ $name }}</p>
                <p class="lead">傳入值:{{ $input_data }}</p>
                <p class="lead">狀態:{{ $status }}</p>
                <p class="lead">訊息:{{ $message1 }}</p>
                <a class="btn btn-lg btn-primary" href="http://rema-sports.com/remaapi/api_view" role="button">View Rema API Log»</a>
            </div>
        </main>
    </body>
</html>