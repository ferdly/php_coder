<?php

/**
 * Implements hook_drush_command().
 */
function php_coder_drush_command() {

  $items['php-coder'] = array(
    'description' => "Description php_coder: \r\nComposes SQL Code to apply Auto-Entry Label Titles to current titles. Useful when there is lots of data already entered before AEL implemented, or when the configuration of EAL is tweaked.",
    'aliases' => array('phpc'), //don't want to collide into others
    'arguments' => array(
      'example' => "Example name is the argument. If not supplied, list of AEL enabled examples are generated to select from.",
    ),
    'options' => array(
      'rand' => 'Pass to the target Example that all options should be randomized.',
      'select' => 'Pass to the target Example that, where possible, the user should be prompted to select any options.',
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
function drush_php_coder($example = FALSE) {

  // Check for existence of argument
    $options = _example_options(); //use custom function to encapsulate
    if (!$example) {
        $example = drush_choice($options, dt('Which Example would you like to interact with using \'PHP-Coder\'?'));
    }

  // Check for correct argument
  $correct_args = array_keys($options);
  if (!in_array($example, $correct_args)) {
    if ($example == '0') {
      drush_user_abort('Buh-Bye!');
      return;
    }
    $string = _example_options('string');
    /**
     * @circleback = how to escape quotes within dt?
     * it's really wrong to circumvent dt() like this
     */
    return drush_set_error(dt('"@type" is not a valid example. ',
      array('@type' => $example)) . $string);
  }

  // Option
  // loop through array of supported options
  /**
   * @circleback can this be gathered from php_coder_drush_command()
   */
  // $example = $example;//KLUDGE
  $supported_option_array = array(
    'rand',
    'select',
    'dev',
    );
  $supported_boolean_options_array = array(
    'rand',
    'indent',
    'dev',
    );
  foreach ($supported_option_array as $index => $option) {
    $option = strtolower($option);//maybe enforce case sensitivity
    $$option = drush_get_option($option, NULL);
    if ($$option == 777) {
      #\_ wrong-test of how to get default value by calling without '='
      if (in_array($option, $supported_boolean_options_array)) {
        $$option = 1;
      }
    }
    $key = 'option_';
    $key .= str_replace('-', '_', $option);
    $additional_option_array[$key] = $$option;
  }
  /**
   * @todo validate, unpack here? I think in object method
   * @circleback remove application of empty $$option to $additional_option_array
   */
  // drush_print($example);
  // return;
  _drush_execute_phpc($example, $additional_option_array);
  // _drush_execute_phpc($example, $action);
} //END function drush_php_coder($example = FALSE)

function _example_options($which = 'array'){
  $example_options = array();
  $example_options['hello'] = "Obligatory 'Hello World!' code.";
  // $example_options['lorem'] = "General Lorem Ipsum string. Use '--vocab==' option for non-latin vocabularies.";
  // $example_options['nodeplode'] = "Play around with nodes.";
  switch ($which) {
    case 'array':
      return $example_options;
      break;
    case 'string':
      $correct_args = array_keys($example_options);
      $correct_args_count = count($correct_args);
      $first_args = $correct_args;
      $last_arg = '"' .  array_pop($first_args) . '"';
      $first_args_list = implode(",", $first_args);
      $first_args_list = '"' . str_replace(",", '", "', $first_args_list) . '"';
      $zero = 'Please ask for assistance, there are currently no php_coder examples in use';
      $non_zero = 'Please select';
      $grammar = $correct_args_count > 2?' among ':': ';
      $grammar = $correct_args_count == 2?' between ':$grammar;
      $list = '';
      $list = $correct_args_count == 1?$last_arg:$list;
      $list = $correct_args_count > 1?$first_args_list. ' and ' . $last_arg:$list;
      if ($correct_args_count == 0) {
        $string = $zero;
      }else{
        $string = $non_zero . $grammar . $list . '. (Or supply no example and select from prompted values.)';
      }
      return $string;
      break;

    default:
      return $example_options;
      #\_ OOAAOC notwithstanding default $which, this is its raison detre
      break;
  }
  return; //OOAAOC
}
