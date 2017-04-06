<?php
require( '../wp-load.php');
require( '../wp-admin/includes/file.php');
require( '../wp-admin/includes/media.php');
require( '../wp-admin/includes/image.php');




if (isset($_POST)) {
$name=$_POST['name'];
$content=$_POST['content'];
$tag=$_POST['tag'];
$img=$_POST['img'];
$tags=explode(",",$tag);




$user_id = get_current_user_id();
// Create post object
$my_post = array();
$my_post['post_title']    = $name;
$my_post['post_content']  = $content;
$my_post['post_status']   = 'publish';
$my_post['post_author']   = $user_id;
$my_post['post_category'] = array(0);
$my_post['tags_input']=$tags;
// Insert the post into the database
$postid=wp_insert_post( $my_post );

$image = media_sideload_image($img, $postid, $name);

$attachments = get_posts(array('numberposts' => '1', 'post_parent' => $postid, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC'));
if(sizeof($attachments) > 0){
    // set image as the post thumbnail
    set_post_thumbnail($postid, $attachments[0]->ID);
}  

}

echo $name;
?>