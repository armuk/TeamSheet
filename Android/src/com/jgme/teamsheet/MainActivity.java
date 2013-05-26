package com.jgme.teamsheet;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.Date;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class MainActivity extends Activity implements OnClickListener {

	Button clockinButton, oneButton, twoButton,
			threeButton, fourButton, fiveButton, sixButton, sevenButton,
			eightButton, nineButton, zeroButton, cancelButton, enterButton;
	EditText staffIDEditText, pinEditText;
	TextView greetingTextView;
	String staffID, pinNumber, uuid, greeting;
	JSONArray loginDetails, accountDetails;
	JSONObject staffObject, accountObject;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		Bundle getIdentifier = getIntent().getExtras();
		uuid = getIdentifier.getString("Identifier");
		Log.d("uuid", uuid);
		Thread myThread = null;
	    Runnable runnable = new CountDownRunner();
	    myThread= new Thread(runnable);   
	    myThread.start();
		GetAccountDetails getAccountDetails = new GetAccountDetails();
		getAccountDetails.execute();
		staffIDEditText = (EditText) findViewById(R.id.staffIDEditText);
		greetingTextView = (TextView) findViewById(R.id.greetingTextView);
		oneButton = (Button) findViewById(R.id.oneButton);
		oneButton.setOnClickListener(this);
		twoButton = (Button) findViewById(R.id.twoButton);
		twoButton.setOnClickListener(this);
		threeButton = (Button) findViewById(R.id.threeButton);
		threeButton.setOnClickListener(this);
		fourButton = (Button) findViewById(R.id.fourButton);
		fourButton.setOnClickListener(this);
		fiveButton = (Button) findViewById(R.id.fiveButton);
		fiveButton.setOnClickListener(this);
		sixButton = (Button) findViewById(R.id.sixButton);
		sixButton.setOnClickListener(this);
		sevenButton = (Button) findViewById(R.id.sevenButton);
		sevenButton.setOnClickListener(this);
		eightButton = (Button) findViewById(R.id.eightButton);
		eightButton.setOnClickListener(this);
		nineButton = (Button) findViewById(R.id.nineButton);
		nineButton.setOnClickListener(this);
		zeroButton = (Button) findViewById(R.id.zeroButton);
		zeroButton.setOnClickListener(this);
		cancelButton = (Button) findViewById(R.id.cancelButton);
		cancelButton.setOnClickListener(this);
		enterButton = (Button) findViewById(R.id.enterButton);
		enterButton.setOnClickListener(this);
	}
	
	public void doWork() {
	    runOnUiThread(new Runnable() {
	        public void run() {
	            try{
	                TextView txtCurrentTime= (TextView)findViewById(R.id.dateTimeTextView);
	                    Date dt = new Date();
	                    int hours = dt.getHours();
	                    int minutes = dt.getMinutes();
	                    int seconds = dt.getSeconds();
	                    String curTime = hours + ":" + minutes + ":" + seconds;
	                    txtCurrentTime.setText(curTime);
	            }catch (Exception e) {}
	        }
	    });
	}


	class CountDownRunner implements Runnable{
	    // @Override
	    public void run() {
	            while(!Thread.currentThread().isInterrupted()){
	                try {
	                doWork();
	                    Thread.sleep(1000);
	                } catch (InterruptedException e) {
	                        Thread.currentThread().interrupt();
	                }catch(Exception e){
	                }
	            }
	    }
	}
	
	@Override
	public void onClick(View v) {
		if (v == oneButton) {
			staffIDEditText.append("1");
		}
		if (v == twoButton) {
			staffIDEditText.append("2");
		}
		if (v == threeButton) {
			staffIDEditText.append("3");
		}
		if (v == fourButton) {
			staffIDEditText.append("4");
		}
		if (v == fiveButton) {
			staffIDEditText.append("5");
		}
		if (v == sixButton) {
			staffIDEditText.append("6");
		}
		if (v == sevenButton) {
			staffIDEditText.append("7");
		}
		if (v == eightButton) {
			staffIDEditText.append("8");
		}
		if (v == nineButton) {
			staffIDEditText.append("9");
		}
		if (v == zeroButton) {
			staffIDEditText.append("0");
		}
		if (v == cancelButton) {
			staffIDEditText.setText("");
			staffID = null;
			pinNumber = null;
			staffIDEditText.setHint(R.string.staffNumberHint);
		}
		if (v == enterButton) {
			if (staffID == null){
			staffID = staffIDEditText.getText().toString();
			staffIDEditText.setHint(R.string.pinNumberHint);
			staffIDEditText.setText("");
			}
			else {
				pinNumber = staffIDEditText.getText().toString();
				GetStaff getStaffDetails = new GetStaff();
				getStaffDetails.execute();
			}
		}
	}

	public class GetStaff extends AsyncTask<String, Long, Object> {

		@Override
		protected Object doInBackground(String... arg0) {
			try {
				Log.d("UUID", uuid);
				staffObject = new JSONObject();
				HttpGet httpget = new HttpGet(
						"https://clockinoutapp.appspot.com/_je/" + uuid
								+ "-team");
				HttpClient httpclient = new DefaultHttpClient();
				HttpResponse response = httpclient.execute(httpget);
				String str = inputStreamToString(
						response.getEntity().getContent()).toString();
				Log.d("Response", str);
				loginDetails = new JSONArray(str);
			} catch (Exception e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} 
			return null;
		}
		
		@Override
		protected void onPostExecute(Object result){
			try {
				for (int i = 0; i < loginDetails.length(); i++) {
					staffObject = loginDetails.getJSONObject(i);
					if (staffID.equals(staffObject.getString("UserID"))
							&& pinNumber.equals(staffObject.getString("PIN"))) {
						Intent loggedInIntent = new Intent(
								getApplicationContext(), LoggedInActivity.class);
						loggedInIntent.putExtra("Name",
								staffObject.getString("Name"));
						loggedInIntent.putExtra("uuid", uuid);
						startActivity(loggedInIntent);
					} else {
						Toast.makeText(getApplicationContext(), "Please try again", Toast.LENGTH_LONG).show();
					}
				}
			} catch (JSONException e) {

				e.printStackTrace();
			}
		}
	}

	public class GetAccountDetails extends AsyncTask<String, Long, Object> {

		@Override
		protected Object doInBackground(String... arg0) {
			try {
				Log.d("where", "in getaccountdetails");
				String url = ("https://clockinoutapp.appspot.com/_je/" + uuid + "-account");
				Log.d("URL", url.replace(" ", ""));
				HttpGet httpget = new HttpGet(url.replace(" ", ""));
				HttpClient httpclient = new DefaultHttpClient();
				HttpResponse response = httpclient.execute(httpget);
				String str = inputStreamToString(
						response.getEntity().getContent()).toString();
				Log.d("Response", str);
				accountDetails = new JSONArray(str);
				
			} catch (Exception e) {
				Toast.makeText(getApplicationContext(), "Error, please try again", Toast.LENGTH_LONG).show();
				e.printStackTrace();
			} 
			return null;
		}
		
		@Override
		protected void onPostExecute(Object result){
			try {
			accountObject = accountDetails.getJSONObject(0);
			greetingTextView.setText(accountObject.getString("Greeting"));
			}
			catch (Exception e){
				Toast.makeText(getApplicationContext(), "Error, please try again", Toast.LENGTH_LONG).show();
				e.printStackTrace();
			}
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
