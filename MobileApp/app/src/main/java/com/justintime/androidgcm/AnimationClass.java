package com.justintime.androidgcm;

import android.animation.ObjectAnimator;
import android.animation.ValueAnimator;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ImageView;
import android.widget.Toast;

/**
 * Created by DEBANGIS on 7/15/2016.
 */
public class AnimationClass extends AppCompatActivity {

    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.animationclass);

        //Validate that user has successfully loggedIn, otherwise refer back to Login Class.
        if(!Constants.loggedIn){

            Toast.makeText(getApplicationContext(), "Login Interface Starting...", Toast.LENGTH_LONG).show();
            Intent i = getBaseContext().getPackageManager()
                    .getLaunchIntentForPackage(getBaseContext().getPackageName() );

            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK );
            startActivity(i);
        }

        ImageView logo = (ImageView)findViewById(R.id.imageView);
        ObjectAnimator scaleAnim = ObjectAnimator.ofFloat(logo, "scaleX", 1.0f, 2.0f);
        scaleAnim.setDuration(3000);
        scaleAnim.setRepeatCount(ValueAnimator.INFINITE);
        scaleAnim.setRepeatMode(ValueAnimator.REVERSE);
        scaleAnim.start();

    }


    private void Animate(String urlSuffix){
        //String result = "";
        class Animate extends AsyncTask<String, Void, String> {

            ProgressDialog loading;

            @Override
            protected void onPreExecute() {
                super.onPreExecute();
               // loading = ProgressDialog.show(AnimationClass.this, "Retrieving Data. Please Wait...",null, true, true);
            }

            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);

               // loading.dismiss();

                if(s.equals("1")){

                }else {
                    Toast.makeText(getApplicationContext(),"Wrong Login Credentials", Toast.LENGTH_LONG).show();
                }
            }

            @Override
            protected String doInBackground(String... params) {
               try{

                }catch(Exception e){
                    return null;
                }
                return null;
            }
        }

        Animate ru = new Animate();
        ru.execute(urlSuffix);

        // return result;
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
