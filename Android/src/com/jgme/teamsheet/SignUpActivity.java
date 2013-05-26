package com.jgme.teamsheet;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.provider.Settings;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class SignUpActivity extends Activity implements OnClickListener {
	EditText contactNameEditText, businessNameEditText, addressLineOneEditText,
			addressLineTwoEditText, postcodeEditText, emailAddressEditText,
			passwordEditText;
	Button registerButton;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.signuplayout);
		registerButton = (Button) findViewById(R.id.registerButton);
		registerButton.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		if (v == registerButton){
			Toast.makeText(getApplicationContext(), "Register works", Toast.LENGTH_LONG).show();
			String androidDeviceID = Settings.Secure.ANDROID_ID;
			Toast.makeText(getApplicationContext(), androidDeviceID, Toast.LENGTH_LONG).show();
			Intent createDatabase = new Intent(getApplicationContext(), MainActivity.class);
			startActivity(createDatabase);
		}
	}
	
}
