<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>ログイン画面</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <form action="" method = "POST" class = "class_login wrapper">
        <div class="class_radio_login">
            <div class="class_radio_insert">
                <input type="radio" id = "id_radio_login" name = "name_radio_login">
                <label for="id_radio_login">新規です</label>
            </div>
            <div class="class_radio_update">
                <input type="radio" id = "id_radio_login" name = "name_radio_login">
                <label for="id_radio_login">編集de</label>
            </div>
        </div>
        <div class="class_login_text_button">
            <input type="text" id = "id_text_login" name = "name_text_login">
            <input type="submit" id = "id_submit_login" name = "name_submit_login" value = "ログイン">
        </div>
    </form>
</body>
</html>