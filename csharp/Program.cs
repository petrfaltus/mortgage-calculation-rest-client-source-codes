using System;
using System.Net;
using System.Text;

using Newtonsoft.Json;

namespace MortgageCalcRestClient
{
    public class Program
    {
        private static readonly string URL_ADDRESS = "http://api.petrfaltus.net/mortgage_law/json/1.0";
        private static readonly Encoding encoding = Encoding.UTF8;
        private static readonly string USER_AGENT = "Petr Faltus C# Mortgage calculation REST client";

        private static readonly string MESSAGE_ERROR_CONTACTING_SERVICE = "error contacting the REST service";
        private static readonly string MESSAGE_RECEIVED_ERROR = "received error";

        public static void Main(string[] args)
        {
            WebClient client = new WebClient();
            client.Encoding = encoding;
            client.Headers.Add("user-agent", USER_AGENT);

            RestRequest restRequest = new RestRequest();
            restRequest.loan_amount = 350000.0;
            restRequest.loan_term_months = 12;
            restRequest.interest_rate_percent_pa = 9.00;

            string restRequestJsonCalculation = JsonConvert.SerializeObject(restRequest);

            string restReplyJsonCalculation;
            try
            {
                restReplyJsonCalculation = client.UploadString(URL_ADDRESS, restRequestJsonCalculation);
            }
            catch (Exception)
            {
                Console.WriteLine(" - " + MESSAGE_ERROR_CONTACTING_SERVICE);
                return;
            }

            RestReply restReply = JsonConvert.DeserializeObject<RestReply>(restReplyJsonCalculation);

            if (restReply.error_code != 0)
            {
                Console.WriteLine(" - " + MESSAGE_RECEIVED_ERROR + ": " + restReply.error_string);
                return;
            }

            CalcData replyData = restReply.data;
            Console.WriteLine(" - interest rate % p.m.: " + replyData.interest_rate_percent_pm);
            Console.WriteLine(" - discont factor: " + replyData.discont_factor);
            Console.WriteLine(" - monthly payment: " + replyData.monthly_payment);
            Console.WriteLine(" - total paid: " + replyData.total_paid);

            int monthNumber = 1;
            foreach (CalcOneMonth replyOneMonth in replyData.scenario)
            {
                Console.WriteLine();

                Console.WriteLine(" - month number: " + monthNumber);
                Console.WriteLine("   - payment: " + replyOneMonth.payment);
                Console.WriteLine("   - interest: " + replyOneMonth.interest);
                Console.WriteLine("   - amortization: " + replyOneMonth.amortization);
                Console.WriteLine("   - account balance: " + replyOneMonth.account_balance);

                monthNumber++;
            }
        }
    }
}
