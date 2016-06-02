<?php

/*
		Plugin Name: Ask Question Vote
		Plugin URI:
		Plugin Update Check URI:
		Plugin Description: Adds Vote buttons to questions
		Plugin Version: 0.1
		Plugin Date: 2016-06-02
		Plugin Author: 38qa.net
		Plugin Author URI:
		Plugin License: GPLv2
		Plugin Minimum Question2Answer Version: 1.7
*/


	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
			header('Location: ../../');
			exit;
	}

	// language file
	qa_register_plugin_phrases('qa-ask-question-vote-lang-*.php', 'qa_ask_question_vote_lang');
	// layer
	qa_register_plugin_layer('qa-ask-question-vote-layer.php', 'Ask Question Layer');
	// admin
	qa_register_plugin_module('module', 'qa-ask-question-vote-admin.php', 'qa_ask_question_vote_admin', 'Ask Question Vote Admin');

/*
	Omit PHP closing tag to help avoid accidental output
*/
