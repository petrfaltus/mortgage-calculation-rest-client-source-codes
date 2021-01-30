package cz.petrfaltus.mortgage_calc_restclient;

import java.io.IOException;
import java.io.StringWriter;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;

import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

public class Json {
    private static final String METHOD_NUMBER = "method_number";

    private static final String LOAN_AMOUNT = "loan_amount";
    private static final String LOAN_TERM_MONTHS = "loan_term_months";
    private static final String INTEREST_RATE_PERCENT_PA = "interest_rate_percent_pa";

    private static final String ERROR_CODE = "error_code";
    private static final String ERROR_STRING = "error_string";
    private static final String DATA = "data";

    private static final String INTEREST_RATE_PERCENT_PM = "interest_rate_percent_pm";
    private static final String DISCONT_FACTOR = "discont_factor";
    private static final String MONTHLY_PAYMENT = "monthly_payment";
    private static final String TOTAL_PAID = "total_paid";
    private static final String SCENARIO = "scenario";

    private static final String PAYMENT = "payment";
    private static final String INTEREST = "interest";
    private static final String AMORTIZATION = "amortization";
    private static final String ACCOUNT_BALANCE = "account_balance";

    private static final long METHOD_CALCULATION_NUMBER = 1;

    private static String lastErrorString;

    private static String objToString(JSONObject obj) {
        String retString = Const.EMPTY_STRING;

        try {
            StringWriter out = new StringWriter();
            obj.writeJSONString(out);

            retString = out.toString();
        } catch (IOException ioex) {
            retString = null;
        }

        return retString;
    }

    public static String codeCalculation(double loan_amount, int loan_term_months, double interest_rate_percent_pa) {
        JSONObject obj = new JSONObject();
        obj.put(METHOD_NUMBER, METHOD_CALCULATION_NUMBER);
        obj.put(LOAN_AMOUNT, loan_amount);
        obj.put(LOAN_TERM_MONTHS, loan_term_months);
        obj.put(INTEREST_RATE_PERCENT_PA, interest_rate_percent_pa);

        String retString = objToString(obj);

        return retString;
    }

    private static double castToDouble(Object obj) {
        if (obj instanceof Long)
        {
            return (double)(long) obj;
        }

        return (double) obj;
    }

    public static CalcData decodeResultCalculation(String resultJson) {
        CalcData retData = null;
        lastErrorString = null;

        try {
            JSONParser parser = new JSONParser();

            JSONObject jsonObject = (JSONObject) parser.parse(resultJson);
            long errorCode = (long) jsonObject.get(ERROR_CODE);

            if (errorCode == 0) {
                JSONObject data = (JSONObject) jsonObject.get(DATA);

                retData = new CalcData();
                Object obj;

                obj = data.get(INTEREST_RATE_PERCENT_PM);
                retData.interest_rate_percent_pm = castToDouble(obj);

                retData.discont_factor = (double) data.get(DISCONT_FACTOR);

                obj = data.get(MONTHLY_PAYMENT);
                retData.monthly_payment = castToDouble(obj);

                obj = data.get(TOTAL_PAID);
                retData.total_paid = castToDouble(obj);

                JSONArray dataScenario = (JSONArray) data.get(SCENARIO);

                retData.scenario = new ArrayList<CalcOneMonth>();

                Iterator<JSONObject> dsi = dataScenario.iterator();
                while (dsi.hasNext()) {
                    JSONObject jsonObjectNext = dsi.next();

                    CalcOneMonth calcOneMonth = new CalcOneMonth();

                    obj = jsonObjectNext.get(PAYMENT);
                    calcOneMonth.payment = castToDouble(obj);

                    obj = jsonObjectNext.get(INTEREST);
                    calcOneMonth.interest = castToDouble(obj);

                    obj = jsonObjectNext.get(AMORTIZATION);
                    calcOneMonth.amortization = castToDouble(obj);

                    obj = jsonObjectNext.get(ACCOUNT_BALANCE);
                    calcOneMonth.account_balance = castToDouble(obj);

                    retData.scenario.add(calcOneMonth);
                }
            } else {
                lastErrorString = (String) jsonObject.get(ERROR_STRING);
            }
        } catch (ParseException pe) {
            retData = null;
        } catch (NullPointerException npe) {
            retData = null;
        }

        return retData;
    }

    public static String getLastErrorString() {
        return lastErrorString;
    }

}
