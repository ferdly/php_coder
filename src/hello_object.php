<?php

class hello_object
{
    var $greeting = 'Hello';
    var $adjective = '';
    var $noun = 'World';
    var $punctuation = '!';
    var $case = 'nochange';
    var $option_array = array();
    var $return_sentence;
    var $force_return = FALSE;

    public function __construct($option_array = array())
    {
        $this->option_array = $option_array;
    }
    public function compose_sentence()
    {
        $return_sentence = trim($this->greeting . ' ' . $this->adjective);
        $return_sentence = trim($return_sentence . ' ' . $this->noun) . $this->punctuation;
        $this->return_sentence = $return_sentence;
        return $return_sentence;
    }
}
