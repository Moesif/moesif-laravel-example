<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Moesif\Middleware\MoesifLaravel;

class UsersController extends Controller {

    public $middleware;

    public function __construct() {
        $this->middleware = new MoesifLaravel();
    }
    
    public function updateUser($id) {

        // Only userId is required.
        // Campaign object is optional, but useful if you want to track ROI of acquisition channels
        // See https://www.moesif.com/docs/api#users for campaign schema
        // metadata can be any custom object
        $user = array(
            "user_id" => $id,
            "company_id" => "67890", // If set, associate user with a company object
            "campaign" => array(
                "utm_source" => "google",
                "utm_medium" => "cpc",
                "utm_campaign" => "adwords",
                "utm_term" => "api+tooling",
                "utm_content" => "landing"
            ),
            "metadata" => array(
                "email" => "john@acmeinc.com",
                "first_name" => "John",
                "last_name" => "Doe",
                "title" => "Software Engineer",
                "sales_info" => array(
                    "stage" => "Customer",
                    "lifetime_value" => 24000,
                    "account_owner" => "mary@contoso.com"
                )
            )
        );

        $this->middleware->updateUser($user);
        return response(null, 201);
    }
}
