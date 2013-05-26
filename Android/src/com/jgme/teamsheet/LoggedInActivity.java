package com.jgme.teamsheet;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.HttpMultipartMode;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.hardware.Camera;
import android.hardware.Camera.PictureCallback;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.os.Looper;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.FrameLayout;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;
import android.widget.Toast;

public class LoggedInActivity extends Activity implements OnClickListener {
	boolean isok = false;
	Preview preview;
	Button savePhotoButton, clearMessagesButton;
	File photo;
	String name, uuid, imageFilename;
	Calendar cal;
	TextView staffNameTextView;
	ListView noticeboardListView;
	List<Map<String, String>> noticeList;
	JSONArray noticesArray;
	JSONObject noticesObject;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.loggedin);
		Bundle extra = getIntent().getExtras();
		name = extra.getString("Name");
		uuid = extra.getString("uuid");
		preview = new Preview(this);
		((FrameLayout) findViewById(R.id.preview)).addView(preview);
		savePhotoButton = (Button) findViewById(R.id.savePhotoButton);
		savePhotoButton.setOnClickListener(this);
		staffNameTextView = (TextView) findViewById(R.id.staffNameTextView);
		staffNameTextView.setText(name);
		noticeboardListView = (ListView) findViewById(R.id.noticeboardListView);
		noticeList = new ArrayList<Map<String, String>>();
		InitList initList = new InitList();
		initList.execute();
		SimpleAdapter simpleAdpt = new SimpleAdapter(this, noticeList,
				android.R.layout.simple_list_item_1, new String[] { "notice" },
				new int[] { android.R.id.text1 });
		noticeboardListView.setAdapter(simpleAdpt);
	}

	public class InitList extends AsyncTask<String, Long, Object> {

		@Override
		protected Object doInBackground(String... arg0) {
			try {
				HttpGet httpget = new HttpGet(
						"https://clockinoutapp.appspot.com/_je/" + uuid
								+ "-messages?sort=Date.asc");
				HttpClient httpclient = new DefaultHttpClient();
				HttpResponse response = httpclient.execute(httpget);
				String str = inputStreamToString(
						response.getEntity().getContent()).toString();
				Log.d("Response", str);
				noticesArray = new JSONArray(str);
			} catch (Exception e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			return null;
		}

		@Override
		protected void onPostExecute(Object result) {
			try {
				for (int i = 0; i < noticesArray.length(); i++) {
					noticesObject = noticesArray.getJSONObject(i);
					noticeList.add(createNotice("notice",
							noticesObject.getString("Message")));
				}
			} catch (JSONException e) {

				e.printStackTrace();
			}

		}
	}

	private HashMap<String, String> createNotice(String key, String name) {
		HashMap<String, String> notice = new HashMap<String, String>();
		notice.put(key, name);

		return notice;
	}

	PictureCallback jpegCallback = new PictureCallback() {
		@Override
		public void onPictureTaken(byte[] data, Camera camera) {
			new SavePhotoTask().execute(data);
			// preview.camera.startPreview();
		}
	};

	class SavePhotoTask extends AsyncTask<byte[], String, String> {
		@Override
		protected String doInBackground(byte[]... jpeg) {
			Looper.prepare();
			cal = Calendar.getInstance();
			imageFilename = name.replaceAll(" ", "") + +cal.getTime().getDate()
					+ cal.getTime().getMonth() + cal.getTime().getYear()
					+ cal.getTime().getHours() + cal.getTime().getMinutes()
					+ cal.getTime().getSeconds() + ".jpg";
			photo = new File(Environment.getExternalStorageDirectory(),
					imageFilename);

			if (photo.exists()) {
				photo.delete();
			}

			try {
				FileOutputStream fos = new FileOutputStream(photo.getPath());

				fos.write(jpeg[0]);
				fos.close();
			} catch (java.io.IOException e) {
				Log.e("PictureDemo", "Exception in photoCallback", e);
			}
			try {
				Log.d("Try", "Trying");
				HttpClient client = new DefaultHttpClient();
				String postURL = "http://heyjimmy.net/uploader/upload.processor.php";
				HttpPost post = new HttpPost(postURL);
				FileBody bin = new FileBody(photo, "multipart/form-data");
				MultipartEntity reqEntity = new MultipartEntity(
						HttpMultipartMode.BROWSER_COMPATIBLE);
				reqEntity.addPart("file", bin);
				post.setEntity(reqEntity);
				HttpResponse response = client.execute(post);
				HttpEntity resEntity = response.getEntity();
				Log.d("Try", "Gets this far");
				if (resEntity != null) {
					String responseString = EntityUtils.toString(resEntity);
					Log.i("RESPONSE", responseString);
					if (responseString.contains("Successful")) {
						HttpClient httpclient = new DefaultHttpClient();
						HttpPost httppost = new HttpPost(
								"http://clockinoutapp.appspot.com/_je/" + uuid
										+ "-times");
						ArrayList<BasicNameValuePair> localArrayList = new ArrayList<BasicNameValuePair>(
								1);
						cal = Calendar.getInstance();
						int second = cal.get(Calendar.SECOND);
						int minute = cal.get(Calendar.MINUTE);
						int hourofday = cal.get(Calendar.HOUR_OF_DAY);
						int year = cal.get(Calendar.YEAR);
						int month = cal.get(Calendar.MONTH) + 1;
						int dayofmonth = cal.get(Calendar.DAY_OF_MONTH);
						String datetime = String.format("%02d", dayofmonth)
								+ "/" + String.format("%02d", month) + "/"
								+ year + " at "
								+ String.format("%02d", hourofday) + ":"
								+ String.format("%02d", minute) + ":"
								+ String.format("%02d", second);
						localArrayList.add(new BasicNameValuePair("Signed-in",
								datetime));
						localArrayList
								.add(new BasicNameValuePair("Name", name));
						localArrayList.add(new BasicNameValuePair("Image",
								imageFilename));
						httppost.setEntity(new UrlEncodedFormEntity(
								localArrayList, "UTF-8"));
						httpclient.execute(httppost);
						Toast.makeText(getApplicationContext(),
								"Picture upload successful", Toast.LENGTH_LONG)
								.show();
					}
				} else {
					Log.d("resEntity", "resEntity empty");
				}
			} catch (ClientProtocolException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IllegalArgumentException e) {
				e.printStackTrace();
			} catch (RuntimeException e) {
				preview.camera.takePicture(null, null, jpegCallback);
			}

			return (null);
		}

		@Override
		protected void onPostExecute(String result) {
			Intent mainIntent = new Intent(getApplicationContext(),
					MainActivity.class);
			mainIntent.putExtra("Identifier", uuid);
			startActivity(mainIntent);
		}
	}

	@Override
	public void onClick(View arg0) {
		if (arg0 == savePhotoButton) {
			preview.camera.takePicture(null, null, jpegCallback);
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
