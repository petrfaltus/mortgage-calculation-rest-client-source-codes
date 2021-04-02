from classes.Web import Web
from classes.Json import Json

MESSAGE_ERROR_CONTACTING_SERVICE = "error contacting the REST service"
MESSAGE_ERROR_DECODING_JSON = "error decoding the reply JSON"
MESSAGE_RECEIVED_ERROR = "received error"

loan_amount = 350000.0
loan_term_months = 12
interest_rate_percent_pa = 9.00

requestJsonCalculation = Json.codeCalculation(loan_amount, loan_term_months, interest_rate_percent_pa)

try:
    replyJsonCalculation = Web.request(requestJsonCalculation)
except:
    print(" - " + MESSAGE_ERROR_CONTACTING_SERVICE)
    exit()

replyData = Json.decodeResult(replyJsonCalculation)
if replyData == None:
    errorString = Json.getLastErrorString()

    if errorString != None:
        print(" - " + MESSAGE_RECEIVED_ERROR + ": " + errorString)
    else:
        print(" - " + MESSAGE_ERROR_DECODING_JSON)

    exit()

print(" - interest rate % p.m.: " + str(replyData[Json.INTEREST_RATE_PERCENT_PM]))
print(" - discont factor: " + str(replyData[Json.DISCONT_FACTOR]))
print(" - monthly payment: " + str(replyData[Json.MONTHLY_PAYMENT]))
print(" - total paid: " + str(replyData[Json.TOTAL_PAID]))

index = 1
for oneMonth in replyData[Json.SCENARIO]:
    print()

    print(" - month number: " + str(index))
    print("   - payment: " + str(oneMonth[Json.PAYMENT]))
    print("   - interest: " + str(oneMonth[Json.INTEREST]))
    print("   - amortization: " + str(oneMonth[Json.AMORTIZATION]))
    print("   - account balance: " + str(oneMonth[Json.ACCOUNT_BALANCE]))

    index = index + 1
