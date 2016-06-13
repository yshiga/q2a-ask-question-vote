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
		// $this->output('var postid = "'.$this->content['q_view']['raw']['postid'].'";');
		$this->output('var qv_url = "'.qa_opt('site_url').$this->plugin_url.'qa-ask-question-vote-ajax.php";');
		$this->output('</script>');
		$this->output('<script type="text/javascript" src="'.$plugin_js.'"></script>');
		// CSS Option
		$this->output('
<style>
'.qa_opt('qa_ask_question_vote_css').'
</style>');
	}

	/*
 	 * 質問の下に支持するボタンを表示する
	 */
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

	/*
	 * 回答の下に支持するボタンを表示する
	 */
	function  a_item_buttons($a_item)
	{

		qa_html_theme_base::a_item_buttons($a_item);

		if (isset($a_item['main_form_tags'])) {
			$this->output('<form '.$a_item['main_form_tags']. '">'); // form for voting buttons
		}

		$this->output('<div class="qa-ask-answer-vote" id="qv_' . $a_item["raw"]["postid"] .'">');
		$this->qa_vote_button($a_item, "answer");
		$this->output('</div>');

		if (isset($a_item['main_form_tags'])) {
			$this->form_hidden_elements(@$a_item['voting_form_hidden']);
			$this->output('</form>');
		}
	}

	/*
	 * 支持するボタンとキャプションを表示
	 */
	function qa_vote_button($post, $type = "question")
	{
		$caption_class = "qa-ask-question-vote-caption";
		$vote_class = "qa-ask-question-vote-button";
		$unvote_class = "qa-ask-question-unvote-button";
		switch (@$post['vote_state'])
		{
			case 'voted_up':
				$this->vote_caption('after', $caption_class, $type);
				$this->post_button($post, 'vote_up_tags', qa_lang_html('qa_ask_question_vote_lang/unvote'), $unvote_class);
				break;

			case 'voted_down':
				$this->vote_caption('before', $caption_class, $type);
				$this->post_button($post, 'vote_down_tags', qa_lang_html('qa_ask_question_vote_lang/vote'), $vote_class);
				break;
			case 'enabled':
			default:
				$this->vote_caption('before', $caption_class, $type);
				$this->post_button($post, 'vote_up_tags', qa_lang_html('qa_ask_question_vote_lang/vote'), $vote_class);
				break;
		}

	}

	/*
	 * ボタン横のキャプションを表示
	 */
	function vote_caption($status = 'before', $caption_class, $type = "question")
	{
		$caption = qa_html(qa_opt('qa_ask_'.$type.'_caption_'.$status));
		$this->output('<span class="' . $caption_class . '">' . $caption .'</span> ');
	}

	/*
	 * ボタンを表示
	 */
	function post_button($post, $element, $value, $class)
	{
		if (isset($post[$element])) {
			$this->output('<input '.$post[$element].' type="submit" value="'.$value.'" class="'.$class.'"/> ');
		}
	}

	/*
	 * フッタ
	 */
	function footer() {
		qa_html_theme_base::footer();
		$this->output('<script>');
		$this->output('$(function(){');
		$this->output('$(".qa-main input").click(function(){');
		$this->output('$(".tipsy").hide();');
		$this->output('});');
		$this->output('});');
		$this->output('</script>');
	}
}
