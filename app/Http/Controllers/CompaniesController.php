<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Moesif\Middleware\MoesifLaravel;

class CompaniesController extends Controller {

    public $middleware;

    public function __construct() {
        $this-> middleware = new MoesifLaravel();
    }
    
    public function updateCompany($id) {

        // Only companyId is required.
        // Campaign object is optional, but useful if you want to track ROI of acquisition channels
        // See https://www.moesif.com/docs/api#update-a-company for campaign schema
        // metadata can be any custom object
        $company = array(
            "company_id" => $id,
            "company_domain" => "acmeinc.com", // If domain is set, Moesif will enrich your profiles with publicly available info 
            "campaign" => array(
                "utm_source" => "google",
                "utm_medium" => "cpc",
                "utm_campaign" => "adwords",
                "utm_term" => "api+tooling",
                "utm_content" => "landing"
            ),
            "metadata" => array(
                "org_name" => "Acme, Inc",
                "plan_name" => "Free",
                "deal_stage" => "Lead",
                "mrr" => 24000,
                "demographics" => array(
                    "alexa_ranking" => 500000,
                    "employee_count" => 47
                )
            )
        );

        $this->middleware->updateCompany($company);
        return response(null, 201);
    }
}
