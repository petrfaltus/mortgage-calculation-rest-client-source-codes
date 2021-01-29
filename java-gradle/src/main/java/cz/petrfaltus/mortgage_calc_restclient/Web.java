package cz.petrfaltus.mortgage_calc_restclient;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;

import java.net.HttpURLConnection;
import java.net.URL;

public class Web {
    public static String request(String requestBody) {
        String output = Const.EMPTY_STRING; // the default output value
        HttpURLConnection connection = null;

        try {
            URL url = new URL(Const.URL_ADDRESS);

            connection = (HttpURLConnection) url.openConnection();
            connection.setUseCaches(false);
            connection.setDoOutput(true);
            connection.addRequestProperty("User-Agent", Const.USER_AGENT);
            connection.setRequestMethod("POST");

            OutputStream os = connection.getOutputStream();
            byte[] requestBodyBytes = requestBody.getBytes(Const.CHARSET);
            os.write(requestBodyBytes);

            InputStream is = connection.getInputStream();
            InputStreamReader isr = new InputStreamReader(is, Const.CHARSET);
            BufferedReader br = new BufferedReader(isr);

            String line;
            while ((line = br.readLine()) != null) {
                output += line ;
                output += System.lineSeparator();
            }

            br.close();
        } catch (Exception e) {
            output = null; // indicates the web request failed
        } finally {
            if (connection != null) {
                connection.disconnect();
            }
        }

        return output;
    }
}
