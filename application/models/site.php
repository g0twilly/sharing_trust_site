<?php

class Site extends CI_Model {
    public $id;
    public $name;
    public $url;

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     *  Get a Site from its ID
     */
    public function get_site($id) {
        $query = $this->db->get_where('sites', 
            array('id', $id)
        );
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->row()->id;
    }

    /**
     * Get a Site from their url
     */
    public function get_site_by_url($url) {
        $query = $this->db->get_where('sites', 
            array('url' => $email)
        );
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->row();
    }

    /**
     * Get all the Sites in the DB
     */
    public function get_all_sites($official=true) {
        if ($official) {
            $query = $this->db->order_by('name', 'asc')->get_where('sites', array('official' => true));
        }
        else {
            $query = $this->db->get('sites');
        }
        return $query->result_array();
    }

    /**
     * Returns a site id of any site, and creates the record if it doesn't exist
     */
    public function get_site_by_name_or_create($name) {
        $query = $this->db->get_where('sites', 
            array('name' => $name)
        );
        if ($query->num_rows() == 0) {
            $insert = $this->db->insert('sites', array(
                'name'  => $name,
                )
            );
            return $this->db->insert_id();
        }
        else {
            return $query->row()->id;
        }
    }

    /**
     * Associates site Ids with User IDs.
     */
    public function add_sites_to_user($user_id) {
        $data = array();
        $sites = $this->input->post('sites');
        if (is_array($sites)) {
            foreach ($sites as $site_id) {
                if ($site_id == 'none') {
                    continue;
                }
                // Non-Official site
                if ($site_id == 'other') {
                    $site_id = $this->get_site_by_name_or_create($this->input->post('new_site'));
                }

                $data[] = array('user_id'   => $user_id,
                                'site_id'   => $site_id);
            }
            if (count($data)) {
                $this->db->insert_batch('users2sites', $data);
            }
        }
    }
}
