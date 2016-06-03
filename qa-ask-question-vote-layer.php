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

		if (isset($q_view['main_form_tags'])) {
			$this->output('<form '.$q_view['main_form_tags'].'>'); // form for voting buttons
		}

		$this->qa_vote_button($q_view);

		if (isset($q_view['main_form_tags'])) {
			$this->form_hidden_elements(@$q_view['voting_form_hidden']);
			$this->output('</form>');
		}
	}

	function qa_vote_button($post) {
		$caption_class = "qa-ask-question-vote-caption";
		$vote_class = "qa-ask-question-vote-button";
		$unvote_class = "qa-ask-question-unvote-button";
		$this->output('<div class="qa-ask-question-vote">');
		switch (@$post['vote_state'])
		{
			case 'voted_up':
				$this->vote_caption('after', $caption_class);
				$this->post_button($post, 'vote_up_tags', qa_lang_html('qa_ask_question_vote_lang/unvote'), $unvote_class);
				break;

			case 'enabled':
			case 'voted_down':
			default:
				$this->vote_caption('before', $caption_class);
				$this->post_button($post, 'vote_up_tags', qa_lang_html('qa_ask_question_vote_lang/vote'), $vote_class);
				break;
		}

		$this->output('</div>');

		$this->output($post['vote_state']);
	}

	function vote_caption($status = 'before', $caption_class)
	{
		$caption = qa_html(qa_opt('qa_ask_question_caption_'.$status));
		$this->output('<span class="' . $caption_class . '">' . $caption .'</span> ');
	}

	function post_button($post, $element, $value, $class)
	{
		if (isset($post[$element])) {
			$this->output('<input '.$post[$element].' type="submit" value="'.$value.'" class="'.$class.'"/> ');
		}
	}

	function footer() {
		qa_html_theme_base::footer();
	}
}
