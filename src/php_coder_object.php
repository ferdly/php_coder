<?php

class php_coder_object
{
    var $example;
    var $example_object;
    var $option_array = array();
    var $option_select = FALSE;
    var $option_rand = FALSE;
    var $option_dev = FALSE;
    var $entity_array = array();
    var $bundle_array = array();
    var $entity_id_array = array();
    var $output_string = 'OUTPUT PENDING OR ERROR';//'';
    var $output_message = 'OUTPUT MESSAGE PENDING OR ERROR';//'';
    var $output_message_type = 'success';//assume the best
    var $stack = array();
    var $stack_type = array();
    var $crlf = "zCRLFz";
    var $tab = "zTABz";
    var $space = "zSPACEz";
    var $temp_output;

    public function  __construct($example, $additional_option_array)
    {
        $this->example = $example;
        $this->option_array = $additional_option_array;
    }

    public function unpack()
    {

        $dev = TRUE;
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
        $this->unpack_all_entities_method();
        if (1 == 1 && $this->output_message_type != 'success') {
            $this->gather_output($dev);
            return;
        }
        $this->unpack_bundle();
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
        $this->gather_output();
        // $this->gather_output($dev);//or implement --dev=1 option
        return;
    }

    public function instantiate_example_object()
    {
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
        return;
    }
    public function unpack_options()
    {
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

    }

    public function unpack_all_entities_method()

    {
        // $variable_name = 'entityreference:base-tables';
        // $variable_default = 'MISSING:' . $this->entity . '_' . $this->area;
        $this->entity_array = unpack_all_entities();
    }

    public function unpack_bundle()
    {
        $entity_bundle_array = field_info_bundles();
        $this->bundle = 'article';
        $i = 1;
        foreach ($entity_bundle_array as $entity => $bundle_array) {
            foreach ($bundle_array as $bundle => $value_array) {
                // $this->temp_output[$entity][$bundle] = $i;
                $result[$bundle] = $entity;
                $i++;
            }
        }
        $this->entity = $result[$this->bundle];
        $this->bundle_array = $result;
        $supported = array_keys($result);
        if (!in_array($this->bundle, $supported)) {
            $this->output_message = "\"{$this->bundle}\" is NOT a supported bundle.";
            $this->output_message_type = __FUNCTION__ . ': ' . basename(__FILE__) . ' - line '. __LINE__;
        }
        return;

    }

    public function unpack_example()
    {
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
        return;
    }

    public function utility_ztring_replace($string, $tab_level = 1) {
        /**
         * Method instead of Function so that $attributes can be consistent
         * Could make replacement string $attributes, but makes sense to make them local here
         */
        $crlf_z = $this->crlf;
        $tab_z = $this->tab;
        $space_z = $this->space;
        $tab_level = $tab_level + 0;
        $i = 0;
        $tab = '';
        while ($i < $tab_level) {
            $tab .= "    ";
            $i++;
        }
        if ($this->indent === true) {
            $crlf = "\r\n";
            $tab = $tab;
        }else{
            $crlf = '';
            $tab = '';
        }
        $space = " ";
        $string = str_replace($crlf_z, $crlf, $string);
        $string = str_replace($tab_z, $tab, $string);
        $string = str_replace($space_z, $space, $string);
        return $string;
    }


    public function validate_options()
    {
        return;
    }

    public function gather_output ($dev = FALSE)
    {
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
        // $this->output_string .= "\r\n=====================================\r\n";

        return;
    }

} //END Class php_coder_object


    function unpack_mask_config_singleton($string, $index) {
        $return_array = array();
        $return_array['index'] = $index;
        $return_array['string'] = $string;
        $string = str_replace('[', '', str_replace(']', '', $string));
        $string_array = explode(':', $string);
        $base_entity = array_shift($string_array);
        $field = array_pop($string_array);
        $i = 0;
        foreach ($string_array as $ref_index => $reference) {
            $reference_array[$i] = unpack_reference_singleton($reference, $index, $ref_index);
            $i++;
        }
        $field_table = 'field_data_' . $field;
        $field_name = $field . '_value';
        $return_array['entity'] = $base_entity;
        $return_array['field'] = $field;
        // $return_array['field_name'] = $field_name;
        // $return_array['field_table'] = $field_table;
        $return_array['reference_array'] = $reference_array;
        return $return_array;
    }

    function unpack_all_entities()
    {
        $variable_name = 'entityreference:base-tables';
        $variable_default = 'MISSING: ' . $variable_name;
        // $entity_raw_array = variable_get($variable_name, $variable_default);
        $entity_raw_array = entity_get_info();
        $used_alias_array = array();
        $i = 0;
        function left_init($value) {return substr($value, 0, 1);}
        foreach ($entity_raw_array as $key => $value) {
            $alias_final = '';
            $initials_try =  implode(array_map('left_init', explode('_', $key)));
            $alias_try = $initials_try;
            if (!in_array($alias_try, $used_alias_array)) {
                $alias_final = $alias_try;
            }
            if (strlen($alias_final) < 1) {
                $try_i = 1;
                $init_len = strlen($initials_try) + 0;
                while ($try_i <= $init_len) {
                    $alias_try = substr($initials_try, 0, $try_i);
                    if (!in_array($alias_try, $used_alias_array)) {
                        $alias_final = $alias_try;
                        break;
                    }
                    $try_i++;
                }
            }
            if (strlen($alias_final) < 1) {
                $try_i = 1;
                $key_len = strlen($key) + 0;
                while($try_i < $key_len){
                    $alias_try = substr($key, 0, $try_i);
                    if (!in_array($alias_try, $used_alias_array)) {
                        $alias_final = $alias_try;
                        break;
                    }
                    $try_i++;
                }

            }
            $alias_final = strlen($alias_final) < 1?$key:$alias_final;
            // $alias_final = $initials_try;
            $used_alias_array[] = $alias_final;
            // $entity_array[$key]['name'] = $key;
            // $entity_array[$key]['table'] = $value[0];
            // $entity_array[$key]['alias'] = $alias_final;
            // $entity_array[$key]['primary'] = $value[1];
            $entity_array[$key]['name'] = $key;
            $entity_array[$key]['table'] = $value['base table'];
            $entity_array[$key]['alias'] = $alias_final;
            $entity_array[$key]['primary'] = $value['entity keys']['id'];
            $bundle_fieldname = $value['entity keys']['bundle'];
            $bundle_fieldname = empty($bundle_fieldname)?'EEMPTY':$bundle_fieldname;
            $entity_array[$key]['bundle_fieldname'] = $bundle_fieldname;
            /**
             * @todo what to do when no bundle_fieldnams as above
             */

            $i++;
        }
        return $entity_array;
    }

    function upmfr_left_init($value) {return substr($value, 0, 1);}
