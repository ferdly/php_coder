<?php

/**
 * Implements hook_drush_command().
 */
function php_coder_drush_command() {

  $items['php-coder'] = array(
    'description' => "Description php_coder: \r\nComposes SQL Code to apply Auto-Entry Label Titles to current titles. Useful when there is lots of data already entered before AEL implemented, or when the configuration of EAL is tweaked.",
    'aliases' => array('phpc'), //don't want to collide into others
    'arguments' => array(
      'area' => "Entity 'Bundle' (for node read 'Content Type'). If not supplied, list of AEL enabled areas are generated to select from.",
    ),
    'options' => array(
      'hello' => 'The number of items to execute for the command (smart defaults as per action, and validated).',
      'lorem' => 'Applies an Offset of limit times lorem. The expectation is that the user leaves limit constant and increments the page, although there is no way to enforce this use (validated).',
      'echo_options' => 'A Comma Separated Value (csv) list of entity_id values to execute for the command (validated).',
      'nodeplode' => 'In conjunction with limit or with echo_options or on its own. Randomizes the order of the lines of code Validated.',
      'vargetter' => 'Smart Defaults, but if you want to overload use yes or no',
      'action' => 'compose, preview, or mask with compose being the default. This will affect the default of limit.',
      'dev' => "Allow for skipping over the 'clean' output in favor of 'dev' output as the code progresses. This may be removed or made more useful developers not coding this module.",
    ),
    'examples' => array(
      'drush phpc --action=mask' => 'PENDING Prints the statement once with the error flag.',
      'drush php_coder --limit=10' => 'PENDING Prints the statement 10 times with the success flag.',
      'drush phpc --echo_options=10,27,125' => 'PENDING Prints the statement 10 times with the success flag.',
    ),
  );

  return $items;
}

/**
 * Callback for the drush-demo-command command
 */
function drush_php_coder($area = FALSE) {

  // Check for existence of argument
    $options = _area_options(); //use custom function to encapsulate
    if (!$area) {
        $area = drush_choice($options, dt('For which Bundle would you like to generate \'Auto Enity-Label Back-Log\' SQL Code?'));
    }

  // Check for correct argument
  $correct_args = array_keys($options);
  // $correct_args_count = count($correct_args);
  // $first_args = $correct_args;
  // $last_arg = array_pop($first_args);
  // $first_args_list = implode(",", $first_args);
  // $first_args_list = str_replace(",", "', '", $first_args_list);
  // $zero = 'Please ask for assistance, there are currently no auto_entitylabel configurations in use';
  // $non_zero = 'Please select';
  // $grammar = $correct_args_count > 2?' among: ':': ';
  // $grammar = $correct_args_count == 2?' between: ':$grammar;
  // $list = '';
  // $list = $correct_args_count == 1?$last_arg:$list;
  // $list = $correct_args_count > 1?$first_args_list. ' and ' . $last_arg:$list;
  // if ($correct_args_count == 0) {
  //   $string = $zero;
  // }else{
  //   $string = $non_zero . $grammar . $list . '. (Or supply no area and select from prompted values.)';
  // }
  if (!in_array($area, $correct_args)) {
    $string = _area_options('string');
    // return drush_set_error(dt('"@type" is not a valid code type. Please choose between "success" and "error".', array('@type' => $area)));
    return drush_set_error(dt('"@type" is not a valid area. @string', array('@type' => $area,'@string' => $string)));
  }

  // Option
  // loop through array of supported options
  /**
   * @circleback can this be gathered from php_coder_drush_command()
   */
  // $area = $area;//KLUDGE
  $supported_option_array = array(
    'action',
    'who',
    'vocab',
    'alt_echo',
    'rand',
    'indent',
    'dev',
    );
  $supported_boolean_options_array = array(
    'rand',
    'indent',
    'dev',
    );
  foreach ($supported_option_array as $index => $option) {
    $option = strtolower($option);//maybe enforce case sensitivity
    $$option = drush_get_option($option, 777);
    if ($$option == 777) {
      if (in_array($option, $supported_boolean_options_array)) {
        $$option = 1;
      }
      $$option = $option != 'action'?$$option:NULL;
    }
    if ($$option != 777) {
      $key = $option == 'action'?'':'option_';
      $key .= str_replace('-', '_', $option);
      $additional_option_array[$key] = $$option;
    }
  }
  /**
   * @todo validate, unpack here? I think in object method
   * @circleback remove application of empty $$option to $additional_option_array
   */
  // drush_print($area);
  // return;
  _drush_execute_phpc($area, $action, $additional_option_array);
  // _drush_execute_phpc($area, $action);
} //END function drush_php_coder($area = FALSE)

function _area_options($which = 'array'){
  $area_options['hello'] = "Obligatory 'Hello World!' code. Use '--who==' option to swap out 'World'.";
  $area_options['lorem'] = "General Lorem Ipsum string. Use '--vocab==' option for non-latin vocabularies.";
  $area_options['pending'] = "Pending Area.";
  switch ($which) {
    case 'array':
      return $area_options;
      break;
    case 'string':
      $correct_args = array_keys($area_options);
      $correct_args_count = count($correct_args);
      $first_args = $correct_args;
      $last_arg = array_pop($first_args);
      $first_args_list = implode(",", $first_args);
      $first_args_list = str_replace(",", ", ", $first_args_list);
      /**
       * @circleback = just add space above, work with below later
       *
       */
      // $first_args_list = str_replace(",", "', '", $first_args_list);
      $zero = 'Please ask for assistance, there are currently no auto_entitylabel configurations in use';
      $non_zero = 'Please select';
      $grammar = $correct_args_count > 2?' among: ':': ';
      $grammar = $correct_args_count == 2?' between: ':$grammar;
      $list = '';
      $list = $correct_args_count == 1?$last_arg:$list;
      $list = $correct_args_count > 1?$first_args_list. ' and ' . $last_arg:$list;
      if ($correct_args_count == 0) {
        $string = $zero;
      }else{
        $string = $non_zero . $grammar . $list . '. (Or supply no area and select from prompted values.)';
      }
      return $string;
      break;

    default:
      return $area_options;
      break;
  }
  return; //OOAAOC
}
