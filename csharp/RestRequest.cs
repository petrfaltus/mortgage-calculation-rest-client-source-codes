
namespace MortgageCalcRestClient
{
    public class RestRequest
    {
        public int method_number { get; set; }

        public double loan_amount { get; set; }
        public int loan_term_months { get; set; }
        public double interest_rate_percent_pa { get; set; }

        public RestRequest()
        {
            method_number = 1;
        }
    }
}
