package cz.petrfaltus.mortgage_calc_restclient;

import static java.lang.System.out;

public class Program {

    public static void main(String[] args) {
        double loan_amount = 350000.0;
        int loan_term_months = 12;
        double interest_rate_percent_pa = 9.00;

        String requestJsonQuery = Json.codeCalculation(loan_amount, loan_term_months, interest_rate_percent_pa);
        if (requestJsonQuery == null) {
            out.println(" - error coding of request JSON");
            return;
        }
        String replyJsonQuery = Web.request(requestJsonQuery);
        if (replyJsonQuery == null) {
            out.println(" - error sending POST web query");
            return;
        }
        CalcData replyData = Json.decodeResultCalculation(replyJsonQuery);
        if (replyData == null) {
            String errorString = Json.getLastErrorString();

            if (errorString != null) {
                out.println(" - replied error '" + errorString + "'");
            } else {
                out.println(" - error decoding of reply JSON");
            }

            return;
        }

        out.println(" - interest rate % p.m.: " + replyData.interest_rate_percent_pm);
        out.println(" - discont factor: " + replyData.discont_factor);
        out.println(" - monthly payment: " + replyData.monthly_payment);
        out.println(" - total paid: " + replyData.total_paid);

        int monthNumber = 1;
        for (CalcOneMonth replyOneMonth: replyData.scenario) {
            out.println();

            out.println(" - month number: " + monthNumber);
            out.println("   - payment: " + replyOneMonth.payment);
            out.println("   - interest: " + replyOneMonth.interest);
            out.println("   - amortization: " + replyOneMonth.amortization);
            out.println("   - account balance: " + replyOneMonth.account_balance);

            monthNumber++;
        }
    }

}
