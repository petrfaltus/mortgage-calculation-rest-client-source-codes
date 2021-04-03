<?php

// constants
const PATH_TO_CLASSES = ".class";

// user classes autoloading
spl_autoload_register(function($class_name)
{
  $class_source_file_path = PATH_TO_CLASSES."/".$class_name.".php";
  require_once $class_source_file_path;
});

const MESSAGE_ERROR_CONTACTING_SERVICE = "error contacting the REST service";
const MESSAGE_ERROR_DECODING_JSON = "error decoding the reply JSON";
const MESSAGE_RECEIVED_ERROR = "received error";

$loan_amount = 350000.0;
$loan_term_months = 12;
$interest_rate_percent_pa = 9.00;

$requestJson = tJson::codeCalculation($loan_amount, $loan_term_months, $interest_rate_percent_pa);

$replyJson = tWeb::request($requestJson);
if ($replyJson === null)
{
  echo " - ".MESSAGE_ERROR_CONTACTING_SERVICE.PHP_EOL;
  return;
}

$replyData = tJson::decodeResultCalculation($replyJson);
if ($replyData === null)
{
  $errorString = tJson::getLastErrorString();

  if ($errorString != null)
  {
    echo " - ".MESSAGE_RECEIVED_ERROR.": ".$errorString.PHP_EOL;
  }
  else
  {
    echo " - ".MESSAGE_ERROR_DECODING_JSON.PHP_EOL;
  }

  return;
}

echo " - interest rate % p.m.: ".$replyData[tJson::INTEREST_RATE_PERCENT_PM].PHP_EOL;
echo " - discont factor: ".$replyData[tJson::DISCONT_FACTOR].PHP_EOL;
echo " - monthly payment: ".$replyData[tJson::MONTHLY_PAYMENT].PHP_EOL;
echo " - total paid: ".$replyData[tJson::TOTAL_PAID].PHP_EOL;

foreach ($replyData[tJson::SCENARIO] as $index => $oneMonth)
{
  echo PHP_EOL;

  echo " - month number: ".($index + 1).PHP_EOL;
  echo "   - payment: ".$oneMonth[tJson::PAYMENT].PHP_EOL;
  echo "   - interest: ".$oneMonth[tJson::INTEREST].PHP_EOL;
  echo "   - amortization: ".$oneMonth[tJson::AMORTIZATION].PHP_EOL;
  echo "   - account balance: ".$oneMonth[tJson::ACCOUNT_BALANCE].PHP_EOL;
}

?>
