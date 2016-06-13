<?php
if (!defined('QA_VERSION')) {
	require_once '../../qa-include/qa-base.php';
}

require_once QA_INCLUDE_DIR.'app/users.php';
require_once QA_INCLUDE_DIR.'app/cookies.php';
require_once QA_INCLUDE_DIR.'app/votes.php';
require_once QA_INCLUDE_DIR.'app/format.php';
require_once QA_INCLUDE_DIR.'app/options.php';
require_once QA_INCLUDE_DIR.'db/selects.php';
// require_once QA_PLUGIN_DIR.'q2a-ask-question-vote/qa-ask-question-vote-layer.php';


if($_SERVER["REQUEST_METHOD"] != "POST"){
	header('Location: ../../');
	exit;
}

if(qa_is_logged_in()) {
	$qa_aqv_ajax = new qa_ask_question_vote_ajax();
	$qa_aqv_ajax->response();
} else {
	header("Content-Type: text/html; charset=UTF-8");
	echo '';
}

class qa_ask_question_vote_ajax
{
	public $postid;
	public $userid;
	public $cookieid;

	function qa_ask_question_vote_ajax()
	{
		$this->postid = qa_post_text('postid');
		$this->userid = qa_get_logged_in_userid();
		$this->cookieid = qa_cookie_get();

		header("Content-Type: text/html; charset=UTF-8");
	}
	function response()
	{

		$post=qa_db_select_with_pending(qa_db_full_post_selectspec($this->userid, $this->postid));

		$fields=qa_post_html_fields($post, $this->userid, $this->cookieid, array(), null, array(
			'voteview' => qa_get_vote_view($post, true), // behave as if on question page since the vote succeeded
		));

		$themeclass=qa_load_theme_class(qa_get_site_theme(), 'voting', null, null);

		// echo "QA_AJAX_RESPONSE\n1\n";
		if($fields["raw"]["type"] === "A") {
			$type = "answer";
		} else {
			$type = "question";
		}
		$themeclass->qa_vote_button($fields, $type);
		// print_r($post);
		// print_r($fields);
	}
}

/*
	Omit PHP closing tag to help avoid accidental output
*/
