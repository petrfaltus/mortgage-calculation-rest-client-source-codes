# Mortgage calculation REST API
Application interface description
(c) Petr Faltus 2021

---
## Mortgage calculation request
Returns one mortgage calculation for the loan amount, the loan term and the interest rate from the API.

-   **URL**
    <http://api.petrfaltus.net/mortgage_law/json/1.0>

-   **Method**
    `POST`

-   **URL Params**
    None

-   **Form Data Params**
    None

-   **Raw Data Params**
    -   **Required**
        | Variable                   | Value                | Type                      |
        | --------                   | -----                | ----                      |
        | `method_number`            | 1                    | integer                   |
        | `loan_amount`              | loan amount          | decimal number or integer |
        | `loan_term_months`         | loan term months     | integer                   |
        | `interest_rate_percent_pa` | interest rate % p.a. | decimal number or integer |

    -   **Optional**
        None

    -   **Example JSON Request**
        ```javascript
          {
            "method_number" : 1,
            "loan_amount" : 350000.0,
            "loan_term_months" : 12,
            "interest_rate_percent_pa" : 9.00
          }
        ```

-   **Success Response**
    -   **Code**
        200 OK

    -   **Content**
        | Variable       | Value          | Type    |
        | --------       | -----          | ----    |
        | `error_code`   | 0              | integer |
        | `error_string` | "ok"           | string  |
        | `data`         | *substructure* | *Data*  |

    -   **Data Content**
        | Variable                   | Value                | Type                      |
        | --------                   | -----                | ----                      |
        | `interest_rate_percent_pm` | interest rate % p.m. | decimal number or integer |
        | `discont_factor`           | discont factor       | decimal number            |
        | `monthly_payment`          | monthly payment      | decimal number or integer |
        | `total_paid`               | total paid           | decimal number or integer |
        | `scenario`                 | *substructure*       | array of *Month*          |

    -   **Month Content**
        | Variable          | Value                        | Type                      |
        | --------          | -----                        | ----                      |
        | `payment`         | payment for the month        | decimal number or integer |
        | `interest`        | interest part of payment     | decimal number or integer |
        | `amortization`    | amortization part of payment | decimal number or integer |
        | `account_balance` | account balance              | decimal number or integer |

    -   **Example JSON Reply**
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

-   **Error Response**
    -   **Code**
        200 OK

    -   **Content**
        | Variable       | Value       | Type    |
        | --------       | -----       | ----    |
        | `error_code`   | number <> 0 | integer |
        | `error_string` | message     | string  |

---
## Communication diagnostics query
Returns detected communication properties for the REST request.

-   **URL**
    <http://api.petrfaltus.net/mortgage_law/json/1.0>

-   **Method**
    `POST`

-   **URL Params**
    None

-   **Form Data Params**
    None

-   **Raw Data Params**
    -   **Required**
        | Variable        | Value | Type    |
        | --------        | ----- | ----    |
        | `method_number` | 0     | integer |

    -   **Optional**
        None

    -   **Example JSON Request**
        ```javascript
        {
          "method_number" : 0
        }
        ```

-   **Success Response**
    -   **Code**
        200 OK

    -   **Content**
        | Variable         | Value                     | Type    |
        | --------         | -----                     | ----    |
        | `error_code`     | 0                         | integer |
        | `error_string`   | "ok"                      | string  |
        | `request_method` | request method            | string  |
        | `proxy_ip`       | IP of the proxy           | string  |
        | `proxy_software` | proxy software            | string  |
        | `client_ip`      | IP of the client          | string  |
        | `user_agent`     | user agent header line    | string  |
        | `user_language`  | user language header line | string  |

    -   **Example JSON Reply**
        ```javascript
        {
          "error_code" : 0,
          "error_string" : "ok",
          "request_method" : "POST",
          "proxy_ip" : "",
          "proxy_software" : "",
          "client_ip" : "85.70.117.166",
          "user_agent" : "Petr Faltus Java Mortgage calculation REST client",
          "user_language" : ""
        }
        ```

-   **Error Response**
    -   **Code**
        200 OK

    -   **Content**
        | Variable       | Value       | Type    |
        | --------       | -----       | ----    |
        | `error_code`   | number <> 0 | integer |
        | `error_string` | message     | string  |
