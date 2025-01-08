package com.justintime.androidgcm;

/**
 * Created by DEBANGIS on 6/10/2016.
 */
public class Constants {
    //Firebase app url
   // public static final String FIREBASE_APP = "https://simplifiedcoding.firebaseio.com/";

    //Constant to store shared preferences
    public static final String SHARED_PREF = "mynotificationapp";

    //To store boolean in shared preferences for if the device is registered to not
    public static final String REGISTERED = "registered";

    //To store the firebase id in shared preferences
    public static final String UNIQUE_ID = "uniqueid";

    //register.php address in your server
    protected static final String REGISTER_URL = "http://104.199.190.90/cimb.com.my/register.php";

    public static boolean loggedIn = false;
}
