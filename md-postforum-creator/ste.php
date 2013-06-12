<?php
function md_post_creator_inserimento_post() {
$new_post = array(
'post_title' => $_POST['name'] ,
'post_content' => 'Asganaway',
'post_status' => 'draft',
'post_date' => date('Y-m-d H:i:s'),
'post_author' => 1,
'post_type' => 'post',
'post_category' => array(0)
);
$post_id = wp_insert_post($new_post);
};
echo 'Sono il file ste.php';?>