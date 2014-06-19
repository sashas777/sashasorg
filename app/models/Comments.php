<?php
class App_Model_Comments  {
	
 public function getComments($articleId) {
 	
 	$db = new App_Model_DbTable_Comments ();
 	$result = $db->getComments($articleId);
 	return $result;
 }	
 
 
 public function addComment($data){
 	$db = new App_Model_DbTable_Comments ();
 	$result = $db->addComment($data);
 	$ArticleId=$data['item_id'];
 	$article_model= new App_Model_Articles();
 	$article_model->addcomment($ArticleId);
 	
 }
 public function deletecomment($commentId, $ArticleId) {
 	$db = new App_Model_DbTable_Comments ();
 	$db->deleteComment($commentId);
 	$article_model= new App_Model_Articles();
 	$article_model->addcomment($ArticleId,1); //delete=1
 }
 
 public function deletecommentByItemId($ArticleId){
 	$db = new App_Model_DbTable_Comments ();
 	$db->deleteCommentBYitem($ArticleId);
 }
	
}