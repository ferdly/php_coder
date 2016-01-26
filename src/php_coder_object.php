<?php

class php_coder_object
{
    var $example;
    var $example_object;
    var $option_array = array();
    var $option_select = FALSE;
    var $option_rand = FALSE;
    var $option_dev = FALSE;
    var $output_string = 'OUTPUT PENDING OR ERROR';//'';
    var $output_message = 'OUTPUT MESSAGE PENDING OR MOOT';//'';
    var $output_message_type = 'success';//assume the best
    var $stack_message = array();
    var $stack_dev_message = array();
    var $stack_status = array();

    public function  __construct($example, $additional_option_array)
    {
        $this->stack_add('entering', __FILE__, __FUNCTION__, __LINE__);
        $this->example = $example;
        $this->option_array = $additional_option_array;
        $this->stack_add('exiting', __FILE__, __FUNCTION__, __LINE__);
    }

    public function unpack()
    {

        $this->stack_add('entering', __FILE__, __FUNCTION__, __LINE__);
        $dev = TRUE;
        // $dev = FALSE;
        $this->instantiate_example_object();
        if (1 == 1 && $this->output_message_type != 'success') {
            $this->gather_output($dev);
            return;
        }
        $this->unpack_options();
        if (1 == 1 && $this->output_message_type != 'success') {
            $this->gather_output($dev);
            return;
        }
        $this->validate_options();
        if (1 == 1 && $this->output_message_type != 'success') {
            $this->gather_output($dev);
            return;
        }
        $this->unpack_example();
        if (1 == 1 && $this->output_message_type != 'success') {
            $this->gather_output($dev);
            return;
        }
        $this->stack_add('success', __FILE__, __FUNCTION__, __LINE__, 'About to call gather_output');
        $this->gather_output();
        // $this->gather_output($dev);//or implement --dev=1 option
        return;
    }

    public function instantiate_example_object()
    {
        $this->stack_add('entering', __FILE__, __FUNCTION__, __LINE__);
        $example = $this->example;
        if (empty($example)) {
            $example = 'hello';//more codey way to set default
            $this->example = $example;
        }
        switch ($example) {
            case 'hello':
                require_once 'hello_object.php';
                $example_object = new hello_object($this->option_array);
                $this->example_object = $example_object;
                break;

            default:
                $this->supported_example_array = array('hello'); // dynamic overload for print_r() purposes
                $this->output_message = "\"$example\" is NOT a supported example.";
                $this->output_message_type = __FUNCTION__ . ': ' . basename(__FILE__) . ' - line '. __LINE__;
                break;
        }
        $this->stack_add('exiting', __FILE__, __FUNCTION__, __LINE__);
        return;
    }
    public function unpack_options()
    {
        $this->stack_add('entering', __FILE__, __FUNCTION__, __LINE__);
        $option_array = $this->option_array;


        $true_values_array = array('true', 'yes', 'on', '1',);
        $false_values_array = array('false', 'no', 'off', '0',);
        #\_ consider dyslexic 'on' vs 'no' problem

        $option_rand_passed = strtolower($option_array['option_rand']);
        $option_rand = NULL;
        $option_rand = in_array($option_rand_passed, $true_values_array)?TRUE:$option_rand;
        $option_rand = in_array($option_rand_passed, $false_values_array)?FALSE:$option_rand;

        $option_select_passed = strtolower($option_array['option_select']);
        $option_select = NULL;
        $option_select = in_array($option_select_passed, $true_values_array)?TRUE:$option_select;
        $option_select = in_array($option_select_passed, $false_values_array)?FALSE:$option_select;

        $option_dev_passed = strtolower($option_array['option_dev']);
        $option_dev = NULL;
        $option_dev = in_array($option_dev_passed, $true_values_array)?TRUE:$option_dev;
        $option_dev = in_array($option_dev_passed, $false_values_array)?FALSE:$option_dev;


        $this->option_select = $option_select;
        $this->option_rand = $option_rand;
        $this->option_dev = $option_dev;

        $this->stack_add('exiting', __FILE__, __FUNCTION__, __LINE__);
    }

    public function unpack_example()
    {
        $this->stack_add('entering', __FILE__, __FUNCTION__, __LINE__);
        $example = $this->example;
        if (empty($example)) {
            $example = 'EERROR';//this is an error
        }
        switch ($example) {
            case 'hello':
                $this->output_string = $this->example_object->compose_sentence();
                break;

            default:
                $this->supported_example_array = array('hello'); // dynamic overload for print_r() purposes
                $this->output_message = "\"$example\" is NOT a supported example.";
                $this->output_message_type = __FUNCTION__ . ': ' . basename(__FILE__) . ' - line '. __LINE__;
                break;
        }
        $this->stack_add('exiting', __FILE__, __FUNCTION__, __LINE__);
        return;
    }

    public function validate_options()
    {
        $this->stack_add('entering', __FILE__, __FUNCTION__, __LINE__);
        $this->stack_add('exiting', __FILE__, __FUNCTION__, __LINE__);
        return;
    }

    public function gather_output ($dev = FALSE)
    {
        $this->stack_add('entering', __FILE__, __FUNCTION__, __LINE__);
        $crlf = "\r\n"; //$this->crlf; // use ztring_replace() method of this gets too hairy
        $tab = "    "; //$this->tab;
        $space = " "; //$this->space;

        $dev = $this->option_dev === TRUE?TRUE:$dev;
        /**
         * @circleback = truly evaluate $dev
         */
        // $dev = true;
        $default_output = 'OUTPUT PENDING OR ERROR';
        if ($this->output_string != $default_output) {
            if ($dev !== TRUE) {
                return;
            }
        }

        $attribute_array = array();
        $prepend_output_string = "=====================================";
        $postpend_output_string = "\r\n=====================================\r\n";
        if (count($attribute_array) > 0) {
            foreach ($attribute_array as $index => $attribute) {
                $attribute_title = empty($attribute_title_array[$attribute])?$attribute:$attribute_title_array[$attribute];
                if ($attribute != 'output_string') {
                    $this->output_string .= "\r\n=====\r\n" . $attribute_title . ":\r\n" . print_r($this->$attribute, TRUE);
                }
            } //END foreach()
        }else{
            $this->output_string .= "\r\n" . print_r($this, TRUE);
        }
        // $this->output_string $prepend_output_string . $this->output_string . $postpend_output_string;

        $this->stack_add('exiting', __FILE__, __FUNCTION__, __LINE__);//MOOT here in particular
        return;
    }

    public function stack_add($status = 'success', $file = '', $function = '', $line = '', $string = 'DDEFAULT',  $dev_string = 'DDEFAULT')
    {
        return;
        $file = empty($file)?__FILE__:$file;
        $file = basename($file);
        $function = empty($function)?__FUNCTION__:$function;
        $line = empty($line)?__LINE__:$line;
        $string_status = 'NNULL';
        $string_status = strtolower($status) == 'entering'?'ENTERING':$string_status;
        $string_status = strtolower($status) == 'exiting'?'EXITING':$string_status;
        #\_ others...
        $status = $string_status == 'NNULL'?$status:'success';

        if ($string == 'DDEFAULT') {
            $supported_string_statuses = array('ENTERING', 'EXITING', );
            $string = in_array($string_status, $supported_string_statuses)?ucfirst(strtolower($string_status)):'Stack called';
            $string .= ' \'' . $function . '\' function on line ' . $line . ' of ' . $file . ' file.';
        }
        $dev_message = 'Line:' . $line . '; Function:' . $function . '; File:' . $file . ';';
        $dev_message .= $dev_string == 'DDEFAULT'?'': "'" . $dev_string . "'";
        $this->stack_message[] = $string;
        $this->stack_dev_message[] = $dev_message;
        $this->stack_status[] = $status;

    }

} //END Class php_coder_object
