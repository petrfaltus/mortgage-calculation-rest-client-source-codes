<?php

class tJson
{
  const METHOD_NUMBER = "method_number";
  const LOAN_AMOUNT = "loan_amount";
  const LOAN_TERM_MONTHS = "loan_term_months";
  const INTEREST_RATE_PERCENT_PA = "interest_rate_percent_pa";

  const ERROR_CODE = "error_code";
  const ERROR_STRING = "error_string";
  const DATA = "data";

  const INTEREST_RATE_PERCENT_PM = "interest_rate_percent_pm";
  const DISCONT_FACTOR = "discont_factor";
  const MONTHLY_PAYMENT = "monthly_payment";
  const TOTAL_PAID = "total_paid";
  const SCENARIO = "scenario";

  const PAYMENT = "payment";
  const INTEREST = "interest";
  const AMORTIZATION = "amortization";
  const ACCOUNT_BALANCE = "account_balance";

  const METHOD_CALCULATION_NUMBER = 1;

  protected static $lastErrorString;

  //----------------------------------------------------------------------------
  public static function codeCalculation(&$loan_amount, &$loan_term_months, &$interest_rate_percent_pa)
  {
    $output[self::METHOD_NUMBER] = self::METHOD_CALCULATION_NUMBER;
    $output[self::LOAN_AMOUNT] = $loan_amount;
    $output[self::LOAN_TERM_MONTHS] = $loan_term_months;
    $output[self::INTEREST_RATE_PERCENT_PA] = $interest_rate_percent_pa;

    $outputJson = json_encode($output);

    return $outputJson;
  }
  //----------------------------------------------------------------------------
  public static function decodeResultCalculation(&$inputJson)
  {
    $retData = null;
    self::$lastErrorString = null;

    $input = json_decode($inputJson, true);

    if ((!isset($input[self::ERROR_CODE])) or (!isset($input[self::ERROR_STRING])))
    {
      // invalid JSON
      $retData = null;
    }
    elseif ($input[self::ERROR_CODE] !== 0)
    {
      // error reported by the service
      $retData = null;
      self::$lastErrorString = $input[self::ERROR_STRING];
    }
    elseif ((!isset($input[self::DATA])) or (!is_array($input[self::DATA])))
    {
      // corrupted JSON
      $retData = null;
    }
    else
    {
      $retData = $input[self::DATA];
    }

    return $retData;
  }
  //----------------------------------------------------------------------------

  //----------------------------------------------------------------------------
  public static function getLastErrorString()
  {
    return self::$lastErrorString;
  }
  //----------------------------------------------------------------------------
}

?>
