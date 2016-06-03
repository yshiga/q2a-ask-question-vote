<?php

class qa_ask_question_vote_admin
{
	public function init_queries($tableslc)
	{
		return;
	}
	public function option_default($option)
	{
		switch ($option) {
			case 'qa_ask_question_vote_css':
				return '.qa-ask-question-vote {
	margin-bottom: 50px;
	padding-left: 80px;
}
.qa-ask-question-vote-button {
	background-color: #f95225;
	color: #fff;
	text-align: center;
	padding: 5px 20px;
	border: 0;
	margin-left: 20px;
}
.qa-ask-question-unvote-button {
	background-color: #fff;
	color: #f95225;
	text-align: center;
	padding: 5px 20px;
	border: 0;
}
.qa-q-view {
	margin-bottom: 0;
}';
			case 'qa_ask_question_caption_before':
				return 'If I think as a good question -> ';
			case 'qa_ask_question_caption_after':
				return 'This question is being supported.';
			default:
				return;
		}
	}

	public function allow_template($template)
	{
		return $template != 'admin';
	}

	public function admin_form(&$qa_content)
	{
		// process the admin form if admin hit Save-Changes-button
		$ok = null;
		if (qa_clicked('qa_ask_question_vote_save')) {
			qa_opt('qa_ask_question_caption_before', qa_post_text('qa_ask_question_caption_before'));
			qa_opt('qa_ask_question_caption_after', qa_post_text('qa_ask_question_caption_after'));
			qa_opt('qa_ask_question_vote_css', qa_post_text('qa_ask_question_vote_css'));
			$ok = qa_lang('admin/options_saved');
		}

		// form fields to display frontend for admin
		$fields = array();

		$fields[] = array(
			'label' => qa_lang('qa_ask_question_vote_lang/caption_before'),
			'tags' => 'NAME="qa_ask_question_caption_before"',
			'value' => qa_opt('qa_ask_question_caption_before'),
			'type' => 'text',
		);

		$fields[] = array(
			'label' => qa_lang('qa_ask_question_vote_lang/caption_after'),
			'tags' => 'NAME="qa_ask_question_caption_after"',
			'value' => qa_opt('qa_ask_question_caption_after'),
			'type' => 'text',
		);

		$fields[] = array(
			'label' => qa_lang('qa_ask_question_vote_lang/custom_css'),
			'tags' => 'NAME="qa_ask_question_vote_css"',
			'value' => qa_opt('qa_ask_question_vote_css'),
			'type' => 'textarea',
			'rows' => 20
		);

		return array(
			'ok' => ($ok && !isset($error)) ? $ok : null,
			'fields' => $fields,
			'buttons' => array(
				array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'name="qa_ask_question_vote_save"',
				),
			),
		);
	}
}
