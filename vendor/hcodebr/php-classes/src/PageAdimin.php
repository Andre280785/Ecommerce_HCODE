<?php

namespace Hcode;

class PageAdimin extends Page{

    public function __construct($opts = array(), $tpl_dir = "/views/admin/")
    {
        parent::__construct($opts, $tpl_dir);
    }
}
