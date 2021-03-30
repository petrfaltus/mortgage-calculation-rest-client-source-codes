from classes.Web import Web

MESSAGE_ERROR_CONTACTING_SERVICE = "error contacting the REST service"

requestJsonCalculation = "{ \"method_number\" : 1, \"loan_amount\" : 350000.0, \"loan_term_months\" : 12, \"interest_rate_percent_pa\" : 9.00 }"

try:
    replyJsonCalculation = Web.request(requestJsonCalculation)
except:
    print(" - " + MESSAGE_ERROR_CONTACTING_SERVICE)
    exit()

print(replyJsonCalculation)
