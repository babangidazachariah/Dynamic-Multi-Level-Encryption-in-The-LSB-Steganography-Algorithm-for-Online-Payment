package com.justintime.androidgcm;

import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by DEBANGIS on 7/15/2016.
 */
public class Login  extends AppCompatActivity {
    // Log tag
    private static final String TAG = DisplayList.class.getSimpleName();

    // Movies json url
    private static final String url = "http://104.199.190.90/cimb.com.my/register.php?funcName=Login";//http://api.androidhive.info/json/movies.json";
    private ProgressDialog pDialog;
    Button btnLogin,btnRegisterUserAccount;
    EditText txtUsername, txtPassword;
    TextView txtError;

    //Sub variables
   // String supportUrl = "http://10.0.2.2/cimb.com.my/merchants/getMerchantList.php";

    String username ="";
    String password ="";

    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.userlogin);


        //Change Title of Login interface
        this.setTitle("Login");
        txtUsername =(EditText)findViewById(R.id.editTextUsername);
        txtPassword = (EditText)findViewById(R.id.editTextPassword);

        txtError = (TextView)findViewById(R.id.textViewError) ;

        btnLogin = (Button) findViewById(R.id.buttonLogin);
        btnRegisterUserAccount = (Button)findViewById(R.id.registerAccount);


        ///When user clicks login button
        btnLogin.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){


                username = txtUsername.getText().toString();
                password = txtPassword.getText().toString();

                if(username.equals(" ") || username.equals("")){
                    //Display a Prompt
                    Toast.makeText(getApplicationContext(), "Username Field Empty!!!", Toast.LENGTH_LONG).show();
                    txtUsername.requestFocus();
                }else{

                    if(password.equals(" ") || password.equals("")){

                        Toast.makeText(getApplicationContext(), "Password Field Empty!!!", Toast.LENGTH_LONG).show();
                        txtPassword.requestFocus();
                    }else{

                        String urlLink = url + "&username=" +username + "&password="+password;

                        if(CheckNetClass.checknetwork(getApplicationContext())) {
                            ValidatWithServer(urlLink);
                        }else{

                            Toast.makeText(getApplicationContext(), "No Network Connectivity. Check Your Data and Try Again!!!", Toast.LENGTH_LONG).show();
                        }
                    }
                }
            }
        });
        btnRegisterUserAccount.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){

                Toast.makeText(getApplicationContext(), "Registration Interface Starting...", Toast.LENGTH_LONG).show();
                startActivity(new Intent("com.justintime.androidgcm.CREATEUSER"));
            }
        });
    }

    private void ValidatWithServer(String urlSuffix){
        //String result = "";
        class Validate extends AsyncTask<String, Void, String> {

            ProgressDialog loading;

            @Override
            protected void onPreExecute() {
                super.onPreExecute();
                loading = ProgressDialog.show(Login.this, "Credentials Authentication. Please Wait...",null, true, true);
            }

            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);

                loading.dismiss();

                if(s.equals("1")){

                    //Successful Login
                    //Set Constant.loggedIn to true for validations
                    Constants.loggedIn = true;
                    Toast.makeText(getApplicationContext(), "Successfully Authenticated!!!", Toast.LENGTH_LONG).show();


                    //Check if this is the first time user is login in, or that the device has not being registered
                    //Getting shared preferences
                    SharedPreferences sharedPreferences = getSharedPreferences(Constants.SHARED_PREF, MODE_PRIVATE);

                    String deviceID = sharedPreferences.getString(Constants.UNIQUE_ID,"").toString();
                    if(deviceID.equals("")){
                        //Device is not registered. So User Register Card details to allow to successfully navigate the application

                        startActivity(new Intent("com.justintime.androidgcm.MAINACTIVITY"));

                    }else{
                        startActivity(new Intent("com.justintime.androidgcm.ANIMATIONCLASS"));
                    }



                }else {
                    Toast.makeText(getApplicationContext(),"Wrong Login Credentials", Toast.LENGTH_LONG).show();
                }
            }

            @Override
            protected String doInBackground(String... params) {
                String s = params[0];
                BufferedReader bufferedReader = null;
                try {
                    Log.w("GetViewList", "This Prepares the URL" + s);
                    java.net.URL url = new URL(s);// URLEncoder.encode(s,"UTF-8"));
                    Log.w("GetViewList", "This Before Execution of Http"+ url.toString());
                    HttpURLConnection con = (HttpURLConnection) url.openConnection();

                    Log.w("GetViewList", "This After Execution of Http");
                    bufferedReader = new BufferedReader(new InputStreamReader(con.getInputStream()));

                    Log.w("GetViewList", "This After Buffering");

                    String result = "";

                    result = bufferedReader.readLine();

                    Log.w("RegisterWithServer", "Reading result from buffer");
                    return result;
                }catch(Exception e){
                    return null;
                }
            }
        }

        Validate ru = new Validate();
        ru.execute(urlSuffix);

        // return result;
    }
}
