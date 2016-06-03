<?php

	class qa_html_theme_layer extends qa_html_theme_base {

		function head_custom()
		{
			qa_html_theme_base::head_custom();

			$this->output('
<style>
'.qa_opt('qa_ask_question_vote_css').'
</style>');
		}

		function q_view($q_view)
		{
			qa_html_theme_base::q_view($q_view);

			$button = $this->qa_vote_button($q_view);
			$this->output('<div id="qa-ask-question-vote">',$button,'</div>');
		}

		function footer() {
			qa_html_theme_base::footer();
		}

		function qa_vote_button($q_view) {
			$caption = '<lbael class="qa-ask-question-vote-caption">' .
				qa_html( qa_opt('qa_ask_question_caption_before') ) .
				'</label>';
			$button = '<input type="submit" class="qa-ask-question-vote-button" '.
				'value="' . qa_lang_html('qa_ask_question_vote_lang/vote') .
				'">';
			$form = '<form>' . $caption . $button . '</form>';

			return $form;
		}

	}
