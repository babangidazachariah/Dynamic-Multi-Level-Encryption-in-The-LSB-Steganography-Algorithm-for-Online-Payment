package com.justintime.androidgcm;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.os.Environment;
import android.util.Log;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * Created by DEBANGIS on 6/27/2016.
 */
public class StegoAlgorithm {


    // global
    private  final int DATA_SIZE = 8;
    // number of image bytes required to store one stego byte


    // global
    private  final int MAX_INT_LEN = 1;
    private  final int MAX_DATA_SIZE =Integer.parseInt(toBinary( "", 1, MAX_INT_LEN *8), 2 );
    public  final String TAG = "STEGOALGORTHM";


    //Create a Constructor with which  the two shares of merchants and clients would be matched.
    public Bitmap CombineShares(Bitmap shareOne, Bitmap shareTwo){
        /*//This Constructor would be be used to combine the two Image Shares from Merchant and client
            urlShareOne is the client Image Captcha url.
            urlShareTwo is the merchant Image Captcha url.

        */
        //String embeddedInfo = "";
        //Bitmap shareOne = loadImage(urlShareOne);
       // Bitmap shareTwo = loadImage(urlShareTwo);


        Bitmap combinedShare;
        int oneWidth = shareOne.getWidth();
        int oneHeight = shareOne.getHeight();

        int twoWidth = shareTwo.getWidth();
        int twoHeight = shareTwo.getHeight();

        if((oneHeight != twoHeight) || (oneWidth != twoWidth)){

            return null;
        }else{

            //try combining images

            combinedShare =  Bitmap.createBitmap((oneWidth+ twoWidth),oneHeight, Bitmap.Config.ARGB_8888);
            int colorOne = 0;
            int colorTwo = 0;
            for(int y = 0; y < oneHeight; y++){

                for (int x = 0; x < oneWidth; x++){

                    colorOne = shareOne.getPixel(x,y);
                    colorTwo = shareTwo.getPixel(x,y);
                    /*

                        ......................................................
                        . 1,1 . 2,1 . 3,1 . 4,1 .    . 1,1 . 2,1 . 3,1 . 4,1 .
                        ......................................................
                        . 1,1 . 2,1 . 3,1 . 4,1 .    . 1,1 . 2,1 . 3,1 . 4,1 .
                        ......................................................

                        .................................................
                        . 1,1 . 2,1 . 3,1 . 4,1 . 5,1 . 6,1 . 7,1 . 8,1 .
                        .................................................
                        . 1,1 . 2,1 . 3,1 . 4,1 . 5,1 . 6,1 . 7,1 . 8,1 .
                        .................................................
                     */


                    combinedShare.setPixel(x,y,colorOne);

                    combinedShare.setPixel((x + oneWidth ), y, colorTwo);

                }
            }
            //embeddedInfo = BitsToText(ReadBits( combinedShare, 8 * ReadLengthBits(combinedShare)));
        }


        return combinedShare;
    }


    ///Write Another Constructor which would be accessed for embedding information into a .png image file that would
    //be retrived from SDCARD.

    public boolean StegoAlgorithm(Bitmap image, String data){


        return  WriteBits(image,data);
    }
    private Bitmap loadImage(String urlString) {
        //To change body of generated methods, choose Tools | Templates.

        Bitmap bitmap = null;

        URL url;
        InputStream inputStream = null;
        BufferedOutputStream outputStream = null;
        int count = 0;
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
        } finally {
            close(inputStream);
            close(outputStream);
        }
        return bitmap;


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


    private boolean writeImageToFile( Bitmap im) {
        //To change body of generated methods, choose1 Tools | Templates.
        boolean successFlag = false;
        try{
           StoreImage(im);//"C:\\auto_loan.png"
            successFlag = true;
        }catch(Exception e){
            e.printStackTrace();
        }
        return successFlag;
    }

    private void StoreImage(Bitmap image) {
        File pictureFile = getOutputMediaFile();
        if (pictureFile == null) {
            Log.d(TAG,
                    "Error creating media file, check storage permissions: ");// e.getMessage());
            return;
        }
        try {
            FileOutputStream fos = new FileOutputStream(pictureFile);
            image.compress(Bitmap.CompressFormat.PNG, 90, fos);
            fos.close();
        } catch (FileNotFoundException e) {
            Log.d(TAG, "File not found: " + e.getMessage());
        } catch (IOException e) {
            Log.d(TAG, "Error accessing file: " + e.getMessage());
        }
    }
    /** Create a File for saving an image or video */
    private  File getOutputMediaFile(){
        // To be safe, you should check that the SDCard is mounted
        // using Environment.getExternalStorageState() before doing this.
        File mediaStorageDir = new File(Environment.getExternalStorageDirectory()
                + "/MyPaymentProcessor");

        // This location works best if you want the created images to be shared
        // between applications and persist after your app has been uninstalled.

        // Create the storage directory if it does not exist
        if (! mediaStorageDir.exists()){
            if (! mediaStorageDir.mkdirs()){
                return null;
            }
        }
        // Create a media file name
        String timeStamp = new SimpleDateFormat("ddMMyyyy_HHmm").format(new Date());
        File mediaFile;
        String mImageName="MI_"+ timeStamp +".png";
        mediaFile = new File(mediaStorageDir.getPath() + File.separator + mImageName);
        return mediaFile;
    }

    public  int ReadLengthBits(Bitmap im){
        String bits = "";
        int bitLen = MAX_INT_LEN * 8;
        int w = im.getWidth();
        int h = im.getHeight();

        int color = 0;
        for(int y=0; y< h; y++){
            for(int x= 0; x < w; x++){
                color = im.getPixel(x, y);
                // bits += Integer.toString((c.getRed()) & 1) + Integer.toString((c.getGreen()) & 1) + Integer.toString((c.getBlue()) & 1);

                ///*
                Log.w("REDCOMP: " , toBinary("",Color.red(color),8));
                Log.w( "GREENCOMP: ", toBinary("",Color.green(color),8));
                Log.w("BLUECOMP: ", toBinary("",Color.blue(color),8)) ;
              //  */
                if(bits.length() <= bitLen){

                    //Red Component
                    StringBuilder colorBits = new StringBuilder(toBinary("",Color.red(color),8));

                    //  System.out.println(dataBits.charAt(i)+ " : "+colorBits.toString());

                    bits += colorBits.charAt(7);


                }else{
                    x = w;
                    y = h;
                    // setCol = false;
                }
                if(bits.length() <= bitLen){
                    //Green Component
                    StringBuilder colorBits = new StringBuilder(toBinary("",Color.green(color),8));

                    // System.out.println(dataBits.charAt(i)+ " : "+colorBits.toString());

                    bits += colorBits.charAt(7);


                }else{
                    x = w;
                    y = h;
                    // setCol = false;
                }
                if(bits.length() <= bitLen){
                    //Blue Component
                    StringBuilder colorBits = new StringBuilder(toBinary("",Color.blue(color),8));

                    // System.out.println(dataBits.charAt(i)+ " : "+colorBits.toString());

                    bits += colorBits.charAt(7);


                }else{
                    x = w;
                    y = h;
                    // setCol = false;
                }

            }
        }

        //System.out.println(bits);
        int len=Integer.parseInt(bits.substring(0, 8), 2);
        Log.w("MESSAGELENGTH",Integer.toString(len) +" : "+ bits);
        return Integer.parseInt(bits.substring(0, 8), 2);

    }
    public  String ReadBits(Bitmap im, int bitLen){
        String bits = "";
        int w = im.getWidth();
        int h = im.getHeight();
        bitLen += MAX_INT_LEN * 8; //to add the last character that would have been left due to message length definition.
        int color = 0;
        int k =0;
        for(int y=0; y< h; y++){
            for(int x= 0; x < w; x++){
                color = im.getPixel(x, y);
                // bits += Integer.toString((c.getRed()) & 1) + Integer.toString((c.getGreen()) & 1) + Integer.toString((c.getBlue()) & 1);
                /*
                Log.w("MREDCOMP: " , k +" :- "+ toBinary("",Color.red(color),8));
                Log.w( "MGREENCOMP: ",  k +" :- "+ toBinary("",Color.green(color),8));
                Log.w("MBLUECOMP: ",  k +" :- "+ toBinary("",Color.blue(color),8)) ;

                */
                k++;
                if(bits.length() <= bitLen){

                    //Red Component
                    StringBuilder colorBits = new StringBuilder(toBinary("",Color.red(color),8));

                    //  System.out.println(dataBits.charAt(i)+ " : "+colorBits.toString());

                    Log.w("MREDCOMP: " , k +" :- "+ toBinary("",Color.red(color),8)+"   => "+ colorBits.charAt(7));
                    bits += colorBits.charAt(7);


                }else{
                    x = w;
                    y = h;
                    // setCol = false;
                }
                if(bits.length() <= bitLen){
                    //Green Component
                    StringBuilder colorBits = new StringBuilder(toBinary("",Color.green(color),8));

                    // System.out.println(dataBits.charAt(i)+ " : "+colorBits.toString());

                    Log.w("MREDCOMP: " , k +" :- "+ toBinary("",Color.green(color),8)+"   => "+ colorBits.charAt(7));
                    bits += colorBits.charAt(7);


                }else{
                    x = w;
                    y = h;
                    // setCol = false;
                }
                if(bits.length() <= bitLen){
                    //Blue Component
                    StringBuilder colorBits = new StringBuilder(toBinary("",Color.blue(color),8));

                    // System.out.println(dataBits.charAt(i)+ " : "+colorBits.toString());

                    Log.w("MREDCOMP: " , k +" :- "+ toBinary("",Color.blue(color),8)+"   => "+ colorBits.charAt(7));
                    bits += colorBits.charAt(7);


                }else{
                    x = w;
                    y = h;
                    // setCol = false;
                }

            }
        }
        //remove the message length spec.
        bits = bits.substring(MAX_INT_LEN * 8);
        return bits;
    }

    public boolean WriteBits(Bitmap im, String data){
        if(data.length() < MAX_DATA_SIZE){//To ensure that one byte is enough to represent the lenth and such is
            //set at the begining of the pix before the message.
            String dataBits = toBinary(Integer.toString(data.length()), -1, 8) + toBinary(data, -1, 8);
            // System.out.println(dataBits + "  "+BitsToText(dataBits));

            int j = dataBits.length();
            int w = im.getWidth();
            int h = im.getHeight();
            int y = 0;
            int x = 0;
            int i = 0;
            int blueComp = 0;
            int redComp =0;
            int greenComp = 0;
            boolean setCol = false;

            int color = 0;
            while( y < h){
                while(x < w){
                     color = im.getPixel(x, y);

                    /*
                    System.out.println("R: " + toBinary("",c.getRed(),8));
                    System.out.println( "G: " + toBinary("",c.getGreen(),8));
                    System.out.println("B: " + toBinary("",c.getBlue(),8)) ;

                    */
                    // String colorBits = toBinary("",c.getRed(),8);
                    if(i < j){
                        //Red Component
                        StringBuilder colorBits = new StringBuilder(toBinary("",Color.red(color),8));

                        //  System.out.println(dataBits.charAt(i)+ " : "+colorBits.toString());

                        colorBits.setCharAt(7, dataBits.charAt(i));

                        //System.out.println("After: " + colorBits.toString());
                        // System.out.println(" ");


                        redComp = Integer.parseInt(colorBits.toString().trim(),2 );

                        // System.out.println("Integer: " + (redComp));

                        i++;
                        setCol = true;
                    }else{
                        x = w;
                        y = h;
                        setCol = false;
                    }
                    if(i < j){
                        //Green Component
                        StringBuilder colorBits = new StringBuilder(toBinary("", Color.green(color),8));

                        // System.out.println(dataBits.charAt(i)+ " : "+colorBits.toString());

                        colorBits.setCharAt(7, dataBits.charAt(i));

                        //System.out.println("After: " + colorBits.toString());
                        //System.out.println(" ");


                        greenComp = Integer.parseInt(colorBits.toString().trim(), 2);

                        //System.out.println("Integer: " + (greenComp));

                        i++;
                        setCol = true;
                    }else{
                        x = w;
                        y = h;
                        setCol = false;
                    }
                    if(i < j){
                        //Blue Component
                        StringBuilder colorBits = new StringBuilder(toBinary("",Color.blue(color),8));

                        // System.out.println(dataBits.charAt(i)+ " : "+colorBits.toString());

                        colorBits.setCharAt(7, dataBits.charAt(i));

                        //System.out.println("After: " + colorBits.toString());
                        // System.out.println(" ");

                        blueComp = Integer.parseInt(colorBits.toString().trim(), 2 );

                        // System.out.println("Integer: " + (blueComp));


                        i++;
                        setCol = true;
                    }else{
                        x = w;
                        y = h;
                        setCol = false;
                    }

                    if(setCol){
                       //Color c = new Color.argb(0xFF,redComp,greenComp,blueComp);
                        im.setPixel(x, y,Color.argb(0xFF,redComp,greenComp,blueComp));
                    }
                    x++;
                }
                y++;
            }

            return writeImageToFile(im);
        }else{

            return false;
        }
    }

    public  String toBinary(String str, int intValue, int bits) {

        String result = "";
        String tmpStr = "";
        int tmpInt = 0;
        if((str.length() > 0) && (intValue < 0)){

            char[] messChar = str.toCharArray();

            for (int i = 0; i < messChar.length; i++) {
                tmpStr = Integer.toBinaryString(messChar[i]);
                tmpInt = tmpStr.length();
                if(tmpInt != bits) {
                    tmpInt = bits - tmpInt;
                    if (tmpInt == bits) {
                        result += tmpStr;
                    } else if (tmpInt > 0) {
                        for (int j = 0; j < tmpInt; j++) {
                            result += "0";
                        }
                        result += tmpStr;
                    } else {
                        System.err.println("argument 'bits' is too small");
                    }
                } else {
                    result += tmpStr;
                }
                // result += " "; // separator
            }

            return result;
        }else{

            tmpStr = Integer.toBinaryString(intValue);
            tmpInt = tmpStr.length() ;
            if(tmpInt < bits){
                tmpInt = bits - tmpInt;
                for (int j = 0; j < tmpInt; j++) {
                    result += "0";
                }
                result += tmpStr;


            }else{

                result = tmpStr;
            }

        }
        // System.out.println(result);
        return result;

    }

    // 001101010011010100110101
    public String BitsToText(String bits){
        //System.out.println(":"+bits+":");
        String text = "";
        int j = bits.length();
        int i = 0;
        int k = 1;
        if(bits.length() >= (MAX_INT_LEN * 8)){
            while((i+8) <= j){
                int chrCode = Integer.parseInt(bits.substring(i, (i+8)), 2);

                char c  = (char) chrCode;
                Log.w("CHAR", k + " :- " + bits.substring(i, (i+8)) + " : "+Character.toString(c));
                k++;
                //System.out.println(":"+Character.toString(c)+":");
                text += Character.toString(c);
                i += 8;
            }
        }
        return text;
    }

}
