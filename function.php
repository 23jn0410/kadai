<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力データを取得
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : '';

    // 必須チェック
    if (empty($name) || empty($email) || empty($message)) {
        echo "全てのフィールドを入力してください。";
        exit;
    }

    // CSVファイルのパス
    $filePath = 'csv/contacts.csv';

    // CSVに保存するデータ
    $data = [
        date('Y-m-d H:i:s'), // 現在日時
        $name,
        $email,
        $message
    ];

    // ファイルに書き込み
    $fileExists = file_exists($filePath);
    $file = fopen($filePath, 'a');

    if ($file) {
        // ヘッダー行の追加（新規ファイルの場合のみ）
        if (!$fileExists) {
            fputcsv($file, ['日時', 'お名前', 'メールアドレス', 'メッセージ']);
        }

        // データ行の追加
        fputcsv($file, $data);
        fclose($file);
        echo '<!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>お問い合わせありがとうございます</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    margin-top: 50px;
                }
                .message {
                    font-size: 1.5rem;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <div class="message">
                <p>お問い合わせありがとうございます。</p>
                <p>3秒後にホームページに戻ります。</p>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "index.html"; // リダイレクト先のURLを指定
                }, 3000); // 3秒後にリダイレクト
            </script>
        </body>
        </html>';
    } else {
        echo "ファイルの書き込みに失敗しました。";
    }
} else {
    echo "無効なリクエストです。";
}
?>