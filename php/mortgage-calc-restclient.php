<?php

// constants
const PATH_TO_CLASSES = ".class";

// user classes autoloading
spl_autoload_register(function($class_name)
{
  $class_source_file_path = PATH_TO_CLASSES."/".$class_name.".php";
  require_once $class_source_file_path;
});

$requestJson = "{ \"method_number\":1, \"loan_amount\":350000.0, \"loan_term_months\":12, \"interest_rate_percent_pa\":9.00 }";

$replyJson = tWeb::request($requestJson);
if ($replyJson === null)
{
  echo " - error sending POST web query".PHP_EOL;
  return;
}

echo $replyJson.PHP_EOL;

?>
