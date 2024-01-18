<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meta extends MY_Controller
{

    function __construct()
    {
        // Construct the parent class
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
    }

    public function index_get()
    {
        // SELECT * FROM `z3950_provider` WHERE id in ( 
        //     SELECT DISTINCT source_id FROM `z3950_marc_bibliographies` WHERE id in (SELECT bibid FROM `z3950_marc_bibliography_files` WHERE format_id=5)
        //     )

        $data = $this->input->get();
        $returned = array();
        if (isset($data['term'])) 
        {
            if (isset($data['type'])) {
                if (trim($data['type']) == 'video') {
                    $returned = array(
                        array('id' => 50, 'name' => "قمة المعرفة"),
                        array('id' => 51, 'name' => "تحدي الامية"),
                        array('id' => 55, 'name' => "بيت الشعر"),
                        array('id' => 49, 'name' => "مبادرة بالعربي"),
                        array('id' => 54, 'name' => "ملتقى العرب للابتكار
                        "),

                    );
                }
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($returned));
    }
}
