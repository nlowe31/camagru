<?php

class Form {
    public $html;

    public function __construct($attr = NULL) {
        $this->html = "<form $attr>\n";
    }

    public function put() {
        $this->html .= "</form>\n";
        echo $this->html;
    }

    public function input($type, $name, $class = NULL, $id = NULL, $value = NULL) {
        $this->html .= '<input type="' . $type . '" ';
        if (isset($name))
            $this->html .= 'name="' . $name . '" ';
        if (isset($class))
            $this->html .= 'class="' . $class . '" ';
        if (isset($id))
            $this->html .= 'id="' . $id . '" ';
        if (isset($value))
            $this->html .= 'value="' . $value . '" ';
        $this->html .= "/><br>\n";
    }

    public function text($name, $class = NULL, $id = NULL, $value = NULL) {
        $this->input('text', $name, $class, $id, $value);
    }

    public function password($name, $class = NULL, $id = NULL, $value = NULL) {
        $this->input('password', $name, $class, $id, $value);
    }

    public function hidden($name, $value = NULL) {
        $this->input('hidden', $name, NULL, NULL, $value);
    }

    public function submit($name, $class = NULL, $id = NULL, $value = NULL) {
        $this->input('submit', $name, $class, $id, $value);
    }

}

?>