package com.justintime.androidgcm;

import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.JsonArrayRequest;
import com.justintime.adapter.CustomListAdapter;
import com.justintime.app.AppController;
import com.justintime.model.Movie;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by DEBANGIS on 7/7/2016.
 */
public class PaidTransactions  extends AppCompatActivity {
    //Log Tag
    private static final String TAG = DisplayList.class.getSimpleName();

    // Movies json url
    private static String url = "http://104.199.190.90/cimb.com.my/merchants/getTransactions.php";//http://api.androidhive.info/json/movies.json";
    private ProgressDialog pDialog;
    private List<Movie> movieList = new ArrayList<Movie>();
    private ListView listView;
    private CustomListAdapter adapter;

    //Sub variables
    String supportUrl = "http://104.199.190.90/cimb.com.my/merchants/getTransactions.php";
    String[] viewListOrder = null;

    String pendingTransactionJson = "";
    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.displaylist);

        // changing action bar color
       // getSupportActionBar().setBackgroundDrawable(new ColorDrawable(Color.parseColor("#1b1b1b")));

        //Validate that user has successfully loggedIn, otherwise refer back to Login Class.
        if(!Constants.loggedIn){

            Toast.makeText(getApplicationContext(), "Login Interface Starting...", Toast.LENGTH_LONG).show();
            Intent i = getBaseContext().getPackageManager()
                    .getLaunchIntentForPackage(getBaseContext().getPackageName() );

            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK );
            startActivity(i);
        }


        listView = (ListView) findViewById(R.id.list);
        adapter = new CustomListAdapter(this, movieList);
        listView.setAdapter(adapter);

        pDialog = new ProgressDialog(this);
        // Showing progress dialog before making http request
        pDialog.setMessage("Loading...");
        pDialog.show();

        //Getting shared preferences
        SharedPreferences sharedPreferences = getSharedPreferences(Constants.SHARED_PREF, MODE_PRIVATE);

        String deviceID = sharedPreferences.getString(Constants.UNIQUE_ID,"De Bangis").toString();

        url += "?registeredDevice=" + deviceID +"&requestType=JSON&funcName=GetPaidTransactions";
        //url += "?request=JSON&agent=Pending";
        Log.w("JSONURL", url);
        supportUrl += "?registeredDevice=" + deviceID +"&requestType=IDList&funcName=GetPaidTransactions";
        Log.w("DEVID2", deviceID);

        if(CheckNetClass.checknetwork(getApplicationContext())){
            // Creating volley request obj
            JsonArrayRequest movieReq = new JsonArrayRequest(url,
                    new Response.Listener<JSONArray>() {
                        @Override
                        public void onResponse(JSONArray response) {
                            Log.d(TAG, response.toString());
                            hidePDialog();

                            // Parsing json
                            for (int i = 0; i < response.length(); i++) {
                                try {

                                    JSONObject obj = response.getJSONObject(i);
                                    Movie movie = new Movie();
                                    movie.setTitle(obj.getString("title"));
                                    movie.setThumbnailUrl(obj.getString("image"));
                                    movie.setRating(( obj.getString("rating")));
                                    movie.setYear(obj.getString("releaseYear"));

                                    // Genre is json array
                                    JSONArray genreArry = obj.getJSONArray("genre");
                                    ArrayList<String> genre = new ArrayList<String>();
                                    for (int j = 0; j < genreArry.length(); j++) {
                                        genre.add((String) genreArry.get(j));
                                    }
                                    movie.setGenre(genre);

                                    // adding movie to movies array
                                    movieList.add(movie);

                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }

                            }

                            // notifying list adapter about data changes
                            // so that it renders the list view with updated data
                            adapter.notifyDataSetChanged();


                            // Click event for single list row
                            listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

                                @Override
                                public void onItemClick(AdapterView<?> parent, View view,
                                                        int position, long id) {

                                    Toast.makeText(getApplicationContext(), "Item With TransactionID: " +viewListOrder[position], Toast.LENGTH_LONG).show();
                                    //String selectedOption = parent.getSelectedItem().toString();
                                    //Displaying the token as toast
                                    Intent pendingPurchasedItems = new Intent("com.justintime.androidgcm.DISPLAYPURCHASEDITEMS") ;
                                    Bundle extras = new Bundle();
                                    extras.putString("id",viewListOrder[position]);
                                    extras.putString("agent","Paid");
                                    pendingPurchasedItems.putExtras(extras);
                                    Log.w("Pending", "Starting Pending Transaction");
                                    startActivity(pendingPurchasedItems);

                                    Log.w("Pending", "Starting Pending Transaction");

                                }
                            });
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    VolleyLog.d(TAG, "Error: " + error.getMessage());
                    hidePDialog();

                }
            });

            // Adding request to request queue
            AppController.getInstance().addToRequestQueue(movieReq);

            //Get List of Merchants For reference when clicked by user
            GetviewTransactionIDOrder(supportUrl);
        }else{

            Toast.makeText(getApplicationContext(), "No Network Connectivity. Check Your Data and Try Again!!!", Toast.LENGTH_LONG).show();
        }
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        hidePDialog();
    }

    private void hidePDialog() {
        if (pDialog != null) {
            pDialog.dismiss();
            pDialog = null;
        }
    }

    private void GetPendingTransactions(String urlSuffix){

        String returnedJson = "";
        class RegisterUser extends AsyncTask<String, Void, String> {

            ProgressDialog loading;


            @Override
            protected void onPreExecute() {
                super.onPreExecute();
                loading = ProgressDialog.show(PaidTransactions.this, "Registering Device. Please Wait...",null, true, true);
            }

            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);
                loading.dismiss();
                pendingTransactionJson = s;
                Toast.makeText(getApplicationContext(),s,Toast.LENGTH_LONG).show();
            }

            @Override
            protected String doInBackground(String... params) {
                String s = params[0];
                BufferedReader bufferedReader = null;
                try {
                    Log.w("RegisterWithServer", "This Prepares the URL" + s);
                    URL url = new URL(Constants.REGISTER_URL + "?params="+ s);// URLEncoder.encode(s,"UTF-8"));
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


    }



    private void GetviewTransactionIDOrder(String urlSuffix){
        //String result = "";
        class GetViewList extends AsyncTask<String, Void, String> {

            ProgressDialog loading;

            @Override
            protected void onPreExecute() {
                super.onPreExecute();
                loading = ProgressDialog.show(PaidTransactions.this, "Retrieving Data. Please Wait...",null, true, true);
            }

            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);
                if(s!=null){
                    viewListOrder = s.split("#");
                }

                loading.dismiss();

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
                Constants.loggedIn= false;
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
