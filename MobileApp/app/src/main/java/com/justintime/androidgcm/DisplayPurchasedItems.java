package com.justintime.androidgcm;

import android.app.ProgressDialog;
import android.content.ActivityNotFoundException;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.support.v7.app.AppCompatActivity;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * Created by DEBANGIS on 7/8/2016.
 */
public class DisplayPurchasedItems extends AppCompatActivity {

         private ProgressDialog pDialog;
        String id= "";
        TableLayout tbLayout;

     Button btnPay, btnClose,btnReceipt;
        String agent = "";
    public static boolean receiptDownloaded = false;
    public static boolean  status = false;
    String destinationPath ="";
        private static String url = "http://104.199.190.90/cimb.com.my/merchants/webServicesClientFunctions.php";//http://api.androidhive.info/json/movies.json";
        @Override
        protected void onCreate(Bundle savedInstanceState) {


            super.onCreate(savedInstanceState);
            setContentView(R.layout.purchaseitemslayout);

            /*
                NOTE:
                    Customize this method to allow for both Paid and Pending Transactions to use this

                    create "pay" and "Receipt" buttons at run time.
             */


            //Validate that user has successfully loggedIn, otherwise refer back to Login Class.
            if(!Constants.loggedIn){

                Toast.makeText(getApplicationContext(), "Login Interface Starting...", Toast.LENGTH_LONG).show();
                Intent i = getBaseContext().getPackageManager()
                        .getLaunchIntentForPackage(getBaseContext().getPackageName() );

                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK );
                startActivity(i);
            }

            tbLayout = (TableLayout)findViewById(R.id.mainTable);


            final LinearLayout lm = (LinearLayout) findViewById(R.id.mainButtons);

            // create the layout params that will be used to define how your
            // button will be displayed
            LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.WRAP_CONTENT);

            //Get the agent requesting for display

            Bundle extras = getIntent().getExtras();

            if(extras != null){

                agent = extras.getString("agent");
                id =  extras.getString("id");
                Log.w("DISPLAYAGENT", "Agent Requesting Display: " + agent);
            }

            /*
            Bundle idExtras = getIntent().getExtras();

            if(idExtras != null){

                id = idExtras.getString("id");
                Log.w("DISPLAYPENDING", "ID Received Transaction");
            }
            */

            DisplayMetrics screenMetrics = new DisplayMetrics();
            getWindowManager().getDefaultDisplay().getMetrics(screenMetrics);
            int  heightPixels = screenMetrics.heightPixels;
            int widthPixels = screenMetrics.widthPixels;


            // Create LinearLayout
            LinearLayout ll = new LinearLayout(this);
            ll.setOrientation(LinearLayout.HORIZONTAL);

            btnClose = new Button(this);
            btnReceipt = new Button(this);
            btnPay = new Button(this);

            //Create Buttons accordingly
            if(agent.equals("Pending")){

                //Reset Title to Pending Transaction
                this.setTitle("Pending Transaction");

                btnPay.setText("Pay");

                btnPay.setTypeface(null,Typeface.BOLD);

                btnPay.setBackgroundResource(R.drawable.bordercolor);

                btnPay.setWidth((widthPixels / 2) - 2);

                ll.addView(btnPay);

                btnClose.setText("Close");

                btnClose.setTypeface(null,Typeface.BOLD);

                btnClose.setBackgroundResource(R.drawable.bordercolor);

                btnClose.setWidth((widthPixels / 2) - 2);

                ll.addView(btnClose);



            }else if(agent.equals("Paid")){

                //Reset Title to Paid Transaction
                this.setTitle("Paid Transaction");



                btnReceipt.setText("Receipt");

                btnReceipt.setTypeface(null,Typeface.BOLD);

                btnReceipt.setBackgroundResource(R.drawable.bordercolor);

                btnReceipt.setWidth((widthPixels / 2) - 2);

                ll.addView(btnReceipt);



                btnClose.setText("Close");

                btnClose.setTypeface(null,Typeface.BOLD);

                btnClose.setBackgroundResource(R.drawable.bordercolor);

                btnClose.setWidth((widthPixels / 2) - 2);
                //btnClose.setBackground(R.drawable.bordercolor);
                ll.addView(btnClose);


            }

            lm.addView(ll);


            /*
            try{
                if(btnPay.getText().toString().equals("Pay")) {
                    // set the layoutParams on the button
                    ViewGroup.LayoutParams paramsPayButton = btnPay.getLayoutParams();
                    paramsPayButton.width = (widthPixels / 2) - 5;
                    btnPay.setLayoutParams(params);
                    Log.w("btnPAY","HERE EXECutes");

                }
            }catch(Exception e){

            }
            try {
                if (btnReceipt.getText().toString().equals("Receipt")) {
                    // set the layoutParams on the button

                    ViewGroup.LayoutParams paramsReceiptButton = btnReceipt.getLayoutParams();
                    paramsReceiptButton.width = (widthPixels / 2) - 5;
                    btnReceipt.setLayoutParams(params);
                    Log.w("btnRECEIPT","HERE EXECutes");
                }
            }catch(Exception e){

            }

            ViewGroup.LayoutParams paramsCloseButton = btnClose.getLayoutParams();
            paramsCloseButton.width = (widthPixels/2) - 5;
            btnClose.setLayoutParams(paramsCloseButton);

             */
            pDialog = new ProgressDialog(this);
            // Showing progress dialog before making http request
           // pDialog.setMessage("Loading Data, Please Wait...");
           // pDialog.show();


            //Check for network connectivity
            if(CheckNetClass.checknetwork(getApplicationContext())) {

                Log.w("CallTo", "Call to function for list Transaction");
                GetviewTransactionIDOrder(url + "?funcName=RequestPurchasedItems&id=" + id);
            }else{

                Toast.makeText(getApplicationContext(), "No Network Connectivity. Check Your Data and Try Again!!!", Toast.LENGTH_LONG).show();
            }
            btnPay.setOnClickListener(new View.OnClickListener(){
                @Override
                public void onClick(View v){

                    if(CheckNetClass.checknetwork(getApplicationContext())){
                    //Send ID of the Transaction to be paid for to the GETANDPROCESSCAPTCHA for processing
                        Intent getAndProcessCaptcha = new Intent("com.justintime.androidgcm.GETANDPROCESSCAPTCHA") ;
                        Bundle extras = new Bundle();
                        extras.putString("id",id);
                        getAndProcessCaptcha.putExtras(extras);
                        Log.w("Pending", "Starting Pending Transaction");
                        startActivity(getAndProcessCaptcha);
                    }else{

                        Toast.makeText(getApplicationContext(), "No Network Connectivity. Check Your Data and Try Again!!!", Toast.LENGTH_LONG).show();
                    }
                }
            });

            btnClose.setOnClickListener(new View.OnClickListener(){
                @Override
                public void onClick(View v){

                    Intent turnBack;

                    if(agent.equals("Paid")){

                        turnBack = new Intent("com.justintime.androidgcm.PAIDTRANSACTIONS") ;
                        Log.w("DIPLAYPURCHASEDITEMS", "Close Button Clicked!!!");
                        startActivity(turnBack);


                    }else if (agent.equals("Pending")) {
                        turnBack = new Intent("com.justintime.androidgcm.PENDINGTRANSACTIONS");
                        Log.w("DIPLAYPURCHASEDITEMS", "Close Button Clicked!!!");
                        startActivity(turnBack);
                    }

                }
            });

            btnReceipt.setOnClickListener(new View.OnClickListener(){
                @Override
                public void onClick(View v){

                    if(CheckNetClass.checknetwork(getApplicationContext())){
                       // Intent getReceipt = new Intent("com.justintime.androidgcm.GETRECEIPT") ;
                        pDialog = ProgressDialog.show(DisplayPurchasedItems.this, "Retrieving Receipt. Please Wait...",null, true, true);
                        pDialog.show();
                        Log.w("GETRECEIPT", "btnReceipt Button Clicked!!!");
                        //startActivity(getReceipt);

                        String fileName = GetFileName();

                        new DownloadFile().execute("http://104.199.190.90/cimb.com.my/merchants/printReceipt.php?id=" + id, fileName);

                        //Some variable to plat with
                        int x = 2;
                        while (!status){
                            Log.w("GETRECEIPT", "Waiting for receipt to be Downloaded !!!");
                            if(x < 100) {
                                x++;
                            }else{
                                x =1;
                            }
                        }
                        if(receiptDownloaded) {
                            File pdfFile = new File(Environment.getExternalStorageDirectory() + "/OPAS/" + fileName);  // -> filename = maven.pdf
                            Uri path = Uri.fromFile(pdfFile);
                            Intent pdfIntent = new Intent(Intent.ACTION_VIEW);
                            pdfIntent.setDataAndType(path, "application/pdf");
                            pdfIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);

                            pDialog.dismiss();
                            try {
                                startActivity(pdfIntent);
                            } catch (ActivityNotFoundException e) {
                                Toast.makeText(DisplayPurchasedItems.this, "No Application available to view PDF", Toast.LENGTH_SHORT).show();
                            }
                        }else{
                            pDialog.dismiss();
                            Toast.makeText(DisplayPurchasedItems.this, "Application Error. Try Again!!!!", Toast.LENGTH_SHORT).show();
                        }
                    }else{

                        Toast.makeText(getApplicationContext(), "No Network Connectivity. Check Your Data and Try Again!!!", Toast.LENGTH_LONG).show();
                    }
                }
            });

        }

        public TableLayout CreatePurchasedItems(TableLayout tbLayout, String list){
            //Read the table definition in xml file



            //Create table row header to hold the column headings
            TableRow trHead = new TableRow(this);
            TableLayout.LayoutParams r = new TableLayout.LayoutParams(TableLayout.LayoutParams.MATCH_PARENT, TableLayout.LayoutParams.WRAP_CONTENT);//0, 10.0f);
            r.setMargins(2, 2, 2, 2);
            trHead.setBackgroundColor(Color.parseColor("#334d4d"));
            trHead.setLayoutParams(r);

            //Add Three data sections to the table row
            TextView itemHead = new TextView(this);
            itemHead.setTypeface(null,Typeface.BOLD);
            itemHead.setTextSize(25);
            itemHead.setText("ITEM NAME");
            itemHead.setTextColor(Color.WHITE);
            itemHead.setPadding(5, 5, 5, 5);
            trHead.addView(itemHead);

            TextView qtyHead = new TextView(this);
            qtyHead.setText("QTY");
            qtyHead.setTextSize(25);
            qtyHead.setTypeface(null,Typeface.BOLD);
            qtyHead.setTextColor(Color.WHITE);
            qtyHead.setPadding(5, 5, 5, 5);
            trHead.addView(qtyHead);

            TextView priceHead = new TextView(this);
            priceHead.setText("PRICE");
            priceHead.setTextSize(25);
            priceHead.setTypeface(null,Typeface.BOLD);
            priceHead.setTextColor(Color.WHITE);
            priceHead.setPadding(5, 5, 5, 5);
            trHead.addView(priceHead);

            //Add the Row to the table
            tbLayout.addView(trHead, new TableLayout.LayoutParams( TableLayout.LayoutParams.MATCH_PARENT, TableLayout.LayoutParams.WRAP_CONTENT));

            String itemList[] = list.split("##");
            String item[];
            int k = 0;
            String color;
            for(int i = 0; i < itemList.length; i++){
                item = itemList[i].split("@");

                if(k == 0){
                    color ="#94b8b8";
                    k ++;
                }else{

                    color ="#669999";
                    k = 0;
                }

                int j =0;
                while( j< item.length){

                    TableRow tRow = new TableRow(this);
                    tRow.setBackgroundColor(Color.parseColor(color));

                    tRow.setLayoutParams(r);

                    //Add Three data sections to the table row

                    if(j < item.length) {
                        //Item Column
                        TextView itemRow = new TextView(this);
                        itemRow.setText(item[j]);
                        itemRow.setTextSize(20);

                        j += 1;
                        itemRow.setTextColor(Color.WHITE);
                        itemRow.setPadding(2, 0, 5, 0);

                        if(j == (item.length -1)){

                            itemRow.setTypeface(null,Typeface.BOLD);
                        }
                        tRow.addView(itemRow);

                    }
                    if(j < item.length) {
                        //Quantity Column
                        TextView qtyRow = new TextView(this);
                        qtyRow.setText(item[j]);
                        qtyRow.setTextSize(20);
                        qtyRow.setGravity(Gravity.CENTER_HORIZONTAL);
                        j += 1;
                        qtyRow.setTextColor(Color.WHITE);
                        qtyRow.setPadding(2, 0, 5, 0);

                        if(j == (item.length -1)){

                            qtyRow.setTypeface(null,Typeface.BOLD);
                        }
                        tRow.addView(qtyRow);

                    }
                    if(j < item.length) {
                        //Price Column
                        TextView priceRow = new TextView(this);

                        priceRow.setText( "RM"+item[j].toString().trim());
                        priceRow.setTextSize(20);
                        priceRow.setGravity(Gravity.LEFT);
                        j += 1;
                        priceRow.setTextColor(Color.WHITE);
                        priceRow.setPadding(2, 0, 5, 0);

                        if(j == (item.length -1)){

                            priceRow.setTypeface(null,Typeface.BOLD);
                        }
                        tRow.addView(priceRow);

                    }
                    //Add the Row to the table
                    tbLayout.addView(tRow, new TableLayout.LayoutParams( TableLayout.LayoutParams.MATCH_PARENT, TableLayout.LayoutParams.WRAP_CONTENT));

                }
            }
            tbLayout.setColumnShrinkable(0,true);
            return tbLayout;
        }



        private void GetviewTransactionIDOrder(String urlSuffix){
            //String result = "";
            class GetViewList extends AsyncTask<String, Void, String> {

                ProgressDialog loading;

                @Override
                protected void onPreExecute() {
                    super.onPreExecute();
                    pDialog = ProgressDialog.show(DisplayPurchasedItems.this, "Retrieving Data. Please Wait...",null, true, true);
                    pDialog.show();
                }

                @Override
                protected void onPostExecute(String s) {
                    super.onPostExecute(s);
                    pDialog.dismiss();
                    if(s!=null){
                        tbLayout =CreatePurchasedItems(tbLayout,s);
                    }



                    Toast.makeText(getApplicationContext(),s, Toast.LENGTH_LONG).show();
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

            GetViewList ru = new GetViewList();
            ru.execute(urlSuffix);

            // return result;
        }

    private String GetFileName(){

        String path = "";
        String timeStamp = new SimpleDateFormat("ddMMyyyy_HHmm").format(new Date());

         path ="trans"+ id + timeStamp +".pdf";

        return path;
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


    private class DownloadFile extends AsyncTask<String, Void, Void>{

        @Override
        protected Void doInBackground(String... strings) {



            String fileUrl = strings[0];   // -> http://maven.apache.org/maven-1.x/maven.pdf
            String fileName = strings[1];  // -> maven.pdf
            String extStorageDirectory = Environment.getExternalStorageDirectory().toString();
            File folder = new File(extStorageDirectory, "OPAS");
            folder.mkdir();

            File pdfFile = new File(folder, fileName);

            try{
                pdfFile.createNewFile();
                //return "1";
            }catch (IOException e){
                e.printStackTrace();
               // return "";
            }
            FileDownloader.downloadFile(fileUrl, pdfFile);
            return null;
        }
    }


    //Menu Options
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
