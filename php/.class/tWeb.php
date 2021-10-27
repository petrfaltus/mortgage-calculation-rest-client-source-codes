<?php

class tWeb
{
  const URL_ADDRESS = "http://api.petrfaltus.net/mortgage_law/json/1.0";
  const USER_AGENT = "Petr Faltus PHP Mortgage calculation REST client";

  //----------------------------------------------------------------------------
  public static function request($query)
  {
    $crequest = curl_init(self::URL_ADDRESS);
    if ($crequest === false)
    {
      return null;
    }

    curl_setopt($crequest, CURLOPT_POST, true);
    curl_setopt($crequest, CURLOPT_POSTFIELDS, $query);
    curl_setopt($crequest, CURLOPT_HEADER, false);
    curl_setopt($crequest, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($crequest, CURLOPT_USERAGENT, self::USER_AGENT);
    curl_setopt($crequest, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($crequest);
    curl_close($crequest);

    if ($output === false)
    {
      return null;
    }

    return $output;
  }
  //----------------------------------------------------------------------------
}

?>
