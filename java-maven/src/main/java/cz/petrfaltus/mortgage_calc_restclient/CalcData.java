package cz.petrfaltus.mortgage_calc_restclient;

import java.util.List;

public class CalcData {
    public double interest_rate_percent_pm;
    public double discont_factor;
    public double monthly_payment;
    public double total_paid;
    public List<CalcOneMonth> scenario;
}
