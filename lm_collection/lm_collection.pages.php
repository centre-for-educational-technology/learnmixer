<?php


/**
 * [The page where extra microcontent can be added to a collection]
 * @param  [string/integer] $nid [collection NID]
 * @return [array]      [drupal render array]
 */
function lm_collection_create_page($form, $form_state, $nid){

  $form = array();

  $node = node_load($nid);
  drupal_set_title($node->title);
  drupal_add_css(drupal_get_path('module', 'lm_collection').'/css/lm_collection.css');
  drupal_add_js(drupal_get_path('module', 'lm_collection').'/js/lm_collection_editor.js');
  $form['panel'] = array(
    '#type' => 'container',
    '#weight' => 0,
    '#attributes' => array(
      'class' => array(
        'container-fluid',
        'collection-outer',
        'panel',
        'panel-default',
      ),
    ),
  );
  $form['panel']['collection'] = array(
    '#type' => 'container',
    '#weight' => 1,
    '#attributes' => array(
      'class' => array(
        'collection-container',
      ),
    ),
  );
  $form['panel']['collection']['desc-container'] = array(
    '#type' => 'container',
    '#prefix' => '<div class="container-fluid">',
    '#suffix' => '</div>',
    '#attributes' => array(
      'class' => array(
        'row',
        'collection-row',
      ),
    ),
  );
  $form['panel']['collection']['desc-container']['label'] = array(
    '#type' => 'markup',
    '#markup' => t('Description:'),
    '#prefix' => '<div class="col-md-3 collection-label">',
    '#suffix' => '</div>',
  );
  $form['panel']['collection']['desc-container']['content'] = array(
    '#type' => 'markup',
    '#markup' => $node->lm_field_description[LANGUAGE_NONE][0]['safe_value'],
    '#prefix' => '<div class="col-md-9"><p>',
    '#suffix' => '</p></div>',
  );

  $form['panel']['collection']['subject-container'] = array(
    '#type' => 'container',
    '#prefix' => '<div class="container-fluid">',
    '#suffix' => '</div>',
    '#attributes' => array(
      'class' => array(
        'row',
        'collection-row',
      ),
    ),
  );
  $form['panel']['collection']['subject-container']['label'] = array(
    '#type' => 'markup',
    '#markup' => t('Subject: '),
    '#prefix' => '<div class="col-md-3 collection-label">',
    '#suffix' => '</div>',
  );
  $subjectname = taxonomy_term_load($node->lm_field_subject[LANGUAGE_NONE][0]['tid'])->name;
  $form['panel']['collection']['subject-container']['content'] = array(
    '#type' => 'markup',
    '#markup' => l($subjectname, 'taxonomy/term/'.$node->lm_field_subject[LANGUAGE_NONE][0]['tid']),
    '#prefix' => '<div class="col-md-9">',
    '#suffix' => '</div>',
  );
  $form['panel']['collection']['topic-container'] = array(
    '#type' => 'container',
    '#prefix' => '<div class="container-fluid">',
    '#suffix' => '</div>',
    '#attributes' => array(
      'class' => array(
        'row',
        'collection-row',
      ),
    ),
  );
  $form['panel']['collection']['topic-container']['label'] = array(
    '#type' => 'markup',
    '#markup' => t('Topic: '),
    '#prefix' => '<div class="col-md-3 collection-label">',
    '#suffix' => '</div>',
  );
  $form['panel']['collection']['topic-container']['content'] = array(
    '#type' => 'markup',
    '#markup' => $node->lm_field_topic[LANGUAGE_NONE][0]['safe_value'],
    '#prefix' => '<div class="col-md-9">',
    '#suffix' => '</div>',
  );

  $form['panel']['collection']['age-group-container'] = array(
    '#type' => 'container',
    '#prefix' => '<div class="container-fluid">',
    '#suffix' => '</div>',
    '#attributes' => array(
      'class' => array(
        'row',
        'collection-row',
      ),
    ),
  );
  $form['panel']['collection']['age-group-container']['label'] = array(
    '#type' => 'markup',
    '#markup' => t('Age group: '),
    '#prefix' => '<div class="col-md-3 collection-label">',
    '#suffix' => '</div>',
  );
  $form['panel']['collection']['age-group-container']['content'] = array(
    '#type' => 'markup',
    '#markup' => $node->lm_field_age_group_min[LANGUAGE_NONE][0]['value'].' - '.$node->lm_field_age_group_max[LANGUAGE_NONE][0]['value'],
    '#prefix' => '<div class="col-md-9">',
    '#suffix' => '</div>',
  );

  $form['panel']['collection']['license-container'] = array(
    '#type' => 'container',
    '#prefix' => '<div class="container-fluid">',
    '#suffix' => '</div>',
    '#attributes' => array(
      'class' => array(
        'row',
        'collection-row',
      ),
    ),
  );
  $form['panel']['collection']['license-container']['label'] = array(
    '#type' => 'markup',
    '#markup' => t('License: '),
    '#prefix' => '<div class="col-md-3 collection-label">',
    '#suffix' => '</div>',
  );
  $licensename = taxonomy_term_load($node->lm_field_license[LANGUAGE_NONE][0]['tid'])->name;
  $form['panel']['collection']['license-container']['content'] = array(
    '#type' => 'markup',
    '#markup' => l($licensename, 'taxonomy/term/'.$node->lm_field_license[LANGUAGE_NONE][0]['tid']),
    '#prefix' => '<div class="col-md-9">',
    '#suffix' => '</div>',
  );
  if(!empty($node->field_tags)){
    $form['panel']['collection']['tags-container'] = array(
      '#type' => 'container',
      '#prefix' => '<div class="container-fluid">',
      '#suffix' => '</div>',
      '#attributes' => array(
        'class' => array(
          'row',
          'collection-row',
        ),
      ),
    );
    $form['panel']['collection']['tags-container']['label'] = array(
      '#type' => 'markup',
      '#markup' => t('Tags: '),
      '#prefix' => '<div class=" col-md-3 collection-label">',
      '#suffix' => '</div>',
    );
    $tags = array();
    foreach($node->field_tags[LANGUAGE_NONE] as $tag){
      array_push($tags, $tag['tid']);
    }
    foreach($tags as &$tag){
      $tagname = taxonomy_term_load($tag)->name;
      $tag = '<span class="label label-primary tags-label">'.l($tagname, 'taxonomy/term/'.$tag).'</span>';
    }

    $form['panel']['collection']['tags-container']['content'] = array(
      '#type' => 'markup',
      '#markup' => implode(' ', $tags),
      '#prefix' => '<div class="col-md-9">',
      '#suffix' => '</div>',
    );
  }
  $form['separator']['hr'] = array(
    '#type' => 'markup',
    '#markup' => '<hr>',
    '#weight' => 2,
  );
  $form['add-new-structural-element'] = array(
    '#type' => 'container',
    '#prefix' => '<div class="container-fluid">',
    '#suffix' => '</div>',
    '#weight' => 3,
    '#attributes' => array(
      'class' => array(
        'row',
        'popover-markup'
      ),
    ),
  );
  $form['add-new-structural-element']['button'] = array(
    '#type' => 'markup',
    '#markup' => '<a tabindex="0" role="button" data-first="true" class="btn btn-default add-structure-elem trigger">'.t('Add a structural element').'</a>',
  );
  $form['add-new-structural-element']['head'] = array(
    '#type' => 'markup',
    '#markup' => t('Add new structural element'),
    '#prefix' => '<div class="head hide">',
    '#suffix' => '</div>',
  );
  $form['add-new-structural-element']['content'] = array(
    '#type' => 'markup',
    '#markup' => '<div class="form-group"><input data-collection="'.$node->nid.'" type="text" class="form-control" placeholder="'.t('e.g. Chapter 1').'"></div><button type="button" class="btn btn-default btn-block submit-structure-elem">'.t('Submit').'</button>',
    '#prefix' => '<div class="content hide">',
    '#suffix' => '</div>',
  );
  $form['new-elements'] = array(
    '#weight' => 4,
    '#type' => 'container',
    '#attributes' => array(
      'class' => array(
        'container-fluid',
        'collection-new-elements',
      ),
    ),
  );




  $defaults = array(
      'value' => '',
      'format' => 'filtered_html',
    );
  $form['container']['chapter-title-row']['test'] = array(
      '#type' => 'text_format',
      '#format' => $defaults['format'],
      '#rows' => 5,

      '#default_value' => $defaults['value'],
      '#prefix' => '<div class="col-md-6 lm-hide-textblock">',
      '#suffix' => '</div>',
      '#attributes' => array(
        'class' => array(
          'lm-hide-textblock',
          'lm-textblock-to-clone',
        ),
        'id' => array(
          'lm-formatted-text-field-hidden-placeholder-loader',
        ),
      ),
    );



  return $form;

}


