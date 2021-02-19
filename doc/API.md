# Mortgage calculation REST API
Application interface description
(c) Petr Faltus 2021

**Mortgage calculation request**
----
Returns one mortgage calculation for the loan amount, the loan term and the interest rate from the API.

* **URL**
  http://api.petrfaltus.net/mortgage_law/json/1.0

* **Method**
  `POST`

* **URL Params**
  None

* **Raw Data Params**
  * **Required**
    `method_number : 1`
    `loan_amount : [loan amount decimal number or integer]`
    `loan_term_months : [loan term months integer]`
    `interest_rate_percent_pa : [interest rate % p.a. decimal number or integer]`

  * **Optional**
    None

  * **Example JSON Request**
    ```javascript
    {
      "method_number" : 1,
      "loan_amount" : 350000.0,
      "loan_term_months" : 12,
      "interest_rate_percent_pa" : 9.00
    }
  ```

* **Success Response**
  * **Code** 200 OK
    **Content**
    ```javascript
    {
      "error_code" : 0,
      "error_string" : "ok",
      "data" : {
                 "interest_rate_percent_pm" : 0.75,
                 "discont_factor" : 0.9926,
                 "monthly_payment" : 30609,
                 "total_paid" : 367295.7,
                 "scenario" : [
                                {
                                  "payment" : 30609,
                                  "interest" : 2625,
                                  "amortization" : 27984,
                                  "account_balance" : -322016
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 2415.1,
                                  "amortization" : 28193.9,
                                  "account_balance" : -293822.1
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 2203.7,
                                  "amortization" : 28405.3,
                                  "account_balance" : -265416.8
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 1990.6,
                                  "amortization" : 28618.4,
                                  "account_balance" : -236798.4
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 1776,
                                  "amortization" : 28833,
                                  "account_balance" : -207965.4
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 1559.7,
                                  "amortization" : 29049.3,
                                  "account_balance" : -178916.1
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 1341.9,
                                  "amortization" : 29267.1,
                                  "account_balance" : -149649
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 1122.4,
                                  "amortization" : 29486.6,
                                  "account_balance" : -120162.4
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 901.2,
                                  "amortization" : 29707.8,
                                  "account_balance" : -90454.6
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 678.4,
                                  "amortization" : 29930.6,
                                  "account_balance" : -60524
                                },
                                {
                                  "payment" : 30609,
                                  "interest" : 453.9,
                                  "amortization" : 30155.1,
                                  "account_balance" : -30368.9
                                },
                                {
                                  "payment" : 30596.7,
                                  "interest" : 227.8,
                                  "amortization" : 30368.9,
                                  "account_balance" : 0
                                }
                              ]
               }
    }
    ```

* **Error Response**
  * **Code** 200 OK
    **Content**
    ```javascript
    {
      "error_code" : integer,
      "error_string" : "message"
    }
    ```
    *(`error_code` != 0)*
