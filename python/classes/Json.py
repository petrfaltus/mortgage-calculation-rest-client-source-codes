import json

class Json:
    METHOD_NUMBER = "method_number"
    LOAN_AMOUNT = "loan_amount"
    LOAN_TERM_MONTHS = "loan_term_months"
    INTEREST_RATE_PERCENT_PA = "interest_rate_percent_pa"

    ERROR_CODE = "error_code"
    ERROR_STRING = "error_string"
    DATA = "data"

    INTEREST_RATE_PERCENT_PM = "interest_rate_percent_pm"
    DISCONT_FACTOR = "discont_factor"
    MONTHLY_PAYMENT = "monthly_payment"
    TOTAL_PAID = "total_paid"
    SCENARIO = "scenario"

    PAYMENT = "payment"
    INTEREST = "interest"
    AMORTIZATION = "amortization"
    ACCOUNT_BALANCE = "account_balance"

    METHOD_CALCULATION_NUMBER = 1

    lastErrorString = None

    @staticmethod
    def codeCalculation(loan_amount, loan_term_months, interest_rate_percent_pa):
        output = {Json.METHOD_NUMBER: Json.METHOD_CALCULATION_NUMBER,
                  Json.LOAN_AMOUNT: loan_amount,
                  Json.LOAN_TERM_MONTHS: loan_term_months,
                  Json.INTEREST_RATE_PERCENT_PA: interest_rate_percent_pa}
        outputJson = json.dumps(output)

        return outputJson

    @staticmethod
    def decodeResult(inputJson):
        retData = None
        Json.lastErrorString = None

        try:
            input = json.loads(inputJson)

            if input[Json.ERROR_CODE] == 0:
                retData = input[Json.DATA]
            else:
                # error reported by the service
                Json.lastErrorString = input[Json.ERROR_STRING]
        except:
            # invalid or corrupted JSON
            retData = None

        return retData

    @staticmethod
    def getLastErrorString():
        return Json.lastErrorString
