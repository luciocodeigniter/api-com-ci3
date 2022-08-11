<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MigrateController extends CI_Controller
{

    public function index()
    {
        $this->load->library('migration');

        if ($this->migration->current(1) === false) {
            show_error($this->migration->error_string());
        }else{

            echo 'Tables Migrated Successfully.';
        }
    }
}
