<?php

class hello_object
{
    var $composition_key;
    var $supported_composition_key_array = array();
    var $greeting;
    var $adjective;
    var $noun;
    var $punctuation;
    var $unpacked = FALSE;
    var $case;
    var $option_array = array();
    var $return_sentence;
    var $force_return = FALSE;

    public function __construct($option_array = array())
    {
        $this->option_array = $option_array;
    }
    public function unpack()
    {
        $dev = TRUE;
        // $dev = FALSE;

        $this->unpack_attribute_defaults();
        if (1 == 2 && $this->output_message_type != 'success') {
            $this->gather_output($dev);
            return;
        }

        $this->unpack_options();
        if (1 == 2 && $this->output_message_type != 'success') {
            $this->gather_output($dev);
            return;
        }

        // $this->validate_options();
        // if (1 == 2 && $this->output_message_type != 'success') {
        //     $this->gather_output($dev);
        //     return;
        // }
        // $this->unpack_example();
        // if (1 == 2 && $this->output_message_type != 'success') {
        //     $this->gather_output($dev);
        //     return;
        // }
        $this->unpacked = TRUE;
        return;
    }

    public function unpack_attribute_defaults()
    {
        /**
         * do check for external overload, regarless of $unpacked still FALSE
         *
         * encapsulated defaults
         * * composition_key
         * * greeting_array
         *   \_ UNDECLARED ATTRIBUTE, not sure of Drupal Coding Standard here
         * * supported_composition_key_array
         * * noun
         * * adjective
         *   \_ NULL and otherwise Empty() indistinguishable from empty string, moot but comment to document it was considered
         * * punctuation
         * * case
         */
        if (!is_array($this->greeting_array) || count($this->greeting_array) == 0) {
            $this->greeting_array['hello'] = 'Hello';
            $this->greeting_select_array['hello'] = 'Select Hello';
            $this->greeting_array['goodbye'] = 'Good-bye';
            $this->greeting_select_array['goodbye'] = 'Select Good-bye';
            $this->greeting_array['hail'] = 'Hail';
            $this->greeting_select_array['hail'] = 'Select Hail';
        }
        $this->composition_key = empty($this->composition_key) ? 'hello':$this->composition_key; //encapsulated default being set
        $this->noun = empty($this->noun) ? 'World':$this->noun; //encapsulated default being set
        $this->adjective = empty($this->adjective) ? '':$this->adjective; //encapsulated default being set
        $this->punctuation = empty($this->punctuation) ? '!':$this->punctuation; //encapsulated default being set

        $this->supported_composition_key_array = array_keys($this->greeting_array);

    }

        public function unpack_options()
    {

        $true_values_array = array('true', 'yes', 'on', '1',);
        $false_values_array = array('false', 'no', 'off', '0',);
        #\_ consider dyslexic 'on' vs 'no' problem

        $option_rand_passed = strtolower($this->option_array['option_rand']);
        $option_rand = NULL;
        $option_rand = in_array($option_rand_passed, $true_values_array)?TRUE:$option_rand;
        $option_rand = in_array($option_rand_passed, $false_values_array)?FALSE:$option_rand;

        $option_select_passed = strtolower($this->option_array['option_select']);
        $option_select = NULL;
        $option_select = in_array($option_select_passed, $true_values_array)?TRUE:$option_select;
        $option_select = in_array($option_select_passed, $false_values_array)?FALSE:$option_select;
        $option_select = in_array($option_select_passed, $this->supported_composition_key_array)?$option_select_passed:$option_select;

        $option_dev_passed = strtolower($this->option_array['option_dev']);
        $option_dev = NULL;
        $option_dev = in_array($option_dev_passed, $true_values_array)?TRUE:$option_dev;
        $option_dev = in_array($option_dev_passed, $false_values_array)?FALSE:$option_dev;


        $this->option_select = $option_select;
        $this->option_rand = $option_rand;
        $this->option_dev = $option_dev;
    }

    public function compose_sentence()
    {
        if ($this->unpacked !== TRUE) {
            $this->unpack();
        }
        $this->apply_option_rand();
        $composition_key = $this->composition_key;
        $composition_key = in_array($this->option_select, $this->supported_composition_key_array)?$this->option_select:$composition_key;
        if ($this->option_select === true) {
            $composition_key = $this->select_composition_key();
            if (!empty($this->return_sentence)) {
                return $this->return_sentence;
            }
        }
        #\_ option_select in_array and === true are mutually exclusive, so okay
        $this->composition_key = $composition_key;
        $this->greeting = $this->greeting_array[$composition_key];
        $this->apply_composition_key();
        // $this->noun = 'World';
        // $this->adjective = $this->composition_key == 'goodbye' ? 'Cruel' : $this->adjective;
        $return_sentence = trim($this->greeting . ' ' . $this->adjective);
        $return_sentence = trim($return_sentence . ' ' . $this->noun) . $this->punctuation;
        $this->return_sentence = $return_sentence;
        return $return_sentence;
    }
    public function apply_composition_key(){
        if ($this->rand) {
            return;
        }
        $composition_key = $this->composition_key;
        /**
         * noun
         */
        $this->noun = $composition_key == 'hail' ? 'Ceasar' : $this->noun;

        /**
         * adjective
         */
        $this->adjective = $composition_key == 'goodbye' ? 'Cruel' : $this->adjective;

        /**
         * punctuation
         */
        $holder = 'no punctuation changes thus far, but ready when they happen';

        /**
         * case
         * no case changing is appropriate here since it doesn't comport with it being based on $composition_key
         * \_ it would need to be its own method, too much for demo
         */
    }

    public function apply_option_rand() {
        if (!$this->option_rand) {
            return; //no change
        }
        /**
         * pretty easy to (properly) place in unpack_atttributes() method, but...
         * * \_ also would allow overload, but...
         */

        $greeting_array = array_flip($this->greeting_array);
        shuffle($greeting_array);
        $this->composition_key = array_shift($greeting_array);
        $noun_array = array('World','Ceasar');
        shuffle($noun_array);
        $this->noun = array_shift($noun_array);
        $adjective_array = array('zEMPTYz','Cruel');
        shuffle($adjective_array);
        $this->adjective = array_shift($adjective_array);
        $this->adjective = str_replace('zEMPTYz', '', $this->adjective);
        $punctuation_array = array('!','.','?');
        shuffle($punctuation_array);
        $this->punctuation = array_shift($punctuation_array);

        // $this->noun = array_shift(shuffle(array('World','Ceasar')));
        // $this->adjective = array_shift(shuffle(array('','Cruel')));
        // $this->punctuation = array_shift(shuffle(array('!','.','?')));
        return;
    }

    public function select_composition_key() {
        $prompt = "Select which 'hello example' Sentence to return.";
        // $composition_key = 'hail';
        $composition_key = drush_choice($this->greeting_select_array, $prompt);
        if ($composition_key == '0') {
            $this->return_sentence = 'You do not get your deposit back upon cancellation.';
            return;
        }
        if (!in_array($composition_key, $this->supported_composition_key_array)) {
            $composition_key = 'hello'; //no thrown error, just revert to default
        }
        $this->composition_key = $composition_key;
        return $composition_key;
    }
}
