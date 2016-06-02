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
				return '#qa-share-buttons-container {
	background: none repeat scroll 0 0 #DDDDDD;
	font-size: 125%;
	font-weight: bold;
	margin: 20px 0;
	padding: 20px;
	text-align: center;

}
#qa-share-buttons {
	vertical-align:middle;
}
.share-widget-container {
	display:inline-block;
	position:relative;
}
.qa-share-button {
	width: 54px;
}';
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
			qa_opt('qa_ask_question_vote_css', (bool)qa_post_text('qa_ask_question_vote_css'));
			$ok = qa_lang('admin/options_saved');
		}

		// form fields to display frontend for admin
		$fields = array();

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
