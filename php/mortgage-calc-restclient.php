<?php

// constants
const PATH_TO_CLASSES = ".class";

// user classes autoloading
spl_autoload_register(function($class_name)
{
  $class_source_file_path = PATH_TO_CLASSES."/".$class_name.".php";
  require_once $class_source_file_path;
});

$loan_amount = 350000.0;
$loan_term_months = 12;
$interest_rate_percent_pa = 9.00;

$requestJson = tJson::codeCalculation($loan_amount, $loan_term_months, $interest_rate_percent_pa);

$replyJson = tWeb::request($requestJson);
if ($replyJson === null)
{
  echo " - error sending POST web query".PHP_EOL;
  return;
}

$replyIData = tJson::decodeResultCalculation($replyJson);
if ($replyIData === null)
{
  $errorString = tJson::getLastErrorString();

  if ($errorString != null)
  {
    echo " - replied error '".$errorString."'".PHP_EOL;
  }
  else
  {
    echo " - error decoding of reply JSON".PHP_EOL;
  }

  return;
}

echo " - interest rate % p.m.: ".$replyIData[tJson::INTEREST_RATE_PERCENT_PM].PHP_EOL;
echo " - discont factor: ".$replyIData[tJson::DISCONT_FACTOR].PHP_EOL;
echo " - monthly payment: ".$replyIData[tJson::MONTHLY_PAYMENT].PHP_EOL;
echo " - total paid: ".$replyIData[tJson::TOTAL_PAID].PHP_EOL;

foreach ($replyIData[tJson::SCENARIO] as $index => $oneMonth)
{
  echo PHP_EOL;

  echo " - month number: ".($index + 1).PHP_EOL;
  echo "   - payment: ".  $oneMonth[tJson::PAYMENT].PHP_EOL;
  echo "   - interest: ".  $oneMonth[tJson::INTEREST].PHP_EOL;
  echo "   - amortization: ".  $oneMonth[tJson::AMORTIZATION].PHP_EOL;
  echo "   - account balance: ".  $oneMonth[tJson::ACCOUNT_BALANCE].PHP_EOL;
}

?>
