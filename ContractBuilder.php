<?php

class ContractBuilder {

    private $customer;
    private $contract_length; 
    private $currency_note;
    private $initial_fee;
    private $renew_statement;
    private $payment_note;
    private $reccurring_fee;
    private $monthly_condition;
    private $agreed_spend;
    private $addpeople_branch_name;
    private $terms_and_conditions;
    private $addpeople_website_url;
    public $contract_id;
    static $dbfields = [''];

    //construct creation waiting for instructions
    //methods:
    private function findContract($actualContract) {
        $dataArray = array();
        $searchStr = file_get_contents(__DIR__ . $actualContract);

        $regex = array(
            '/Durcan Fencing/'
            , '/3/'
            , '/UK Pounds/'
            , '/£200/'
            , '/Thank you for choosing Add People\./'
            , '/Your first monthly payment date will be 22nd March 2017./'
            , '/£119/'
            , '/n\.a/'
            , '/n\.a/'
            , '/Add Media \(Group\) Ltd /'
            , '/https:\/\/www\.addpeople\.co\.uk\/ppc-terms-and-conditions\//'
            , '/https:\/\/www\.addpeople\.co\.uk\//'
        );

        for ($i = 0; $i < sizeof($regex); $i++) {
            preg_match($regex[$i], $searchStr, $match);
            if (!empty($match[0])) {
                array_push($dataArray, $match[0]);
            } else {
                array_push($dataArray, "null");
            }
        }


        return $dataArray;
    }

    private function initialize($htmlTemplate,$dataArray) {
        $this->customer = $dataArray[0];
        $this->contract_length = $dataArray[1];
        $this->currency_note = $dataArray[2];
        $this->initial_fee = $dataArray[3];
        $this->renew_statement = $dataArray[4];
        $this->payment_note = $dataArray[5];
        $this->reccurring_fee = $dataArray[6];
        $this->monthly_condition = $dataArray[7];
        $this->agreed_spend = $dataArray[8];
        $this->addpeople_branch_name = $dataArray[9];
        $this->terms_and_conditions = $dataArray[10];
        $this->addpeople_website_url = $dataArray[11];

        $regex = array(
            '/@company@/'
            , '/@contractlen@/'
            , '/@currencynote@/'
            , '/@initial@/'
            , '/@isrenew@/'
            , '/@paymentnote@/'
            , '/@recurringfee@/'
            , '/n\.a/'
            , '/n\.a/'
            , '/@branchname@/'
            , '/@tandc@/'
            , '/@website@/'
        );
        $replacement = array(
            $this->customer
            , $this->contract_length
            , $this->currency_note
            , $this->initial_fee
            , $this->renew_statement
            , $this->payment_note
            , $this->reccurring_fee
            , $this->monthly_condition
            , $this->agreed_spend
            , $this->addpeople_branch_name
            , "<a href=".$this->terms_and_conditions.">terms and conditions</a>"
            , "<a href=".$this->addpeople_website_url.">website</a>"
        );

        $contractStr = file_get_contents(__DIR__.$htmlTemplate); //handles open, read and close handle
        echo preg_replace($regex, $replacement, $contractStr);
    }

    public function buildContract($htmlTemplate, $actualContract) {
        $this->initialize($htmlTemplate,$this->findContract($actualContract));
    }

}
