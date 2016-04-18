<?php

namespace libs;
class Model extends \Illuminate\Database\Eloquent\Model {

    public function getTable()
    {
        if (isset($this->table)) return $this->table;

        return str_replace('\\', '', snake_case(class_basename($this)));
    }

}
