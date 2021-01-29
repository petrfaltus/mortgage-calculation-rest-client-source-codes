using System;
using System.Net;
using System.Text;

namespace MortgageCalcRestClient
{
    public class Program
    {
        private static readonly string URL_ADDRESS = "http://api.petrfaltus.net/mortgage_law/json/1.0";
        private static readonly string WEB_REQUEST_FAILED = "The web request to the REST service failed";
        private static readonly Encoding encoding = Encoding.UTF8;
        private static readonly string USER_AGENT = "Petr Faltus C# Mortgage calculation REST client";

        public static void Main(string[] args)
        {
            WebClient client = new WebClient();
            client.Encoding = encoding;
            client.Headers.Add("user-agent", USER_AGENT);

            string restRequestJsonCalculation = "{ \"method_number\":1, \"loan_amount\":350000.0, \"loan_term_months\":12, \"interest_rate_percent_pa\":9.00 }";

            string restReplyJsonCalculation;
            try
            {
                restReplyJsonCalculation = client.UploadString(URL_ADDRESS, restRequestJsonCalculation);
            }
            catch (Exception)
            {
                Console.WriteLine(" - " + WEB_REQUEST_FAILED);
                return;
            }

            Console.WriteLine(restReplyJsonCalculation);

        }
    }
}
