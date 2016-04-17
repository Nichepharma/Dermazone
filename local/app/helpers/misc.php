<?php

function getLangLabel($lang_dir)
{
	if(Config::has('lang_directions'))
	{
		$langs = Config::get('lang_directions');
		return $langs[$lang_dir];
	}
	return $lang_dir;
}

function generateTransactionID()
{
	return rand(1000, 9999);
}