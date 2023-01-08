<?php

namespace App\Controller;
use OpenApi\Annotations as OA;

class OauthClientController extends BaseController {
    public function __construct(){
		parent::__construct();
    }

    public function retrieve()
    {
        // RETRIEVE ALL OAUTH_CLIENT TABLE
        $sql = "SELECT * FROM oauth_clients";
        $data = [];
        foreach ($this->db->query($sql) as $row) {
            $data[] = array(
                'client_id' => $row['client_id'],
                'client_secret' => $row['client_secret'],
                'redirect_uri' => $row['redirect_uri']
            );
        }
        $response = ["code"=> 1, 'data' => $data];
        echo json_encode($response);
    }
}