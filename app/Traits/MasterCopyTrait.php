<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait MasterCopyTrait
{
    /*public $blueprints = [
        1 => 'Cover Page',
        2 => 'Index (Page 1)',
        3 => 'Index (Page 2)',
        4 => 'Introduction',
        5 => 'Pre-Modification Specs - Vehicle Details',
        6 => 'Pre-Modification Specs - Engine / Transmission Details',
        7 => 'Pre-Modification Specs - Scope Check',
        8 => 'Pre-Modification Specs - Vehicle Recall Check',
        9 => 'Photographs Mandatory for RAV (Page 1)',
        10 => 'Photographs Mandatory for RAV (Page 2)',
        11 => 'Odometer Check',
        12 => 'Damage & Corrosion Checks',
        13 => 'Measurements - Under Bonnet',
        14 => 'Measurements - Under Body Front End',
        15 => 'Measurements - Under Body Rear End',
        16 => 'Measurements - Measuring Point Dimensions ',
        17 => 'Secondary Evaluation (Page 1)',
        18 => 'Secondary Evaluation (Page 2)',
        19 => 'Secondary Evaluation (Page 3)',
        20 => 'Consumer Information Notice (Page 1)',
        21 => 'Consumer Information Notice (Page 2)',
        22 => 'Consumer Information Notice (Page 3)',
        23 => 'Verification - Raw Model Report Declaration',
        24 => 'Verification - Compliance & Verification Parties',
        25 => 'Verification - AVV Model Report Summary Checklist',
        26 => 'Verification - AVV declaration',
        27 => 'Vehicle Scope (Work Instruction Part 2)',
    ];*/

    public $placeholders = [
        1 => [
            '1.1' => '!empty($vin) ? $vin : "[VIN]"',
            '1.2' => '$report["make"]',
            '1.3' => '$report["model"]',
            '1.4' => '$report["model_code"]',
            '1.5' => '$report["description"]',
            '1.6' => 'include(app_path() . "/View/qr_code.php")',
            '1.7' => '$report["approval_code"] ?? "Not Yet Approved"',
        ],
        5 => [
            '5.1' => '!empty($vin) ? $vin : "[VIN]"'
        ],
        6 => [
            '6.0' => 'include(app_path() . "/View/variant_heading.php")',
            '6.1' => '$report["data"]["vehicle"]["sev_no"]',
            '6.2' => 'include(app_path() . "/View/oem_vin.php")',
            '6.3' => '$report["data"]["vehicle"]["vin_location"]',
            '6.4' => '$report["make"]',
            '6.5' => '$report["model"]',
            '6.6' => '$report["model_code"]',
            '6.7' => '$report["data"]["vehicle"]["body_type"]',
            '6.8' => '$report["data"]["vehicle"]["category"]',
            '6.9' => '$report["data"]["vehicle"]["build_range_starts"]',
            '6.10' => '$report["data"]["vehicle"]["build_range_ends"] ?? "Current"',
            '6.11' => '$report["data"]["vehicle"]["mass"]',
            '6.12' => '$report["data"]["vehicle"]["steering_location"]',
            '6.13' => 'include(app_path() . "/View/seats.php")',
            '6.14' => '$report["data"]["vehicle"]["doors"]["side"]',
            '6.15' => '$report["data"]["vehicle"]["doors"]["rear"]',
            '6.16' => '$report["data"]["vehicle"]["tyre_code"]',
            '6.17' => '$report["data"]["vehicle"]["tyre_pressure"]["front"]',
            '6.18' => '$report["data"]["vehicle"]["tyre_pressure"]["rear"]',
            '6.19' => '$report["data"]["vehicle"]["rim_size"]',
            '6.22' => '$report["data"]["vehicle"]["rim_offset"]',
            '6.21' => 'include(app_path() . "/View/dimensions.php")',
        ],
        7 => [
            '7.1' => '$report["data"]["engine"]["model"]',
            '7.2' => '$report["data"]["engine"]["capacity"]',
            '7.3' => '$report["data"]["engine"]["config"]',
            '7.4' => '$report["data"]["engine"]["motive_power"]',
            '7.5' => '$report["data"]["engine"]["induction_type"]',
            '7.6' => '$report["data"]["transmission"]["model"]',
            '7.7' => '$report["data"]["transmission"]["type"]',
            '7.8' => '$report["data"]["transmission"]["drive_train_config"]',
            '7.9' => 'include(app_path() . "/View/other_variants.php")'
        ],

        8 => [
            '8.1' => 'include(app_path() . "/View/photos/rav_1.php")'
        ],

        9 => [
            '9.1' => 'include(app_path() . "/View/photos/rav_2.php")',
            '9.2' => 'include(app_path() . "/View/photos/rav_3.php")'
        ],

        10 => [
            '10.1' => 'include(app_path() . "/View/post_modifications.php")',
        ],

        13 => [
            '13.1' => 'include(app_path() . "/View/dimensions/under_bonnet.php")',
        ],

        14 => [
            '14.1' => 'include(app_path() . "/View/dimensions/under_body_front.php")',
        ],

        15 => [
            '15.1' => 'include(app_path() . "/View/dimensions/under_body_rear.php")',
        ],

        16 => [
            '16.1' => 'include(app_path() . "/View/dimensions/under_body_center_rear.php")',
        ],

        17 => [
            '17.1' => 'include(app_path() . "/View/dimensions/under_body_center.php")',
        ],

        18 => [
            '18.1' => '$report["data"]["oem_figures"]["A"]',
            '18.2' => '$report["data"]["oem_figures"]["B"]',
            '18.3' => '$report["data"]["oem_figures"]["C"]',
            '18.4' => '$report["data"]["oem_figures"]["D"]',
            '18.5' => '$report["data"]["oem_figures"]["E"]',
            '18.6' => '$report["data"]["oem_figures"]["F"]'
        ],

        22 => [
            '22.1' => 'include(app_path() . "/View/odometer_check/raw_input.php")',
            '22.2' => 'include(app_path() . "/View/odometer_check/date.php")',
            '22.3' => 'include(app_path() . "/View/odometer_check/reading.php")',
        ],

        23 => [
            '23.1' => '$report["data"]["vehicle"]["check_link"]',
        ],

        25 => [
            '25.1' => 'include(app_path() . "/View/common_adrs_availability.php")',
        ],

        26 => [
            '26.1' => '$report["make"]',
            '26.2' => '!empty($vin) ? ($user->client->raw_company_name . " (RAW ID - " . $user->client->raw_id . ")") : "[Raw Company Name] (Raw ID)"',
            '26.3' => '$report["model"] . " " . $report["model_code"]',
            '26.4' => '"MR" . $report["name"]',
            '26.5' => '(!empty($vin) ? $vin : "[VIN]")',
            '26.6' => '$report["model_code"]',
            '26.7' => 'include(app_path() . "/View/consumer_notice/20_7.php")',
            '26.8' => 'include(app_path() . "/View/consumer_notice/20_8.php")',
            '26.9' => 'include(app_path() . "/View/consumer_notice/20_9.php")',
        ],

        27 => [
            '27.1' => 'include(app_path() . "/View/adr_mods.php")',
            '27.2' => '!empty($vin) ? $vin : "[VIN]"',
            '27.3' => '!empty($vin) ? ($user->first_name . " " . $user->last_name) : "[Raw Representative Name]"',
            '27.4' => '!empty($vin) ? $user->client->raw_company_name : "[Raw Company Name]"',
        ],

        28 => [
            '28.1' => '!empty($vin) ? ($user->first_name . " " . $user->last_name) : "[Raw Representative Name]"',
            '28.2' => '!empty($vin) ? $user->client->raw_company_name : "[Raw Company Name]"',
            '28.3' => '!empty($vin) ? $user->client->raw_id : "[Raw ID]"',
            '28.4' => '!empty($vin) ? $user->client->raw_company_name : "[Raw Company Name]"',
        ],

        29 => [
            '29.1' => '!empty($vin) ? $vin : "[VIN]"'
        ],

        31 => [
            '31.1' => '!empty($vin) ? $vin : "[VIN]"'
        ],

        32 => [
            '32.1' => 'Company::get("name") . " (" .Company::get("code") .")"',
            '32.2' => 'Company::get("acn")',
            '32.3' => 'Company::get("test_facility_id")',
            '32.4' => 'Company::get("web")',
            '32.5' => 'Company::get("email")',
            '32.6' => '!empty($vin) ? $user->client->raw_company_name : ""',
            '32.7' => '!empty($vin) ? $user->client->raw_id : ""',
            '32.8' => '!empty($vin) ? $user->client->address->address_formatted_inline : ""',
            '32.9' => '!empty($vin) ? ($user->first_name . " " . $user->last_name) : ""',
            '32.10' => '!empty($vin) ? "(+61)". $user->mobile_no : ""',
            '32.11' => '!empty($vin) ? $user->email : ""',
        ]

    ];

    private function replace_variables($blueprint_id, $html)
    {
        if (empty($html)) {
            return;
        }

        $doc = new \DOMDocument();
        $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($doc);

        foreach (['h1', 'h2'] AS $tag)
        {
            $elements = $doc->getElementsByTagName($tag);
            foreach ($elements AS $element)
            {
                $element->setAttribute('id', Str::slug($element->nodeValue));
                $doc->saveHTML();
            }
        }

        foreach (['placeholder', 'image'] AS $class) {
            $tags = $xpath->query("//*[@class='$class']");

            foreach ($tags as $tag) {
                $id = $tag->getAttribute('data-id');

                if ($class === 'placeholder') {
                    if (in_array($id, ['6.0', '6.2', '6.13', '6.21', '7.9', '10.1', '22.1', '22.2', '22.3', '25.1', '26.7', '26.8', '26.9'])) {
                        $tag->nodeValue = '<?php ' . $this->placeholders[$blueprint_id][$id] . '?>';
                    } else if ($id == '7.15') {
                        $tag->parentNode->nodeValue = '<?php ' . $this->placeholders[$blueprint_id][$id] . '?>';
                    } else if ($id =='27.1') {
                        $tag->parentNode->parentNode->parentNode->nodeValue = '<?php ' . $this->placeholders[$blueprint_id][$id] . '?>';
                    } else {
                        $tag->nodeValue = '<?php echo ' . $this->placeholders[$blueprint_id][$id] . '?>';
                    }
                }

                if ($class === 'image') {
                    if (in_array($id, ['13.1', '14.1', '15.1', '16.1', '17.1'])) { // , '11.1', '11.2', '11.3', '20.10'
                        $tag->nodeValue = '<?php ' . $this->placeholders[$blueprint_id][$id] . '?>';
                    } else {
                        $tag->parentNode->nodeValue = '<?php ' . $this->placeholders[$blueprint_id][$id] . '?>';
                    }
                }
            }
        }

        return $doc->saveHTML();
    }

}
