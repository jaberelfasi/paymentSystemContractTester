<?php
/*$str1 = file_get_contents(__DIR__."/contract_test_1.txt");
echo $str1; die;*/
require __Dir__.'/ContractBuilder.php';
$cb = new ContractBuilder();
$actualContract=array("/final_contract.txt","","");
$htmlTemplate=array("/contarct_source_code.txt", "/contract_test_1.txt","/contract_test_2.txt");
$cb->buildContract($htmlTemplate[0], $actualContract[0]);

