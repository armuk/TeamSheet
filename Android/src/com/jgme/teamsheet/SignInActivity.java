package com.jgme.teamsheet;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.nio.charset.Charset;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.HttpMultipartMode;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Typeface;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.method.PasswordTransformationMethod;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class SignInActivity extends Activity implements OnClickListener {
	Button loginButton, registerButton;
	EditText emailAddressEditText, passwordEditText;
	JSONObject object;
	String emailAddress, password, uuid, hashpass, loginDetails;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.signinlayout);
		loginButton = (Button) findViewById(R.id.loginButton);
		loginButton.setOnClickListener(this);
		registerButton = (Button) findViewById(R.id.registerButton);
		registerButton.setOnClickListener(this);
		emailAddressEditText = (EditText) findViewById(R.id.emailAddressEditText);
		passwordEditText = (EditText) findViewById(R.id.passwordEditText);
		passwordEditText.setTypeface(Typeface.DEFAULT);
		passwordEditText
				.setTransformationMethod(new PasswordTransformationMethod());
	}

	@Override
	public void onClick(View v) {
		if (v == loginButton) {
			GetLogin getLoginDetails = new GetLogin();
			getLoginDetails.execute();
			emailAddress = emailAddressEditText.getText().toString();
			password = passwordEditText.getText().toString();
			MessageDigest md;
			try {
				md = MessageDigest.getInstance("SHA-512");
				md.update(password.getBytes());
				byte byteData[] = md.digest();

				StringBuffer sb = new StringBuffer();
				for (int i = 0; i < byteData.length; i++) {
					sb.append(Integer
							.toString((byteData[i] & 0xff) + 0x100, 16)
							.substring(1));
				}
				hashpass = sb.toString();
				Log.d("Password", hashpass);
			} catch (NoSuchAlgorithmException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
		}
		if (v == registerButton){
			Uri signUp = Uri.parse("https://heyjimmy.net/signup/");
			Intent signUpIntent = new Intent(Intent.ACTION_VIEW, signUp);
			startActivity(signUpIntent);
		}
	}

	public class GetLogin extends AsyncTask<String, Long, Object> {

		@Override
		protected void onPreExecute(){
			loginButton.setEnabled(false);
			loginButton.setText("Logging in...");
		}
		
		@Override
		protected Object doInBackground(String... arg0) {
			try {
				object = new JSONObject();
				HttpPost httppost = new HttpPost(
						"http://heyjimmy.net/mobilesignin/index.php");
				HttpClient httpclient = new DefaultHttpClient();
				StringBody emailString = new StringBody(emailAddress);
				StringBody passwordString = new StringBody(hashpass);
				MultipartEntity reqEntity = new MultipartEntity(
						HttpMultipartMode.BROWSER_COMPATIBLE,null,Charset.forName("UTF-8"));
				reqEntity.addPart("email", emailString);
				reqEntity.addPart("password", passwordString);
			    httppost.setEntity(reqEntity);
			    //httppost.setHeader("Content-type", "application/x-www-form-urlencoded");
			    //httppost.setHeader("Accept", "application/x-www-form-urlencoded");
				HttpResponse response = httpclient.execute(httppost);
				String str = inputStreamToString(
						response.getEntity().getContent()).toString();
				loginDetails = new String(str);
				Log.d("str", str);
				Log.d("Response", loginDetails);
			} catch (UnsupportedEncodingException e) {
				e.printStackTrace();
			} catch (ClientProtocolException e) {
				e.printStackTrace();
			} catch (IllegalStateException e) {
				e.printStackTrace();
			} catch (IOException e) {
				Toast.makeText(getApplicationContext(),
						"Please ensure Wi-fi is turned on", Toast.LENGTH_LONG)
						.show();
				e.printStackTrace();
			}
			Thread myThread = null;
		    Runnable runnable = new CountDownRunner();
		    myThread= new Thread(runnable);   
		    myThread.start();
			return null;
		}
	}
	
	public void doWork() {
	    runOnUiThread(new Runnable() {
	        public void run() {
	            try{
	    			if (loginDetails.contains("Expired")) {
	    				Toast.makeText(getApplicationContext(), "Your subscription has expired, please re-subscribe", Toast.LENGTH_LONG).show();
	    				loginButton.setEnabled(true);
	    				loginButton.setText("Login");
	    			}
	    			else if (loginDetails.contains("Inactive")) {
	    				Toast.makeText(getApplicationContext(), "Your account is inactive, check your e-mails", Toast.LENGTH_LONG).show();
	    				loginButton.setEnabled(true);
	    				loginButton.setText("Login");
	    			}
	    			else if (loginDetails.length() == 36){
	    				loginButton.setEnabled(true);
	    				loginButton.setText("Login");
	    				Intent mainIntent = new Intent(getApplicationContext(),
	    					MainActivity.class);
	    			mainIntent.putExtra("Identifier", loginDetails);
	    			startActivity(mainIntent);
	    			}
	    			else if (loginDetails.length() == 0){
	    				Toast.makeText(getApplicationContext(), "Login details invalid", Toast.LENGTH_LONG).show();
	    				loginButton.setEnabled(true);
	    				loginButton.setText("Login");
	    			}
	            }catch (Exception e) {}
	        }
	    });
	}


	class CountDownRunner implements Runnable{
	    // @Override
	    public void run() {
	            doWork();
	            }
	    }
	
	private StringBuilder inputStreamToString(InputStream is) {
		String line = "";
		StringBuilder total = new StringBuilder();
		BufferedReader rd = new BufferedReader(new InputStreamReader(is));
		try {
			while ((line = rd.readLine()) != null) {
				total.append(line);
			}
		} catch (IOException e) {
			e.printStackTrace();
		}
		return total;
	}
}
