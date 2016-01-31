<?php

class hello_object
{
    var $composition_key = 'hello';
    var $supported_composition_key_array = array();
    var $greeting;
    var $adjective = '';
    var $noun = 'World';
    var $punctuation = '!';
    var $unpacked = FALSE;
    var $case = 'nochange';
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
        $this->unpack_options();
        if (1 == 2 && $this->output_message_type != 'success') {
            $this->gather_output($dev);
            return;
        }

        $this->unpack_composition_key();
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
        return;
    }

        public function unpack_options()
    {

        $true_values_array = array('true', 'yes', 'on', '1',);
        $false_values_array = array('false', 'no', 'off', '0',);
        #\_ consider dyslexic 'on' vs 'no' problem

        $option_rand_passed = strtolower($option_array['option_rand']);
        $option_rand = NULL;
        $option_rand = in_array($option_rand_passed, $true_values_array)?TRUE:$option_rand;
        $option_rand = in_array($option_rand_passed, $false_values_array)?FALSE:$option_rand;

        $option_select_direct_array = array('hello','goodbye',);
        $option_select_passed = strtolower($option_array['option_select']);
        $option_select = NULL;
        $option_select = in_array($option_select_passed, $true_values_array)?TRUE:$option_select;
        $option_select = in_array($option_select_passed, $false_values_array)?FALSE:$option_select;
        $option_select = in_array($option_select_passed, $option_select_direct_array)?$option_select_passed:$option_select;

        $option_dev_passed = strtolower($option_array['option_dev']);
        $option_dev = NULL;
        $option_dev = in_array($option_dev_passed, $true_values_array)?TRUE:$option_dev;
        $option_dev = in_array($option_dev_passed, $false_values_array)?FALSE:$option_dev;


        $this->option_select = $option_select;
        $this->option_rand = $option_rand;
        $this->option_dev = $option_dev;
    }

    public function unpack_composition_key ()
    {
        $this->composition_key = 'hello'; //encapsulated default being set
        $this->supported_composition_key_array = array('hello','goodbye');//encapsulated options being set
    }

    public function compose_sentence()
    {
        $composition_key = $this->composition_key;
        $composition_key = in_array($this->option_select, $this->supported_composition_key_array)?$this->option_select:$composition_key;
        if ($this->option_select === true) {
            $return_sentence = 'SELECT OPTION HERE';
            $this->return_sentence = $return_sentence;
            return $return_sentence;
        }

        $return_sentence = trim($this->greeting . ' ' . $this->adjective);
        $return_sentence = trim($return_sentence . ' ' . $this->noun) . $this->punctuation;
        $this->return_sentence = $return_sentence;
        return $return_sentence;
    }
}
