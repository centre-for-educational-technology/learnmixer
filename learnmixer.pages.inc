<?php


/**
 * [Learnmixer home page]
 * @return [array] [returns content array for home page]
 */
function learnmixer_home_page(){
  $content = array();
  $content['test'] = array(
    '#type' => 'markup',
    '#markup' => t('Welcome to Learnmixer!'),
  );
  return $content;
}
