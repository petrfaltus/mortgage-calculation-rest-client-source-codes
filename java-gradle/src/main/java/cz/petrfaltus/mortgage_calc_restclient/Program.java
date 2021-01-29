package cz.petrfaltus.mortgage_calc_restclient;

import static java.lang.System.out;

public class Program {

    public static void main(String[] args) {
        String requestJsonQuery = "{ \"method_number\":1, \"loan_amount\":350000.0, \"loan_term_months\":12, \"interest_rate_percent_pa\":9.00 }";
        String replyJsonQuery = Web.request(requestJsonQuery);
        if (replyJsonQuery == null) {
            out.println(" - error sending POST web query");
            return;
        }
        out.println(replyJsonQuery);
    }

}
