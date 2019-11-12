#!/usr/bin/php

<?php

$csv = file_get_contents('https://rate.bot.com.tw/xrt/flcsv/0/day');

// Check line by line
foreach(preg_split("/((\r?\n)|(\r\n?))/", $csv) as $line) {
  $values = explode(',', $line);

  // Format:
  // [0]幣別,[1]匯率,[2]現金,[3]即期,[4]遠期10天,[5]遠期30天,[6]遠期60天,[7]遠期90天,[8]遠期120天,[9]遠期150天,[10]遠期180天,[11]匯率,[12]現金,[13]即期,[14]遠期10天,[15]遠期30天,[16]遠期60天,[17]遠期90天,[18]遠期120天,[19]遠期150天,[20]遠期180天

  if ($values[0] == 'JPY') {
    // Send a push to LINE Notify
    $url = 'https://notify-api.line.me/api/notify';
    $data = array(
      'message' => "\n\n\u{1000B4} 日幣換台幣 = {$values[2]}\n\u{1000B4} 台幣換日幣 = {$values[12]}\n\nhttps://rate.bot.com.tw/xrt?Lang=zh-TW"
    );

    $options = array(
        'http' => array(
            'header'  => "Authorization: Bearer {存取權杖}\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
  }
}

?>
