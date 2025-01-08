package com.justintime.androidgcm;

import android.app.ProgressDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.content.LocalBroadcastManager;
import android.support.v7.app.AppCompatActivity;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;


//this is our main activity
public class MainActivity extends AppCompatActivity {


    //Create Variables
    private String generatedID,cardNumber, expiryMonth,expiryYear,cardCVC,cardHolderName,cardPin, cardType;

    String serverRegResponse ="";
    //Create Views variables
    Button buttonSubmit, buttonCancel;
    EditText editTextCardNumber, editTextExpiryMonth, editTextExpiryYear, editTextCVC, editTextCardHolderName, editTextPin;
    Spinner spinnerCardType;
    private BroadcastReceiver mRegistrationBroadcastReceiver;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //Validate that user has successfully loggedIn, otherwise refer back to Login Class.
        if(!Constants.loggedIn){

            Toast.makeText(getApplicationContext(), "Login Interface Starting...", Toast.LENGTH_LONG).show();
            Intent i = getBaseContext().getPackageManager()
                    .getLaunchIntentForPackage(getBaseContext().getPackageName() );

            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK );
            startActivity(i);
        }

        DisplayMetrics screenMetrics = new DisplayMetrics();
        getWindowManager().getDefaultDisplay().getMetrics(screenMetrics);
        int  heightPixels = screenMetrics.heightPixels;
        int widthPixels = screenMetrics.widthPixels;


        //Initializing our broadcast receiver
        mRegistrationBroadcastReceiver = new BroadcastReceiver() {

            //When the broadcast received
            //We are sending the broadcast from GCMRegistrationIntentService

            @Override
            public void onReceive(Context context, Intent intent) {
                //If the broadcast has received with success
                //that means device is registered successfully
                if(intent.getAction().equals(GCMRegistrationIntentService.REGISTRATION_SUCCESS)){


                    Log.w("ReceivedBroadcastHere", "Here Executes:");
                    //Get other fields of data expected of user
                    editTextCardNumber =(EditText)findViewById(R.id.editTextCardNumber);
                    editTextExpiryMonth =(EditText)findViewById(R.id.editTextExpiryMonth);
                    editTextExpiryYear=(EditText)findViewById(R.id.editTextExpiryYear);
                    editTextCVC =(EditText)findViewById(R.id.editTextCVC);
                    editTextPin=(EditText)findViewById(R.id.editTextPin);
                    editTextCardHolderName=(EditText)findViewById(R.id.editTextCardHolderName);
                    spinnerCardType =  (Spinner) findViewById(R.id.spinnerCardType);


                    //Retrieve supplied values supplied by the user
                    cardNumber = editTextCardNumber.getText().toString();
                    expiryMonth= editTextExpiryMonth.getText().toString();
                    expiryYear=editTextExpiryYear.getText().toString();
                    cardCVC= editTextCVC.getText().toString();
                    cardHolderName=editTextCardHolderName.getText().toString();
                    cardPin = editTextPin.getText().toString();
                    cardType = spinnerCardType.getSelectedItem().toString();
                    //replace empty spaces of name with +
                    cardHolderName =cardHolderName.replace(" ", "**");
                    //Getting the registration token from the intent
                    generatedID = intent.getStringExtra("token");

                    //Displaying the token as toast
                    Toast.makeText(getApplicationContext(), "Device Configured Successfully!!!", Toast.LENGTH_LONG).show();

                    //Register with the server (wamp: localhost) "uniqueID="+generatedID+"&cardNumber="+cardNumber+"&expiryMonth="+expiryMonth+"&expiryYear="+expiryYear+"&cardCVC="+cardCVC+"&cardPin="+cardPin+"&cardHolderName="+ cardHolderName;
                    String urlParams = generatedID+"^^"+cardNumber+"^^"+expiryMonth+"^^"+expiryYear+"^^"+cardCVC+"^^"+cardPin+"^^"+ cardHolderName+"^^"+ cardType;
                    Log.w("ParametersPassed",urlParams);
                    serverRegResponse = RegisterDeviceAtServer(urlParams);

                    /*
                    boolean status = false;
                    while(!status){
                        Log.w("STATUS","Here"+serverRegResponse +" Ah");
                        if(serverRegResponse != ""){
                            status = true;
                        }
                    }
                   // */

                    //if the intent is not with success then displaying error messages
                } else if(intent.getAction().equals(GCMRegistrationIntentService.REGISTRATION_ERROR)){
                    Toast.makeText(getApplicationContext(), "Error While Configuring Device! Try Again!!!", Toast.LENGTH_LONG).show();
                } else {
                    Toast.makeText(getApplicationContext(), "Error occurred", Toast.LENGTH_LONG).show();
                }
            }
        };

        buttonSubmit = (Button) findViewById(R.id.buttonSubmit);


        buttonCancel = (Button) findViewById(R.id.buttonCancel);


        buttonCancel.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){
                Constants.loggedIn = false;
                Toast.makeText(getApplicationContext(), "Login Interface Starting...", Toast.LENGTH_LONG).show();
                Intent i = getBaseContext().getPackageManager()
                        .getLaunchIntentForPackage(getBaseContext().getPackageName() );

                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK );
                startActivity(i);
            }

            });
        buttonSubmit.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){

                Log.w("ButtonClickdToSubmit", "Before Checking for registration:");
                //if the device is not already registered
                if (!isRegistered()) {
                    //registering the device
                    GenerateUniqieDeviceID();
                } else {

                    Log.w("RegisteredAlready", "Device was found to have been registered:");
                    //Getting shared preferences
                    SharedPreferences sharedPreferences = getSharedPreferences(Constants.SHARED_PREF, MODE_PRIVATE);

                    //if the device is already registered
                    //displaying a toast
                    Toast.makeText(MainActivity.this, "Device is Already registered..."+ sharedPreferences.getString(Constants.UNIQUE_ID,"De Bangis").toString(), Toast.LENGTH_SHORT).show();
                }
            }
        });

    }

    //Registering receiver on activity resume
    @Override
    protected void onResume() {
        super.onResume();
        Log.w("MainActivity", "onResume");
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver,
                new IntentFilter(GCMRegistrationIntentService.REGISTRATION_SUCCESS));
        LocalBroadcastManager.getInstance(this).registerReceiver(mRegistrationBroadcastReceiver,
                new IntentFilter(GCMRegistrationIntentService.REGISTRATION_ERROR));
    }


    //Unregistering receiver on activity paused
    @Override
    protected void onPause() {
        super.onPause();
        Log.w("MainActivity", "onPause");
        LocalBroadcastManager.getInstance(this).unregisterReceiver(mRegistrationBroadcastReceiver);
    }


    private boolean isRegistered() {
        //Getting shared preferences
        SharedPreferences sharedPreferences = getSharedPreferences(Constants.SHARED_PREF, MODE_PRIVATE);

        //Getting the value from shared preferences
        //The second parameter is the default value
        //if there is no value in sharedprference then it will return false
        //that means the device is not registered
        return sharedPreferences.getBoolean(Constants.REGISTERED, false);
    }

    private void GenerateUniqieDeviceID(){
        //Checking play service is available or not
        int resultCode = GooglePlayServicesUtil.isGooglePlayServicesAvailable(getApplicationContext());

        //if play service is not available
        if(ConnectionResult.SUCCESS != resultCode) {
            //If play service is supported but not installed
            if(GooglePlayServicesUtil.isUserRecoverableError(resultCode)) {
                //Displaying message that play service is not installed
                Toast.makeText(getApplicationContext(), "Google Play Service is not install/enabled in this device!", Toast.LENGTH_LONG).show();
                GooglePlayServicesUtil.showErrorNotification(resultCode, getApplicationContext());

                //If play service is not supported
                //Displaying an error message
            } else {
                Toast.makeText(getApplicationContext(), "This device does not support for Google Play Service!", Toast.LENGTH_LONG).show();
            }

            //If play service is available
        } else {
            //Starting intent to register device
            Intent intentExtras = new Intent(this, GCMRegistrationIntentService.class);

            startService(intentExtras);
        }
    }


    //Register Device with the server
    private String RegisterDeviceAtServer(String urlSuffix){

        class RegisterUser extends AsyncTask<String, Void, String> {

            ProgressDialog loading;


            @Override
            protected void onPreExecute() {
                super.onPreExecute();
                loading = ProgressDialog.show(MainActivity.this, "Registering Device. Please Wait...",null, true, true);
            }

            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);
                WriteRegistration(s);

                serverRegResponse = s;
                Log.w("Registration", " Returned Value is " + s);

                loading.dismiss();
                Toast.makeText(getApplicationContext(),s,Toast.LENGTH_LONG).show();

            }

            @Override
            protected String doInBackground(String... params) {
                String s = params[0];
                BufferedReader bufferedReader = null;
                try {
                    Log.w("RegisterWithServer", "This Prepares the URL" + s);
                    URL url = new URL(Constants.REGISTER_URL + "?funcName=RegisterDevice&params="+ s);// URLEncoder.encode(s,"UTF-8"));
                    Log.w("RegisterWithServer", "This Before Execution of Http"+ url.toString());
                    HttpURLConnection con = (HttpURLConnection) url.openConnection();

                    Log.w("RegisterWithServer", "This After Execution of Http");
                    bufferedReader = new BufferedReader(new InputStreamReader(con.getInputStream()));

                    Log.w("RegisterWithServer", "This After Buffering");
                    String result;

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

        return serverRegResponse;
    }

    private void WriteRegistration(String status){
        //On Successful Registration with the Server, we write to a sharedPreference
        if(status.equals("1")){ //Meaning Successful registration
            Log.w("STATUS","Success : "+status );

            Toast.makeText(getApplicationContext(), "Successfully Registered!!!", Toast.LENGTH_LONG).show();


            //Opening shared preference
            SharedPreferences sharedPreferences = getSharedPreferences(Constants.SHARED_PREF, MODE_PRIVATE);

            //Opening the shared preferences editor to save values
            SharedPreferences.Editor editor = sharedPreferences.edit();

            //Storing the unique id
            editor.putString(Constants.UNIQUE_ID, generatedID);

            //Saving the boolean as true i.e. the device is registered
            editor.putBoolean(Constants.REGISTERED, true);

            //Applying the changes on sharedpreferences
            editor.apply();

            Log.w("ServerSuccess", "Check to see that here executes at success with server:");

            startActivity(new Intent("com.justintime.androidgcm.ANIMATIONCLASS"));
        }else if(status.equals("2")){ //Invalid card Details
            Log.w("STATUS","Invalid : "+status );
            Toast.makeText(getApplicationContext(), "Invalid card Details. Try Again!!!", Toast.LENGTH_LONG).show();

        }else if(status.equals("3")){ //Incomplete Registration. Try Again!!!
            Log.w("STATUS","Incomplete : "+status );
            Toast.makeText(getApplicationContext(), "Incomplete Registration. Try Again!!!", Toast.LENGTH_LONG).show();
        }else if(status.equals("4")){ //Incomplete Registration. Try Again!!!
            Log.w("STATUS","Already : "+status );
            Toast.makeText(getApplicationContext(), "Already Registered!!!", Toast.LENGTH_LONG).show();
        }else{
            Log.w("STATUS","Nothing : "+status );
        }
    }

    //Menu Options
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {

        //Check if this is the first time user is login in, or that the device has not being registered
        //Getting shared preferences
        SharedPreferences sharedPreferences = getSharedPreferences(Constants.SHARED_PREF, MODE_PRIVATE);

        String deviceID = sharedPreferences.getString(Constants.UNIQUE_ID,"").toString();
        if(deviceID.equals("")) {

            return  true;

        }else{

            //Device is not registered. So User Register Card details to allow to successfully navigate the application

            // the essence of this here is to ensure that when user has not registered his device, menu items should not be displayed.

            // Inflate the menu; this adds items to the action bar if it is present.
            getMenuInflater().inflate(R.menu.main_menu, menu);//Menu Resource, Menu
            return true;
        }
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.approvedmerchants:
                Toast.makeText(getApplicationContext(), "Approved Merchants Selected", Toast.LENGTH_LONG).show();
                startActivity(new Intent("com.justintime.androidgcm.DISPLAYLIST"));
               // startActivity(intent);
                return true;
            case R.id.paidtransactions:
                Toast.makeText(getApplicationContext(), "Paid Transactions", Toast.LENGTH_LONG).show();
                startActivity(new Intent("com.justintime.androidgcm.PAIDTRANSACTIONS"));
                return true;
            case R.id.pendingtransactions:
                Toast.makeText(getApplicationContext(), "Pending Transactions", Toast.LENGTH_LONG).show();
                startActivity(new Intent("com.justintime.androidgcm.PENDINGTRANSACTIONS"));
                return true;

            case R.id.registercard:
                Toast.makeText(getApplicationContext(), "Card Registration Requested", Toast.LENGTH_LONG).show();
                startActivity(new Intent("com.justintime.androidgcm.MAINACTIVITY"));
                return true;

            case R.id.logout:
                Constants.loggedIn = false;
                Toast.makeText(getApplicationContext(), "Login Interface Starting...", Toast.LENGTH_LONG).show();
                Intent i = getBaseContext().getPackageManager()
                        .getLaunchIntentForPackage(getBaseContext().getPackageName() );

                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK );
                startActivity(i);
                return true;

            default:
                return super.onOptionsItemSelected(item);
        }
    }
}