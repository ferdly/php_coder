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
            $this->greeting_array['goodbye'] = 'Good-bye';
            $this->greeting_array['hail'] = 'Hail';
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
        $composition_key = $this->composition_key;
        $composition_key = in_array($this->option_select, $this->supported_composition_key_array)?$this->option_select:$composition_key;
        $this->composition_key = $composition_key;
        if ($this->option_select === true) {
            $dev_output = 'File: ' . basename(__FILE__) . '; Function: ' . __FUNCTION__ . '; Line: ' . __LINE__ . ';';
            $return_sentence = 'SELECT OPTION HERE ' . $dev_output;
            $this->return_sentence = $return_sentence;
            return $return_sentence;
        }
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
}
