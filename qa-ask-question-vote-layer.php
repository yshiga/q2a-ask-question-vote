<?php

class qa_html_theme_layer extends qa_html_theme_base {

	public $plugin_url;

	public function qa_html_theme_layer($template, $content, $rooturl, $request)
	{
		qa_html_theme_base::qa_html_theme_base($template, $content, $rooturl, $request);
		global $qa_layers;
		$this->plugin_url = $qa_layers['Ask Question Layer']['urltoroot'];
	}

	function head_custom()
	{
		qa_html_theme_base::head_custom();

		if($this->template != 'question') return;
		// JS file
		$plugin_js = qa_opt('site_url').$this->plugin_url.'js/qa-ask-question-vote.js';
		// Scripts
		$this->output('<script>');
		$this->output('var postid = "'.$this->content['q_view']['raw']['postid'].'";');
		$this->output('var qv_url = "'.qa_opt('site_url').$this->plugin_url.'qa-ask-question-vote-ajax.php";');
		$this->output('</script>');
		$this->output('<script type="text/javascript" src="'.$plugin_js.'"></script>');
		// CSS Option
		$this->output('
<style>
'.qa_opt('qa_ask_question_vote_css').'
</style>');
	}

	function q_view($q_view)
	{
		qa_html_theme_base::q_view($q_view);
		if($this->template != 'question') return;

		if (isset($q_view['main_form_tags'])) {
			$this->output('<form '.$q_view['main_form_tags']. '">'); // form for voting buttons
		}

		$this->output('<div class="qa-ask-question-vote" id="qv_' . $q_view["raw"]["postid"] .'">');
		$this->qa_vote_button($q_view);
		$this->output('</div>');

		if (isset($q_view['main_form_tags'])) {
			$this->form_hidden_elements(@$q_view['voting_form_hidden']);
			$this->output('</form>');
		}
	}

	function qa_vote_button($post) {
		$caption_class = "qa-ask-question-vote-caption";
		$vote_class = "qa-ask-question-vote-button";
		$unvote_class = "qa-ask-question-unvote-button";
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
