package com.example.onclass._6_DanhBa_Menu_intent;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

public class C6_Main2_next_intent extends AppCompatActivity {
    private ImageView imageView;
    private TextView tvName, tvNumber;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_c6_next_activity_main);

        imageView = findViewById(R.id.imageView);
        tvName = findViewById(R.id.tvName);
        tvNumber = findViewById(R.id.tvNumber);

        Intent intent = getIntent();
        C6_DanhBa c6DanhBa = intent.getParcelableExtra("contact");

        imageView.setImageResource(R.mipmap.ic_contact_launcher);
        tvName.setText(c6DanhBa.getTxtName());
        tvNumber.setText(c6DanhBa.getTxtNumber());
    }
}
