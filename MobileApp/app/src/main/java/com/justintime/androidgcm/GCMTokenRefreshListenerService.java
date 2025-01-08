package com.justintime.androidgcm;


import android.content.Intent;

import com.google.android.gms.iid.InstanceIDListenerService;


/**
 * Created by DEBANGIS on 6/8/2016.
 */
public class GCMTokenRefreshListenerService extends InstanceIDListenerService {

    //If the token is changed registering the device again
    @Override
    public void onTokenRefresh() {
        Intent intent = new Intent(this, GCMRegistrationIntentService.class);
        startService(intent);
    }
}