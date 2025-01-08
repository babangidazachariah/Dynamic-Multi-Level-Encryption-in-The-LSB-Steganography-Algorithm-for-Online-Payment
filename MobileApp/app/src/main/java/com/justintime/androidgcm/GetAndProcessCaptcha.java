package com.justintime.androidgcm;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;

public class GetAndProcessCaptcha extends AppCompatActivity {//implements OnTouchListener{

    ProgressDialog progressDialog;
  //  CustomListViewAdapter listViewAdapter;

    Bitmap shaOne = null;
    Bitmap shaTwo = null;
    ImageView imgCombinedShare;
    Bitmap combinedImage = null;
    Button btnSumit;
    Button btnCancel;

            public static  String URL = "http://104.199.190.90/cimb.com.my/merchants/TransactionCaptchas/";
    public static  String URL1 = "http://146.148.55.110/lazada.com.my/cimb/TransactionCaptchas/";

    Boolean checkShare = true;

    EditText editTextCaptchaCode, editTextOtp, editTextEncrypted, editTextDecrypted;

    String serverOtpek = "";
    String stegoOtpek = "";
    String ids = "";
    String encrypted ="";
    String decrypted =""; //NOTE: otp is same as decrypted but for purpose of illustration as in the interface.
    String otp="";
    String captcha ="";

    String transactionID= "";

    int trials = 0;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.captchadisplay);


        //Validate that user has successfully loggedIn, otherwise refer back to Login Class.
        if(!Constants.loggedIn){

            Toast.makeText(getApplicationContext(), "Login Interface Starting...", Toast.LENGTH_LONG).show();
            Intent i = getBaseContext().getPackageManager()
                    .getLaunchIntentForPackage(getBaseContext().getPackageName() );

            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK );
            startActivity(i);
        }


        //captcha = (ImageView) findViewById(R.id.thumbnail);



         imgCombinedShare = (ImageView) findViewById(R.id.combinedShare);
        //imgShaOne = (ImageView) findViewById(R.id.shaone);
        // imgShaTwo = (ImageView) findViewById(R.id.shatwo);
        editTextCaptchaCode = (EditText) findViewById(R.id.editTextCaptchaCode);
        editTextOtp = (EditText) findViewById(R.id.editTextOtp);
        editTextEncrypted = (EditText) findViewById(R.id.editTextEncrypted);
        editTextDecrypted = (EditText) findViewById(R.id.editTextDecrypted);
        //set OnTouchListener
        //imgShaOne.setOnTouchListener(this);
        //imgShaTwo.setOnTouchListener(this);

        btnSumit = (Button)findViewById(R.id.buttonSubmit);
        btnCancel = (Button) findViewById(R.id.buttonCancel);

        progressDialog = new ProgressDialog(this);
        progressDialog.setTitle("In progress...");
        progressDialog.setMessage("Loading...");
        progressDialog.setProgressStyle(ProgressDialog.STYLE_HORIZONTAL);
        progressDialog.setIndeterminate(false);
        progressDialog.setMax(100);
        //progressDialog.setIcon(R.drawable.bits);
        progressDialog.setCancelable(true);
        progressDialog.show();



        //Get ID of the transaction payment is to be made

        Bundle extras = getIntent().getExtras();

        if(extras != null){

            transactionID = extras.getString("id");
            //Log.w("DISPLAYPENDING", "ID Received Transaction" + transactionID);
        }

        //Get TransactionIDs for the Shares URL formating.
        if(CheckNetClass.checknetwork(getApplicationContext())) { //Check Network

            GetIDsAndOtpek getIDsAndOtpek = new GetIDsAndOtpek(this);
            getIDsAndOtpek.execute(new String[]{transactionID});

            String shareOneUrl = "";
            String shareTwoUrl = "";
            while(checkShare) {

                if (ids != "" && serverOtpek != "") {
                    checkShare = false;
                    shareOneUrl = URL +"trans"+ids+"ShareOne.png";
                    shareTwoUrl =  URL1 + "trans"+ids+"ShareTwo.png";
                }
            }


            /*Creating and executing background task*/
            GetShareOneTask shareOneTask = new GetShareOneTask(this);
            GetShareTwoTask shareTwoTask = new GetShareTwoTask(this);
            shareOneTask.execute(new String[] { shareOneUrl, shareTwoUrl });

            shareTwoTask.execute(new String[] {shareTwoUrl,shareOneUrl});





            //Test Image Processing Here!!!
            checkShare =true;
            while(checkShare){

                if(shaOne != null && shaTwo != null){
                    checkShare = false;
                    Log.w("CheckIngSHares","Checking Shares for Processing!!!"+ Integer.toString(shaOne.getWidth())+Integer.toString(shaTwo.getWidth()));

                    Toast.makeText(getApplicationContext(), "Bank Server and Merchant Server Shares of Stego Captcha Have Now Been Received. Wait For Further Processing ", Toast.LENGTH_LONG).show();
                    //allBits = GetBits(shaOne,shaTwo);
                    ProcessImage allProcessBits = new ProcessImage(this);
                   allProcessBits.execute(new Bitmap[] {shaOne,shaTwo});



                   // Log.w("CheckIngSHares","After the the execution of Processing!!!");
                }

            }
        }else{

            Toast.makeText(getApplicationContext(), "No Network Connectivity. Check Your Data and Try Again!!!", Toast.LENGTH_LONG).show();
        }

        btnCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent("com.justintime.androidgcm.PENDINGTRANSACTIONS"));
            }
        });

        btnSumit.setOnClickListener(new View.OnClickListener(){
            //When User Clicks Submit button after typing Captcha
            @Override
            public  void onClick(View v){

                if(CheckNetClass.checknetwork(getApplicationContext())){
                    captcha = editTextCaptchaCode.getText().toString();
                    //if captcha is empty, display dialig box prompt warning

                    //Concatenate the captcha and otpek
                    String combinedOtpek = captcha + stegoOtpek+ serverOtpek;


                    Log.w("FINALLY", "Captcha Response:  " + captcha);
                    Log.w("FINALLY", "StegoOtpek Response:  " + stegoOtpek);
                    Log.w("FINALLY", "ServerOtpek Response:  " + serverOtpek);
                    Log.w("FINALLY", "Combined Otpek :  " + combinedOtpek);

                    //combinedOtpek is the Decryption key. Thus Initialise the MCrypt Class Object with it



                    //http://www.androidsnippets.com/encrypt-decrypt-between-android-and-php.html#
                    MCrypt mcrypt = new MCrypt(combinedOtpek);

                    Log.w("FINALLY", "Encrypted First Otpek :  " + encrypted);
                     /* Encrypt */
                    //String encrypted = MCrypt.bytesToHex( mcrypt.encrypt("Text to Encrypt") );

                    /* Decrypt */
                    String decrypted ="";
                    try{
                        decrypted = new String(mcrypt.decrypt(encrypted));
                        Log.w("FINALLY", "Encrypted Final Otpek :  " + encrypted);
                    }catch (Exception e){

                        e.printStackTrace();
                    }

                    Log.w("DECRYPTED: ", decrypted);

                    //Call Payment Approval Method Here!!
                    ApprovePayment("?funcName=MakePayment&registeredDevice=12345&requestType=void&id="+ transactionID +"&otp="+decrypted);


                    editTextEncrypted.setText(encrypted);

                    //Decrypted text is same for editTextDecrypted and editTextOtp
                    editTextDecrypted.setText(combinedOtpek);//(decrypted);
                    editTextOtp.setText(decrypted);
                }else{

                    Toast.makeText(getApplicationContext(), "No Network Connectivity. Check Your Data and Try Again!!!", Toast.LENGTH_LONG).show();
                }

            }


        });

    }


    private class GetIDsAndOtpek extends AsyncTask<String, Integer, String>{
        /*
        This function calls the  GetIDAndOtp function of the getTransaction.php web interface
         */
        private Activity context;
        public GetIDsAndOtpek(Activity context){this.context = context;}

        @Override
        protected String doInBackground(String... id){

            String idsAndOtpek = GetFromServer(id[0]);

            return idsAndOtpek;
        }

        @Override
        protected void onPostExecute(String received) {
            super.onPostExecute(received);

            Log.w("OnPostExecute", "Received Response: " + received);
            String outPut[] = received.split("#");
            Log.w("OnPostExecute", "Received Response:  " + received);
            ids = outPut[0];
            Log.w("IDSOTPEK", "IDS: " + received);
            serverOtpek = outPut[1];
            Log.w("IDSOTPEK", "OTEK" + ids);
        }


        private String GetFromServer(String transID){
            String urlLink = "http://104.199.190.90/cimb.com.my/merchants/getTransactions.php?funcName=GetIDSAndOtp&registeredDevice=12345&requestType=ids&id=" + transID;

            BufferedReader bufferedReader = null;
            try {
                Log.w("GetIDsOtpek", "This Prepares the URL" + urlLink);
                java.net.URL url = new URL(urlLink);// URLEncoder.encode(s,"UTF-8"));
                Log.w("GetViewList", "This Before Execution of Http: "+ url.toString());
                HttpURLConnection con = (HttpURLConnection) url.openConnection();

                Log.w("GetViewList", "This After Execution of HttpUrlConnection:  ");
                bufferedReader = new BufferedReader(new InputStreamReader(con.getInputStream()));

                Log.w("GetViewList", "This After Buffering");

                String result = "";

                result = bufferedReader.readLine();

                Log.w("RegisterWithServer", "Reading result from buffer");
                Log.w("GetViewList", "GetFromServer : " + result);


                String outPut[] = result.split("#");
                Log.w("OnPostExecute", "Received Response:  " + result);
                ids = outPut[0];
                Log.w("IDSOTPEK", "IDS: " + ids);
                serverOtpek = outPut[1];
                Log.w("IDSOTPEK", "OTEK" + serverOtpek);


                return result;
            }catch(Exception e) {
                Log.w("GetIDsOtpek", "Errors : " + e.getMessage());

                Toast.makeText(getApplicationContext(), "Error Processing Transactions", Toast.LENGTH_LONG).show();
                startActivity(new Intent("com.justintime.androidgcm.PENDINGTRANSACTIONS"));

                return null;
            }
        }



    }
    private class GetShareOneTask extends AsyncTask<String, Integer,Bitmap> {
        private Activity context;

        int noOfURLs;

        public GetShareOneTask(Activity context) {
            this.context = context;
        }

        @Override
        protected Bitmap doInBackground(String... urls) {
            noOfURLs = urls.length;

           // Bitmap combineCaptcha = null;

            shaOne = downloadImage(urls[0]);
           // shaTwo = downloadImage(urls[1]);


            return shaOne;
        }

        private Bitmap downloadImage(String urlString) {

            int count = 0;
            Bitmap bitmap = null;

            URL url;
            InputStream inputStream = null;
            BufferedOutputStream outputStream = null;

            try {
                url = new URL(urlString);
                URLConnection connection = url.openConnection();
                int lenghtOfFile = connection.getContentLength();

                inputStream = new BufferedInputStream(url.openStream());
                ByteArrayOutputStream dataStream = new ByteArrayOutputStream();

                outputStream = new BufferedOutputStream(dataStream);

                byte data[] = new byte[512];
                long total = 0;

                while ((count = inputStream.read(data)) != -1) {
                    total += count;
                    /*publishing progress update on UI thread.
                    Invokes onProgressUpdate()*/
                    publishProgress((int) ((total * 100) / lenghtOfFile));

                    // writing data to byte array stream
                    outputStream.write(data, 0, count);
                }
                outputStream.flush();

                BitmapFactory.Options bmOptions = new BitmapFactory.Options();
                bmOptions.inSampleSize = 1;

                byte[] bytes = dataStream.toByteArray();
                bitmap = BitmapFactory.decodeByteArray(bytes, 0, bytes.length, bmOptions);

            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {

                e.printStackTrace();
                Toast.makeText(getApplicationContext(), "Error Processing Transactions", Toast.LENGTH_LONG).show();
                startActivity(new Intent("com.justintime.androidgcm.PENDINGTRANSACTIONS"));


            } finally {
                close(inputStream);
                close(outputStream);
            }
            return bitmap;
        }


        protected void onProgressUpdate(Integer... progress) {
            progressDialog.setProgress(progress[0]);
            // if(rowItems != null) {
            progressDialog.setMessage("Processing Transaction!!!");
            // }
        }

        @Override
        protected void onPostExecute(Bitmap received) {
            //listViewAdapter = new CustomListViewAdapter(context, rowItems);
            //listView.setAdapter(listViewAdapter);

            // ImageView imgShaTwo = (ImageView) findViewById(R.id.shatwo);

            Log.w("Display", "Display ShareTwo");
          //  imgShaOne.setImageBitmap(Bitmap.createScaledBitmap(shaOne, (int) shaOne.getWidth() * 5, (int) shaOne.getHeight() * 5, true));
            // imgShaTwo.setImageBitmap(shaTwo);
           // progressDialog.dismiss();

            Toast.makeText(getApplicationContext(), "Bank Server Share of Stego Captcha Has Now Been Received ", Toast.LENGTH_LONG).show();
        }


    }
    private class GetShareTwoTask extends AsyncTask<String, Integer,Bitmap> {
        private Activity context;

        int noOfURLs;
        public GetShareTwoTask(Activity context) {
            this.context = context;
        }


        @Override
        protected Bitmap doInBackground(String... urls) {
            noOfURLs = urls.length;

            //Bitmap combineCaptcha = null;


            shaTwo = downloadImage(urls[0]);



            return shaTwo;
        }

        private Bitmap downloadImage(String urlString) {

            int count = 0;
            Bitmap bitmap = null;

            URL url;
            InputStream inputStream = null;
            BufferedOutputStream outputStream = null;

            try {
                url = new URL(urlString);
                URLConnection connection = url.openConnection();
                int lenghtOfFile = connection.getContentLength();

                inputStream = new BufferedInputStream(url.openStream());
                ByteArrayOutputStream dataStream = new ByteArrayOutputStream();

                outputStream = new BufferedOutputStream(dataStream);

                byte data[] = new byte[512];
                long total = 0;

                while ((count = inputStream.read(data)) != -1) {
                    total += count;
                    /*publishing progress update on UI thread.
                    Invokes onProgressUpdate()*/
                    publishProgress((int)((total*100)/lenghtOfFile));

                    // writing data to byte array stream
                    outputStream.write(data, 0, count);
                }
                outputStream.flush();

                BitmapFactory.Options bmOptions = new BitmapFactory.Options();
                bmOptions.inSampleSize = 1;

                byte[] bytes = dataStream.toByteArray();
                bitmap = BitmapFactory.decodeByteArray(bytes, 0, bytes.length,bmOptions);

            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
                //Incase of file Missing Errors
                Toast.makeText(getApplicationContext(), "Error Processing Transactions", Toast.LENGTH_LONG).show();
                startActivity(new Intent("com.justintime.androidgcm.PENDINGTRANSACTIONS"));

            } finally {
                close(inputStream);
                close(outputStream);
            }
            return bitmap;
        }



        @Override
        protected void onPostExecute(Bitmap received) {
            //listViewAdapter = new CustomListViewAdapter(context, rowItems);
            //listView.setAdapter(listViewAdapter);
            //ImageView imgShaOne = (ImageView) findViewById(R.id.shaone);

            Log.w("Display", "Display ShareTwo");
          //  imgShaTwo.setImageBitmap(Bitmap.createScaledBitmap(shaTwo, (int) shaTwo.getWidth() * 5, (int) shaTwo.getHeight() * 5, true));
           // imgShaTwo.setImageBitmap(shaTwo);
           // progressDialog.dismiss();
            Toast.makeText(getApplicationContext(), "Merchant Server Share of Stego Captcha Has Now Been Received ", Toast.LENGTH_LONG).show();
        }

    }





    public  void close(InputStream stream) {
        if(stream != null) {
            try {
                stream.close();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    public  void close(OutputStream stream) {
        if(stream != null) {
            try {
                stream.close();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }



   private String getBit(int n, int k) {
       /*

       return kth bit in n Using Bitwise Operation.
        */
        int bit = (n >> k) & 1;
        return Integer.toString(bit);
    }



    private class ProcessImage extends AsyncTask<Bitmap, Integer,String> {
        private Activity context;

        String  allBits ="", runningBits = "";
        public ProcessImage(Activity context) {
            this.context = context;
        }

        ProgressDialog loading;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            //loading = ProgressDialog.show(GetAndProcessCaptcha.this, "Request being Processed. Please Wait...",null, true, true);
        }

        @Override
        protected String doInBackground(Bitmap... params) {


            String embeddedInfo = "";
            Bitmap theOne = params[0];
            Bitmap theTwo =params[1];


            StegoAlgorithm stegoAlgorithm = new StegoAlgorithm();
            combinedImage = stegoAlgorithm.CombineShares(theOne,theTwo);
            //combinedImage = theOne; //Test for one first.
            embeddedInfo = stegoAlgorithm.BitsToText(stegoAlgorithm.ReadBits( combinedImage, (8 * stegoAlgorithm.ReadLengthBits(combinedImage))));

            return embeddedInfo;
        }

        //


        @Override
        protected void onPostExecute(String received) {

            super.onPostExecute(received);

            //Set the combinedImage Captcha to the imageview for display combinedShare
            imgCombinedShare.setImageBitmap(Bitmap.createScaledBitmap(combinedImage, (int) combinedImage.getWidth() * 10, (int) combinedImage.getHeight() * 10, true));

            Log.w("WritingBits", "Here is Writing the retrieved content");
            encrypted = received.substring(0,32);
            stegoOtpek = received.substring(32);
            //editTextCaptchaCode.setText(received);
           progressDialog.dismiss();
           // loading.dismiss();

        }

    }






    public void ApprovePayment(String url) {
         class PaymentApproval extends AsyncTask<String, Integer, String> {
            private Activity context;

            String allBits = "", runningBits = "";

            public PaymentApproval(Activity context) {
                this.context = context;
            }

            ProgressDialog loading;

            @Override
            protected void onPreExecute() {
                super.onPreExecute();
                loading = ProgressDialog.show(GetAndProcessCaptcha.this, "Request being Processed. Please Wait...", null, true, true);
            }

            @Override
            protected String doInBackground(String... params) {

                String s = params[0];
                BufferedReader bufferedReader = null;
                try {
                    Log.w("GetViewList", "This Prepares the URL" + s);
                    java.net.URL url = new URL(s);// URLEncoder.encode(s,"UTF-8"));
                    Log.w("GetViewList", "This Before Execution of Http" + url.toString());
                    HttpURLConnection con = (HttpURLConnection) url.openConnection();

                    Log.w("GetViewList", "This After Execution of Http");
                    bufferedReader = new BufferedReader(new InputStreamReader(con.getInputStream()));

                    Log.w("GetViewList", "This After Buffering");

                    String result = "";

                    result = bufferedReader.readLine();

                    Log.w("RegisterWithServer", "Reading result from buffer");
                    return result;
                } catch (Exception e) {
                    return null;
                }

            }

            //


            @Override
            protected void onPostExecute(String s) {

                super.onPostExecute(s);

                loading.dismiss();

                Log.w("PAYMENTRESPONSE", "Response is: "+ s);
                if (s.equals("1")) {

                    //Successful Login
                    Toast.makeText(getApplicationContext(), "Successful Payment!!!", Toast.LENGTH_LONG).show();

                    //Display Pending Transactions
                    startActivity(new Intent("com.justintime.androidgcm.PENDINGTRANSACTIONS"));

                }else if (s.equals("2")) {

                    Toast.makeText(getApplicationContext(), "Invalid Payment Details. Try Again!!!", Toast.LENGTH_LONG).show();

                } else if (s.equals("3")) {

                    Toast.makeText(getApplicationContext(), "Insufficient Account Balance. Deposit and Try Again!!!", Toast.LENGTH_LONG).show();

                } else if (s.equals("4")) {

                    Toast.makeText(getApplicationContext(), "Invalid Customer Account Details. Try Again!!!", Toast.LENGTH_LONG).show();

                } else if (s.equals("5")) {

                    Toast.makeText(getApplicationContext(), "Invalid Merchant Account Details. Try Again!!!", Toast.LENGTH_LONG).show();

                } else {
                    Toast.makeText(getApplicationContext(), "No Response from Server. Try Again!!!", Toast.LENGTH_LONG).show();
                    startActivity(new Intent("com.justintime.androidgcm.PENDINGTRANSACTIONS"));
                }
            }

        }
        String urlLink = "http://104.199.190.90/cimb.com.my/merchants/getTransactions.php"+ url;
        PaymentApproval paymentApproval = new PaymentApproval(this);
        paymentApproval.execute(urlLink);
    }



    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main_menu, menu);//Menu Resource, Menu
        return true;
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
                Constants.loggedIn =false;
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
