<?php
if (!isset($_REQUEST)) {
    return;
}
$data = json_decode(file_get_contents('php://input'));
switch ($data->type) {
    case 'wall_post_new':
        $text=$data->object->text;
        if (count($data->object->attachments)>0) {
            if ($data->object->attachments[0]->type=='link') {
                if (!$text) {
                    $text=$data->object->attachments[0]->link->url;
                }
            }
        }
        $postUrl='https://vk.com/blr_usa?w=wall'.$data->object->owner_id.'_'.$data->object->id;
        break;
}

$telegramText=$text.PHP_EOL.$postUrl;
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot462491250:AAE_5g6xFxGhlcZqQqoNDuOUpdcUhuS8Gvc/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
          http_build_query(array('chat_id' => '-1001354292359&text','text'=>$telegramText)));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);


?>
ok
