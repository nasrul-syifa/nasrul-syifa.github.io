<?php
/**
 * Created by PhpStorm.
 * User: anasrulysf
 * Date: 4/27/2022
 * Time: 10:29 PM
 */

class Welcome extends CI_Controller
{
    public function index(){
        $this->load->view("frontoffice/index");
    }
}