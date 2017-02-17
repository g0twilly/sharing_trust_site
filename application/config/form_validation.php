<?php

$config = array(
         'account/signup' => array(
            array(
                  'field'   => 'first_name',
                  'label'   => 'lang:first_name',
                  'rules'   => 'trim'
            ),
            array(
                  'field'   => 'last_name',
                  'label'   => 'lang:last_name',
                  'rules'   => 'trim'
            ),
            array(
                  'field'   => 'email',
                  'label'   => 'lang:email',
                  'rules'   => 'trim|required|valid_email|is_unique[users.email]'
            ),
            array(
                  'field'   => 'token',
                  'label'   => 'lang:token',
                  'rules'   => 'required',
            ),
            array(
                  'field'   => 'age',
                  'label'   => 'lang:age',
                  'rules'   => 'trim|required|is_natural_no_zero',
            ),
            array(
                  'field'   => 'zip',
                  'label'   => 'lang:zipcode',
                  'rules'   => 'trim|required|is_natural|greater_than[0]|less_than[100000]|min_length[5]|callback__validate_zipcode[zip]',
            ),
            array(
                  'field'   => 'gender',
                  'label'   => 'lang:gender',
                  'rules'   => 'required',
            ),
            array(
                  'field'   => 'marital_status',
                  'label'   => 'lang:marital_status',
                  'rules'   => 'required',
            ),
            array(
                  'field'  => 'ip_address',
                  'label'  => 'lang:ip_address',
                  'rules'  => 'callback__validate_ip_address[ip_address]',
            ),
      ),
      'account/avatar' => array(
            array(
                  'field'  => 'avatar',
                  'label'  => 'lang:avatar',
                  'rules'  => 'required|trim',
            ),
      ),
      'account/login' => array(
            array(
                  'field'  => 'login',
                  'label'  => 'lang:email',
                  //'rules'  => 'trim|required|valid_email',
                  'rules'  => 'trim|required',
            ),
      ),
      'account/interested' => array(
            array(
                  'field'  => 'email',
                  'label'  => 'lang:email',
                  'rules'  => 'trim|required|valid_email',
            ),
      ),
      'pages/risk' => array(
            array(
                  'field'  => 'answer',
                  'label'  => 'lang:answer',
                  'rules'  => 'trim|required',
            ),
      ),
      'pages/risk2' => array(
            array(
                  'field'  => 'answer',
                  'label'  => 'lang:answer',
                  'rules'  => 'trim|required|numeric|greater_than[0]',
            ),
      ),
      'pages/welcome' => array(
            array(
                  'field'   => 'username',
                  'label'   => 'lang:email',
                  'rules'   => 'trim|required|valid_email|is_unique[users.email]'
            ),
            array(
                  'field'   => 'token',
                  'label'   => 'lang:token',
                  'rules'   => 'required',
            ),
      ),
      'game/complete' => array(
            array(
                  'field'  => 'answer',
                  'label'  => 'lang:answer',
                  'rules'  => 'trim|required',
            ),
      ),
      'game/instructions' => array(
            array(
                  'field'  => 'understand',
                  'label'  => 'lang:understand',
                  'rules'  => 'trim|required',
            ),
      ),
      'pages/survey_airbnb' => array(
            array(
                  'field'  => 'host_or_guest',
                  'label'  => 'lang:answer_to_question',
                  'rules'  => 'trim|required',
            ),
            array(
                  'field'  => 'interact_with_host',
                  'label'  => 'lang:answer_to_question',
                  'rules'  => 'trim',
            ),
            array(
                  'field'  => 'first_interaction',
                  'label'  => 'lang:answer_to_question',
                  'rules'  => 'trim',
            ),
            array(
                  'field'  => 'hangout',
                  'label'  => 'lang:answer_to_question',
                  'rules'  => 'trim',
            ),
      ),
      'pages/survey_postgame' => array(
            array(
                  'field'  => 'experience',
                  'label'  => 'lang:experience',
                  'rules'  => 'trim',
            ),
            array(
                  'field'  => 'trust',
                  'label'  => 'lang:trust',
                  'rules'  => 'trim',
            ),
      ),
);
