package com.justintime.androidgcm;

import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by DEBANGIS on 7/16/2016.
 */
public class CreateUser extends AppCompatActivity{

    EditText txtUserName, txtPassword, txtConfirmPassword;
    String userName, password, confirmPassword;

    private static String url = "http://104.199.190.90/cimb.com.my/register.php?funcName=RegisterUser";
    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.userregisteration);

        Button btnSubmit = (Button) findViewById(R.id.buttonRecSubmit);
        Button btnCancel = (Button) findViewById(R.id.buttonRecCancel);
        Button btnLoginReq = (Button)findViewById(R.id.buttonRecLogin);


        DisplayMetrics screenMetrics = new DisplayMetrics();
        getWindowManager().getDefaultDisplay().getMetrics(screenMetrics);
        int heightPixels = screenMetrics.heightPixels;
        int widthPixels = screenMetrics.widthPixels;


        ViewGroup.LayoutParams paramsPayButton = btnSubmit.getLayoutParams();
        paramsPayButton.width = (widthPixels / 2) - 1;
        btnSubmit.setLayoutParams(paramsPayButton);

        ViewGroup.LayoutParams paramsCloseButton = btnCancel.getLayoutParams();
        paramsCloseButton.width = (widthPixels / 2) - 1;
        btnCancel.setLayoutParams(paramsCloseButton);
        //btnPay.setLayoutParams(((LinearLayout.LayoutParams.MATCH_PARENT)/2),((LinearLayout.LayoutParams.WRAP_CONTENT)));


        txtUserName = (EditText)findViewById(R.id.editTextRecUsername) ;
        txtPassword = (EditText)findViewById(R.id.editTextRecPassword);
        txtConfirmPassword = (EditText)findViewById(R.id.editTextRecConfirmPassword);


        btnSubmit.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){
                userName = txtUserName.getText().toString();
                password = txtPassword.getText().toString();
                confirmPassword = txtConfirmPassword.getText().toString();

                if((userName.equals(" ")) || (userName.equals(""))){
                    Toast.makeText(getApplicationContext(),"Username Field Empty!!!", Toast.LENGTH_LONG).show();
                }else{
                    if(password.equals("")){
                        Toast.makeText(getApplicationContext(),"Password Field Empty!!!", Toast.LENGTH_LONG).show();
                    }else{
                        if(confirmPassword.equals("")){
                            Toast.makeText(getApplicationContext(),"Confirm Password Field Empty!!!", Toast.LENGTH_LONG).show();
                        }else{

                            if(password.equals(confirmPassword)){ //The two password match each other.

                                String urlLink = url +"&username="+ userName+"&password="+password;
                                if(CheckNetClass.checknetwork(getApplicationContext())){
                                    RegisterUserAtServer(urlLink);
                                }else{

                                    Toast.makeText(getApplicationContext(), "No Network Connectivity. Check Your Data and Try Again!!!", Toast.LENGTH_LONG).show();
                                }
                            }else{

                                Toast.makeText(getApplicationContext(),"Password Mismatch. Try Again!!!", Toast.LENGTH_LONG).show();
                            }
                        }
                    }
                }




            }
        });
        btnCancel.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){
                //Cancel Registration Process at user request by pressing cancel button
                Toast.makeText(getApplicationContext(), "Login Interface Starting...", Toast.LENGTH_LONG).show();

                Intent i = getBaseContext().getPackageManager()
                        .getLaunchIntentForPackage(getBaseContext().getPackageName() );

                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK );
                startActivity(i);
                //startActivity(new Intent("com.justintime.androidgcm.LOGIN"));
            }
        });

        btnLoginReq.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){

                //Cancel Registration Process at user request by pressing cancel button
                Toast.makeText(getApplicationContext(), "Login Interface Starting...", Toast.LENGTH_LONG).show();


                Intent i = getBaseContext().getPackageManager()
                        .getLaunchIntentForPackage(getBaseContext().getPackageName() );

                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK );
                startActivity(i);

               // startActivity(new Intent("com.justintime.androidgcm.LOGIN"));
            }
        });

    }


    private void RegisterUserAtServer(String urlSuffix){
        //String result = "";
        class RegisterUser extends AsyncTask<String, Void, String> {

            ProgressDialog loading;

            @Override
            protected void onPreExecute() {
                super.onPreExecute();
                loading = ProgressDialog.show(CreateUser.this, "Request being Processed. Please Wait...",null, true, true);
            }

            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);

                loading.dismiss();

                if(s.equals("1")){

                    //Successful Login
                    Toast.makeText(getApplicationContext(), "Successfully Registered!!!", Toast.LENGTH_LONG).show();


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


                }else if(s.equals("2")) {

                    Toast.makeText(getApplicationContext(),"Change Username and Try Again!!!", Toast.LENGTH_LONG).show();

                }else{
                    Toast.makeText(getApplicationContext(),"Unsuccessful Registration. Try Again!!!", Toast.LENGTH_LONG).show();
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

        RegisterUser ru = new RegisterUser();
        ru.execute(urlSuffix);

        // return result;
    }


}
