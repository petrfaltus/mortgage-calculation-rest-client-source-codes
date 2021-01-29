
namespace MortgageCalcRestClient
{
    public class RestReply
    {
        public int error_code { get; set; }
        public string error_string { get; set; }

        public CalcData data { get; set; }
    }
}
