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
    $filePath = 'contacts.csv';

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
        echo "お問い合わせ内容を保存しました。ありがとうございます。";
    } else {
        echo "ファイルの書き込みに失敗しました。";
    }
} else {
    echo "無効なリクエストです。";
}
?>
